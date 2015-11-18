<?php
// $Id: form_render.php 61 2005-11-04 14:55:24Z tuff $
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
if( !defined('LIAISE_ROOT_PATH') ){ exit(); }

include_once XOOPS_ROOT_PATH."/class/xoopsformloader.php";
$liaise_ele_mgr =& xoops_getmodulehandler('elements');
include_once LIAISE_ROOT_PATH.'class/elementrenderer.php';
$xoopsOption['template_main'] = 'liaise_form.html';
include_once XOOPS_ROOT_PATH.'/header.php';
$criteria = new CriteriaCompo();
$criteria->add(new Criteria('form_id', $form->getVar('form_id')));
$criteria->add(new Criteria('ele_display', 1));
$criteria->setSort('ele_order');
$criteria->setOrder('ASC');
$elements =& $liaise_ele_mgr->getObjects($criteria, true);

$form_output = new XoopsThemeForm($form->getVar('form_title'), 'liaise_'.$form->getVar('form_id'), LIAISE_URL.'index.php');
foreach( $elements as $i ){
	$renderer =& new LiaiseElementRenderer($i);
	$form_ele =& $renderer->constructElement();
	$req = intval($i->getVar('ele_req'));
	$form_output->addElement($form_ele, $req);
	unset($form_ele);
}
$form_output->addElement(new XoopsFormHidden('form_id', $form->getVar('form_id')));
$form_output->addElement(new XoopsFormButton('', 'submit', $form->getVar('form_submit_text'), 'submit'));
// $form_output->assign($xoopsTpl);

$c = 0;
$eles = array();
foreach( $form_output->getElements() as $e ){
	$id = $req = $name = $ele_type = false;
	$name = $e->getName();
	$caption = $e->getCaption();
	if( !empty($name) ){
		$id = str_replace('ele_', '', $e->getName());
	}elseif( method_exists($e, 'getElements') ){
		$obj =& $e->getElements();
		$id = str_replace('ele_', '', $obj[0]->getName());
		$id = str_replace('[]', '', $id);
	}
	if( isset($elements[$id]) ){
		$req = $elements[$id]->getVar('ele_req') ? true : false;
		$ele_type = $elements[$id]->getVar('ele_type');
	}else{
		$req = false;
	}
	$eles[$c]['caption']  = $caption;
	$eles[$c]['name']	  = $name;
	$eles[$c]['body']	  = $e->render();
	$eles[$c]['hidden']	  = $e->isHidden();
	$eles[$c]['required'] = $req;
	$eles[$c]['ele_type'] = $ele_type;
	$c++;
}
$js = $form_output->renderValidationJS();
$xoopsTpl->assign('form_output', array('title' => $form_output->getTitle(), 'name' => $form_output->getName(), 'action' => $form_output->getAction(),  'method' => $form_output->getMethod(), 'extra' => 'onsubmit="return xoopsFormValidate_'.$form_output->getName().'();"'.$form_output->getExtra(), 'javascript' => $js, 'elements' => $eles));

$xoopsTpl->assign('form_req_prefix', $xoopsModuleConfig['prefix']);
$xoopsTpl->assign('form_req_suffix', $xoopsModuleConfig['suffix']);
$xoopsTpl->assign('form_intro', $form->getVar('form_intro'));
$xoopsTpl->assign('form_text_global', $myts->makeTareaData4Show($xoopsModuleConfig['global']));
if( $form->getVar('form_order') == 0 ){
	if( !isset($xoopsUser) || !is_object($xoopsUser) || !$xoopsUser->isAdmin() ){
		header("Location: ".LIAISE_URL);
		exit();
	}
	$xoopsTpl->assign('form_is_hidden', _LIAISE_FORM_IS_HIDDEN);
}

$xoopsTpl->assign('xoops_pagetitle', $form->getVar('form_title'));
?>