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

}
