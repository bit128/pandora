<?php
/**
* 文件资源模型
* ======
* @author 洪波
* @version 17.03.03
*/
namespace app\models;
use core\db\Criteria;

class T_file extends \core\web\Model {

    const STATUS_DELETE = 0;
    const STATUS_NORMAL = 1;
    const STATUS_OPEN   = 2;
}