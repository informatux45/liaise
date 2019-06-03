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

include dirname(__DIR__) . '/preloads/autoloader.php';

// includes
require_once dirname(dirname(dirname(__DIR__))) . '/include/cp_header.php';
require_once dirname(__DIR__) . '/include/common.php';
define('LIAISE_ADMIN_URL', LIAISE_URL . 'admin/index.php');
define('_LIAISE_ADMIN_URL', LIAISE_URL . 'admin/');
require_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
require_once __DIR__ . '/header.inc.php';

/** @var \XoopsGroupPermHandler $grouppermHandler */
$grouppermHandler = xoops_getHandler('groupperm');

// --- INFORMATUX ---
if (file_exists($GLOBALS['xoops']->path('/Frameworks/moduleclasses/moduleadmin/moduleadmin.php'))) {
    require_once $GLOBALS['xoops']->path('/Frameworks/moduleclasses/moduleadmin/moduleadmin.php');
} else {
    redirect_header('../../../admin.php', 5, _AM_LIAISE_MODULEADMIN_MISSING, false);
}

/** @var Liaise\Helper $helper */
$helper = Liaise\Helper::getInstance();
$helper->loadLanguage('modinfo');

/** @var \XoopsModuleHandler $moduleHandler */
$moduleHandler   = xoops_getHandler('module');
$moduleInfo      = $moduleHandler->get($xoopsModule->getVar('mid'));
$pathModuleAdmin = $xoopsModule->getInfo('dirmoduleadmin');
$pathIcon16      = \Xmf\Module\Admin::iconUrl('', 16);
$pathIcon16      = \Xmf\Module\Admin::iconUrl('', 32);

$myts = \MyTextSanitizer::getInstance();
// --------

// --- Security Check ---
//require_once LIAISE_ROOT_PATH . 'include/gtickets.php';
// ------

function adminHtmlHeader($navigation = 'index.php')
{
    xoops_cp_header();
    global $xoopsModule, $xoopsConfig, $pathIcon16;

    // --- INFORMATUX ---
    /* LIAISE Style */
    $urlMod = XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname');
    echo '<link rel="stylesheet" type="text/css" media="all" href="' . $urlMod . '/css/xliaise_style.css">';

    /* Nice Xoops GUI */
    $adminObject = \Xmf\Module\Admin::getInstance();
    $adminObject->displayNavigation($navigation);

    switch ($navigation) {
        case 'index.php':
            // Accueil
            // -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
            //              Nouvelle box
            // -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
            $box1 = _MI_LIAISE_ADMENU2;
            $box2 = _MI_LIAISE_ADMENU6;

            $adminObject->addInfoBox($box1);
            // ------------------------------------
            // --- Affichage de boutons
            // ------------------------------------
            $adminObject->addItemButton(_AM_FORM_NEW, 'forms.php?op=edit', 'add', '');
            $adminObject->addInfoBoxLine(sprintf($adminObject->displayButton('left'), '', '', 'default'), '');

            // --- Tableau
            $adminObject->addInfoBox($box2);
            // Forms Status
            // Recuperer les valeurs de la synthese
            $xliaise_forms_created   = getFormsCount() ?: false;
            $xliaise_forms_activated = getFormsCount(true) ?: false;
            $xliaise_forms_offline   = ($xliaise_forms_created - $xliaise_forms_activated);

            if ($xliaise_forms_created) {
                $xliaise_forms_activated_sprint = ($xliaise_forms_activated > 1) ? _AM_XLIAISE_INDEX_ACTIVATED_FORMS : _AM_XLIAISE_INDEX_ACTIVATED_FORM;
                $adminObject->addInfoBoxLine(sprintf(sprintf($xliaise_forms_activated_sprint, $xliaise_forms_activated)), '');
                $xliaise_forms_offline_sprint = ($xliaise_forms_offline > 1) ? _AM_XLIAISE_INDEX_OFFLINE_FORMS : _AM_XLIAISE_INDEX_OFFLINE_FORM;
                $adminObject->addInfoBoxLine(sprintf(sprintf($xliaise_forms_offline_sprint, $xliaise_forms_offline)), '');
                // ----------------------------------------
                $adminObject->addInfoBoxLine(sprintf('-------------------------------', ''), '');
                $xliaise_forms_created_sprint = ($xliaise_forms_created > 1) ? _AM_XLIAISE_INDEX_CREATED_FORMS : _AM_XLIAISE_INDEX_CREATED_FORM;
                $adminObject->addInfoBoxLine(sprintf(sprintf($xliaise_forms_created_sprint, $xliaise_forms_created)), '');
            } else {
                $adminObject->addInfoBoxLine(sprintf(_AM_XLIAISE_INDEX_NOFORM, ''), '');
            }

            $adminObject->displayIndex();
            adminHtmlFooter();
            break;
        case 'forms.php':
            $op = isset($_REQUEST['op']) ? trim($_REQUEST['op']) : false;
            if (!$op) {
                // ------------------------------------
                // --- Affichage de boutons
                // ------------------------------------
                $adminObject->addItemButton(_AM_FORM_NEW, 'forms.php?op=edit', 'add', '');
                $adminObject->displayButton('left', '');
            }
            break;
        case 'editelement.php':
        case 'elements.php':

            break;
        case 'about.php':
            $adminObject->displayAbout();
            break;
    }
    // ------------------
}

