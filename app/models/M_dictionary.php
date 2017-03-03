<?php
/**
* 索引词库模型
* ======
* @author 洪波
* @version 16.08.07
*/
namespace app\models;
use core\db\Criteria;

class M_dictionary extends \core\web\Model
{

	public $table_name = 't_dictionary';

	/**
	* 新增词汇
	* ======
	* @param $dc_fid 		类型
	* @param $dc_keyword 	关键字
	* ======
	* @author 洪波
	* @version 16.08.10
	*/
	public function add($dc_fid, $dc_keyword)
	{
		$data = array(
			'dc_fid' => $dc_fid,
			'dc_keyword' => $dc_keyword,
			'dc_time' => time()
			);
		$this->load($data);
		return $this->save();
	}

	/**
	* 通过关键词获取实体id
	* ======
	* @param $dc_keyword 	关键词
	* ======
	* @author 洪波
	* @version 16.08.11
	*/
	public function getEntryIds(array $keyword, $by_field = 'dc_keyword')
	{
		$keyword = array_filter($keyword);
		sort($keyword);
		$field = 'b.' . $by_field;
		$sql = "select distinct(a.by_id),{$field} from t_index as a,t_dictionary as b where {$field} in ('".implode("','", $keyword)."') and a.dc_id=b.dc_id";
		$result = array();
		$list = $this->orm
			->getDb()
			->queryAll($sql);
		foreach ($list as $v)
		{
			$result[$v->by_id][] = $v->$by_field;
		}
		$ids = array();
		foreach ($result as $k => $v)
		{
			sort($v);
			if(array_unique($v) == $keyword)
				$ids[] = $k;
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
		return $this->orm
			->getDb()
			->query($sql);
	}
}