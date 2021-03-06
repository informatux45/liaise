<?php
// 2006-12-20 K.OHWADA
// use GIJOE's Ticket Class

// $Id: admin_header.php 26 2005-09-04 09:52:40Z tuff $
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
##  Author of this file: NS Tai (aka tuff)                                   ##
##  URL: http://www.brandycoke.com/                                          ##
##  Project: Liaise                                                          ##
###############################################################################

// includes
include '../../../include/cp_header.php';
include '../include/common.php';
define('LIAISE_ADMIN_URL', LIAISE_URL.'admin/index.php');
define('_LIAISE_ADMIN_URL', LIAISE_URL . 'admin/');
include_once XOOPS_ROOT_PATH.'/class/xoopsformloader.php';
include_once 'header.inc.php';

// --- INFORMATUX ---
if ( file_exists($GLOBALS['xoops']->path('/Frameworks/moduleclasses/moduleadmin/moduleadmin.php'))){
        include_once $GLOBALS['xoops']->path('/Frameworks/moduleclasses/moduleadmin/moduleadmin.php');
} else {
        redirect_header("../../../admin.php", 5, _AM_LIAISE_MODULEADMIN_MISSING, false); 
}

if ( file_exists("../language/".$xoopsConfig['language']."/main.php") ) {
	include ("../language/".$xoopsConfig['language']."/main.php");
} else {
	include ("../language/english/main.php");
}

$moduleInfo      =& $module_handler->get($xoopsModule->getVar('mid'));
$pathModuleAdmin = $xoopsModule->getInfo('dirmoduleadmin');
$pathIcon16      = XOOPS_URL .'/'. $moduleInfo->getInfo('icons16');
$pathIcon32      = XOOPS_URL .'/'. $moduleInfo->getInfo('icons32');

$myts =& MyTextSanitizer::getInstance();
// --------

// --- GIJOE's Ticket Class ---
include_once LIAISE_ROOT_PATH.'include/gtickets.php';
// ------

function adminHtmlHeader($navigation = 'index.php'){
        xoops_cp_header();
        global $xoopsModule, $xoopsConfig, $pathIcon16;
        
        // --- INFORMATUX ---
	/* LIAISE Style */
	$urlMod = XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname');
        echo '<link rel="stylesheet" type="text/css" media="all" href="'.$urlMod.'/css/xliaise_style.css" />';

	/* Nice Xoops GUI */
	$indexAdmin = new ModuleAdmin();
        echo $indexAdmin->addNavigation($navigation);
        
        switch ($navigation) {
            case 'index.php':
                // Accueil
                // -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
		//              Nouvelle box
		// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
		$box1 = _MI_LIAISE_ADMENU2;
		$box2 = _MI_LIAISE_ADMENU6;
                
                $indexAdmin->addInfoBox($box1);
                // ------------------------------------
                // --- Affichage de boutons
                // ------------------------------------
                $indexAdmin->addItemButton(_AM_FORM_NEW, 'forms.php?op=edit', 'add', '');
                $indexAdmin->addInfoBoxLine($box1, $indexAdmin->renderbutton('left'), '', '', 'default');

                // --- Tableau
		$indexAdmin->addInfoBox($box2);
		// Forms Status
		// Recuperer les valeurs de la synthese
		$xliaise_forms_created   = getFormsCount() ? getFormsCount() : false;
		$xliaise_forms_activated = getFormsCount(true) ? getFormsCount(true) : false;
		$xliaise_forms_offline   = (($xliaise_forms_created) - ($xliaise_forms_activated));

		if ($xliaise_forms_created) {
			$xliaise_forms_activated_sprint = ($xliaise_forms_activated > 1) ? _AM_XLIAISE_INDEX_ACTIVATED_FORMS : _AM_XLIAISE_INDEX_ACTIVATED_FORM;
			$indexAdmin->addInfoBoxLine($box2, sprintf($xliaise_forms_activated_sprint, $xliaise_forms_activated));
			$xliaise_forms_offline_sprint = ($xliaise_forms_offline > 1) ? _AM_XLIAISE_INDEX_OFFLINE_FORMS : _AM_XLIAISE_INDEX_OFFLINE_FORM;
			$indexAdmin->addInfoBoxLine($box2, sprintf($xliaise_forms_offline_sprint, $xliaise_forms_offline));
			// ----------------------------------------
			$indexAdmin->addInfoBoxLine($box2, '-------------------------------', '');
			$xliaise_forms_created_sprint = ($xliaise_forms_created > 1) ? _AM_XLIAISE_INDEX_CREATED_FORMS : _AM_XLIAISE_INDEX_CREATED_FORM;
			$indexAdmin->addInfoBoxLine($box2, sprintf($xliaise_forms_created_sprint, $xliaise_forms_created));
		} else {
			$indexAdmin->addInfoBoxLine($box2, _AM_XLIAISE_INDEX_NOFORM, '');
		}
		
                echo $indexAdmin->renderIndex();
		adminHtmlFooter();
            break;
            case "forms.php":
                $op = (isset($_REQUEST['op'])) ? trim($_REQUEST['op']) : false;
                if (!$op) {
                    // ------------------------------------
                    // --- Affichage de boutons
                    // ------------------------------------
                    $indexAdmin->addItemButton(_AM_FORM_NEW, 'forms.php?op=edit', 'add', '');
                    echo $indexAdmin->renderButton('left', '');
                }
            break;
            case "editelement.php":
            case "elements.php":
                //
            break;
            case "about.php":
                echo $indexAdmin->renderAbout();
            break;
        }
	// ------------------
}

