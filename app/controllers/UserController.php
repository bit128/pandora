<?php
/**
* 用户控制器
* ======
* @author 洪波
* @version 16.07.28
*/
namespace app\controllers;
use core\Autumn;
use core\http\Response;
use app\models\M_user;
use app\models\M_admin;

class UserController extends \core\web\Controller
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
			'user_device' => Autumn::app()->request->getPost('user_device', 0),
			'user_devid' => Autumn::app()->request->getPost('user_devid'),
			'user_devname' => Autumn::app()->request->getPost('user_devid'),
			'user_version' => Autumn::app()->request->getPost('user_version'),
			'user_ip' => Autumn::app()->request->getPost('user_ip')
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
		if($account = Autumn::app()->request->getParam('account'))
		{
			Autumn::app()->response->setResult($this->m_user->exist($account));
			Autumn::app()->response->json();
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
			$user_phone = Autumn::app()->request->getPost('user_phone');
			$user_password = Autumn::app()->request->getPost('user_password');
			$info = $this->getDeviceInfo();
			//$info['user_email'] = Autumn::app()->request->getPost('user_email');
			$info['user_name'] = Autumn::app()->request->getPost('user_name');
			$info['user_gender'] = Autumn::app()->request->getPost('user_gender', 0);
			$info['user_avatar'] = Autumn::app()->request->getPost('user_avatar');
			//检查重名
			if(! $this->m_user->exist($user_phone))
			{
				$token_info = $info;
				$info['user_phone'] = $user_phone;
				$info['user_password'] = md5($user_password);
				$info['user_ctime'] = time();
				$info['user_ltime'] = $info['user_ctime'];
				$info['user_status'] = M_user::STATUS_NORMAL;
				//写入数据库
				$this->m_user->load($info);
				if($this->m_user->save())
				{
					$user_id = $this->m_user->getOrm()->user_id;
					//构建令牌
					$token = RedisCache::model('token')->build($user_id, $token_info);
					$token['user_name'] = $info['user_name'];
					Autumn::app()->response->setResult($token);
				}
				else
				{
					Autumn::app()->response->setResult(Response::RES_FAIL);
				}
			}
			else
			{
				Autumn::app()->response->setResult(Response::RES_NAMEDF);
			}
			Autumn::app()->response->json();
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
			$user_phone = Autumn::app()->request->getPost('user_phone');
			$user_password = Autumn::app()->request->getPost('user_password');
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
					$token['user_name'] = $user->user_name;
					Autumn::app()->response->setResult($token);
				}
				else
				{
					Autumn::app()->response->setResult(Response::RES_REFUSE, '', '账户被锁定');
				}
			}
			else
			{
				Autumn::app()->response->setResult(Response::RES_PWDF, '', '用户名或密码错误');
			}
			Autumn::app()->response->json();
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
			$user_id = Autumn::app()->request->getPost('user_id');
			$token = Autumn::app()->request->getPost('token');
			if(RedisCache::model('token')->check($user_id, $token))
			{
				//清空device_id
				$this->m_user->update($user_id, array(
					'user_devid' => ''
					));
				//清除用户令牌
				RedisCache::model('token')->flush($user_id);
				Autumn::app()->response->setResult(Response::RES_OK);
			}
			else
			{
				Autumn::app()->response->setResult(Response::RES_TOKENF);
			}
			Autumn::app()->response->json();
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
		$user_id = Autumn::app()->request->getParam('user_id');
		$token = Autumn::app()->request->getParam('token');
		if(strlen($user_id) == 13)
		{
			$user = $this->m_user->get($user_id);
			if($user)
			{
				unset($user->user_password);
				if(! $this->m_user->checkToken($user_id, $token))
				{
					unset($user->user_phone, $user->user_email, $user->user_devid, $user->user_note, $user->user_ip);
				}
				Autumn::app()->response->setResult($user);
			}
			else
			{
				Autumn::app()->response->setResult(Response::RES_NOHAS, '', '用户不存在');
			}
		}
		else
		{
			Autumn::app()->response->setResult(Response::RES_PARAMF);
		}
		Autumn::app()->response->json();
	}

	/**
	* [管理员]设置用户信息
	* ======
	* @author 洪波
	* @version 16.07.28
	*/
	public function actionSetInfo()
	{
		if(Autumn::app()->request->isPostRequest())
		{
			if(M_admin::checkRole(M_admin::ROLE_USER))
			{
				$user_id = Autumn::app()->request->getPost('user_id');
				$field = Autumn::app()->request->getPost('field');
				$value = Autumn::app()->request->getPost('value');
				if(($field == 'user_phone' || $field == 'user_email') && $this->m_user->exist($value))
				{
					Autumn::app()->response->setResult(Response::RES_NAMEDF);
				}
				else
				{
					$data = array(
						$field => $field != 'user_password' ? $value : md5($value)
						);
					if($this->m_user->update($user_id, $data))
					{
						Autumn::app()->response->setResult(Response::RES_OK);
					}
					else
					{
						Autumn::app()->response->setResult(Response::RES_NOCHAN);
					}
				}
			}
			else
			{
				Autumn::app()->response->setResult(Response::RES_REFUSE, '', '需要用户权限');
			}
			Autumn::app()->response->json();
		}
	}

	/**
	* 设置用户信息
	* ======
	* @author 洪波
	* @version 17.02.14
	*/
	private function setInfo($field)
	{
		if (Autumn::app()->request->isPostRequest())
		{
			$user_id = Autumn::app()->request->getPost('user_id');
			$token = Autumn::app()->request->getPost('token');
			if ($this->m_user->checkToken($user_id, $token))
			{
				$data = array(
					$field => Autumn::app()->request->getPost($field)
				);
				if ($this->m_user->update($user_id, $data))
				{
					Autumn::app()->response->setResult(Response::RES_OK);
				}
				else
				{
					Autumn::app()->response->setResult(Response::RES_NOCHAN);
				}
			}
			else
			{
				Autumn::app()->response->setResult(Response::RES_TOKENF, '', '令牌错误');
			}
			Autumn::app()->response->json();
		}
	}

	/**
	* 设置用户姓名
	* ======
	* @author 洪波
	* @version 17.02.14
	*/
	public function actionSetName()
	{
		$this->setInfo('user_name');
	}

	/**
	* 设置用户头像
	* ======
	* @author 洪波
	* @version 17.02.14
	*/
	public function actionSetAvatar()
	{
		$this->setInfo('user_avatar');
	}

	/**
	* 设置用户性别
	* ======
	* @author 洪波
	* @version 17.02.14
	*/
	public function actionSetGender()
	{
		$this->setInfo('user_gender');
	}

	/**
	* 设置用户签名
	* ======
	* @author 洪波
	* @version 17.02.14
	*/
	public function actionSetNote()
	{
		$this->setInfo('user_note');
	}

	/**
	* 变更密码
	* ======
	* @author 洪波
	* @version 16.07.28
	*/
	public function actionChangePassword()
	{
		if (Autumn::app()->request->isPostRequest())
		{
			$user_id = Autumn::app()->request->getPost('user_id');
			$token = Autumn::app()->request->getPost('token');
			if ($this->m_user->checkToken($user_id, $token))
			{
				$old_password = md5(Autumn::app()->request->getPost('old_password'));
				$new_password = md5(Autumn::app()->request->getPost('new_password'));
				$user = $this->m_user->get($user_id);
				if ($user->user_password == $old_password)
				{
					$data = array('user_password' => $new_password);
					$this->m_user->update($user_id, $data);
					Autumn::app()->response->setResult(Response::RES_OK);
				}
				else
				{
					Autumn::app()->response->setResult(Response::RES_PWDF, '', '原密码不正确');
				}
			}
			else
			{
				Autumn::app()->response->setResult(Response::RES_TOKENF, '', '令牌错误');
			}
			Autumn::app()->response->json();
		}
	}
}