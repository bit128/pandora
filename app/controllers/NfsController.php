<?php
/**
* 网络文件控制器
* ======
* @author 洪波
* @version 16.08.02
*/
namespace app\controllers;
use core\Controller;
use library\NetFile;

class NfsController extends Controller
{

	private $nfs;

	public function init()
	{
		$this->nfs = new NetFile;
	}

	/**
	* 上传文件
	* ======
	* @author 洪波
	* @version 15.07.05
	*/
	public function actionUpload()
	{
		$result = $this->nfs->upload(NetFile::POST_NAME);
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
		$src = substr(strrchr($_SERVER['REQUEST_URI'], '/'), 1);
		if($src)
		{
			$this->nfs->outputImage($src, NetFile::IMAGE_PATH);
		}
	}

}