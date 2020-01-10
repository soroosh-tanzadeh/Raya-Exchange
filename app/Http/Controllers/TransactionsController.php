<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\Checkout;
use App\Transaction;

class TransactionsController extends Controller {

    public function crypto(Request $request) {
        $deposits = Order::query()->where("user_id", session()->get("user")->id)->get();
        $checkouts = Checkout::query()->join("wallets", "wallets.id", "=", "checkouts.wallet_id")->select(array("checkouts.*", "wallets.type_name as coin"))->where("checkouts.user_id", session()->get("user")->id)->get();
        ;

        return view("dashboard.transactions.crypto", array("user" => session()->get("user"), "deposits" => $deposits, "checkouts" => $checkouts));
    }

    public function rials(Request $request) {
        $deposits = Transaction::where("user_id", session()->get("user")->id)->where("type", "شارژ حساب")->get();
        $checkouts = Checkout::query()->join("bank_accounts", "bank_accounts.id", "=", "checkouts.bankaccount_id")->select(array("checkouts.*", "bank_accounts.IBAN", "bank_accounts.account_number", "bank_accounts.card_number"))->where("checkouts.user_id", session()->get("user")->id)->get();
        return view("dashboard.transactions.rial", array("user" => session()->get("user"), "deposits" => $deposits, "checkouts" => $checkouts));
    }

}
