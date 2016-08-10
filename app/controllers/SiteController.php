<?php
namespace app\controllers;
use core\Controller;
use core\Request;

/**
* 站点控制器示例
* ======
* @author 洪波
* @version 16.07.06
*/
class SiteController extends Controller
{
	public function actionIndex()
	{
		header("Content-Type:text/html;charset=UTF-8");
		echo 'Pandora is come back! ';
	}
}