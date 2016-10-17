<?php
/**
* 栏目控制器
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
use app\models\M_channel;
use app\models\M_admin;

class ChannelController extends Controller
{

	private $m_channel;

	public function init()
	{
		$this->m_channel = new M_channel;
	}

	/**
	* 获取栏目树
	* ======
	* @author 洪波
	* @version 16.04.22
	*/
	public function actionGetChannelTree()
	{
		$id = Request::inst()->getParam('id', '0');
 		echo json_encode($this->m_channel->getTreeList($id));
	}

	/**
	* 添加栏目
	* ======
	* @author 洪波
	* @version 16.04.22
	*/
	public function actionAdd()
	{
		if(Request::inst()->isPostrequest())
		{
			$response = new Response;
			if(M_admin::checkRole(M_admin::ROLE_CONTENT))
			{
				$cn_fid = Request::inst()->getPost('cn_fid');
				$cn_name = Request::inst()->getPost('cn_name');
				if(strlen($cn_id = $this->m_channel->add($cn_fid, $cn_name)) === 13)
				{
					$response->setResult($cn_id, Response::RES_SUCCESS);
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
	* 获取栏目详情
	* ======
	* @author 洪波
	* @version 16.04.22
	*/
	public function actionGet()
	{
		$cn_id = Request::inst()->getParam('cn_id', -1);
		if($cn_id != -1)
		{
			$response = new Response;
			if($channel = $this->m_channel->get($cn_id))
			{
				$response->setResult($channel, Response::RES_SUCCESS);
			}
			else
			{
				$response->setError('栏目不存在', Response::RES_NOHAS);
			}
			$response->json();
		}
	}

	/**
	* 获取栏目列表
	* ======
	* @author 洪波
	* @version 16.08.12
	*/
	public function actionGetList()
	{
		if(Psdk::checkSign())
		{
			$response = new Response;
			$offset = Request::inst()->getPost('offset', 0);
			$limit = Request::inst()->getPost('limit', 99);
			$cn_id = Request::inst()->getPost('cn_id');
			if(strlen($cn_id) == 13)
			{
				$criteria = new Criteria;
				$criteria->add('cn_fid', $cn_id);
				$criteria->order = 'cn_sort asc';
				$result = $this->m_channel->getList($offset, $limit, $criteria);
				$response->setResult($result, Response::RES_SUCCESS);
			}
			else
			{
				$response->setResult('参数错误', Response::RES_PARAMF);
			}
		}
	}

	/**
	* 更新栏目
	* ======
	* @author 洪波
	* @version 16.04.22
	*/
	public function actionUpdate()
	{
		if(Request::inst()->isPostrequest())
		{
			$response = new Response;
			if(M_admin::checkRole(M_admin::ROLE_CONTENT))
			{
				$cn_id = Request::inst()->getPost('cn_id');
				$data = array(
					'cn_nick' => Request::inst()->getPost('cn_nick'),
					'cn_url' => Request::inst()->getPost('cn_url'),
					//'cn_status' => Request::inst()->getPost('cn_status', 2)
					);
				if($this->m_channel->update($cn_id, $data))
				{
					$response->setResult('更新成功', Response::RES_SUCCESS);
				}
				else
				{
					$response->setError('栏目没有更新', Response::RES_NOCHAN);
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
	* 栏目重命名
	* ======
	* @author 洪波
	* @version 16.04.22
	*/
	public function actionRename()
	{
		if(Request::inst()->isPostrequest())
		{
			$response = new Response;
			if(M_admin::checkRole(M_admin::ROLE_CONTENT))
			{
				$cn_id = Request::inst()->getPost('cn_id');
				$data = array(
					'cn_name' => Request::inst()->getPost('cn_name')
					);
				if($this->m_channel->update($cn_id, $data))
				{
					$response->setResult('操作成功', RES_SUCCESS);
				}
				else
				{
					$response->setError('栏目没有更新', Response::RES_NOCHAN);
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
	* 设置排序
	* ======
	* @author 洪波
	* @version 14.12.27
	*/
	public function actionSetSort()
	{
		if(Request::inst()->isPostrequest())
		{
			$response = new Response;
			if(M_admin::checkRole(M_admin::ROLE_CONTENT))
			{
				$cn_id = Request::inst()->getPost('cn_id');
				$cn_fid = Request::inst()->getPost('cn_fid');
				$by_id = Request::inst()->getPost('by_id');
				$type = Request::inst()->getPost('type');

				$this->m_channel->setSort($cn_id, $cn_fid, $by_id, $type);
				$response->setResult('操作成功', Response::RES_SUCCESS);
			}
			else
			{
				$response->setError('无权操作', Response::RES_REFUSE);
			}
			$response->json();
		}
	}

	/**
	* 删除栏目
	* ======
	* @author 洪波
	* @version 14.12.27
	*/
	public function actionDelete()
	{
		if(Request::inst()->isPostrequest())
		{
			$response = new Response;
			if(M_admin::checkRole(M_admin::ROLE_CONTENT))
			{
				$cn_id = Request::inst()->getPost('cn_id');
				//判断有没有子栏目
				if(! $this->m_channel->isParent($cn_id))
				{
					$m_content = new \app\models\M_content;
					//判断有没有内容
					if($m_content->countContent($cn_id) == 0)
					{
						if($this->m_channel->delete($cn_id))
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
						$response->setError('栏目下有内容，请先删除内容', Response::RES_FAIL);
					}
				}
				else
				{
					$response->setError('存在子栏目，请先删除子栏目', Response::RES_FAIL);
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