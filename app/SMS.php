<?php

namespace App;

use Ixudra\Curl\Facades\Curl;

class SMS {

    private $API_Key = "5555555";
    private $API_Secret = "94yA%TQn%5555555";
    private $APIURL = "https://ws.sms.ir/";
    /**
     * Gets API Verification Code Url.
     *
     * @return string Indicates the Url
     */
    protected function getAPIVerificationCodeUrl() {
        return "api/VerificationCode";
    }

    /**
     * Gets Api Token Url.
     *
     * @return string Indicates the Url
     */
    protected function getApiTokenUrl() {
        return "api/Token"; 
    }

    /**
     * Verification Code.
     *
     * @param string $Code         Code
     * @param string $MobileNumber Mobile Number
     * 

     * @return string Indicates the sent sms result
     */
    public function verificationCode($Code, $MobileNumber) {
        $token = $this->_getToken($this->API_Key, $this->API_Secret);
        if ($token != false) {
            $postData = array(
                'Code' => $Code,
                'MobileNumber' => $MobileNumber,
            );

            $url = $this->APIURL . $this->getAPIVerificationCodeUrl();
            $VerificationCode = $this->_execute($postData, $url, $token);
            $object = (object)$VerificationCode;

            $result = false;
            if (is_object($object)) {
                $result = $object->Message;
            } else {
                $result = false;
            }
        } else {
            $result = false;
        }
        return $result;
    }

    /**
     * Gets token key for all web service requests.
     *
     * @return string Indicates the token key
     */
    private function _getToken() {
        $postData = array(
            'UserApiKey' => $this->API_Key,
            'SecretKey' => $this->API_Secret,
            'System' => 'php_rest_v_2_0'
        );


        $result = Curl::to($this->APIURL . $this->getApiTokenUrl())->
                        withContentType('application/json')->withData($postData)->asJson(true)->post();
        $result = (object) $result;
        $resp = false;
        $IsSuccessful = '';
        $TokenKey = '';
        $IsSuccessful = $result->IsSuccessful;
        if ($IsSuccessful == true) {
            $TokenKey = $result->TokenKey;
            $resp = $TokenKey;
        } else {
            $resp = false;
        }

        return $resp;
    }

    /**
     * Executes the main method.
     *
     * @param postData[] $postData array of json data
     * @param string     $url      url
     * @param string     $token    token string
     * 
     * @return string Indicates the curl execute result
     */
    private function _execute($postData, $url, $token) {
        $result = Curl::to($this->APIURL . "/api/VerificationCode")
                        ->withHeader('x-sms-ir-secure-token: ' . $token)->
                        withContentType('application/json')->withData($postData)->asJson(true)->post();
        return $result;
    }

}
