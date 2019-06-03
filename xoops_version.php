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

require_once __DIR__ . '/preloads/autoloader.php';

$moduleDirName = basename(__DIR__);

$modversion['version']       = '2.10';
$modversion['module_status'] = 'Beta 1';
$modversion['release_date']  = '2019/06/01';
$modversion['name']          = _MI_LIAISE_NAME;
$modversion['description']   = _MI_LIAISE_DESC;
$modversion['author']        = 'NS Tai (aka tuff)';
$modversion['credits']       = "<a href='http://www.brandycoke.com/' target='_blank'>Brandycoke Productions</a>";
$modversion['help']          = 'page=help';
$modversion['license']       = "<a href='http://creativecommons.org/licenses/GPL/2.0/' target='_blank'>Human-Readable Commons Deed</a><br><a href='http://www.gnu.org/copyleft/gpl.html' target='_blank'>Full Legal Code</a>";
$modversion['official']      = 0;
$modversion['image']         = 'assets/images/logoModule.png';
$modversion['dirname']       = $moduleDirName;
$modversion['modicons16']    = 'assets/images/icons/16';
$modversion['modicons32']    = 'assets/images/icons/32';

// System menu
$modversion['system_menu'] = 1;

// About
$modversion['module_website_url']  = '//www.brandycoke.com/';
$modversion['module_website_name'] = "Brandycoke Productions <a href='https://www.informatux.com/' target='_blank'>& maintened by INFORMATUX</a>";
$modversion['status_version']      = 'Stable';
$modversion['min_php']             = '7.0';
$modversion['min_xoops']           = '2.5.10';
$modversion['min_admin']           = '1.2';
$modversion['min_db']              = ['mysql' => '5.5'];

// Developers
$modversion['contributors']['developers'][0]['name']    = 'Patrice Bouthier';
$modversion['contributors']['developers'][0]['uname']   = 'webmaster';
$modversion['contributors']['developers'][0]['email']   = 'contact@informatux.com';
$modversion['contributors']['developers'][0]['website'] = "https://www.informatux.com";

// ------------------- Mysql ------------------- //
$modversion['sqlfile']['mysql'] = 'sql/mysql.sql';
// Tables created by sql file (without prefix!)
$modversion['tables'][0] = 'xliaise_forms';
$modversion['tables'][1] = 'xliaise_formelements';
$modversion['tables'][2] = 'xliaise_forms_archive';

// Admin things
$modversion['hasAdmin']   = 1;
$modversion['adminindex'] = 'admin/index.php';
$modversion['adminmenu']  = 'admin/menu.php';

// Menu -- content in main menu block
$modversion['hasMain'] = 1;

$modversion['onInstall'] = 'include/functions.php';

// ----------------------------------------------------------
// Templates
// ----------------------------------------------------------
$modversion['templates'][1]['file']        = 'xliaise_index.tpl';
$modversion['templates'][1]['description'] = _MI_LIAISE_TMPL_MAIN_DESC;
$modversion['templates'][2]['file']        = 'xliaise_form.tpl';
$modversion['templates'][2]['description'] = _MI_LIAISE_TMPL_FORM_DESC;
$modversion['templates'][3]['file']        = 'xliaise_error.tpl';
$modversion['templates'][3]['description'] = _MI_LIAISE_TMPL_ERROR_DESC;
$modversion['templates'][4]['file']        = 'xliaise_header.tpl';
$modversion['templates'][4]['description'] = _MI_LIAISE_TMPL_HEADER_DESC;

// ----------------------------------------------------------
//    Module Configs
// ----------------------------------------------------------
// $helper->getConfig('t_width')

$modversion['config'][] = [
    'name'        => 't_width',
    'title'       => '_MI_LIAISE_TEXT_WIDTH',
    'description' => '',
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'default'     => '35',
];

// $helper->getConfig('t_max')
$modversion['config'][] = [
    'name'        => 't_max',
    'title'       => '_MI_LIAISE_TEXT_MAX',
    'description' => '',
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'default'     => '255',
];

