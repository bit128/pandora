<?php
/**
* 测试控制器
* ======
* @author 洪波
* @version 16.07.28
*/
namespace app\controllers;
use core\Controller;
use library\Psdk;

class TestController extends Controller
{
	public function init()
	{
		header("Content-Type:text/html;charset=UTF-8");
	}

	public function actionCut()
	{
		$m_stock = new \app\models\M_stock;
		echo $m_stock->cutStock('57ac2e9b90a20', 2);
	}

	public function actionUpload()
	{
		$data = array(
			'by_id' => '112358',
			'al_image' => 'default.jpg'
			);
		$psdk = new Psdk;
		echo $psdk->post('album/add', $data);
	}

	public function actionRegister()
	{
		$data = array(
			'user_phone' => '13761497959',
			'user_password' => '123',
			'user_name' => '银莹',
			'user_device' => 4,
			'user_version' => '1.2'
			);
		$psdk = new Psdk;
		echo $psdk->post('user/register', $data);
	}

	public function actionLogin()
	{
		$data = array(
			'user_phone' => '18814887668',
			'user_password' => 'hong_1987',
			);
		$psdk = new Psdk;
		echo $psdk->post('user/login', $data);
	}

	public function actionLogout()
	{
		$data = array(
			'user_id' => '579b29ea49424',
			'token' => 'd63dde4880d07101e1b7e41c89d64a62',
			);
		$psdk = new Psdk;
		echo $psdk->post('user/logout', $data);
	}

	public function actionSearchList()
	{
		$data = array(
			'offset' => 0,
			'limit' => 10,
			'keyword' => '中西主食 手工冰淇淋'
			);
		$psdk = new Psdk;
		echo $psdk->post('product/searchList', $data);
	}

	public function actionAddCollect()
	{
		$data = array(
			'user_id' => '57ad684337eee',
			'token' => '2a5de996f75cdd14ca3d1f2832e14c35',
			'pd_id' => '57ac1d12914cf'
			);
		$psdk = new Psdk;
		echo $psdk->post('collect/add', $data);
	}

	public function actionGetCollect()
	{
		$data = array(
			'user_id' => '57ad684337eee',
			'token' => '2a5de996f75cdd14ca3d1f2832e14c35',
			);
		$psdk = new Psdk;
		echo $psdk->post('collect/getList', $data);
	}

	public function actionDeleteCollect()
	{
		$data = array(
			'user_id' => '57ad684337eee',
			'token' => '2a5de996f75cdd14ca3d1f2832e14c35',
			'cl_id' => '57bfbbfc93c81'
			);
		$psdk = new Psdk;
		echo $psdk->post('collect/delete', $data);
	}

	public function actionAddCart()
	{
		$data = array(
			'user_id' => '57ad684337eee',
			'token' => '2a5de996f75cdd14ca3d1f2832e14c35',
			'pd_id' => '57ac1b5acd3a4',
			'st_id' => '57ae9d81a7dc9'
			);
		$psdk = new Psdk;
		echo $psdk->post('cart/add', $data);
	}

	public function actionGetCart()
	{
		$data = array(
			'user_id' => '57ad684337eee',
			'token' => '2a5de996f75cdd14ca3d1f2832e14c35',
			);
		$psdk = new Psdk;
		echo $psdk->post('cart/getList', $data);
	}

	public function actionDeleteCart()
	{
		$data = array(
			'user_id' => '57ad684337eee',
			'token' => '2a5de996f75cdd14ca3d1f2832e14c35',
			'cr_id' => '57bfe191abfb6'
			);
		$psdk = new Psdk;
		echo $psdk->post('cart/delete', $data);
	}

	public function actionAddOrder()
	{
		$data = array(
			'user_id' => '57ad684337eee',
			'token' => '2a5de996f75cdd14ca3d1f2832e14c35',
			);
		$psdk = new Psdk;
		echo $psdk->post('order/add', $data);
	}

	public function actionAddAddress()
	{
		$data = array(
			'user_id' => '57ad684337eee',
			'token' => '2a5de996f75cdd14ca3d1f2832e14c35',
			'ad_content' => '海曙路128号仓溢绿苑',
			'ad_post' => '000000',
			'ad_phone' => '18814887668',
			'ad_name' => '波哥'
			);
		$psdk = new Psdk;
		echo $psdk->post('address/add', $data);
	}
}