<?php
/**
*  索引词控制器
* ======
* @author 洪波
* @version 16.07.29
*/
namespace app\controllers;
use core\Autumn;
use core\db\Criteria;
use core\http\Response;
use app\models\M_dictionary;
use app\models\M_index;
use app\models\M_admin;

class DictionaryController extends \core\web\Controller
{

	private $m_dictionary;

	public function init()
	{
		$this->m_dictionary = new M_dictionary;
	}

	/**
	* 增加索引词
	* ======
	* @author 洪波
	* @version 16.08.07
	*/
	public function actionAdd()
	{
		if(Autumn::app()->request->isPostRequest())
		{
			if(M_admin::checkRole(M_admin::ROLE_CONTENT))
			{
				$dc_fid = Autumn::app()->request->getPost('dc_fid');
				$dc_keyword = Autumn::app()->request->getPost('dc_keyword');
				if($this->m_dictionary->add($dc_fid, $dc_keyword))
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
	* 搜索索引词列表
	* ======
	* @author 洪波
	* @version 17.01.23
	*/
	public function actionGetKeywordList()
	{
		$criteria = new Criteria;
		$criteria->offset = 0;
		$criteria->limit = 99;
		$criteria->order = 'dc_count desc';
		$result = $this->m_dictionary->getList($criteria);
		Autumn::app()->response->setResult($result['result']);
		Autumn::app()->response->json();
	}

	/**
	* 更新索引词信息
	* ======
	* @author 洪波
	* @version 17.01.01
	*/
	public function actionUpdate()
	{
		if(Autumn::app()->request->isPostRequest())
		{
			if(M_admin::checkRole(M_admin::ROLE_CONTENT))
			{
				$dc_id = Autumn::app()->request->getPost('dc_id');
				$field = Autumn::app()->request->getPost('field');
				$value = Autumn::app()->request->getPost('value');
				if($this->m_dictionary->update($dc_id, array($field => $value)))
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
	* @version 16.08.08
	*/
	public function actionDelete()
	{
		if(Autumn::app()->request->isPostRequest())
		{
			if(M_admin::checkRole(M_admin::ROLE_CONTENT))
			{
				$dc_id = Autumn::app()->request->getPost('dc_id');
				if($this->m_dictionary->delete($dc_id))
				{
					//删除索引
					$m_index = new M_index;
					$m_index->deleteIndex($dc_id, '');
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
	* 增加词汇索引
	* ======
	* @author 洪波
	* @version 16.08.09
	*/
	public function actionAddIndex()
	{
		if(Autumn::app()->request->isPostRequest())
		{
			if(M_admin::checkRole(M_admin::ROLE_CONTENT))
			{
				$dc_id = Autumn::app()->request->getPost('dc_id');
				$by_id = Autumn::app()->request->getPost('by_id');
				$m_index = new M_index;
				$m_index->load(array(
					'dc_id' => $dc_id,
					'by_id' => $by_id
					));
				$m_index->save();
				Autumn::app()->response->setResult(Response::RES_OK);
			}
			else
			{
				Autumn::app()->response->setResult(Response::RES_REFUSE);
			}
			Autumn::app()->response->json();
		}
	}

	/**
	* 获取词汇索引
	* ======
	* @author 洪波
	* @version 16.08.10
	*/
	public function actionGetIndex()
	{
		$by_id = Autumn::app()->request->getParam('id');
		if(strlen($by_id) == 13)
		{
			$m_index = new M_index;
			$result = $m_index->getIndex($by_id);
			Autumn::app()->response->setResult($result);
			Autumn::app()->response->json();
		}
	}

	/**
	* 删除词汇索引
	* ======
	* @author 洪波
	* @version 17.01.23
	*/
	public function actionDeleteIndex()
	{
		if(Autumn::app()->request->isPostRequest())
		{
			if(M_admin::checkRole(M_admin::ROLE_CONTENT))
			{
				$dc_id = Autumn::app()->request->getPost('dc_id');
				$by_id = Autumn::app()->request->getPost('by_id');

				$m_index = new M_index;
				$m_index->deleteIndex($dc_id, $by_id);
				Autumn::app()->response->setResult(Response::RES_OK);
			}
			else
			{
				Autumn::app()->response->setResult(Response::RES_REFUSE);
			}
			Autumn::app()->response->json();
		}
	}

}