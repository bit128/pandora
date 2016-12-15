<?php
/**
* 后台控制器
* ======
* @author 洪波
* @version 16.07.29
*/
namespace app\controllers;
use core\Autumn;
use core\Criteria;

class HomeController extends \core\Controller
{

	public function init()
	{
		if(! Autumn::app()->request->getSession('am_account'))
		{
			header("Location:/admin/loginPage");
		}
	}

	/**
	* 控制台
	* ======
	* @author 洪波
	* @version 16.07.29
	*/
	public function actionIndex()
	{
		Autumn::app()->view->render('index');
	}

	/**
	* 管理员页面
	* ======
	* @author 洪波
	* @version 16.07.29
	*/
	public function actionAdmin()
	{
		$m_admin = new \app\models\M_admin;
		$page = Autumn::app()->request->getQuery('page', 1);
		$limit = 10;
		$offset = ($page - 1) * $limit;
		$result = $m_admin->getList($offset, $limit);
		//分页
		$url = '/home/admin';
		$pages = new \library\Pagination($result['count'], $limit, $page, $url);

		$data = array(
			'admin_list' => $result['result'],
			'pages' => $pages->build()
			);
		Autumn::app()->view->render('admin', $data);
	}

	/**
	* 用户管理页面
	* ======
	* @author 洪波
	* @version 16.08.02
	*/
	public function actionUser()
	{
		$m_user = new \app\models\M_user;
		$page = Autumn::app()->request->getQuery('page', 1);
		$status = Autumn::app()->request->getQuery('s', 1);
		$keyword = Autumn::app()->request->getQuery('k');
		$limit = 10;
		$offset = ($page - 1) * $limit;
		$url = '/home/user/s/'.$status;
		$criteria = new Criteria;
		$criteria->add('user_status', $status);
		if($keyword != '')
		{
			$criteria->addCondition("user_phone='{$keyword}' OR user_email='{$keyword}' OR user_name like '%{$keyword}%'");
			$url .= '/k/' . $keyword;
		}
		$result = $m_user->getList($offset, $limit, $criteria);
		//分页
		$pages = new \library\Pagination($result['count'], $limit, $page, $url);

		$data = array(
			'status' => $status,
			'keyword' => $keyword,
			'count' => $result['count'],
			'user_list' => $result['result'],
			'pages' => $pages->build()
			);
		Autumn::app()->view->render('user', $data);
	}

	/**
	* 用户详情
	* ======
	* @author 洪波
	* @version 16.08.02
	*/
	public function actionUserDetail()
	{
		$user_id = Autumn::app()->request->getQuery('id');
		if(strlen($user_id) == 13)
		{
			$m_user = new \app\models\M_user;
			$user = $m_user->get($user_id);
			if($user)
			{
				$data = array(
					'user' => $user
					);
				Autumn::app()->view->render('user_detail', $data);
			}
		}
	}

	/**
	* 内容管理页面
	* ======
	* @author 洪波
	* @version 16.07.29
	*/
	public function actionContent()
	{
		Autumn::app()->view->render('content');
	}

	/**
	* 内容详情页面
	* ======
	* @author 洪波
	* @version 16.08.01
	*/
	public function actionContentDetail()
	{
		$ct_id = Autumn::app()->request->getParam('id');
		if(strlen($ct_id) == 13)
		{
			$data = array(
				'ct_id' => $ct_id
				);
			Autumn::app()->view->render('content_detail', $data);
		}
	}

	public function actionContentNote()
	{
		$ct_id = Autumn::app()->request->getQuery('id');
		$status = Autumn::app()->request->getQuery('s', 0);
		$page = Autumn::app()->request->getQuery('page', 1);
		$limit = 10;
		$offset = ($page - 1) * $limit;

		$criteria = new Criteria;
		$criteria->add('ct_id', $ct_id);
		if ($status != -1)
			$criteria->add('tn_status', $status);
		$m_note = new \app\models\M_content_note;
		$result = $m_note->getList($offset, $limit, $criteria);
		//分页
		$url = '/home/contentNote';
		$pages = new \library\Pagination($result['count'], $limit, $page, $url);

		$data = array(
			'ct_id' => $ct_id,
			'status' => $status,
			'count' => $result['count'],
			'result' => $result['result'],
			'pages' => $pages->build()
		);
		Autumn::app()->view->render('content_note', $data);
	}

	/**
	* 搜索词库管理页面
	* ======
	* @author 洪波
	* @version 16.08.07
	*/
	public function actionDictionary()
	{
		$m_dictionary = new \app\models\M_dictionary;
		$page = Autumn::app()->request->getQuery('page', 1);
		$type = Autumn::app()->request->getQuery('t', -1);
		$sort = (int) Autumn::app()->request->getQuery('s', 0);
		$keyword = Autumn::app()->request->getQuery('k');
		$limit = 10;
		$offset = ($page - 1) * $limit;
		//查询数据列表
		$criteria = new Criteria;
		if($type != -1)
		{
			$criteria->add('dc_type', $type);
		}
		if($keyword != '')
		{
			$criteria->add('dc_keyword', $keyword);
		}
		$criteria->offset = $offset;
		$criteria->limit = $limit;
		$sort_arr = array('dc_time desc', 'dc_count desc');
		$criteria->order = $sort_arr[$sort];
		$result = $m_dictionary->getList($offset, $limit, $criteria);
		//分页
		$url = '/home/dictionary/t/' . $type . '/s/' . $sort;
		if($keyword != '')
		{
			$url .= '/k/' . $keyword;
		}
		$pages = new \library\Pagination($result['count'], $limit, $page, $url);

		$data = array(
			'type' => $type,
			'sort' => $sort,
			'keyword' => $keyword,
			'count' => $result['count'],
			'dictionary_list' => $result['result'],
			'pages' => $pages->build()
			);
		Autumn::app()->view->render('dictionary', $data);
	}

