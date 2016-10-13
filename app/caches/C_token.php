<?php
/**
* 令牌 - 缓存
* ======
* @author 洪波
* @version 16.07.25
*/
namespace app\caches;
use library\CacheModel;

class C_token implements CacheModel
{

	//缓存引用对象
	protected $cache;
	//缓存前缀
	protected $prefix = 'token_';
	//缓存有效时间
	protected $cache_limit = 2592000;

	/**
	* 设置缓存资源实例
	* ======
	* @param $cache 	缓存资源
	* ======
	* @author 洪波
	* @version 16.07.25
	*/
	public function setCache($cache)
	{
		$this->cache = $cache;
	}

	/**
	* 释放缓存
	* ======
	* @param $key 	缓存键
	* ======
	* @author 洪波
	* @version 16.07.25
	*/
	public function flush($user_id)
	{
		$key = $this->prefix . $user_id;
		$this->cache->delete($key);
	}

	/**
	* 验证令牌
	* ======
	* @param $user_id 	用户id
	* @param $token 	令牌
	* ======
	* @author 洪波
	* @version 15.01.27
	*/
	public function check($user_id, $token)
	{
		$tokens = $this->get($user_id);

		if($tokens)
		{
			if($tokens['token'] == $token)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}

	/**
	* 获取令牌
	* ======
	* @param $user_id 	用户id
	* @param $token 	令牌
	* ======
	* @author 洪波
	* @version 15.01.27
	*/
	public function get($user_id)
	{
		$key = $this->prefix . $user_id;
		if($token = $this->cache->hGetAll($key))
		{
			return $token;
		}
		else
		{
			return array();
		}
	}

	/**
	* 构建令牌
	* ======
	* @param $user_id 	用户id
	* @param $info 		登录信息
	* ======
	* @author 洪波
	* @version 16.07.25
	*/
	public function build($user_id, $info = array())
	{
		if($user_id == '')
		{
			return 0;
		}
		$key = $this->prefix . $user_id;
		$token_string = time() . $user_id . rand(1000, 9999);
		$data = array(
			'user_id' => $user_id,
			'token' => md5($token_string),
			'validity' => time() + $this->cache_limit,
			);
		if(is_array($info) && count($info))
		{
			$data += $info;
		}
		//缓存token
		foreach ($data as $k => $v)
		{
			$this->cache->hSet($key, $k, $v);
		}
		$this->cache->setTimeout($key, $this->cache_limit);

		return $data;
	}

}