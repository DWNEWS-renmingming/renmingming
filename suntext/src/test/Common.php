<?php
namespace SunWei100\SunText\test;
use SunWei100\SunText\config;

class Common{

    public function __construct(){

    }

    public static function curl_form ($url,$data) {
        $curl = curl_init();
        $configs = new config\Configs();
        $app_id = $configs::get_config('account_system','app_id');
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "content-type: application/x-www-form-urlencoded",
                "x-clientkey: ".$app_id
            ),
        ));
        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl,CURLINFO_HTTP_CODE);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            return "cURL Error #:" . $err;
        } else {
            return $response;
        }
    }


    public function output($code,$msg,$data=''){
        return [
            'internalCode' => $code,
            'msg' => $msg,
            'data' => $data
        ];
    }

}





