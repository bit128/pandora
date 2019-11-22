<?php
/**
* 用户控制器
* ======
* @author 洪波
* @version 16.07.28
*/
namespace app\controllers;
use core\Autumn;
use app\models\M_user;
use app\models\M_admin;

class UserController extends \core\web\Controller {

	/**
	* 获取客户端信息
	* ======
	* @author 洪波
	* @version 16.07.29
	*/
	private function getDeviceInfo() {
		$info = array(
			'user_device' => $this->getPost('user_device', 0),
			'user_devid' => $this->getPost('user_devid'),
			'user_devname' => $this->getPost('user_devid'),
			'user_version' => $this->getPost('user_version'),
			'user_ip' => $this->getPost('user_ip')
			);
		//ip地址判定
		if(isset($info['user_device']) && $info['user_device'] != M_user::DEVICE_WEB) {
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
	public function actionExist() {
		if($account = $this->getParam('account')) {
			$this->respSuccess($this->m_user->exist($account));
			$this->respJson();
		}
	}

	/**
	* 注册
	* ======
	* @author 洪波
	* @version 16.07.28
	*/
	public function actionRegister() {
		if($this->isPost()) {
			$user_phone = $this->getPost('user_phone');
			$user_password = $this->getPost('user_password');
			$info = $this->getDeviceInfo();
			//$info['user_email'] = $this->getPost('user_email');
			$info['user_name'] = $this->getPost('user_name');
			$info['user_gender'] = $this->getPost('user_gender', 0);
			$info['user_avatar'] = $this->getPost('user_avatar');
			//检查重名
			if(! $this->model('m_user')->exist($user_phone)) {
				$token_info = $info;
				$info['user_phone'] = $user_phone;
				$info['user_password'] = md5($user_password);
				$info['user_ctime'] = time();
				$info['user_ltime'] = $info['user_ctime'];
				$info['user_status'] = M_user::STATUS_NORMAL;
				//写入数据库
				$this->model('m_user')->loadData($info);
				if($this->model('m_user')->save()) {
					$user_id = $this->model('m_user')->user_id;
					//构建令牌
					$this->respSuccess($token);
				} else {
					$this->respError(2);
				}
			} else {
				$this->respError(2, '账号重名');
			}
			$this->respJson();
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
		if($this->isPost()) {
			$user_phone = $this->getPost('user_phone');
			$user_password = $this->getPost('user_password');
			//查询用户信息
			$user = $this->model('m_user')->login($user_phone, md5($user_password));
			if($user) {
				if ($user->user_status > M_user::STATUS_LOCK) {
					$info['user_ltime'] = time();
					$info['user_count'] = ++ $user->user_count;
					//更新登录信息
					$user_id = $user->user_id;
					$this->model('m_user')->update($user_id, $info);
					//构建令牌
					$this->respSuccess($token);
				} else {
					$this->respError(105, '账户被锁定');
				}
			} else {
				$this->respError(104, '用户名或密码错误');
			}
			$this->respJson();
		}
	}

	/**
	* 登出
	* ======
	* @author 洪波
	* @version 16.07.28
	*/
	public function actionLogout() {
		$user_id = $this->getPost('user_id');
		$token = $this->getPost('token');
		if($this->model('m_user')->checkToken($user_id, $token)) {
			//清空device_id
			$this->model('m_user')->update($user_id, [
				'user_devid' => ''
			]);
			$this->respSuccess();
		} else {
			$this->respError(104);
		}
		$this->respJson();
	}

	/**
	* 获取用户信息
	* ======
	* @author 洪波
	* @version 16.07.28
	*/
	public function actionGetInfo()
	{
		$user_id = $this->getParam('user_id');
		$token = $this->getParam('token');
		if(strlen($user_id) == 13) {
			$user = $this->model('m_user')->get($user_id);
			if($user) {
				unset($user->user_password);
				if(! $this->model('m_user')->checkToken($user_id, $token)) {
					unset($user->user_phone, $user->user_email, $user->user_devid, $user->user_note, $user->user_ip);
				}
				$this->respSuccess($user->toArray());
			} else {
				$this->respError(106, '用户资料不存在');
			}
		} else {
			$this->respError(103);
		}
		$this->respJson();
	}

	/**
	* [管理员]设置用户信息
	* ======
	* @author 洪波
	* @version 16.07.28
	*/
	public function actionSetInfo() {
		if($this->isPost()) {
			if(M_admin::checkRole(M_admin::ROLE_USER)) {
				$user_id = $this->getPost('user_id');
				$field = $this->getPost('field');
				$value = $this->getPost('value');
				if(($field == 'user_phone' || $field == 'user_email') && $this->m_user->exist($value)) {
					$this->respError(2, '用户重名');
				} else {
					$data = [
						$field => $field != 'user_password' ? $value : md5($value)
					];
					if($this->model('m_user')->update($user_id, $data)) {
						Autumn::app()->response->setResult(Response::RES_OK);
						$this->respSuccess();
					} else {
						$this->respError(102);
					}
				}
			} else {
				$this->respError(105);
			}
			$this->respJson();
		}
	}

	/**
	* 设置用户信息
	* ======
	* @author 洪波
	* @version 17.02.14
	*/
	private function setInfo($field) {
		if ($this->isPost()) {
			$user_id = $this->getPost('user_id');
			$token = $this->getPost('token');
			if ($this->model('m_user')->checkToken($user_id, $token)) {
				$data = array(
					$field => $this->getPost($field)
				);
				if ($this->model('m_user')->update($user_id, $data)) {
					$this->respSuccess();
				} else {
					$this->respError(102);
				}
			} else {
				$this->respError(104);
			}
			$this->respJson();
		}
	}

	/**
	* 设置用户姓名
	* ======
	* @author 洪波
	* @version 17.02.14
	*/
	public function actionSetName() {
		$this->setInfo('user_name');
	}

	/**
	* 设置用户头像
	* ======
	* @author 洪波
	* @version 17.02.14
	*/
	public function actionSetAvatar() {
		$this->setInfo('user_avatar');
	}

	/**
	* 设置用户性别
	* ======
	* @author 洪波
	* @version 17.02.14
	*/
	public function actionSetGender() {
		$this->setInfo('user_gender');
	}

	/**
	* 设置用户签名
	* ======
	* @author 洪波
	* @version 17.02.14
	*/
	public function actionSetNote() {
		$this->setInfo('user_note');
	}

	/**
	* 变更密码
	* ======
	* @author 洪波
	* @version 16.07.28
	*/
	public function actionChangePassword() {
		if ($this->isPost()) {
			$user_id = $this->getPost('user_id');
			$token = $this->getPost('token');
			if ($this->model('m_user')->checkToken($user_id, $token)) {
				$old_password = md5($this->getPost('old_password'));
				$new_password = md5($this->getPost('new_password'));
				$user = $this->model('m_user')->get($user_id);
				if ($user->user_password == $old_password) {
					$data = array('user_password' => $new_password);
					$this->model('m_user')->update($user_id, $data);
					Autumn::app()->response->setResult(Response::RES_OK);
					$this->respSuccess();
				} else {
					$this->respError(105, '原密码不正确');
				}
			} else {
				Autumn::app()->response->setResult(Response::RES_TOKENF, '', '令牌错误');
				$this->respError(104);
			}
			$this->respJson();
		}
	}
}