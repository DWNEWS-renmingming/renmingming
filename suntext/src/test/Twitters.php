<?php
namespace SunWei100\SunText\test;
use Yii;
use yii\web\Session;
use Abraham\TwitterOAuth\TwitterOAuth;

class Twitters extends Common{

    public function __construct(){
    }

    static public function get_twitter_button($a){
        $consumer_key = Yii::$app->params['OAUTH_API']['twitter']['consumer_key'];
        $consumer_secret = Yii::$app->params['OAUTH_API']['twitter']['consumer_secret'];
        $oauth_callback = Yii::$app->params['OAUTH_API']['twitter']['oauth_callback'];
        //获取临时token 生成授权url
        $connection = new TwitterOAuth($consumer_key, $consumer_secret);
        $request_token = $connection->oauth('oauth/request_token', array('oauth_callback' => $oauth_callback));
        if ($connection->getLastHttpCode() == 200) {
            //存到session中
            $session = Yii::$app->session;
            $session->set('oauth_token',$request_token['oauth_token']);
            $session->set('oauth_token_secret',$request_token['oauth_token_secret']);
            $url = $connection->url('oauth/authorize', array('oauth_token' => $request_token['oauth_token']));
            return parent::output('200','twitter登录url生成成功.',$url);
        } else {
            return parent::output('001','request_token获取失败.');
        }

    }

    static public function get_twitter_callback($array){
        $consumer_key = Yii::$app->params['OAUTH_API']['twitter']['consumer_key'];
        $consumer_secret = Yii::$app->params['OAUTH_API']['twitter']['consumer_secret'];
        $request_token = [];
        $session = Yii::$app->session;
        $request_token['oauth_token'] = $session->get('oauth_token');
        $request_token['oauth_token_secret'] = $session->get('oauth_token_secret');
        if (isset($array['oauth_token']) && $request_token['oauth_token'] !== $array['oauth_token']) {
            return parent::output('002','oauth_token不匹配.');
        }
        $connection = new TwitterOAuth($consumer_key, $consumer_secret, $request_token['oauth_token'], $request_token['oauth_token_secret']);
        $access_token = $connection->oauth("oauth/access_token", ["oauth_verifier" => $array['oauth_verifier']]);
        if($connection->getLastHttpCode() == 200){
            $session->set('access_token',$access_token);
            return parent::output('200','access_token请求成功.',$access_token);
        }else{
            return parent::output('003','access_token请求不成功.');
        }
    }

    static public function get_twitter_userinfo(){
        $consumer_key = Yii::$app->params['OAUTH_API']['twitter']['consumer_key'];
        $consumer_secret = Yii::$app->params['OAUTH_API']['twitter']['consumer_secret'];
        $session = Yii::$app->session;
        $access_token = $session->get('access_token');
        $connection = new TwitterOAuth($consumer_key, $consumer_secret, $access_token['oauth_token'], $access_token['oauth_token_secret']);
        $user = $connection->get('account/verify_credentials', ['tweet_mode' => 'extended','include_email' => 'true']);
        if($connection->getLastHttpCode() == 200){
            return parent::output('200','获取user信息成功.',get_object_vars($user));
        }else{
            return parent::output('004','获取user信息失败.');
        }
    }
}





