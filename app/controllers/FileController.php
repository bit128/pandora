<?php
/**
* 文件资源控制器
* ======
* @author 洪波
* @version 17.03.03
*/
namespace app\controllers;
use core\Autumn;
use core\db\Criteria;
use core\http\Response;
use app\models\M_file;
use app\models\M_admin;

class FileController extends \core\web\Controller
{

	private $m_file;

	public function init()
	{
		$this->m_file = new M_file;
	}
	
	/**
	* 添加文件
	* ======
	* @author 洪波
	* @version 17.03.03
	*/
	public function actionAdd()
	{
		if (Autumn::app()->request->isPostRequest())
		{
			if(M_admin::checkRole(M_admin::ROLE_CONTENT))
			{
				$data = [
					'file_ctime' => time(),
					'file_status' => M_file::STATUS_OPEN
				];
				$this->m_file->load($data, true);
				if ($this->m_file->save())
				{
					Autumn::app()->response->setResult(Response::RES_OK);
				}
				else
				{
					Autumn::app()->response->setResult(Response::RES_FAIL);
				}
			}
			else
			{
				Autumn::app()->response->setResult(Response::RES_REFUSE);
			}
			Autumn::app()->response->json();
		}
	}

	/**
	* 设置文件属性
	* ======
	* @author 洪波
	* @version 17.03.03
	*/
	public function actionSetInfo()
	{
		if (Autumn::app()->request->isPostRequest())
		{
			if(M_admin::checkRole(M_admin::ROLE_CONTENT))
			{
				$file_id = Autumn::app()->request->getPost('file_id');
				$field = Autumn::app()->request->getPost('field');
				$value = Autumn::app()->request->getPost('value');
				if ($this->m_file->update($file_id, [
					$field => $value,
					'file_utime' => time()
				]))
				{
					Autumn::app()->response->setResult(Response::RES_OK);
				}
				else
				{
					Autumn::app()->response->setResult(Response::RES_NOCHAN);
				}
			}
			else
			{
				Autumn::app()->response->setResult(Response::RES_REFUSE);
			}
			Autumn::app()->response->json();
		}
	}

	/**
	* 删除文件属性
	* ======
	* @author 洪波
	* @version 17.03.03
	*/
	public function actionDelete()
	{
		if (Autumn::app()->request->isPostRequest())
		{
			if(M_admin::checkRole(M_admin::ROLE_CONTENT))
			{
				$file_id = Autumn::app()->request->getPost('file_id');
				$file_obj = $this->m_file->get($file_id);
				if ($file_obj)
				{
					@unlink('.' . $file_obj->file_path);
					$this->m_file->delete($file_id);
					Autumn::app()->response->setResult(Response::RES_OK);
				}
				else
				{
					Autumn::app()->response->setResult(Response::RES_NOTHAS);
				}
			}
			else
			{
				Autumn::app()->response->setResult(Response::RES_REFUSE);
			}
			Autumn::app()->response->json();
		}
	}
}