function adminHtmlHeaderPopup() {
	global $xoopsModule, $xoopsConfig;
	$langf = LIAISE_ROOT_PATH.'language/'.$xoopsConfig['language'].'/modinfo.php';
	if (file_exists($langf)) {
		include $langf;
	} else {
		include LIAISE_ROOT_PATH.'language/english/modinfo.php';
	}
}

function adminHtmlFooter() {
global $xoopsModule;

    $modfootertxt = "Module " . $xoopsModule->getVar('name') . " - Version " . $xoopsModule->getVar('version')/100 . " - INFORMATUX.COM";
    $urlMod  = XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname');
    $urlSup  = "http://www.informatux.com/";
    $urlSup2 = "https://github.com/informatux45/xliaise";

    echo "<div style='padding-top: 8px; padding-bottom: 10px; text-align: center;'><a href='" . $urlSup2 . "' target='_blank'><img src='" . $urlMod . "/images/admin/xliaise_icon.png' title='" . $modfootertxt . "' alt='" . $modfootertxt . "'/></a><div class='xliaise_admin_footer_inf2'>is maintained by <a href='" . $urlSup . "'>INFORMATUX</a></div></div>";
    
} // fin de la fonction

function formatDate($date) {
    if ($date) {
        $returndate = date('d-m-Y H:i', $date);
    }
    return $returndate;
}

function truncate($string, $max_length = 30, $replacement = '', $trunc_at_space = false) {
    $max_length -= strlen($replacement);
    $string_length = strlen($string);
     
    if($string_length <= $max_length)
        return $string;
     
    if( $trunc_at_space && ($space_position = strrpos($string, ' ', $max_length-$string_length)) )
        $max_length = $space_position;
     
    return substr_replace($string, $replacement, $max_length);
}

function getMessagesCount($form_id) {
   // query database for posted messages
   global $xoopsDB;
   $sql = 'SELECT * FROM ' . $xoopsDB->prefix('xliaise_forms_archive') . ' WHERE form_id = "'.$form_id.'"';
   $result = $xoopsDB->query($sql);
   if (!$result)
     return false;
   $num_messages = $xoopsDB->getRowsNum($result);
   if ($num_messages == 0)
      return false;

   return $num_messages;
}

function getElementName($ele) {
    if (!isset($ele)) return false;
    switch($ele) {
        case "text":      return _AM_ELE_TEXT; break;
        case "textarea":  return _AM_ELE_TAREA; break;
        case "select":    return _AM_ELE_SELECT; break;
        case "checkbox":  return _AM_ELE_CHECK; break;
        case "radio":     return _AM_ELE_RADIO; break;
        case "yn":        return _AM_ELE_YN; break;
        case "html":      return _AM_ELE_HTML; break;
	case "uploadimg": return _AM_ELE_UPLOADIMG; break;
        case "upload":    return _AM_ELE_UPLOADFILE; break;
        case "break":     return _AM_ELE_SEPARATOR; break;
    }
}

?>