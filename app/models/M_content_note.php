<?php
/**
* 内容模型
* ======
* @author 洪波
* @version 16.07.28
*/
namespace app\models;
use core\Model;
use core\Orm;
use core\Criteria;

class M_content_note extends Model
{
    public $table_name = 't_content_note';

    const STATUS_HIDE = 0;
    const STATUS_OPEN = 1;

    /**
    * 获取文章留言列表
    * ======
    * @param $offset    查询位置
    * @param $limit     偏移量
    * @param $ct_id     文章id
    * ======
    * @author 洪波
    * @version 17.02.14
    */
    public function getNoteList($offset, $limit, $ct_id)
    {
        $criteria = new Criteria;
        $criteria->add('ct_id', $ct_id);
        $criteria->add('tn_status', self::STATUS_OPEN);
        //统计数量
        $count = $this->count($criteria);
        //联查user信息
        $criteria->select = $this->table_name . '.*,t_user.user_name,t_user.user_avatar';
        $criteria->union('t_user', 't_user.user_id=' . $this->table_name . '.user_id', 'left');
        //分页排序
        $criteria->offset = $offset;
        $criteria->limit = $limit;
        $criteria->order = 'tn_time asc';
        $result = Orm::model($this->table_name)->findAll($criteria);

        return array(
            'count' => $count,
            'result' => $result
        );
    }

     /**
    * 获取我的文章留言列表
    * ======
    * @param $offset    查询位置
    * @param $limit     偏移量
    * @param $user_id   用户id
    * ======
    * @author 洪波
    * @version 17.02.14
    */
    public function myNoteList($offset, $limit, $user_id)
    {
        $criteria = new Criteria;
        $criteria->add('user_id', $user_id);
        //统计数量
        $count = $this->count($criteria);
        //联查user信息
        $criteria->select = $this->table_name . '.*,t_content.ct_title';
        $criteria->union('t_content', 't_content.ct_id=' . $this->table_name . '.ct_id', 'left');
        //分页排序
        $criteria->offset = $offset;
        $criteria->limit = $limit;
        $criteria->order = 'tn_time asc';
        $result = Orm::model($this->table_name)->findAll($criteria);

        return array(
            'count' => $count,
            'result' => $result
        );
    }

    /**
    * 删除内容下全部评论
    * ======
    * @author 洪波
    * @version 17.02.15
    */
    public function deleteByContent($ct_id)
    {
        return Orm::model($this->table_name)->deleteAll("ct_id = '{$ct_id}'");
    }
}