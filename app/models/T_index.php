<?php
/**
* 关键词索引模型
* ======
* @author 洪波
* @version 16.09.23
*/
namespace app\models;
use core\db\Criteria;

class T_index extends \core\web\Model {

    /**
    * 删除栏目内容索引
    * ======
    * @param $cn_id     栏目id
    * ======
    * @author 洪波
    * @version 17.09.24
    */
    public function deleteByChannel($cn_id) {
        $criteria = new Criteria;
        $criteria->add('id_channel', $cn_id);
        return $this->getOrm()->deleteAll($criteria);
    }
}