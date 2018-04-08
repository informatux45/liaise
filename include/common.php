<?php
//
###############################################################################
##                Liaise -- Contact forms generator for XOOPS                ##
##                 Copyright (c) 2003-2005 NS Tai (aka tuff)                 ##
##                       <http://www.brandycoke.com>                        ##
###############################################################################
##                   XOOPS - PHP Content Management System                   ##
##                       Copyright (c) 2000-2016 XOOPS.org                        ##
##                          <https://xoops.org>                          ##
###############################################################################
##  This program is free software; you can redistribute it and/or modify     ##
##  it under the terms of the GNU General Public License as published by     ##
##  the Free Software Foundation; either version 2 of the License, or        ##
##  (at your option) any later version.                                      ##
##                                                                           ##
##  You may not change or alter any portion of this comment or credits       ##
##  of supporting developers from this source code or any supporting         ##
##  source code which is considered copyrighted (c) material of the          ##
##  original comment or credit authors.                                      ##
##                                                                           ##
##  This program is distributed in the hope that it will be useful,          ##
##  but WITHOUT ANY WARRANTY; without even the implied warranty of           ##
##  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            ##
##  GNU General Public License for more details.                             ##
##                                                                           ##
##  You should have received a copy of the GNU General Public License        ##
##  along with this program; if not, write to the Free Software              ##
##  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA ##
###############################################################################
##  Author of this file: NS Tai (aka tuff)                                   ##
##  URL: http://www.brandycoke.com/                                          ##
##  Project: Liaise                                                          ##
###############################################################################

use XoopsModules\Liaise;
/** @var Liaise\Helper $helper */
$helper = Liaise\Helper::getInstance();

if (!defined('LIAISE_CONSTANTS_DEFINED')) {
    define('LIAISE_URL', XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/');
    define('LIAISE_ROOT_PATH', XOOPS_ROOT_PATH . '/modules/' . $xoopsModule->getVar('dirname') . '/');
    define('LIAISE_UPLOAD_PATH', $helper->getConfig('uploaddir') . '/');

    define('LIAISE_CONSTANTS_DEFINED', true);
}

$liaise_form_mgr = xoops_getModuleHandler('forms');

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
