<?php
/**
* 管理员控制器
* ======
* @author 洪波
* @version 16.07.29
*/
namespace app\controllers;
use core\Autumn;
use app\models\M_admin;

class AdminController extends \core\Controller
{

	private $m_admin;

	public function init()
	{
		$this->m_admin = new M_admin;
	}

	/**
	* 管理员登录页面
	* ======
	* @author 洪波
	* @version 16.07.29
	*/
	public function actionLoginPage()
	{
		Autumn::app()->view->renderPartial('login_page');
	}

	/**
	* 管理员登录
	* ======
	* @author 洪波
	* @version 16.07.29
	*/
	public function actionLogin()
	{
		if(Autumn::app()->request->isPostRequest())
		{
			$account = Autumn::app()->request->getPost('account');
			$password = md5(Autumn::app()->request->getPost('password'));

			if($this->m_admin->login($account, $password))
			{
				$this->redirect('/home');
			}
			else
			{
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
	public function actionLogout()
	{
		Autumn::app()->request->destorySession();
		$this->redirect('/admin/loginPage');
	}

	/**
	* 添加管理员
	* ======
	* @author 洪波
	* @version 16.07.29
	*/
	public function actionAdd()
	{
		if(Autumn::app()->request->isPostRequest())
		{
			if(M_admin::checkRole(M_admin::ROLE_ADMIN))
			{
				$am_account = Autumn::app()->request->getPost('am_account');
				if(trim($am_account) != '')
				{
					if (! $this->m_admin->get($am_account))
					{
						$data = array(
							'am_time' => time(),
							'am_ip' => Autumn::app()->request->getIp()
							);
						if($this->m_admin->insert())
						{
							Autumn::app()->response->setResult(\core\Response::RES_OK);
						}
						else
						{
							Autumn::app()->response->setResult(\core\Response::RES_FAIL);
						}
					}
					else
					{
						Autumn::app()->response->setResult(\core\Response::RES_NAMEDF);
					}
				}
				else
				{
					Autumn::app()->response->setResult(\core\Response::RES_PARAMF, '', '需要填写管理员账号');
				}
			}
			else
			{
				Autumn::app()->response->setResult(\core\Response::RES_REFUSE, '', '需要管理员权限');
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
	public function actionUpdate()
	{
		if(Autumn::app()->request->isPostRequest())
		{
			if(M_admin::checkRole(M_admin::ROLE_ADMIN))
			{
				$account = Autumn::app()->request->getPost('account');
				$field = Autumn::app()->request->getPost('field');
				$data = array();
				if($field == 'am_password')
				{
					$data['am_password'] = md5(Autumn::app()->request->getPost('value'));
				}
				else
				{
					$data[$field] = Autumn::app()->request->getPost('value');
				}
				if($this->m_admin->update($account, $data))
				{
					Autumn::app()->response->setResult(\core\Response::RES_OK);
				}
				else
				{
					Autumn::app()->response->setResult(\core\Response::RES_NOCHAN);
				}
			}
			else
			{
				Autumn::app()->response->setResult(\core\Response::RES_REFUSE);
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
	public function actionGetAccountList()
	{
		if(M_admin::checkRole(M_admin::ROLE_ADMIN + M_admin::ROLE_CONTENT))
		{
			$criteria = new \core\Criteria;
			$criteria->select = 'am_account,am_name';
			$admin_list = $this->m_admin->getList(0, 99, $criteria);
			Autumn::app()->response->setResult($admin_list['result']);
		}
		else
		{
			Autumn::app()->response->setResult(\core\Response::RES_REFUSE);
		}
		Autumn::app()->response->json();
	}

	/**
	* 变更管理员权限
	* ======
	* @author 洪波
	* @version 14.04.10
	*/
	public function actionChangeRole()
	{
		if(Autumn::app()->request->isPostRequest())
		{
			if(M_admin::checkRole(M_admin::ROLE_ADMIN))
			{
				$account = Autumn::app()->request->getPost('am_account');
				$role = Autumn::app()->request->getPost('role');
				$op = Autumn::app()->request->getPost('op');
				if($this->m_admin->changeRole($account, $role, $op))
				{
					Autumn::app()->response->setResult(\core\Response::RES_OK);
				}
				else
				{
					Autumn::app()->response->setResult(\core\Response::RES_FAIL);
				}
			}
			else
			{
				Autumn::app()->response->setResult(\core\Response::RES_REFUSE);
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
	public function actionDelete()
	{
		if(Autumn::app()->request->isPostRequest())
		{
			if(M_admin::checkRole(M_admin::ROLE_SUPER))
			{
				$account = Autumn::app()->request->getPost('account');
				if($this->m_admin->delete($account))
				{
					Autumn::app()->response->setResult(\core\Response::RES_OK);
				}
				else
				{
					Autumn::app()->response->setResult(\core\Response::RES_FAIL);
				}
			}
			else
			{
				Autumn::app()->response->setResult(\core\Response::RES_REFUSE);
			}
			Autumn::app()->response->json();
		}
	}
}