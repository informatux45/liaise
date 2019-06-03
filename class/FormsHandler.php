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

class FormsHandler extends \XoopsObjectHandler
{
    public $db;
    public $db_table;
    public $perm_name = 'liaise_form_access';
    public $obj_class = Forms::class;

    public function __construct($db)
    {
        $this->db       = $db;
        $this->db_table = $this->db->prefix('xliaise_forms');
    }

    public function getInstance($db)
    {
        static $instance;
        if (null === $instance) {
            $instance = new static($db);
        }

        return $instance;
    }

    public function &create()
    {
        $ret = new $this->obj_class();

        return $ret;
    }

    public function &get($id, $fields = '*')
    {
        $id = (int)$id;
        if ($id > 0) {
            $sql = 'SELECT ' . $fields . ' FROM ' . $this->db_table . ' WHERE form_id=' . $id;
            if (!$result = $this->db->query($sql)) {
                return false;
            }
            $numrows = $this->db->getRowsNum($result);
            if (1 == $numrows) {
                $form = new $this->obj_class();
                $form->assignVars($this->db->fetchArray($result));

                return $form;
            }

            return false;
        }

        return false;
    }

    public function insert(\XoopsObject $form, $force = false)
    {
        if (mb_strtolower(get_class($form)) != mb_strtolower($this->obj_class)) {
            return false;
        }
        if (!$form->isDirty()) {
            return true;
        }
        if (!$form->cleanVars()) {
            return false;
        }
        foreach ($form->cleanVars as $k => $v) {
            ${$k} = $v;
        }
        if ($form->isNew() || empty($form_id)) {
            $form_id = $this->db->genId($this->db_table . '_form_id_seq');
            $sql     = sprintf('INSERT INTO `%s` (
                form_id, form_send_method, form_send_to_group, form_order, form_delimiter, form_title, form_submit_text, form_desc, form_intro, form_whereto
                ) VALUES (
                %u, %s, %s, %u, %s, %s, %s, %s, %s, %s
                )', $this->db_table, $form_id, $this->db->quoteString($form_send_method), $this->db->quoteString($form_send_to_group), $form_order, $this->db->quoteString($form_delimiter), $this->db->quoteString($form_title), $this->db->quoteString($form_submit_text),
                               $this->db->quoteString($form_desc), $this->db->quoteString($form_intro), $this->db->quoteString($form_whereto));
        } else {
            $sql = sprintf('UPDATE `%s` SET
                form_send_method = %s,
                form_send_to_group = %s,
                form_order = %u,
                form_delimiter = %s,
                form_title = %s,
                form_submit_text = %s,
                form_desc = %s,
                form_intro = %s,
                form_whereto = %s
                WHERE form_id = %u', $this->db_table, $this->db->quoteString($form_send_method), $this->db->quoteString($form_send_to_group), $form_order, $this->db->quoteString($form_delimiter), $this->db->quoteString($form_title), $this->db->quoteString($form_submit_text),
                           $this->db->quoteString($form_desc), $this->db->quoteString($form_intro), $this->db->quoteString($form_whereto), $form_id);
        }
        if (false !== $force) {
            $result = $this->db->queryF($sql);
        } else {
            $result = $this->db->query($sql);
        }
        if (!$result) {
            $form->setErrors('Could not store data in the database.<br>' . $this->db->error() . ' (' . $this->db->errno() . ')<br>' . $sql);

            return false;
        }
        if (empty($form_id)) {
            $form_id = $this->db->getInsertId();
        }
        $form->assignVar('form_id', $form_id);

