<?php
/**
* 关键词统计模型
* ======
* @author 洪波
* @version 16.09.23
*/
namespace app\models;
use core\db\Criteria;

class M_keyword extends \core\web\Model
{
    public $table_name = 't_keyword';

    /**
    * 使用计数
    * ======
    * @param $kw_name   关键词
    * ======
    * @author 洪波
    * @version 17.09.24
    */
    public function useCount($kw_name)
    {
        $criteria = new Criteria;
        $criteria->add('kw_name', $kw_name);
        $keyword = $this->getOrm()->find($criteria);
        if ($keyword)
        {
            $keyword->kw_use++;
            return $keyword->save();
        }
        else
        {
            $data = [
                'kw_name' => $kw_name,
                'kw_time' => time(),
                'kw_use' => 1
            ];
            $this->load($data);
            return $this->save();
        }
    }
}