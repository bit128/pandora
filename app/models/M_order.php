<?php
/**
* 订单模型
* ======
* @author 洪波
* @version 16.08.18
*/
namespace app\models;
use core\Model;
use core\Criteria;
use core\Orm;

class M_order extends Model
{

	const STATUS_CLOSE		= 0; //状态 - 已关闭
	const STATUS_CREATE		= 1; //状态 - 新订单
	const STATUS_PAY		= 2; //状态 - 已支付
	const STATUS_ACCEPT		= 3; //状态 - 已接受
	const STATUS_REFUSE		= 4; //状态 - 以拒绝
	const STATUS_SEND		= 5; //状态 - 已发货
	const STATUS_FINISH		= 6; //状态 - 已完成
	const STATUS_COMMENT	= 7; //状态 - 已评论

	public $table_name = 't_order';

	/**
	* 生成新的订单id
	* ======
	* @author 洪波
	* @version 16.08.27
	*/
	public function newOrderId()
	{
		do {
			$od_id = date('ymdHis') . rand(1000, 9999);
		} 
		while ($this->get($od_id));

		return $od_id;
	}
}