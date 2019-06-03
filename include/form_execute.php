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

/** @var Liaise\Helper $helper */
$helper = Liaise\Helper::getInstance();
/** @var \XoopsMemberHandler $memberHandler */
$memberHandler = xoops_getHandler('member');

$liaise_ele_mgr = $helper->getHandler('Elements');
$criteria       = new \CriteriaCompo();
$criteria->add(new \Criteria('form_id', $form->getVar('form_id')), 'AND');
$criteria->add(new \Criteria('ele_display', 1), 'AND');
$criteria->setSort('ele_order');
$criteria->setOrder('ASC');
$elements = $liaise_ele_mgr->getObjects($criteria, true);

$msg = $err = $attachments = [];
foreach ($_POST as $k => $v) {
    if (preg_match('/^ele_[0-9]+$/', $k)) {
        $n          = explode('_', $k);
        $ele[$n[1]] = $v;
    }
}
if (\Xmf\Request::hasVar('xoops_upload_file', 'POST') && is_array($_POST['xoops_upload_file'])) {
    foreach ($_POST['xoops_upload_file'] as $k => $v) {
        $n          = explode('_', $v);
        $ele[$n[1]] = $v;
    }
}

foreach ($elements as $i) {
    $ele_id      = $i->getVar('ele_id');
    $ele_type    = $i->getVar('ele_type');
    $ele_value   = $i->getVar('ele_value');
    $ele_req     = $i->getVar('ele_req');
    $ele_caption = $i->getVar('ele_caption', 'n');
    if (isset($ele[$ele_id]) && !empty($ele[$ele_id])) {
        if ('' != $ele_caption) {
            $msg[$ele_id] = "\n" . $myts->stripSlashesGPC($ele_caption) . "\n";
        }
        switch ($ele_type) {
            case 'upload':
            case 'uploadimg':
                if (isset($_FILES['ele_' . $ele_id])) {
                    //                    require_once LIAISE_ROOT_PATH . 'class/uploader.php';
                    $ext  = empty($ele_value[1]) ? 0 : explode('|', $ele_value[1]);
                    $mime = empty($ele_value[2]) ? 0 : explode('|', $ele_value[2]);

                    if ('uploadimg' === $ele_type) {
                        $uploader[$ele_id] = new Liaise\Uploader(LIAISE_UPLOAD_PATH, $ele_value[0], $ext, $mime, $ele_value[4], $ele_value[5]);
                    } else {
                        $uploader[$ele_id] = new Liaise\Uploader(LIAISE_UPLOAD_PATH, $ele_value[0], $ext, $mime);
                    }
                    if (0 == $ele_value[0]) {
                        $uploader[$ele_id]->noAdminSizeCheck(true);
                    }
                    if ($uploader[$ele_id]->fetchMedia('ele_' . $ele_id, null, $i)) {
                        $attachments[] = [
                            'id'     => $ele_id,
                            'path'   => $_FILES['ele_' . $ele_id]['tmp_name'],
                            'name'   => $_FILES['ele_' . $ele_id]['name'],
                            'saveto' => $ele_value[3],
                        ];
                    } else {
                        if (count($uploader[$ele_id]->errors) > 0) {
                            $err[] = $uploader[$ele_id]->getErrors();
                        }
                    }
                }
                break;
            case 'text':
                $ele[$ele_id] = trim($ele[$ele_id]);
                if (preg_match('/\{EMAIL\}/', $ele_value[2])) {
                    if (!checkEmail($ele[$ele_id])) {
                        $err[] = _LIAISE_ERR_INVALIDMAIL;
                    } else {
                        $reply_mail = $ele[$ele_id];
                    }
                }
                if (preg_match('/\{UNAME\}/', $ele_value[2])) {
                    $reply_name = $ele[$ele_id];
                }
                $msg[$ele_id] .= $myts->stripSlashesGPC($ele[$ele_id]);
                break;
            case 'textarea':
                $msg[$ele_id] .= $myts->stripSlashesGPC($ele[$ele_id]);
                break;
            case 'radio':
                $opt_count = 1;
                //                while ($v = each($ele_value)) {
                foreach ($ele_value as $v) {
                    if ($opt_count == $ele[$ele_id]) {
                        $other = checkOther($v['key'], $ele_id, $ele_caption);
                        if (false !== $other) {
                            $msg[$ele_id] .= $other;
                        } else {
                            $msg[$ele_id] .= $myts->stripSlashesGPC($v['key']);
                        }
                    }
                    $opt_count++;
                }
                break;
            case 'yn':
                $v            = (2 == $ele[$ele_id]) ? _NO : _YES;
                $msg[$ele_id] .= $myts->stripSlashesGPC($v);
                break;
            case 'checkbox':
                $opt_count = 1;
                $ch        = [];
                //                while ($v = each($ele_value)) {
                foreach ($ele_value as $v) {
                    if (is_array($ele[$ele_id])) {
                        if (in_array($opt_count, $ele[$ele_id])) {
                            $other = checkOther($v['key'], $ele_id, $ele_caption);
                            if (false !== $other) {
                                $ch[] = $other;
                            } else {
                                $ch[] = $myts->stripSlashesGPC($v['key']);
                            }
                        }
                        $opt_count++;
                    } else {
                        if (!empty($ele[$ele_id])) {
                            $ch[] = $myts->stripSlashesGPC($v['key']);
                        }
                    }
                }
                $msg[$ele_id] .= !empty($ch) ? implode("\n", $ch) : '';
                break;
            case 'select':
                $opt_count = 1;
                $ch        = [];
                if (is_array($ele[$ele_id])) {
                    //                    while ($v = each($ele_value[2])) {
                    foreach ($ele_value[2] as $v) {
                        if (in_array($opt_count, $ele[$ele_id])) {
                            $ch[] = $myts->stripSlashesGPC($v['key']);
                        }
                        $opt_count++;
                    }
                } else {
                    //                    while ($j = each($ele_value[2])) {
                    foreach ($ele_value[2] as $j) {
                        if ($opt_count == $ele[$ele_id]) {
                            $ch[] = $myts->stripSlashesGPC($j['key']);
                        }
                        $opt_count++;
                    }
                }
                $msg[$ele_id] .= !empty($ch) ? implode("\n", $ch) : '';
                break;
            case 'break': // --- INFORMATUX ---
                $msg[$ele_id] .= $myts->stripSlashesGPC($ele[0]);
                break; // -------------------------
            default:
                break;
        }
    } elseif (1 == $ele_req) {
        $err[] = sprintf(_LIAISE_ERR_REQ, $ele_caption);
    }
}

