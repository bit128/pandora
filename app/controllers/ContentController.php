<?php
/**
* 内容控制器
* ======
* @author 洪波
* @version 16.07.29
*/
namespace app\controllers;
use core\Autumn;
use core\Controller;
use core\Request;
use core\Response;
use core\Criteria;
use library\Psdk;
use app\models\M_content;
use app\models\M_content_note;
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

	/**
	* 提交评论
	* ======
	* @author 洪波
	* @version 16.12.13
	*/
	public function actionAddNote()
	{
		if (Autumn::app()->request->isPostRequest())
		{
			$data = array(
				'tn_phone' => Autumn::app()->request->getPost('tn_phone'),
				'tn_email' => Autumn::app()->request->getPost('tn_email'),
				'tn_content' => Autumn::app()->request->getPost('tn_content'),
				'tn_time' => time(),
				'tn_status' => M_content_note::STATUS_HIDE,
				'cn_id' => Autumn::app()->request->getPost('cn_id'),
				'ct_id' => Autumn::app()->request->getPost('ct_id'),
				'user_id' => Autumn::app()->request->getPost('user_id'),
			);
			$response = new Response;
			$m_note = new M_content_note;
			if($m_note->insert($data))
			{
				$response->setResult('评论提交成功', Response::RES_SUCCESS);
			}
			else
			{
				$response->setError('操作失败', Response::RES_FAIL);
			}
			$response->json();
		}
	}

	/**
	* 获取评论列表
	* ======
	* @author 洪波
	* @version 16.12.13
	*/
	public function actionGetNoteList()
	{
		if (Autumn::app()->request->isPostRequest())
		{
			$offset = Autumn::app()->request->getPost('offset');
			$limit = Autumn::app()->request->getPost('limit');
			$cn_id = Autumn::app()->request->getPost('cn_id');
			$ct_id = Autumn::app()->request->getPost('ct_id');
			$tn_status = Autumn::app()->request->getPost('tn_status' -1);

			$criteria = new Criteria;
			if (strlen($cn_id) == 13)
				$criteria->add('cn_id', $cn_id);
			if (strlen($ct_id) == 13)
				$criteria->add('ct_id', $ct_id);
			if ($tn_status != -1)
				$criteria->add('tn_status', $tn_status);

			$m_note = new M_content_note;
			$result = $m_note->getList($offset, $limit, $criteria);
			$response = new Response;
			$response->setResult($result, Response::RES_SUCCESS);
			$response->json();
		}
	}

	/**
	* 删除评论
	* ======
	* @author 洪波
	* @version 16.12.13
	*/
	public function actionDeleteNote()
	{
		if(Request::inst()->isPostRequest())
		{
			$response = new Response;
			if(M_admin::checkRole(M_admin::ROLE_CONTENT))
			{
				$tn_id = Request::inst()->getPost('ct_id');
				$m_note = new M_content_note;
				if($m_note->delete($ct_id))
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