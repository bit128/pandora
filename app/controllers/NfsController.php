<?php
/**
* 网络文件控制器
* ======
* @author 洪波
* @version 16.08.02
*/
namespace app\controllers;

class NfsController extends \core\Controller
{

	/**
	* 上传文件
	* ======
	* @author 洪波
	* @version 15.07.05
	*/
	public function actionUpload()
	{
		$nfs = new \library\NetFile;
		$result = $nfs->upload('./app/statics/files/', 'file_name', \library\NetFile::HASH_DATE);
		echo json_encode($result);
	}

	/**
	* 输出图片
	* ======
	* @author 洪波
	* @version 15.08.22
	*/
	public function actionImage()
	{
		$src = substr($_SERVER['REQUEST_URI'], 10);
		$out = new \library\ImageOutput;
		$out->render($src);
	}

}