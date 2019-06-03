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

// Includes
require_once __DIR__ . '/admin_header.php';
$liaise_ele_mgr = $helper->getHandler('Elements');

//if (is_file(LIAISE_ROOT_PATH . 'class/elementrenderer.php')) {
//    require_once LIAISE_ROOT_PATH . 'class/elementrenderer.php';
//}

define('_THIS_PAGE', LIAISE_URL . 'admin/editelement.php');

/** @var Liaise\Helper $helper */
$helper = Liaise\Helper::getInstance();
$myts   = \MyTextSanitizer::getInstance();
if ($liaise_form_mgr->getCount() < 1) {
    redirect_header(LIAISE_ADMIN_URL, 0, _AM_GO_CREATE_FORM);
}

if (count($_POST) > 0) {
    extract($_POST);
} else {
    extract($_GET);
}

$op      = isset($_GET['op']) ? trim($_GET['op']) : '';
$op      = isset($_POST['op']) ? trim($_POST['op']) : $op;
$clone   = \Xmf\Request::getInt('clone', 0, 'GET');
$clone   = isset($_POST['clone']) ? trim($_POST['clone']) : $clone;
$form_id = \Xmf\Request::getInt('form_id', 0, 'GET');
$form_id = isset($_POST['form_id']) ? trim($_POST['form_id']) : $form_id;

if (\Xmf\Request::hasVar('submit', 'POST') && _AM_ELE_ADD_OPT_SUBMIT == $_POST['submit'] && \Xmf\Request::getInt('addopt', 0, 'POST') > 0) {
    $op = 'edit';
}

