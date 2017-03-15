<?php
/**
* 响应处理类
* ======
* @author 洪波
* @version 16.07.13
*/
namespace core\http;

class Response
{
	const RES_UNKNOW	= 0;	//响应码 - 未知
	const RES_OK		= 1;	//响应码 - 成功
	const RES_FAIL		= 2;	//响应码 - 失败
	const RES_PARAMF    = 3;    //响应码 - 参数错误
    const RES_TOKENF    = 4;    //响应码 - 令牌错误
    const RES_NOHAS     = 5;    //响应码 - 不存在
    const RES_REFUSE    = 6;    //响应码 - 拒绝服务
    const RES_NAMEDF    = 7;    //响应码 - 重名
    const RES_PWDF      = 8;    //响应码 - 密码错误
    const RES_NOCHAN    = 9;    //响应码 - 未变更

	public $code_discription = [
		self::RES_UNKNOW 	=> '未知状态',
		self::RES_OK 		=> '操作成功',
		self::RES_FAIL 		=> '操作失败',
		self::RES_PARAMF    => '参数错误',
        self::RES_TOKENF    => '令牌错误',
        self::RES_NOHAS     => '不存在',
        self::RES_REFUSE    => '拒绝服务',
        self::RES_NAMEDF    => '重名',
        self::RES_PWDF      => '密码错误',
        self::RES_NOCHAN    => '未变更'
		];

	//响应吗
	protected $code;
	//结果信息
	protected $result;
	//错误信息
	protected $error;

	/**
	* 构造方法，刷新响应结果集
	* ======
	* @author 洪波
	* @version 16.07.13
	*/
	public function __construct()
	{
		$this->flush();
		$this->init();
	}

	/**
	* 控制器初始化方法
	* 子类重写用来替代构造方法
	* ======
	* @author 洪波
	* @version 16.03.09
	*/
	public function init(){}

	/**
	* 刷新响应结果
	* ======
	* @author 洪波
	* @version 16.07.13
	*/
	public function flush()
	{
		$this->code = self::RES_UNKNOW;
		$this->result = '';
		$this->error = '';
	}

	/**
	* 设置结果集
	* ======
	* @param $code 		响应码
	* @param $result 	结果集
	* @param $error 	保存集
	* ======
	* @author 洪波
	* @version 16.07.13
	*/
	public function setResult($code = 0, $result = '', $error = '')
	{
		if(in_array($code, array_keys($this->code_discription), true))
		{
			$this->code = $code;
			if($this->code == self::RES_OK)
			{
				if($result != '')
				{
					$this->result = $result;
				}
				else
				{
					$this->result = $this->code_discription[self::RES_OK];
				}
			}
			else
			{
				if($error != '')
				{
					$this->error = $error;
				}
				else
				{
					$this->error = $this->code_discription[$code];
				}
			}
		}
		else
		{
			$this->code = self::RES_OK;
			$this->result = $code;
		}
	}

	/**
	* 返回结果json格式
	* ======
	* @param $output 	输出模式
	* ======
	* @author 洪波
	* @version 16.07.13
	*/
	public function json($output = true)
	{
		$rs = array(
			'code' => $this->code,
			'result' => $this->result,
			'error' => $this->error,
			'date' => date('Y-m-d H:i:s')
			);
		if($output)
		{
			header("Content-Type:application/json; charset=utf-8");
			echo json_encode($rs);
		}
		else
		{
			return $rs;
		}
	}

	/**
	* 返回结果xml格式
	* ======
	* @param $output 	输出模式
	* ======
	* @author 洪波
	* @version 16.07.13
	*/
	public function xml($output = true)
	{
		$rs = simplexml_load_string('<?xml version="1.0" encoding="utf-8" ?><ResponseRoot />');
		$rs->addChild('code', $this->code);
		$rs->addChild('result');
		$this->addNode($rs->result, $this->result);
		$rs->addChild('error', $this->error);
		$rs->addChild('date', date('Y-m-d H:i:s'));
		if($output)
		{
			header("Content-Type:text/xml; charset=utf-8");
			echo $rs->asXML();
		}
		else
		{
			return $rs;
		}
	}

	/**
	* 添加xml子节点数据
	* ======
	* @param $xml 	父节点
	* @param $data 	数据
	* ======
	* @author 洪波
	* @version 16.07.13
	*/
	private function addNode($xml, $data)
	{
		foreach ($data as $k => $v)
		{
			if(is_numeric($k))
			{
				$k = 'item';
			}
			if(is_array($v) || is_object($v))
			{
				$this->addNode($xml->addChild($k), $v);
			}
			else
			{
				$xml->addChild($k, $v);
			}
		}
	}
}