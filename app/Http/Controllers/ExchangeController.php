<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exchange;
use Ixudra\Curl\Facades\Curl;

class ExchangeController extends Controller {

    public function index(Request $request) {
        $result = Curl::to("https://api.simpleswap.io/get_all_currencies")->asJson()->get();
        $exchanges = Exchange::query()->where("user_id", session()->get("user")->id)->latest()->paginate(10);
        return view("dashboard.market.exchange", array("user" => session()->get("user"), "exchanges" => $exchanges, "currencies" => ((array) $result)));
    }

    public function exchangeRequest(Request $request) {
        $exchange = new Exchange();
        return response()->json($exchange->createNewExchange($request->from, $request->to, $request->wallet, $request->amount));
    }

    public function getEstimate(Request $request) {
        $result = Curl::to("https://api.simpleswap.io/get_estimated?currency_from=$request->from&currency_to=$request->to&amount=$request->amount")->asJson()->get();
     //   echo "https://api.simpleswap.io/get_estimated?currency_from=$request->from&currency_to=$request->to&amount=$request->amount";
       return response()->json($result);
    }

}
