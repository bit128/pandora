<?php
/**
* 收货地址控制器
* ======
* @author 洪波
* @version 16.07.29
*/
namespace app\controllers;
use core\Controller;
use core\Request;
use core\Response;
use core\Criteria;
use library\RedisCache;
use app\models\M_stock;
use app\models\M_address;

class AddressController extends Controller
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
		if(Request::inst()->isPostRequest())
		{
			$response = new Response;
			$user_id = Request::inst()->getPost('user_id');
			$token = Request::inst()->getPost('token');
			if(RedisCache::model('token')->check($user_id, $token))
			{
				$criteria = new Criteria;
				$criteria->add('user_id', $user_id);
				$count = $this->m_address->count($criteria);
				if($count < M_address::CT_LIMIT)
				{
					$data = array(
						'ad_title' => Request::inst()->getPost('ad_title', '我的地址'),
						'ad_content' => Request::inst()->getPost('ad_content'),
						'ad_post' => Request::inst()->getPost('ad_post'),
						'ad_phone' => Request::inst()->getPost('ad_phone'),
						'ad_name' => Request::inst()->getPost('ad_name'),
						'user_id' => $user_id
						);
					if($ad_id = $this->m_address->insert($data))
					{
						$response->setResult($ad_id, Response::RES_SUCCESS);
					}
					else
					{
						$response->setError('创建失败', Response::RES_FAIL);
					}
				}
				else
				{
					$response->setError('您做多可拥有'.M_address::CT_LIMIT.'个地址', Response::RES_REFUSE);
				}
			}
			else
			{
				$response->setError('令牌无效', Response::RES_TOKENF);
			}
			$response->json();
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
		if(Request::inst()->isPostRequest())
		{
			$response = new Response;
			$user_id = Request::inst()->getPost('user_id');
			$token = Request::inst()->getPost('token');
			if(RedisCache::model('token')->check($user_id, $token))
			{
				$offset = Request::inst()->getPost('offset', 0);
				$limit = Request::inst()->getPost('limit', 99);
				$criteria = new Criteria;
				$criteria->add('user_id', $user_id);
				$criteria->order = 'ad_status desc';

				$result = $this->m_address->getList($offset, $limit, $criteria);
				$response->setResult($result, Response::RES_SUCCESS);
			}
			else
			{
				$response->setError('令牌无效', Response::RES_TOKENF);
			}
			$response->json();
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
		if(Request::inst()->isPostRequest())
		{
			$response = new Response;
			$user_id = Request::inst()->getPost('user_id');
			$token = Request::inst()->getPost('token');
			if(RedisCache::model('token')->check($user_id, $token))
			{
				$ad_id = Request::inst()->getPost('ad_id');
				$data = array(
					'ad_title' => Request::inst()->getPost('ad_title'),
					'ad_content' => Request::inst()->getPost('ad_content'),
					'ad_post' => Request::inst()->getPost('ad_post'),
					'ad_phone' => Request::inst()->getPost('ad_phone'),
					'ad_name' => Request::inst()->getPost('ad_name'),
					);
				if($this->m_address->update($ad_id, $data))
				{
					$response->setResult('更新成功', Response::RES_SUCCESS);
				}
				else
				{
					$response->setError('没有更新', Response::RES_NOCHAN);
				}
			}
			else
			{
				$response->setError('令牌无效', Response::RES_TOKENF);
			}
			$response->json();
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
		if(Request::inst()->isPostRequest())
		{
			$response = new Response;
			$user_id = Request::inst()->getPost('user_id');
			$token = Request::inst()->getPost('token');
			if(RedisCache::model('token')->check($user_id, $token))
			{
				$ad_id = Request::inst()->getPost('ad_id');
				$address = $this->m_address->get($ad_id);
				if($address)
				{
					if($address->user_id == $user_id)
					{
						$this->m_address->delete($cr_id);
						$response->setResult('删除成功', Response::RES_SUCCESS);
					}
					else
					{
						$response->setError('越权操作', Response::RES_REFUSE);
					}
				}
				else
				{
					$response->setError('参数错误', Response::RES_PARAMF);
				}
			}
			else
			{
				$response->setError('令牌无效', Response::RES_TOKENF);
			}
			$response->json();
		}
	}    
}