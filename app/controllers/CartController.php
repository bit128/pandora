<?php
/**
* 购物车控制器
* ======
* @author 洪波
* @version 16.08.26
*/
namespace app\controllers;
use core\Autumn;
use core\Criteria;
use library\RedisCache;
use app\models\M_cart;

class CartController extends \core\Controller
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
		if(Autumn::app()->request->isPostRequest())
		{
			$response = new Response;
			$user_id = Autumn::app()->request->getPost('user_id');
			$token = Autumn::app()->request->getPost('token');
			if(RedisCache::model('token')->check($user_id, $token))
			{
				$pd_id = Autumn::app()->request->getPost('pd_id');
				$st_id = Autumn::app()->request->getPost('st_id');
				$cr_count = Autumn::app()->request->getPost('cr_count', 1);
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
								Autumn::app()->response->setResult($cr_id);
							}
							else
							{
								Autumn::app()->response->setResult(\core\Response::RES_NOHAS, '', '库存不足');
							}
						}
						else
						{
							if($cr_count <= $stock->st_count)
							{
								$data = array(
									'cr_count' => $cr_count,
									'cr_price' => $stock->st_price,
									'cr_discount' => $stock->st_discount,
									'cr_time' => time(),
									'pd_id' => $pd_id,
									'st_id' => $st_id,
									'user_id' => $user_id
									);
								if($cr_id = $this->m_cart->insert($data))
								{
									Autumn::app()->response->setResult($cr_id);
								}
								else
								{
									Autumn::app()->response->setResult(\core\Response::RES_FAIL);
								}
							}
							else
							{
								Autumn::app()->response->setResult(\core\Response::RES_NOHAS, '', '库存不足');
							}
						}
					}
					else
					{
						Autumn::app()->response->setResult(\core\Response::RES_NOHAS, '', '库存不存在');
					}
				}
				else
				{
					Autumn::app()->response->setResult(\core\Response::RES_NOHAS, '', '商品不存在');
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
	* 获取购物车商品列表
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
				$result = $this->m_cart->getProductList($offset, $limit, $user_id, '');
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
	* 从购物车中删除商品
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
				$cr_id = Autumn::app()->request->getPost('cr_id');
				$cart = $this->m_cart->get($cr_id);
				if($cart)
				{
					if($cart->user_id == $user_id)
					{
						$this->m_cart->delete($cr_id);
						Autumn::app()->response->setResult(\core\Response::RES_OK);
					}
					else
					{
						Autumn::app()->response->setResult(\core\Response::RES_REFUSE, '', '越权操作');
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