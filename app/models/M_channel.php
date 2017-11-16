<?php
/**
* 栏目模型
* ======
* @author 洪波
* @version 16.07.28
*/
namespace app\models;
use core\db\Criteria;

class M_channel extends \core\web\Model {
	
	public $table_name = 't_channel';

	const STATUS_HIDE	= 1; //状态 - 隐藏
	const STATUS_OPEN	= 2; //状态 - 开放
	const STATUS_HOT	= 3; //状态 - 热点

	/**
	* 设置封面
	* ======
	* @param $cn_id 	栏目id
	* @param $image 	封面图片地址
	* ======
	* @author 洪波
	* @version 17.09.15
	*/
	public function setAvatar($cn_id, $image) {
		return $this->update($cn_id, [
			'cn_image' => $image,
			'cn_utime' => time()
		]);
	}

	/**
	* 获取父级栏目下子栏目最大排序
	* ======
	* @param $cn_fid 	栏目父级id
	* ======
	* @author 洪波
	* @version 13.10.17
	*/
	public function maxSort($cn_fid) {
		$sql = "select max(cn_sort) from " . $this->table_name . " where cn_fid='{$cn_fid}'";
		$max = $this->getDb()->queryScalar($sql);
		if($max) {
			return ++$max;
		} else {
			return 1;
		}
	}

	/**
	* 获取栏目内容详情
	* ======
	* @param $cn_id 	栏目id
	* ======
	* @author 洪波
	* @version 17.09.22
	*/
	public function getDetail($cn_id) {
		$channel = parent::get($cn_id);
		if ($channel) {
			$channel = $channel->toArray();
			if (str_replace(' ', '', $channel['cn_data']) != '{}') {
				$channel['cn_data'] = json_decode($channel['cn_data']);
			} else {
				$channel['cn_data'] = '';
			}
			return $channel;
		}
		return [];
	}

	/**
	* 仅获取栏目扩展数据
	* ======
	* @param $cn_id 	栏目id
	* ======
	* @author 洪波
	* @version 17.09.15
	*/
	public function getData($cn_id) {
		$criteria = new Criteria;
		$criteria->select = 'cn_data';
		$criteria->add('cn_id', $cn_id);
		if ($channel = $this->getOrm()->find($criteria)) {
			return json_decode($channel->cn_data);
		} else {
			return false;
		}
	}

	/**
	* 仅获取栏目内容
	* ======
	* @param $cn_id 	栏目id
	* ======
	* @author 洪波
	* @version 17.09.15
	*/
	public function getContent($cn_id) {
		$criteria = new Criteria;
		$criteria->select = 'cn_content';
		$criteria->add('cn_id', $cn_id);
		if ($channel = $this->getOrm()->find($criteria)) {
			return $channel->cn_content;
		} else {
			return false;
		}
	}

	/**
	 * [SDK]获取内容列表
	 * ======
	 * @param $offset		分页开始位置
	 * @param $limit 		分页偏移量
	 * @param $cn_fid		父内容id（单个或数组）
	 * @param $cn_status	内容状态（单个或数组）
	 * @param $get_summary 	以摘要方式显示详细内容（摘要字数）
	 * @param $order_by		排序方式（默认序号）
	 * ======
	 * @author 洪波
	 * @version 17.10.20
	 */
	public function getContentList($offset, $limit, $cn_fid, $cn_status=[2,3], $get_summary=0, $order_by=0) {
		$criteria = new Criteria;
		if (is_array($cn_fid)) {
			$criteria->addIn('cn_fid', $cn_fid);
		} else {
			$criteria->add('cn_fid', $cn_fid);
		}
		if (is_array($cn_status)) {
			$criteria->addIn('cn_status', $cn_status);
		} else {
			$criteria->add('cn_status', $cn_status);
		}
		$count = $this->getOrm()->count($criteria);
		//分页排序
		$criteria->offset = $offset;
		$criteria->limit = $limit;
		$criteria->order = ['cn_sort desc','cn_sort asc','cn_ctime desc','cn_utime desc'][$order_by];
		//获取数据列表
		$result = $this->getOrm()->findAll($criteria);
		if ($get_summary > 0) {
			foreach ($result as $k => $v) {
				$result[$k]->cn_content = \core\tools\MbString::substr(str_replace(' ', '', strip_tags($v->cn_content)), 0, $get_summary);
			}
		}
		return ['count'=>$count, 'result'=>$result];
	}

	/**
	 * [SDK]获取内容简单列表
	 * ======
	 * @param $offset		分页开始位置
	 * @param $limit 		分页偏移量
	 * @param $cn_fid		父内容id（单个或数组）
	 * ======
	 * @author 洪波
	 * @version 17.10.31
	 */
	public function getSimpleList($offset, $limit, $cn_fid, $order_by=0) {
		$criteria = new Criteria;
		$criteria->select = 'cn_id,cn_image,cn_name,cn_data,cn_ctime,cn_ctime';
		if (is_array($cn_fid)) {
			$criteria->addIn('cn_fid', $cn_fid);
		} else {
			$criteria->add('cn_fid', $cn_fid);
		}
		$criteria->add('cn_status', self::STATUS_OPEN);
		//分页排序
		$criteria->offset = $offset;
		$criteria->limit = $limit;
		$criteria->order = ['cn_sort desc','cn_sort asc','cn_ctime desc','cn_utime desc'][$order_by];
		//获取数据列表
		$count = $this->getOrm()->count($criteria);
		$result = $this->getOrm()->findAll($criteria);
		foreach ($result as $k => $v) {
			if ($result[$k]->cn_data != '{}')
				$result[$k]->cn_data = json_decode($v->cn_data);
		}
		return ['count'=>$count, 'result'=>$result];
	}

	/**
	* 面包屑路径（递归上级目录路径）
	* ======
	* @param $cn_id 目录id
	* ======
	* @author 洪波
	* @version 17.09.29
	*/
	public function breadcrumb($cn_id) {
		$path = [];
		while ($channel = $this->getOrm()->find("cn_id = '{$cn_id}'")) {
			array_unshift($path, [
				'id' => $channel->cn_id,
				'name' => $channel->cn_name
			]);
			$cn_id = $channel->cn_fid;
		}
		return $path;
	}

	/**
	* 递归删除栏目
	* ======
	* @param $cn_id 栏目id
	* ======
	* @author 洪波
	* @version 17.09.15
	*/
	public function recursionDelete($cn_id) {
		$children = $this->getOrm()->findAll("cn_fid = '{$cn_id}'");
		foreach ($children as $child) {
			$this->recursionDelete($child->cn_id);
		}
		parent::delete($cn_id);
	}
}