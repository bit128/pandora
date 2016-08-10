<?php
/**
* Redis缓存服务 - 单例模型
* ======
* @author 洪波
* @version 15.01.15
*/
namespace library;

class RedisCache
{
	private static $_instance = null;		//类对象实例
	private static $_name = '';				//子对象名称
	private static $_child = null;			//子对象实例

	protected $cache = null;				//缓存对象实例
	protected $cache_host = '127.0.0.1';	//缓存服务器地址
	protected $cache_prot = 6379;			//缓存服务器端口
	protected $cache_limit = 60;			//缓存时间
	protected $cache_db = 0;				//正式数据库0 - 测试数据库1

	/**
	* 私有化构造方法
	* ======
	* @author 洪波
	* @version 15.01.15
	*/
	private function __construct()
	{
		//实例化redis并建立连接
		if($this->cache == null)
		{
			$this->cache = new \Redis;
			$this->cache->connect($this->cache_host, $this->cache_prot);
			$this->cache->select($this->cache_db);
		}
	}
	
	/**
	* 析构方法中关闭缓存连接
	* ======
	* @author 洪波
	* @version 15.01.15
	*/
	public function __destruct()
	{
		@ $this->cache->close();
	}

	/**
	* 私有化克隆方法，防止复制
	* ======
	* @author 洪波
	* @version 15.01.15
	*/
	private function __clone() {}

	/**
	* 静态化构造方法(缓存模型工厂)
	* ======
	* @param $class 	注入对象名
	* ======
	* @author 洪波
	* @version 15.01.15
	*/
	public static function model($class)
	{
		//如果实例不存在，则全新实例化
		if(! (self::$_instance instanceof self))
		{
			self::$_instance = new self();
		}
		//判断子对象名是否变更
		if($class != self::$_name)
		{
			//如果子对象名变更，则实例化子对象
			self::$_name = $class;
			$class = '\app\caches\C_' . $class;
			//注入子对象
			self::$_child = new $class;
			//设置子对象的redis引用
			self::$_child->setCache(self::$_instance->getRedis());
		}

		return self::$_child;
	}
	
	/**
	* 静态化构造方法
	* ======
	* @author 洪波
	* @version 15.07.30
	*/
	public static function getInstance()
	{
		if(! (self::$_instance instanceof self))
		{
			self::$_instance = new self();
		}
		
		return self::$_instance;
	}

	/**
	* 获取redis引用
	* ======
	* @author 洪波
	* @version 15.01.15
	*/
	public function getRedis()
	{
		return $this->cache;
	}
}