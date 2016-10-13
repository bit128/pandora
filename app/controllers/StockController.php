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
use app\models\M_stock;
use app\models\M_admin;

class StockController extends Controller
{

	private $m_stock;

	public function init()
	{
		$this->m_stock = new M_stock;
	}

	/**
	* 增加新库存
	* ======
	* @author 洪波
	* @version 16.08.06
	*/
	public function actionAdd()
	{
		if(Request::inst()->isPostRequest())
		{
			$response = new Response;
			if(M_admin::checkRole(M_admin::ROLE_PRODUCT))
			{
				$pd_id = Request::inst()->getPost('pd_id');
				if(strlen($pd_id) == 13)
				{
					$data = array(
						'pd_id' => $pd_id,
						'st_discount' => 1.0,
						'st_time' => time(),
						'st_status' => M_stock::STATUS_HIDE
						);
					if($st_id = $this->m_stock->insert($data))
					{
						$response->setResult($st_id, Response::RES_SUCCESS);
					}
					else
					{
						$response->setError('创建失败', Response::RES_FAIL);
					}
				}
				else
				{
					$response->setError('参数错误', Response::RES_PARAMF);
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
	* 设置库存信息
	* ======
	* @author 洪波
	* @version 16.08.06
	*/
	public function actionSetInfo()
	{
		if(Request::inst()->isPostRequest())
		{
			$response = new Response;
			if(M_admin::checkRole(M_admin::ROLE_PRODUCT))
			{
				$st_id = Request::inst()->getPost('st_id');
				$field = Request::inst()->getPost('field');
				$value = Request::inst()->getPost('value');
				$data = array(
					$field => $value
					);
				if($this->m_stock->update($st_id, $data))
				{
					$response->setResult('设置成功', Response::RES_SUCCESS);
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

}