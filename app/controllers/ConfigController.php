<?php
/**
* 配置项控制器
* ======
* @author 洪波
* @version 16.08.14
*/
namespace app\controllers;
use core\Autumn;
use app\models\M_struct;
use app\models\M_admin;

class ConfigController extends \core\Controller
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
		if(Autumn::app()->request->isPostRequest())
		{
			if(M_admin::checkRole(M_admin::ROLE_CONTENT))
			{
				$name = Autumn::app()->request->getPost('name', '新配置项');
				$this->m_struct->addHead($name);
				Autumn::app()->response->setResult(\core\Response::RES_OK);
			}
			else
			{
				Autumn::app()->response->setResult(\core\Response::RES_REFUSE);
			}
			Autumn::app()->response->json();
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
		if(Autumn::app()->request->isPostRequest())
		{
			if(M_admin::checkRole(M_admin::ROLE_CONTENT))
			{
				$id = Autumn::app()->request->getPost('id');
				$name = Autumn::app()->request->getPost('name');
				$this->m_struct->setName($id, $name);
				Autumn::app()->response->setResult(\core\Response::RES_OK);
			}
			else
			{
				Autumn::app()->response->setResult(\core\Response::RES_REFUSE);
			}
			Autumn::app()->response->json();
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
		if(Autumn::app()->request->isPostRequest())
		{
			if(M_admin::checkRole(M_admin::ROLE_CONTENT))
			{
				$id = Autumn::app()->request->getPost('id');
				$body = Autumn::app()->request->getPost('body');
				$this->m_struct->setBody($id, $body);
				Autumn::app()->response->setResult(\core\Response::RES_OK);
			}
			else
			{
				Autumn::app()->response->setResult(\core\Response::RES_REFUSE);
			}
			Autumn::app()->response->json();
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
		$id = Autumn::app()->request->getQuery('id');
		$response = new Response;
		if(strlen($id) == 13)
		{
			$body = $this->m_struct->getBody($id);
			if($body)
			{
				Autumn::app()->response->setResult($body);
			}
			else
			{
				Autumn::app()->response->setResult(\core\Response::RES_NOHAS, '', '配置项不存在');
			}
		}
		else
		{
			Autumn::app()->response->setResult(\core\Response::RES_PARAMF);
		}
		Autumn::app()->response->json();
	}

	/**
	* 获取配置项列表
	* ======
	* @author 洪波
	* @version 16.08.14
	*/
	public function actionGetList()
	{
		Autumn::app()->response->setResult($this->m_struct->getHeadList());
		Autumn::app()->response->json();
	}

	/**
	* 删除配置项
	* ======
	* @author 洪波
	* @version 16.08.14
	*/
	public function actionDelete()
	{
		$id = Autumn::app()->request->getPost('id');
		if(M_admin::checkRole(M_admin::ROLE_CONTENT))
		{
			if(strlen($id) == 13)
			{
				$body = $this->m_struct->deleteHead($id);
				Autumn::app()->response->setResult(\core\Response::RES_OK);
			}
			else
			{
				Autumn::app()->response->setResult(\core\Response::RES_PARAMF);
			}
		}
		else
		{
			Autumn::app()->response->setResult(\core\Response::RES_REFUSE);
		}
		Autumn::app()->response->json();
	}
}