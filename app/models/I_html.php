<?php
/**
* 富文本读写接口
* ======
* @author 洪波
* @version 19.12.19
*/
namespace app\models;

interface I_html {

    const MATCH_MODEL = ['channel'];

    /**
     * 获取内容详情
     * ======
     * @author 洪波
     * @version 19.12.19
     */
    public function getHtml($id);

    /**
     * 设置内容详情
     * ======
     * @author 洪波
     * @version 19.12.19
     */
    public function setHtml($id, $content);
}