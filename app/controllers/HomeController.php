<?php
/**
* 后台控制器
* ======
* @author 洪波
* @version 16.07.29
*/
namespace app\controllers;
use core\Controller;
use core\View;
use core\Request;
use core\Criteria;

class HomeController extends Controller
{

	public function init()
	{
		if(! Request::inst()->getSession('am_account'))
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
		View::layout()->render('index');
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
		$page = Request::inst()->getQuery('page', 1);
		$limit = 10;
		$offset = ($page - 1) * $limit;
		$result = $m_admin->getList($offset, $limit);
		//分页
		$url = '/site/admin';
		$pages = new \library\Pagination($result['count'], $limit, $page, $url);

		$data = array(
			'admin_list' => $result['result'],
			'pages' => $pages->build()
			);
		View::layout()->render('admin', $data);
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
		$page = Request::inst()->getQuery('page', 1);
		$status = Request::inst()->getQuery('s', 1);
		$keyword = Request::inst()->getQuery('k');
		$limit = 10;
		$offset = ($page - 1) * $limit;
		$url = '/site/user/s/'.$status;
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
		View::layout()->render('user', $data);
	}

	/**
	* 用户详情
	* ======
	* @author 洪波
	* @version 16.08.02
	*/
	public function actionUserDetail()
	{
		$user_id = Request::inst()->getQuery('id');
		if(strlen($user_id) == 13)
		{
			$m_user = new \app\models\M_user;
			$user = $m_user->get($user_id);
			if($user)
			{
				$data = array(
					'user' => $user
					);
				View::layout()->render('user_detail', $data);
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
		View::layout()->render('content');
	}

	/**
	* 内容详情页面
	* ======
	* @author 洪波
	* @version 16.08.01
	*/
	public function actionContentDetail()
	{
		$ct_id = Request::inst()->getParam('id');
		if(strlen($ct_id) == 13)
		{
			$data = array(
				'ct_id' => $ct_id
				);
			View::layout()->render('content_detail', $data);
		}
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
		$page = Request::inst()->getQuery('page', 1);
		$type = Request::inst()->getQuery('t', -1);
		$sort = (int) Request::inst()->getQuery('s', 0);
		$keyword = Request::inst()->getQuery('k');
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
		$url = '/site/dictionary/t/' . $type . '/s/' . $sort;
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
		View::layout()->render('dictionary', $data);
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
		$page = Request::inst()->getQuery('page', 1);
		$status = Request::inst()->getQuery('s', -1);
		$keyword = Request::inst()->getQuery('k');
		$limit = 10;
		$offset = ($page - 1) * $limit;
		$url = '/site/product/s/'.$status;
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
		View::layout()->render('product', $data);
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
		$page = Request::inst()->getQuery('page', 1);
		$status = Request::inst()->getQuery('s', 2);
		$keyword = Request::inst()->getQuery('k');
		$limit = 10;
		$offset = ($page - 1) * $limit;
		$url = '/site/order/s/'.$status;
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
		View::layout()->render('order', $data);
	}

	/**
	* 库存管理页面
	* ======
	* @author 洪波
	* @version 16.08.06
	*/
	public function actionStock()
	{
		$pd_id = Request::inst()->getQuery('id');
		if(strlen($pd_id) == 13)
		{
			$m_stock = new \app\models\M_stock;
			$page = Request::inst()->getQuery('page', 1);
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
			View::layout()->render('stock', $data);
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
		$by_id = Request::inst()->getQuery('id');
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
				'al_type' => Request::inst()->getQuery('t'),
				'count' => $result['count'],
				'album_list' => $result['result']
				);
			View::layout()->render('album', $data);
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
		View::layout()->render('struct');
	}
}