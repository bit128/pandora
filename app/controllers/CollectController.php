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
use library\RedisCache;
use app\models\M_collect;

class CollectController extends \core\Controller
{

	private $m_collect;

	public function init()
	{
		$this->m_collect = new M_collect;
	}

	/**
	* 添加商品到收藏夹
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
			if(RedisCache::model('token')->check($user_id, $token))
			{
				$pd_id = Autumn::app()->request->getPost('pd_id');
				$criteria = new Criteria;
				$criteria->add('pd_id', $pd_id);
				//判断商品是否存在
				$m_product = new \app\models\M_product;
				if($m_product->count($criteria))
				{
					$criteria->add('user_id', $user_id);
					if($this->m_collect->count($criteria))
					{
						Autumn::app()->response->setResult(\core\Response::RES_NOCHAN, '', '商品已经收藏过了');
					}
					else
					{
						$data = array(
							'pd_id' => $pd_id,
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
					Autumn::app()->response->setResult(Response::RES_NOHAS, '', '商品不存在');
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
	* 获取收藏夹商品列表
	* ======
	* @author 洪波
	* @version 16.08.18
	*/
	public function actionGetList()
	{
		if(Autumn::app()->request->isPostRequest())
		{
			$user_id = Autumn::app()->request->getPost('user_id');
			$token = Autumn::app()->request->getPost('token');
			if(RedisCache::model('token')->check($user_id, $token))
			{
				$offset = Autumn::app()->request->getPost('offset', 0);
				$limit = Autumn::app()->request->getPost('limit', 99);
				$result = $this->m_collect->getProductList($offset, $limit, $user_id);
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
			if(RedisCache::model('token')->check($user_id, $token))
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