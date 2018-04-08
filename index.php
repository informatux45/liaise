<?php
// 2006-12-20 K.OHWADA
// use GIJOE's Ticket Class
// use captcha

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

use XoopsModules\Liaise;
/** @var Liaise\Helper $helper */
$helper = Liaise\Helper::getInstance();

require_once __DIR__ . '/header.php';
$myts = \MyTextSanitizer::getInstance();

// --- reload ---
$liaise_error = null;
// -----

if (empty($_POST['submit'])) {
    global $xoopsTpl;
    $form_id = \Xmf\Request::getInt('form_id', 0, 'GET');

    if (empty($form_id)) {
        $forms =& $liaise_form_mgr->getPermittedForms();
        if (false !== $forms && 1 === count($forms)) {
            $form =& $liaise_form_mgr->get($forms[0]->getVar('form_id'));
            require_once __DIR__ . '/include/form_render.php';
        } else {
            // -------------------------------------------------------
            $GLOBALS['xoopsOption']['template_main'] = 'xliaise_index.html';
            // -------------------------------------------------------
            require_once XOOPS_ROOT_PATH . '/header.php';
            if (count($forms) > 0) {
                foreach ($forms as $form) {
                    $xoopsTpl->append('forms', [
                        'title' => $form->getVar('form_title'),
                        'desc'  => $form->getVar('form_desc'),
                        'id'    => $form->getVar('form_id')
                    ]);
                }
                $xoopsTpl->assign('forms_intro', $myts->displayTarea($helper->getConfig('intro')));
            }
        }
    } else {
        if (5 == $form_id) {
        }
        if (!$form =& $liaise_form_mgr->get($form_id)) {
            header('Location: ' . LIAISE_URL);
            exit();
        } else {
            if (false !== $liaise_form_mgr->getSingleFormPermission($form_id)) {
                require_once __DIR__ . '/include/form_render.php';
            } else {
                header('Location: ' . LIAISE_URL);
                exit();
            }
        }
    }

    $xoopsTpl->assign('forms_breadcrumb', $helper->getConfig('breadcrumb'));
    require XOOPS_ROOT_PATH . '/footer.php';
} else {
    $form_id = \Xmf\Request::getInt('form_id', 0, 'POST');
    if (empty($form_id)
        || !$form =& $liaise_form_mgr->get($form_id)
                     || false === $liaise_form_mgr->getSingleFormPermission($form_id)) {
        header('Location: ' . LIAISE_URL);
        exit();
    }

    // --- GIJOE's Ticket Class ---
//    require_once LIAISE_ROOT_PATH . 'include/gtickets.php';

    if (!$GLOBALS['xoopsSecurity']->check()) {
        $liaise_error = 'Ticket Error';
    }
    // ----------------------------

    // ---------- captcha ---------
    if ($helper->getConfig('captcha') && empty($liaise_error)) {
        require_once LIAISE_ROOT_PATH . 'class/captcha_x/class.captcha_x.php';
        $captcha = new captcha_x();
        if (!isset($_POST['captcha']) || !$captcha->validate($_POST['captcha'])) {
            $liaise_error = _LIAISE_CAPTCHA_ERROR;
        }
    }
    // ----------------------------

    // ----------- reload ---------
    if ($liaise_error) {
        if (!$form =& $liaise_form_mgr->get($form_id)) {
            header('Location: ' . LIAISE_URL);
            exit();
        }
        require_once __DIR__ . '/include/form_render.php';
        require XOOPS_ROOT_PATH . '/footer.php';
        exit();
    }
    // ----------------------------

    require_once __DIR__ . '/include/form_execute.php';
}
