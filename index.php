<?php

require_once './lib/mcrypt.php';

echo  mcrypt::des_ecb_encrypt('1234', '5555');