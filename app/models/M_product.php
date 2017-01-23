<?php
/**
* 商品模型
* ======
* @author 洪波
* @version 16.08.03
*/
namespace app\models;
use core\Model;
use core\Criteria;
use core\Orm;

class M_product extends Model
{
	const STATUS_OPEN	= 1;
	const STATUS_HIDE	= 0;

	public $table_name = 't_product';

	/**
	* 设置商品主图[协议接口]
	* ======
	* @param $pd_id 	商品id
	* @param $image 	图片地址
	* ======
	* @author 洪波
	* @version 16.08.05
	*/
	public function setMainImage($pd_id, $image)
	{
		$this->update($pd_id, array('pd_image'=>$image));
	}

	/**
	* 搜索产品列表
	* ======
	* @param $offset 	查询位置
	* @param $limit 	偏移量
	* @param $dict 		搜索分类
	* @param $keyword 	关键字
	* @param $all 		全部商品
	* ======
	* @author 洪波
	* @version 17.01.23
	*/
	public function getProductList($offset, $limit, $dict, $keyword, $all = false)
	{
		$m_dictionary = new \app\models\M_dictionary;
		$criteria = new \core\Criteria;
		$criteria->select = 't_product.*,t_content.ct_title';
		if(! $all)
		{
			$criteria->add('pd_status', self::STATUS_OPEN);
		}
		//搜索关键字
		$kr = explode(' ', trim($keyword));
		$pd_ids = $m_dictionary->getEntryIds($kr);
		//搜索分类
		$dict_arr = array_unique(explode('-', $dict));
		$pd_ids += $m_dictionary->getEntryIds($dict_arr, 'dc_id');
		//条件查询
		if($keyword != '' || $dict != '')
		{
			if($pd_ids)
			{
				$criteria->addIn('pd_id', $pd_ids);
			}
			else if ($keyword != '')
			{
				$criteria->addCondition("pd_name like '%{$keyword}%'");
			}
			else
			{
				$criteria->add('pd_id', 0);
			}
		}
		//统计总数
		$count = Orm::model($this->table_name)->count($criteria);
		//联合内容表获取数据列表
		$criteria->union('t_content', 't_product.pd_id=t_content.ct_id');
		$criteria->offset = $offset;
		$criteria->limit = $limit;
		$criteria->order = 'pd_sort asc';
		$result = Orm::model($this->table_name)->findAll($criteria);

		return array(
			'count' => $count,
			'result' => $result
		);
	}

}