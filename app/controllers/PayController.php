<?php
/**
* 付款控制器
* ======
* @author 洪波
* @version 16.08.27
*/
namespace app\controllers;
use core\Autumn;
use app\models\M_order;

class PayController extends \core\Controller
{

	private $m_order;

	public function init()
	{
		$this->m_order = new M_order;
	}

	/**
	* 使用支付宝付款
	* ======
	* @author 洪波
	* @version 16.09.13
	*/
	public function actionAlipay()
	{
		$od_id = Autumn::app()->request->getParam('id');
		if(strlen($od_id) == 16)
		{
			$order = $this->m_order->get($od_id);
			if($order)
			{
				if($order->od_status == M_order::STATUS_CREATE)
				{
					$data = array(
						'od_paytype' => 'alipay',
						'od_flowid' => date('YmdHis') . rand(100000, 999999),
						'od_status' => M_order::STATUS_PAY
						);
					if($this->m_order->update($od_id, $data))
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
			}
			else
			{
				Autumn::app()->response->setResult(\core\Response::RES_NOHAS);
			}
		}
		else
		{
			Autumn::app()->response->setResult(\core\Response::RES_PARAMF);
		}
		Autumn::app()->response->json();
	}

	/**
	* 使用微信钱包付款
	* ======
	* @author 洪波
	* @version 16.09.13
	*/
	public function actionWechat()
	{}
}