        return $form_id;
    }

    public function delete(\XoopsObject $form, $force = false)
    {
        if (mb_strtolower(get_class($form)) != mb_strtolower($this->obj_class)) {
            return false;
        }
        $sql = 'DELETE FROM ' . $this->db_table . ' WHERE form_id=' . $form->getVar('form_id') . '';
        if (false !== $force) {
            $result = $this->db->queryF($sql);
        } else {
            $result = $this->db->query($sql);
        }

        return true;
    }

    public function &getObjects($criteria = null, $fields = '*', $id_as_key = false)
    {
        $ret   = false;
        $limit = $start = 0;
        switch ($fields) {
            case 'home_list':
                $fields = 'form_id, form_title, form_desc';
                break;
            case 'admin_list':
                $fields = 'form_id, form_title, form_order, form_send_to_group';
                break;
        }
        $sql = 'SELECT ' . $fields . ' FROM ' . $this->db_table;
        if (isset($criteria) && is_subclass_of($criteria, 'CriteriaElement')) {
            $sql .= ' ' . $criteria->renderWhere();
            if ('' != $criteria->getSort()) {
                $sql .= ' ORDER BY ' . $criteria->getSort() . ' ' . $criteria->getOrder();
            }
            $limit = $criteria->getLimit();
            $start = $criteria->getStart();
        }
        $result = $this->db->query($sql, $limit, $start);
        if (!$result) {
            return false;
        }
        while (false !== ($myrow = $this->db->fetchArray($result))) {
            $forms = new $this->obj_class();
            $forms->assignVars($myrow);
            if (!$id_as_key) {
                $ret[] = &$forms;
            } else {
                $ret[$myrow['form_id']] = &$forms;
            }
            unset($forms);
        }

        return $ret;
    }

    public function getCount($criteria = null)
    {
        $sql = 'SELECT COUNT(*) FROM ' . $this->db_table;
        if (isset($criteria) && is_subclass_of($criteria, 'CriteriaElement')) {
            $sql .= ' ' . $criteria->renderWhere();
        }
        $result = $this->db->query($sql);
        if (!$result) {
            return 0;
        }
        list($count) = $this->db->fetchRow($result);

        return $count;
    }

    public function deleteAll($criteria = null)
    {
        $sql = 'DELETE FROM ' . $this->db_table;
        if (isset($criteria) && is_subclass_of($criteria, 'CriteriaElement')) {
            $sql .= ' ' . $criteria->renderWhere();
        }
        if (!$result = $this->db->query($sql)) {
            return false;
        }

        return true;
    }

    public function deleteFormPermissions($form_id)
    {
        $grouppermHandler = xoops_getHandler('groupperm');
        $grouppermHandler->deleteByModule($GLOBALS['xoopsModule']->getVar('mid'), $this->perm_name, $form_id);

        return true;
    }

    public function insertFormPermissions($form_id, $group_ids)
    {
        $grouppermHandler = xoops_getHandler('groupperm');
        foreach ($group_ids as $id) {
            $grouppermHandler->addRight($this->perm_name, $form_id, $id, $GLOBALS['xoopsModule']->getVar('mid'));
        }

        return true;
    }

    public function &getPermittedForms()
    {
        global $xoopsUser, $xoopsModule;
        /** @var \XoopsGroupPermHandler $grouppermHandler */
        $grouppermHandler = xoops_getHandler('groupperm');
        $groups           = is_object($xoopsUser) ? $xoopsUser->getGroups() : 3;
        $criteria         = new \CriteriaCompo();
        $criteria->add(new \Criteria('form_order', 1, '>='), 'OR');
        $criteria->setSort('form_order');
        $criteria->setOrder('ASC');
        if ($forms = $this->getObjects($criteria, 'home_list')) {
            $ret = [];
            foreach ($forms as $f) {
                if (false !== $grouppermHandler->checkRight($this->perm_name, $f->getVar('form_id'), $groups, $xoopsModule->getVar('mid'))) {
                    $ret[] = $f;
                    unset($f);
                }
            }

            return $ret;
        }

        return false;
    }

    public function getSingleFormPermission($form_id)
    {
        global $xoopsUser, $xoopsModule;
        $grouppermHandler = xoops_getHandler('groupperm');
        $groups           = is_object($xoopsUser) ? $xoopsUser->getGroups() : 3;
        if (false !== $grouppermHandler->checkRight($this->perm_name, $form_id, $groups, $xoopsModule->getVar('mid'))) {
            return true;
        }

        return false;
    }
}
