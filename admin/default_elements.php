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

if (!defined('LIAISE_ROOT_PATH')) {
    exit();
}

/** @var Liaise\Helper $helper */
$helper = Liaise\Helper::getInstance();

$defaults               = [];
$defaults[0]['caption'] = 'Your name';
$defaults[0]['req']     = true;
$defaults[0]['order']   = 1;
$defaults[0]['display'] = 1;
$defaults[0]['type']    = 'text';
$defaults[0]['value']   = [
    0 => $helper->getConfig('t_width'),
    1 => $helper->getConfig('t_max'),
    2 => '{UNAME}',
];

$defaults[1]['caption'] = 'Email address';
$defaults[1]['req']     = true;
$defaults[1]['order']   = 2;
$defaults[1]['display'] = 1;
$defaults[1]['type']    = 'text';
$defaults[1]['value']   = [
    0 => $helper->getConfig('t_width'),
    1 => $helper->getConfig('t_max'),
    2 => '{EMAIL}',
];

$defaults[2]['caption'] = 'Your comments';
$defaults[2]['req']     = true;
$defaults[2]['order']   = 3;
$defaults[2]['display'] = 1;
$defaults[2]['type']    = 'textarea';
$defaults[2]['value']   = [
    0 => '',
    1 => $helper->getConfig('ta_rows'),
    2 => $helper->getConfig('ta_cols'),
];
