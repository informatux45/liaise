<?php
// $Id: index.php 26 2005-09-04 09:52:40Z tuff $
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
require 'header.php';
$myts =& MyTextSanitizer::getInstance();
if( empty($_POST['submit']) ){
	$form_id = isset($_GET['form_id']) ? intval($_GET['form_id']) : 0;
	if( empty($form_id) ){
		$forms =& $liaise_form_mgr->getPermittedForms();
		if( false != $forms && count($forms) === 1 ){
			$form =& $liaise_form_mgr->get($forms[0]->getVar('form_id'));
			require 'include/form_render.php';
		}else{
			$xoopsOption['template_main'] = 'liaise_index.html';
			require_once XOOPS_ROOT_PATH.'/header.php';
			if( count($forms) > 0 ){
				foreach( $forms as $form ){
					$xoopsTpl->append('forms',
								array('title' => $form->getVar('form_title'),
									'desc' => $form->getVar('form_desc'),
									'id' => $form->getVar('form_id')
									)
								);
				}
				$xoopsTpl->assign('forms_intro', $myts->makeTareaData4Show($xoopsModuleConfig['intro']));
			}
		}
	}else{
		if( !$form =& $liaise_form_mgr->get($form_id) ){
			header("Location: ".LIAISE_URL);
			exit();
		}else{
			if( false != $liaise_form_mgr->getSingleFormPermission($form_id) ){
				require 'include/form_render.php';
			}else{
				header("Location: ".LIAISE_URL);
				exit();
			}
		}
	}
	require XOOPS_ROOT_PATH.'/footer.php';
}else{
	$form_id = isset($_POST['form_id']) ? intval($_POST['form_id']) : 0;
	if( empty($form_id) || !$form =& $liaise_form_mgr->get($form_id) || $liaise_form_mgr->getSingleFormPermission($form_id) == false ){
		header("Location: ".LIAISE_URL);
		exit();
	}
	require 'include/form_execute.php';
}
?>