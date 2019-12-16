<?php
/**
* 栏目控制器
* ======
* @author 洪波
* @version 16.07.29
*/
namespace app\controllers;
use core\db\Criteria;
use app\models\T_channel;
use app\models\T_index;
use app\models\T_admin;

class ChannelController extends \core\web\Controller {
	/**
	* 添加栏目
	* ======
	* @author 洪波
	* @version 16.04.22
	*/
	public function actionAdd() {
		if($this->isPost()) {
			if(T_admin::checkRole(T_admin::ROLE_CONTENT)) {
				$cn_fid = $this->getPost('cn_fid', '0');
				$t_channel = new T_channel;
				$data = [
					'cn_fid' => $cn_fid,
					'cn_name' => '新建栏目',
					'cn_data' => '{}',
					'cn_sort' => $t_channel->maxSort($cn_fid),
					'cn_ctime' => time(),
					'cn_status' => T_channel::STATUS_HIDE
				];
				$t_channel->loadData($data);
				//复制扩展内容
				if ($cn_fid != '0') {
					$parent = $this->model('t_channel')->get($cn_fid);
					if ($parent) {
						$t_channel->setAttribute('cn_data', $parent->cn_data);
					}
				}
				if($t_channel->save()) {
					$this->respSuccess($t_channel->cn_id);
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
	 * 获取栏目目录
	 * ======
	 * @author 洪波
	 * @version 17.10.28
	 */
	public function actionGetSimpleList() {
		if ($this->isPost()) {
			$criteria = new Criteria;
			$criteria->select = 'cn_id,cn_fid,cn_image,cn_name';
			$criteria->offset = $this->getPost('offset', 0);
			$criteria->limit = $this->getPost('limit', 20);
			$criteria->add('cn_fid', $this->getPost('cn_fid', '0'));
			$criteria->order = 'cn_sort asc';
			$result = $this->model('t_channel')->getOrm()->findAll($criteria);
			$this->respSuccess($result)->json();
		}
	}

	/**
	* 获取栏目详情
	* ======
	* @author 洪波
	* @version 16.04.22
	*/
	public function actionGet() {
		if($cn_id = $this->getParam('id')) {
			if($channel = $this->model('t_channel')->get($cn_id)) {
				$this->respSuccess($channel->toArray());
			} else {
				$this->respError(106);
			}
		} else {
			$this->respError(103);
		}
		$this->respJson();
	}

	/**
	* 仅获取栏目扩展数据
	* ======
	* @author 洪波
	* @version 16.04.22
	*/
	public function actionGetData() {
		if($cn_id = $this->getParam('id')) {
			$data = $this->model('t_channel')->getData($cn_id);
			if($data !== false) {
				$this->respSuccess($data);
			} else {
				$this->respError(106);
			}
		} else {
			$this->respError(103);
		}
		$this->respJson();
	}

	/**
	* 仅获取栏目内容
	* ======
	* @author 洪波
	* @version 16.04.22
	*/
	public function actionGetContent() {
		if($cn_id = $this->getParam('id')) {
			$content = $this->model('t_channel')->getContent($cn_id);
			if($content !== false) {
				$this->respSuccess($content);
			} else {
				$this->respError(106);
			}
		} else {
			$this->respError(103);
		}
		$this->respJson();
	}

	/**
	* 更新栏目
	* ======
	* @author 洪波
	* @version 16.09.15
	*/
	public function actionUpdateField() {
		if($this->isPost()) {
			if(T_admin::checkRole(T_admin::ROLE_CONTENT)) {
				$cn_id = $this->getPost('cn_id');
				$field = $this->getPost('field');
				$value = $this->getPost('value');
				if($this->model('t_channel')->update($cn_id, [
					$field => $value,
					'cn_utime' => time()
				])) {
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
	* 设置栏目内容关键词
	* ======
	* @author 洪波
	* @version 16.09.15
	*/
	public function actionSetKeyword() {
		if($this->isPost()) {
			if(T_admin::checkRole(T_admin::ROLE_CONTENT)) {
				$cn_id = $this->getPost('cn_id');
				$keyword = trim($this->getPost('keyword'));
				//变更栏目内容关键字字段
				$this->model('t_channel')->update($cn_id, [
					'cn_keyword' => $keyword,
					'cn_utime' => time()
				]);
				//删除旧索引
				$this->model('t_index')->deleteByChannel($cn_id);
				//批量建立索引
				if ($keyword != '') {
					foreach (explode(' ', $keyword) as $kw_name) {
						if ($kw_name != '') {
							//使用计数
							$this->model('t_keyword')->useCount($kw_name);
							//建立索引
							$t_index = new T_index;
							$t_index->id_keyword = $kw_name;
							$t_index->id_channel = $cn_id;
							$t_index->save();
						}
					}
				}
				$this->respSuccess();
			} else {
				$this->respError(105);
			}
			$this->respJson();
		}
	}

	/**
	* 删除栏目
	* ======
	* @author 洪波
	* @version 17.09.15
	*/
	public function actionDeleteAll() {
		if($this->isPost()) {
			if(T_admin::checkRole(T_admin::ROLE_CONTENT)) {
				$cn_id = $this->getPost('cn_id');
				$this->model('t_channel')->recursionDelete($cn_id);
				$this->respSuccess();
			} else {
				$this->respError(105);
			}
			$this->respJson();
		}
	}
}