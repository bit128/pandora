<?php
/**
* 管理员控制器
* ======
* @author 洪波
* @version 16.07.29
*/
namespace app\controllers;
use core\Autumn;
use \core\http\Response;
use app\models\M_admin;

class AdminController extends \core\web\Controller {
	/**
	* 管理员页面
	* ======
	* @author 洪波
	* @version 16.07.29
	*/
	public function actionIndex() {
		$page = Autumn::app()->request->getQuery('page', 1);
		$limit = 10;
		$offset = ($page - 1) * $limit;
		$criteria = new \core\db\Criteria;
		$criteria->offset = $offset;
		$criteria->limit = $limit;
		$result = $this->model('m_admin')->getList($criteria);
		//分页
		$url = '/home/admin';
		$pages = new \core\tools\Pagination($result['count'], $limit, $page, $url);

		$data = array(
			'admin_list' => $result['result'],
			'pages' => $pages->build()
			);
		Autumn::app()->view->render('index', $data);
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
		if(Autumn::app()->request->isPost()) {
			$account = Autumn::app()->request->getPost('account');
			$password = md5(Autumn::app()->request->getPost('password'));

			if($this->model('m_admin')->login($account, $password)) {
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
		if(Autumn::app()->request->isPost()) {
			if(M_admin::checkRole(M_admin::ROLE_ADMIN)) {
				$am_account = Autumn::app()->request->getPost('am_account');
				if(trim($am_account) != '') {
					if (! $this->model('m_admin')->get($am_account)) {
						$data = array(
							'am_account' => $am_account,
							'am_password' => md5(trim(Autumn::app()->request->getPost('am_password'))),
							'am_name' => Autumn::app()->request->getPost('am_name'),
							'am_group' => Autumn::app()->request->getPost('am_group'),
							'am_role' => Autumn::app()->request->getPost('am_role'),
							'am_time' => time(),
							'am_ip' => Autumn::app()->request->getIp()
							);
						$this->model('m_admin')->loadData($data);
						if($this->model('m_admin')->save()) {
							Autumn::app()->response->setResult(Response::RES_OK);
						} else {
							Autumn::app()->response->setResult(Response::RES_FAIL);
						}
					} else {
						Autumn::app()->response->setResult(Response::RES_NAMEDF);
					}
				} else {
					Autumn::app()->response->setResult(Response::RES_PARAMF, '', '需要填写管理员账号');
				}
			} else {
				Autumn::app()->response->setResult(Response::RES_REFUSE, '', '需要管理员权限');
			}
			Autumn::app()->response->json();
		}
	}

	/**
	* 修改管理员信息
	* ======
	* @author 洪波
	* @version 16.07.29
	*/
	public function actionUpdate() {
		if(Autumn::app()->request->isPost()) {
			if(M_admin::checkRole(M_admin::ROLE_ADMIN)) {
				$account = Autumn::app()->request->getPost('account');
				$field = Autumn::app()->request->getPost('field');
				$data = array();
				if($field == 'am_password') {
					$data['am_password'] = md5(Autumn::app()->request->getPost('value'));
				} else {
					$data[$field] = Autumn::app()->request->getPost('value');
				}
				if($this->model('m_admin')->update($account, $data)) {
					Autumn::app()->response->setResult(Response::RES_OK);
				} else {
					Autumn::app()->response->setResult(Response::RES_NOCHAN);
				}
			} else {
				Autumn::app()->response->setResult(Response::RES_REFUSE);
			}
			Autumn::app()->response->json();
		}
	}

	/**
	* 获取管理员账号列表
	* ======
	* @author 洪波
	* @version 16.12.18
	*/
	public function actionGetAccountList() {
		if(M_admin::checkRole(M_admin::ROLE_ADMIN + M_admin::ROLE_CONTENT)) {
			$criteria = new \core\db\Criteria;
			$criteria->select = 'am_account,am_name';
			$criteria->offset = 0;
			$criteria->limit = 99;
			$admin_list = $this->model('m_admin')->getList($criteria);
			Autumn::app()->response->setResult($admin_list['result']);
		} else {
			Autumn::app()->response->setResult(Response::RES_REFUSE);
		}
		Autumn::app()->response->json();
	}

	/**
	* 变更管理员权限
	* ======
	* @author 洪波
	* @version 14.04.10
	*/
	public function actionChangeRole() {
		if(Autumn::app()->request->isPost()) {
			if(M_admin::checkRole(M_admin::ROLE_ADMIN)) {
				$account = Autumn::app()->request->getPost('am_account');
				$role = Autumn::app()->request->getPost('role');
				$op = Autumn::app()->request->getPost('op');
				if($this->model('m_admin')->changeRole($account, $role, $op)) {
					Autumn::app()->response->setResult(Response::RES_OK);
				} else {
					Autumn::app()->response->setResult(Response::RES_FAIL);
				}
			} else {
				Autumn::app()->response->setResult(Response::RES_REFUSE);
			}
			Autumn::app()->response->json();
		}
	}

	/**
	* 删除管理员账号
	* ======
	* @author 洪波
	* @version 14.04.10
	*/
	public function actionDelete() {
		if(Autumn::app()->request->isPost()) {
			if(M_admin::checkRole(M_admin::ROLE_SUPER)) {
				$account = Autumn::app()->request->getPost('account');
				if($this->model('m_admin')->delete($account)) {
					Autumn::app()->response->setResult(Response::RES_OK);
				} else {
					Autumn::app()->response->setResult(Response::RES_FAIL);
				}
			} else {
				Autumn::app()->response->setResult(Response::RES_REFUSE);
			}
			Autumn::app()->response->json();
		}
	}
}