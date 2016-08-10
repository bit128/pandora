<?php
/**
* 相册控制器
* ======
* @author 洪波
* @version 16.07.29
*/
namespace app\controllers;
use core\Controller;
use core\Request;
use core\Response;
use core\Criteria;
use app\models\M_album;
use app\models\M_admin;

class AlbumController extends Controller
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
		if(Request::inst()->isPostRequest())
		{
			$response = new Response;
			if(M_admin::checkRole(M_admin::ROLE_CONTENT))
			{
				$by_id = Request::inst()->getPost('by_id');
				$data = array(
					'by_id' => $by_id,
					'al_type' => Request::inst()->getPost('al_type'),
					'al_image' => Request::inst()->getPost('al_image'),
					'al_sort' => $this->m_album->maxSort($by_id),
					'al_status' => M_album::STATUS_SHOW
					);
				if(strlen($by_id) == 13)
				{
					if($al_id = $this->m_album->insert($data))
					{
						$this->updateMainImage($by_id);
						$response->setResult($al_id, Response::RES_SUCCESS);
					}
					else
					{
						$response->setError('添加图片失败', Response::RES_FAIL);
					}
				}
				else
				{
					$response->setError('参数错误', Response::RES_PARAMF);
				}
			}
			else
			{
				$response->setError('需要内容权限', Response::RES_REFUSE);
			}
			$response->json();
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
		if(Request::inst()->isPostRequest())
		{
			$response = new Response;
			if(M_admin::checkRole(M_admin::ROLE_CONTENT))
			{
				$offset = Request::inst()->getPost('offset', 0);
				$limit = Request::inst()->getPost('limit', 10);
				$by_id = Request::inst()->getPost('by_id');
				$criteria = new Criteria;
				$criteria->add('by_id', $by_id);
				$criteria->order = 'al_sort asc';
				$response->setResult($this->m_album->getList($offset, $limit, $criteria), Response::RES_SUCCESS);
			}
			else
			{
				$response->setError('需要内容权限', Response::RES_REFUSE);
			}
			$response->json();
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
		if(Request::inst()->isPostRequest())
		{
			$response = new Response;
			if(M_admin::checkRole(M_admin::ROLE_CONTENT))
			{
				$al_id = Request::inst()->getPost('al_id');
				$field = Request::inst()->getPost('field');
				$value = Request::inst()->getPost('value');
				$data = array(
					$field => $value
					);
				if($this->m_album->update($al_id, $data))
				{
					$response->setResult('更新成功', Response::RES_SUCCESS);
				}
				else
				{
					$response->setError('没有变更', Response::RES_NOCHAN);
				}
			}
			else
			{
				$response->setError('需要内容权限', Response::RES_REFUSE);
			}
			$response->json();
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
		if(Request::inst()->isPostRequest())
		{
			$response = new Response;
			if(M_admin::checkRole(M_admin::ROLE_CONTENT))
			{
				$al_id = Request::inst()->getPost('al_id');
				$by_id = Request::inst()->getPost('by_id');
				$type = Request::inst()->getPost('type');
				if($this->m_album->setSort($al_id, $by_id, $type))
				{
					$this->updateMainImage($by_id);
					$response->setResult('设置成功', Response::RES_SUCCESS);
				}
				else
				{
					$response->setError('没有变更', Response::RES_NOCHAN);
				}
			}
			else
			{
				$response->setError('需要内容权限', Response::RES_REFUSE);
			}
			$response->json();
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
		if(Request::inst()->isPostRequest())
		{
			$response = new Response;
			if(M_admin::checkRole(M_admin::ROLE_CONTENT))
			{
				$al_id = Request::inst()->getPost('al_id');
				if($this->m_album->delete($al_id))
				{
					$response->setResult('删除成功', Response::RES_SUCCESS);
				}
				else
				{
					$response->setError('删除失败', Response::RES_FAIL);
				}
			}
			else
			{
				$response->setError('需要内容权限', Response::RES_REFUSE);
			}
			$response->json();
		}
	}
}