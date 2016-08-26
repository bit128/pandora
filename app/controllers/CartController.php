<?php
/**
* 购物车控制器
* ======
* @author 洪波
* @version 16.08.26
*/
namespace app\controllers;
use core\Controller;
use core\Request;
use core\Response;
use core\Criteria;
use library\RedisCache;
use app\models\M_cart;

class CartController extends Controller
{

	private $m_cart;

	public function init()
	{
		$this->m_cart = new M_cart;
	}

	/**
	* 添加商品到购物车中
	* ======
	* @param $user_id 	用户id
	* @param $token 	令牌
	* @param $pd_id 	商品id
	* @param $st_id 	库存id
	* @param $cr_count 	数量
	* ======
	* @author 洪波
	* @version 16.08.26
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
				$st_id = Request::inst()->getPost('st_id');
				$cr_count = Request::inst()->getPost('cr_count', 1);
				//获取商品信息
				$m_product = new \app\models\M_product;
				$product = $m_product->get($pd_id);
				if($product)
				{
					//获取商品库存信息
					$m_stock = new \app\models\M_stock;
					$stock = $m_stock->get($st_id);
					if($stock)
					{
						//判断有无相同库存
						if($cart = $this->m_cart->matchItem($user_id, $pd_id, $st_id))
						{
							$cr_count += $cart->cr_count;
							if($cr_count <= $stock->st_count)
							{
								$cr_id = $cart->cr_id;
								$cart->cr_count = $cr_count;
								$cart->save();
								$response->setResult($cr_id, Response::RES_SUCCESS);
							}
							else
							{
								$response->setError('库存不足', Response::RES_NOHAS);
							}
						}
						else
						{
							if($cr_count <= $stock->st_count)
							{
								$data = array(
									'cr_count' => $cr_count,
									'cr_price' => $stock->st_price,
									'cr_time' => time(),
									'pd_id' => $pd_id,
									'st_id' => $st_id,
									'user_id' => $user_id
									);
								if($cr_id = $this->m_cart->insert($data))
								{
									$response->setResult($cr_id, Response::RES_SUCCESS);
								}
								else
								{
									$response->setError('添加失败', Response::RES_FAIL);
								}
							}
							else
							{
								$response->setError('库存不足', Response::RES_NOHAS);
							}
						}
					}
					else
					{
						$response->setError('库存不存在', Response::RES_NOHAS);
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
	* 获取购物车商品列表
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
				$offset = Request::inst()->getPost('offset', 0);
				$limit = Request::inst()->getPost('limit', 99);
				$result = $this->m_cart->getProductList($offset, $limit, $user_id, '');
				$response->setResult($result, Response::RES_SUCCESS);
			}
			else
			{
				$response->setError('令牌无效', Response::RES_TOKENF);
			}
			$response->json();
		}
	}

	/**
	* 从购物车中删除商品
	* ======
	* @author 洪波
	* @version 16.08.26
	*/
	public function actionDelete()
	{
		if(Request::inst()->isPostRequest())
		{
			$response = new Response;
			$user_id = Request::inst()->getPost('user_id');
			$token = Request::inst()->getPost('token');
			if(RedisCache::model('token')->check($user_id, $token))
			{
				$cr_id = Request::inst()->getPost('cr_id');
				$cart = $this->m_cart->get($cr_id);
				if($cart)
				{
					if($cart->user_id == $user_id)
					{
						$this->m_cart->delete($cr_id);
						$response->setResult('删除成功', Response::RES_SUCCESS);
					}
					else
					{
						$response->setError('越权操作', Response::RES_REFUSE);
					}
				}
				else
				{
					$response->setError('参数错误', Response::RES_PARAMF);
				}
			}
			else
			{
				$response->setError('令牌无效', Response::RES_TOKENF);
			}
			$response->json();
		}
	}
}