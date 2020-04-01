<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CoinPaymentController extends Controller {
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
        $wallet->save();
        return view("payment", $transaction['result']);
    }

}
