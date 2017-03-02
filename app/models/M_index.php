<?php
/**
* 搜索索引模型
* ======
* @author 洪波
* @version 16.08.07
*/
namespace app\models;
use core\db\Criteria;

class M_index extends \core\web\Model
{

	public $table_name = 't_index';

	/**
	* 判断索引是否存在
	* ======
	* @param $dc_id 	词汇id
	* @param $by_id 	实体id
	* ======
	* @author 洪波
	* @version 16.08.10
	*/
	public function exist($dc_id, $by_id)
	{
		$criteria = new Criteria;
		$criteria->add('dc_id', $dc_id);
		$criteria->add('by_id', $by_id);
		return $this->orm->count($criteria);
	}

	/**
	* 获取实体索引列表
	* ======
	* @param $by_id 	实体id
	* ======
	* @author 洪波
	* @version 16.08.10
	*/
	public function getIndex($by_id)
	{
		$sql = "select a.dc_id,b.dc_keyword from t_index as a,t_dictionary as b where a.by_id='{$by_id}' and b.dc_id=a.dc_id";
		return $this->orm
			->getDb()
			->queryAll($sql);
	}

	/**
	* 删除实体索引
	* ======
	* @param $dc_id 	词汇id
	* @param $by_id 	实体id
	* ======
	* @author 洪波
	* @version 17.01.23
	*/
	public function deleteIndex($dc_id, $by_id)
	{
		$criteria = new Criteria;
		if($dc_id != '')
		{
			$criteria->add('dc_id', $dc_id);
		}
		if ($by_id != '')
		{
			$criteria->add('by_id', $by_id);
		}
		return $this->orm->deleteAll($criteria);
	}

}