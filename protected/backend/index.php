<?php
define('WEB_ROOT', __DIR__. '/../../');
define('DEBUG', true);
require_once WEB_ROOT.'common.php';
define('MODULE', WEB_ROOT . 'module/');
$_REQUEST['server_mod'] = 'cli';

if(!empty($argv)) {
    $r = '';
    $r_arr = $argv;
    unset($r_arr[0]);

    if(empty($r_arr)) {
        echo 'please into route!';
        exit();
    }

    $r = implode('/', $r_arr);
    $_REQUEST['r'] = $r;
} else {
    echo 'please into route!';
    exit();
}

$_POST = $_GET = $_REQUEST;
$router = new \core\m_router\m_router();
$router->run();