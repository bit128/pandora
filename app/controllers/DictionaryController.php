<?php
/**
* 管理员控制器
* ======
* @author 洪波
* @version 16.07.29
*/
namespace app\controllers;
use core\Autumn;
use core\Criteria;
use app\models\M_dictionary;
use app\models\M_index;
use app\models\M_admin;

class DictionaryController extends \core\Controller
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
				$dc_keyword = Autumn::app()->request->getPost('dc_keyword');
				$dc_type = (int) Autumn::app()->request->getPost('dc_type', M_dictionary::TYPE_NORMAL);
				if($dc_keyword != '' && ! $this->m_dictionary->getId($dc_keyword))
				{
					if($this->m_dictionary->add($dc_keyword, $dc_type))
					{
						Autumn::app()->response->setResult(\core\Response::RES_OK);
					}
					else
					{
						Autumn::app()->response->setResult(\core\Response::RES_FAIL);
					}
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
	* 模糊查找索引词列表
	* ======
	* @author 洪波
	* @version 16.08.08
	*/
	public function actionMatchKeywordList()
	{
		$keyword = urldecode(Autumn::app()->request->getParam('keyword'));
		if($keyword != '')
		{
			$criteria = new Criteria;
			$criteria->addCondition("dc_keyword like '%{$keyword}%'");
			$criteria->order = 'dc_count desc';
			$result = $this->m_dictionary->getList(0, 10, $criteria);
			Autumn::app()->response->setResult($result);
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
					$m_index->deleteByDic($dc_id);
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
				$by_id = Autumn::app()->request->getPost('by_id');
				$keywords = Autumn::app()->request->getPost('keywords');
				if(strlen($by_id) == 13)
				{
					$m_index = new M_index;
					$m_index->deleteIndex($by_id);
					foreach (explode(' ', $keywords) as $v)
					{
						if(trim($v) == '')
						{
							continue;
						}
						$dc_id = $this->m_dictionary->getId($v, true);
						if($dc_id && ! $m_index->exist($dc_id, $by_id))
						{
							$m_index->insert(array(
								'dc_id' => $dc_id,
								'by_id' => $by_id
								));
						}
					}
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

}