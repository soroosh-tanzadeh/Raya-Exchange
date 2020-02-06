<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AffilateWallet;
use App\AffilateTransaction;
use App\AffilateCheckout;
use App\User;

class AffilateController extends Controller {

    public function index() {
        $wallet = AffilateWallet::where("user_id", session()->get("user")->id)->first();
        $transactions = AffilateTransaction::query()->where("user_id", session()->get("user")->id)->latest()->limit(10)->get();
        $checkouts = AffilateCheckout::where("user_id", session()->get("user")->id)->latest()->limit(10)->get();
        $users = count(User::where("affilate", session()->get("user")->id)->get());
        return view("dashboard.affilate", array("user" => session()->get("user"), "wallet" => $wallet, "transactions" => $transactions, "checkouts" => $checkouts, "users" => $users));
    }

}
