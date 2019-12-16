<?php
/**
* 管理员模型
* ======
* @author 洪波
* @version 16.07.29
*/
namespace app\models;
use core\Autumn;
use core\db\Criteria;

class T_admin extends \core\web\Model {

	const ROLE_ADMIN	= 1; 	//权限 - 管理员
	const ROLE_USER		= 2; 	//权限 - 用户
	const ROLE_CONTENT	= 4; 	//权限 - 内容
	const ROLE_SUPER	= 4096;	//权限 - 超级

	/**
	* 打印权限表
	* ======
	* @param $select 	选中项
	* @param $checkbox 	是否显示复选框
	* ======
	* @author 洪波
	* @version 14.04.09
	*/
	public static function printRole($select = 0, $checkbox = true) {
		$html = '';
		$roles = array(
			1 	=> '管理员',
			2 	=> '用户',
			4 	=> '内容',
			4096=> '超级'
			);
		if($checkbox) {
			foreach ($roles as $k => $v) {
				if($select & $k)
					$html .= '<input type="checkbox" name="am_role" value="' . $k . '" checked> ' . $v . ' ';
				else
					$html .= '<input type="checkbox" name="am_role" value="' . $k . '"> ' . $v . ' ';
			}
		} else {
			foreach ($roles as $k => $v) {
				if($select & $k)
					$html .= $v . ' ';
			}
		}
		return $html;
	}

	/**
	* 校验管理员权限
	* ======
	* @param $role 	权限值
	* ======
	* @author 洪波
	* @version 14.04.09
	*/
	public static function checkRole($role) {
		if($am_role = Autumn::app()->request->getSession('am_role')) {
			if($am_role & $role)
				return true;
			else
				return false;
		} else {
			return false;
		}
	}

	/**
	* 管理员登录
	* ======
	* @param $account 	账号
	* @param $password 	密码
	* ======
	* @author 洪波
	* @version 14.04.09
	*/
	public function login($account, $password) {
		$criteria = new Criteria;
		$criteria->add('am_account', $account);
		$criteria->add('am_password', $password);
		$criteria->add('am_status', 1);
		$admin = $this->orm->find($criteria);
		if ($admin) {
			//缓存管理员信息
			Autumn::app()->request->setSession('am_account', $admin->am_account);
			Autumn::app()->request->setSession('am_name', $admin->am_name);
			Autumn::app()->request->setSession('am_role', $admin->am_role);
			Autumn::app()->request->setSession('am_time', date('Y-m-d H:i',$admin->am_time));
			Autumn::app()->request->setSession('am_ip', $admin->am_ip);
			//更新登录信息
			$admin->am_time = time();
			$admin->am_ip = $_SERVER['REMOTE_ADDR'];
			return $admin->save();
		} else {
			return false;
		}
	}

	/**
	* 变更管理员权限
	* ======
	* @param $account 	账号
	* @param $roles 	权限
	* @param $op 		操作方式
	* ======
	* @author 洪波
	* @version 14.04.09
	*/
	public function changeRole($account, $role, $op) {
		//获取原管理员权限
		$admin = $this->get($account);
		if($admin) {
			$r = $admin->am_role;
			if($op) {
				$r += $role;
			} else {
				$r -= $role;
			}
			//保存权限
			return $this->update($account, ['am_role' => $r]);
		} else {
			return false;
		}
	}

}