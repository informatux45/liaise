<?php
// 2006-12-20 K.OHWADA
// use GIJOE's Ticket Class
// new file INFORMATUX

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
##  Author of this file: NS Tai (aka tuff) / INFORMATUX [www.informatux.com] ##
##  URL: http://www.brandycoke.com/                                          ##
##  Project: Liaise                                                          ##
###############################################################################

include __DIR__ . '/admin_header.php';
$myts = \MyTextSanitizer::getInstance();
$op   = isset($_GET['op']) ? trim($_GET['op']) : false;
$op   = isset($_POST['op']) ? trim($_POST['op']) : $op;

switch ($op) {

    case 'list':
    default:
        global $xoopsDB;
        adminHtmlHeader('forms.php');
        $criteria = new \Criteria(1, 1);
        $criteria->setSort('form_order');
        $criteria->setOrder('ASC');
        if ($forms = $liaise_form_mgr->getObjects($criteria, 'admin_list')) {
            echo '<form action="' . _LIAISE_ADMIN_URL . '/forms.php" method="post">
                <table class="outer" cellspacing="1" width="100%">
                    <tr><th colspan="5">' . _AM_FORM_LISTING . '</th></tr>
                    <tr>
                        <td class="head" align="center">' . _AM_ID . '</td>
                        <td class="head" align="center">' . _AM_FORM_ORDER . '<br>' . _AM_FORM_ORDER_DESC . '</td>
                        <td class="head" align="center">' . _AM_FORM_TITLE . '</td>
                        <td class="head" align="center">' . _AM_FORM_SENDTO . '</td>
                        <td class="head" align="center">' . _AM_ACTION . '</td>
                    </tr>';

            // --- GIJOE's Ticket Class ---
            $ticket = $GLOBALS['xoopsSecurity']->createToken();
            // ------

            foreach ($forms as $f) {
                $id        = $f->getVar('form_id');
                $order     = new \XoopsFormText('', 'order[' . $id . ']', 3, 2, $f->getVar('form_order'));
                $group_mgr = xoops_getHandler('group');
                $sendto    = $f->getVar('form_send_to_group');
                if (false != $sendto && $group =& $group_mgr->get($sendto)) {
                    $sendto = $group->getVar('name');
                } else {
                    $sendto = _AM_FORM_SENDTO_ADMIN;
                }
                $ids = new \XoopsFormHidden('ids[]', $id);

                echo '
                    <tr>
                        <td class="odd" align="center">' . $id . '</td>
                        <td class="even" align="center">' . $order->render() . '</td>
                        <td class="odd"><a target="_blank" href="' . LIAISE_URL . '?form_id=' . $id . '">' . $f->getVar('form_title') . '</a></td>
                        <td class="odd" align="center">' . $sendto . '</td>
                        <td class="odd"><ul>
                            <li><a href="' . _LIAISE_ADMIN_URL . 'forms.php?op=edit&amp;form_id=' . $id . '">' . _AM_FORM_ACTION_EDITFORM . '</a></li>
                            <li><a href="elements.php?form_id=' . $id . '">' . _AM_FORM_ACTION_EDITELEMENT . '</a></li>
                            <li><a href="' . _LIAISE_ADMIN_URL . 'forms.php?op=edit&amp;clone=1&amp;form_id=' . $id . '">' . _AM_FORM_ACTION_CLONE . '</a></li>';
                echo '<li><a href="' . _LIAISE_ADMIN_URL . 'forms.php?op=delete&amp;form_id=' . $id . '&amp;XOOPS_G_TICKET=' . $ticket . '">';
                echo _DELETE . '</a></li>';
                $message_count = getMessagesCount($id);
                if (0 == $message_count) {
                    echo '<li><a href="' . _LIAISE_ADMIN_URL . 'forms.php?op=archive&amp;form_id=' . $id . '">' . _AM_FORM_ACTION_ARCHIVE . '</a></li>';
                } else {
                    echo '<li><a href="' . _LIAISE_ADMIN_URL . 'forms.php?op=archive&amp;form_id=' . $id . '">' . _AM_FORM_ACTION_ARCHIVE . ' (' . $message_count . ')</a></li>';
                }
                echo '</ul>' . $ids->render() . '</td>
                    </tr>';
                // ------
            }
            $submit = new \XoopsFormButton('', 'submit', _AM_RESET_ORDER, 'submit');
            echo '
                    <tr>
                        <td class="foot">&nbsp;</td>
                        <td class="foot" align="center">' . $submit->render() . '</td>
                        <td class="foot" colspan="3">&nbsp;</td>
                    </tr>
                    </table>';

            // --- GIJOE's Ticket Class ---
            echo $GLOBALS['xoopsSecurity']->getTokenHTML();
            // ------

            $hidden = new \XoopsFormHidden('op', 'saveorder');
            echo $hidden->render() . "\n</form>\n";
        }
        adminHtmlFooter();
        break;

    case 'archive':
        global $xoopsDB;
        adminHtmlHeader('forms.php');
        $form_id = (int)$_GET['form_id'];
        $sql     = 'SELECT * FROM ' . $xoopsDB->prefix('xliaise_forms_archive') . ' WHERE form_id = "' . $form_id . '" ORDER BY form_date DESC';
        $result  = $xoopsDB->query($sql);
        $archive = dbResultToArray($result);

        $form_name_sql = 'SELECT form_title FROM ' . $xoopsDB->prefix('xliaise_forms') . ' WHERE form_id = "' . $form_id . '"';
        $result_name   = $xoopsDB->query($form_name_sql);
        $form_name     = $xoopsDB->fetchArray($result_name);

        echo '<table class="outer" cellspacing="1" width="100%">
            <tr><th colspan="4">Formulaire : ' . $form_name['form_title'] . '</th></tr>
            <tr>
                <td class="head" align="center">' . _AM_ID . '</td>
                <td class="head" align="center">Date</td>
                <td class="head" align="center">Message</td>
                <td class="head" align="center">' . _AM_ACTION . '</td>
            </tr>';

        if ($archive) {
            // --- GIJOE's Ticket Class ---
            $ticket = $GLOBALS['xoopsSecurity']->createToken();
            // ----------------------------
            foreach ($archive as $row) {
                echo '<tr>
                    <td class="odd" align="center">' . $row['id'] . '</td>
                    <td class="even" align="center">' . formatDate($row['form_date']) . '</td>
                    <td class="odd" align="center">' . truncate(strip_tags($row['form_message']), 40, '..') . '</td>
                    <td class="odd">
                        <ul>
                            <li><a href="#" onclick="window.open(\'' . _LIAISE_ADMIN_URL . 'forms.php?op=archive_view&amp;form_id=' . $row['form_id'] . '&amp;msg_id=' . $row['id'] . '\', \'Message\', \'menubar=no, status=no, scrollbars=yes, menubar=no, width=550, height=420\');">Visualiser</a></li>
                            <li><a href="' . _LIAISE_ADMIN_URL . 'forms.php?op=archive_delete&amp;msg_id=' . $row['id'] . '&amp;XOOPS_G_TICKET=' . $ticket . '">' . _DELETE . '</a></li>
                         </ul>
                    </td>
                    </tr>';
            }
        } else {
            echo '<tr><th colspan="4" class="odd"><span style="font-size: 1.2em; font-weight: bold; color: red;">Pas de message pour ce formulaire</span></th></tr>';
        }

        echo '</table>';
        break;

    case 'archive_all':
        global $xoopsDB;
        adminHtmlHeader('forms.php');
        $sql     = 'SELECT * FROM ' . $xoopsDB->prefix('xliaise_forms_archive') . ' ORDER BY form_date DESC';
        $result  = $xoopsDB->query($sql);
        $archive = dbResultToArray($result);

        echo '<table class="outer" cellspacing="1" width="100%">
            <tr><th colspan="5">Tous les messages post&eacute;s sur les formulaires</th></tr>
            <tr>
                <td class="head" align="center">' . _AM_ID . '</td>
                <td class="head" align="center">Date</td>
                <td class="head" align="center">Formulaire</td>
                <td class="head" align="center">Message</td>
                <td class="head" align="center">' . _AM_ACTION . '</td>
            </tr>';

        if ($archive) {
            // --- GIJOE's Ticket Class ---
            $ticket = $GLOBALS['xoopsSecurity']->createToken();
            // ----------------------------
            foreach ($archive as $row) {
                if ('0' == $row['form_id']) {
                    $form_name['form_title'] = 'Demande de rappel';
                } else {
                    $form_name_sql = 'SELECT form_title FROM ' . $xoopsDB->prefix('xliaise_forms') . ' WHERE form_id = "' . $row['form_id'] . '"';
                    $result_name   = $xoopsDB->query($form_name_sql);
                    $form_name     = $xoopsDB->fetchArray($result_name);
                }

                echo '<tr>
                    <td class="odd" align="center">' . $row['id'] . '</td>
                    <td class="even" align="center">' . formatDate($row['form_date']) . '</td>
                    <td class="odd" align="center">' . $form_name['form_title'] . '</td>
                    <td class="even" align="center">' . truncate(strip_tags($row['form_message']), 40, '..') . '</td>
                    <td class="odd">
                        <ul>
                            <li><a href="#" onclick="window.open(\'' . _LIAISE_ADMIN_URL . 'forms.php?op=archive_view&amp;form_id=' . $row['form_id'] . '&amp;msg_id=' . $row['id'] . '\', \'Message\', \'menubar=no, status=no, scrollbars=yes, menubar=no, width=550, height=620\');">Visualiser</a></li>
                            <li><a href="' . _LIAISE_ADMIN_URL . 'forms.php?op=archive_delete&amp;msg_id=' . $row['id'] . '&amp;XOOPS_G_TICKET=' . $ticket . '">' . _DELETE . '</a></li>
                         </ul>
                    </td>
                    </tr>';
            }
        } else {
            echo '<tr><th colspan="5" class="odd"><span style="font-size: 1.2em; font-weight: bold; color: red;">' . _AM_XLIAISE_NO_MESSAGES . '</span></th></tr>';
        }

        echo '</table>';
        adminHtmlFooter();
        break;

    case 'archive_view':
        global $xoopsDB;
        adminHtmlHeaderPopup();
        // Message du visiteur
        $msg_id   = (int)$_GET['msg_id'];
        $message  = 'SELECT * FROM ' . $xoopsDB->prefix('xliaise_forms_archive') . ' WHERE id = "' . $msg_id . '"';
        $result   = $xoopsDB->query($message);
        $msg_info = $xoopsDB->fetchArray($result);
        // Nom du formulaire
        $form_id = (int)$_GET['form_id'];

        $form_name_sql = 'SELECT form_title FROM ' . $xoopsDB->prefix('xliaise_forms') . ' WHERE form_id = "' . $form_id . '"';
        $result_name   = $xoopsDB->query($form_name_sql);
        $form_name     = $xoopsDB->fetchArray($result_name);

        echo '<u>FORMULAIRE :</u> ' . $form_name['form_title'];
        echo '<br><br><u>DATE :</u> ' . formatDate($msg_info['form_date']);
        echo '<br><br><u>MESSAGE :</u><br>';
        echo nl2br($msg_info['form_message']);
        break;

    case 'archive_delete':
        if (empty($_POST['ok'])) {
            // --- GIJOE's Ticket Class ---
            if (!$GLOBALS['xoopsSecurity']->check(false)) {
                $err = 'Ticket Error <br>';
                $err .= $GLOBALS['xoopsSecurity']->getErrors();
                redirect_header(_LIAISE_ADMIN_URL, 3, $err);
            }
            // ----------------------------
            adminHtmlHeader('forms.php');
            // --- GIJOE's Ticket Class ---
            $ticket = $GLOBALS['xoopsSecurity']->createToken();
            xoops_confirm([
                              'op'             => 'archive_delete',
                              'msg_id'         => $_GET['msg_id'],
                              'ok'             => 1,
                              'XOOPS_G_TICKET' => $ticket
                          ], _LIAISE_ADMIN_URL . 'forms.php', 'Etes vous s&ucirc;r de vouloir supprimer ce message ?');
        // ----------------------------
        } else {
            // --- GIJOE's Ticket Class ---
            if (!$GLOBALS['xoopsSecurity']->check()) {
                $err = 'Ticket Error <br>';
                $err .= $GLOBALS['xoopsSecurity']->getErrors();
                redirect_header(_LIAISE_ADMIN_URL . 'forms.php', 3, $err);
            }
            // ----------------------------
            $msg_id = (int)$_POST['msg_id'];
            if (empty($msg_id)) {
                redirect_header(_LIAISE_ADMIN_URL . 'forms.php', 3, _AM_NOTHING_SELECTED . ' MSG ID: ' . $msg_id);
            }
            global $xoopsDB;
            $sql    = 'DELETE FROM ' . $xoopsDB->prefix('xliaise_forms_archive') . ' WHERE id = "' . $msg_id . '"';
            $result = $xoopsDB->query($sql);
            if (!$result) {
                redirect_header(_LIAISE_ADMIN_URL . 'forms.php', 3, 'Erreur lors de la mise a jour');
            } else {
                redirect_header(_LIAISE_ADMIN_URL . 'forms.php', 3, _AM_DBUPDATED);
            }
        }
        break;

    case 'edit':
        adminHtmlHeader('forms.php');

        $clone   = isset($_GET['clone']) ? (int)$_GET['clone'] : false;
        $form_id = isset($_GET['form_id']) ? (int)$_GET['form_id'] : 0;

        if (!empty($form_id)) {
            $form = $liaise_form_mgr->get($form_id);
        } else {
            $form = $liaise_form_mgr->create();
        }

        $text_form_title = new \XoopsFormText(_AM_FORM_TITLE, 'form_title', 50, 255, $form->getVar('form_title', 'e'));

        $group_ids              = $modulepermHandler->getGroupIds($liaise_form_mgr->perm_name, $form_id, $xoopsModule->getVar('mid'));
        $select_form_group_perm = new \XoopsFormSelectGroup(_AM_FORM_PERM, 'form_group_perm', true, $group_ids, 5, true);

        $select_form_send_method = new \XoopsFormSelect(_AM_FORM_SEND_METHOD, 'form_send_method', $form->getVar('form_send_method'));
        $select_form_send_method->addOption('e', _AM_FORM_SEND_METHOD_MAIL);
        $select_form_send_method->addOption('p', _AM_FORM_SEND_METHOD_PM);
        $select_form_send_method->setDescription(_AM_FORM_SEND_METHOD_DESC);

        $select_form_send_to_group = new \XoopsFormSelectGroup(_AM_FORM_SENDTO, 'form_send_to_group', false, $form->getVar('form_send_to_group'));
        $select_form_send_to_group->addOption('0', _AM_FORM_SENDTO_ADMIN);

        $select_form_delimiter = new \XoopsFormSelect(_AM_FORM_DELIMETER, 'form_delimiter', $form->getVar('form_delimiter'));
        $select_form_delimiter->addOption('s', _AM_FORM_DELIMETER_SPACE);
        $select_form_delimiter->addOption('b', _AM_FORM_DELIMETER_BR);

        $text_form_order = new \XoopsFormText(_AM_FORM_ORDER, 'form_order', 3, 2, $form->getVar('form_order'));
        $text_form_order->setDescription(_AM_FORM_ORDER_DESC);

        $submit_text           = $form->getVar('form_submit_text');
        $text_form_submit_text = new \XoopsFormText(_AM_FORM_SUBMIT_TEXT, 'form_submit_text', 50, 50, empty($submit_text) ? _SUBMIT : $submit_text);

        $tarea_form_desc = new \XoopsFormDhtmlTextArea(_AM_FORM_DESC, 'form_desc', $form->getVar('form_desc', 'e'), 5);
        $tarea_form_desc->setDescription(_AM_FORM_DESC_DESC);

        $tarea_form_intro = new \XoopsFormDhtmlTextArea(_AM_FORM_INTRO, 'form_intro', $form->getVar('form_intro', 'e'), 10);
        $tarea_form_intro->setDescription(_AM_FORM_INTRO_DESC);

        $text_form_whereto = new \XoopsFormText(_AM_FORM_WHERETO, 'form_whereto', 50, 255, $form->getVar('form_whereto'));
        $text_form_whereto->setDescription(_AM_FORM_WHERETO_DESC);

        $hidden_op = new \XoopsFormHidden('op', 'saveform');
        $submit1   = new \XoopsFormButton('', 'submit1', _AM_SAVE, 'submit');
        $submit2   = new \XoopsFormButton('', 'submit2', _AM_SAVE_THEN_ELEMENTS, 'submit');
        $tray      = new \XoopsFormElementTray('');
        $tray->addElement($submit1);
        $tray->addElement($submit2);

        if (empty($form_id)) {
            $caption = _AM_FORM_NEW;
        } else {
            if ($clone) {
                $caption         = sprintf(_AM_COPIED, $form->getVar('form_title'));
                $clone_form_id   = new \XoopsFormHidden('clone_form_id', $form_id);
                $text_form_title = new \XoopsFormText(_AM_FORM_TITLE, 'form_title', 50, 255, sprintf(_AM_COPIED, $form->getVar('form_title', 'e')));
            } else {
                $caption        = sprintf(_AM_FORM_EDIT, $form->getVar('form_title'));
                $hidden_form_id = new \XoopsFormHidden('form_id', $form_id);
            }
        }
        $output = new \XoopsThemeForm($caption, 'editform', _LIAISE_ADMIN_URL . 'forms.php');
        $output->addElement($text_form_title, true);
        $output->addElement($select_form_group_perm);
        $output->addElement($select_form_send_method);
        $output->addElement($select_form_send_to_group);
        $output->addElement($select_form_delimiter);
        $output->addElement($text_form_order);
        $output->addElement($text_form_submit_text, true);
        $output->addElement($tarea_form_desc);
        $output->addElement($tarea_form_intro);
        $output->addElement($text_form_whereto);
        $output->addElement($hidden_op);
        if (isset($hidden_form_id) && is_object($hidden_form_id)) {
            $output->addElement($hidden_form_id);
        }
        if (isset($clone_form_id) && is_object($clone_form_id)) {
            $output->addElement($clone_form_id);
        }
        $output->addElement($tray);

        // --- GIJOE's Ticket Class ---
        //        $output->addElement($xoopsGTicket->getTicketXoopsForm(__LINE__));
        // ------

        $output->display();
        adminHtmlFooter();
        break;

    case 'delete':
        if (empty($_POST['ok'])) {

            // --- GIJOE's Ticket Class ---
            if (!$GLOBALS['xoopsSecurity']->check(false)) {
                $err = 'Ticket Error <br>';
                $err .= $GLOBALS['xoopsSecurity']->getErrors();
                redirect_header(_LIAISE_ADMIN_URL . 'forms.php', 3, $err);
            }
            // ------

            adminHtmlHeader('forms.php');

            // --- GIJOE's Ticket Class ---
            //            xoops_confirm(array('op' => 'delete', 'form_id' => $_GET['form_id'], 'ok' => 1), _LIAISE_ADMIN_URL, _AM_FORM_CONFIRM_DELETE);
            $ticket = $GLOBALS['xoopsSecurity']->createToken();
            xoops_confirm([
                              'op'             => 'delete',
                              'form_id'        => $_GET['form_id'],
                              'ok'             => 1,
                              'XOOPS_G_TICKET' => $ticket
                          ], _LIAISE_ADMIN_URL . 'forms.php', _AM_FORM_CONFIRM_DELETE);
        // ------
        } else {

            // --- GIJOE's Ticket Class ---
            if (!$GLOBALS['xoopsSecurity']->check()) {
                $err = 'Ticket Error <br>';
                $err .= $GLOBALS['xoopsSecurity']->getErrors();
                redirect_header(_LIAISE_ADMIN_URL . 'forms.php', 3, $err);
            }
            // ------

            $form_id = (int)$_POST['form_id'];
            if (empty($form_id)) {
                redirect_header(_LIAISE_ADMIN_URL . 'forms.php', 0, _AM_NOTHING_SELECTED);
            }
            $form =& $liaise_form_mgr->get($form_id);
            $liaise_form_mgr->delete($form);
            $liaise_ele_mgr = xoops_getModuleHandler('elements');
            $criteria       = new \Criteria('form_id', $form_id);
            $liaise_ele_mgr->deleteAll($criteria);
            $liaise_form_mgr->deleteFormPermissions($form_id);
            redirect_header(_LIAISE_ADMIN_URL . 'forms.php', 0, _AM_DBUPDATED);
        }
        break;

    case 'saveorder':
        // --- GIJOE's Ticket Class ---
        if (!$GLOBALS['xoopsSecurity']->check()) {
            $err = 'Ticket Error <br>';
            $err .= $GLOBALS['xoopsSecurity']->getErrors();
            redirect_header(_LIAISE_ADMIN_URL . 'forms.php', 3, $err);
        }
        // ------

        if (!isset($_POST['ids']) || count($_POST['ids']) < 1) {
            redirect_header(_LIAISE_ADMIN_URL . 'forms.php', 0, _AM_NOTHING_SELECTED);
        }
        extract($_POST, EXTR_OVERWRITE);
        foreach ($ids as $id) {
            $id   = (0 == $id) ? '0' : $id;
            $form =& $liaise_form_mgr->get($id);
            $form->setVar('form_order', $order[$id]);
            $liaise_form_mgr->insert($form);
        }
        redirect_header(_LIAISE_ADMIN_URL . 'forms.php', 0, _AM_DBUPDATED);
        break;

    case 'saveform':
        // --- GIJOE's Ticket Class ---
        if (!$GLOBALS['xoopsSecurity']->check()) {
            $err = 'Ticket Error <br>';
            $err .= $GLOBALS['xoopsSecurity']->getErrors();
            redirect_header(_LIAISE_ADMIN_URL . 'forms.php', 3, $err);
        }
        // ------

        if (!isset($_POST['submit1']) && !isset($_POST['submit2'])) {
            redirect_header(_LIAISE_ADMIN_URL . 'forms.php', 0, _AM_NOTHING_SELECTED);
        }
        $error = '';
        extract($_POST, EXTR_OVERWRITE);
        if (!empty($form_id)) {
            $form = $liaise_form_mgr->get($form_id);
        } else {
            $form = $liaise_form_mgr->create();
        }
        $form->setVar('form_send_method', $form_send_method);
        $form->setVar('form_send_to_group', $form_send_to_group);
        $form->setVar('form_order', $form_order);
        $form->setVar('form_delimiter', $form_delimiter);
        $form->setVar('form_title', $form_title);
        $form->setVar('form_submit_text', $form_submit_text);
        $form->setVar('form_desc', $form_desc);
        $form->setVar('form_intro', $form_intro);
        $form->setVar('form_whereto', $form_whereto);
        if (!$ret = $liaise_form_mgr->insert($form)) {
            $error = $form->getHtmlErrors();
        } else {
            $liaise_form_mgr->deleteFormPermissions($ret);
            if (count($form_group_perm) > 0) {
                $liaise_form_mgr->insertFormPermissions($ret, $form_group_perm);
            }
            if (!empty($clone_form_id)) {
                $liaise_ele_mgr = xoops_getModuleHandler('elements');
                $criteria       = new \Criteria('form_id', $clone_form_id);
                $count          = $liaise_ele_mgr->getCount($criteria);
                if ($count > 0) {
                    $elements = $liaise_ele_mgr->getObjects($criteria);
                    foreach ($elements as $e) {
                        $cloned =& $e->xoopsClone();
                        $cloned->setVar('form_id', $ret);
                        if (!$liaise_ele_mgr->insert($cloned)) {
                            $error .= $cloned->getHtmlErrors();
                        }
                    }
                }
            } elseif (empty($form_id)) {
                $liaise_ele_mgr = xoops_getModuleHandler('elements');
                $error          = $liaise_ele_mgr->insertDefaults($ret);
            }
        }
        if (!empty($error)) {
            adminHtmlHeader('forms.php');
            echo $error;
        } else {
            if (isset($_POST['submit2'])) {
                redirect_header(LIAISE_URL . 'admin/elements.php?form_id=' . $ret, 0, _AM_DBUPDATED);
            } else {
                redirect_header(_LIAISE_ADMIN_URL . 'forms.php', 0, _AM_DBUPDATED);
            }
        }
        break;
}

include __DIR__ . '/footer.php';
xoops_cp_footer();
