<?php
/**
* 主站控制器
* ======
* @author 洪波
* @version 16.09.21
*/
namespace app\controllers;
use core\Autumn;

class SiteController extends \core\web\Controller {

	private $view;
	
	public function init() {
		$this->view = \core\web\View::layout('layout_site');
	}

	/**
	 * 站点首页面
	 */
	public function actionIndex() {
		$page = Autumn::app()->request->getQuery('page', 1);
		$limit = 20;
		$offset = ($page - 1) * $limit;
		$main_list = $this->m_channel->getContentList($offset, $limit, ['59cdcf31d4f84'], [2,3], 60);
		$pages = new \core\tools\Pagination($main_list['count'], $limit, $page, '/site/index');
		$data = [
			'main_list' => $main_list['result'],
			'blog_list' => $this->m_channel->getContentList(0, 10, '59e98b4535276'),
			'pages' => $pages->build()
		];
		$this->view->render('index', $data);
	}

	/**
	 * 内容详情
	 */
	public function actionDetail($id) {
		$contents = $this->m_channel->get($id);
		if ($contents) {
			$data = [
				'contents' => $contents,
				'blog_list' => $this->m_channel->getContentList(0, 10, '59e98b4535276')
			];
			$this->view->render('detail', $data);
		}
	}

	/**
	 * 重点课堂页面
	 */
	public function actionStudy() {
		$page = Autumn::app()->request->getQuery('page', 1);
		$limit = 20;
		$offset = ($page - 1) * $limit;
		$main_list = $this->m_channel->getSimpleList($offset, $limit, '59f00c834650c');
		$pages = new \core\tools\Pagination($main_list['count'], $limit, $page, '/site/study');
		$data = [
			'main_list' => $main_list['result'],
			'pages' => $pages->build()
		];
		$this->view->render('study', $data);
	}

	/**
	 * 重点课堂 - 具体课程
	 */
	public function actionStudyDetail($id, $sid) {
		if (strlen($id) == 13) {
			$study = $this->m_channel->get($id);
			if ($study) {
				$study = $study->toArray();
				$study['cn_data'] = json_decode($study['cn_data']);
				$menus = $this->m_channel->getContentList(0, 99, $id, [2,3], 1, 1);
				$sid = $sid == '' ? $menus['result'][0]->cn_id : $sid;
				$data = [
					'id' => $id,
					'sid' => $sid,
					'study' => $study,
					'menus' => $menus['result'],
					'contents' => $this->m_channel->getContent($sid)
				];
				$this->view->render('study_detail', $data);
			} else {
				Autumn::app()->exception->throws('你要找的课程可能不存在，或者被删除了～');
			}
		} else {
			$this->actionNotFound();
		}
	}

	/**
	 * 实验室页面
	 */
	public function actionLab() {
		$pj_id = Autumn::app()->request->getQuery('pj');
		$page = Autumn::app()->request->getQuery('page', 1);
		$limit = 20;
		$offset = ($page - 1) * $limit;
		//获取项目列表
		$projects = $this->m_channel->getContentList(0, 10, '59f7f2fee27ea',[1,2,3]);
		if ($pj_id == '' && $projects['count'] > 0) {
			$pj_id = $projects['result'][0]->cn_id;
		}
		//获取内容
		$contents = $this->m_channel->getContentList($offset, $limit, $pj_id);
		//内容分页
		$pages = new \core\tools\Pagination($contents['count'], $limit, $page, '/site/lab/pj/'.$pj_id);
		$data = [
			'pj_id' => $pj_id,
			'projects' => $projects['result'],
			'contents' => $contents['result'],
			'pages' => $pages->build()
		];
		$this->view->render('lab', $data);
	}

	/**
	 * Autumn框架专题
	 */
	public function actionAutumn() {
		$ids = Autumn::app()->request->getQuery('id', '59eedaea65567');
		$contents = $this->m_channel->getContent($ids);
		if ($contents !== false) {
			$data = [
				'contents' => $contents,
				'menus' => $this->m_channel->getContentList(0, 99, '59eedaceef30b', [2,3], 1, 1),
				'ids' => $ids
			];
			$this->view->render('autumn', $data);
		}
		
	}
}