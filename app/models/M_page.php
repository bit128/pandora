<?php
/**
* 收藏夹模型
* ======
* @author 洪波
* @version 17.08.24
*/
namespace app\models;
use core\db\Criteria;

class M_page extends \core\web\Model
{
    const STATUS_NORMAL = 1; //状态 - 正常使用
    const STATUS_LOCK   = 0; //状态 - 隐藏锁定

    const TYPE_PAGE = 1; //页面类型 - 页面
    const TYPE_TEMP = 2; //页面类型 - 模版

    public $table_name = 't_page';
/*
    public function newId()
    {
        do {
            $id = '6' . rand(11111, 99999);
        } while ($this->getOrm()->count('page_id=' . $id));
        return $id;
    }*/
}