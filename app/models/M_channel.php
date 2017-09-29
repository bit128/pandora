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