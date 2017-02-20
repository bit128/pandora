<?php
/**
* 收藏夹控制器
* ======
* @author 洪波
* @version 16.08.18
*/
namespace app\controllers;
use core\Autumn;
use core\Criteria;
use app\models\M_collect;
use app\models\M_user;

class CollectController extends \core\Controller
{

	private $m_collect;
	private $m_user;

	public function init()
	{
		$this->m_collect = new M_collect;
		$this->m_user = new M_user;
	}

	/**
	* 添加对象到收藏夹
	* ======
	* @author 洪波
	* @version 16.08.18
	*/
	public function actionAdd()
	{
		if(Autumn::app()->request->isPostRequest())
		{
			$user_id = Autumn::app()->request->getPost('user_id');
			$token = Autumn::app()->request->getPost('token');
			if($this->m_user->checkToken($user_id, $token))
			{
				$cl_type = Autumn::app()->request->getPost('cl_type', M_collect::TYPE_CONTENT);
				$by_id = Autumn::app()->request->getPost('by_id');
				
				if($this->m_collect->exist($by_id, $user_id))
				{
					Autumn::app()->response->setResult(\core\Response::RES_NOCHAN, '', '已经收藏过了');
				}
				else
				{
					$data = array(
						'cl_type' => M_collect::TYPE_CONTENT,
						'by_id' => $by_id,
						'user_id' => $user_id,
						'cl_time' => time()
						);
					if($cl_id = $this->m_collect->insert($data))
					{
						Autumn::app()->response->setResult($cl_id);
					}
					else
					{
						Autumn::app()->response->setResult(\core\Response::RES_FAIL);
					}
				}
			}
			else
			{
				Autumn::app()->response->setResult(\core\Response::RES_TOKENF);
			}
			Autumn::app()->response->json();
		}
	}

	/**
	* 获取收藏夹内容列表
	* ======
	* @author 洪波
	* @version 16.08.18
	*/
	public function actionGetContentList()
	{
		if(Autumn::app()->request->isPostRequest())
		{
			$user_id = Autumn::app()->request->getPost('user_id');
			$token = Autumn::app()->request->getPost('token');
			if($this->m_user->checkToken($user_id, $token))
			{
				$offset = Autumn::app()->request->getPost('offset', 0);
				$limit = Autumn::app()->request->getPost('limit', 99);
				$result = $this->m_collect->getContentList($offset, $limit, $user_id);
				Autumn::app()->response->setResult($result);
			}
			else
			{
				Autumn::app()->response->setResult(\core\Response::RES_TOKENF);
			}
			Autumn::app()->response->json();
		}
	}

	/**
	* 根据实体id从收藏夹中删除商品
	* ======
	* @author 洪波
	* @version 16.08.26
	*/
	public function actionDeleteByEntry()
	{
		if(Autumn::app()->request->isPostRequest())
		{
			$user_id = Autumn::app()->request->getPost('user_id');
			$token = Autumn::app()->request->getPost('token');
			if($this->m_user->checkToken($user_id, $token))
			{
				$cl_type = Autumn::app()->request->getPost('cl_type', M_collect::TYPE_CONTENT);
				$by_id = Autumn::app()->request->getPost('by_id');
				
				if($this->m_collect->deleteByEntry($cl_type, $by_id, $user_id))
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
				Autumn::app()->response->setResult(\core\Response::RES_TOKENF);
			}
			Autumn::app()->response->json();
		}
	}

	/**
	* 从收藏夹中删除商品
	* ======
	* @author 洪波
	* @version 16.08.26
	*/
	public function actionDelete()
	{
		if(Autumn::app()->request->isPostRequest())
		{
			$user_id = Autumn::app()->request->getPost('user_id');
			$token = Autumn::app()->request->getPost('token');
			if($this->m_user->checkToken($user_id, $token))
			{
				$cl_id = Autumn::app()->request->getPost('cl_id');
				$collect = $this->m_collect->get($cl_id);
				if($collect)
				{
					if($collect->user_id == $user_id)
					{
						$this->m_collect->delete($cl_id);
						Autumn::app()->response->setResult(\core\Response::RES_OK);
					}
					else
					{
						Autumn::app()->response->setResult(\core\Response::RES_REFUSE);
					}
				}
				else
				{
					Autumn::app()->response->setResult(\core\Response::RES_PARAMF);
				}
			}
			else
			{
				Autumn::app()->response->setResult(\core\Response::RES_TOKENF);
			}
			Autumn::app()->response->json();
		}
	}
}