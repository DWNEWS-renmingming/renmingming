<?php
namespace renmingming\demo;
use Yii;

class API{

	//获取FACEBOOK 登录链接
	const GET_FACEBOOK_BUTTON = 'get_facebook_button';

	//FACEBOOK登录回调处理
	const GET_FACEBOOK_CALLBACK = 'get_facebook_callback';

	//获取TWITTER 登录链接
	const GET_TWITTER_BUTTON = 'get_twitter_button';

	//TWITTER登录回调处理
	const GET_TWITTER_CALLBACK = 'get_twitter_callback';

	//获取授权后的用户信息
	const GET_TWITTER_USERINFO = 'get_twitter_userinfo';

	//检测email是否存在
	const CHECK_EMAIL_API = 'check_email_api';

	//登录
	const SIGN_IN_API = 'sign_in_api';

	//注册
	const SIGN_UP_API = 'sign_up_api';

	//修改个人信息
	const UPDATE_USER_INFO = 'update_user_info';

	//修改密码
	const CHANGE_PASSWORD = 'change_password';

	//忘记密码
	const FORGET_PASSWORD = 'forget_password';

	//重置密码
	const RESET_PASSWORD = 'reset_password';

	//获取验证码
    	const GET_CAPTCHA_API = 'get_captcha_api';
	
	//上传图像
	const UPLOAD_AVATAR = 'upload_avatar';

	//三方登录
	const USER_OAUTH_API = 'user_oauth_api';



	public function __construct(){}

	public function post($do='',$data = array())
	{
		//try {
			switch ($do) {
				case self::GET_FACEBOOK_BUTTON:
					$message = Facebooks::get_facebook_button($data);
					break;
				case self::GET_FACEBOOK_CALLBACK:
					$message = Facebooks::get_facebook_callback($data);
					break;
				case self::GET_TWITTER_BUTTON:
					$message = Twitters::get_twitter_button($data);
					break;
				case self::GET_TWITTER_CALLBACK:
					$message = Twitters::get_twitter_callback($data);
					break;
				case self::GET_TWITTER_USERINFO:
					$message = Twitters::get_twitter_userinfo($data);
					break;
				case self::CHECK_EMAIL_API:
					$message = Users::check_email_api($data);
					break;
				case self::SIGN_IN_API:
					$message = Users::sign_in_api($data);
					break;
				case self::SIGN_UP_API:
					$message = Users::sign_up_api($data);
					break;
				case self::UPDATE_USER_INFO:
					$message = Users::update_user_info($data);
					break;
				case self::CHANGE_PASSWORD:
					$message = Users::change_password($data);
					break;
				case self::FORGET_PASSWORD:
					$message = Users::forget_password($data);
					break;
				case self::RESET_PASSWORD:
					$message = Users::reset_password($data);
					break;
				case self::USER_OAUTH_API:
					$message = Users::user_oauth_api($data);
					break;
				case self::UPLOAD_AVATAR:
					$message = Users::upload_avatar($data);
					break;
                		case self::GET_CAPTCHA_API:
                    			$message = Users::get_captcha_api($data);
                    			break;
				default:
					$message = [];
					break;
			}
			return $message;
		//} catch (\Exception $exception) {
		//	$send = [
		//		'internalCode' => '000',
		//		'msg' => '参数错误!',
		//		'data' => ''
		//	];
		//	return $send;
		//}
	}
}


