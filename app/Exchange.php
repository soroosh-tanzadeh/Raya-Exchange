<?php

namespace App;

use Ixudra\Curl\Facades\Curl;
use App\Common;

class Exchange {

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

        return json_decode($result);
    }

    public static function getCoins() {
        $requestURL = "https://api.coincap.io/v2/assets";
        $response = Curl::to($requestURL)
                ->withData(array('ids' => "bitcoin,ethereum,litecoin,ripple,monero,eos,bitcoin-cash,neo,dogecoin"))
                ->get();
        $coins_raw = json_decode($response)->data;
        $coins = array();
        $usdprice = Currency::where("code", "USD")->first()->price;
        foreach ($coins_raw as $coin) {
            $priceInToman = (int) ($coin->priceUsd * $usdprice);
            if (($priceInToman >= 1000) & ($priceInToman < 1000000)) {
                $price = $priceInToman / 1000;
                $coin->price_in_toman = $price . " هزار تومان";
            } elseif ($priceInToman >= 1000000 & ($priceInToman < 1000000000)) {
                $price = $priceInToman / 1000000;
                $coin->price_in_toman = $price . " میلیون تومان";
            } elseif ($priceInToman >= 1000000000) {
                $price = $priceInToman / 1000000000;
                $coin->price_in_toman = $price . " میلیارد تومان";
            } else {
                $price = $priceInToman;
                $coin->price_in_toman = $price . " تومان";
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