if (is_dir(LIAISE_ROOT_PATH . 'language/' . $xoopsConfig['language'] . '/mail_template')) {
    $template_dir = LIAISE_ROOT_PATH . 'language/' . $xoopsConfig['language'] . '/mail_template';
} else {
    $template_dir = LIAISE_ROOT_PATH . 'language/english/mail_template';
}
$xoopsMailer = xoops_getMailer();
$xoopsMailer->setTemplateDir($template_dir);
$xoopsMailer->setTemplate('xliaise.tpl');
$xoopsMailer->setSubject(sprintf(_LIAISE_MSG_SUBJECT, $myts->stripSlashesGPC($form->getVar('form_title'))));
if (in_array('user', $helper->getConfig('moreinfo'))) {
    if (is_object($xoopsUser)) {
        $xoopsMailer->assign('UNAME', sprintf(_LIAISE_MSG_UNAME, $xoopsUser->getVar('uname')));
        $xoopsMailer->assign('ULINK', sprintf(_LIAISE_MSG_UINFO, XOOPS_URL . '/userinfo.php?uid=' . $xoopsUser->getVar('uid')));
    } else {
        $xoopsMailer->assign('UNAME', sprintf(_LIAISE_MSG_UNAME, $xoopsConfig['anonymous']));
        $xoopsMailer->assign('ULINK', '');
    }
} else {
    $xoopsMailer->assign('UNAME', '');
    $xoopsMailer->assign('ULINK', '');
}

if (in_array('ip', $helper->getConfig('moreinfo'))) {
    $proxy = $_SERVER['REMOTE_ADDR'];
    $ip    = '';
    if (\Xmf\Request::hasVar('HTTP_X_FORWARDED_FOR', 'SERVER')) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } elseif (\Xmf\Request::hasVar('HTTP_PROXY_CONNECTION', 'SERVER')) {
        $ip = $_SERVER['HTTP_PROXY_CONNECTION'];
    } elseif (\Xmf\Request::hasVar('HTTP_VIA', 'SERVER')) {
        $ip = $_SERVER['HTTP_VIA'];
    }
    $ip = empty($ip) ? $_SERVER['REMOTE_ADDR'] : $ip;
    if ($proxy != $ip) {
        $ip = $ip . sprintf(_LIAISE_PROXY, $proxy);
    }
    $xoopsMailer->assign('IP', sprintf(_LIAISE_MSG_IP, $ip));
} else {
    $xoopsMailer->assign('IP', '');
}
if (in_array('agent', $helper->getConfig('moreinfo'))) {
    $xoopsMailer->assign('AGENT', sprintf(_LIAISE_MSG_AGENT, $_SERVER['HTTP_USER_AGENT']));
} else {
    $xoopsMailer->assign('AGENT', '');
}
if (in_array('form', $helper->getConfig('moreinfo'))) {
    $xoopsMailer->assign('FORMURL', sprintf(_LIAISE_MSG_FORMURL, LIAISE_URL . 'index.php?form_id=' . $form_id));
} else {
    $xoopsMailer->assign('FORMURL', '');
}

