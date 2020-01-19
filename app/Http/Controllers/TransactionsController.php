<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\Checkout;
use App\Transaction;
use App\BankAccount;
use App\Wallet;
use App\Activity;

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

    public function addBankAccount(Request $request) {
        $account = new BankAccount();
        if ($this->checkIBAN($request->IBAN) && $this->checkCartDigit($request->card_number)) {
            if (BankAccount::where("IBAN", $request->IBAN)->Orwhere("card_number", $request->card_number)->first() !== null) {
                return response()->json(array("result" => false, "msg" => "این کارت بانکی / حساب قبلا افزوده شده"));
            }
            $account->IBAN = $request->IBAN;
            $account->account_number = $request->account_number;
            $account->card_number = $request->card_number;
            $account->user_id = session()->get("user")->id;
            $result = $account->save();
            if ($result) {
                Activity::addActivity("ثبت حساب‌بانکی");
                return response()->json(array("result" => $result, "msg" => "اطلاعات با موفقیت ثبت شد"));
            } else {
                return response()->json(array("result" => $result, "msg" => "خطا در ثبت اطلاعات"));
            }
        } else {
            $msg = "شماره شبا نامعتبر است";
            if (!$this->checkCartDigit($request->card_number)) {
                $msg = "شماره کارت نامعتبر است";
            }
            return response()->json(array("result" => false, "msg" => $msg));
        }
    }

    public function bankAccounts(Request $request) {
        $accounts = BankAccount::where("user_id", session()->get("user")->id)->paginate(10);
        return view("dashboard.wallet.bankaccounts", array("user" => session()->get("user"), "accounts" => $accounts));
    }

    public function checkouts(Request $request) {
        $user = session()->get("user");
        $bankaccounts = BankAccount::where("user_id", session()->get("user")->id)->get();
        $rialWallet = Wallet::where("user_id", $user->id)->where("type", "rial")->first();
        return view("dashboard.wallet.checkout", array("user" => session()->get("user"), "rialWallet" => $rialWallet, "bankaccounts" => $bankaccounts));
    }

    public function coinCheckouts(Request $request) {
        $coin = $request->target;
        $amount = $request->amount;
        $user_id = session()->get("user")->id;
        $wallet = Wallet::where("user_id", $user_id)->where("type_name", strtoupper($coin))->first();
        if ($wallet->cashable >= $amount) {
            $checkout = new Checkout();
            $checkout->wallet_id = $wallet->id;
            $checkout->user_id = $user_id;
            $checkout->token = $request->token;
            $checkout->amount = $amount;
            $checkout->is_payed = false;
            if ($checkout->save()) {
                $wallet->cashable -= $amount;
                Activity::addActivity("ثبت درخواست برداشت کوین");
                return response()->json(array("result" => $wallet->save(), "msg" => "درخواست با موفقیت ثبت شد."));
            } else {
                return response()->json(array("result" => false, "msg" => "خطا در ثبت اطلاعات!"));
            }
        } else {
            return response()->json(array("result" => false, "msg" => "موجودی کیف پول کافی نیست!"));
        }
    }

    public function rialCheckouts(Request $request) {
        $bankaccount_id = $request->bankaccount;
        $amount = $request->amount;
        $user_id = session()->get("user")->id;
        $wallet = Wallet::where("user_id", $user_id)->where("type", "rial")->first();
        if ($wallet->cashable >= $amount) {
            $checkout = new Checkout();
            $checkout->wallet_id = $wallet->id;
            $checkout->user_id = $user_id;
            $checkout->amount = $amount;
            $checkout->bankaccount_id = $bankaccount_id;
            $checkout->is_payed = false;
            if ($checkout->save()) {
                $wallet->cashable -= $amount;
                Activity::addActivity("ثبت درخواست برداشت ریال");
                return response()->json(array("result" => $wallet->save(), "msg" => "درخواست با موفقیت ثبت شد."));
            } else {
                return response()->json(array("result" => false, "msg" => "خطا در ثبت اطلاعات!"));
            }
        } else {
            return response()->json(array("result" => false, "msg" => "موجودی کیف پول کافی نیست!"));
        }
    }

    public function checkIBAN($iban) {
        $iban = strtolower(str_replace(' ', '', $iban));
        $Countries = array("ir" => 26, 'al' => 28, 'ad' => 24, 'at' => 20, 'az' => 28, 'bh' => 22, 'be' => 16, 'ba' => 20, 'br' => 29, 'bg' => 22, 'cr' => 21, 'hr' => 21, 'cy' => 28, 'cz' => 24, 'dk' => 18, 'do' => 28, 'ee' => 20, 'fo' => 18, 'fi' => 18, 'fr' => 27, 'ge' => 22, 'de' => 22, 'gi' => 23, 'gr' => 27, 'gl' => 18, 'gt' => 28, 'hu' => 28, 'is' => 26, 'ie' => 22, 'il' => 23, 'it' => 27, 'jo' => 30, 'kz' => 20, 'kw' => 30, 'lv' => 21, 'lb' => 28, 'li' => 21, 'lt' => 20, 'lu' => 20, 'mk' => 19, 'mt' => 31, 'mr' => 27, 'mu' => 30, 'mc' => 27, 'md' => 24, 'me' => 22, 'nl' => 18, 'no' => 15, 'pk' => 24, 'ps' => 29, 'pl' => 28, 'pt' => 25, 'qa' => 29, 'ro' => 24, 'sm' => 27, 'sa' => 24, 'rs' => 22, 'sk' => 24, 'si' => 19, 'es' => 24, 'se' => 24, 'ch' => 21, 'tn' => 24, 'tr' => 26, 'ae' => 23, 'gb' => 22, 'vg' => 24);
        $Chars = array('a' => 10, 'b' => 11, 'c' => 12, 'd' => 13, 'e' => 14, 'f' => 15, 'g' => 16, 'h' => 17, 'i' => 18, 'j' => 19, 'k' => 20, 'l' => 21, 'm' => 22, 'n' => 23, 'o' => 24, 'p' => 25, 'q' => 26, 'r' => 27, 's' => 28, 't' => 29, 'u' => 30, 'v' => 31, 'w' => 32, 'x' => 33, 'y' => 34, 'z' => 35);

        if (strlen($iban) == $Countries[substr($iban, 0, 2)]) {
            $MovedChar = substr($iban, 4) . substr($iban, 0, 4);
            $MovedCharArray = str_split($MovedChar);
            $NewString = "";

            foreach ($MovedCharArray AS $key => $value) {
                if (!is_numeric($MovedCharArray[$key])) {
                    $MovedCharArray[$key] = $Chars[$MovedCharArray[$key]];
                }
                $NewString .= $MovedCharArray[$key];
            }

            if (bcmod($NewString, '97') == 1) {
                return true;
            }
        }
        return false;
    }

    public function checkCartDigit($code) {
        $L = strlen($code);
        if ($L < 16 || intval(substr($L, 1, 10), 10) == 0 || intval(substr($code, 10, 6), 10) == 0)
            return false;
        $c = intval(substr($code, 15, 1), 10);
        $s = 0;
        $k = 0;
        $d = 0;
        for ($i = 0; $i < 16; $i++) {
            $k = ($i % 2 == 0) ? 2 : 1;
            $d = intval(substr($code, $i, 1), 10) * $k;
            $s += ($d > 9) ? $d - 9 : $d;
        }
        return (($s % 10) == 0);
    }

}
