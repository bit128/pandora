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
	* 关联订单成员
	* ======
	* @param $od_id 	订单id
	* @param $cr_id 	购物车成员id
	* ======
	* @author 洪波
	* @version 16.08.27
	*/
	public function unionOrder($od_id, $cr_id)
	{
		$criteria = new Criteria;
		if(is_array($cr_id))
		{
			$criteria->addIn('cr_id', $cr_id);
		}
		else
		{
			$criteria->add('cr_id', $cr_id);
		}
		$data = array('od_id' => $od_id);

		return Orm::model($this->table_name)->updateAll($data, $criteria);
	}

	/**
	* 获取我的购物车全部商品列表
	* ======
	* @param $user_id 	用户id
	* @param $od_id 	订单id
	* ======
	* @author 洪波
	* @version 16.08.27
	*/
	public function getAllList($user_id, $od_id = '')
	{
		$criteria = new Criteria;
		$criteria->add('user_id', $user_id);
		$criteria->add('od_id', $od_id);
		return Orm::model($this->table_name)->findAll($criteria);
	}

	/**
	* 【后期废弃】获取购物车商品列表
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
		if(strlen($user_id) == 13)
		{
			$criteria->add('user_id', $user_id);
		}
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

	/**
	* 获取购物车详细列表
	* ======
	* @param $od_id 订单id
	* ======
	* @author 洪波
	* @version 17.01.05
	*/
	public function getDetailList($od_id)
	{
		$select_cart = 't_cart.*';
		$select_product = 't_product.pd_name,t_product.pd_image';
		$select_stock = 't_stock.st_name,t_stock.st_size';
		$condition = "t_cart.od_id='{$od_id}' and t_cart.pd_id=t_product.pd_id and t_cart.st_id=t_stock.st_id";

		$sql = 'select ' . $select_cart . ',' . $select_product . ',' 
			. $select_stock . ' from t_cart,t_product,t_stock where ' . $condition 
			. ' order by t_cart.cr_time asc';

		return \core\Autumn::app()->mysqli->queryAll($sql);
	}
}