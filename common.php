<?php
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
