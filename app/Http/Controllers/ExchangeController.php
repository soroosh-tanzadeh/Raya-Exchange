<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exchange;
use Ixudra\Curl\Facades\Curl;
use App\Common;

class ExchangeController extends Controller {

    public function index(Request $request) {
        $currencyDATA = Curl::to("https://api.simpleswap.io/get_all_currencies")->asJson()->get();
        $currencies_all = array();
        foreach ($currencyDATA as $currency) {
            $currencies_all[$currency->symbol] = $currency;
        }

        $currenciesData = (array) Curl::to("https://api.simpleswap.io/fixed/get_all_pairs")->asJson()->get();
        $coins = array();
        foreach ($currenciesData as $key => $value) {
            $coins[] = $currencies_all[$key];
        }

        $exchanges = Exchange::query()->where("user_id", session()->get("user")->id)->latest()->paginate(10);
        foreach ($exchanges as $exchange) {
            if ((strtotime($exchange->created_at) + (60 * 20)) - (time()) < 0) {
                $exchange->status = -5;
            } else {
                $exchange->status = Exchange::getExchangeStatus($exchange->exchange_id);
            }
            $exchange->save();
        }

        $from = "btc";
        $amount = "1";
        $to = "eth";

        if ($request->has("from") && $request->has("amount") && $request->has("to")) {
            $from = $request->from;
            $amount = $request->amount;
            $to = $request->to;
        }
        return view("dashboard.market.exchange", array("user" => session()->get("user"), "exchanges" => $exchanges, "from" => $from, "to" => $to, "amount" => $amount, "currencies" => ((array) $coins)));
    }

    public function getAllCoins(Request $request) {
        if ($request->type === "floating") {
            $currencyDATA = Curl::to("https://api.simpleswap.io/get_all_currencies")->asJson()->get();
            $currencies_all = array();
            echo "<option value=''></option>";
            foreach ($currencyDATA as $currency) {
                echo "<option value='" . $currency->symbol . "' data-icon='https://simpleswap.io" . $currency->image . "'>" . $currency->name . "</option>\n";
            }
        } else {
            $currencyDATA = Curl::to("https://api.simpleswap.io/get_all_currencies")->asJson()->get();
            $currencies_all = array();
            foreach ($currencyDATA as $currency) {
                $currencies_all[$currency->symbol] = $currency;
            }

            $currenciesData = (array) Curl::to("https://api.simpleswap.io/fixed/get_all_pairs")->asJson()->get();
            $coins = array();
            echo "<option value=''></option>";
            foreach ($currenciesData as $key => $value) {
                echo "<option value='" . $currencies_all[$key]->symbol . "' data-icon='https://simpleswap.io" . $currencies_all[$key]->image . "'>" . $currencies_all[$key]->name . "</option>\n";
            }
        }
    }

    public function getPairs(Request $request) {
        $url = "https://api.simpleswap.io/fixed/get_pairs?symbol=$request->coin";
        if ($request->type === "floating") {
            $url = "https://api.simpleswap.io/get_pairs?symbol=$request->coin";
        }

        $currencyDATA = Curl::to("https://api.simpleswap.io/get_all_currencies")->asJson()->get();
        $currencies = array();
        foreach ($currencyDATA as $currency) {
            $currencies[$currency->symbol] = $currency;
        }

        $coins = (array) Curl::to($url)->asJson()->get();
        echo "<option value=''></option>";
        foreach ($coins as $coin) {
            if ($coin->symbol !== $request->coin) {
                echo "<option value='$coin->symbol' data-icon='https://simpleswap.io" . $currencies[$coin->symbol]->image . "'>$coin->name</option>\n";
            }
        }
    }

    public function exchangeRequest(Request $request) {
        $exchange = new Exchange();
        $msg = "آدرس کیف‌پول اشتباه است.";

        if ($request->type === "fixed") {
            $result = Curl::to("https://api.simpleswap.io/fixed/get_max?currency_from=$request->from&currency_to=$request->to")->asJson()->get();
            $maxamount = floatval($result);

            if (floatval($request->amount) > $maxamount) {
                return response()->json(array("result" => false, "msg" => $maxamount));
            }
        }

        return response()->json(array("result" => $exchange->createNewExchange($request->from, $request->to, $request->wallet, $request->amount, $request->type === "fixed"), "msg" => $msg));
    }

    public function getEstimate(Request $request) {
        if ($request->type === "fixed") {
            $result = Curl::to("https://api.simpleswap.io/fixed/get_max?currency_from=$request->from&currency_to=$request->to")->asJson()->get();
            $maxamount = doubleval($result);

            $minresult = Curl::to("https://api.simpleswap.io/fixed/get_min?currency_from=$request->from&currency_to=$request->to")->asJson()->get();
            $minamount = doubleval($minresult);
            if (doubleval($request->amount) < $minamount) {
                return response()->json(array("result" => false, "min" => true, "msg" => $minamount));
            }

            if (doubleval($request->amount) > $maxamount) {
                return response()->json(array("result" => false, "max" => true, "msg" => $maxamount));
            }
        } else {
            $minresult = Curl::to("https://api.simpleswap.io/get_min?currency_from=$request->from&currency_to=$request->to")->asJson()->get();
            $minamount = doubleval($minresult);
            if (doubleval($request->amount) < $minamount) {
                return response()->json(array("result" => false, "min" => true, "msg" => $minamount));
            }
        }

        $result = Curl::to("https://simpleswap.io/api/get_estimated?currency_from=$request->from&currency_to=$request->to&amount=$request->amount")->asJson()->get();
        return response()->json(array("value" => $result));
    }

}
