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
use Illuminate\Support\Facades\Cache;
use App\Notification;
use App\AffilateWallet;
use App\AffilateTransaction;
use App\coinPayments\CoinpaymentsAPI;
use App\SMS;

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
        $offer = CoinOffer::where("id", $request->offer_id)->first();
        if ($offer->type === "sell") {
            $payir = new PayirPG();
            $amount = $request->amount;
            if ($amount >= $offer->min_buy && $amount <= $offer->amount) {
                $price = ($offer->price_pre * $amount) / $offer->max_buy;

                $payir->amount = $price * 10;
                $payir->mobile = session()->get("user")->phone_number;
                session()->put("coin_wallet", true);
                session()->put("coin_offer", $offer);
                try {
                    $payir->send();
                    Cache::put(session()->get("user")->id . "_$payir->token" . "_coin$offer->id", $amount);
                    session()->put("coin_wallet", true);
                    session()->put("coin_offer", $offer);
                    return redirect($payir->paymentUrl);
                } catch (SendException $e) {
                    report($e);
                }
            }
        } elseif ($offer->type === "buy") {
            $amount = $request->amount;
            if ($offer->amount >= $amount) {
                $price = ($offer->price_pre * $amount) / $offer->max_buy;
                $price = $price + ($price * Option::getOption("admin_fee"));


                // Adding Buy fee to admin wallet
                $adminwallet = Wallet::where("type", "rial")->where("type_name", "admin")->first();
                $adminwallet->credit += ($price * Option::getOption("admin_fee"));
                $adminwallet->cashable += ($price * Option::getOption("admin_fee"));
                //////////////////////////
                /// Adding affilate fee to user wallet
                $user = session()->get("user");
                if ($user->affilate !== null) {
                    $refrall = ($price * Option::getOption("payment_fee"));
                    $rtransaction = new AffilateTransaction();
                    $rtransaction->from_user = session()->get("user")->id;
                    $rtransaction->user_id = session()->get("user")->affilate;
                    $rtransaction->amount = session()->get("user")->affilate;
                    $rtransaction->save();
                }

                /// adding money to seller rial wallet
                $userWallet = Wallet::where("user_id", $user->id)->where("type", "rial")->first();
                $userWallet->cashable += round($price);
                $userWallet->credit += round($price);


                $coinamount = $amount;
                //////////////////////////////////////////////////////
                $the_wallet = Wallet::where("user_id", $user->id)->where("name", $offer->coin)->first();
                if ($the_wallet->cashable >= $coinamount) {
                    $the_wallet->cashable -= $coinamount;
                    $the_wallet->credit -= $coinamount;
                } else {
                    return response()->json(array("result" => false, "msg" => "موجودی کیف‌پول شما کافی نیست!"));
                }

                $offer->amount -= $amount;
                if ($offer->amount <= 0) {
                    $offer->is_active = false;
                }
                $offer_wallet = Wallet::where("user_id", $offer->user_id)->where("name", $offer->coin)->first();
                $offer_wallet->cashable += $amount;
                $offer_wallet->credit += $amount;

                $rialofferWallet = Wallet::where("user_id", $offer->user_id)->where("type", "rial")->first();
                $rialofferWallet->credit -= round($price);

                if ($the_wallet->save() && $userWallet->save() && $offer_wallet->save() && $rialofferWallet->save() && $offer->save()) {
                    $transaction = new Transaction();
                    $transaction->user_id = $user->id;
                    $transaction->amount = $amount;
                    $transaction->coin = $offer->coin;
                    $transaction->type = "فروش ارز دیجیتال";
                    Notification::sendNotification("خرید ارز", "مقدار $amount از پیشنهاد $offer->id به شما فروخته شد و مبلغ آن از کیف پول شما کسر شد.", $offer->user_id, "/dashboard/mywallet");
                    if ($transaction->save()) {
                        return response()->json(array("result" => true, "msg" => "پرداخت با موفقیت انجام شد"));
                    }
                }
            } else {
                return response()->json(array("result" => false, "msg" => "درخواست غیر مجاز"));
            }
        }
    }

    public function offerPage(Request $request) {
        $offer = CoinOffer::find($request->offer);
        $fee = Option::getOption("payment_fee");
        if ($offer->type === "sell") {
            return view("dashboard.invoice", array("user" => session()->get("user"), "offer" => $offer, "fee" => $fee));
        } elseif ($offer->type === "buy") {
            return view("dashboard.sellcoin", array("user" => session()->get("user"), "offer" => $offer, "fee" => $fee));
        }
    }

    public function verify(Request $request) {
        $payir = new PayirPG();
        $payir->token = $request->token; // Pay.ir returns this token to your redirect url
        try {
            $verify = $payir->verify(); // returns verify result from pay.ir like (transId, cardNumber, ...)
            if ($request->status == 1) {
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
                            $transaction->coin = "تومان";
                            $transaction->type = "شارژ حساب";
                            $transaction->status = "موفق";
                            $transaction->trans_id = $verify['transId'];;
                            $transaction->save();

                            $rialWallet = Wallet::where("user_id", $user->id)->where("type", "rial")->first();
                            $rialWallet->credit += $verify['amount'];
                            $rialWallet->cashable += $verify['amount'];

                            $sms = new SMS($user->phone_number);
                            $sms->chargeWallet("تومان");

                            $rialWallet->save();
                        }
                    } else {
                        if (session()->pull("coin_wallet", false)) {
                            $offer = session()->get("coin_offer");
                            $transaction = new Transaction();
                            $transaction->user_id = $user->id;
                            $transaction->amount = $verify['amount'];
                            $transaction->coin = "تومان";
                            $transaction->type = "خرید ارز دیجیتال";
                            $transaction->status = "موفق";
                            $transaction->save();

                            $the_offer = CoinOffer::where("id", $offer->id)->first();
                            $amount = Cache::pull(session()->get("user")->id . "_$payir->token" . "_coin$offer->id");

                            $price = (($the_offer->price_pre * $amount) / $the_offer->max_buy);
                            $price = $price - ($price * Option::getOption("admin_fee"));

                            // Adding Buy fee to admin wallet
                            $adminwallet = Wallet::where("type", "rial")->where("type_name", "admin")->first();
                            $adminwallet->credit += ($price * Option::getOption("admin_fee"));
                            $adminwallet->cashable += ($price * Option::getOption("admin_fee"));

                            $the_offer->amount -= $amount;
                            $the_offer->save();

                            $the_wallet = Wallet::where("user_id", $the_offer->user_id)->where("name", $the_offer->coin)->first();
                            $the_wallet->credit -= $amount;
                            $the_wallet->save();

                            $user_wallet = Wallet::where("user_id", $user->id)->where("name", $the_offer->coin)->first();
                            $user_wallet->credit += $amount;
                            $user_wallet->cashable += $amount;
                            $user_wallet->save();

                            $rialWallet = Wallet::where("user_id", $the_offer->user_id)->where("type", "rial")->first();
                            $rialWallet->credit += $price;
                            $rialWallet->save();
                        }
                    }
                    return redirect("/dashboard/mywallet");
                } else {
                    return redirect("/dashboard/error");
                }
            } else {
                $transaction = new Transaction();
                $transaction->user_id = $user->id;
                $transaction->amount = $verify['amount'];
                $transaction->coin = "تومان";
                $transaction->type = "شارژ حساب";
                $transaction->status = "ناموفق";
                $transaction->save();

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
        $coinp = new CoinpaymentsAPI();
        $order = new Order();
        $order->user_id = session()->get("user")->id;
        $order->coin = $request->target;
        $order->amount = $request->amount;
        $order->save();
        $wallet = Wallet::where("type_name", $order->coin)->where("user_id", session()->get("user")->id)->first();
        $wallet->credit += $request->amount;
        $transaction = $coinp->CreateCustomTransaction(array("amount" => $request->amount, "buyer_email" => "soroosh081@gmail.com", "currency1" => $request->target, "currency2" => $request->target, "invoice" => "$order->id", "ipn_url" => url("/coinpayment/ipn")));
        return redirect($transaction['result']);
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
