<?php
/**
* 测试控制器
* ======
* @author 洪波
* @version 16.07.28
*/
namespace app\controllers;
use core\Autumn;
use library\Psdk;

class TestController extends \core\web\Controller
{
	public function init()
	{
		header("Content-Type:text/html;charset=UTF-8");
	}

	public function actionIndex()
	{
		Autumn::app()->response->setResult('wahaha');
		echo Autumn::app()->response->json();
	}
	/*
	public function actionGetNoteList()
	{
		$data = array(
			'offset' => 0,
			'limit' => 10,
			'ct_id' => '57ae9a845f7df'
		);
		$psdk = new Psdk;
		echo $psdk->post('content/getNoteList', $data);
	}//*/

}