<?php
/**
* autumn主配置文件
* ======
* @author 洪波
* @version 17.02.24
*/
return [
	'app_name' => 'Pandora 网媒管理系统',
	'version' => '2.3',
	//开启session
	'session_start' => true,
	//业务模型载入路径
	'service_path' => 'app/models/',
	'module' => [
		//路由器设置
		'route' => [
			'class' => 'core\web\Route',
			'path' => 'app/controllers/',
			//默认入口脚本文件
			'index' => '/index.php',
			//默认控制器
			'controller' => 'site',
			//默认控制器执行动作
			'action' => 'index',
			//自定义路由规则
			'route_alias' => [
				//'hello' => 'site/test'
			]
		],
		//视图设置
		'view' => [
			'class' => 'core\web\View',
			'layout' => 'layout',
			'path' => 'app/views/',
			'cache_dir' => 'app/runtimes/',
			'cache_limit' => 86400
		],
		//数据库配置
		'db' => [
			'class' => 'core\db\Mysqli',
			'host' => '127.0.0.1',
			'user' => 'root',
			'password' => '',
			'dbname' => 'pandora'
		]
	]
];