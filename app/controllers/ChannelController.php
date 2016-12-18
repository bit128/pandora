<?php
/**
* 栏目控制器
* ======
* @author 洪波
* @version 16.07.29
*/
namespace app\controllers;
use core\Autumn;
use core\Criteria;
use library\Psdk;
use app\models\M_channel;
use app\models\M_admin;

class ChannelController extends \core\Controller
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
		$id = Autumn::app()->request->getParam('id', '0');
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
		if(Autumn::app()->request->isPostrequest())
		{
			if(M_admin::checkRole(M_admin::ROLE_CONTENT))
			{
				$cn_fid = Autumn::app()->request->getPost('cn_fid');
				$cn_name = Autumn::app()->request->getPost('cn_name');
				if(strlen($cn_id = $this->m_channel->add($cn_fid, $cn_name)) === 13)
				{
					Autumn::app()->response->setResult($cn_id);
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
	* 获取栏目详情
	* ======
	* @author 洪波
	* @version 16.04.22
	*/
	public function actionGet()
	{
		$cn_id = Autumn::app()->request->getParam('cn_id', -1);
		if($cn_id != -1)
		{
			if($channel = $this->m_channel->get($cn_id))
			{
				Autumn::app()->response->setResult($channel);
			}
			else
			{
				Autumn::app()->response->setResult(\core\Response::RES_NOHAS, '', '栏目不存在');
			}
			Autumn::app()->response->json();
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
			$offset = Autumn::app()->request->getPost('offset', 0);
			$limit = Autumn::app()->request->getPost('limit', 99);
			$cn_id = Autumn::app()->request->getPost('cn_id');
			if(strlen($cn_id) == 13)
			{
				$criteria = new Criteria;
				$criteria->add('cn_fid', $cn_id);
				$criteria->order = 'cn_sort asc';
				$result = $this->m_channel->getList($offset, $limit, $criteria);
				Autumn::app()->response->setResult($result);
			}
			else
			{
				Autumn::app()->response->setResult(\core\Response::RES_PARAMF);
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
		if(Autumn::app()->request->isPostrequest())
		{
			if(M_admin::checkRole(M_admin::ROLE_CONTENT))
			{
				$cn_id = Autumn::app()->request->getPost('cn_id');
				$data = array(
					'cn_nick' => Autumn::app()->request->getPost('cn_nick'),
					'cn_url' => Autumn::app()->request->getPost('cn_url'),
					'cn_admin' => Autumn::app()->request->getPost('cn_admin'),
					'cn_status' => Autumn::app()->request->getPost('cn_status')
					);
				if($this->m_channel->update($cn_id, $data))
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
	* 栏目重命名
	* ======
	* @author 洪波
	* @version 16.04.22
	*/
	public function actionRename()
	{
		if(Autumn::app()->request->isPostrequest())
		{
			if(M_admin::checkRole(M_admin::ROLE_CONTENT))
			{
				$cn_id = Autumn::app()->request->getPost('cn_id');
				$data = array(
					'cn_name' => Autumn::app()->request->getPost('cn_name')
					);
				if($this->m_channel->update($cn_id, $data))
				{
					Autumn::app()->response->setResult(\core\Response::RES_SUCCESS);
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
	* 设置排序
	* ======
	* @author 洪波
	* @version 14.12.27
	*/
	public function actionSetSort()
	{
		if(Autumn::app()->request->isPostrequest())
		{
			if(M_admin::checkRole(M_admin::ROLE_CONTENT))
			{
				$cn_id = Autumn::app()->request->getPost('cn_id');
				$cn_fid = Autumn::app()->request->getPost('cn_fid');
				$by_id = Autumn::app()->request->getPost('by_id');
				$type = Autumn::app()->request->getPost('type');

				$this->m_channel->setSort($cn_id, $cn_fid, $by_id, $type);
				Autumn::app()->response->setResult(\core\Response::RES_OK);
			}
			else
			{
				Autumn::app()->response->setResult(\core\Response::RES_REFUSE);
			}
			Autumn::app()->response->json();
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
		if(Autumn::app()->request->isPostrequest())
		{
			if(M_admin::checkRole(M_admin::ROLE_CONTENT))
			{
				$cn_id = Autumn::app()->request->getPost('cn_id');
				if($cn_id != '1')
				{
					//判断有没有子栏目
					if(! $this->m_channel->isParent($cn_id))
					{
						$m_content = new \app\models\M_content;
						//判断有没有内容
						if($m_content->countContent($cn_id) == 0)
						{
							if($this->m_channel->delete($cn_id))
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
							Autumn::app()->response->setResult(\core\Response::RES_FAIL, '', '栏目下有内容，请先删除内容');
						}
					}
					else
					{
						Autumn::app()->response->setResult(\core\Response::RES_FAIL, '', '存在子栏目，请先删除子栏目');
					}
				}
				else
				{
					Autumn::app()->response->setResult(\core\Response::RES_REFUSE, '', '不能删除根目录，不然就没得玩了');
				}
			}
			else
			{
				Autumn::app()->response->setResult(\core\Response::RES_REFUSE, '', '无权操作');
			}
			Autumn::app()->response->json();
		}
	}
}