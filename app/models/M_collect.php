<?php
/**
* 收藏夹模型
* ======
* @author 洪波
* @version 16.08.18
*/
namespace app\models;
use core\Model;
use core\Criteria;
use core\Orm;

class M_collect extends Model
{
	public $table_name = 't_collect';

	/**
	* 获取收藏夹商品列表
	* ======
	* @param $offset 	分页位置
	* @param $limit 	偏移量
	* @param $user_id 	用户Id
	* ======
	* @author 洪波
	* @version 16.08.18
	*/
	public function getProductList($offset, $limit, $user_id)
	{
		$criteria = new Criteria;
		$criteria->add('user_id', $user_id);
		//统计数量
		$count = $this->count($criteria);
		//联合product
		$criteria->select = $this->table_name . '.*,t_product.pd_name,t_product.pd_image,t_product.pd_price';
		$criteria->union('t_product', $this->table_name . '.pd_id=t_product.pd_id', 'left');
		//分页排序
		$criteria->offset = $offset;
		$criteria->limit = $limit;
		$criteria->order = 'cl_time asc';
		//获取数据列表
		$list = Orm::model($this->table_name)->findAll();

		return array(
			'count' => $count,
			'result' => $result
			);
	}
}