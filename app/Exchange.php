<?php

namespace App;

use Ixudra\Curl\Facades\Curl;

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

}
