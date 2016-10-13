<?php
/**
* 地址簿模型
* ======
* @author 洪波
* @version 16.08.18
*/
namespace app\models;
use core\Model;
use core\Criteria;
use core\Orm;

class M_address extends Model
{
	const TYPE_NORMAL	= 0; //状态-普通
	const TYPE_DEFAULT	= 1; //状态-默认

	const CT_LIMIT		= 9; //数量限制（拥有地址数量）

	public $table_name = 't_address';
}