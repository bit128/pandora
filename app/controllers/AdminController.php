<?php
/**
* 管理员控制器
* ======
* @author 洪波
* @version 16.07.29
*/
namespace app\controllers;
use core\Autumn;
use app\models\T_admin;

class AdminController extends \core\web\Controller {

	private function checkLogin() {
		if(! Autumn::app()->request->getSession('am_account')) {
			header("Location:/admin/loginPage");
		}
	}

	/**
	* 管理员页面
	* ======
	* @author 洪波
	* @version 16.07.29
	*/
	public function actionIndex() {
		$this->checkLogin();
		$page = $this->getQuery('page', 1);
		$limit = 10;
		$offset = ($page - 1) * $limit;
		$criteria = new \core\db\Criteria;
		$criteria->offset = $offset;
		$criteria->limit = $limit;
		$result = $this->model('t_admin')->getList($criteria);
		//分页
		$url = '/home/admin';
		$pages = new \core\tools\Pagination($result['count'], $limit, $page, $url);

		$data = array(
			'admin_list' => $result['result'],
			'pages' => $pages->build()
			);
		$this->renderView('index', $data);
	}

	/**
	* 管理员登录页面
	* ======
	* @author 洪波
	* @version 16.07.29
	*/
	public function actionLoginPage() {
		Autumn::app()->view->renderPartial('login_page');
	}

	/**
	* 管理员登录
	* ======
	* @author 洪波
	* @version 16.07.29
	*/
	public function actionLogin() {
		if($this->isPost()) {
			$account = $this->getPost('account');
			$password = md5($this->getPost('password'));
			if($this->model('t_admin')->login($account, $password)) {
				$this->redirect('/home');
			} else {
				echo 'login fail.';
			}
		}
	}

	/**
	* 管理员登出
	* ======
	* @author 洪波
	* @version 16.07.29
	*/
	public function actionLogout() {
		Autumn::app()->request->destorySession();
		$this->redirect('/admin/loginPage');
	}

	/**
	* 添加管理员
	* ======
	* @author 洪波
	* @version 16.07.29
	*/
	public function actionAdd() {
		if($this->isPost()) {
			if(T_admin::checkRole(T_admin::ROLE_ADMIN)) {
				$am_account = $this->getPost('am_account');
				if(trim($am_account) != '') {
					if (! $this->model('t_admin')->get($am_account)) {
						$data = array(
							'am_account' => $am_account,
							'am_password' => md5(trim($this->getPost('am_password'))),
							'am_name' => $this->getPost('am_name'),
							'am_group' => $this->getPost('am_group'),
							'am_role' => $this->getPost('am_role'),
							'am_time' => time(),
							'am_ip' => $this->getIp()
							);
						$this->model('t_admin')->loadData($data);
						if($this->model('t_admin')->save()) {
							$this->respSuccess();
						} else {
							$this->respError(2);
						}
					} else {
						$this->respError(2, '用户重名');
					}
				} else {
					$this->respError(103, '需要填写管理员账号');
				}
			} else {
				$this->respError(105, '需要管理员权限');
			}
			$this->respJson();
		}
	}

	/**
	* 修改管理员信息
	* ======
	* @author 洪波
	* @version 16.07.29
	*/
	public function actionUpdate() {
		if($this->isPost()) {
			if(T_admin::checkRole(T_admin::ROLE_ADMIN)) {
				$account = $this->getPost('account');
				$field = $this->getPost('field');
				$data = [];
				if($field == 'am_password') {
					$data['am_password'] = md5($this->getPost('value'));
				} else {
					$data[$field] = $this->getPost('value');
				}
				if($this->model('t_admin')->update($account, $data)) {
					$this->respSuccess();
				} else {
					$this->respError(106);
				}
			} else {
				$this->respError(105);
			}
			$this->respJson();
		}
	}

	/**
	* 获取管理员账号列表
	* ======
	* @author 洪波
	* @version 16.12.18
	*/
	public function actionGetAccountList() {
		if(T_admin::checkRole(T_admin::ROLE_ADMIN + T_admin::ROLE_CONTENT)) {
			$criteria = new \core\db\Criteria;
			$criteria->select = 'am_account,am_name';
			$criteria->offset = 0;
			$criteria->limit = 99;
			$admin_list = $this->model('t_admin')->getList($criteria);
			$this->respSuccess($admin_list['result']);
		} else {
			$this->respError(105);
		}
		$this->respJson();
	}

	/**
	* 变更管理员权限
	* ======
	* @author 洪波
	* @version 14.04.10
	*/
	public function actionChangeRole() {
		if($this->isPost()) {
			if(T_admin::checkRole(T_admin::ROLE_ADMIN)) {
				$account = $this->getPost('am_account');
				$role = $this->getPost('role');
				$op = $this->getPost('op');
				if($this->model('t_admin')->changeRole($account, $role, $op)) {
					A::res()->setResult(Response::RES_OK);
					$this->respSuccess();
				} else {
					$this->respError(2);
				}
			} else {
				$this->respError(105);
			}
			$this->respJson();
		}
	}

	/**
	* 删除管理员账号
	* ======
	* @author 洪波
	* @version 14.04.10
	*/
	public function actionDelete() {
		if($this->isPost()) {
			if(T_admin::checkRole(T_admin::ROLE_SUPER)) {
				$account = $this->getPost('account');
				if($this->model('t_admin')->delete($account)) {
					$this->respSuccess();
				} else {
					$this->respError(2);
				}
			} else {
				$this->respError(105);
			}
			$this->respJson();
		}
	}
}