function adminHtmlHeaderPopup()
{
    global $xoopsModule, $xoopsConfig;

    /** @var Liaise\Helper $helper */
    $helper = Liaise\Helper::getInstance();
    $helper->loadLanguage('modinfo');
}

function adminHtmlFooter()
{
    global $xoopsModule;

    $modfootertxt = 'Module ' . $xoopsModule->getVar('name') . ' - Version ' . $xoopsModule->getVar('version') / 100 . ' - INFORMATUX.COM';
    $urlMod       = XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname');
    $urlSup       = 'http://www.informatux.com/';
    $urlSup2      = 'https://github.com/informatux45/xliaise';

    echo "<div style='padding-top: 8px; padding-bottom: 10px; text-align: center;'><a href='"
         . $urlSup2
         . "' target='_blank'><img src='"
         . $urlMod
         . "/images/admin/xliaise_icon.png' title='"
         . $modfootertxt
         . "' alt='"
         . $modfootertxt
         . "'></a><div class='xliaise_admin_footer_inf2'>is maintained by <a href='"
         . $urlSup
         . "'>INFORMATUX</a></div></div>";
} // fin de la fonction

function formatDate($date)
{
    if ($date) {
        $returndate = date('d-m-Y H:i', $date);
    }

    return $returndate;
}

function truncate($string, $max_length = 30, $replacement = '', $trunc_at_space = false)
{
    $max_length    -= mb_strlen($replacement);
    $string_length = mb_strlen($string);

    if ($string_length <= $max_length) {
        return $string;
    }

    if ($trunc_at_space && ($space_position = mb_strrpos($string, ' ', $max_length - $string_length))) {
        $max_length = $space_position;
    }

    return substr_replace($string, $replacement, $max_length);
}

function getMessagesCount($form_id)
{
    // query database for posted messages
    global $xoopsDB;
    $sql    = 'SELECT * FROM ' . $xoopsDB->prefix('xliaise_forms_archive') . ' WHERE form_id = "' . $form_id . '"';
    $result = $xoopsDB->query($sql);
    if (!$result) {
        return false;
    }
    $num_messages = $xoopsDB->getRowsNum($result);
    if (0 == $num_messages) {
        return false;
    }

    return $num_messages;
}

function getElementName($ele)
{
    if (!isset($ele)) {
        return false;
    }
    switch ($ele) {
        case 'text':
            return _AM_ELE_TEXT;
            break;
        case 'textarea':
            return _AM_ELE_TAREA;
            break;
        case 'select':
            return _AM_ELE_SELECT;
            break;
        case 'checkbox':
            return _AM_ELE_CHECK;
            break;
        case 'radio':
            return _AM_ELE_RADIO;
            break;
        case 'yn':
            return _AM_ELE_YN;
            break;
        case 'html':
            return _AM_ELE_HTML;
            break;
        case 'uploadimg':
            return _AM_ELE_UPLOADIMG;
            break;
        case 'upload':
            return _AM_ELE_UPLOADFILE;
            break;
        case 'break':
            return _AM_ELE_SEPARATOR;
            break;
    }
}
