<?php
/**
* 收货地址控制器
* ======
* @author 洪波
* @version 16.07.29
*/
namespace app\controllers;
use core\Autumn;
use core\Criteria;
use library\RedisCache;
use app\models\M_stock;
use app\models\M_address;

class AddressController extends \core\Controller
{

	private $m_address;

	public function init()
	{
		$this->m_address = new M_address;
	}

	/**
	* 添加收获地址
	* ======
	* @param $user_id 		用户id
	* @param $token 		令牌
	* @param $ad_title 		地址标题
	* @param $ad_content	详细地址
	* @param $ad_post 		邮编
	* @param $ad_phone 		电话
	* @param $ad_name 		姓名
	* ======
	* @author 洪波
	* @version 16.08.26
	*/
	public function actionAdd()
	{
		if(Autumn::app()->request->isPostRequest())
		{
			$user_id = Autumn::app()->request->getPost('user_id');
			$token = Autumn::app()->request->getPost('token');
			if(RedisCache::model('token')->check($user_id, $token))
			{
				$criteria = new Criteria;
				$criteria->add('user_id', $user_id);
				$count = $this->m_address->count($criteria);
				if($count < M_address::CT_LIMIT)
				{
					$data = array(
						'ad_title' => Autumn::app()->request->getPost('ad_title', '我的地址'),
						'ad_content' => Autumn::app()->request->getPost('ad_content'),
						'ad_post' => Autumn::app()->request->getPost('ad_post'),
						'ad_phone' => Autumn::app()->request->getPost('ad_phone'),
						'ad_name' => Autumn::app()->request->getPost('ad_name'),
						'user_id' => $user_id
						);
					if($ad_id = $this->m_address->insert($data))
					{
						Autumn::app()->response->setResult($ad_id);
					}
					else
					{
						Autumn::app()->response->setResult(\core\Response::RES_FAIL);
					}
				}
				else
				{
					Autumn::app()->response->setResult(\core\Response::RES_REFUSE, '', '您做多可拥有'.M_address::CT_LIMIT.'个地址');
				}
			}
			else
			{
				Autumn::app()->response->setResult(\core\Response::RES_TOKENF);
			}
			Autumn::app()->response->json();
		}
	}

	/**
	* 获取地址列表
	* ======
	* @author 洪波
	* @version 16.08.26
	*/
	public function actionGetList()
	{
		if(Autumn::app()->request->isPostRequest())
		{
			$user_id = Autumn::app()->request->getPost('user_id');
			$token = Autumn::app()->request->getPost('token');
			if(RedisCache::model('token')->check($user_id, $token))
			{
				$offset = Autumn::app()->request->getPost('offset', 0);
				$limit = Autumn::app()->request->getPost('limit', 99);
				$criteria = new Criteria;
				$criteria->add('user_id', $user_id);
				$criteria->order = 'ad_status desc';

				$result = $this->m_address->getList($offset, $limit, $criteria);
				Autumn::app()->response->setResult($result);
			}
			else
			{
				Autumn::app()->response->setResult(\core\Response::RES_TOKENF);
			}
			Autumn::app()->response->json();
		}
	}

	/**
	* 设置地址信息
	* ======
	* @author 洪波
	* @version 16.08.26
	*/
	private function setInfo($field)
	{}

	/**
	* 更新地址
	* ======
	* @author 洪波
	* @version 16.08.26
	*/
	public function actionUpdate()
	{
		if(Autumn::app()->request->isPostRequest())
		{
			$user_id = Autumn::app()->request->getPost('user_id');
			$token = Autumn::app()->request->getPost('token');
			if(RedisCache::model('token')->check($user_id, $token))
			{
				$ad_id = Autumn::app()->request->getPost('ad_id');
				$data = array(
					'ad_title' => Autumn::app()->request->getPost('ad_title'),
					'ad_content' => Autumn::app()->request->getPost('ad_content'),
					'ad_post' => Autumn::app()->request->getPost('ad_post'),
					'ad_phone' => Autumn::app()->request->getPost('ad_phone'),
					'ad_name' => Autumn::app()->request->getPost('ad_name'),
					);
				if($this->m_address->update($ad_id, $data))
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
				Autumn::app()->response->setResult(\core\Response::RES_TOKENF);
			}
			Autumn::app()->response->json();
		}
	}

	/**
	* 删除收货地址
	* ======
	* @author 洪波
	* @version 16.08.26
	*/
	public function actionDelete()
	{
		if(Autumn::app()->request->isPostRequest())
		{
			$user_id = Autumn::app()->request->getPost('user_id');
			$token = Autumn::app()->request->getPost('token');
			if(RedisCache::model('token')->check($user_id, $token))
			{
				$ad_id = Autumn::app()->request->getPost('ad_id');
				$address = $this->m_address->get($ad_id);
				if($address)
				{
					if($address->user_id == $user_id)
					{
						$this->m_address->delete($cr_id);
						Autumn::app()->response->setResult(\core\Response::RES_OK);
					}
					else
					{
						Autumn::app()->response->setResult(\core\Response::RES_REFUSE);
					}
				}
				else
				{
					Autumn::app()->response->setResult(\core\Response::RES_PARAMF);
				}
			}
			else
			{
				Autumn::app()->response->setResult(\core\Response::RES_TOKENF);
			}
			Autumn::app()->response->json();
		}
	}    
}