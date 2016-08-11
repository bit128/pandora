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
	* 获取库存列表
	* ======
	* @param $pd_id 	商品id
	* ======
	* @author 洪波
	* @version 16.08.11
	*/
	public function getStock($pd_id)
	{
		$criteria = new Criteria;
		$criteria->add('pd_id', $pd_id);
		$list = Orm::model($this->table_name)->findAll($criteria);
		$result = array(
			'item' => array(),
			'size' => array()
			);
		$names = array();
		$price = 0;
		foreach ($list as $v)
		{
			if(! in_array($v->st_name, $names))
			{
				$names[] = $v->st_name; 
				$result['item'][] = array(
					'st_image' => $v->st_image,
					'st_name' => $v->st_name,
					'st_price' => $v->st_price
					);
			}
			if(! in_array($v->st_size, $result['size']))
			{
				$result['size'][] = $v->st_size;
			}
			if($price < $v->st_price)
			{
				$price = $v->st_price;
			}
		}
		$result['price'] = $price;
		//$result['list'] = $list;
		return $result;
	}

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