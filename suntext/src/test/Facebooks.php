<?php
namespace SunWei100\SunText\test;
use Yii;
use Facebook;
use yii\web\Session;

class Facebooks extends Common{

    public function __construct(){

    }
    static public function get_facebook_button($a){
        $app_id = Yii::$app->params['OAUTH_API']['facebook']['app_id'];
        $app_secret = Yii::$app->params['OAUTH_API']['facebook']['app_secret'];
        $fb = new Facebook\Facebook([
            'app_id' => $app_id,
            'app_secret' => $app_secret,
            'default_graph_version' => 'v2.9',
        ]);
        $helper = $fb->getRedirectLoginHelper();
        $permissions = ['email,public_profile']; //要获取的权限
        $collbackurl = Yii::$app->params['OAUTH_API']['facebook']['collback_url'];
        $loginUrl = $helper->getLoginUrl($collbackurl, $permissions);
        return parent::output('200','facebook登录url生成成功.',htmlspecialchars($loginUrl));
    }

    static public function get_facebook_callback($array){
        $app_id = Yii::$app->params['OAUTH_API']['facebook']['app_id'];
        $app_secret = Yii::$app->params['OAUTH_API']['facebook']['app_secret'];
        $fb = new Facebook\Facebook([
            'app_id' => $app_id,
            'app_secret' => $app_secret,
            'default_graph_version' => 'v2.9',
        ]);
        $helper = $fb->getRedirectLoginHelper();
        $helper->getPersistentDataHandler()->set('state', $array['state']);
        try {
            $accessToken = $helper->getAccessToken();
        } catch(Facebook\Exceptions\FacebookResponseException $e) {
            // 当返回错误时
            return parent::output('005','Graph returned an error: ' . $e->getMessage());
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
            // 当验证失败或其他来源的地方
            return parent::output('006','Facebook SDK returned an error: ' . $e->getMessage());
        }
        if (! isset($accessToken)) {
            if ($helper->getError()) {
                header('HTTP/1.0 401 Unauthorized');
                echo "Error: " . $helper->getError() . "\n";
                echo "Error Code: " . $helper->getErrorCode() . "\n";
                echo "Error Reason: " . $helper->getErrorReason() . "\n";
                echo "Error Description: " . $helper->getErrorDescription() . "\n";
            } else {
                header('HTTP/1.0 400 Bad Request');
                echo 'Bad request';
            }
            exit;
        }
        if (! $accessToken->isLongLived()) {
            // 用临时token换长期token
            try {
                $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
            } catch (Facebook\Exceptions\FacebookSDKException $e) {
                return parent::output('007','Error getting long-lived access token: ' . $e->getMessage());
            }
        }
        $session = Yii::$app->session;
        $session->set('fb_access_token',(string) $accessToken);
        return parent::output('200','access_token请求成功.',$accessToken->getValue());
    }

    static public function get_facebook_userinfo(){
        $app_id = Yii::$app->params['OAUTH_API']['facebook']['app_id'];
        $app_secret = Yii::$app->params['OAUTH_API']['facebook']['app_secret'];
        $session = Yii::$app->session;
        $access_token = $session->get('fb_access_token');
        $fb = new Facebook\Facebook([
            'app_id' => $app_id,
            'app_secret' => $app_secret,
            'default_graph_version' => 'v2.9',
            'default_access_token' => $access_token
        ]);
        try {
            $response = $fb->get('/me?locale=en_US&fields=name,email,picture');
        } catch(\Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
            return parent::output('005','Graph returned an error: ' . $e->getMessage());
        } catch(\Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
            return parent::output('006','Facebook SDK returned an error: ' . $e->getMessage());
        }
        $user = $response->getGraphUser()->asArray();
        return parent::output('200','获取user信息成功.',$user);
    }
}





