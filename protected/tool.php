<?php
define('WEB_ROOT', __DIR__ . 'tool.php/');
define('DEBUG', true);
require_once WEB_ROOT . 'common.php';
define('MODULE', WEB_ROOT . 'module/');
$op = isset($_REQUEST['op']) ? $_REQUEST['op'] : '';

switch($op) {
    case 'create':
        break;
}