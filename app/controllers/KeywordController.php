<?php
/**
*  关键词控制器
* ======
* @author 洪波
* @version 16.09.23
*/
namespace app\controllers;
use core\db\Criteria;
use app\models\T_admin;

class KeywordController extends \core\web\Controller {
    /**
    * 增加关键词
    * ======
    * @author 洪波
    * @version 17.09.23
    */
    public function actionAdd() {
        if ($this->isPost()) {
			if(T_admin::checkRole(T_admin::ROLE_CONTENT)) {
				$data = [
                    'kw_name' => $this->getPost('kw_name'),
					'kw_time' => time()
				];
				$this->model('t_keyword')->loadData($data);
				if ($this->model('t_keyword')->save()) {
					$this->respSuccess();
				} else {
					$this->respError(2);
				}
			} else {
				$this->respError(105);
			}
			$this->respJson();
		}
	}
	
	/**
	* 获取关键词列表
	* ======
	* @author 洪波
	* @version 17.09.24
	*/
	public function actionGetList() {
		if ($this->isPost()) {
			if(T_admin::checkRole(T_admin::ROLE_CONTENT)) {
				$sort = $this->getPost('sort', 0);
				$keyword = $this->getPost('keyword', '');
				//查询条件
				$criteria = new Criteria;
				$criteria->offset = $this->getPost('offset', 0);
				$criteria->limit = $this->getPost('limit', 5);
				if ($keyword != '') {
					$criteria->addCondition("kw_name like '%{$keyword}%'");
				}
				$criteria->order = [
					'kw_time desc',
					'kw_search desc',
					'kw_use desc'
				][$sort];
				$this->respSuccess($this->model('t_keyword')->getList($criteria));
			} else {
				$this->respError(105);
			}
			$this->respJson();
		}
	}

    /**
    * 删除关键词
    * ======
    * @author 洪波
    * @version 17.09.23
    */
    public function actionDelete() {
        if ($this->isPost()) {
			if(T_admin::checkRole(T_admin::ROLE_CONTENT)) {
				if ($this->model('t_keyword')->delete($this->getPost('kw_id'))) {
					$this->respSuccess();
				} else {
					$this->respError(2);
				}
			} else {
				$this->respError(105);
			}
			$this->respJson();
		}
    }
}