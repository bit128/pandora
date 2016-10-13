<?php
/**
* 内容控制器
* ======
* @author 洪波
* @version 16.07.29
*/
namespace app\controllers;
use core\Controller;
use core\Request;
use core\Response;
use core\Criteria;
use library\Psdk;
use app\models\M_content;
use app\models\M_admin;

class ContentController extends Controller
{

	private $m_content;

	public function init()
	{
		$this->m_content = new M_content;
	}

	/**
	* 新建内容
	* ======
	* @author 洪波
	* @version 16.07.31
	*/
	public function actionAdd()
	{
		if(Request::inst()->isPostRequest())
		{
			$response = new Response;
			if(M_admin::checkRole(M_admin::ROLE_CONTENT))
			{
				$time = time();
				$data = array(
					'cn_id' => Request::inst()->getPost('cn_id'),
					'ct_title' => '新建栏目内容',
					'ct_ctime' => $time,
					'ct_utime' => $time,
					'ct_status' => M_content::STATUS_HIDE
					);
				$ct_id = $this->m_content->insert($data);
				if(strlen($ct_id) == 13)
				{
					$response->setResult($ct_id, Response::RES_SUCCESS);
				}
				else
				{
					$response->setError('创建失败', Response::RES_FAIL);
				}
			}
			else
			{
				$response->setError('无权操作', Response::RES_REFUSE);
			}
			$response->json();
		}
	}

	/**
	* 更新内容
	* ======
	* @author 洪波
	* @version 16.07.31
	*/
	public function actionUpdate()
	{
		if(Request::inst()->isPostRequest())
		{
			$response = new Response;
			if(M_admin::checkRole(M_admin::ROLE_CONTENT))
			{
				$ct_id = Request::inst()->getPost('ct_id');
				$field = Request::inst()->getPost('field');
				$value = Request::inst()->getPost('value');
				$data = array(
					$field => $value,
					'ct_utime' => time()
					);
				if($this->m_content->update($ct_id, $data))
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
				$response->setError('无权操作', Response::RES_REFUSE);
			}
			$response->json();
		}
	}

	public function actionGet()
	{
		$ct_id = Request::inst()->getParam('ct_id');
		if(strlen($ct_id) == 13)
		{
			$response = new Response;
			$result = $this->m_content->get($ct_id);
			if($result)
			{
				$response->setResult($result, Response::RES_SUCCESS);
			}
			else
			{
				$response->setError('内容不存在', Response::RES_NOHAS);
			}
			$response->json();
		}
	}

	/**
	* 搜索文章列表
	* ======
	* @author 洪波
	* @version 16.08.12
	*/
	public function actionSearchList()
	{
		if(Psdk::checkSign())
		{
			$response = new Response;
			$offset = Request::inst()->getPost('offset', 0);
			$limit = Request::inst()->getPost('limit', 99);
			$cn_id = Request::inst()->getPost('cn_id');
			$keyword = Request::inst()->getPost('keyword');

			$criteria = new Criteria;
			$criteria->addCondition('ct_status > 0');
			if(strlen($cn_id) == 13)
			{
				$m_channel = new \app\models\M_channel;
				$cn_ids = $m_channel->getChildIds($cn_id);
				$criteria->addCondition("cn_id in ('".implode("','", $cn_ids)."')");
			}
			$criteria->order = 'ct_utime desc';
			$result = $this->m_content->getList($offset, $limit, $criteria);
			$response->setResult($result, Response::RES_SUCCESS);
			$response->json();
		}
	}

	/**
	* [管理员]获取内容列表
	* ======
	* @author 洪波
	* @version 16.07.31
	*/
	public function actionGetList()
	{
		if(Request::inst()->isPostRequest())
		{
			$offset = Request::inst()->getPost('offset');
			$limit = Request::inst()->getPost('limit');
			$cn_id = Request::inst()->getPost('cn_id');
			$sort = (int) Request::inst()->getPost('sort', 0);
			$ct_status = (int) Request::inst()->getPost('ct_status', -1);

			$response = new Response;
			$result = $this->m_content->getContentList($offset, $limit, $cn_id, $sort, $ct_status);
			$response->setResult($result, Response::RES_SUCCESS);
			$response->json();
		}
	}

	/**
	* 删除内容
	* ======
	* @author 洪波
	* @version 16.07.31
	*/
	public function actionDelete()
	{
		if(Request::inst()->isPostRequest())
		{
			$response = new Response;
			if(M_admin::checkRole(M_admin::ROLE_CONTENT))
			{
				$ct_id = Request::inst()->getPost('ct_id');
				if($this->m_content->delete($ct_id))
				{
					$response->setResult('删除成功', Response::RES_SUCCESS);
				}
				else
				{
					$response->setError('删除失败', Response::RES_NOCHAN);
				}
			}
			else
			{
				$response->setError('无权操作', Response::RES_REFUSE);
			}
			$response->json();
		}
	}
}