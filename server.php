<?php

//================================================================
// Liaise Module
// 2006-12-20 K.OHWADA
//================================================================

include("../../mainfile.php");
require_once ( 'class/captcha_x/class.captcha_x.php');
$server = &new captcha_x();
$server->handle_request();

?>