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

require_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
$liaise_ele_mgr = $helper->getHandler('Elements');
//require_once LIAISE_ROOT_PATH . 'class/elementrenderer.php';

/** @var Liaise\Helper $helper */
$helper = Liaise\Helper::getInstance();

// -------------------------------------------------------
$GLOBALS['xoopsOption']['template_main'] = 'xliaise_form.tpl';
// -------------------------------------------------------
require_once XOOPS_ROOT_PATH . '/header.php';
$criteria = new \CriteriaCompo();
$criteria->add(new \Criteria('form_id', $form->getVar('form_id')));
$criteria->add(new \Criteria('ele_display', 1));
$criteria->setSort('ele_order');
$criteria->setOrder('ASC');
$elements = $liaise_ele_mgr->getObjects($criteria, true);

$form_output = new \XoopsThemeForm($form->getVar('form_title'), 'liaise_' . $form->getVar('form_id'), LIAISE_URL . 'index.php', 'post', true);
foreach ($elements as $i) {
    $renderer = new Liaise\ElementRenderer($i);
    $form_ele = &$renderer->constructElement();
    $req      = (int)$i->getVar('ele_req');
    $form_output->addElement($form_ele, $req);
    unset($form_ele);
}

// --- Security Check ---
//require_once LIAISE_ROOT_PATH . 'include/gtickets.php';

//$form_output->addElement($xoopsGTicket->getTicketXoopsForm(__LINE__));
// ------

// --- captcha ---
if ($helper->getConfig('captcha')) {
    $server  = LIAISE_URL . 'server.php';
    $onclick = "javasript:this.src='" . $server . "?'+Math.random();";
    $captcha = _LIAISE_CAPTCHA_DESC . "<br>\n";
//    $captcha .= '<img src="' . $server . '" onclick="' . $onclick . '" alt="CAPTCHA image" style="padding: 3px">' . "<br>\n";
    $captcha .= '<img class="xliaise_img_captcha" src="'. $server .'" onclick="'. $onclick .'" alt="CAPTCHA image" style="padding: 3px" />'."<br />\n";
    $captcha .= '<input name="captcha" type="text">';
    $form_output->addElement(new \XoopsFormLabel(_LIAISE_CAPTCHA, $captcha));
}
// ------

// --- reload ---
if ($liaise_error) {
    $xoopsTpl->assign('form_error', $liaise_error);
}
// -----

$form_output->addElement(new \XoopsFormHidden('form_id', $form->getVar('form_id')));
$form_output->addElement(new \XoopsFormButton('', 'submit', $form->getVar('form_submit_text'), 'submit'));
// $form_output->assign($xoopsTpl);

$c    = 0;
$eles = [];
foreach ($form_output->getElements() as $e) {
    $id = $req = $name = $ele_type = $except = false;

    $name    = $e->getName();
    $caption = $e->getCaption();
    if (!empty($name)) {
        $id     = str_replace('ele_', '', $e->getName());
        $except = '1';
    } elseif (method_exists($e, 'getElements')) {
        $obj    = $e->getElements();
        $id     = str_replace('ele_', '', $e->getName());
        $id     = str_replace('[]', '', $id);
        $except .= '2';
    }
    if (isset($elements[$id])) {
        $req      = $elements[$id]->getVar('ele_req') ? true : false;
        $ele_type = $elements[$id]->getVar('ele_type');
        $except   .= '3';
    } else {
        $req    = false;
        $except .= '4';
    }
    $eles[$c]['insbreak'] = $name . ' - ' . $caption . ' - ' . $id . ' - ' . $except;
    $eles[$c]['caption']  = $caption;
    $eles[$c]['name']     = $name;
    $eles[$c]['body']     = $e->render();
    $eles[$c]['hidden']   = $e->isHidden();
    $eles[$c]['required'] = $req;
    $eles[$c]['ele_type'] = $ele_type;
    $c++;
}
$js = $form_output->renderValidationJS();
$xoopsTpl->assign('form_output', [
    'title'      => $form_output->getTitle(),
    'name'       => $form_output->getName(),
    'action'     => $form_output->getAction(),
    'method'     => $form_output->getMethod(),
    'extra'      => 'onsubmit="return xoopsFormValidate_' . $form_output->getName() . '();"' . $form_output->getExtra(),
    'javascript' => $js,
    'elements'   => $eles,
]);

$xoopsTpl->assign('form_req_prefix', $helper->getConfig('prefix'));
$xoopsTpl->assign('form_req_suffix', $helper->getConfig('suffix'));
$xoopsTpl->assign('form_intro', $form->getVar('form_intro'));
$xoopsTpl->assign('form_text_global', $myts->displayTarea($helper->getConfig('global')));
if (0 == $form->getVar('form_order')) {
    if (!isset($xoopsUser) || !is_object($xoopsUser) || !$xoopsUser->isAdmin()) {
        header('Location: ' . LIAISE_URL);
        exit();
    }
    $xoopsTpl->assign('form_is_hidden', _LIAISE_FORM_IS_HIDDEN);
}

$xoopsTpl->assign('xoops_pagetitle', $form->getVar('form_title'));
