<?php
namespace SunWei100\SunText\test;
use Yii;
use \Curl\Curl;

class Users extends Common{

    public function __construct(){

    }
    static public function check_email_api($data){
        if(!empty($data)){
            $url = Yii::$app->params['USER_API_URL']['check_email'];
            $curl = new Curl();
            $curl->setHeaders(['cache-control'=>'no-cache','content-type'=>'application/json']);
            $curl->get($url.$data);
            $http_status_code = $curl->httpStatusCode;
            $error = $curl->error;
            $error_code = $curl->errorCode;
            $error_message = $curl->errorMessage;
            $curl->close();
            if ($http_status_code != '200') {
                if($error && $error_code == '404'){
                    return parent::output($http_status_code,'请求成功.',$http_status_code);
                }else{
                    return parent::output($error_code,'Error: ' . $error_code . ': ' . $error_message);
                }
            } else {
                return parent::output($http_status_code,'请求成功.',$http_status_code);
            }
        }else{
            return parent::output('008','username不能为空');
        }
    }


    static public function sign_in_api ($data) {
        if(!empty($data)){
            $url = Yii::$app->params['USER_API_URL']['sign_in'];
            $curl = new Curl();
            $curl->setHeaders(['cache-control'=>'no-cache','content-type'=>'application/json']);
            $curl->post($url,$data);
            $http_status_code = $curl->httpStatusCode;
            $error = $curl->error;
            $error_code = $curl->errorCode;
            $error_message = $curl->errorMessage;
            $response = $curl->rawResponse;
            $curl->close();
            if ($error) {
                return parent::output($error_code,'Error: ' . $error_code . ': ' . $error_message);
            } else {
                return parent::output($http_status_code,'请求成功.',$response);
            }
        }else{
            return parent::output('008','参数不能为空');
        }
    }


    static public function sign_up_api ($data) {
        if(!empty($data)){
            $url = Yii::$app->params['USER_API_URL']['sign_up'];
            $curl = new Curl();
            $curl->setHeaders(['cache-control'=>'no-cache','content-type'=>'application/json']);
            $curl->post($url,$data);
            $http_status_code = $curl->httpStatusCode;
            $error = $curl->error;
            $error_code = $curl->errorCode;
            $error_message = $curl->errorMessage;
            $response = $curl->rawResponse;
            $curl->close();
            if ($error) {
                return parent::output($error_code,'Error: ' . $error_code . ': ' . $error_message);
            } else {
                return parent::output($http_status_code,'请求成功.',$response);
            }
        }else{
            return parent::output('008','参数不能为空');
        }
    }

    static public function update_user_info ($data) {
        if(!empty($data)){
            $url = Yii::$app->params['USER_API_URL']['update_userinfo'];
            $curl = new Curl();
            $curl->setHeaders(['authorization'=>"Bearer ".$data["user_jwt"],'cache-control'=>'no-cache','content-type'=>'application/json']);
            $curl->post($url,$data['info']);
            $http_status_code = $curl->httpStatusCode;
            $error = $curl->error;
            $error_code = $curl->errorCode;
            $error_message = $curl->errorMessage;
            $response = $curl->rawResponse;
            $curl->close();
            if ($error) {
                return parent::output($error_code,'Error: ' . $error_code . ': ' . $error_message);
            } else {
                return parent::output($http_status_code,'请求成功.',$response);
            }
        }else{
            return parent::output('008','参数不能为空');
        }
    }

    static public function change_password ($data) {
        if(!empty($data)){
            $url = Yii::$app->params['USER_API_URL']['change_password'];
            $curl = new Curl();
            $curl->setHeaders(['authorization'=>"Bearer ".$data["user_jwt"],'cache-control'=>'no-cache','content-type'=>'application/json']);
            $curl->post($url,$data['info']);
            $http_status_code = $curl->httpStatusCode;
            $error = $curl->error;
            $error_code = $curl->errorCode;
            $error_message = $curl->errorMessage;
            $response = $curl->rawResponse;
            $curl->close();
            if ($error) {
                return parent::output($error_code,'Error: ' . $error_code . ': ' . $error_message);
            } else {
                return parent::output($http_status_code,'请求成功.',$response);
            }
        }else{
            return parent::output('008','参数不能为空');
        }
    }


