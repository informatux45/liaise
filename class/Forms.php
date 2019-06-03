<?php

namespace XoopsModules\Liaise;

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

class Forms extends \XoopsObject
{
    public function __construct()
    {
        parent::__construct();
        //    key, data_type, value, req, max, opt
        $this->initVar('form_id', XOBJ_DTYPE_INT);
        $this->initVar('form_send_method', XOBJ_DTYPE_TXTBOX, 'e', true, 1);
        $this->initVar('form_send_to_group', XOBJ_DTYPE_TXTBOX, 1, false, 3);
        $this->initVar('form_order', XOBJ_DTYPE_INT, 1, false, 3);
        $this->initVar('form_delimiter', XOBJ_DTYPE_TXTBOX, 's', true, 1);
        $this->initVar('form_title', XOBJ_DTYPE_TXTBOX, '', true, 255);
        $this->initVar('form_submit_text', XOBJ_DTYPE_TXTBOX, _SUBMIT, true, 50);
        $this->initVar('form_desc', XOBJ_DTYPE_TXTAREA);
        $this->initVar('form_intro', XOBJ_DTYPE_TXTAREA);
        $this->initVar('form_whereto', XOBJ_DTYPE_TXTBOX);
    }
}
