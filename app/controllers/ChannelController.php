<?php
/**
* 栏目控制器
* ======
* @author 洪波
* @version 16.07.29
*/
namespace app\controllers;
use core\Autumn;
use core\db\Criteria;
use core\http\Response;
use app\models\M_channel;
use app\models\M_index;
use app\models\M_admin;

class ChannelController extends \core\web\Controller
{
	/**
	* 添加栏目
	* ======
	* @author 洪波
	* @version 16.04.22
	*/
	public function actionAdd()
	{
		if(Autumn::app()->request->isPost())
		{
			if(M_admin::checkRole(M_admin::ROLE_CONTENT))
			{
				$cn_fid = Autumn::app()->request->getPost('cn_fid', '0');
				$data = [
					'cn_fid' => $cn_fid,
					'cn_name' => '新建栏目',
					'cn_data' => '{}',
					'cn_sort' => $this->m_channel->maxSort($cn_fid),
					'cn_ctime' => time(),
					'cn_status' => M_channel::STATUS_HIDE
				];
				$this->m_channel->load($data);
				if($this->m_channel->save())
				{
					Autumn::app()->response->setResult($this->m_channel->getOrm()->cn_id);
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
	* 获取栏目详情
	* ======
	* @author 洪波
	* @version 16.04.22
	*/
	public function actionGet()
	{
		if($cn_id = Autumn::app()->request->getParam('id'))
		{
			if($channel = $this->m_channel->get($cn_id))
			{
				Autumn::app()->response->setResult($channel->toArray());
			}
			else
			{
				Autumn::app()->response->setResult(Response::RES_NOTHAS, '', '栏目不存在');
			}
		}
		else
		{
			Autumn::app()->response->setResult(Response::RES_PARAMF);
		}
		Autumn::app()->response->json();
	}

	/**
	* 仅获取栏目扩展数据
	* ======
	* @author 洪波
	* @version 16.04.22
	*/
	public function actionGetData()
	{
		if($cn_id = Autumn::app()->request->getParam('id'))
		{
			$data = $this->m_channel->getData($cn_id);
			if($data !== false)
			{
				Autumn::app()->response->setResult($data);
			}
			else
			{
				Autumn::app()->response->setResult(Response::RES_NOTHAS, '', '栏目不存在');
			}
		}
		else
		{
			Autumn::app()->response->setResult(Response::RES_PARAMF);
		}
		Autumn::app()->response->json();
	}

	/**
	* 仅获取栏目内容
	* ======
	* @author 洪波
	* @version 16.04.22
	*/
	public function actionGetContent()
	{
		if($cn_id = Autumn::app()->request->getParam('id'))
		{
			$content = $this->m_channel->getContent($cn_id);
			if($content !== false)
			{
				Autumn::app()->response->setResult($content);
			}
			else
			{
				Autumn::app()->response->setResult(Response::RES_NOTHAS, '', '栏目不存在');
			}
		}
		else
		{
			Autumn::app()->response->setResult(Response::RES_PARAMF);
		}
		Autumn::app()->response->json();
	}

	/**
	* 更新栏目
	* ======
	* @author 洪波
	* @version 16.09.15
	*/
	public function actionUpdateField()
	{
		if(Autumn::app()->request->isPostrequest())
		{
			if(M_admin::checkRole(M_admin::ROLE_CONTENT))
			{
				$cn_id = Autumn::app()->request->getPost('cn_id');
				$field = Autumn::app()->request->getPost('field');
				$value = Autumn::app()->request->getPost('value');
				if($this->m_channel->update($cn_id, [
					$field => $value,
					'cn_utime' => time()
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
	* 设置栏目内容关键词
	* ======
	* @author 洪波
	* @version 16.09.15
	*/
	public function actionSetKeyword()
	{
		if(Autumn::app()->request->isPostrequest())
		{
			if(M_admin::checkRole(M_admin::ROLE_CONTENT))
			{
				$cn_id = Autumn::app()->request->getPost('cn_id');
				$keyword = trim(Autumn::app()->request->getPost('keyword'));
				//变更栏目内容关键字字段
				$this->m_channel->update($cn_id, [
					'cn_keyword' => $keyword,
					'cn_utime' => time()
				]);
				//删除旧索引
				$this->m_index->deleteByChannel($cn_id);
				//批量建立索引
				if ($keyword != '')
				{
					foreach (explode(' ', $keyword) as $kw_name)
					{
						if ($kw_name != '')
						{
							//使用计数
							$this->m_keyword->useCount($kw_name);
							//建立索引
							$m_index = new M_index;
							$m_index->getOrm()->id_keyword = $kw_name;
							$m_index->getOrm()->id_channel = $cn_id;
							$m_index->save();
						}
					}
				}
				Autumn::app()->response->setResult(Response::RES_OK);
			}
			else
			{
				Autumn::app()->response->setResult(Response::RES_REFUSE);
			}
			Autumn::app()->response->json();
		}
	}

	/**
	* 删除栏目
	* ======
	* @author 洪波
	* @version 17.09.15
	*/
	public function actionDeleteAll()
	{
		if(Autumn::app()->request->isPostrequest())
		{
			if(M_admin::checkRole(M_admin::ROLE_CONTENT))
			{
				$cn_id = Autumn::app()->request->getPost('cn_id');
				$this->m_channel->recursionDelete($cn_id);
				Autumn::app()->response->setResult(Response::RES_OK);
			}
			else
			{
				Autumn::app()->response->setResult(Response::RES_REFUSE, '', '无权操作');
			}
			Autumn::app()->response->json();
		}
	}
}