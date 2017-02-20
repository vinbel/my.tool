<html>
<head>
    <meta charset="utf-8"/>
</head>
<body>
<form method="post">
    <input name="py"/>
    <input type="submit" value="生成"/>
</form>
</body>

</html>

<?php
define('WEB_ROOT', __DIR__ . '/');
require_once WEB_ROOT . 'common.php';
use lib\m_zh2py;

if ($_POST && isset($_POST['py'])) {
    $str = $_POST['py'];
    $str_code = "abcdefghijklmnopqrstuvwxyz";
    $pinyin = m_zh2py\m_zh2py::encode($str);

    for ($i = 0, $len = strlen($pinyin); $i < $len; $i++) {
        $code = strpos($str_code, $pinyin[$i]);
        $code += 1;
        $num_s = $code % 4;
        $num_u = floor($code / 4);

        if ($num_s == '0') {
            $num_s = 4;
            $num_u -= 1;
        }

        $code = intval($num_u . $num_s);
        $code = sprintf("%02d", $code);
        echo $code;
    }
}

