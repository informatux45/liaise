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
