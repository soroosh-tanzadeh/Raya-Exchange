<?php

namespace App;

use Ixudra\Curl\Facades\Curl;
use App\Common;
use Illuminate\Database\Eloquent\Model;

class Exchange extends Model {

    public $token;

    public function __construct() {
        $this->token = env("SIMPLE_SWAP_TOKEN", "test");
    }

    public function getCurrencies() {
        $result = Curl::to("https://api.simpleswap.io/v1/get_all_currencies?api_key=$this->token")->get();
        return json_decode($result);
    }

    public function createNewExchange($from, $to, $to_address, $amount, $fixed = true) {
        $parameters = array(
            "fixed" => $fixed,
            "currency_from" => $from,
            "currency_to" => $to,
            "address_to" => $to_address,
            "amount" => $amount
        );

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://api.simpleswap.io/v1/create_exchange?api_key=' . $this->token);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($parameters));

        $headers = array();
        $headers[] = 'Content-Type: application/json; charset=utf-8';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);
        $result = json_decode($result);
        $exchange = new Exchange();
        $exchange->amount = $amount;
        $exchange->from = $from;
        $exchange->to = $to;
        $exchange->to_address = $to_address;
        $exchange->user_id = session()->get("user")->id;
        $exchange->exchange_id = $result->id;
        $exchange->payment_address = $result->address_from;
        $exchange->save();

        return $result;
    }

    public static function getExchangeStatus($id) {
        $result = Curl::to("https://api.simpleswap.io/v1/get_exchange?api_key=" . env("SIMPLE_SWAP_TOKEN", "test") . "&id=$id")->asJson()->get();
        if ($result->status === "waiting") {
            return 0;
        } else {
            return 1;
        }
    }

    public static function getCoins() {
        $requestURL = "https://api.coincap.io/v2/assets";
        $response = Curl::to($requestURL)
                ->withData(array('ids' => "bitcoin,ethereum,litecoin,ripple,monero,eos,bitcoin-cash,neo,dogecoin,dash,etc,zec,ont,trx,bnb,bat,nem,xml,usdt,ada,miota"))
                ->get();
        $coins_raw = json_decode($response)->data;
        $coins = array();
        $usdprice = Currency::where("code", "USD")->first()->price;
        foreach ($coins_raw as $coin) {
            $priceInToman = (int) ($coin->priceUsd * $usdprice);
            if (($priceInToman >= 1000) & ($priceInToman < 1000000)) {
                $price = $priceInToman / 1000;
                $coin->price_in_toman = " هزار تومان" . $price;
            } elseif ($priceInToman >= 1000000 & ($priceInToman < 1000000000)) {
                $price = $priceInToman / 1000000;
                $coin->price_in_toman = " میلیون تومان " . $price;
            } elseif ($priceInToman >= 1000000000) {
                $price = $priceInToman / 1000000000;
                $coin->price_in_toman = " میلیارد تومان " . $price;
            } else {
                $price = $priceInToman;
                $coin->price_in_toman = " تومان " . $price;
            }
            $coin_icon = Common::getIconPath() . "/" . strtolower($coin->symbol) . ".png";
            if (Common::url_exists($coin_icon)) {
                $coin->icon = $coin_icon;
            } else {
                $coin->icon = Common::getLogoPath();
            }
            $coin->price_in_toman_int = $priceInToman;
            $coins[$coin->id] = $coin;
        }
        return $coins;
    }

}
