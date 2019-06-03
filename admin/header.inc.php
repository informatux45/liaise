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

function getFormsCount($form_order = false, $created = true)
{
    // query database for forms created
    global $xoopsDB;
    if ($created && false === $form_order) {
        // Created Forms
        $sql    = 'SELECT * FROM ' . $xoopsDB->prefix('xliaise_forms');
        $result = $xoopsDB->query($sql);
        if (!$result) {
            return false;
        }
        $num_forms = $xoopsDB->getRowsNum($result);
        if (0 == $num_forms) {
            return false;
        }
    } else {
        // Activated Forms
        $sql    = 'SELECT * FROM ' . $xoopsDB->prefix('xliaise_forms') . ' WHERE form_order >= "1"';
        $result = $xoopsDB->query($sql);
        if (!$result) {
            return false;
        }
        $num_forms = $xoopsDB->getRowsNum($result);
        if (0 == $num_forms) {
            return false;
        }
    }

    return $num_forms;
}

function getFormTitle($form_id)
{
    // query database for form title
    global $xoopsDB;
    if (isset($form_id)) {
        $sql    = 'SELECT form_title FROM ' . $xoopsDB->prefix('xliaise_forms') . ' WHERE form_id = "' . $form_id . '"';
        $result = $xoopsDB->query($sql);
        if (!$result) {
            return false;
        }

        return $xoopsDB->fetchArray($result);
    }

    return false;
}
