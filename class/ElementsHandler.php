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

class ElementsHandler
{
    private $db;
    private $db_table;
    private $obj_class = Elements::class;

    // porting from XOOPS/class/uploader.php
    public $errors = [];

    public function __construct($db)
    {
        $this->db       = $db;
        $this->db_table = $this->db->prefix('xliaise_formelements');
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

    public function &get($id)
    {
        $id = (int)$id;
        if ($id > 0) {
            $sql = 'SELECT * FROM ' . $this->db_table . ' WHERE ele_id=' . $id;
            if (!$result = $this->db->query($sql)) {
                return false;
            }
            $numrows = $this->db->getRowsNum($result);
            if (1 == $numrows) {
                $element = new $this->obj_class();
                $element->assignVars($this->db->fetchArray($result));

                return $element;
            }
        }

        return false;
    }

    public function insert($element, $force = false)
    {
        if (mb_strtolower(get_class($element)) != mb_strtolower($this->obj_class)) {
            return false;
        }
        if (!$element->isDirty()) {
            return true;
        }
        if (!$element->cleanVars()) {
            return false;
        }
        foreach ($element->cleanVars as $k => $v) {
            ${$k} = $v;
        }
        if (empty($ele_id) || $element->isNew()) {
            $ele_id = $this->db->genId($this->db_table . '_ele_id_seq');
            $sql    = sprintf('INSERT INTO `%s` (
                ele_id, form_id, ele_type, ele_caption, ele_order, ele_req, ele_value, ele_display
                ) VALUES (
                %u, %u, %s, %s, %u, %u, %s, %u
                )', $this->db_table, $ele_id, $form_id, $this->db->quoteString($ele_type), $this->db->quoteString($ele_caption), $ele_order, $ele_req, $this->db->quoteString($ele_value), $ele_display);
        } else {
            $sql = sprintf('UPDATE `%s` SET
                form_id = %u,
                ele_type = %s,
                ele_caption = %s,
                ele_order = %u,
                ele_req = %u,
                ele_value = %s,
                ele_display = %u
                WHERE ele_id = %u', $this->db_table, $form_id, $this->db->quoteString($ele_type), $this->db->quoteString($ele_caption), $ele_order, $ele_req, $this->db->quoteString($ele_value), $ele_display, $ele_id);
        }
        if (false !== $force) {
            $result = $this->db->queryF($sql);
        } else {
            $result = $this->db->query($sql);
        }
        if (!$result) {
            $element->setErrors('Could not store data in the database.<br>' . $this->db->error() . ' (' . $this->db->errno() . ')<br>' . $sql);

            return false;
        }
        if (empty($ele_id)) {
            $ele_id = $this->db->getInsertId();
        }
        $element->assignVar('ele_id', $ele_id);

        return $ele_id;
    }

    public function delete($element, $force = false)
    {
        if (mb_strtolower(get_class($element)) != mb_strtolower($this->obj_class)) {
            return false;
        }
        $sql = 'DELETE FROM ' . $this->db_table . ' WHERE ele_id=' . $element->getVar('ele_id') . '';
        if (false !== $force) {
            $result = $this->db->queryF($sql);
        } else {
            $result = $this->db->query($sql);
        }

        return true;
    }

    public function &getObjects($criteria = null, $id_as_key = false)
    {
        $ret   = [];
        $limit = $start = 0;
        $sql   = 'SELECT * FROM ' . $this->db_table;
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
            //            return false;
            $false = false;

            return $false;
        }
        while (false !== ($myrow = $this->db->fetchArray($result))) {
            $elements = new $this->obj_class();
            $elements->assignVars($myrow);
            if (!$id_as_key) {
                $ret[] = &$elements;
            } else {
                $ret[$myrow['ele_id']] = &$elements;
            }
            unset($elements);
        }

        // Notice [PHP]: Only variable references should be returned by reference
        //        return count($ret) > 0 ? $ret : false;
        if (0 == count($ret)) {
            $false = false;

            return $false;
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

    public function insertDefaults($form_id)
    {
        global $xoopsModuleConfig;
        include LIAISE_ROOT_PATH . 'admin/default_elements.php';
        if (count($defaults) > 0) {
            $error = '';
            foreach ($defaults as $d) {
                $ele = $this->create();
                $ele->setVar('form_id', $form_id);
                $ele->setVar('ele_caption', $d['caption']);
                $ele->setVar('ele_req', $d['req']);
                $ele->setVar('ele_order', $d['order']);
                $ele->setVar('ele_display', $d['display']);
                $ele->setVar('ele_type', $d['type']);
                $ele->setVar('ele_value', $d['value']);
                if (!$this->insert($ele)) {
                    $error .= $ele->getHtmlErrors();
                }
            }
            if (!empty($error)) {
                return $error;
            }
        }

        return false;
    }
}
