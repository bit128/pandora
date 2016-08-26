<?php
/**
* 购物车模型
* ======
* @author 洪波
* @version 16.08.18
*/
namespace app\models;
use core\Model;
use core\Criteria;
use core\Orm;

class M_cart extends Model
{
	public $table_name = 't_cart';


	/**
	* 匹配购物车中相同商品库存
	* ======
	* @param $user_id 	用户id
	* @param $pd_id 	商品id
	* @param $st_id 	库存id
	* ======
	* @author 洪波
	* @version 16.08.26
	*/
	public function matchItem($user_id, $pd_id, $st_id)
	{
		$criteria = new Criteria;
		$criteria->add('user_id', $user_id);
		$criteria->add('pd_id', $pd_id);
		$criteria->add('st_id', $st_id);
		return Orm::model($this->table_name)->find($criteria, true);
	}

	/**
	* 获取购物车商品列表
	* ======
	* @param $offset 	分页位置
	* @param $limit 	偏移量
	* @param $user_id 	用户Id
	* @param $od_id 	订单id
	* ======
	* @author 洪波
	* @version 16.08.26
	*/
	public function getProductList($offset, $limit, $user_id, $od_id)
	{
		$criteria = new Criteria;
		$criteria->add('user_id', $user_id);
		$criteria->add('od_id', $od_id);
		//统计数量
		$count = $this->count($criteria);
		//联合product
		$criteria->select = $this->table_name . '.*,t_product.pd_name,t_product.pd_image,t_product.pd_price';
		$criteria->union('t_product', $this->table_name . '.pd_id=t_product.pd_id', 'left');
		//分页排序
		$criteria->offset = $offset;
		$criteria->limit = $limit;
		$criteria->order = 'cr_time asc';
		//获取数据列表
		$list = Orm::model($this->table_name)->findAll($criteria);

		return array(
			'count' => $count,
			'result' => $list
			);
	}
}