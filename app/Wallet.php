<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Ixudra\Curl\Facades\Curl;
use Illuminate\Support\Facades\Cache;

class Wallet extends Model {

    public static function getWallets() {
        $user = null;
        if (session()->has("user")){
            $user = session()->get("user");
        }else {
            $user = session()->get("user_admin");
        }
        $coinWallets_data = Wallet::where("user_id", $user->id)->get();
        $coinWallets = array();
        foreach ($coinWallets_data as $wallet) {
            $coinWallets[$wallet->type_name] = $wallet;
        }
        return $coinWallets;
    }

    public static function getCoins() {
        $response = Cache::remember('coin-assets', 10000, function () {
                    $requestURL = "https://api.coincap.io/v2/assets";
                    return Curl::to($requestURL)
                                    ->asJson()
                                    ->get();
                });
        $coins_raw = $response->data;
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
            $coin->price_in_toman_int = $priceInToman;
            $coins[$coin->symbol] = $coin;
        }
        return $coins;
    }

    public static function getCoin($coin) {
        $requestURL = "https://api.coincap.io/v2/assets";
        $response = Curl::to($requestURL)
                ->withData(array('ids' => $coin))
                ->asJson()
                ->get();
        $coins = $response->data;
        $output = array();
        $usdprice = Currency::where("code", "USD")->first()->price;
        foreach ($coins as $coin) {
            $priceInToman = (int) ($coin->priceUsd * $usdprice);
            if (($priceInToman >= 1000) & ($priceInToman < 1000000)) {
                $price = $priceInToman / 1000;
                $coin->price_in_toman = $price . "<br>" . "<div class='priceunit'>" . " هزار تومان" . "</div>";
            } elseif ($priceInToman >= 1000000 & ($priceInToman < 1000000000)) {
                $price = $priceInToman / 1000000;
                $coin->price_in_toman = $price . "<br>" . "<div class='priceunit'>" . " میلیون تومان" . "</div>";
            } elseif ($priceInToman >= 1000000000) {
                $price = $priceInToman / 1000000000;
                $coin->price_in_toman = $price . "<br>" . "<div class='priceunit'>" . " میلیارد تومان" . "</div>";
            } else {
                $price = $priceInToman;
                $coin->price_in_toman = $price . "<br>" . "<div class='priceunit'>" . " تومان" . "</div>";
            }
            $coin->price_in_toman_int = $priceInToman;
            $coin->priceUsd = number_format(round($coin->priceUsd, 5), 5);
        }
        return $coin;
    }

}
