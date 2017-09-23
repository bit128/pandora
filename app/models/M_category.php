<?php
/**
* 类目模型
* ======
* @author 洪波
* @version 16.08.07
*/
namespace app\models;
use core\db\Criteria;

class M_category extends \core\web\Model
{
	public $table_name = 't_category';

	/**
	* 设置封面
	* ======
	* @param $ca_id 	词汇id
	* @param $image 	封面图片地址
	* ======
	* @author 洪波
	* @version 17.09.21
	*/
	public function setAvatar($ca_id, $image)
	{
		return $this->update($ca_id, ['ca_image' => $image]);
	}

	/**
	* 新增类目
	* ======
	* @param $dc_fid 		类型
	* @param $dc_keyword 	关键字
	* ======
	* @author 洪波
	* @version 16.09.21
	*/
	public function add($ca_fid, $ca_name)
	{
		$data = array(
			'ca_fid' => $ca_fid,
			'ca_name' => $ca_name,
			'ca_time' => time()
			);
		$this->load($data);
		return $this->save();
	}

	/**
	* 【批量】获取类目名称
	* ======
	* @param $ca_ids	类目id列表
	* ======
	* @author 洪波
	* @version 17.09.23
	*/
	public function getMultiNames(array $ca_ids)
	{
		$criteria = new Criteria;
		$criteria->select = 'ca_id,ca_name';
		$criteria->addIn('ca_id', $ca_ids);
		$result = [];
		foreach ($this->getOrm()->findAll($criteria) as $item)
		{
			$result[$item->ca_id] = $item->ca_name;
		}
		return $result;
	}

	/**
	* 递归删除类目
	* ======
	* @param $ca_id 类目id
	* ======
	* @author 洪波
	* @version 17.09.22
	*/
	public function recursionDelete($ca_id)
	{
		$children = $this->getOrm()->findAll("ca_fid = '{$ca_id}'");
		foreach ($children as $child)
		{
			$this->recursionDelete($child->ca_id);
		}
		parent::delete($ca_id);
	}
	
	/**
	* 通过关键词获取实体id
	* ======
	* @param $dc_keyword 	关键词
	* ======
	* @author 洪波
	* @version 16.08.11
	*//*
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
	}*/
}