<?php
// $Id: ele_text.php 41 2005-09-18 16:28:09Z tuff $
###############################################################################
##                Liaise -- Contact forms generator for XOOPS                ##
##                 Copyright (c) 2003-2005 NS Tai (aka tuff)                 ##
##                       <http://www.brandycoke.com/>                        ##
###############################################################################
##                    XOOPS - PHP Content Management System                  ##
##                       Copyright (c) 2000 XOOPS.org                        ##
##                          <http://www.xoops.org/>                          ##
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
if( !defined('LIAISE_ROOT_PATH') ){ exit(); }

$options = array();
$opt_count = 0;
//if( empty($addopt) && !empty($ele_id) ){
//	$keys = array_keys($value);
//	for( $i=0; $i<count($keys); $i++ ){
//		$r = $value[$keys[$i]] ? $opt_count : null;
//		$v = $myts->makeTboxData4PreviewInForm($keys[$i]);
//		$options[] = addOption('ele_value['.$opt_count.']', $opt_count, $v, 'radio', $r);
//		$opt_count++;
//	}
//}else{
//	if( isset($ele_value) && count($ele_value) > 0 ){
//		while( $v = each($ele_value) ){
//			$v['value'] = $myts->makeTboxData4PreviewInForm($v['value']);
//			if( !empty($v['value']) ){
//				$r = ($checked == $opt_count) ? $opt_count : null;
//				$options[] = addOption('ele_value['.$opt_count.']', $opt_count, $v['value'], 'radio', $r);
//				$opt_count++;
//			}
//		}
//	}
//	$addopt = empty($addopt) ? 2 : $addopt;
//	for( $i=0; $i<$addopt; $i++ ){
//		$options[] = addOption('ele_value['.$opt_count.']', $opt_count, '', 'radio');
//		$opt_count++;
//	}
//}
$options[] = addOptionsTray();
$opt_tray = new XoopsFormElementTray(_AM_ELE_OPT, '<br />');
$opt_tray->setDescription(_AM_ELE_OPT_DESC2.'<br />UUUUUUUUUUUUUUU<br />'._AM_ELE_OTHER);
for( $i=0; $i<count($options); $i++ ){
	$opt_tray->addElement($options[$i]);
}
$output->addElement($opt_tray);

?>