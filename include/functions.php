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

function xoops_module_install_liaise(\XoopsModule $module)
{
    $grouppermHandler = xoops_getHandler('groupperm');
    /*
    $msgs[] = 'Setting up default permissions...';
    $m = '&nbsp;&nbsp;Grant permission of form id %u to group id %u ......%s';
    */
    for ($i = 1; $i < 4; $i++) {
        $perm = $grouppermHandler->create();
        $perm->setVar('gperm_name', 'xliaise_form_access');
        $perm->setVar('gperm_itemid', 1);
        $perm->setVar('gperm_groupid', $i);
        $perm->setVar('gperm_modid', $module->getVar('mid'));
        $grouppermHandler->insert($perm);
        /*
        if( !$grouppermHandler->insert($perm) ){
            $msgs[] = sprintf($m, 1, $i, 'failed');
        }else{
            $msgs[] = sprintf($m, 1, $i, 'done');
        }
        */
    }

    return true;
}
