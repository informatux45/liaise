<?php
// 2006-12-20 K.OHWADA
// change mail_charset for Japanese
// add captcha

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

include __DIR__ . '/preloads/autoloader.php';

$moduleDirName = basename(__DIR__);

$modversion['version']       = '2.00';
$modversion['module_status'] = 'FINAL';
$modversion['release_date']  = '2015/11/18';
$modversion['name']          = _MI_LIAISE_NAME;
$modversion['description']   = _MI_LIAISE_DESC;
$modversion['author']        = 'NS Tai (aka tuff)';
$modversion['credits']       = "<a href='http://www.brandycoke.com/' target='_blank'>Brandycoke Productions</a>";
$modversion['help']          = 'page=help';
$modversion['license']       = "<a href='http://creativecommons.org/licenses/GPL/2.0/' target='_blank'>Human-Readable Commons Deed</a><br><a href='http://www.gnu.org/copyleft/gpl.html' target='_blank'>Full Legal Code</a>";
$modversion['official']      = 0;
$modversion['image']         = 'images/xliaise.png';
$modversion['dirname']       = $moduleDirName;
//$modversion['dirmoduleadmin'] = '/Frameworks/moduleclasses/moduleadmin';
//$modversion['icons16']        = '../../Frameworks/moduleclasses/icons/16';
//$modversion['icons32']        = '../../Frameworks/moduleclasses/icons/32';
$modversion['modicons16'] = 'assets/images/icons/16';
$modversion['modicons32'] = 'assets/images/icons/32';

// System menu
$modversion['system_menu'] = 1;

// About
$modversion['module_website_url']  = '//www.brandycoke.com/';
$modversion['module_website_name'] = "Brandycoke Productions <a href='//www.informatux.com/'>& maintened by INFORMATUX</a>";
$modversion['status_version']      = 'Stable';
$modversion['min_php']             = '5.5';
$modversion['min_xoops']           = '2.5.9';
$modversion['min_admin']           = '1.2';
$modversion['min_db']              = ['mysql' => '5.5'];

// Developers
$modversion['contributors']['developers'][0]['name']    = 'Patrice Bouthier';
$modversion['contributors']['developers'][0]['uname']   = 'webmaster';
$modversion['contributors']['developers'][0]['email']   = 'contact@informatux.com';
$modversion['contributors']['developers'][0]['website'] = '//www.informatux.com';

// Sql file
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
$modversion['templates'][1]['file']        = 'xliaise_index.html';
$modversion['templates'][1]['description'] = _MI_LIAISE_TMPL_MAIN_DESC;
$modversion['templates'][2]['file']        = 'xliaise_form.html';
$modversion['templates'][2]['description'] = _MI_LIAISE_TMPL_FORM_DESC;
$modversion['templates'][3]['file']        = 'xliaise_error.html';
$modversion['templates'][3]['description'] = _MI_LIAISE_TMPL_ERROR_DESC;
$modversion['templates'][4]['file']        = 'xliaise_header.html';
$modversion['templates'][4]['description'] = _MI_LIAISE_TMPL_HEADER_DESC;

// ----------------------------------------------------------
//    Module Configs
// ----------------------------------------------------------
// $helper->getConfig('t_width')
$modversion['config'][1]['name']        = 't_width';
$modversion['config'][1]['title']       = '_MI_LIAISE_TEXT_WIDTH';
$modversion['config'][1]['description'] = '';
$modversion['config'][1]['formtype']    = 'textbox';
$modversion['config'][1]['valuetype']   = 'int';
$modversion['config'][1]['default']     = '35';

// $helper->getConfig('t_max')
$modversion['config'][2]['name']        = 't_max';
$modversion['config'][2]['title']       = '_MI_LIAISE_TEXT_MAX';
$modversion['config'][2]['description'] = '';
$modversion['config'][2]['formtype']    = 'textbox';
$modversion['config'][2]['valuetype']   = 'int';
$modversion['config'][2]['default']     = '255';

// $helper->getConfig('ta_rows')
$modversion['config'][3]['name']        = 'ta_rows';
$modversion['config'][3]['title']       = '_MI_LIAISE_TAREA_ROWS';
$modversion['config'][3]['description'] = '';
$modversion['config'][3]['formtype']    = 'textbox';
$modversion['config'][3]['valuetype']   = 'int';
$modversion['config'][3]['default']     = '5';

// $helper->getConfig('ta_cols')
$modversion['config'][4]['name']        = 'ta_cols';
$modversion['config'][4]['title']       = '_MI_LIAISE_TAREA_COLS';
$modversion['config'][4]['description'] = '';
$modversion['config'][4]['formtype']    = 'textbox';
$modversion['config'][4]['valuetype']   = 'int';
$modversion['config'][4]['default']     = '35';

