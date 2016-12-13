<?php
/**
* 内容模型
* ======
* @author 洪波
* @version 16.07.28
*/
namespace app\models;
use core\Model;

class M_content_note extends Model
{
    public $table_name = 't_content_note';

    const STATUS_HIDE = 0;
    const STATUS_OPEN = 1;
}