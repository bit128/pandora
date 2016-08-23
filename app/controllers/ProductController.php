<?php
/**
* 商品控制器
* ======
* @author 洪波
* @version 16.08.04
*/
namespace app\controllers;
use core\Controller;
use core\Request;
use core\Response;
use core\Criteria;
use library\Psdk;
use app\models\M_product;
use app\models\M_admin;

class ProductController extends Controller
{

	private $m_product;

	public function init()
	{
		$this->m_product = new M_product;
	}

	/**
	* 添加商品
	* =======
	* @author 洪波
	* @version 16.08.04
	*/
	public function actionAdd()
	{
		if(Request::inst()->isPostRequest())
		{
			$response = new Response;
			if(M_admin::checkRole(M_admin::ROLE_PRODUCT))
			{
				$data = array(
					'pd_name' => Request::inst()->getPost('pd_name', '新上商品'),
					'pd_time' => time(),
					'pd_status' => M_product::STATUS_HIDE
					);
				if($pd_id = $this->m_product->insert($data))
				{
					//生成产品详情（扩展内容）
					$m_content = new \app\models\M_content;
					$m_content->addExtra($pd_id);
					$response->setResult($pd_id, Response::RES_SUCCESS);
				}
				else
				{
					$response->setError('创建失败', Response::RES_FAIL);
				}
			}
			else
			{
				$response->setError('无权操作', Response::RES_REFUSE);
			}
			$response->json();
		}
	}

	/**
	* 搜索商品列表
	* ======
	* @author 洪波
	* @version 16.08.11
	*/
	public function actionSearchList()
	{
		if(Request::inst()->isPostRequest())
		{
			$response = new Response;
			$offset = Request::inst()->getPost('offset');
			$limit = Request::inst()->getPost('limit');
			$keyword = urldecode(Request::inst()->getPost('keyword'));
			//关键词分析
			$m_dictionary = new \app\models\M_dictionary;
			$kr = explode(' ', trim($keyword));
			$pd_ids = $m_dictionary->getEntryIds($kr);
			//获取pd_id列表
			$criteria = new Criteria;
			$criteria->add('pd_status', M_product::STATUS_OPEN);
			if($keyword != '')
			{
				if(! $pd_ids)
				{
					$pd_ids[] = '';
				}
				$criteria->addCondition("pd_id in ('".implode("','", $pd_ids)."')");
			}
			$criteria->order = 'pd_sort asc';
			
			$response->setResult($this->m_product->getList($offset, $limit, $criteria), Response::RES_SUCCESS);
			$response->json();
		}
	}

	/**
	* 获取商品详情
	* ======
	* @author 洪波
	* @version 16.08.11
	*/
	public function actionGetDetail()
	{
		$response = new Response;
		$pd_id = Request::inst()->getParam('id');
		if(strlen($pd_id) == 13)
		{
			$product = $this->m_product->get($pd_id);
			if($product)
			{
				$m_content = new \app\models\M_content;
				$m_stock = new \app\models\M_stock;
				$m_album = new \app\models\M_album;
				$detail = $m_content->get($pd_id);

				$result = array(
					'product' => $product,
					'image' => $m_album->getImages($pd_id),
					'detail' => $detail->ct_detail,
					'stock' => $m_stock->getStock($pd_id)
					);
				$response->setResult($result, Response::RES_SUCCESS);
			}
			else
			{
				$response->setError('商品不存在', Response::RES_NOHAS);
			}
		}
		else
		{
			$response->setError('参数错误', Response::RES_PARAMF);
		}
		$response->json();
	}

	/**
	* 设置商品信息
	* =======
	* @author 洪波
	* @version 16.08.04
	*/
	public function actionSetInfo()
	{
		if(Request::inst()->isPostRequest())
		{
			$response = new Response;
			if(M_admin::checkRole(M_admin::ROLE_PRODUCT))
			{
				$pd_id = Request::inst()->getPost('pd_id');
				$field = Request::inst()->getPost('field');
				$value = Request::inst()->getPost('value');
				$data = array(
					$field => $value
					);
				if($this->m_product->update($pd_id, $data))
				{
					$response->setResult('设置成功', Response::RES_SUCCESS);
				}
				else
				{
					$response->setError('没有变更', Response::RES_NOCHAN);
				}
			}
			else
			{
				$response->setError('无权操作', Response::RES_REFUSE);
			}
			$response->json();
		}
	}

	/**
	* 删除商品
	* ======
	* @author 洪波
	* @version 16.08.06
	*/
	public function actionDelete()
	{
		if(Request::inst()->isPostRequest())
		{
			$response = new Response;
			if(M_admin::checkRole(M_admin::ROLE_PRODUCT))
			{
				$pd_id = Request::inst()->getPost('pd_id');
				if($this->m_product->delete($pd_id))
				{
					//删除扩展内容
					$m_content = new \app\models\M_content;
					$m_content->delete($pd_id);
					//删除商品图片
					$m_album = new \app\models\M_album;
					$m_album->deleteById($pd_id);
					//删除库存
					$m_stock = new \app\models\M_stock;
					$m_stock->deleteByPd($pd_id);
					//删除索引
					$m_index = new \app\models\M_index;
					$m_index->deleteIndex($pd_id);

					$response->setResult('删除成功', Response::RES_SUCCESS);
				}
				else
				{
					$response->setError('删除变更', Response::RES_NOCHAN);
				}
			}
			else
			{
				$response->setError('无权操作', Response::RES_REFUSE);
			}
			$response->json();
		}
	}
}