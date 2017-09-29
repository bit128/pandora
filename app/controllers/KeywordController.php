<?php
/**
*  关键词控制器
* ======
* @author 洪波
* @version 16.09.23
*/
namespace app\controllers;
use core\Autumn;
use core\db\Criteria;
use core\http\Response;
use app\models\M_admin;

class KeywordController extends \core\web\Controller {
    /**
    * 增加关键词
    * ======
    * @author 洪波
    * @version 17.09.23
    */
    public function actionAdd() {
        if (Autumn::app()->request->isPost()) {
			if(M_admin::checkRole(M_admin::ROLE_CONTENT)) {
				$data = [
                    'kw_name' => Autumn::app()->request->getPost('kw_name'),
					'kw_time' => time()
				];
				$this->model('m_keyword')->loadData($data);
				if ($this->model('m_keyword')->save()) {
					Autumn::app()->response->setResult(Response::RES_OK);
				} else {
					Autumn::app()->response->setResult(Response::RES_FAIL);
				}
			} else {
				Autumn::app()->response->setResult(Response::RES_REFUSE);
			}
			Autumn::app()->response->json();
		}
	}
	
	/**
	* 获取关键词列表
	* ======
	* @author 洪波
	* @version 17.09.24
	*/
	public function actionGetList() {
		if (Autumn::app()->request->isPost()) {
			if(M_admin::checkRole(M_admin::ROLE_CONTENT)) {
				$sort = Autumn::app()->request->getPost('sort', 0);
				$keyword = Autumn::app()->request->getPost('keyword', '');
				//查询条件
				$criteria = new Criteria;
				$criteria->offset = Autumn::app()->request->getPost('offset', 0);
				$criteria->limit = Autumn::app()->request->getPost('limit', 5);
				if ($keyword != '') {
					$criteria->addCondition("kw_name like '%{$keyword}%'");
				}
				$criteria->order = [
					'kw_time desc',
					'kw_search desc',
					'kw_use desc'
				][$sort];
				Autumn::app()->response->setResult($this->model('m_keyword')->getList($criteria));
			} else {
				Autumn::app()->response->setResult(Response::RES_REFUSE);
			}
			Autumn::app()->response->json();
		}
	}

    /**
    * 删除关键词
    * ======
    * @author 洪波
    * @version 17.09.23
    */
    public function actionDelete() {
        if (Autumn::app()->request->isPost()) {
			if(M_admin::checkRole(M_admin::ROLE_CONTENT)) {
				if ($this->model('m_keyword')->delete(Autumn::app()->request->getPost('kw_id'))) {
					Autumn::app()->response->setResult(Response::RES_OK);
				} else {
					Autumn::app()->response->setResult(Response::RES_FAIL);
				}
			} else {
				Autumn::app()->response->setResult(Response::RES_REFUSE);
			}
			Autumn::app()->response->json();
		}
    }
}