	/**
	* 商品列表页面
	* ======
	* @author 洪波
	* @version 16.08.04
	*/
	public function actionProduct()
	{
		$m_product = new \app\models\M_product;
		$page = Autumn::app()->request->getQuery('page', 1);
		$status = Autumn::app()->request->getQuery('s', -1);
		$keyword = Autumn::app()->request->getQuery('k');
		$limit = 10;
		$offset = ($page - 1) * $limit;
		$url = '/home/product/s/'.$status;
		$criteria = new Criteria;
		if($status != -1)
		{
			$criteria->add('pd_status', $status);
		}
		if($keyword != '')
		{
			$criteria->addCondition("pd_name like '%{$keyword}%'");
			$url .= '/k/' . $keyword;
		}
		$result = $m_product->getList($offset, $limit, $criteria);
		//分页
		$pages = new \library\Pagination($result['count'], $limit, $page, $url);

		$data = array(
			'status' => $status,
			'keyword' => $keyword,
			'count' => $result['count'],
			'product_list' => $result['result'],
			'pages' => $pages->build()
			);
		Autumn::app()->view->render('product', $data);
	}

	/**
	* 订单管理页面
	* ======
	* @author 洪波
	* @version 16.09.11
	*/
	public function actionOrder()
	{
		$m_order = new \app\models\M_order;
		$page = Autumn::app()->request->getQuery('page', 1);
		$status = Autumn::app()->request->getQuery('s', 2);
		$keyword = Autumn::app()->request->getQuery('k');
		$limit = 10;
		$offset = ($page - 1) * $limit;
		$url = '/home/order/s/'.$status;
		$criteria = new Criteria;
		$criteria->add('od_status', $status);
		if($keyword != '')
		{
			$criteria->add('od_id', $keyword);
		}
		$result = $m_order->getList($offset, $limit, $criteria);
		//分页
		$pages = new \library\Pagination($result['count'], $limit, $page, $url);

		$data = array(
			'status' => $status,
			'keyword' > $keyword,
			'count' => $result['count'],
			'order_list' => $result['result'],
			'pages' => $pages->build()
			);
		Autumn::app()->view->render('order', $data);
	}

	/**
	* 订单详情页面
	* ======
	* @author 洪波
	* @version 16.09.11
	*/
	public function actionOrderDetail()
	{
		$od_id = Autumn::app()->request->getParam('id');
		if(strlen($od_id) == 16)
		{
			$m_order = new \app\models\M_order;
			$m_cart = new \app\models\M_cart;
			$m_user = new \app\models\M_user;

			$order = $m_order->get($od_id);
			$product_list = $m_cart->getProductList(0, 99, '', $od_id);
			$user = $m_user->get($order->user_id);

			$data = array(
				'order' => $order,
				'user' => $user,
				'product_list' => $product_list['result']
				);
			Autumn::app()->view->render('order_detail', $data);
		}
	}

	/**
	* 库存管理页面
	* ======
	* @author 洪波
	* @version 16.08.06
	*/
	public function actionStock()
	{
		$pd_id = Autumn::app()->request->getQuery('id');
		if(strlen($pd_id) == 13)
		{
			$m_stock = new \app\models\M_stock;
			$page = Autumn::app()->request->getQuery('page', 1);
			$limit = 10;
			$offset = ($page - 1) * $limit;
			$criteria = new Criteria;
			$criteria->add('pd_id', $pd_id);
			$result = $m_stock->getList($offset, $limit, $criteria);
			//分页
			$url = '/home/stock/id/' . $pd_id;
			$pages = new \library\Pagination($result['count'], $limit, $page, $url);
			
			$data = array(
				'pd_id' => $pd_id,
				'stock_list' => $result['result'],
				'pages' => $pages->build()
				);
			Autumn::app()->view->render('stock', $data);
		}
	}

	/**
	* 相册
	* ======
	* @author 洪波
	* @version 16.08.04
	*/
	public function actionAlbum()
	{
		$by_id = Autumn::app()->request->getQuery('id');
		if(strlen($by_id) == 13)
		{
			$m_album = new \app\models\M_album;
			$criteria = new Criteria;
			$criteria->add('by_id', $by_id);
			$criteria->order = 'al_sort asc';
			$offset = 0;
			$limit = 60;
			$result = $m_album->getList($offset, $limit, $criteria);
			$data = array(
				'by_id' => $by_id,
				'al_type' => Autumn::app()->request->getQuery('t'),
				'count' => $result['count'],
				'album_list' => $result['result']
				);
			Autumn::app()->view->render('album', $data);
		}
	}

	/**
	* 配置项（结构化数据管理）
	* ======
	* @author 洪波
	* @version 16.08.13
	*/
	public function actionStruct()
	{
		Autumn::app()->view->render('struct');
	}
}