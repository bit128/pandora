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

	public function actionIndex()
	{
		$m_stock = new \app\models\M_stock;
		$rs = $m_stock->getStock('57abe7f60eef6');
		print_r($rs);
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
			'user_phone' => '8613761497959',
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
			'user_phone' => '8613761497959',
			'user_password' => '123',
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
}