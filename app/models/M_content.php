<?php
/**
* 内容模型
* ======
* @author 洪波
* @version 16.07.28
*/
namespace app\models;
use core\Model;
use core\Criteria;
use core\Orm;

class M_content extends Model
{

	const STATUS_HIDE	= 0; //状态 - 隐藏
	const STATUS_OPEN	= 1; //状态 - 开放
	const STATUS_HOT	= 2; //状态 - 推荐

	public $table_name = 't_content';

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
		return $this->count($criteria);
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
		if($this->insert($data))
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
	public function getContentList($offset, $limit, $cn_id, $sort = 0, $ct_status = -1)
	{
		$criteria = new Criteria;
		$criteria->add('cn_id', $cn_id);
		if($ct_status != -1)
		{
			$criteria->add('ct_status', $ct_status);
		}
		//统计数量
		$count = $this->count($criteria);
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
		$list = Orm::model($this->table_name)->findAll($criteria);

		return array(
			'count' => $count,
			'result' => $list
			);
	}

}