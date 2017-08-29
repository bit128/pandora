<?php
/**
* 管理员控制器
* ======
* @author 洪波
* @version 17.08.24
*/
namespace app\controllers;
use core\Autumn;
use core\http\Response;
use app\models\M_admin;
use app\models\M_page;

class PageController extends \core\web\Controller
{

    public function actionAdd()
    {
        if (Autumn::app()->request->isPost())
        {
            if(M_admin::checkRole(M_admin::ROLE_CONTENT))
			{
                $data = [
                    //'page_id' => $this->m_page->newId(),
                    'page_name' => '新页面',
                    'page_type' => M_page::TYPE_PAGE,
                    'page_head' => 0,
                    'page_foot' => 0,
                    'page_utime' => time(),
                    'page_status' => M_Page::STATUS_NORMAL
                ];
                $this->m_page->load($data);
                if ($this->m_page->save())
                {
                    Autumn::app()->response->setResult(Response::RES_OK);
                }
                else
                {
                    Autumn::app()->response->setResult(Response::RES_FAIL);
                }
            }
            else
            {
                Autumn::app()->response->setResult(Response::RES_FAIL);
            }
            Autumn::app()->response->json();
        }
    }
}