<?php
/**
* 订单控制器
* ======
* @author 洪波
* @version 16.08.27
*/
namespace app\controllers;
use core\Autumn;
use core\Criteria;
use library\RedisCache;
use app\models\M_order;

class OrderController extends \core\Controller
{

	private $m_order;

	public function init()
	{
		$this->m_order = new M_order;
	}

	/**
	* 创建订单
	* ======
	* @author 洪波
	* @version 16.08.27
	*/
	public function actionAdd()
	{
		if(Autumn::app()->request->isPostRequest())
		{
			$user_id = Autumn::app()->request->getPost('user_id');
			$token = Autumn::app()->request->getPost('token');
			if(RedisCache::model('token')->check($user_id, $token))
			{
				$od_note = Autumn::app()->request->getPost('od_note');
				$m_cart = new \app\models\M_cart;
				$m_stock = new \app\models\M_stock;
				//获取收藏夹商品列表
				$carts = $m_cart->getAllList($user_id);
				if($carts)
				{
					$falg = true;
					$total = 0;
					$items = array();
					//开启事务
					Autumn::app()->mysqli->beginTransaction();
					//库存处理
					foreach ($carts as $v)
					{
						//统计总价
						$total += $v->cr_discount * $v->cr_price * $v->cr_count;
						//订单成员id
						$items[] = $v->cr_id;
						//变更库存
						if(! $m_stock->cutStock($v->st_id, $v->cr_count))
						{
							$falg = false;
							//回滚库存
							Autumn::app()->mysqli->rollback();
							Autumn::app()->response->setResult(\core\Response::RES_FAIL, '', '库存不足或参数错误');
							break;
						}
					}
					//创建订单
					if($falg)
					{
						//提交库存事务
						Autumn::app()->mysqli->commit();

						$od_id = $this->m_order->newOrderId();
						$data = array(
							'od_id' => $od_id,
							'od_total' => $total,
							'od_ctime' => $oc_ctime = time(),
							'od_note' => $od_note,
							'od_status' => M_order::STATUS_CREATE,
							'user_id' => $user_id
							);
						if($this->m_order->insert($data))
						{
							//关联订单成员
							$m_cart->unionOrder($od_id, $items);
							Autumn::app()->response->setResult($od_id);
						}
						else
						{
							Autumn::app()->response->setResult(\core\Response::RES_FAIL);
						}
					}
				}
				else
				{
					Autumn::app()->response->setResult(\core\Response::RES_NOHAS, '', '购物车中没有商品');
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
	* 获取我的订单列表
	* ======
	* @author 洪波
	* @version 16.08.27
	*/
	public function actionGetList()
	{
		if(Autumn::app()->request->isPostRequest())
		{
			$user_id = Autumn::app()->request->getPost('user_id');
			$token = Autumn::app()->request->getPost('token');
			if(RedisCache::model('token')->check($user_id, $token))
			{
				$offset = Autumn::app()->request->getPost('offset');
				$limit = Autumn::app()->request->getPost('limit');
				$od_status = Autumn::app()->request->getPost('od_status');

				$criteria = new Criteria;
				$criteria->add('user_id', $user_id);
				if($od_status)
				{
					$criteria->add('od_status', $od_status);
				}
				else
				{
					$criteria->add('od_status', M_order::STATUS_CLOSE, '!=');
				}
				$criteria->order = 'od_ctime desc';
				$result = $this->m_order->getList($offset, $limit, $criteria);
				Autumn::app()->response->setResult($result);
			}
			else
			{
				Autumn::app()->response->setResult(\core\Response::RES_TOKENF);
			}
			Autumn::app()->response->json();
		}
	}
}