<?php
/**
* 收藏夹控制器
* ======
* @author 洪波
* @version 16.08.18
*/
namespace app\controllers;
use core\Controller;
use core\Request;
use core\Response;
use library\RedisCache;
use app\models\M_collect;

class CollectController extends Controller
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
		if(Request::inst()->isPostRequest())
		{
			$response = new Response;
			$user_id = Request::inst()->getPost('user_id');
			$token = Request::inst()->getPost('token');
			if(RedisCache::model('token')->check($user_id, $token))
			{
				$pd_id = Request::inst()->getPost('pd_id');
				$criteria = new Criteria;
				$criteria->add('pd_id', $pd_id);
				//判断商品是否存在
				$m_product = new M_product;
				if($m_product->count($criteria))
				{
					$criteria->add('user_id', $user_id);
					if($this->m_collect->count($criteria))
					{
						$this->setError('商品已经收藏过了', Response::RES_NOCHAN);
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
							$this->setResult($cl_id, Response::RES_SUCCESS);
						}
						else
						{
							$this->setError('创建失败', Response::RES_OPTF);
						}
					}
				}
				else
				{
					$response->setError('商品不存在', Response::RES_NOHAS);
				}
			}
			else
			{
				$response->setError('令牌无效', Response::RES_TOKENF);
			}
			$response->json();
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
		if(Request::inst()->isPostRequest())
		{
			$response = new Response;
			$user_id = Request::inst()->getPost('user_id');
			$token = Request::inst()->getPost('token');
			if(RedisCache::model('token')->check($user_id, $token))
			{
				//
			}
			else
			{
				$response->setError('令牌无效', Response::RES_TOKENF);
			}
			$response->json();
		}
	}
}