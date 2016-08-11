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
	* 登录页面
	* ======
	* @author 洪波
	* @version 16.08.10
	*/
	public function actionLogin()
	{
		View::layout('layout_site')->render('login');
	}

	/**
	* 注册页面
	* ======
	* @author 洪波
	* @version 16.08.10
	*/
	public function actionRegister()
	{
		View::layout('layout_site')->render('register');
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
		View::layout('layout_site')->render('list');
	}

	/**
	* 商品详情页
	* ======
	* @author 洪波
	* @version 16.08.10
	*/
	public function actionItem()
	{
		View::layout('layout_site')->render('item');
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