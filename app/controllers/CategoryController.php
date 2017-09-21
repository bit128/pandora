<?php
/**
*  类目控制器
* ======
* @author 洪波
* @version 16.09.21
*/
namespace app\controllers;
use core\Autumn;
use core\db\Criteria;
use core\http\Response;
use app\models\M_index;
use app\models\M_admin;

class CategoryController extends \core\web\Controller
{
	/**
	* 增加索引词
	* ======
	* @author 洪波
	* @version 16.09.21
	*/
	public function actionAdd()
	{
		if(Autumn::app()->request->isPost())
		{
			if(M_admin::checkRole(M_admin::ROLE_CONTENT))
			{
				$ca_fid = Autumn::app()->request->getPost('ca_fid');
				$ca_name = Autumn::app()->request->getPost('ca_name');
				if($this->m_category->add($ca_fid, $ca_name))
				{
					Autumn::app()->response->setResult(Response::RES_OK);
				}
				else
				{
					Autumn::app()->response->setResult(Response::RES_FAIL);
				}
			}
			else
			{
				Autumn::app()->response->setResult(Response::RES_REFUSE);
			}
			Autumn::app()->response->json();
		}
	}

	/**
	* 更新类目信息
	* ======
	* @author 洪波
	* @version 17.09.21
	*/
	public function actionUpdate()
	{
		if(Autumn::app()->request->isPost())
		{
			if(M_admin::checkRole(M_admin::ROLE_CONTENT))
			{
				$ca_id = Autumn::app()->request->getPost('ca_id');
				$field = Autumn::app()->request->getPost('field');
				$value = Autumn::app()->request->getPost('value');
				if($this->m_category->update($ca_id, array($field => $value)))
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
				Autumn::app()->response->setResult(Response::RES_REFUSE);
			}
			Autumn::app()->response->json();
		}
	}

	/**
	* 删除索引词汇
	* ======
	* @author 洪波
	* @version 16.09.21
	*/
	public function actionDelete()
	{
		if(Autumn::app()->request->isPost())
		{
			if(M_admin::checkRole(M_admin::ROLE_CONTENT))
			{
				$ca_id = Autumn::app()->request->getPost('ca_id');
				if($this->m_category->delete($ca_id))
				{
					//TODO 删除索引
					Autumn::app()->response->setResult(Response::RES_OK);
				}
				else
				{
					Autumn::app()->response->setResult(Response::RES_FAIL);
				}
			}
			else
			{
				Autumn::app()->response->setResult(Response::RES_REFUSE);
			}
			Autumn::app()->response->json();
		}
	}

}