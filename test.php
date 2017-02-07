<?php
//print_r(json_encode($_POST));
file_put_contents('1.txt', var_export($_SERVER, 1));
exit;
header('HTTP/1.1 404 Not Found');
exit;