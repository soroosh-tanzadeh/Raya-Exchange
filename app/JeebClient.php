<?php

namespace App;

class JeebClient {

    private $signature;
    private $baseUrl;

    public function __construct() {
        $this->signature = env("JEEB_TOKEN");
        $this->baseUrl = "https://core.jeeb.io/";
    }
    
    public function redirectURL($token){
        return redirect($this->baseUrl . "api/payments/invoice?token=$token");
    }

    public function convert($amount, $baseCurrency, $targetCurrency) {
        $ch = curl_init($this->baseUrl . 'api/currency?&value=' . $amount . '&base=' . $baseCurrency . '&target=' . $targetCurrency);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json')
        );
        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            return curl_error($ch);
        }
        $data = json_decode($result, true);
        return (float) $data["result"];
    }

    public function issue($data = array()) {
       // print('Processing issuance request...' . PHP_EOL);
        $post = json_encode($data);
        $ch = curl_init($this->baseUrl . 'api/payments/' . $this->signature . '/issue');
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($post))
        );
        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            return curl_error($ch);
        }
        $data = json_decode($result, true);
        return $data['result'];
    }

    public function confirm($data = array()) {
        $post = json_encode($data);
        $ch = curl_init($this->baseUrl . 'api/payments/' . $this->signature . '/confirm');
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($post))
        );
        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            print curl_error($ch);
        }
        $data = json_decode($result, true);
        return $data;
    }

    public function status($data = array()) {
        print('Processing status request...' . PHP_EOL);
        $post = json_encode($data);
        $ch = curl_init($this->baseUrl . 'api/payments/' . $this->signature . '/status');
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($post))
        );
        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            print curl_error($ch);
        }
        $data = json_decode($result, true);
        print('Response =>' . var_export($data, true) . PHP_EOL);
        return $data['result'];
    }

}
