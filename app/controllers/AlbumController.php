<?php
/**
* 相册控制器
* ======
* @author 洪波
* @version 16.07.29
*/
namespace app\controllers;
use core\Autumn;
use core\db\Criteria;
use core\http\Response;
use app\models\M_album;
use app\models\M_admin;

class AlbumController extends \core\web\Controller
{

	private $m_album;

	public function init()
	{
		$this->m_album = new M_album;
	}

	/**
	* 更新实体主图
	* ======
	* @param $by_id 	实体id
	* ======
	* @author 洪波
	* @version 16.08.06
	*/
	public function updateMainImage($by_id)
	{
		$image = $this->m_album->getMinImage($by_id);
		if($image)
		{
			$class = '\app\models\M_' . $image->al_type;
			$main = new $class;
			$main->setMainImage($by_id, $image->al_image);
		}
	}

	/**
	* 添加图片
	* ======
	* @author 洪波
	* @version 16.08.05
	*/
	public function actionAdd()
	{
		if(Autumn::app()->request->isPostRequest())
		{
			if(M_admin::checkRole(M_admin::ROLE_CONTENT))
			{
				$by_id = Autumn::app()->request->getPost('by_id');
				$data = array(
					'by_id' => $by_id,
					'al_type' => Autumn::app()->request->getPost('al_type'),
					'al_image' => Autumn::app()->request->getPost('al_image'),
					'al_sort' => $this->m_album->maxSort($by_id),
					'al_status' => M_album::STATUS_SHOW
					);
				if(strlen($by_id) == 13)
				{
					$this->m_album->load($data);
					if($al_id = $this->m_album->save())
					{
						$this->updateMainImage($by_id);
						Autumn::app()->response->setResult($al_id);
					}
					else
					{
						Autumn::app()->response->setResult(Response::RES_FAIL, '', '添加图片失败');
					}
				}
				else
				{
					Autumn::app()->response->setResult(Response::RES_PARAMF);
				}
			}
			else
			{
				Autumn::app()->response->setResult(Response::RES_REFUSE, '', '需要内容权限');
			}
			Autumn::app()->response->json();
		}
	}

	/**
	* 根据实体Id获取图片列表
	* ======
	* @author 洪波
	* @version 16.08.06
	*/
	public function actionGetList()
	{
		if(Autumn::app()->request->isPostRequest())
		{
			if(M_admin::checkRole(M_admin::ROLE_CONTENT))
			{
				$criteria = new Criteria;
				$criteria->offset = Autumn::app()->request->getPost('offset', 0);
				$criteria->limit = Autumn::app()->request->getPost('limit', 10);
				$by_id = Autumn::app()->request->getPost('by_id');
				
				$criteria->add('by_id', $by_id);
				$criteria->order = 'al_sort asc';
				$result = $this->m_album->getList($criteria);
				Autumn::app()->response->setResult($result);
			}
			else
			{
				Autumn::app()->response->setResult(Response::RES_REFUSE, '', '需要内容权限');
			}
			Autumn::app()->response->json();
		}
	}

	/**
	* 设置照片信息
	* ======
	* @author 洪波
	* @version 16.08.05
	*/
	public function actionSetInfo()
	{
		if(Autumn::app()->request->isPostRequest())
		{
			if(M_admin::checkRole(M_admin::ROLE_CONTENT))
			{
				$al_id = Autumn::app()->request->getPost('al_id');
				$field = Autumn::app()->request->getPost('field');
				$value = Autumn::app()->request->getPost('value');
				$data = array(
					$field => $value
					);
				if($this->m_album->update($al_id, $data))
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
	* 设置顺序
	* ======
	* @author 洪波
	* @version 16.08.05
	*/
	public function actionSetSort()
	{
		if(Autumn::app()->request->isPostRequest())
		{
			if(M_admin::checkRole(M_admin::ROLE_CONTENT))
			{
				$al_id = Autumn::app()->request->getPost('al_id');
				$by_id = Autumn::app()->request->getPost('by_id');
				$type = Autumn::app()->request->getPost('type');
				if($this->m_album->setSort($al_id, $by_id, $type))
				{
					$this->updateMainImage($by_id);
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
	* 删除图片
	* ======
	* @author 洪波
	* @version 16.08.05
	*/
	public function actionDelete()
	{
		if(Autumn::app()->request->isPostRequest())
		{
			if(M_admin::checkRole(M_admin::ROLE_CONTENT))
			{
				$al_id = Autumn::app()->request->getPost('al_id');
				if($this->m_album->delete($al_id))
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
}