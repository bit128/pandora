<?php
/**
* 管理员控制器
* ======
* @author 洪波
* @version 16.07.29
*/
namespace app\controllers;
use core\Controller;
use core\View;
use core\Request;
use core\Response;
use app\models\M_admin;

class AdminController extends Controller
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
		View::layout()->renderPartial('login_page');
	}

	/**
	* 管理员登录
	* ======
	* @author 洪波
	* @version 16.07.29
	*/
	public function actionLogin()
	{
		if(Request::inst()->isPostRequest())
		{
			$account = Request::inst()->getPost('account');
			$password = md5(Request::inst()->getPost('password'));

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
		Request::inst()->destorySession();
		header("Location:/admin/loginPage");
	}

	/**
	* 添加管理员
	* ======
	* @author 洪波
	* @version 16.07.29
	*/
	public function actionAdd()
	{
		if(Request::inst()->isPostRequest())
		{
			$response = new Response;
			if(M_admin::checkRole(M_admin::ROLE_ADMIN))
			{
				$am_account = Request::inst()->getPost('am_account');
				if(trim($am_account) != '')
				{
					if (! $this->m_admin->get($am_account))
					{
						$data = array(
							'am_time' => time(),
							'am_ip' => Request::inst()->getIp()
							);
						if($this->m_admin->insert())
						{
							$response->setResult('创建成功', Response::RES_SUCCESS);
						}
						else
						{
							$response->setError('创建失败', RES_FAIL);
						}
					}
					else
					{
						$response->setError('账号重名', Response::RES_NAMEDF);
					}
				}
				else
				{
					$response->setError('需要填写管理员账号', Response::RES_PARAMF);
				}
			}
			else
			{
				$response->setError('需要管理员权限', Response::RES_REFUSE);
			}
			$response->json();
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
		if(Request::inst()->isPostRequest())
		{
			$response = new Response;
			if(M_admin::checkRole(M_admin::ROLE_ADMIN))
			{
				$account = Request::inst()->getPost('account');
				$field = Request::inst()->getPost('field');
				$data = array();
				if($field == 'am_password')
				{
					$data['am_password'] = md5(Request::inst()->getPost('value'));
				}
				else
				{
					$data[$field] = Request::inst()->getPost('value');
				}
				if($this->m_admin->update($account, $data))
				{
					$response->setResult('修改成功', Response::RES_SUCCESS);
				}
				else
				{
					$response->setError('没有变更', Response::RES_NOCHAN);
				}
			}
			else
			{
				$response->setError('需要超级权限', Response::RES_REFUSE);
			}
			$response->json();
		}
	}

	/**
	* 变更管理员权限
	* ======
	* @author 洪波
	* @version 14.04.10
	*/
	public function actionChangeRole()
	{
		if(Request::inst()->isPostRequest())
		{
			$response = new Response;
			if(M_admin::checkRole(M_admin::ROLE_ADMIN))
			{
				$account = Request::inst()->getPost('am_account');
				$role = Request::inst()->getPost('role');
				$op = Request::inst()->getPost('op');
				if($this->m_admin->changeRole($account, $role, $op))
				{
					$response->setResult('权限变更成功', Response::RES_SUCCESS);
				}
				else
				{
					$response->setError('变更权限失败', Response::RES_FAIL);
				}
			}
			else
			{
				$response->setError('需要超级权限', Response::RES_REFUSE);
			}
			$response->json();
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
		if(Request::inst()->isPostRequest())
		{
			$response = new Response;
			if(M_admin::checkRole(M_admin::ROLE_SUPER))
			{
				$account = Request::inst()->getPost('account');
				if($this->m_admin->delete($account))
				{
					$response->setResult('删除管理员账号成功', Response::RES_SUCCESS);
				}
				else
				{
					$response->setError('删除管理员账号失败', Response::RES_FAIL);
				}
			}
			else
			{
				$response->setError('需要超级权限', Response::RES_REFUSE);
			}
			$response->json();
		}
	}
}