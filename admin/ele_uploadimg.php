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

$size   = !empty($value[0]) ? (int)$value[0] : 0;
$ext    = empty($ele_id) ? 'jpg|jpeg|gif|png|tif|tiff' : $value[1];
$mime   = empty($ele_id) ? 'image/jpeg|image/pjpeg|image/png|image/x-png|image/gif|image/tiff' : $value[2];
$saveas = 1 != $value[3] ? 0 : 1;
$width  = !empty($value[4]) ? (int)$value[4] : 0;
$height = !empty($value[5]) ? (int)$value[5] : 0;

$size = new \XoopsFormText(_AM_ELE_UPLOAD_MAXSIZE, 'ele_value[0]', 10, 20, $size);
$size->setDescription(_AM_ELE_UPLOAD_MAXSIZE_DESC . '<br>' . _AM_ELE_UPLOAD_DESC_SIZE_NOLIMIT);

$ext = new \XoopsFormText(_AM_ELE_UPLOAD_ALLOWED_EXT, 'ele_value[1]', 50, 255, $myts->htmlSpecialChars($myts->stripSlashesGPC($ext)));
$ext->setDescription(_AM_ELE_UPLOAD_ALLOWED_EXT_DESC . '<br><br>' . _AM_ELE_UPLOAD_DESC_NOLIMIT);

$mime = new \XoopsFormTextArea(_AM_ELE_UPLOAD_ALLOWED_MIME, 'ele_value[2]', $myts->htmlSpecialChars($myts->stripSlashesGPC($mime)), 5, 50);
$mime->setDescription(_AM_ELE_UPLOAD_ALLOWED_MIME_DESC . '<br><br>' . _AM_ELE_UPLOAD_DESC_NOLIMIT);

$saveas = new \XoopsFormSelect(_AM_ELE_UPLOAD_SAVEAS, 'ele_value[3]', $saveas);
$saveas->addOptionArray([0 => _AM_ELE_UPLOAD_SAVEAS_MAIL, 1 => _AM_ELE_UPLOAD_SAVEAS_FILE]);

$width = new \XoopsFormText(_AM_ELE_UPLOADIMG_MAXWIDTH, 'ele_value[4]', 10, 20, $width);
$width->setDescription(_AM_ELE_UPLOAD_DESC_SIZE_NOLIMIT);

$height = new \XoopsFormText(_AM_ELE_UPLOADIMG_MAXHEIGHT, 'ele_value[5]', 10, 20, $height);
$height->setDescription(_AM_ELE_UPLOAD_DESC_SIZE_NOLIMIT);

$output->addElement($size, 1);
$output->addElement($ext);
$output->addElement($mime);
$output->addElement($saveas, 1);
$output->addElement($width, 1);
$output->addElement($height, 1);
