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

// ---- INFORMATUX ----

use XoopsModules\Liaise;

// require_once  dirname(__DIR__) . '/class/Helper.php';
//require_once  dirname(__DIR__) . '/include/common.php';
$helper = Liaise\Helper::getInstance();

$pathIcon32 = \Xmf\Module\Admin::menuIconPath('');
if (is_object($helper->getModule())) {
    $pathModIcon32 = $helper->getModule()->getInfo('modicons32');
}

$adminmenu[] = [
    'title' => _MI_LIAISE_ADMENU1,
    'link'  => 'admin/index.php',
    'icon'  => $pathIcon32 . '/manage.png',
];

$adminmenu[] = [
    'title' => _MI_LIAISE_ADMENU2,
    'link'  => 'admin/forms.php',
    'icon'  => $pathIcon32 . '/list.png',
];

$adminmenu[] = [
    'title' => _MI_LIAISE_ADMENU3,
    'link'  => 'admin/editelement.php',
    'icon'  => $pathIcon32 . '/insert_table_row.png',
];

$adminmenu[] = [
    'title' => _MI_LIAISE_ADMENU4,
    'link'  => 'admin/forms.php?op=archive_all',
    'icon'  => $pathIcon32 . '/mail_country.png',
];

$adminmenu[] = [
    'title' => _MI_LIAISE_ADMENU5,
    'link'  => 'admin/about.php',
    'icon'  => $pathIcon32 . '/about.png',
];
