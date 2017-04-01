<?php
define('WEB_ROOT', __DIR__. '/');
define('DEBUG', true);
require_once WEB_ROOT.'common.php';
define('MODULE', WEB_ROOT . 'module/');
$router = new \core\m_router\m_router();
$router->run();