<?php
namespace app\controllers;
use core\Controller;
use core\Request;
use core\View;

/**
* 站点控制器示例
* ======
* @author 洪波
* @version 16.07.06
*/
class SiteController extends Controller
{
	const CHANNEL_BLOG = '57ad76d2a739f';
	const CHANNEL_NEWS = '57ae9a6b2a96b';

	public function init()
	{
		header("Content-Type:text/html;charset=UTF-8");
	}

	/**
	* 主页面
	* ======
	* @author 洪波
	* @version 16.08.10
	*/
	public function actionIndex()
	{
		$m_struct = new \app\models\M_struct;
		$rs = json_decode($m_struct->getBody('57afc7ec763ac'));
		$data = array(
			'banner' => $rs->banner,
			'side' => $rs->side,
			'promotion' => $rs->promotion,
			'hot' => $rs->hot
			);
		View::layout('layout_site')->render('index', $data);
	}

	/**
	* 生成验证码
	* ======
	* @author 洪波
	* @version 16.08.12
	*/
	public function actionValidateCode()
	{
		$validate = new \library\ValidateCode;
		$validate->show();
	}

	/**
	* 登录页面
	* ======
	* @author 洪波
	* @version 16.08.10
	*/
	public function actionLogin()
	{
		if(Request::inst()->isPostRequest())
		{
			$code = Request::inst()->getPost('code');
			if(strtoupper($code) == Request::inst()->getSession('validate_code'))
			{
				$data = array(
					'user_phone' => Request::inst()->getPost('user_phone'),
					'user_password' => Request::inst()->getPost('user_password'),
					'user_device' => 1,
					'user_ip' => $_SERVER['REMOTE_ADDR']
					);
				$psdk = new Psdk;
				$result = json_decode($psdk->post('user/login', $data));
				if($result->code == 1)
				{
					Request::inst()->setSession('user_id', $result->result->user_id);
					Request::inst()->setSession('user_name', $result->result->user_name);
					Request::inst()->setSession('token', $result->result->token);
					header('Location:/');
				}
				else
				{
					echo $result->error;
				}
			}
			else
			{
				echo '验证码错误';
			}
		}
		else
		{
			View::layout('layout_site')->render('login');
		}
	}

	/**
	* 注册页面
	* ======
	* @author 洪波
	* @version 16.08.10
	*/
	public function actionRegister()
	{
		if(Request::inst()->isPostRequest())
		{
			$data = array(
				'user_phone' => Request::inst()->getPost('user_phone'),
				'user_password' => Request::inst()->getPost('user_password'),
				'user_name' => Request::inst()->getPost('user_name'),
				'user_device' => 1,
				'user_ip' => $_SERVER['REMOTE_ADDR']
				);
			$psdk = new Psdk;
			$result = json_decode($psdk->post('user/register', $data));
			if($result->code == 1)
			{
				Request::inst()->setSession('user_id', $result->result->user_id);
				Request::inst()->setSession('user_name', $result->result->user_name);
				Request::inst()->setSession('token', $result->result->token);
				header('Location:/');
			}
			else
			{
				echo $result->error;
			}
		}
		else
		{
			View::layout('layout_site')->render('register');
		}
	}

	/**
	* 用户登出
	* ======
	* @author 洪波
	* @version 16.08.12
	*/
	public function actionLogout()
	{
		Request::inst()->destorySession();
		header("Location:/");
	}

	/**
	* 找回密码页面
	* ======
	* @author 洪波
	* @version 16.08.10
	*/
	public function actionGetpwd()
	{
		View::layout('layout_site')->render('getpwd');
	}

	/**
	* 商品列表页
	* ======
	* @author 洪波
	* @version 16.08.10
	*/
	public function actionList()
	{

		$m_dictionary = new \app\models\M_dictionary;
		$m_product = new \app\models\M_product;
		$criteria = new \core\Criteria;

		$keyword = urldecode(Request::inst()->getQuery('k'));
		$page = Request::inst()->getQuery('page', 1);
		$limit = 16;
		$offset = ($page - 1) * $limit;
		//关键词分析
		$kr = explode(' ', trim($keyword));
		$pd_ids = $m_dictionary->getEntryIds($kr);
		//获取pd_id列表
		$criteria->add('pd_status', 1);
		if($keyword != '')
		{
			if(! $pd_ids)
			{
				$pd_ids[] = '';
			}
			$criteria->addCondition("pd_id in ('".implode("','", $pd_ids)."')");
		}
		$criteria->order = 'pd_sort asc';
		$product_list = $m_product->getList($offset, $limit, $criteria);
		//分页
		$url = '/site/list';
		$pages = new \library\Pagination($product_list['count'], $limit, $page, $url);

		$data = array(
			'product_list' => $product_list['result'],
			'pages' => $pages->build()
			);
		View::layout('layout_site')->render('list', $data);
	}

	/**
	* 商品详情页
	* ======
	* @author 洪波
	* @version 16.08.10
	*/
	public function actionItem()
	{
		$pd_id = Request::inst()->getQuery('id');
		if(strlen($pd_id) == 13)
		{
			$m_product = new \app\models\M_product;
			if($product = $m_product->get($pd_id))
			{
				$m_content = new \app\models\M_content;
				$m_stock = new \app\models\M_stock;
				$m_album = new \app\models\M_album;
				$detail = $m_content->get($pd_id);
				$data = array(
					'product' => $product,
					'image' => $m_album->getImages($pd_id),
					'stock' => $m_stock->getStock($pd_id),
					'detail' => $detail->ct_detail
					);
				View::layout('layout_site')->render('item', $data);
			}
		}
	}

