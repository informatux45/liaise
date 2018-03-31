<?php
// 2006-12-20 K.OHWADA
// use GIJOE's Ticket Class

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

// Includes
include __DIR__ . '/admin_header.php';
$liaise_ele_mgr = xoops_getModuleHandler('elements');

require_once LIAISE_ROOT_PATH . 'class/elementrenderer.php';

define('_THIS_PAGE', LIAISE_URL . 'admin/elements.php');

if (!isset($_POST['op']) || 'save' !== $_POST['op']) {
    $form_id = \Xmf\Request::getInt('form_id', 0, 'GET');
    if (empty($form_id)) {
        redirect_header(_LIAISE_ADMIN_URL, 0, _AM_NOTHING_SELECTED);
    }
    $form =& $liaise_form_mgr->get($form_id);

    adminHtmlHeader('editelement.php');

    $jump    = [];
    $jump[0] = new \XoopsFormSelect('', 'ele_type');
    $jump[0]->addOptionArray([
                                 'text'      => _AM_ELE_TEXT,
                                 'textarea'  => _AM_ELE_TAREA,
                                 'select'    => _AM_ELE_SELECT,
                                 'checkbox'  => _AM_ELE_CHECK,
                                 'radio'     => _AM_ELE_RADIO,
                                 'yn'        => _AM_ELE_YN,
                                 'html'      => _AM_ELE_HTML,
                                 'uploadimg' => _AM_ELE_UPLOADIMG,
                                 'upload'    => _AM_ELE_UPLOADFILE,
                                 'break'     => _AM_ELE_SEPARATOR,
                             ]);
    $jump[1] = new \XoopsFormHidden('op', 'edit');
    $jump[2] = new \XoopsFormHidden('form_id', $form_id);
    $jump[3] = new \XoopsFormButton('', 'submit', _GO, 'submit');
    echo '<div align="center">
            <form action="' . LIAISE_URL . 'admin/editelement.php" method="post">
                <b>' . _AM_ELE_CREATE . '</b>';
    foreach ($jump as $j) {
        echo "\n" . $j->render();
    }
    echo '
            </form>
        </div>
    <form action="' . _THIS_PAGE . '" method="post">
    <table class="outer" cellspacing="1" width="100%">
        <tr><th colspan="6">' . sprintf(_AM_ELEMENTS_OF_FORM, $form->getVar('form_title')) . '</th></tr>
        <tr>
            <td class="head" align="center" colspan="2">' . _AM_ELE_CAPTION . ' / ' . _AM_ELE_DEFAULT . '</td>
            <td class="head" align="center">' . _AM_ELE_REQ . '</td>
            <td class="head" align="center">' . _AM_ELE_ORDER . '</td>
            <td class="head" align="center">' . _AM_ELE_DISPLAY . '</td>
            <td class="head" align="center">' . _AM_ACTION . '</td>
        </tr>
    ';
    $criteria = new \Criteria('form_id', $form_id);
    $criteria->setSort('ele_order');
    $criteria->setOrder('ASC');

    // --- GIJOE's Ticket Class ---
    $ticket = $GLOBALS['xoopsSecurity']->createToken();
    // ------

    if ($elements = $liaise_ele_mgr->getObjects($criteria)) {
        foreach ($elements as $i) {
            $id        = $i->getVar('ele_id');
            $renderer  = new LiaiseElementRenderer($i);
            $ele_type  = $i->getVar('ele_type');
            $req       = $i->getVar('ele_req');
            $check_req = new \XoopsFormCheckBox('', 'ele_req[' . $id . ']', $req);
            $check_req->addOption(1, ' ');
            $ele_value     =& $renderer->constructElement(true);
            $order         = $i->getVar('ele_order');
            $text_order    = new \XoopsFormText('', 'ele_order[' . $id . ']', 3, 2, $order);
            $display       = $i->getVar('ele_display');
            $check_display = new \XoopsFormCheckBox('', 'ele_display[' . $id . ']', $display);
            $check_display->addOption(1, ' ');
            $hidden_id = new \XoopsFormHidden('ele_id[]', $id);
            echo '<tr>';
            // --- INFORMATUX ---
            if ('break' === $ele_type) {
                echo '<td class="odd" colspan="2">[SEPARATEUR] ' . $i->getVar('ele_caption') . "</td>\n";
            } else {
                echo '<td class="odd" colspan="2">' . $i->getVar('ele_caption') . "</td>\n";
            }
            // ------------------
            echo '<td class="even" rowspan="2" align="center">' . $check_req->render() . "</td>\n";
            echo '<td class="even" rowspan="2" align="center">' . $text_order->render() . "</td>\n";
            echo '<td class="even" rowspan="2" align="center">' . $check_display->render() . $hidden_id->render() . "</td>\n";

            // --- GIJOE's Ticket Class ---
            echo '<td class="even" nowrap="nowrap" rowspan="2">
                    <ul><li><a href="editelement.php?op=edit&amp;ele_id=' . $id . '&amp;form_id=' . $form_id . '">' . _EDIT . '</a></li>
                    <li><a href="editelement.php?op=edit&amp;ele_id=' . $id . '&amp;form_id=' . $form_id . '&amp;clone=1">' . _CLONE . '</a></li>';
            echo '<li><a href="editelement.php?op=delete&amp;ele_id=' . $id . '&amp;form_id=' . $form_id . '&amp;XOOPS_G_TICKET=' . $ticket . '">' . _DELETE . '</a></li></ul></td>';
            // ------

            echo '</tr>';
            echo '<tr><td class="even" colspan="2">' . $ele_value->render() . "</td>\n</tr>";
        }
    }

    $submit1 = new \XoopsFormButton('', 'submit1', _AM_SAVE, 'submit');
    $submit2 = new \XoopsFormButton('', 'submit2', _AM_SAVE_THEN_FORM, 'submit');
    $tray    = new \XoopsFormElementTray('');
    $tray->addElement($submit1);
    $tray->addElement($submit2);
    echo '
        <tr>
            <td class="foot" colspan="6" align="center">' . $tray->render() . '
        </tr>
    </table>
    ';
    $hidden_op      = new \XoopsFormHidden('op', 'save');
    $hidden_form_id = new \XoopsFormHidden('form_id', $form_id);
    echo $hidden_op->render();
    echo $hidden_form_id->render();

    // --- GIJOE's Ticket Class ---
    echo $GLOBALS['xoopsSecurity']->getTokenHTML();
    // ------

    echo '</form>';
    adminHtmlFooter();
} else {
    // --- GIJOE's Ticket Class ---
    if (!$GLOBALS['xoopsSecurity']->check()) {
        $err = 'Ticket Error <br>';
        $err .= $GLOBALS['xoopsSecurity']->getErrors();
        redirect_header(LIAISE_ADMIN_URL, 3, $err);
    }
    // ------

    $form_id = \Xmf\Request::getInt('form_id', 0, 'POST');
    if (empty($form_id)) {
        redirect_header(LIAISE_ADMIN_URL, 0, _AM_NOTHING_SELECTED);
    }
    extract($_POST, EXTR_OVERWRITE);
    $error = '';
    foreach ($ele_id as $id) {
        $element =& $liaise_ele_mgr->get($id);
        $req     = !empty($ele_req[$id]) ? 1 : 0;
        $element->setVar('ele_req', $req);
        $order = !empty($ele_order[$id]) ? (int)$ele_order[$id] : 0;
        $element->setVar('ele_order', $order);
        $display = !empty($ele_display[$id]) ? 1 : 0;
        $element->setVar('ele_display', $display);
        $type  = $element->getVar('ele_type');
        $value = $element->getVar('ele_value');
        switch ($type) {
            case 'text':
                $value[2] = $ele_value[$id];
                break;
            case 'textarea':
            case 'html':
                $value[0] = $ele_value[$id];
                break;
            case 'select':
                $new_vars  = [];
                $opt_count = 1;
                if (isset($ele_value[$id])) {
                    if (is_array($ele_value[$id])) {
//                        while ($j = each($value[2])) {
                        foreach (value[2] as $j) {
                            if (in_array($opt_count, $ele_value[$id])) {
                                $new_vars[$j['key']] = 1;
                            } else {
                                $new_vars[$j['key']] = 0;
                            }
                            $opt_count++;
                        }
                    } else {
                        if (count($value[2]) > 1) {
//                            while ($j = each($value[2])) {
                            foreach ($value[2] as $j) {
                                if ($opt_count == $ele_value[$id]) {
                                    $new_vars[$j['key']] = 1;
                                } else {
                                    $new_vars[$j['key']] = 0;
                                }
                                $opt_count++;
                            }
                        } else {
//                            while ($j = each($value[2])) {
                            foreach ($value[2] as $j) {
                                if (!empty($ele_value[$id])) {
                                    $new_vars = [$j['key'] => 1];
                                } else {
                                    $new_vars = [$j['key'] => 0];
                                }
                            }
                        }
                    }
                    $value[2] = $new_vars;
                } else {
                    foreach ($value[2] as $k => $v) {
                        $value[2][$k] = 0;
                    }
                }
                break;
            case 'checkbox':
                $new_vars  = [];
                $opt_count = 1;
                if (isset($ele_value[$id]) && is_array($ele_value[$id])) {
//                    while ($j = each($value)) {
                    foreach ($value as $j) {
                        if (in_array($opt_count, $ele_value[$id])) {
                            $new_vars[$j['key']] = 1;
                        } else {
                            $new_vars[$j['key']] = 0;
                        }
                        $opt_count++;
                    }
                } else {
                    if (count($value) > 1) {
                        //                    while ($j = each($value)) {
                        foreach ($value as $j) {
                            $new_vars[$j['key']] = 0;
                        }
                    } else {
                        //                    while ($j = each($value)) {
                        foreach ($value as $j) {
                            if (!empty($ele_value[$id])) {
                                $new_vars = [$j['key'] => 1];
                            } else {
                                $new_vars = [$j['key'] => 0];
                            }
                        }
                    }
                }
                $value = $new_vars;
                break;
            case 'radio':
            case 'yn':
                $new_vars = [];
                $i        = 1;
            //                    while ($j = each($value)) {
            foreach ($value as $j) {
                if ($ele_value[$id] == $i) {
                    $new_vars[$j['key']] = 1;
                } else {
                    $new_vars[$j['key']] = 0;
                }
                $i++;
            }
                $value = $new_vars;
                break;
            case 'uploadimg':
                $value[0] = (int)$ele_value[$id][0];
                $value[4] = (int)$ele_value[$id][4];
                $value[5] = (int)$ele_value[$id][5];
                break;
            case 'upload':
                $value[0] = (int)$ele_value[$id][0];
                break;
            case 'break': // INFORMATUX
                $value[0] = $ele_value[$id][0];
                break;
            default:
                break;
        }
        $element->setVar('ele_value', $value, true);
        if (!$liaise_ele_mgr->insert($element)) {
            $error .= $element->getHtmlErrors();
        }
    }
    if (empty($error)) {
        if (isset($_POST['submit2'])) {
            redirect_header(LIAISE_URL . 'admin/forms.php?op=edit&form_id=' . $form_id, 0, _AM_DBUPDATED);
        } else {
            redirect_header(_THIS_PAGE . '?form_id=' . $form_id, 0, _AM_DBUPDATED);
        }
    } else {
        adminHtmlHeader('editelement.php');
        echo $error;
        adminHtmlFooter();
    }
}
include __DIR__ . '/footer.php';
xoops_cp_footer();
