<?php
/**
* autumn主配置文件
* ======
* @author 洪波
* @version 15.02.08
*/
$config = array(
	'app_name' => 'Pandora',
	'version' => '1.0',
	//开启调试模式
	'debug' => true,
	//开启session
	'session_start' => true,
	//路由器设置
	'router' => array(
		//默认入口脚本文件
		'index' => '/index.php',
		//默认控制器
		'controller' => 'site',
		//默认控制器执行动作
		'action' => 'index'
		),
	//视图设置
	'view' => array(
		'path' => '/app/views/',
		'cache_dir' => '/app/runtime/',
		'cache_limit' => 86400
		),
	//数据库配置
	'database' => array(
		'driver' => 'Mysqli',
		'host' => '127.0.0.1',
		'user' => 'root',
		'password' => 'hong_1987',
		'dbname' => 'pandora'
		),
	//电子邮件服务
	'smtp' => array(
		'host' => 'smtp.qq.com',
		'port' => 25,
		'user' => 'xxxxxx@qq.com',
		'passwd' => 'xxxxxx',
		'debug' => false,
		),
	);