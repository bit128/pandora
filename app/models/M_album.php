<?php
/**
* 相册模型
* ======
* @author 洪波
* @version 16.08.03
*/
namespace app\models;
use core\Model;
use core\Criteria;
use core\Orm;

class M_album extends Model
{
	const STATUS_SHOW	= 1;
	const STATUS_HIDE	= 0;

	public $table_name = 't_album';

	/**
	* 获取图片在相册中最大排序
	* ======
	* @param $by_id 	目标实体id
	* ======
	* @author 洪波
	* @version 16.08.05
	*/
	public function maxSort($by_id)
	{
		$sql = "select max(al_sort) from " . $this->table_name . " where by_id='{$by_id}'";
		$max = Orm::model($this->table_name)
			->getDb()
			->queryScalar($sql);
		if($max)
		{
			return ++$max;
		}
		else
		{
			return 1;
		}
	}

	/**
	* 获取实体最小排序图片
	* ======
	* @param $al_id 	图片id
	* ======
	* @author 洪波
	* @version 16.08.05
	*/
	public function getMinImage($by_id)
	{
		$sql = "select al_type,al_image from ".$this->table_name." where by_id='{$by_id}' order by al_sort asc limit 1";
		return Orm::model($this->table_name)
			->getDb()
			->queryRow($sql);
	}

	/**
	* 设置图片排序
	* ======
	* @param $al_id 	栏目id
	* @param $by_id 	作用对象栏目id
	* @param $type 		排序方式
	* ======
	* @author 洪波
	* @version 16.08.05
	*/
	public function setSort($al_id, $by_id, $type)
	{
		//获取作用对象序号
		$pointer = Orm::model($this->table_name)
			->getDb()
			->queryScalar("select al_sort from t_album where al_id = '{$al_id}'");
		//相对位置前
		if($type == 'prev')
		{
			$sql = "select al_id,al_sort from t_album where al_sort < {$pointer} and by_id = '{$by_id}' order by al_sort desc limit 1";
		}
		//相对位置后
		else if ($type == 'next')
		{
			$sql = "select al_id,al_sort from t_album where al_sort > {$pointer} and by_id = '{$by_id}' order by al_sort asc limit 1";
		}
		//获取被作用对象序号
		$oppo = Orm::model($this->table_name)
			->getDb()
			->queryRow($sql);
		if($oppo)
		{
			$oppo_sort = $oppo->al_sort;
			//更新作用对象
			$this->update($al_id, array('al_sort'=>$oppo_sort));
			//更新被作用对象
			$this->update($oppo->al_id, array('al_sort'=>$pointer));
			return true;
		}
		else
		{
			return false;
		}
	}

	/**
	* 通过实体id删除图片
	* ======
	* @param $by_id 	实体id
	* ======
	* @author 洪波
	* @version 16.08.06
	*/
	public function deleteById($by_id)
	{
		$criteria = new Criteria;
		$criteria->add('by_id', $by_id);
		return Orm::model($this->table_name)->deleteAll($criteria);
	}

}