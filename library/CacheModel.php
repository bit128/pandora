<?php
/**
* 缓存模型接口
* ======
* @author 洪波
* @version 16.07.25
*/
namespace library;

interface CacheModel
{
	/**
	* 设置缓存资源实例
	* ======
	* @param $cache 	缓存资源
	* ======
	* @author 洪波
	* @version 16.07.25
	*/
	public function setCache($cache);

	/**
	* 释放缓存
	* ======
	* @param $key 	缓存键
	* ======
	* @author 洪波
	* @version 16.07.25
	*/
	public function flush($key); 
}