switch ($op) {
    case 'edit':
        adminHtmlHeader('editelement.php');
        if (!empty($ele_id)) {
            $element      = $liaise_ele_mgr->get($ele_id);
            $ele_type     = $element->getVar('ele_type');
            $output_title = $clone ? _AM_ELE_CREATE : sprintf(_AM_ELE_EDIT, $element->getVar('ele_caption'));
        } else {
            $element = $liaise_ele_mgr->create();
            // Check if form_id > 0
            if ($form_id > 0) {
                global $xoopsDB;
                $sql          = 'SELECT form_title FROM ' . $xoopsDB->prefix('xliaise_forms') . ' WHERE form_id = "' . $form_id . '"';
                $result       = $xoopsDB->query($sql);
                $result       = @mysqli_fetch_object($result);
                $formname     = $result->form_title;
                $output_title = _AM_ELE_CREATE . ' (' . $formname . ') : ' . getElementName(trim($_REQUEST['ele_type']));
            } else {
                $output_title = _AM_ELE_CREATE . ' : ' . getElementName(trim($_REQUEST['ele_type']));
            }
        }
        $output = new \XoopsThemeForm($output_title, 'form_ele', _THIS_PAGE, 'post', true);
        if (empty($addopt)) {
            $ele_caption      = $clone ? sprintf(_AM_COPIED, $element->getVar('ele_caption', 'f')) : $element->getVar('ele_caption', 'f');
            $text_ele_caption = new \XoopsFormText(_AM_ELE_CAPTION, 'ele_caption', 50, 255, $ele_caption);
            $value            = $element->getVar('ele_value', 'f');
            $req              = $element->getVar('ele_req');
            $display          = $element->getVar('ele_display');
            $order            = $element->getVar('ele_order');
        } else {
            $ele_caption      = $myts->htmlSpecialChars($myts->stripSlashesGPC($ele_caption));
            $text_ele_caption = new \XoopsFormText(_AM_ELE_CAPTION, 'ele_caption', 50, 255, $ele_caption);
            $req              = isset($_POST['ele_req']) ? 1 : 0;
            $display          = isset($_POST['ele_display']) ? 1 : 0;
            $order            = \Xmf\Request::getInt('ele_order', 0, 'POST');
        }
        $output->addElement($text_ele_caption);

        $check_ele_req = new \XoopsFormCheckBox(_AM_ELE_REQ, 'ele_req', $req);
        $check_ele_req->addOption(1, ' ');
        $output->addElement($check_ele_req);

        $check_ele_display = new \XoopsFormCheckBox(_AM_ELE_DISPLAY, 'ele_display', $display);
        $check_ele_display->addOption(1, ' ');
        $output->addElement($check_ele_display);

        $text_ele_order = new \XoopsFormText(_AM_ELE_ORDER, 'ele_order', 3, 2, $order);
        $output->addElement($text_ele_order);

        switch ($ele_type) {
            case 'text':
            default:
                require_once __DIR__ . '/ele_text.php';
                break;
            case 'textarea':
                require_once __DIR__ . '/ele_tarea.php';
                break;
            case 'select':
                require_once __DIR__ . '/ele_select.php';
                break;
            case 'checkbox':
                require_once __DIR__ . '/ele_check.php';
                break;
            case 'radio':
                require_once __DIR__ . '/ele_radio.php';
                break;
            case 'yn':
                require_once __DIR__ . '/ele_yn.php';
                break;
            case 'html':
                $check_ele_req->setExtra('disabled="disabled"');
                require_once __DIR__ . '/ele_html.php';
                break;
            case 'uploadimg':
                require_once __DIR__ . '/ele_uploadimg.php';
                break;
            case 'upload':
                require_once __DIR__ . '/ele_upload.php';
                break;
            case 'break':
                require_once __DIR__ . '/ele_break.php';
                break;
        }

        $hidden_op   = new \XoopsFormHidden('op', 'save');
        $hidden_type = new \XoopsFormHidden('ele_type', $ele_type);
        $output->addElement($hidden_op);
        $output->addElement($hidden_type);

        if (true === $clone || empty($form_id)) {
            $select_apply_form = new \XoopsFormSelect(_AM_ELE_APPLY_TO_FORM, 'form_id', $form_id);
            $forms             = $liaise_form_mgr->getObjects(null, 'form_id, form_title');
            foreach ($forms as $f) {
                $select_apply_form->addOption($f->getVar('form_id'), $f->getVar('form_title'));
            }
            $output->addElement($select_apply_form);
            $hidden_clone = new \XoopsFormHidden('clone', 1);
            $output->addElement($hidden_clone);
        } else {
            $hidden_form_id = new \XoopsFormHidden('form_id', $form_id);
            $output->addElement($hidden_form_id);
        }

        if (!empty($ele_id) && !$clone) {
            $hidden_id = new \XoopsFormHidden('ele_id', $ele_id);
            $output->addElement($hidden_id);
        }
        $submit = new \XoopsFormButton('', 'submit', _AM_SAVE, 'submit');
        $cancel = new \XoopsFormButton('', 'cancel', _CANCEL, 'button');
        $cancel->setExtra('onclick="javascript:history.go(-1);"');
        $tray = new \XoopsFormElementTray('');
        $tray->addElement($submit);
        $tray->addElement($cancel);
        $output->addElement($tray);

        // --- Security Check ---
        //        $output->addElement($xoopsGTicket->getTicketXoopsForm(__LINE__));
        // ------

        $output->display();
        adminHtmlFooter();
        break;
    case 'delete':

        if (empty($ele_id)) {
            redirect_header(_LIAISE_ADMIN_URL, 0, _AM_NOTHING_SELECTED);
        }
        if (empty($_POST['ok'])) {
            // --- Security Check ---
            if (!$GLOBALS['xoopsSecurity']->check(false)) {
                $err = 'Ticket Error <br>';
                $err .= $GLOBALS['xoopsSecurity']->getErrors();
                redirect_header(_LIAISE_ADMIN_URL, 3, $err);
            }
            // ------

            adminHtmlHeader('editelement.php');

            // --- Security Check ---
            //            xoops_confirm(array('op' => 'delete', 'ele_id' => $ele_id, 'form_id' => $form_id, 'ok' => 1), _THIS_PAGE, _AM_ELE_CONFIRM_DELETE);
            $ticket = $GLOBALS['xoopsSecurity']->createToken();
            xoops_confirm([
                              'op'             => 'delete',
                              'ele_id'         => $ele_id,
                              'form_id'        => $form_id,
                              'ok'             => 1,
                              'XOOPS_G_TICKET' => $ticket,
                          ], _THIS_PAGE, _AM_ELE_CONFIRM_DELETE);
            // ------
        } else {
            // --- Security Check ---
            if (!$GLOBALS['xoopsSecurity']->check()) {
                $err = 'Ticket Error <br>';
                $err .= $GLOBALS['xoopsSecurity']->getErrors();
                redirect_header(_LIAISE_ADMIN_URL, 3, $err);
            }
            // ------

            $element = &$liaise_ele_mgr->get($ele_id);
            $liaise_ele_mgr->delete($element);
            redirect_header(_LIAISE_ADMIN_URL . 'elements.php?form_id=' . $form_id, 0, _AM_DBUPDATED);
        }
        break;
    case 'save':
        // --- Security Check ---
        if (!$GLOBALS['xoopsSecurity']->check()) {
            $err = 'Ticket Error <br>';
            $err .= $GLOBALS['xoopsSecurity']->getErrors();
            redirect_header(_LIAISE_ADMIN_URL, 3, $err);
        }
        // ------

        if (!empty($ele_id)) {
            $element = $liaise_ele_mgr->get($ele_id);
        } else {
            $element = $liaise_ele_mgr->create();
        }
        $element->setVar('form_id', $form_id);
        $element->setVar('ele_caption', $ele_caption);
        $req = !empty($ele_req) ? 1 : 0;
        $element->setVar('ele_req', $req);
        $order = empty($ele_order) ? 0 : (int)$ele_order;
        $element->setVar('ele_order', $order);
        $display = !empty($ele_display) ? 1 : 0;
        $element->setVar('ele_display', $display);
        $element->setVar('ele_type', $ele_type);
        $value = [];
        switch ($ele_type) {
            case 'text':
                $value[] = !empty($ele_value[0]) ? (int)$ele_value[0] : $helper->getConfig('t_width');
                $value[] = !empty($ele_value[1]) ? (int)$ele_value[1] : $helper->getConfig('t_max');
                $value[] = $ele_value[2];
                break;
            case 'textarea':
            case 'html':
                $value[] = $ele_value[0];
                if (0 != (int)$ele_value[1]) {
                    $value[] = (int)$ele_value[1];
                } else {
                    $value[] = $helper->getConfig('ta_rows');
                }
                if (0 != (int)$ele_value[2]) {
                    $value[] = (int)$ele_value[2];
                } else {
                    $value[] = $helper->getConfig('ta_cols');
                }
                break;
            case 'select':
                $value[0]   = $ele_value[0] > 1 ? (int)$ele_value[0] : 1;
                $value[1]   = !empty($ele_value[1]) ? 1 : 0;
                $v2         = [];
                $multi_flag = 1;
                //                while ($v = each($ele_value[2])) {
                foreach ($ele_value[2] as $v) {
                    if (!empty($v['value'])) {
                        if (1 == $value[1] || $multi_flag) {
                            if (1 == $checked[$v['key']]) {
                                $check      = 1;
                                $multi_flag = 0;
                            } else {
                                $check = 0;
                            }
                        } else {
                            $check = 0;
                        }
                        $v2[$v['value']] = $check;
                    }
                }
                $value[2] = $v2;
                break;
            case 'checkbox':
                //        while ($v = each($ele_value)) {
                foreach ($ele_value as $v) {
                    if (!empty($v['value'])) {
                        if (1 == $checked[$v['key']]) {
                            $check = 1;
                        } else {
                            $check = 0;
                        }
                        $value[$v['value']] = $check;
                    }
                }
                break;
            case 'radio':
                //        while ($v = each($ele_value)) {
                foreach ($ele_value as $v) {
                    if (!empty($v['value'])) {
                        if ($checked == $v['key']) {
                            $value[$v['value']] = 1;
                        } else {
                            $value[$v['value']] = 0;
                        }
                    }
                }
                break;
            case 'yn':
                if ('_NO' === $ele_value) {
                    $value = ['_YES' => 0, '_NO' => 1];
                } else {
                    $value = ['_YES' => 1, '_NO' => 0];
                }
                break;
            case 'uploadimg':
                $value[] = (int)$ele_value[0];
                $value[] = trim($ele_value[1]);
                $value[] = trim($ele_value[2]);
                $value[] = 1 != $ele_value[3] ? 0 : 1;
                $value[] = (int)$ele_value[4];
                $value[] = (int)$ele_value[5];
                break;
            case 'upload':
                $value[] = (int)$ele_value[0];
                $value[] = trim($ele_value[1]);
                $value[] = trim($ele_value[2]);
                $value[] = 1 != $ele_value[3] ? 0 : 1;
                break;
            case 'break':
                $value[] = $ele_value[0];
                break;
        }
        $element->setVar('ele_value', $value);
        if (!$liaise_ele_mgr->insert($element)) {
            adminHtmlHeader('editelement.php');
            echo $element->getHtmlErrors();
        } else {
            redirect_header(LIAISE_URL . 'admin/elements.php?form_id=' . $form_id, 0, _AM_DBUPDATED);
        }
        break;
    default:
        adminHtmlHeader('editelement.php');
        echo '<h4>' . _AM_ELE_CREATE . "</h4>
        <ul class='xliaise_editelement'>
        <li><a href='" . _THIS_PAGE . "?op=edit&amp;ele_type=text'>" . _AM_ELE_TEXT . "</a></li>
        <li><a href='" . _THIS_PAGE . "?op=edit&amp;ele_type=textarea'>" . _AM_ELE_TAREA . "</a></li>
        <li><a href='" . _THIS_PAGE . "?op=edit&amp;ele_type=select'>" . _AM_ELE_SELECT . "</a></li>
        <li><a href='" . _THIS_PAGE . "?op=edit&amp;ele_type=checkbox'>" . _AM_ELE_CHECK . "</a></li>
        <li><a href='" . _THIS_PAGE . "?op=edit&amp;ele_type=radio'>" . _AM_ELE_RADIO . "</a></li>
        <li><a href='" . _THIS_PAGE . "?op=edit&amp;ele_type=yn'>" . _AM_ELE_YN . "</a></li>
        <li><a href='" . _THIS_PAGE . "?op=edit&amp;ele_type=html'>" . _AM_ELE_HTML . "</a></li>
        <li><a href='" . _THIS_PAGE . "?op=edit&amp;ele_type=uploadimg'>" . _AM_ELE_UPLOADIMG . "</a></li>
        <li><a href='" . _THIS_PAGE . "?op=edit&amp;ele_type=upload'>" . _AM_ELE_UPLOADFILE . "</a></li>
        <li><a href='" . _THIS_PAGE . "?op=edit&amp;ele_type=break'>" . _AM_ELE_SEPARATOR . '</a></li>
        </ul>';
        adminHtmlFooter();
        break;
}
require_once __DIR__ . '/footer.php';
xoops_cp_footer();

function addOption($id1, $id2, $text = '', $type = 'check', $checked = null)
{
    $d = new \XoopsFormText('', $id1, 40, 255, $text);
    if ('check' === $type) {
        $c = new \XoopsFormCheckBox('', $id2, $checked);
        $c->addOption(1, ' ');
    } else {
        $c = new \XoopsFormRadio('', 'checked', $checked);
        $c->addOption($id2, ' ');
    }
    $t = new \XoopsFormElementTray('');
    $t->addElement($c);
    $t->addElement($d);

    return $t;
}

function addOptionsTray()
{
    $t = new \XoopsFormText('', 'addopt', 3, 2);
    $l = new \XoopsFormLabel('', sprintf(_AM_ELE_ADD_OPT, $t->render()));
    $b = new \XoopsFormButton('', 'submit', _AM_ELE_ADD_OPT_SUBMIT, 'submit');
    $r = new \XoopsFormElementTray('');
    $r->addElement($l);
    $r->addElement($b);

    return $r;
}