// $helper->getConfig('ta_rows')
$modversion['config'][] = [
    'name'        => 'ta_rows',
    'title'       => '_MI_LIAISE_TAREA_ROWS',
    'description' => '',
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'default'     => '5',
];

// $helper->getConfig('ta_cols')
$modversion['config'][] = [
    'name'        => 'ta_cols',
    'title'       => '_MI_LIAISE_TAREA_COLS',
    'description' => '',
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'default'     => '35',
];

// $helper->getConfig('moreinfo')
$modversion['config'][] = [
    'name'        => 'moreinfo',
    'title'       => '_MI_LIAISE_MOREINFO',
    'description' => '',
    'formtype'    => 'select_multi',
    'valuetype'   => 'array',
    'default'     => ['user', 'ip', 'agent'],
    'options'     => [
        _MI_LIAISE_MOREINFO_USER  => 'user',
        _MI_LIAISE_MOREINFO_IP    => 'ip',
        _MI_LIAISE_MOREINFO_AGENT => 'agent',
        _MI_LIAISE_MOREINFO_FORM  => 'form',
    ],
];

// --- for Japanese ---
$charset = _CHARSET;
global $xoopsConfig;
if ('japanese' === $xoopsConfig['language']) {
    $charset = 'ISO-2022-JP';
}

// $helper->getConfig('mail_charset')
$modversion['config'][] = [
    'name'        => 'mail_charset',
    'title'       => '_MI_LIAISE_MAIL_CHARSET',
    'description' => '_MI_LIAISE_MAIL_CHARSET_DESC',
    'formtype'    => 'textbox',
    'valuetype'   => 'text',
    'default'     => $charset,
];

// $helper->getConfig('prefix')
$modversion['config'][] = [
    'name'        => 'prefix',
    'title'       => '_MI_LIAISE_PREFIX',
    'description' => '',
    'formtype'    => 'textbox',
    'valuetype'   => 'text',
    'default'     => '',
];

// $helper->getConfig('suffix')
$modversion['config'][] = [
    'name'        => 'suffix',
    'title'       => '_MI_LIAISE_SUFFIX',
    'description' => '',
    'formtype'    => 'textbox',
    'valuetype'   => 'text',
    'default'     => '*',
];

// $helper->getConfig('intro')
$modversion['config'][] = [
    'name'        => 'intro',
    'title'       => '_MI_LIAISE_INTRO',
    'description' => '',
    'formtype'    => 'textarea',
    'valuetype'   => 'text',
    'default'     => _MI_LIAISE_INTRO_DEFAULT,
];

// $helper->getConfig('global')
$modversion['config'][] = [
    'name'        => 'global',
    'title'       => '_MI_LIAISE_GLOBAL',
    'description' => '',
    'formtype'    => 'textarea',
    'valuetype'   => 'text',
    'default'     => _MI_LIAISE_GLOBAL_DEFAULT,
];

// $helper->getConfig('uploaddir')
$modversion['config'][] = [
    'name'        => 'uploaddir',
    'title'       => '_MI_LIAISE_UPLOADDIR',
    'description' => '_MI_LIAISE_UPLOADDIR_DESC',
    'formtype'    => 'textbox',
    'valuetype'   => 'text',
    'default'     => XOOPS_UPLOAD_PATH . '/' . uniqid(mt_rand(), true),
];

// --- captcha ---
// $helper->getConfig('captcha')
$modversion['config'][] = [
    'name'        => 'captcha',
    'title'       => '_MI_LIAISE_CAPTCHA',
    'description' => '_MI_LIAISE_CAPTCHA_DESC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 1,
];

// --- breadcrumb ---
// $helper->getConfig('breadcrumb')
$modversion['config'][] = [
    'name'        => 'breadcrumb',
    'title'       => '_MI_LIAISE_BREADCRUMB',
    'description' => '_MI_LIAISE_BREADCRUMB_DESC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 1, // -----
];

