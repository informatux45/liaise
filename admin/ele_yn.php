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
if (!defined('LIAISE_ROOT_PATH')) {
    exit();
}

if (!empty($ele_id)) {
    if (1 == $value['_YES']) {
        $selected = '_YES';
    } else {
        $selected = '_NO';
    }
} else {
    $selected = '_YES';
}
$options = new \XoopsFormRadio(_AM_ELE_DEFAULT, 'ele_value', $selected);
$options->addOption('_YES', _YES);
$options->addOption('_NO', _NO);
$output->addElement($options);
