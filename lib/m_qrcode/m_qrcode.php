<?php
namespace lib\m_qrcode;
include_once 'phpqrcode/qrencode.php';
class m_qrcode{
    public static function png($text, $outfile = false, $level = QR_ECLEVEL_L, $size = 3, $margin = 4, $saveandprint=false) {
        return \QRcode::png($text, $outfile, $level, $size, $margin, $saveandprint);
    }
}