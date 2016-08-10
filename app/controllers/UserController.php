<?php
/**
* 用户控制器
* ======
* @author 洪波
* @version 16.07.28
*/
namespace app\controllers;
use core\Controller;
use core\Request;
use core\Response;
use library\RedisCache;
use library\Psdk;
use app\models\M_user;
use app\models\M_admin;

class UserController extends Controller
{
	private $m_user;

	public function init()
	{
		$this->m_user = new M_user;
	}

	/**
	* 获取客户端信息
	* ======
	* @author 洪波
	* @version 16.07.29
	*/
	private function getDeviceInfo()
	{
		$info = array(
			'user_device' => Request::inst()->getPost('user_device', 0),
			'user_devid' => Request::inst()->getPost('user_devid'),
			'user_devname' => Request::inst()->getPost('user_devid'),
			'user_version' => Request::inst()->getPost('user_version'),
			'user_ip' => Request::inst()->getPost('user_ip')
			);
		//ip地址判定
		if(isset($info['user_device']) && $info['user_device'] != M_user::DEVICE_WEB)
		{
			$info['user_ip'] = $_SERVER['REMOTE_ADDR'];
		}
		return $info;
	}

	/**
	* 判断用户是否存在
	* ======
	* @author 洪波
	* @version 16.07.28
	*/
	public function actionExist()
	{
		if($account = Request::inst()->getParam('account'))
		{
			$response = new Response;
			$response->setResult($this->m_user->exist($account), Response::RES_SUCCESS);
			$rs->json();
		}
	}

	/**
	* 注册
	* ======
	* @author 洪波
	* @version 16.07.28
	*/
	public function actionRegister()
	{
		if(Psdk::checkSign())
		{
			$response = new Response;
			$user_phone = Request::inst()->getPost('user_phone');
			$user_password = Request::inst()->getPost('user_password');
			$info = $this->getDeviceInfo();
			//$info['user_email'] = Request::inst()->getPost('user_email');
			$info['user_name'] = Request::inst()->getPost('user_name');
			$info['user_gender'] = Request::inst()->getPost('user_gender', 0);
			$info['user_avatar'] = Request::inst()->getPost('user_avatar');
			//检查重名
			$user = $this->m_user->getUser($user_phone);
			if(! $user)
			{
				$token_info = $info;
				$info['user_phone'] = $user_phone;
				$info['user_password'] = md5($user_password);
				$info['user_ctime'] = time();
				$info['user_ltime'] = $info['user_ctime'];
				$info['user_status'] = M_user::STATUS_NORMAL;
				//写入数据库
				$user_id = $this->m_user->insert($info, false);
				if(strlen($user_id) === 13)
				{
					//构建令牌
					$token = RedisCache::model('token')->build($user_id, $token_info);
					$response->setResult($token, Response::RES_SUCCESS);
				}
				else
				{
					$response->setError('创建失败', Response::RES_FAIL);
				}
			}
			else
			{
				$response->setError('账号重名', Response::RES_NAMEDF);
			}
			$response->json();
		}
	}

	/**
	* 登录
	* ======
	* @author 洪波
	* @version 16.07.28
	*/
	public function actionLogin()
	{
		if(Psdk::checkSign())
		{
			$response = new Response;
			$user_phone = Request::inst()->getPost('user_phone');
			$user_password = Request::inst()->getPost('user_password');
			//查询用户信息
			$user = $this->m_user->login($user_phone, md5($user_password));
			if($user)
			{
				if ($user->user_status > M_user::STATUS_LOCK)
				{
					$info['user_ltime'] = time();
					$info['user_count'] = ++ $user->user_count;
					//更新登录信息
					$user_id = $user->user_id;
					$this->m_user->update($user_id, $info);
					//构建令牌
					$token = RedisCache::model('token')->build($user_id, $info);
					$response->setResult($token, Response::RES_SUCCESS);
				}
				else
				{
					$response->setError('账户被锁定', Response::RES_REFUSE);
				}
			}
			else
			{
				$response->setError('用户名或密码错误', Response::RES_PWDF);
			}
			$response->json();
		}
	}

	/**
	* 登出
	* ======
	* @author 洪波
	* @version 16.07.28
	*/
	public function actionLogout()
	{
		if(Psdk::checkSign())
		{
			$response = new Response;
			$user_id = Request::inst()->getPost('user_id');
			$token = Request::inst()->getPost('token');
			if(RedisCache::model('token')->check($user_id, $token))
			{
				//清空device_id
				$this->m_user->update($user_id, array(
					'user_devid' => ''
					));
				//清除用户令牌
				RedisCache::model('token')->flush($user_id);
				$response->setResult('登出成功', Response::RES_SUCCESS);
			}
			else
			{
				$response->setError('令牌无效', Response::RES_TOKENF);
			}
			$response->json();
		}
	}

	/**
	* 获取用户信息
	* ======
	* @author 洪波
	* @version 16.07.28
	*/
	public function actionGetInfo()
	{
		$response = new Response;
		$user_id = Request::inst()->getParam('user_id');
		$token = Request::inst()->getParam('token');
		if(strlen($user_id) == 13)
		{
			$user = $this->m_user->get($user_id);
			if($user)
			{
				unset($user->user_password);
				if(! RedisCache::model('token')->check($user_id, $token))
				{
					unset($user->user_phone, $user->user_email, $user->user_devid, $user->user_note, $user->user_ip);
				}
				$response->setResult($user, Response::RES_SUCCESS);
			}
			else
			{
				$response->setError('用户不存在', Response::RES_NOHAS);
			}
		}
		else
		{
			$response->setError('参数错误', Response::RES_PARAMF);
		}
		$response->json();
	}

	/**
	* 设置用户信息
	* ======
	* @author 洪波
	* @version 16.07.28
	*/
	public function actionSetInfo()
	{
		if(Request::inst()->isPostRequest())
		{
			$response = new Response;
			if(M_admin::checkRole(M_admin::ROLE_USER))
			{
				$user_id = Request::inst()->getPost('user_id');
				$field = Request::inst()->getPost('field');
				$value = Request::inst()->getPost('value');
				if(($field == 'user_phone' || $field == 'user_email') && $this->m_user->exist($value))
				{
					$response->setError('账号重名', Response::RES_NAMEDF);
				}
				else
				{
					$data = array(
						$field => $field != 'user_password' ? $value : md5($value)
						);
					if($this->m_user->update($user_id, $data))
					{
						$response->setResult('设置成功', Response::RES_SUCCESS);
					}
					else
					{
						$response->setError('没有变更', Response::RES_NOCHAN);
					}
				}
			}
			else
			{
				$response->setError('需要用户权限', Response::RES_REFUSE);
			}
			$response->json();
		}
	}

	/**
	* 更新用户信息
	* ======
	* @author 洪波
	* @version 16.07.28
	*/
	public function actionUpdateInfo()
	{}

	/**
	* 变更密码
	* ======
	* @author 洪波
	* @version 16.07.28
	*/
	public function actionChangePassword()
	{}
}