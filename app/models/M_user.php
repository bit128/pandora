<?php
/**
* 用户模型
* ======
* @author 洪波
* @version 16.07.28
*/
namespace app\models;
use core\Autumn;
use core\db\Criteria;

class M_user extends \core\web\Model {

	public $table_name = 't_user';
	
	const DEVICE_DEFAULT 	= 0; 		//登录设备 - 未知
	const DEVICE_WEB		= 1;		//登录设备 - 网站
	const DEVICE_MBWEB		= 2;		//登录设备 - 移动网站
	const DEVICE_ARDUSERS	= 3;		//登录设备 - android端
	const DEVICE_ARDGUIDE 	= 4;		//登录设备 - ios端

	const STATUS_LOCK		= 0;		//锁定用户
	const STATUS_NORMAL 	= 1; 		//原生用户
	const STATUS_OPEN		= 2;		//开放平台账户
	const STATUS_SHOP		= 3;		//商家

	/**
	* 判断用户是否存在
	* ======
	* @param $account 	账号
	* ======
	* @author 洪波
	* @version 16.07.29
	*/
	public function exist($account) {
		$criteria = new Criteria;
		$criteria->add('user_phone', $account);
		$criteria->add('user_email', $account, '=', 'OR');
		return $this->orm->count($criteria);
	}

	/**
	* 获取用户资料
	* ======
	* @param $account 	用户id/用户电话/邮箱
	* ======
	* @author 洪波
	* @version 16.07.25
	*/
	public function getUser($account) {
		$criteria = new Criteria;
		$criteria->add('user_id', $account);
		$criteria->add('user_phone', $account, '=', 'OR');
		$criteria->add('user_email', $account, '=', 'OR');

		return $this->orm->find($criteria);
	}

	/**
	* 用户登录
	* ======
	* @param $account 	账号
	* @param $password 	密码
	* ======
	* @author 洪波
	* @version 16.07.12
	*/
	public function login($account, $password) {
		$criteria = new Criteria;
		$criteria->add('user_email', $account);
		$criteria->add('user_password', $password);
		return $this->orm->find($criteria);
	}

	/**
	* 用户登出
	* ======
	* @param $account 	账号
	* ======
	* @author 洪波
	* @version 17.08.30
	*/
	public function logout($user_id) {
		return $this->update($user_id, ['user_token' => '']);
	}

	/**
	* 构建令牌
	* ======
	* @param $user_id 	用户id
	* @param $info 		登录信息
	* ======
	* @author 洪波
	* @version 17.08.30
	*/
	public function buildToken($user_id) {
		if($user_id == '') {
			return 0;
		}
		$token = md5(time() . $user_id . rand(1000, 9999));
		$this->update($user_id, ['user_token' => $token]);
		return $token;
	}

	/**
	* 构建令牌
	* ======
	* @param $user_id 	用户id
	* @param $info 		登录信息
	* ======
	* @author 洪波
	* @version 17.08.30
	*/
	public function checkToken($user_id, $token) {
		$user = $this->get($user_id);
		if ($user) {
			if ($user->user_token == $token) {
				return true;
			}
		}
		return false;
	}
}