$group = $memberHandler->getGroup($form->getVar('form_send_to_group'));
if ('p' === $form->getVar('form_send_method') && is_object($xoopsUser) && false !== $group) {
    $xoopsMailer->usePM();
    $xoopsMailer->setToGroups($group);
} else {
    $xoopsMailer->useMail();
    $xoopsMailer->setFromName($xoopsConfig['sitename']);
    $xoopsMailer->setFromEmail($xoopsConfig['adminmail']);
    if (isset($reply_mail)) {
        $xoopsMailer->multimailer->addReplyTo($reply_mail, isset($reply_name) ? '"' . $reply_name . '"' : null);
    }
    $charset              = !empty($helper->getConfig('mail_charset')) ? $helper->getConfig('mail_charset') : _CHARSET;
    $xoopsMailer->charSet = $charset;
    if (false !== $group) {
        $xoopsMailer->setToGroups($group);
    } else {
        $xoopsMailer->setToEmails($xoopsConfig['adminmail']);
    }
}

$uploaded = [];
if (count($attachments) > 0) {
    foreach ($attachments as $a) {
        if (false === $xoopsMailer->isMail || $a['saveto']) {
            $uploader[$a['id']]->prefix = $form->getVar('form_id') . '_';
            if (false === $uploader[$a['id']]->upload()) {
                $err[] = $uploader[$a['id']]->getErrors();
            } else {
                $saved         = $uploader[$a['id']]->savedFileName;
                $uploaded[]    = LIAISE_UPLOAD_PATH . $saved;
                $msg[$a['id']] .= sprintf(_LIAISE_UPLOADED_FILE, LIAISE_URL . 'admin/file.php?f=' . $saved);
            }
        } else {
            if (false === $xoopsMailer->multimailer->addAttachment($a['path'], $a['name'])) {
                $err[] = $xoopsMailer->multimailer->ErrorInfo;
            } else {
                $msg[$a['id']] .= sprintf(_LIAISE_ATTACHED_FILE, $_FILES['ele_' . $a['id']]['name']);
            }
        }
    }
}

$xoopsMailer->assign('MSG', implode("\n", $msg));

if (count($err) < 1) {
    if (!$xoopsMailer->send(true)) {
        $err[] = $xoopsMailer->getErrors();
    }
}

// --------- Archivage --------
global $xoopsDB;
// Variable (initialisation)
$form_id      = \Xmf\Request::getInt('form_id', 0, 'POST');
$form_message = trim($xoopsDB->escape(implode("\n", $msg)));
$sql_archive  = 'INSERT INTO ' . $xoopsDB->prefix('xliaise_forms_archive') . " VALUES ('', '$form_id', UNIX_TIMESTAMP(), '$form_message')";
$result       = $xoopsDB->query($sql_archive);
// ----------------------------

if (count($err) > 0) {
    if (count($uploaded) > 0) {
        foreach ($uploaded as $u) {
            @unlink($u);
        }
    }
    // -------------------------------------------------------
    $GLOBALS['xoopsOption']['template_main'] = 'xliaise_error.tpl';
    // -------------------------------------------------------
    require_once XOOPS_ROOT_PATH . '/header.php';
    $xoopsTpl->assign('error_heading', _LIAISE_ERR_HEADING);
    $xoopsTpl->assign('errors', $err);
    $xoopsTpl->assign('go_back', _BACK);
    $xoopsTpl->assign('liaise_url', LIAISE_URL . '/index.php?form_id=' . $form_id);
    $xoopsTpl->assign('xoops_pagetitle', _LIAISE_ERR_HEADING);
    require_once XOOPS_ROOT_PATH . '/footer.php';
    exit();
}

$whereto = $form->getVar('form_whereto');
$whereto = !empty($whereto) ? str_replace('{SITE_URL}', XOOPS_URL, $whereto) : XOOPS_URL . '/index.php';
redirect_header($whereto, 0, _LIAISE_MSG_SENT);

function checkOther($key, $id, $caption)
{
    global $err, $myts;
    if (!preg_match('/\{OTHER\|+[0-9]+\}/', $key)) {
        return false;
    }
    if (!empty($_POST['other']['ele_' . $id])) {
        return _LIAISE_OPT_OTHER . $myts->stripSlashesGPC($_POST['other']['ele_' . $id]);
    }
    $err[] = sprintf(_LIAISE_ERR_REQ, $caption);

    return false;
}
