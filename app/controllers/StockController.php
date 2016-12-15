<?php
/**
* 库存控制器
* ======
* @author 洪波
* @version 16.07.29
*/
namespace app\controllers;
use core\Autumn;
use app\models\M_stock;
use app\models\M_admin;

class StockController extends \core\Controller
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
		if(Autumn::app()->request->isPostRequest())
		{
			if(M_admin::checkRole(M_admin::ROLE_PRODUCT))
			{
				$pd_id = Autumn::app()->request->getPost('pd_id');
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
						Autumn::app()->response->setResult($st_id);
					}
					else
					{
						Autumn::app()->response->setResult(\core\Response::RES_FAIL);
					}
				}
				else
				{
					Autumn::app()->response->setResult(\core\Response::RES_PARAMF);
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
	* 设置库存信息
	* ======
	* @author 洪波
	* @version 16.08.06
	*/
	public function actionSetInfo()
	{
		if(Autumn::app()->request->isPostRequest())
		{
			if(M_admin::checkRole(M_admin::ROLE_PRODUCT))
			{
				$st_id = Autumn::app()->request->getPost('st_id');
				$field = Autumn::app()->request->getPost('field');
				$value = Autumn::app()->request->getPost('value');
				$data = array(
					$field => $value
					);
				if($this->m_stock->update($st_id, $data))
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

}