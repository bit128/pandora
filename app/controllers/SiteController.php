<?php
namespace app\controllers;
use core\Autumn;

/**
* 站点控制器示例
* ======
* @author 洪波
* @version 16.07.06
*/
class SiteController extends \core\Controller
{
	
	public function init()
	{
		header("Content-Type:text/html;charset=UTF-8");
	}

	public function actionIndex()
	{
		echo 'Pandora ', Autumn::PRODUCT_VERSION;
	}
}