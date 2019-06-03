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

require_once dirname(dirname(dirname(__DIR__))) . '/include/cp_header.php';
require_once dirname(__DIR__) . '/include/common.php';
define('LIAISE_ADMIN_URL', LIAISE_URL . 'admin/index.php');
require_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';

/** @var \XoopsGroupPermHandler $grouppermHandler */
$grouppermHandler = xoops_getHandler('groupperm');

function adminHtmlHeader()
{
    global $xoopsModule, $xoopsConfig;

    /** @var Liaise\Helper $helper */
    $helper = Liaise\Helper::getInstance();
    $helper->loadLanguage('modinfo');

    require_once __DIR__ . '/menu.php';
    for ($i = 0; $i < 3; $i++) {
        $links[$i] = [0 => LIAISE_URL . $adminmenu[$i]['link'], 1 => $adminmenu[$i]['title']];
    }
    $links[]     = [
        0 => XOOPS_URL . '/modules/system/admin.php?fct=preferences&op=showmod&mod=' . $xoopsModule->getVar('mid'),
        1 => _PREFERENCES,
    ];
    $links[]     = [0 => LIAISE_URL . 'admin/about.php', 1 => 'About'];
    $admin_links = '<table class="outer" width="100%" cellspacing="1"><tr>';
    for ($i = 0, $iMax = count($links); $i < $iMax; ++$i) {
        $admin_links .= '<td class="even" style="width: 20%; text-align: center;"><a href="' . $links[$i][0] . '" accesskey="' . ($i + 1) . '">' . $links[$i][1] . '</a></td>';
    }
    $admin_links .= "</tr></table><br clear='all'>\n";
    xoops_cp_header();
    echo $admin_links;
}
