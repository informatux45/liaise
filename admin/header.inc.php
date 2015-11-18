<?php
/* ******************************************* */
/*                INFORMATUX                   */
/*         http://www.informatux.com/          */
/*       SOLUTIONS AND WEB DEVELOPMENT         */
/*             Patrice BOUTHIER                */
/*                   2015                      */
/* ------------------------------------------- */
/*    XOOPS - PHP Content Management System    */
/*         Copyright (c) 2000 XOOPS.org        */
/*            <http://www.xoops.org/>          */
/* ******************************************* */

function getFormsCount($form_order = false, $created = true) {
    // query database for forms created
    global $xoopsDB;
    if ($created AND $form_order == false) {
        // Created Forms
        $sql = 'SELECT * FROM ' . $xoopsDB->prefix('xliaise_forms');
        $result = $xoopsDB->query($sql);
        if (!$result)
          return false;
        $num_forms = $xoopsDB->getRowsNum($result);
        if ($num_forms == 0)
           return false;
    } else {
        // Activated Forms
        $sql = 'SELECT * FROM ' . $xoopsDB->prefix('xliaise_forms') . ' WHERE form_order >= "1"';
        $result = $xoopsDB->query($sql);
        if (!$result)
          return false;
        $num_forms = $xoopsDB->getRowsNum($result);
        if ($num_forms == 0)
           return false;
    }
    
    return $num_forms;    
}

function getFormTitle($form_id) {
    // query database for form title
    global $xoopsDB;
    if (isset($form_id)) {
        $sql = 'SELECT form_title FROM '.$xoopsDB->prefix("xliaise_forms").' WHERE form_id = "'.$form_id.'"';
        $result = $xoopsDB->query($sql);
        if (!$result)
            return false;
        else
            return $xoopsDB->fetchArray($result);
    } else {
        return false;
    }
}
?>