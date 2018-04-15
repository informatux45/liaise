<?php

//================================================================
// Liaise Module
// 2006-12-20 K.OHWADA
//================================================================

include  dirname(dirname(__DIR__)) . '/mainfile.php';
require_once __DIR__ . '/class/captcha_x/class.captcha_x.php';
$server = new captcha_x();
$server->handle_request();
