<?php
/**
* 内容控制器
* ======
* @author 洪波
* @version 16.07.29
*/
namespace app\controllers;
use core\Autumn;
use core\Criteria;
use library\Psdk;
use app\models\M_content;
use app\models\M_content_note;
use app\models\M_admin;

class ContentController extends \core\Controller
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
		if(Autumn::app()->request->isPostRequest())
		{
			if(M_admin::checkRole(M_admin::ROLE_CONTENT))
			{
				$time = time();
				$data = array(
					'cn_id' => Autumn::app()->request->getPost('cn_id'),
					'ct_title' => '新建栏目内容',
					'ct_ctime' => $time,
					'ct_utime' => $time,
					'ct_status' => M_content::STATUS_HIDE
					);
				$ct_id = $this->m_content->insert($data);
				if(strlen($ct_id) == 13)
				{
					Autumn::app()->response->setResult($ct_id);
				}
				else
				{
					Autumn::app()->response->setResult(\core\Response::RES_FAIL);
				}
			}
			else
			{
				Autumn::app()->response->setResult(\core\Response::RES_REFUSE);
			}
			Autumn::app()->response->json();
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
		if(Autumn::app()->request->isPostRequest())
		{
			if(M_admin::checkRole(M_admin::ROLE_CONTENT))
			{
				$ct_id = Autumn::app()->request->getPost('ct_id');
				$field = Autumn::app()->request->getPost('field');
				$value = Autumn::app()->request->getPost('value');
				$data = array(
					$field => $value,
					'ct_utime' => time()
					);
				if($this->m_content->update($ct_id, $data))
				{
					Autumn::app()->response->setResult(\core\Response::RES_OK);
				}
				else
				{
					Autumn::app()->response->setResult(\core\Response::RES_NOCHAN);
				}
			}
			else
			{
				Autumn::app()->response->setResult(\core\Response::RES_REFUSE);
			}
			Autumn::app()->response->json();
		}
	}

	/**
	* 获取内容详情
	* ======
	* @author 洪波
	* @version 16.12.15
	*/
	public function actionGet()
	{
		$ct_id = Autumn::app()->request->getParam('ct_id');
		if(strlen($ct_id) == 13)
		{
			$result = $this->m_content->get($ct_id);
			if($result)
			{
				Autumn::app()->response->setResult($result);
			}
			else
			{
				Autumn::app()->response->setResult(\core\Response::RES_NOHAS);
			}
			Autumn::app()->response->json();
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
			$offset = Autumn::app()->request->getPost('offset', 0);
			$limit = Autumn::app()->request->getPost('limit', 99);
			$cn_id = Autumn::app()->request->getPost('cn_id');
			$keyword = Autumn::app()->request->getPost('keyword');

			$criteria = new Criteria;
			$criteria->add('ct_status', '0', '>');
			if(strlen($cn_id) == 13)
			{
				$m_channel = new \app\models\M_channel;
				$cn_ids = $m_channel->getChildIds($cn_id);
				$criteria->addIn('cn_id', $cn_ids);
			}
			$criteria->order = 'ct_utime desc';
			$result = $this->m_content->getList($offset, $limit, $criteria);
			Autumn::app()->response->setResult($result);
			Autumn::app()->response->json();
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
		if(Autumn::app()->request->isPostRequest())
		{
			$offset = Autumn::app()->request->getPost('offset');
			$limit = Autumn::app()->request->getPost('limit');
			$cn_id = Autumn::app()->request->getPost('cn_id');
			$sort = (int) Autumn::app()->request->getPost('sort', 0);
			$ct_status = (int) Autumn::app()->request->getPost('ct_status', -1);

			$result = $this->m_content->getContentList($offset, $limit, $cn_id, $sort, $ct_status);
			Autumn::app()->response->setResult($result);
			Autumn::app()->response->json();
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
		if(Autumn::app()->request->isPostRequest())
		{
			if(M_admin::checkRole(M_admin::ROLE_CONTENT))
			{
				$ct_id = Autumn::app()->request->getPost('ct_id');
				if($this->m_content->delete($ct_id))
				{
					Autumn::app()->response->setResult(\core\Response::RES_OK);
				}
				else
				{
					Autumn::app()->response->setResult(\core\Response::RES_NOCHAN);
				}
			}
			else
			{
				Autumn::app()->response->setResult(\core\Response::RES_REFUSE);
			}
			Autumn::app()->response->json();
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
			$m_note = new M_content_note;
			if($m_note->insert($data))
			{
				Autumn::app()->response->setResult(\core\Response::RES_OK);
			}
			else
			{
				Autumn::app()->response->setResult(\core\Response::RES_FAIL);
			}
			Autumn::app()->response->json();
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
			Autumn::app()->response->setResult($result);
			Autumn::app()->response->json();
		}
	}

	/**
	* 设置评论状态
	* ======
	* @author 洪波
	* @version 16.12.15
	*/
	public function actionSetNoteStatus()
	{
		if(Autumn::app()->request->isPostRequest())
		{
			if(M_admin::checkRole(M_admin::ROLE_CONTENT))
			{
				$tn_id = Autumn::app()->request->getPost('tn_id');
				$tn_status = Autumn::app()->request->getPost('tn_status');
				$m_note = new M_content_note;
				if($m_note->update($tn_id, array(
					'tn_status' => $tn_status
				)))
				{
					Autumn::app()->response->setResult(\core\Response::RES_OK);
				}
				else
				{
					Autumn::app()->response->setResult(\core\Response::RES_NOCHAN);
				}
			}
			else
			{
				Autumn::app()->response->setResult(\core\Response::RES_REFUSE);
			}
			Autumn::app()->response->json();
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
		if(Autumn::app()->request->isPostRequest())
		{
			if(M_admin::checkRole(M_admin::ROLE_CONTENT))
			{
				$tn_id = Autumn::app()->request->getPost('tn_id');
				$m_note = new M_content_note;
				if($m_note->delete($tn_id))
				{
					Autumn::app()->response->setResult(\core\Response::RES_OK);
				}
				else
				{
					Autumn::app()->response->setResult(\core\Response::RES_FAIL);
				}
			}
			else
			{
				Autumn::app()->response->setResult(\core\Response::RES_REFUSE);
			}
			Autumn::app()->response->json();
		}
	}
}