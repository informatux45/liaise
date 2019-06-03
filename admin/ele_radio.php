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
if (!defined('LIAISE_ROOT_PATH')) {
    exit();
}

$options   = [];
$opt_count = 0;
if (empty($addopt) && !empty($ele_id)) {
    $keys = array_keys($value);
    for ($i = 0, $iMax = count($keys); $i < $iMax; ++$i) {
        $r         = $value[$keys[$i]] ? $opt_count : null;
        $v         = $myts->htmlSpecialChars($myts->stripSlashesGPC($keys[$i]));
        $options[] = addOption('ele_value[' . $opt_count . ']', $opt_count, $v, 'radio', $r);
        $opt_count++;
    }
} else {
    if (isset($ele_value) && count($ele_value) > 0) {
        //        while ($v = each($ele_value)) {
        foreach ($ele_value as $v) {
            $v['value'] = $myts->htmlSpecialChars($myts->stripSlashesGPC($v['value']));
            if (!empty($v['value'])) {
                $r         = ($checked == $opt_count) ? $opt_count : null;
                $options[] = addOption('ele_value[' . $opt_count . ']', $opt_count, $v['value'], 'radio', $r);
                $opt_count++;
            }
        }
    }
    $addopt = empty($addopt) ? 2 : $addopt;
    for ($i = 0; $i < $addopt; $i++) {
        $options[] = addOption('ele_value[' . $opt_count . ']', $opt_count, '', 'radio');
        $opt_count++;
    }
}
$options[] = addOptionsTray();
$opt_tray  = new \XoopsFormElementTray(_AM_ELE_OPT, '<br>');
$opt_tray->setDescription(_AM_ELE_OPT_DESC2 . '<br><br>' . _AM_ELE_OTHER);
for ($i = 0, $iMax = count($options); $i < $iMax; ++$i) {
    $opt_tray->addElement($options[$i]);
}
$output->addElement($opt_tray);
