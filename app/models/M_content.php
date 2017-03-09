<?php
/**
* 内容模型
* ======
* @author 洪波
* @version 16.07.28
*/
namespace app\models;
use core\db\Criteria;

class M_content extends \core\web\Model
{

	const STATUS_HIDE	= 0; //状态 - 隐藏
	const STATUS_OPEN	= 1; //状态 - 开放
	const STATUS_HOT	= 2; //状态 - 推荐

	public $table_name = 't_content';

	/**
	* 增加内容访问量
	* ======
	* @param $ct_id 内容id
	* ======
	* @author 洪波
	* @version 17.02.09
	*/
	public function addViewCount($ct_id)
	{
		$sql = "update {$this->table_name} set ct_view=ct_view+1 where ct_id = '{$ct_id}'";
		return $this->orm
			->getDb()
			->query($sql);
	}

	/**
	* 统计栏目包含内容数量
	* ======
	* @param $cn_id 	栏目id
	* @param $status 	栏目状态
	* ======
	* @author 洪波
	* @version 16.04.21
	*/
	public function countContent($cn_id, $status = -1)
	{
		$criteria = new Criteria;
		$criteria->add('cn_id', $cn_id);
		if($status != -1)
		{
			$criteria->add('ct_status', $status);
		}
		return $this->orm->count($criteria);
	}

	/**
	* 新建扩展内容
	* ======
	* @param $cn_id 	栏目id
	* ======
	* @author 洪波
	* @version 16.07.31
	*/
	public function addExtra($ct_id, $cn_id = '')
	{
		$time = time();
		$data = array(
			'ct_id' => $ct_id,
			'cn_id' => $cn_id,
			'ct_title' => '新建扩展内容',
			'ct_ctime' => $time,
			'ct_utime' => $time,
			'ct_status' => self::STATUS_OPEN
			);
		$this->load($data);
		if($this->save())
		{
			return $ct_id;
		}
	}

	/**
	* 获取内容列表
	* ======
	* @param $offset 	分页位置
	* @param $limit 	偏移量
	* @param $cn_id 	栏目id
	* @param $sort 		排序方式
	* @param $ct_status 内容状态
	* ======
	* @author 洪波
	* @version 16.07.31
	*/
	public function getContentList($offset, $limit, $cn_id = '', $sort = 0, $ct_status = -1)
	{
		$criteria = new Criteria;
		if ($cn_id != '')
		{
			$criteria->add('cn_id', $cn_id);
		}
		if ($ct_status != -1)
		{
			$criteria->add('ct_status', $ct_status);
		}
		//统计数量
		$count = $this->orm->count($criteria);
		//分页
		$criteria->offset = $offset;
		$criteria->limit = $limit;
		//排序
		$sorts = array(
			'ct_ctime desc',
			'ct_ctime asc',
			'ct_utime desc',
			'ct_utime asc'
			);
		$criteria->order = $sorts[$sort];
		//获取数据列表
		$list = $this->orm->findAll($criteria);
		$result = array();
		$m_index = new M_index;
		foreach ($list as $k => $v)
		{
			$result[$k] = $v;
			$result[$k]->indexs = $m_index->getIndex($v->ct_id);
		}

		return array(
			'count' => $count,
			'result' => $result
			);
	}

}