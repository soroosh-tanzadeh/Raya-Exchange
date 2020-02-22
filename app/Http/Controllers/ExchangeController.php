<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exchange;
use Ixudra\Curl\Facades\Curl;
use App\Common;

class ExchangeController extends Controller {

    public function index(Request $request) {
        $coins = (array) Curl::to("https://api.simpleswap.io/get_all_currencies")->asJson()->get();
        $exchanges = Exchange::query()->where("user_id", session()->get("user")->id)->latest()->paginate(10);
        foreach ($exchanges as $exchange) {
            $exchange->status = Exchange::getExchangeStatus($exchange->exchange_id);
            $exchange->save();
        }
        return view("dashboard.market.exchange", array("user" => session()->get("user"), "exchanges" => $exchanges, "currencies" => ((array) $coins)));
    }
    
    public function getcoins(Request $request){
        $coins = (array) Curl::to("https://api.simpleswap.io/get_all_currencies")->asJson()->get();
        foreach ($coins as $coin){
            echo "<option value='$coin->symbol'>$coin->name</option>\n";
        }
    }

    public function exchangeRequest(Request $request) {
        $exchange = new Exchange();
        return response()->json($exchange->createNewExchange($request->from, $request->to, $request->wallet, $request->amount));
    }

    public function getEstimate(Request $request) {
        $result = Curl::to("https://api.simpleswap.io/get_estimated?currency_from=$request->from&currency_to=$request->to&amount=$request->amount")->asJson()->get();
        return response()->json(array("value" => $result));
    }

}
