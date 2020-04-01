<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AffilateWallet;
use App\AffilateTransaction;
use App\AffilateCheckout;
use App\User;
use App\Option;
use App\Wallet;

class AffilateController extends Controller {

    public function index() {
        $wallet = AffilateWallet::where("user_id", session()->get("user")->id)->first();
        $transactions = AffilateTransaction::query()->where("user_id", session()->get("user")->id)->latest()->limit(10)->get();
        $checkouts = AffilateCheckout::where("user_id", session()->get("user")->id)->latest()->get();
        $users = count(User::where("affilate", session()->get("user")->id)->get());
        return view("dashboard.affilate", array("user" => session()->get("user"), "wallet" => $wallet, "transactions" => $transactions, "checkouts" => $checkouts, "users" => $users));
    }

    public function moveToWallet(Request $request) {
        $wallet = AffilateWallet::where("user_id", session()->get("user")->id)->first();
        $max = $wallet->cashable;
        $amount = $request->amount;
        $min = 15000;
        if ($amount <= $max && $amount >= $min) {
            $wallet->cashable -= $amount;
            $rialWallet = Wallet::where("type", "rial")->where("user_id", $user->id)->first();
            $result = $wallet->save() && $rialWallet->save();
            if ($result) {
                return response()->json(array("result" => true, "msg" => "با موفقیت انجام شد!"));
            } else {
                return response()->json(array("result" => false, "msg" => "خطا در ذخیره اطلاعات!"));
            }
        } else {
            return response()->json(array("result" => false, "msg" => "مقدار ورودی نمی‌تواند از میزان درآمد بیشتر، و یا از حداقل نرخ تبدیل کمتر باشد."));
        }
    }

    public function convert2btc(Request $request) {
        $wallet = AffilateWallet::where("user_id", session()->get("user")->id)->first();
        $user = session()->get("user");
        $min = Option::getOption("affilate_btc_rate");
        $max = $wallet->cashable;
        $amount = $request->amount;
        if ($amount <= $max && $amount >= $min) {
            $wallet->cashable -= $amount;
            $btcWallet = Wallet::where("type_name", "BTC")->where("user_id", $user->id)->first();
            if ($btcWallet !== null) {
                $checkout = new AffilateCheckout();
                $checkout->user_id = $user->id;
                $checkout->amount = $amount;
                $result = $wallet->save() && $checkout->save();
                if ($result) {
                    return response()->json(array("result" => true, "msg" => "با موفقیت انجام شد!"));
                } else {
                    return response()->json(array("result" => false, "msg" => "خطا در ذخیره اطلاعات!"));
                }
            }
        } else {
            return response()->json(array("result" => false, "msg" => "مقدار ورودی نمی‌تواند از میزان درآمد بیشتر، و یا از حداقل نرخ تبدیل کمتر باشد."));
        }
    }

}
