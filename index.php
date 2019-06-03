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

require_once __DIR__ . '/header.php';

/** @var Liaise\Helper $helper */
$helper = Liaise\Helper::getInstance();
$myts   = \MyTextSanitizer::getInstance();

// --- reload ---
$liaise_error = null;
// -----

if (empty($_POST['submit'])) {
    global $xoopsTpl;
    $form_id = \Xmf\Request::getInt('form_id', 0, 'GET');

    if (empty($form_id)) {
        $forms = &$liaise_form_mgr->getPermittedForms();
        if (false !== $forms && 1 === count($forms)) {
            $form = &$liaise_form_mgr->get($forms[0]->getVar('form_id'));
            require_once __DIR__ . '/include/form_render.php';
        } else {
            // -------------------------------------------------------
            $GLOBALS['xoopsOption']['template_main'] = 'xliaise_index.tpl';
            // -------------------------------------------------------
            require_once XOOPS_ROOT_PATH . '/header.php';
            if (count($forms) > 0) {
                foreach ($forms as $form) {
                    $xoopsTpl->append('forms', [
                        'title' => $form->getVar('form_title'),
                        'desc'  => $form->getVar('form_desc'),
                        'id'    => $form->getVar('form_id'),
                    ]);
                }
                $xoopsTpl->assign('forms_intro', $myts->displayTarea($helper->getConfig('intro')));
            }
        }
    } else {
        if( !$form =& $liaise_form_mgr->get($form_id) ){
            header('Location: ' . LIAISE_URL);
            exit();
        }
        if (false !== $liaise_form_mgr->getSingleFormPermission($form_id)) {
            require_once __DIR__ . '/include/form_render.php';
        } else {
            header('Location: ' . LIAISE_URL);
            exit();
        }
    }

    $xoopsTpl->assign('forms_breadcrumb', $helper->getConfig('breadcrumb'));
    require_once XOOPS_ROOT_PATH . '/footer.php';
} else {
    $form_id = \Xmf\Request::getInt('form_id', 0, 'POST');
    if (empty($form_id)
        || !$form = &$liaise_form_mgr->get($form_id)
                     || false === $liaise_form_mgr->getSingleFormPermission($form_id)) {
        header('Location: ' . LIAISE_URL);
        exit();
    }

    // --- Security Check ---
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
        if (!$form = &$liaise_form_mgr->get($form_id)) {
            header('Location: ' . LIAISE_URL);
            exit();
        }
        require_once __DIR__ . '/include/form_render.php';
        require_once XOOPS_ROOT_PATH . '/footer.php';
        exit();
    }
    // ----------------------------

    require_once __DIR__ . '/include/form_execute.php';
}
