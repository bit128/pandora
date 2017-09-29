<?php
/**
* 主站控制器
* ======
* @author 洪波
* @version 16.09.21
*/
namespace app\controllers;
use core\Autumn;

class SiteController extends \core\web\Controller {
	//private $view;
	
	public function init() {
		//$this->view = \core\web\View::layout('site/layout_site');
	}

	public function actionIndex() {
		echo 'Welcome to Pandora ' , Autumn::app()->config->get('version'), '.';
		//Autumn::app()->view->renderPartial('index');
	}
}