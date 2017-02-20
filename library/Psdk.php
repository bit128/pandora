<?php
/**
* Pandora网络sdk
* ======
* @author 洪波
* @version 16.07.29
*/
namespace library;

class Psdk
{
	//服务地址
	const DOMAIN 			= 'http://1doc.cc/';
	const METHOD_POST		= 1;
	const METHOD_GET		= 0;
	//HTTP请求参数
	private $method;
	private $params			= array();
	private $header			= array();
	//内部约定密钥
	private static $app_key	= 'Pandora@0826_6280#arodnaP';

	/**
	* 构造方法 - 设置请求报头
	* ======
	* @author 洪波
	* @version 16.06.16
	*/
	public function __construct()
	{
		$this->header = array(
			'User-Agent: Mozilla/5.0 Pandora v1.0',
			'Accept :application/json, text/html',
			'Accept-Encoding: gzip, deflate',
			'Accept-Language: zh-CN,zh;q=0.8,en-US;q=0.5,en;q=0.3'
			);
	}

	/**
	* 设置请求报头
	* ======
	* @param $header 	请求报头内容
	* ======
	* @author 洪波
	* @version 16.06.16
	*/
	public function setHeader($header)
	{
		foreach ($header as $v)
		{
			$this->header[] = $v;
		}
	}

	/**
	* 通过GET方式请求参数[没有签名校验机制]
	* ======
	* @author 洪波
	* @version 16.06.16
	*/
	public function query($path)
	{
		$this->method = self::METHOD_GET;
		return $this->sendRequest($path);
	}

	/**
	* 通过POST方式请求参数
	* ======
	* @author 洪波
	* @version 16.06.16
	*/
	public function post($path, $params)
	{
		$this->method = self::METHOD_POST;
		if($params)
		{
			$time = date('Y-m-d H:i:s');
			//参数签名
			$sign = md5(self::sign($params));
			$this->header[] = 'Sign: ' . md5($sign . $time . self::$app_key);

			$params['time'] = $time;
			$this->params = $params;
		}
		return $this->sendRequest($path);
	}

	/**
	* 网络请求方法
	* ======
	* @param $path 	请求路径
	* ======
	* @author 洪波
	* @version 16.06.16
	*/
	public function sendRequest($path)
	{
		if($path == '')
			exit('the url is null!');
		
		$curl = curl_init(self::DOMAIN . $path);
		//设置消息头
		if($this->header)
			curl_setopt($curl, CURLOPT_HTTPHEADER, $this->header);
		//设置请求方法
		if($this->method == self::METHOD_POST)
		{
			curl_setopt($curl, CURLOPT_POST, 1);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $this->params);
		}
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec($curl);
		//$response = curl_getinfo($curl);
		curl_close($curl);

		return $result;
	}

	/**
	* 生成签名
	* ======
	* @param $params 	请求参数
	* ======
	* @author 洪波
	* @version 14.12.24
	*/
	private static function sign($params)
	{
		//排序
		ksort($params);
		reset($params);
		//拼接成待签名字符串
		$arg  = '';
		while (list ($key, $val) = each ($params))
		{
			$arg.=$key."=".$val."&";
		}
		//去掉最后一个&字符
		$arg = substr($arg, 0, count($arg)-2);
		//如果存在转义字符，那么去掉转义
		if(get_magic_quotes_gpc())
		{
			$arg = stripslashes($arg);
		}
		return $arg;
	}

	/**
	* 校验请求参数签名
	* ======
	* @author 洪波
	* @version 16.06.16
	*/
	public static function checkSign()
	{
		if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SERVER['HTTP_SIGN']))
		{
			$sign = $_SERVER['HTTP_SIGN'];
			$params = $_POST;
			$time = $params['time'];
			unset($params['time']);
			$validate = md5(md5(self::sign($params)) . $time . self::$app_key);
			if($sign == $validate)
			{
				return true;
			}
		}
		return false;
	}
}