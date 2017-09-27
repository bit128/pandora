<?php
/**
* 后台控制器
* ======
* @author 洪波
* @version 16.07.29
*/
namespace app\controllers;
use core\Autumn;
use core\db\Criteria;

class HomeController extends \core\web\Controller
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
		$criteria->offset = $offset;
		$criteria->limit = $limit;
		$criteria->add('user_status', $status);
		if($keyword != '')
		{
			$criteria->addCondition("user_phone='{$keyword}' OR user_email='{$keyword}' OR user_name like '%{$keyword}%'");
			$url .= '/k/' . $keyword;
		}
		$result = $m_user->getList($criteria);
		//分页
		$pages = new \core\tools\Pagination($result['count'], $limit, $page, $url);

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
	* 栏目内容管理
	* ======
	* @author 洪波
	* @version 17.09.15
	*/
	public function actionChannel()
	{
		$fid = Autumn::app()->request->getQuery('fid', '0');
		$status = (int) Autumn::app()->request->getQuery('s', 0);
		$keyword = Autumn::app()->request->getQuery('k', '');
		$page = Autumn::app()->request->getQuery('page', 1);
		//查询条件
		$criteria = new Criteria;
		$criteria->add('cn_fid', $fid);
		if ($status > 0)
		{
			$criteria->add('cn_status', $status);
		}
		if ($keyword != '')
		{
			$criteria->addCondition("cn_name like '%{$keyword}%'");
		}
		$criteria->limit = 10;
		$criteria->offset = ($page - 1) * $criteria->limit;
		$criteria->order = 'cn_sort asc';
		//获取栏目列表
		$result = $this->m_channel->getList($criteria);
		//分页
		$pages = new \core\tools\Pagination($result['count'], $criteria->limit, $page,
			Autumn::app()->route->reUrl(['page'=>null]));

		$data = [
			'cn_fid' => $fid,
			'status' => $status,
			'keyword' => $keyword,
			'count' => $result['count'],
			'result' => $result['result'],
			'pages' => $pages->build()
		];
		Autumn::app()->view->render('channel', $data);
	}

	/**
	* 内容详情页面
	* ======
	* @author 洪波
	* @version 16.08.01
	*/
	public function actionContent()
	{
		$cn_id = Autumn::app()->request->getParam('id');
		if(strlen($cn_id) == 13)
		{
			//获取附件列表
			$m_file = new \app\models\M_file;
			$criteria = new Criteria;
			$criteria->add('file_bid', $cn_id);
			$criteria->offset = 0;
			$criteria->limit = 99;
			$file_list = $m_file->getList($criteria);
			$data = array(
				'cn_id' => $cn_id,
				'file_list' => $file_list
				);
			Autumn::app()->view->render('content', $data);
		}
	}

	/**
	* 关键词管理页面
	* ======
	* @author 洪波
	* @version 16.09.23
	*/
	public function actionKeyword()
	{
		$keyword = Autumn::app()->request->getQuery('k');
		$sort = Autumn::app()->request->getQuery('s', 0);
		$page = Autumn::app()->request->getQuery('page', 1);
		//查询数据列表
		$criteria = new Criteria;
		$criteria->limit = 10;
		$criteria->offset = ($page - 1) * $criteria->limit;
		$criteria->order = ['kw_name asc','kw_time desc','kw_use desc','kw_search desc'][$sort];
		if($keyword != '')
		{
			$criteria->addCondition("kw_name like '%{$keyword}%'");
		};
		
		$result = $this->m_keyword->getList($criteria);
		//分页
		$pages = new \core\tools\Pagination($result['count'], $criteria->limit, $page,
			Autumn::app()->route->reUrl(['page'=>null]));
		$data = array(
			'keyword' => $keyword,
			'sort' => $sort,
			'result' => $result['result'],
			'pages' => $pages->build()
			);
		Autumn::app()->view->render('keyword', $data);
	}

	/**
	* 资源
	* ======
	* @author 洪波
	* @version 16.08.04
	*/
	public function actionFile()
	{
		$file_bid = Autumn::app()->request->getQuery('bid');
		$avatar = Autumn::app()->request->getQuery('avatar');
		$keyword = Autumn::app()->request->getQuery('k');
		$page = Autumn::app()->request->getQuery('page', 1);
		if ($avatar)
		{
			$page_uri .= '/avatar/' . $avatar;
		}

		$m_file= new \app\models\M_file;
		$criteria = new Criteria;
		if ($file_bid != '')
		{
			$criteria->add('file_bid', $file_bid);
		}
		if ($keyword != '')
		{
			$criteria->addCondition("file_name like '%{$keyword}%'");
		}
		$criteria->order = 'file_time desc';
		$criteria->limit = 10;
		$criteria->offset = ($page - 1) * $criteria->limit;
		$result = $m_file->getList($criteria);
		$pages = new \core\tools\Pagination($result['count'], $criteria->limit, $page,
			Autumn::app()->route->reUrl(['page'=>null]));
		$data = array(
			'file_bid' => $file_bid,
			'keyword' => $keyword,
			'avatar' => $avatar,
			'result' => $result,
			'pages' => $pages->build()
			);
		Autumn::app()->view->render('file', $data);
	}
}