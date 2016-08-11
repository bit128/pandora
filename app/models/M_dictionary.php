<?php
/**
* 索引词库模型
* ======
* @author 洪波
* @version 16.08.07
*/
namespace app\models;
use core\Model;
use core\Criteria;
use core\Orm;

class M_dictionary extends Model
{
	const TYPE_NORMAL	= 0;
	const TYPE_PRODUCT	= 1;

	public $table_name = 't_dictionary';

	public static $_types = array(
		self::TYPE_NORMAL => '默认',
		self::TYPE_PRODUCT => '产品分类'
		);

	/**
	* 新增词汇
	* ======
	* @param $keyword 	关键字
	* @param $type 		类型
	* ======
	* @author 洪波
	* @version 16.08.10
	*/
	public function add($keyword, $type = self::TYPE_NORMAL)
	{
		$data = array(
			'dc_keyword' => $keyword,
			'dc_type' => $type,
			'dc_time' => time()
			);
		return $this->insert($data);
	}

	/**
	* 通过索引词获取id
	* ======
	* @param $dc_keyword 	关键词
	* @param $write 		不存在是否写入
	* ======
	* @author 洪波
	* @version 16.08.07
	*/
	public function getId($dc_keyword, $write = false)
	{
		$criteria = new Criteria;
		$criteria->add('dc_keyword', $dc_keyword);
		$dictionary = Orm::model($this->table_name)->find($criteria);
		if($dictionary)
		{
			$this->addCount($dictionary->dc_id);
			return $dictionary->dc_id;
		}
		else
		{
			if($write)
			{
				return $this->add($dc_keyword);
			}
			return false;
		}
	}

	/**
	* 通过关键词获取实体id
	* ======
	* @param $dc_keyword 	关键词
	* ======
	* @author 洪波
	* @version 16.08.11
	*/
	public function getEntryIds($dc_keyword)
	{
		if(is_array($dc_keyword))
		{
			$sql = "select distinct(a.by_id) from t_index as a,t_dictionary as b where b.dc_keyword in ('".implode("','", $dc_keyword)."') and a.dc_id=b.dc_id";
		}
		else
		{
			$sql = "select distinct(a.by_id) from t_index as a,t_dictionary as b where b.dc_keyword='{$dc_keyword}' and a.dc_id=b.dc_id";
		}
		$ids = array();
		$result = Orm::model($this->table_name)
			->getDb()
			->queryAll($sql);
		foreach ($result as $v)
		{
			$ids[] = $v->by_id;
		}
		return $ids;
	}

	/**
	* 增加词汇用量
	* ======
	* @param $dc_id 	词汇id
	* ======
	* @author 洪波
	* @version 16.08.10
	*/
	public function addCount($dc_id)
	{
		$sql = "update t_dictionary set dc_count=dc_count+1 where dc_id='{$dc_id}'";
		return Orm::model($this->table_name)
			->getDb()
			->query($sql);
	}
}