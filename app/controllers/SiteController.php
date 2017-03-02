<?php
namespace app\controllers;
use core\Autumn;

/**
* 站点控制器示例
* ======
* @author 洪波
* @version 16.07.06
*/
class SiteController extends \core\web\Controller
{
	private $view;
	private $m_content;
	
	public function init()
	{
		$this->view = \core\web\View::layout('layout_site');
		$this->m_content = new \app\models\M_content;
	}

	/**
	* 用户注册／登录
	* ======
	* @author 洪波
	* @version 17.02.10
	*/
	public function actionUserCache()
	{
		if (Autumn::app()->request->isPostRequest())
		{
			$account = Autumn::app()->request->getPost('account');
			$password = Autumn::app()->request->getPost('password');
			$type = Autumn::app()->request->getPost('type');
			$m_user = new \app\models\M_user;
			if($type == 'register')
			{
				$info = array(
					'user_name' => Autumn::app()->request->getPost('user_name'),
				);
				//检查重名
				if(! $m_user->exist($account))
				{
					$token_info = $info;
					$info['user_email'] = $account;
					$info['user_password'] = md5($password);
					$info['user_ctime'] = time();
					$info['user_ltime'] = $info['user_ctime'];
					$info['user_status'] = \app\models\M_user::STATUS_NORMAL;
					//写入数据库
					$user_id = $m_user->insert($info, false);
					if(strlen($user_id) === 13)
					{
						//构建令牌
						$token = $m_user->buildToken($user_id, $info);
						//缓存登录信息
						Autumn::app()->request->setSession('user_id', $user_id);
						Autumn::app()->request->setSession('token', $token['token']);
						Autumn::app()->request->setSession('user_name', $info['user_name']);
						$this->redirect('/');
					}
					else
					{
						Autumn::app()->exception('抱歉！注册失败，请联系管理员.');
					}
				}
				else
				{
					Autumn::app()->exception('该账号已经注册过了.');
				}
			}
			else if ($type == 'login')
			{
				$user = $m_user->login($account, md5($password));
				if($user)
				{
					if ($user->user_status > \app\models\M_user::STATUS_LOCK)
					{
						$info = array(
							'user_ltime' => time(),
							'user_count' => ++ $user->user_count
						);
						//更新登录信息
						$user_id = $user->user_id;
						$m_user->update($user_id, $info);
						//构建令牌
						$token = $m_user->buildToken($user_id, $info);
						//缓存登录信息
						Autumn::app()->request->setSession('user_id', $user_id);
						Autumn::app()->request->setSession('token', $token['token']);
						Autumn::app()->request->setSession('user_name', $user->user_name);
						$this->redirect('/');
					}
					else
					{
						Autumn::app()->exception('账户被锁定');
					}
				}
				else
				{
					Autumn::app()->exception('用户名或密码错误');
				}
			}
		}
	}

	/**
	* 用户退出登录状态
	* ======
	* @author 洪波
	* @version 17.02.13
	*/
	public function actionLogout()
	{
		Autumn::app()->request->destorySession();
		$this->redirect('/');
	}

	/**
	* 登录页面
	* ======
	* @author 洪波
	* @version 17.02.09
	*/
	public function actionLoginPage()
	{
		$this->view->render('login');
	}

	/**
	* 注册页面
	* ======
	* @author 洪波
	* @version 17.02.09
	*/
	public function actionRegisterPage()
	{
		$this->view->render('register');
	}

	/**
	* 个人资料页面
	* ======
	* @author 洪波
	* @version 17.02.10
	*/
	public function actionUser()
	{
		$user_id = Autumn::app()->request->getSession('user_id');
		$token = Autumn::app()->request->getSession('token');
		$m_user = new \app\models\M_user;
		if ($m_user->checkToken($user_id, $token))
		{
			$users = $m_user->get($user_id);
			$data = array(
				'users' => $users
			);
			$this->view->render('user', $data);
		}
		else
		{
			$this->redirect('/site/loginPage');
		}
	}

	/**
	* 首页
	* ======
	* @author 洪波
	* @version 17.02.09
	*/
	public function actionIndex()
	{
		$page = Autumn::app()->request->getQuery('page', 1);
		$keyword = Autumn::app()->request->getQuery('k', '');
		$limit = 10;
		$offset = ($page - 1) * $limit;
		$result = $this->m_content->getContentList($offset, $limit, '585615b8ed0db', 0, 1);
		$pages = new \library\Pagination($result['count'], $limit, $page, '/site/index');

		$data  = array(
			'main_list' => $result['result'],
			'pages' => $pages->build()
		);
		$this->view->render('index', $data);
	}

	/**
	* 内容详情
	* ======
	* @author 洪波
	* @version 17.02.09
	*/
	public function actionContent()
	{
		$ct_id = Autumn::app()->request->getQuery('id');
		if(strlen($ct_id) == 13)
		{
			$contents = $this->m_content->get($ct_id);
			if($contents)
			{
				$is_coll = false;
				if ($user_id = Autumn::app()->request->getSession('user_id'))
				{
					$m_collect = new \app\models\M_collect;
					$is_coll = $m_collect->exist($ct_id, $user_id);
				}
				$m_index = new \app\models\M_index;
				$this->m_content->addViewCount($ct_id);
				$data = array(
					'is_coll' => $is_coll,
					'contents' => $contents,
					'indexs' => $m_index->getIndex($ct_id)
				);
				$this->view->render('content', $data);
			}
		}
	}

	/**
	* 收藏夹
	* ======
	* @author 洪波
	* @version 17.02.14
	*/
	public function actionCollect()
	{
		$user_id = Autumn::app()->request->getSession('user_id');
		$token = Autumn::app()->request->getSession('token');
		$m_user = new \app\models\M_user;
		if ($m_user->checkToken($user_id, $token))
		{
			$page = Autumn::app()->request->getQuery('page', 1);
			$limit = 10;
			$offset = ($page - 1) * $limit;
			$m_collect = new \app\models\M_collect;
			$result = $m_collect->getContentList($offset, $limit, $user_id);
			$pages = new \library\Pagination($result['count'], $limit, $page, '/site/collect');
			$data = array(
				'collect_list' => $result['result'],
				'pages' => $pages->build()
			);
			$this->view->render('collect', $data);
		}
		else
		{
			$this->redirect('/site/loginPage');
		}
	}

	/**
	* 问题列表
	* ======
	* @author 洪波
	* @version 17.02.14
	*/
	public function actionQuestion()
	{
		$user_id = Autumn::app()->request->getSession('user_id');
		$token = Autumn::app()->request->getSession('token');
		$m_user = new \app\models\M_user;
		if ($m_user->checkToken($user_id, $token))
		{
			$page = Autumn::app()->request->getQuery('page', 1);
			$limit = 10;
			$offset = ($page - 1) * $limit;
			$m_content_note = new \app\models\M_content_note;
			$result = $m_content_note->myNoteList($offset, $limit, $user_id);
			$pages = new \library\Pagination($result['count'], $limit, $page, '/site/question');
			$data = array(
				'note_list' => $result['result'],
				'pages' => $pages->build()
			);
			$this->view->render('question', $data);
		}
		else
		{
			$this->redirect('/site/loginPage');
		}
	}
}