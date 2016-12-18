<?php
/**
* 栏目模型
* ======
* @author 洪波
* @version 16.07.28
*/
namespace app\models;
use core\Model;
use core\Orm;
use core\Criteria;

class M_channel extends Model
{

	const STATUS_HIDE	= 0;
	const STATUS_OPEN	= 1;

	public $table_name = 't_channel';

	/**
	* 判断是否为父级栏目
	* ======
	* @param $cn_id 	栏目id
	* ======
	* @author 洪波
	* @version 16.04.21
	*/
	public function isParent($cn_id)
	{
		$criteria = new Criteria;
		$criteria->add('cn_id', $cn_id);
		$count = Orm::model($this->table_name)->count("cn_fid = '{$cn_id}'");
		if($count)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	/**
	* 获取父级栏目下子栏目最大排序
	* ======
	* @param $cn_fid 	栏目父级id
	* ======
	* @author 洪波
	* @version 13.10.17
	*/
	private function maxSort($cn_fid)
	{
		$sql = "select max(cn_sort) from " . $this->table_name . " where cn_fid='{$cn_fid}'";
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
	* 添加新栏目
	* ======
	* @param $cn_fid 	栏目父id
	* @param $cn_name 	栏目名称
	* ======
	* @author 洪波
	* @version 13.10.17
	*/
	public function add($cn_fid, $cn_name)
	{
		$data = array(
			'cn_id' => uniqid(),
			'cn_fid' => $cn_fid,
			'cn_name' => $cn_name,
			'cn_nick' => '',
			'cn_url' => '',
			'cn_time' => time(),
			'cn_sort' => $this->maxSort($cn_fid),
			'cn_admin' => '',
			'cn_status' => self::STATUS_OPEN
			);

		if($this->insert($data))
		{
			return $data['cn_id'];
		}
		else
		{
			return false;
		}
	}

	/**
	* 获取栏目树结构
	* ======
	* @param $cn_fid 	栏目父级id
	* ======
	* @author 洪波
	* @version 14.12.25
	*/
	public function getTreeList($cn_fid)
	{
		$criteria = new Criteria;
		$criteria->add('cn_fid', $cn_fid);
		$criteria->order = 'cn_sort asc';
		$list = Orm::model($this->table_name)->findAll($criteria);
		//拼装结构
		$tree = array();
		foreach ($list as $v)
		{
			$item = array(
				'id' => $v->cn_id,
				'name' => $v->cn_name,
				'status' => $v->cn_status,
				'isParent' => $this->isParent($v->cn_id) ? 'true' : 'false'
				);
			$tree[] = $item;
		}
		return $tree;
	}

	/**
	* 获取栏目全部子孙节点
	* ======
	* @param $cn_id 	父栏目id
	* @param $self 		是否包含父栏目id
	* ======
	* @author 洪波
	* @version 16.08.12
	*/
	public function getChildIds($cn_id, $self = true)
	{
		$result = array();
		if($self)
		{
			$result[] = $cn_id;
		}
		$condition = array($cn_id);
		//迭代子目录
		do {
			$list = Orm::model($this->table_name)
				->getDb()
				->queryAll("select cn_id from t_channel where cn_fid in ('".implode("','", $condition)."')");
			$rs = array();
			foreach ($list as $v)
			{
				$result[] = $v->cn_id;
				$rs[] = $v->cn_id;
			}
			$condition = $rs;
		} while ($condition);
		unset($condition);
		return $result;
	}

	/**
	* 设置栏目排序
	* ======
	* @param $cn_id 	栏目id
	* @param $cn_fid 	父级栏目id
	* @param $by_id 	作用对象栏目id
	* @param $type 		排序方式
	* ======
	* @author 洪波
	* @version 14.12.27
	*/
	public function setSort($cn_id, $cn_fid, $by_id, $type)
	{
		$data = array(
			'cn_fid' => $cn_fid
			);
		//如果作为子对象被添加，则排到尾端
		if($type == 'inner')
		{
			$sort_id = $this->maxSort($cn_fid);
			$data['cn_sort'] = $sort_id;
			$this->update($cn_id, $data);
		}
		//否则是同级别排序
		else
		{
			$data['cn_sort'] = '0';
			//$this->update($cn_id, $data);
			//取作用栏目序号
			$pointer = Orm::model($this->table_name)
				->getDb()
				->queryScalar("select cn_sort from t_channel where cn_id = '{$by_id}'");
			//相对位置前
			if($type == 'prev')
			{
				$sql = "update t_channel set cn_sort=cn_sort+1 where cn_sort >= '{$pointer}' and cn_fid = '{$cn_fid}'";
				Orm::model($this->table_name)
					->getDb()
					->query($sql);
				//更新当前栏目序号
				$this->update($cn_id, array('cn_sort'=>$pointer));
			}
			//相对位置后
			else if ($type == 'next')
			{
				$sql = "update t_channel set cn_sort=cn_sort+1 where cn_sort > '{$pointer}' and cn_fid = '{$cn_fid}'";
				Orm::model($this->table_name)
					->getDb()
					->query($sql);
				//更新当前栏目序号
				$pointer += 1;
				$this->update($cn_id, array('cn_sort'=>$pointer));
			}
		}
	}
}