// $helper->getConfig('moreinfo')
$modversion['config'][5]['name']        = 'moreinfo';
$modversion['config'][5]['title']       = '_MI_LIAISE_MOREINFO';
$modversion['config'][5]['description'] = '';
$modversion['config'][5]['formtype']    = 'select_multi';
$modversion['config'][5]['valuetype']   = 'array';
$modversion['config'][5]['default']     = ['user', 'ip', 'agent'];
$modversion['config'][5]['options']     = [
    _MI_LIAISE_MOREINFO_USER  => 'user',
    _MI_LIAISE_MOREINFO_IP    => 'ip',
    _MI_LIAISE_MOREINFO_AGENT => 'agent',
    _MI_LIAISE_MOREINFO_FORM  => 'form'
];

// $helper->getConfig('mail_charset')
$modversion['config'][6]['name']        = 'mail_charset';
$modversion['config'][6]['title']       = '_MI_LIAISE_MAIL_CHARSET';
$modversion['config'][6]['description'] = '_MI_LIAISE_MAIL_CHARSET_DESC';
$modversion['config'][6]['formtype']    = 'textbox';
$modversion['config'][6]['valuetype']   = 'text';

// --- for Japanese ---
//$modversion['config'][6]['default'] = _CHARSET;
$charset = _CHARSET;
global $xoopsConfig;
if ('japanese' === $xoopsConfig['language']) {
    $charset = 'ISO-2022-JP';
}
$modversion['config'][6]['default'] = $charset;
//------

// $helper->getConfig('prefix')
$modversion['config'][7]['name']        = 'prefix';
$modversion['config'][7]['title']       = '_MI_LIAISE_PREFIX';
$modversion['config'][7]['description'] = '';
$modversion['config'][7]['formtype']    = 'textbox';
$modversion['config'][7]['valuetype']   = 'text';
$modversion['config'][7]['default']     = '';

// $helper->getConfig('suffix')
$modversion['config'][8]['name']        = 'suffix';
$modversion['config'][8]['title']       = '_MI_LIAISE_SUFFIX';
$modversion['config'][8]['description'] = '';
$modversion['config'][8]['formtype']    = 'textbox';
$modversion['config'][8]['valuetype']   = 'text';
$modversion['config'][8]['default']     = '*';

// $helper->getConfig('intro')
$modversion['config'][9]['name']        = 'intro';
$modversion['config'][9]['title']       = '_MI_LIAISE_INTRO';
$modversion['config'][9]['description'] = '';
$modversion['config'][9]['formtype']    = 'textarea';
$modversion['config'][9]['valuetype']   = 'text';
$modversion['config'][9]['default']     = _MI_LIAISE_INTRO_DEFAULT;

// $helper->getConfig('global')
$modversion['config'][10]['name']        = 'global';
$modversion['config'][10]['title']       = '_MI_LIAISE_GLOBAL';
$modversion['config'][10]['description'] = '';
$modversion['config'][10]['formtype']    = 'textarea';
$modversion['config'][10]['valuetype']   = 'text';
$modversion['config'][10]['default']     = _MI_LIAISE_GLOBAL_DEFAULT;

// $helper->getConfig('uploaddir')
$modversion['config'][11]['name']        = 'uploaddir';
$modversion['config'][11]['title']       = '_MI_LIAISE_UPLOADDIR';
$modversion['config'][11]['description'] = '_MI_LIAISE_UPLOADDIR_DESC';
$modversion['config'][11]['formtype']    = 'textbox';
$modversion['config'][11]['valuetype']   = 'text';
$modversion['config'][11]['default']     = XOOPS_UPLOAD_PATH . '/' . uniqid(mt_rand(), true);

// --- captcha ---
// $helper->getConfig('captcha')
$modversion['config'][12]['name']        = 'captcha';
$modversion['config'][12]['title']       = '_MI_LIAISE_CAPTCHA';
$modversion['config'][12]['description'] = '_MI_LIAISE_CAPTCHA_DESC';
$modversion['config'][12]['formtype']    = 'yesno';
$modversion['config'][12]['valuetype']   = 'int';
$modversion['config'][12]['default']     = 1;
// -----

// --- breadcrumb ---
// $helper->getConfig('breadcrumb')
$modversion['config'][13]['name']        = 'breadcrumb';
$modversion['config'][13]['title']       = '_MI_LIAISE_BREADCRUMB';
$modversion['config'][13]['description'] = '_MI_LIAISE_BREADCRUMB_DESC';
$modversion['config'][13]['formtype']    = 'yesno';
$modversion['config'][13]['valuetype']   = 'int';
$modversion['config'][13]['default']     = 1;// -----