	/**
	* 购物车
	* ======
	* @author 洪波
	* @version 16.08.10
	*/
	public function actionCart()
	{
		View::layout('layout_site')->render('cart');
	}

	/**
	* 订单列表
	* ======
	* @author 洪波
	* @version 16.08.10
	*/
	public function actionOrder()
	{
		View::layout('layout_site')->render('order');
	}

	/**
	* 确认订单
	* ======
	* @author 洪波
	* @version 16.08.10
	*/
	public function actionCheckout()
	{
		View::layout('layout_site')->render('checkout');
	}

	/**
	* 完成支付
	* ======
	* @author 洪波
	* @version 16.08.10
	*/
	public function actionCheckdone()
	{
		View::layout('layout_site')->render('checkdone');
	}

	/**
	* 博客列表
	* ======
	* @author 洪波
	* @version 16.08.10
	*/
	public function actionBlog()
	{
		$cn_id = Request::inst()->getQuery('cn', self::CHANNEL_BLOG);
		$page = Request::inst()->getQuery('page', 1);
		$limit =5;
		$offset = ($page - 1) * $limit;
		
		$m_channel = new \app\models\M_channel;
		$m_content = new \app\models\M_content;
		//获取内容列表
		$criteria = new \core\Criteria;
		$criteria->addCondition('ct_status > 0');
		if(strlen($cn_id) == 13)
		{
			$cn_ids = $m_channel->getChildIds($cn_id);
			$criteria->addCondition("cn_id in ('".implode("','", $cn_ids)."')");
		}
		$criteria->order = 'ct_utime desc';
		$content_list = $m_content->getList($offset, $limit, $criteria);
		//分页
		$url = '/site/blog';
		$pages = new \library\Pagination($content_list['count'], $limit, $page, $url);

		$data = array(
			'content_list' => $content_list['result'],
			'blog_channel' => $this->getBlogChannel(),
			'hot_content' => $this->getHotContent(),
			'pages' => $pages->build()
			);
		View::layout('layout_site')->render('blog', $data);
	}

	/**
	* 博客详情
	* ======
	* @author 洪波
	* @version 16.08.10
	*/
	public function actionBlogDetail()
	{
		$id = Request::inst()->getQuery('id');
		if(strlen($id) == 13)
		{
			$m_content = new \app\models\M_content;
			$content_detail = $m_content->get($id);
			if($content_detail)
			{
				$data = array(
					'contents' => $content_detail,
					'blog_channel' => $this->getBlogChannel(),
					'hot_content' => $this->getHotContent()
					);
				View::layout('layout_site')->render('blog_detail', $data);
			}
		}
	}

	/**
	* 获取博客栏目列表
	* ======
	* @author 洪波
	* @version 16.08.13
	*/
	private function getBlogChannel()
	{
		$m_channel = new \app\models\M_channel;
		$criteria = new \core\Criteria;
		$criteria->add('cn_fid', self::CHANNEL_BLOG);
		$criteria->add('cn_status', 1);
		$criteria->order = 'cn_sort asc';
		return $m_channel->getList(0, 20, $criteria);
	}

	/**
	* 获取博客热门内容列表
	* ======
	* @author 洪波
	* @version 16.08.13
	*/
	private function getHotContent()
	{
		$m_channel = new \app\models\M_channel;
		$m_content = new \app\models\M_content;
		$criteria = new \core\Criteria;
		$criteria->add('ct_status', 2);
		$cn_ids = $m_channel->getChildIds(self::CHANNEL_BLOG);
		$criteria->addCondition("cn_id in ('".implode("','", $cn_ids)."')");
		$criteria->order = 'ct_utime desc';
		return $m_content->getList(0, 10, $criteria);
	}

	/**
	* 新闻列表
	* ======
	* @author 洪波
	* @version 16.08.10
	*/
	public function actionNews()
	{
		$m_content = new \app\models\M_content;
		$page = Request::inst()->getQuery('page', 1);
		$limit =5;
		$offset = ($page - 1) * $limit;
		$criteria = new \core\Criteria;
		$criteria->add('cn_id', self::CHANNEL_NEWS);
		$criteria->add('ct_status', \app\models\M_content::STATUS_HIDE, '!=');
		$criteria->order = 'ct_utime desc';
		$content_list = $m_content->getList($offset, $limit, $criteria);
		//分页
		$url = '/site/news';
		$pages = new \library\Pagination($content_list['count'], $limit, $page, $url);

		$data = array(
			'content_list' => $content_list['result'],
			'pages' => $pages->build()
			);
		View::layout('layout_site')->render('news', $data);
	}

	/**
	* 关于我们
	* ======
	* @author 洪波
	* @version 16.08.10
	*/
	public function actionAbout()
	{
		View::layout('layout_site')->render('about');
	}

	/**
	* 订单帮助
	* ======
	* @author 洪波
	* @version 16.08.10
	*/
	public function actionHelpOrder()
	{
		View::layout('layout_site')->render('help_order');
	}
}