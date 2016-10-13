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
use core\Criteria;
use app\models\M_dictionary;
use app\models\M_index;
use app\models\M_admin;

class DictionaryController extends Controller
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
		if(Request::inst()->isPostRequest())
		{
			$response = new Response;
			if(M_admin::checkRole(M_admin::ROLE_CONTENT))
			{
				$dc_keyword = Request::inst()->getPost('dc_keyword');
				$dc_type = (int) Request::inst()->getPost('dc_type', M_dictionary::TYPE_NORMAL);
				if($dc_keyword != '' && ! $this->m_dictionary->getId($dc_keyword))
				{
					if($this->m_dictionary->add($dc_keyword, $dc_type))
					{
						$response->setResult('创建成功', Response::RES_SUCCESS);
					}
					else
					{
						$response->serError('创建失败', Response::RES_FAIL);
					}
				}
			}
			else
			{
				$response->setError('无权操作', Response::RES_REFUSE);
			}
			$response->json();
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
		$keyword = urldecode(Request::inst()->getParam('keyword'));
		if($keyword != '')
		{
			$response = new Response;
			$criteria = new Criteria;
			$criteria->addCondition("dc_keyword like '%{$keyword}%'");
			$criteria->order = 'dc_count desc';
			$response->setResult($this->m_dictionary->getList(0, 10, $criteria), Response::RES_SUCCESS);
			$response->json();
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
		if(Request::inst()->isPostRequest())
		{
			$response = new Response;
			if(M_admin::checkRole(M_admin::ROLE_CONTENT))
			{
				$dc_id = Request::inst()->getPost('dc_id');
				if($this->m_dictionary->delete($dc_id))
				{
					//删除索引
					$m_index = new M_index;
					$m_index->deleteByDic($dc_id);
					$response->setResult('删除成功', Response::RES_SUCCESS);
				}
				else
				{
					$response->serError('删除失败', Response::RES_FAIL);
				}
			}
			else
			{
				$response->setError('无权操作', Response::RES_REFUSE);
			}
			$response->json();
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
		if(Request::inst()->isPostRequest())
		{
			$response = new Response;
			if(M_admin::checkRole(M_admin::ROLE_CONTENT))
			{
				$by_id = Request::inst()->getPost('by_id');
				$keywords = Request::inst()->getPost('keywords');
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
					$response->setResult('操作成功', Response::RES_SUCCESS);
				}
				else
				{
					$response->setError('参数错误', Response::RES_PARAMF);
				}
			}
			else
			{
				$response->setError('无权操作', Response::RES_REFUSE);
			}
			$response->json();
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
		$by_id = Request::inst()->getParam('id');
		if(strlen($by_id) == 13)
		{
			$response = new Response;
			$m_index = new M_index;
			$response->setResult($m_index->getIndex($by_id), Response::RES_SUCCESS);
			$response->json();
		}
	}

}