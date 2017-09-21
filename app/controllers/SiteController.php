<?php
namespace app\controllers;
use core\Autumn;

/**
* 站点控制器示例
* ======
* @author 洪波
* @version 16.09.21
*/
class SiteController extends \core\web\Controller
{
	//private $view;
	
	public function init()
	{
		//$this->view = \core\web\View::layout('site/layout_site');
	}

	public function actionIndex()
	{
		echo 'Welcome to Pandora ' , Autumn::app()->config->get('version'), '.';
		//Autumn::app()->view->renderPartial('index');
	}
}