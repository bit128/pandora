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

	const TYPE_CONTENT = 1; //收藏类型 - 内容

	public $table_name = 't_collect';

	/**
	* 判断是否收藏过
	* ======
	* @param $by_id 	实体id
	* @param $user_id 	用户id
	* ======
	* @author 洪波
	* @version 17.02.14
	*/
	public function exist($by_id, $user_id)
	{
		$criteria = new Criteria;
		$criteria->add('by_id', $by_id);
		$criteria->add('user_id', $user_id);
		if ($this->count($criteria))
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	/**
	* 获取收藏夹内容列表
	* ======
	* @param $offset 	查询位置
	* @param $limit 	偏移量
	* @param $user_id 	用户id
	* ======
	* @author 洪波
	* @version 17.02.14
	*/
	public function getContentList($offset, $limit, $user_id)
	{
		$criteria = new Criteria;
		$criteria->add('user_id', $user_id);
		$criteria->add('cl_type', self::TYPE_CONTENT);
		//统计数量
		$count = $this->count($criteria);
		//联合product
		$criteria->select = $this->table_name . '.*,t_content.ct_title,t_content.ct_image,t_content.ct_detail';
		$criteria->union('t_content', $this->table_name . '.by_id=t_content.ct_id', 'left');
		//分页排序
		$criteria->offset = $offset;
		$criteria->limit = $limit;
		$criteria->order = 'cl_time asc';
		//获取数据列表
		$list = Orm::model($this->table_name)->findAll($criteria);

		return array(
			'count' => $count,
			'result' => $list
			);
	}

	/**
	* 根据实体id删除收藏
	* ======
	* @param $cl_type 	收藏类型
	* @param $by_id 	实体id
	* @param $user_id 	用户id
	* ======
	* @author 洪波
	* @version 17.02.14
	*/
	public function deleteByEntry($cl_type, $by_id, $user_id = '')
	{
		$criteria = new Criteria;
		$criteria->add('cl_type', $cl_type);
		$criteria->add('by_id', $by_id);
		if ($user_id != '')
			$criteria->add('user_id', $user_id);

		return Orm::model($this->table_name)->deleteAll($criteria);
	}
}