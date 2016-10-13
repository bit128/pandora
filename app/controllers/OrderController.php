<?php
/**
* 订单控制器
* ======
* @author 洪波
* @version 16.08.27
*/
namespace app\controllers;
use core\Controller;
use core\Request;
use core\Response;
use core\Criteria;
use library\RedisCache;
use app\models\M_order;

class OrderController extends Controller
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
		if(Request::inst()->isPostRequest())
		{
			$response = new Response;
			$user_id = Request::inst()->getPost('user_id');
			$token = Request::inst()->getPost('token');
			if(RedisCache::model('token')->check($user_id, $token))
			{
				$od_note = Request::inst()->getPost('od_note');
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
					\core\Orm::model($this->m_order->table_name)->getDb()->beginTransaction();
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
							\core\Orm::model($this->m_order->table_name)->getDb()->rollback();

							$response->setError('库存不足，或者参数错误', Response::RES_FAIL);
							break;
						}
					}
					//创建订单
					if($falg)
					{
						//提交库存事务
						\core\Orm::model($this->m_order->table_name)->getDb()->commit();

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
							$response->setResult($od_id, Response::RES_SUCCESS);
						}
						else
						{
							$falg = false;
							$response->setError('创建失败', Response::RES_FAIL);
						}
					}
				}
				else
				{
					$response->setError('购物车中没有商品', Response::RES_NOHAS);
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
	* 获取我的订单列表
	* ======
	* @author 洪波
	* @version 16.08.27
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
				$offset = Request::inst()->getPost('offset');
				$limit = Request::inst()->getPost('limit');
				$od_status = Request::inst()->getPost('od_status');

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
				$criteria->order = 'order_ctime desc';
				$response->setResult($this->m_order->getList($offset, $limit, $criteria), Response::RES_SUCCESS);
			}
			else
			{
				$response->setError('令牌无效', Response::RES_TOKENF);
			}
			$response->json();
		}
	}
}