    static public function forget_password($data){
        if(!empty($data)){
            $url = Yii::$app->params['USER_API_URL']['forget_password'];
            $curl = new Curl();
            $curl->setHeaders(['cache-control'=>'no-cache','content-type'=>'application/json']);
            $curl->post($url,$data);
            $http_status_code = $curl->httpStatusCode;
            $error = $curl->error;
            $error_code = $curl->errorCode;
            $error_message = $curl->errorMessage;
            $response = $curl->rawResponse;
            $curl->close();
            if ($error) {
                return parent::output($error_code,'Error: ' . $error_code . ': ' . $error_message);
            } else {
                return parent::output($http_status_code,'请求成功.',$http_status_code);
            }
        }else{
            return parent::output('008','参数不能为空');
        }
    }


    static public function reset_password($data){
        if(!empty($data)){
            $url = Yii::$app->params['USER_API_URL']['reset_password'];
            $curl = new Curl();
            $curl->setHeaders(['cache-control'=>'no-cache','content-type'=>'application/json']);
            $curl->post($url,$data);
            $http_status_code = $curl->httpStatusCode;
            $error = $curl->error;
            $error_code = $curl->errorCode;
            $error_message = $curl->errorMessage;
            $response = $curl->rawResponse;
            $curl->close();
            if ($error) {
                return parent::output($error_code,'Error: ' . $error_code . ': ' . $error_message);
            } else {
                return parent::output($http_status_code,'请求成功.',$http_status_code);
            }
        }else{
            return parent::output('008','参数不能为空');
        }
    }

    static public function  upload_avatar($data){
        if(!empty($data)){
            $url = Yii::$app->params['USER_API_URL']['upload_avatar'];
            $curl = new Curl();
            $curl->setHeaders(['authorization'=>"Bearer ".$data["user_jwt"],'cache-control'=>'no-cache','content-type'=>'multipart/form-data']);
            $curl->post($url, [
                'image' => new \CURLFile('/data/webroot/dwk/advanced/frontend/web/imgtest/1234.png'),
            ]);
            $http_status_code = $curl->httpStatusCode;
            $error = $curl->error;
            $error_code = $curl->errorCode;
            $error_message = $curl->errorMessage;
            $response = $curl->rawResponse;
            $curl->close();
            if ($error) {
                return parent::output($error_code,'Error: ' . $error_code . ': ' . $error_message);
            } else {
                return parent::output($http_status_code,'请求成功.',$response);
            }
        }else{
            return parent::output('008','参数不能为空');
        }
    }


    static public function user_oauth_api ($data) {
        if(!empty($data)){
            $url = Yii::$app->params['USER_API_URL']['oauth_login'];
            $curl = new Curl();
            $curl->setHeaders(['cache-control'=>'no-cache','content-type'=>'application/json']);
            $curl->post($url,$data);
            $http_status_code = $curl->httpStatusCode;
            $error = $curl->error;
            $error_code = $curl->errorCode;
            $error_message = $curl->errorMessage;
            $response = $curl->rawResponse;
            $curl->close();
            if ($error) {
                return parent::output($error_code,'Error: ' . $error_code . ': ' . $error_message);
            } else {
                return parent::output($http_status_code,'请求成功.',$response);
            }
        }else{
            return parent::output('008','参数不能为空');
        }

    }

    static public function get_captcha_api(){
        $url = Yii::$app->params['USER_API_URL']['get_captcha'];
        $curl = new Curl();
        $curl->setHeaders(['cache-control'=>'no-cache','content-type'=>'application/json']);
        $curl->post($url);
        $http_status_code = $curl->httpStatusCode;
        $error = $curl->error;
        $error_code = $curl->errorCode;
        $error_message = $curl->errorMessage;
        $response = $curl->rawResponse;
        $curl->close();
        if ($error) {
            return parent::output($error_code,'Error: ' . $error_code . ': ' . $error_message);
        } else {
            return parent::output($http_status_code,'请求成功.',$response);
        }
    }
}





