<?php
$db = require_once WEB_ROOT . 'conf/db.conf.php';
/**
 * 简单写了个自动加载
 * @param $class_name 类名 带 命名空间
 */
function __autoload($class_name) {
    $class_name = WEB_ROOT.str_replace('\\', '/', $class_name);

    if(is_dir($class_name)) {
//        $files = read_dirs($class_name);
//
//        foreach ($files as $file) {
//            require_once $file;
//        }

    } else {
        require_once $class_name.'.php';
    }
}

/**
 * 读所有文件
 * @param $dir
 * @return array
 */
function read_dirs($dir) {
    $arr = array();

    if(is_dir($dir)) {

        $od = opendir($dir);

        while ($file = readdir($od)) {
            if($file != '.' && $file != '..') {
                $path = $dir.'/'.$file;

                if(is_dir($path)) {
                    $sub_arr = read_dirs($path);
                    $arr = array_merge($arr, $sub_arr);
                } else {
                    $arr[] = $path;
                }
            }

        }

        return $arr;
    }
}

/**
 * write log to anywhere
 * @param $content
 * @param null $file
 */
function log_to($content, $file = null) {
    if(!$file) {
        $url = $_SERVER['PHP_SELF'];
        $url = str_replace('\\', '/', $url);
        $arr = explode('/',$url);
        $filename = end($arr);
        $file = WEB_ROOT.'log/' . $filename . '/'. date('Ymd').'.log';
    } else {
        $file = WEB_ROOT.'log/' . $file . '/'. date('Ymd').'.log';
    }

    $dir = dirname($file);

    if(!is_dir($dir)) {
        mkdir($dir, '0777', 1);
    }

    error_log($content, 3, $file);
}

function get_db() {
    global $db;
    return $db;
}
