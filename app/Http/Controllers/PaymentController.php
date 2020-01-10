<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SaeedVaziry\Payir\Exceptions\SendException;
use SaeedVaziry\Payir\Exceptions\VerifyException;
use SaeedVaziry\Payir\PayirPG;
use App\Payment;
use App\Wallet;
use App\Transaction;
use App\CoinOffer;
use App\User;
use Ixudra\Curl\Facades\Curl;
use App\Currency;
use App\Option;
use App\JeebClient;
use App\Order;

class PaymentController extends Controller {

    public function pay(Request $request) {
        $payir = new PayirPG();
        $payir->amount = $request->amount * 10; // Required, Amount
        $payir->factorNumber = ''; // Optional
        $payir->mobile = session()->get("user")->phone_number; // Optional, If you want to show user's saved card numbers in gateway
        session()->put("rial_wallet", true);
        try {
            $payir->send();
            return redirect($payir->paymentUrl);
        } catch (SendException $e) {
            throw $e;
        }
    }

    public function buyCoin(Request $request) {
        $payir = new PayirPG();
        $offer = CoinOffer::where("id", $request->offer_id)->first();
        $requestURL = "https://api.coincap.io/v2/assets";
        $response = Curl::to($requestURL)
                ->withData(array('ids' => $offer->coin))
                ->get();
        $coin_price = json_decode($response)->data[0]->priceUsd;
        $usdprice = Currency::where("code", "USD")->first()->price;
        $amount = $coin_price * $usdprice;
        $payir->amount = $usdprice * 10; // Required, Amount
        $payir->mobile = session()->get("user")->phone_number; // Optional, If you want to show user's saved card numbers in gateway
        session()->put("coin_wallet", true);
        session()->put("coin_offer", $offer);
        try {
            $payir->send();
            return redirect($payir->paymentUrl);
        } catch (SendException $e) {
            throw $e;
        }
    }

    public function verify(Request $request) {
        $payir = new PayirPG();
        $payir->token = $request->token; // Pay.ir returns this token to your redirect url
        try {
            $verify = $payir->verify(); // returns verify result from pay.ir like (transId, cardNumber, ...)
            $payment = Payment::where("transId", $verify['transId'])->first();
            $user = session()->get("user");
            if ($payment === null) {
                $payment = new Payment();
                $payment->amount = $verify['amount'];
                $payment->user_id = $user->id;
                $payment->transId = $verify['transId'];
                $payment->save();

                if (session()->has("rial_wallet")) {
                    if (session()->pull("rial_wallet", false)) {
                        $transaction = new Transaction();
                        $transaction->user_id = $user->id;
                        $transaction->amount = $verify['amount'];
                        $transaction->coin = "ریال";
                        $transaction->type = "شارژ حساب";
                        $transaction->save();

                        $rialWallet = Wallet::where("user_id", $user->id)->where("type", "rial")->first();
                        $rialWallet->credit += $verify['amount'];
                        $rialWallet->save();
                    }
                } else {
                    if (session()->pull("coin_wallet", false)) {
                        $fee = Option::where("key", "sell_fee")->first()->value;

                        $offer = session()->get("coin_offer");
                        $transaction = new Transaction();
                        $transaction->user_id = $user->id;
                        $transaction->amount = $verify['amount'];
                        $transaction->coin = "ریال";
                        $transaction->type = "خرید ارز دیجیتال";
                        $transaction->save();

                        $the_offer = CoinOffer::where("id", $offer->id)->first();
                        $the_offer->is_selled = true;
                        $the_offer->save();
                        $the_wallet = Wallet::where("user_id", $the_offer->user_id)->where("name", $the_offer->coin)->first();
                        $the_wallet->credit -= $the_offer->amount + ($the_offer->amount * $fee);
                        $the_wallet->save();

                        $user_wallet = Wallet::where("user_id", $user->id)->where("name", $the_offer->coin)->first();
                        $user_wallet->credit += $the_offer->amount;
                        $user_wallet->cashable += $the_offer->amount;
                        $user_wallet->save();

                        $rialWallet = Wallet::where("user_id", $the_offer->user_id)->where("type", "rial")->first();
                        $rialWallet->credit += $verify['amount'];
                        $rialWallet->save();
                    }
                }
                return redirect("/dashboard/mywallet");
            } else {
                return redirect("/dashboard/error");
            }
        } catch (VerifyException $e) {
            throw $e;
        }
    }

    /*
     * 
     * Coin Payment
     * 
     */

    public function payCoin(Request $request) {
        $order = new Order();
        $order->user_id = session()->get("user")->id;
        $order->coin = $request->target;
        $order->save();
        $jeebClient = new JeebClient();
        $data = array();
        $order = $order->id;
        $data['orderNo'] = $order; // Order No  
        $data['value'] = $jeebClient->convert($request->amount, $request->target, 'btc'); // Value in BTC
        $data['callbackUrl'] = 'http://raya.webflaxco.ir/coincallback'; // Callback URL (this is just an example)
        $data['webhookUrl'] = 'http://raya.webflaxco.ir/coinwebhook'; // Webhook URL (this is just an example)
        $data['expiration'] = 15; // Expands default expiration time of payment. should be between 15 to 2880 (mins)
        $data['coins'] = $request->target; // Defines the payable currencies which users can use
        $data['language'] = 'auto'; // Payment area's language
        $data['allowReject'] = true; // Allows payments to be refunded
        //   $data['allowTestNet'] = true; // Allows testnets to get processed
        $result = $jeebClient->issue($data);
        $token = $result['token'];
        $order = Order::where("id", $order)->first();
        $order->token = $token;
        $order->save();
        return $jeebClient->redirectURL($token);
    }

    public function webhook(Request $request) {
        $jeebClient = new JeebClient();
        $ip = $request->ip();
        if ($ip === "35.209.237.202" || $ip === "52.56.239.177") {
            if ($request->stateId === 4) {
                $order = $request->orderNo;
                $amount = $request->paidValue;
                $token = $request->token;
                $order = Order::where("id", $order)->where("token", $token)->first();
                $order->amount = $amount;
                $order->save();
                $user = Wallet::where("user_id", $order->user_id)->where('type_name', strtoupper($order->coin))->first();
                $data = array();
                $data['token'] = $token;
                $jeebClient->confirm($data);
            }
        }
    }

    public function comfirm(Request $request) {
        return response()->json($request->all());
    }

}
