<?php

/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

/**
 *
 * @copyright   2003-2005 NS Tai (aka tuff) http://www.brandycoke.com
 * @copyright   2003-2019 XOOPS Project (https://xoops.org)
 * @license     GNU GPL 2 or later (http://www.gnu.org/licenses/gpl-2.0.html)
 * @author      NS Tai (aka tuff) URL: http://www.brandycoke.com/
 * @author      Kenichi OHWADA, http://linux2.ohwada.net/, Email:  webmaster@ohwada.jp
 * @author      Patrice BOUTHIER, contact@informatux.com, https://informatux.com/
 * @author      Michael Beck (aka Mamba), XOOPS Development Team
 * @package     Liaise -- Contact forms generator for XOOPS
 */

use XoopsModules\Liaise;

/** @var Liaise\Helper $helper */
$helper = Liaise\Helper::getInstance();

if (!defined('LIAISE_CONSTANTS_DEFINED')) {
    define('LIAISE_URL', XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/');
    define('LIAISE_ROOT_PATH', XOOPS_ROOT_PATH . '/modules/' . $xoopsModule->getVar('dirname') . '/');
    define('LIAISE_UPLOAD_PATH', $helper->getConfig('uploaddir') . '/');

    define('LIAISE_CONSTANTS_DEFINED', true);
}

$liaise_form_mgr = $helper->getHandler('Forms');

if (false !== LIAISE_UPLOAD_PATH) {
    if (!is_dir(LIAISE_UPLOAD_PATH)) {
        $oldumask = umask(0);
        mkdir(LIAISE_UPLOAD_PATH, 0777);
        umask($oldumask);
    }
    if (is_dir(LIAISE_UPLOAD_PATH) && !is_writable(LIAISE_UPLOAD_PATH)) {
        chmod(LIAISE_UPLOAD_PATH, 0777);
    }
}

// ------------------ INFORMATUX
function dbResultToArray($result)
{
    // construction d'un tableau pour les scripts
    global $xoopsDB;
    $result_array = [];

    for ($count = 0; $myrow = $xoopsDB->fetchArray($result); $count++) {
        $result_array[$count] = $myrow;
    }

    return $result_array;
}

//error_reporting(E_ALL);
