<?php
/**
* 配置项控制器
* ======
* @author 洪波
* @version 16.08.14
*/
namespace app\controllers;
use core\Controller;
use core\Request;
use core\Response;
use app\models\M_struct;
use app\models\M_admin;

class ConfigController extends Controller
{

	private $m_struct;

	public function init()
	{
		$this->m_struct = new M_struct;
	}

	/**
	* 新建配置项
	* ======
	* @author 洪波
	* @version 16.08.14
	*/
	public function actionAdd()
	{
		if(Request::inst()->isPostRequest())
		{
			$response = new Response;
			if(M_admin::checkRole(M_admin::ROLE_CONTENT))
			{
				$name = Request::inst()->getPost('name', '新配置项');
				$this->m_struct->addHead($name);
				$response->setResult('设置成功', Response::RES_SUCCESS);
			}
			else
			{
				$response->setError('无权操作', Response::RES_REFUSE);
			}
			$response->json();
		}
	}

	/**
	* 设置配置项名称
	* ======
	* @author 洪波
	* @version 16.08.14
	*/
	public function actionSetName()
	{
		if(Request::inst()->isPostRequest())
		{
			$response = new Response;
			if(M_admin::checkRole(M_admin::ROLE_CONTENT))
			{
				$id = Request::inst()->getPost('id');
				$name = Request::inst()->getPost('name');
				$this->m_struct->setName($id, $name);
				$response->setResult('设置成功', Response::RES_SUCCESS);
			}
			else
			{
				$response->setError('无权操作', Response::RES_REFUSE);
			}
			$response->json();
		}
	}

	/**
	* 设置配置项内容
	* ======
	* @author 洪波
	* @version 16.08.14
	*/
	public function actionSetBody()
	{
		if(Request::inst()->isPostRequest())
		{
			$response = new Response;
			if(M_admin::checkRole(M_admin::ROLE_CONTENT))
			{
				$id = Request::inst()->getPost('id');
				$body = Request::inst()->getPost('body');
				$this->m_struct->setBody($id, $body);
				$response->setResult('设置成功', Response::RES_SUCCESS);
			}
			else
			{
				$response->setError('无权操作', Response::RES_REFUSE);
			}
			$response->json();
		}
	}

	/**
	* 获取配置内容
	* ======
	* @author 洪波
	* @version 16.08.14
	*/
	public function actionGet()
	{
		$id = Request::inst()->getQuery('id');
		$response = new Response;
		if(strlen($id) == 13)
		{
			$body = $this->m_struct->getBody($id);
			if($body)
			{
				$response->setResult($body, Response::RES_SUCCESS);
			}
			else
			{
				$response->setError('配置项不存在', Response::RES_NOHAS);
			}
		}
		else
		{
			$response->setError('参数错误', Response::RES_PARAMF);
		}
		$response->json();
	}

	/**
	* 获取配置项列表
	* ======
	* @author 洪波
	* @version 16.08.14
	*/
	public function actionGetList()
	{
		$response = new Response;
		$response->setResult($this->m_struct->getHeadList());
		$response->json();
	}

	/**
	* 删除配置项
	* ======
	* @author 洪波
	* @version 16.08.14
	*/
	public function actionDelete()
	{
		$id = Request::inst()->getPost('id');
		$response = new Response;
		if(M_admin::checkRole(M_admin::ROLE_CONTENT))
		{
			if(strlen($id) == 13)
			{
				$body = $this->m_struct->deleteHead($id);
				$response->setResult('操作成功', Response::RES_SUCCESS);
			}
			else
			{
				$response->setError('参数错误', Response::RES_PARAMF);
			}
			$response->json();
		}
		else
		{
			$response->setError('无权操作', Response::RES_REFUSE);
		}
	}
}