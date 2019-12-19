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

class HomeController extends \core\web\Controller {

	public function init() {
		if(! Autumn::app()->request->getSession('am_account')) {
			$this->redirect('/admin/loginPage');
		}
	}

	/**
	* 控制台
	* ======
	* @author 洪波
	* @version 16.07.29
	*/
	public function actionIndex() {
		$this->renderView('index');
	}

	/**
	* 用户管理页面
	* ======
	* @author 洪波
	* @version 16.08.02
	*/
	public function actionUser() {
		$t_user = new \app\models\T_user;
		$page = $this->getQuery('page', 1);
		$status = $this->getQuery('s', 1);
		$keyword = $this->getQuery('k');
		$limit = 10;
		$offset = ($page - 1) * $limit;
		$url = '/home/user/s/'.$status;
		$criteria = new Criteria;
		$criteria->offset = $offset;
		$criteria->limit = $limit;
		$criteria->add('user_status', $status);
		if($keyword != '') {
			$criteria->addCondition("user_phone='{$keyword}' OR user_email='{$keyword}' OR user_name like '%{$keyword}%'");
			$url .= '/k/' . $keyword;
		}
		$result = $t_user->getList($criteria);
		//分页
		$pages = new \core\tools\Pagination($result['count'], $limit, $page, $url);

		$data = array(
			'status' => $status,
			'keyword' => $keyword,
			'count' => $result['count'],
			'user_list' => $result['result'],
			'pages' => $pages->build()
			);
		$this->renderView('user', $data);
	}

	/**
	* 用户详情
	* ======
	* @author 洪波
	* @version 16.08.02
	*/
	public function actionUserDetail() {
		$user_id = $this->getQuery('id');
		if(strlen($user_id) == 13) {
			$t_user = new \app\models\T_user;
			$user = $t_user->get($user_id);
			if($user) {
				$data = array(
					'user' => $user
					);
				$this->renderView('user_detail', $data);
			}
		}
	}

	/**
	* 栏目内容管理
	* ======
	* @author 洪波
	* @version 17.09.15
	*/
	public function actionChannel() {
		$fid = $this->getQuery('fid', '0');
		$status = (int) $this->getQuery('s', 0);
		$order = (int) $this->getQuery('o', 0);
		$keyword = $this->getQuery('k', '');
		$page = $this->getQuery('page', 1);
		//查询条件
		$criteria = new Criteria;
		$criteria->add('cn_fid', $fid);
		if ($status > 0) {
			$criteria->add('cn_status', $status);
		}
		if ($keyword != '') {
			$criteria->addCondition("cn_name like '%{$keyword}%'");
		}
		$criteria->limit = 10;
		$criteria->offset = ($page - 1) * $criteria->limit;
		$criteria->order = ['cn_sort desc','cn_sort asc'][$order];
		//获取栏目列表
		$result = $this->model('t_channel')->getList($criteria);
		//分页
		$pages = new \core\tools\Pagination($result['count'], $criteria->limit, $page,
			Autumn::app()->route->reUrl(['page'=>null]));
		$data = [
			'cn_fid' => $fid,
			'status' => $status,
			'order' => $order,
			'keyword' => $keyword,
			'result' => $result['result'],
			'breadcrumb' => $this->model('t_channel')->breadcrumb($fid),
			'pages' => $pages->build()
		];
		$this->renderView('channel', $data);
	}

	/**
	* 内容详情页面
	* ======
	* @author 洪波
	* @version 16.08.01
	*/
	public function actionContent($id, $model = 'channel') {
		if($id && \in_array($model, \app\models\I_html::MATCH_MODEL)) {
			$criteria = new Criteria;
			$criteria->add('file_bid', $id);
			$criteria->offset = 0;
			$criteria->limit = 99;
			$file_list = $this->model('t_file')->getList($criteria);
			$data = [
				'id' => $id,
				'model' => $model,
				'file_list' => $file_list
			];
			$this->renderView('content', $data);
		}
	}

	/**
	* 关键词管理页面
	* ======
	* @author 洪波
	* @version 16.09.23
	*/
	public function actionKeyword() {
		$keyword = $this->getQuery('k');
		$sort = $this->getQuery('s', 0);
		$page = $this->getQuery('page', 1);
		//查询数据列表
		$criteria = new Criteria;
		$criteria->limit = 10;
		$criteria->offset = ($page - 1) * $criteria->limit;
		$criteria->order = ['kw_name asc','kw_time desc','kw_use desc','kw_search desc'][$sort];
		if($keyword != '') {
			$criteria->addCondition("kw_name like '%{$keyword}%'");
		};
		
		$result = $this->model('t_keyword')->getList($criteria);
		//分页
		$pages = new \core\tools\Pagination($result['count'], $criteria->limit, $page,
			Autumn::app()->route->reUrl(['page'=>null]));
		$data = array(
			'keyword' => $keyword,
			'sort' => $sort,
			'result' => $result['result'],
			'pages' => $pages->build()
			);
		$this->renderView('keyword', $data);
	}

	/**
	* 资源
	* ======
	* @author 洪波
	* @version 16.08.04
	*/
	public function actionFile() {
		$file_bid = $this->getQuery('bid');
		$avatar = $this->getQuery('avatar');
		$keyword = $this->getQuery('k');
		$page = $this->getQuery('page', 1);
		$page_uri = '/home/file';
		if ($avatar) {
			$page_uri .= '/avatar/' . $avatar;
		}
		$t_file= new \app\models\T_file;
		$criteria = new Criteria;
		if ($file_bid != '') {
			$criteria->add('file_bid', $file_bid);
		}
		if ($keyword != '') {
			$criteria->addCondition("file_name like '%{$keyword}%'");
		}
		$criteria->order = 'file_time desc';
		$criteria->limit = 10;
		$criteria->offset = ($page - 1) * $criteria->limit;
		$result = $t_file->getList($criteria);
		$pages = new \core\tools\Pagination($result['count'], $criteria->limit, $page,
			Autumn::app()->route->reUrl(['page'=>null]));
		$data = array(
			'file_bid' => $file_bid,
			'keyword' => $keyword,
			'avatar' => $avatar,
			'result' => $result,
			'pages' => $pages->build()
			);
		$this->renderView('file', $data);
	}
}