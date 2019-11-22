<?php
/**
* 文件资源控制器
* ======
* @author 洪波
* @version 17.03.03
*/
namespace app\controllers;
use core\db\Criteria;
use app\models\M_file;
use app\models\M_admin;

class FileController extends \core\web\Controller {
	/**
	* 设置[模块实体]封面照片
	* ======
	* @author 洪波
	* @version 17.03.09
	*/
	public function actionSetAvatar() {
		if ($this->isPost()) {
			if(M_admin::checkRole(M_admin::ROLE_CONTENT)) {
				$file_bid = $this->getPost('file_bid');
				$image = $this->getPost('image');
				$mod = $this->getPost('mod');

				$mod_class = '\app\models\M_' . $mod;
				if (class_exists($mod_class)) {
					$class = new $mod_class;
					if ($class->setAvatar($file_bid, $image)) {
						$this->respSuccess();
					} else {
						$this->respError(2);
					}
				} else {
					$this->respError(106);
				}
			} else {
				$this->respError(105);
			}
			$this->respJson();
		}
	}
	
	/**
	* 添加文件
	* ======
	* @author 洪波
	* @version 17.03.03
	*/
	public function actionAdd() {
		if ($this->isPost()) {
			if(M_admin::checkRole(M_admin::ROLE_CONTENT)) {
				$data = [
					'file_bid' => $this->getPost('file_bid'),
					'file_path' => $this->getPost('file_path'),
					'file_type' => $this->getPost('file_type'),
					'file_size' => $this->getPost('file_size'),
					'file_time' => time(),
					'file_status' => M_file::STATUS_OPEN
				];
				$this->model('m_file')->loadData($data);
				if ($this->model('m_file')->save()) {
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
	* 设置文件属性
	* ======
	* @author 洪波
	* @version 17.03.03
	*/
	public function actionSetInfo() {
		if ($this->isPost()) {
			if(M_admin::checkRole(M_admin::ROLE_CONTENT)) {
				$file_id = $this->getPost('file_id');
				$field = $this->getPost('field');
				$value = $this->getPost('value');
				if ($this->model('m_file')->update($file_id, [$field => $value])) {
					$this->respSuccess();
				} else {
					$this->respError(102);
				}
			} else {
				$this->respError(105);
			}
			$this->respJson();
		}
	}

	/**
	* 删除文件属性
	* ======
	* @author 洪波
	* @version 17.03.03
	*/
	public function actionDelete() {
		if ($this->isPost()) {
			if(M_admin::checkRole(M_admin::ROLE_CONTENT)) {
				$file_id = $this->getPost('file_id');
				$file_obj = $this->model('m_file')->get($file_id);
				if ($file_obj) {
					@unlink('.' . $file_obj->file_path);
					$this->m_file->delete($file_id);
					$this->respSuccess();
				} else {
					$this->respError(106);
				}
			} else {
				$this->respError(105);
			}
			$this->respJson();
		}
	}
}