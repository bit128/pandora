<?php
namespace app\controllers;
use core\Controller;
use core\Request;
use core\View;
use library\Psdk;

/**
* 站点控制器示例
* ======
* @author 洪波
* @version 16.07.06
*/
class SiteController extends Controller
{

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
		View::layout('layout_site')->render('index');
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
		$keyword = Request::inst()->getQuery('k');
		$page = Request::inst()->getQuery('page', 1);
		$limit = 16;
		$offset = ($page - 1) * $limit;

		$data = array(
			'offset' => $offset,
			'limit' => $limit,
			'keyword' => $keyword
			);
		$psdk = new Psdk;
		$response = json_decode($psdk->post('product/searchList', $data));
		//分页
		$url = '/site/list';
		$pages = new \library\Pagination($response->result->count, $limit, $page, $url);

		$data = array(
			'product_list' => $response->result->result,
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
			$psdk = new Psdk;
			$result = json_decode($psdk->query('product/getDetail/id/' . $pd_id));
			if($result->code == 1)
			{
				$data = array(
					'product' => $result->result->product,
					'image' => $result->result->image,
					'stock' => $result->result->stock,
					'detail' => $result->result->detail
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
		View::layout('layout_site')->render('blog');
	}

	/**
	* 博客详情
	* ======
	* @author 洪波
	* @version 16.08.10
	*/
	public function actionBlogDetail()
	{
		View::layout('layout_site')->render('blog_detail');
	}

	/**
	* 新闻列表
	* ======
	* @author 洪波
	* @version 16.08.10
	*/
	public function actionNews()
	{
		View::layout('layout_site')->render('news');
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