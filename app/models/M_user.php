<?php
/**
* 用户模型
* ======
* @author 洪波
* @version 16.07.28
*/
namespace app\models;
use core\Autumn;
use core\Model;
use core\Orm;
use core\Criteria;

class M_user extends Model
{
	
	const DEVICE_DEFAULT 	= 0; 		//登录设备 - 未知
	const DEVICE_WEB		= 1;		//登录设备 - 网站
	const DEVICE_MBWEB		= 2;		//登录设备 - 移动网站
	const DEVICE_ARDUSERS	= 3;		//登录设备 - android端
	const DEVICE_ARDGUIDE 	= 4;		//登录设备 - ios端

	const STATUS_LOCK		= 0;		//锁定用户
	const STATUS_NORMAL 	= 1; 		//原生用户
	const STATUS_OPEN		= 2;		//开放平台账户
	const STATUS_SHOP		= 3;		//商家

	const TOKEN_LIMIT 		= 1296000; 	//令牌缓存有效期
	const TOKEN_PREFIX 		= 'token_'; //令牌缓存前缀

	public $table_name = 't_user';

	/**
	* 判断用户是否存在
	* ======
	* @param $account 	账号
	* ======
	* @author 洪波
	* @version 16.07.29
	*/
	public function exist($account)
	{
		$criteria = new Criteria;
		$criteria->add('user_phone', $account);
		$criteria->add('user_email', $account, '=', 'OR');
		return $this->count($criteria);
	}

	/**
	* 获取用户资料
	* ======
	* @param $account 	用户id/用户电话/邮箱
	* ======
	* @author 洪波
	* @version 16.07.25
	*/
	public function getUser($account)
	{
		$criteria = new Criteria;
		$criteria->add('user_id', $account);
		$criteria->add('user_phone', $account, '=', 'OR');
		$criteria->add('user_email', $account, '=', 'OR');

		return Orm::model($this->table_name)->find($criteria);
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
	public function login($account, $password)
	{
		$criteria = new Criteria;
		$criteria->add('user_email', $account);
		$criteria->add('user_password', $password);
		return Orm::model($this->table_name)->find($criteria);
	}

	/**
	* 构建令牌
	* ======
	* @param $user_id 	用户id
	* @param $info 		登录信息
	* ======
	* @author 洪波
	* @version 16.07.25
	*/
	public function buildToken($user_id, $info = array())
	{
		if($user_id == '')
		{
			return 0;
		}
		$key = self::TOKEN_PREFIX . $user_id;
		$token_string = time() . $user_id . rand(1000, 9999);
		$data = array(
			'user_id' => $user_id,
			'token' => md5($token_string),
			'validity' => time() + self::TOKEN_LIMIT,
			);
		if(is_array($info) && count($info))
		{
			$data += $info;
		}
		//缓存token
		Autumn::app()->redis->hSetAll($key, $data, self::TOKEN_LIMIT);

		return $data;
	}

	/**
	* 构建令牌
	* ======
	* @param $user_id 	用户id
	* @param $info 		登录信息
	* ======
	* @author 洪波
	* @version 16.07.25
	*/
	public function checkToken($user_id, $token)
	{
		$tokens = Autumn::app()->redis->hGetAll(self::TOKEN_PREFIX . $user_id);
		if($tokens)
		{
			if($tokens['token'] == $token)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}
}