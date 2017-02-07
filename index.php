<?php
define('WEB_ROOT', __DIR__.'/');
require_once WEB_ROOT.'common.php';
use lib\m_curl;

$curl = new m_curl\m_curl();
$url = 'http://my.tool/test.php';
//$curl->exec();
$curl->post($url, array(1), array(
    'charset:utf-8;',
));
var_dump($curl->response);
var_dump($curl->to_arr());