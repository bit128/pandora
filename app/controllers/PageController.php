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

class PageController extends \core\web\Controller
{

    public function actionAdd()
    {
        if (Autumn::app()->request->isPost())
        {
            if(M_admin::checkRole(M_admin::ROLE_CONTENT))
			{}
            else
            {}
        }
    }
}