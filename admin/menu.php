<?php
// $Id: menu.php 26 2005-09-04 09:52:40Z tuff $
###############################################################################
##                Liaise -- Contact forms generator for XOOPS                ##
##                 Copyright (c) 2003-2005 NS Tai (aka tuff)                 ##
##                       <http://www.brandycoke.com/>                        ##
###############################################################################
##                   XOOPS - PHP Content Management System                   ##
##                       Copyright (c) 2000 XOOPS.org                        ##
##                          <http://www.xoops.org/>                          ##
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

// ---- INFORMATUX ----
defined('XOOPS_ROOT_PATH') or die('Restricted access');
$path = dirname(dirname(dirname(dirname(__FILE__))));

global $xoopsModule, $xoopsUser;

$dirname        = basename(dirname(dirname(__FILE__)));
$module_handler = xoops_gethandler('module');
$module         = $module_handler->getByDirname($dirname);
$pathIcon32     = $module->getInfo('icons32');
$pathLanguage   = $path . $module->getInfo('dirmoduleadmin');

if (!file_exists($fileinc = $pathLanguage . '/language/' . $GLOBALS['xoopsConfig']['language'] . '/' . 'main.php')) {
    $fileinc = $pathLanguage . '/language/english/main.php';
}
include_once $fileinc;

xoops_loadLanguage('admin', $dirname);
// -------

$i = 1;
$adminmenu[$i]['title'] = _MI_LIAISE_ADMENU1;
$adminmenu[$i]['link']  = "admin/index.php";
$adminmenu[$i]['icon']  = $pathIcon32.'/manage.png';;
$i++;
$adminmenu[$i]['title'] = _MI_LIAISE_ADMENU2;
$adminmenu[$i]['link']  = "admin/forms.php";
$adminmenu[$i]['icon']  = $pathIcon32.'/list.png';
$i++;
$adminmenu[$i]['title'] = _MI_LIAISE_ADMENU3;
$adminmenu[$i]['link']  = "admin/editelement.php";
$adminmenu[$i]['icon']  = $pathIcon32.'/insert_table_row.png';
$i++;
$adminmenu[$i]['title'] = _MI_LIAISE_ADMENU4;
$adminmenu[$i]['link']  = "admin/forms.php?op=archive_all";
$adminmenu[$i]['icon']  = $pathIcon32.'/mail_country.png';
$i++;
$adminmenu[$i]['title'] = _MI_LIAISE_ADMENU5;
$adminmenu[$i]['link']  = "admin/about.php";
$adminmenu[$i]['icon']  = $pathIcon32.'/about.png';;
?>