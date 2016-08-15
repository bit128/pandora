<?php
/**
* 结构化数据服务
* ======
* @author 洪波
* @version 16.08.13
*/
namespace app\models;

class M_struct
{

	const SAVE_PATH = './app/statics/files/struct.json'; //数据存储路径
	const BUFFER = 1024; //文件缓冲大小

	/**
	* 新增结构头
	* ======
	* @author 洪波
	* @version 16.08.14
	*/
	public function addHead($name = '新配置项')
	{
		$item = array(
			'id' => uniqid(),
			'name' => $name,
			'data' => null
			);
		$head = $this->getHeadList();
		$head[$item['id']] = $item;
		$this->saveData($head);
	}

	/**
	* 获取结构头列表
	* ======
	* @author 洪波
	* @version 16.08.14
	*/
	public function getHeadList()
	{
		if(file_exists(self::SAVE_PATH))
		{
			$data = '';
			if($file = fopen(self::SAVE_PATH, 'r'))
			{
				while (! feof($file))
				{
					$data .= fread($file, self::BUFFER);
				}
				fclose($file);
			}
			if($data == '')
			{
				return array();
			}
			else
			{
				return (array) json_decode($data);
			}
		}
		else
		{
			return array();
		}
	}

	/**
	* 删除结构头
	* ======
	* @param $id 	配置id
	* ======
	* @author 洪波
	* @version 16.08.14
	*/
	public function deleteHead($id)
	{
		$head = $this->getHeadList();
		if(isset($head[$id]))
		{
			unset($head[$id]);
			$this->saveData($head);
		}
	}

	/**
	* 获取结构体
	* ======
	* @param $id 	结构头id
	* ======
	* @author 洪波
	* @version 16.08.14
	*/
	public function getBody($id)
	{
		$head = $this->getHeadList();
		if(isset($head[$id]))
		{
			return $head[$id]->data;
		}
	}

	/**
	* 设置结构体
	* ======
	* @param $id 	结构头id
	* @param $body 	结构体数据
	* ======
	* @author 洪波
	* @version 16.08.14
	*/
	public function setBody($id, $body)
	{
		$head = $this->getHeadList();
		if(isset($head[$id]))
		{
			$head[$id]->data = $body;
			$this->saveData($head);
		}
	}

	/**
	* 设置结构头名称
	* ======
	* @param $id 	结构体id
	* @param $name 	名称
	* ======
	* @author 洪波
	* @version 16.08.14
	*/
	public function setName($id, $name)
	{
		$head = $this->getHeadList();
		if(isset($head[$id]))
		{
			$head[$id]->name = $name;
			$this->saveData($head);
		}
	}

	/**
	* 保存结构数据
	* ======
	* @param $data 	结构数据
	* ======
	* @author 洪波
	* @version 16.08.14
	*/
	private function saveData($data)
	{
		if($file = fopen(self::SAVE_PATH, 'w'))
		{
			if(! is_string($data))
			{
				$data = json_encode($data);
			}
			fwrite($file, $data);
			fclose($file);
		}
	}
}