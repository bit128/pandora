<?php
/**
* 付款控制器
* ======
* @author 洪波
* @version 16.08.27
*/
namespace app\controllers;
use core\Controller;
use core\Request;
use core\Response;
use app\models\M_order;

class PayController extends Controller
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
		$od_id = Request::inst()->getParam('id');
		$response = new Response;
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
						$response->setResult('操作成功', Response::RES_SUCCESS);
					}
					else
					{
						$response->setResult('操作失败', Response::RES_FAIL);
					}
				}
				else
				{
					$response->setError('状态错误', Response::RES_REFUSE);
				}
			}
			else
			{
				$response->setError('订单不存在', Response::RES_NOHAS);
			}
		}
		else
		{
			$response->setError('参数错误', Response::RES_PARAMF);
		}
		$response->json();
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