<?php
/**
* 商品模型
* ======
* @author 洪波
* @version 16.08.03
*/
namespace app\models;
use core\Model;
use core\Criteria;
use core\Orm;

class M_product extends Model
{
	const STATUS_OPEN	= 1;
	const STATUS_HIDE	= 0;

	public $table_name = 't_product';

	/**
	* 设置商品主图[协议接口]
	* ======
	* @param $pd_id 	商品id
	* @param $image 	图片地址
	* ======
	* @author 洪波
	* @version 16.08.05
	*/
	public function setMainImage($pd_id, $image)
	{
		$this->update($pd_id, array('pd_image'=>$image));
	}

}