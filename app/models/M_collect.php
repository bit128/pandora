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
	{}
}