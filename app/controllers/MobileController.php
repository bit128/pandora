<?php
/**
* 移动设备页面控制器
* ======
* @author 洪波
* @version 16.08.02
*/
namespace app\controllers;

class MobileController extends \core\web\Controller {

    const PAGE_PATH = './app/mobiles/';

    /**
     * 获取版本库
     * ======
     * @author 洪波
     * @version 19.12.16
     */
    public function actionGetConfig() {
        $uri = $_SERVER['REQUEST_URI'];
        $config_file = self::PAGE_PATH . 'config.json';
        if (strlen($uri) > 10) {
            $config_file = self::PAGE_PATH . 'config-' . substr($uri, 11) . '.json';
        }
        if (\is_file($config_file)) {
            echo \file_get_contents($config_file);
        }
    }

    /**
     * 获取文件内容
     * ======
     * @author 洪波
     * @version 19.11.16
     */
    public function actionGetFile() {
        $file = self::PAGE_PATH . substr($_SERVER['REQUEST_URI'], 9);
        if (\is_file($file)) {
            echo \file_get_contents($file);
        }
    }

    /**
     * 渲染移动设备页面
     * ======
     * @author 洪波
     * @version 19.12.16
     */
    public function actionRender() {
        $page_name = substr($_SERVER['REQUEST_URI'], 3);
        if ($page_name != '') {
            $params = [];
            if(($p = strpos($page_name, '?')) != false) {
                $param_str = substr($page_name, $p+1);
                $page_name = substr($page_name, 0, $p);
                if (strstr($param_str, '=')) {
                    foreach (explode('&', $param_str) as $pair) {
                        $arr = explode('=', $pair);
                        if (count($arr) == 2) {
                            $params[$arr[0]] = $arr[1];
                        }
                    }
                }
            }
            $page_file = self::PAGE_PATH . $page_name . '.html';
            if (is_file($page_file)) {
                $content = file_get_contents($page_file);
                \preg_match_all('/<asset>([\w\-\.]*?)<\/asset>/', $content, $result);
                foreach ($result[1] as $k => $v) {
                    //获取扩展名
                    $ext_name = strtolower(substr(strrchr($v, '.'), 1));
                    $p = '';
                    if ($ext_name == 'css') {
                        $p = '<link href="/app/mobiles/' . $v . '" type="text/css" rel="stylesheet" />';
                    } else if ($ext_name == 'js') {
                        $p = '<script src="/app/mobiles/' . $v . '" type="text/javascript"></script>';
                    }
                    $content = \str_replace($result[0][$k], $p, $content);
                }
                $content = \str_replace('app-image:', '/app/mobiles/image/', $content);
                $content = \str_replace('app-local:', '/app/mobiles/image/', $content);
                $content = \str_replace('app-page:back', 'javascript:history.back();', $content);
                $content = \str_replace('app-page:', '/m/', $content);
                foreach ($params as $key => $value) {
                    $content = str_replace('#'.$key.'#', urldecode($value), $content);
                }
                echo $content;
            } else {
                echo 'not found';
            }
        }
    }
}