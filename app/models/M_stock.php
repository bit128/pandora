<?php
/**
* 库存模型
* ======
* @author 洪波
* @version 16.08.03
*/
namespace app\models;
use core\Model;
use core\Criteria;
use core\Orm;

class M_stock extends Model
{
	
	const STATUS_OPEN	= 1;
	const STATUS_HIDE	= 0;

	public $table_name = 't_stock';

	/**
	* 根据商品id删除库存
	* ======
	* @param $pd_id 	商品id
	* ======
	* @author 洪波
	* @version 16.08.11
	*/
	public function deleteByPd($pd_id)
	{
		$criteria = new Criteria;
		$criteria->add('pd_id', $pd_id);
		return Orm::model($this->table_name)->deleteAll($criteria);
	}

}