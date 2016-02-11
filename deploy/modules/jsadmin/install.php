<?php

// $Id: install.php 915 2009-01-21 19:27:01Z Ruebenwurzel $

// JsAdmin module for Website Baker
// Copyright (C) 2006, Stepan Riha
// www.nonplus.net

// modified by Swen Uth for Website Baker 2.7

/*

 Website Baker Project <http://www.websitebaker.org/>
 Copyright (C) 2004-2009, Ryan Djurovich

 Website Baker is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 2 of the License, or
 (at your option) any later version.

 Website Baker is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with Website Baker; if not, write to the Free Software
 Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA

*/

// prevent this file from being accessed directly
if(!defined('WB_PATH')) { exit('Cannot access this file directly'); }

// add new rows to table "settings"

$table = TABLE_PREFIX ."mod_jsadmin";
$database->query("DROP TABLE IF EXISTS `$table`");

$database->query("
	CREATE TABLE `$table` (
    `id` INT(11) NOT NULL DEFAULT '0',
		`name` VARCHAR(255) NOT NULL DEFAULT '0',
		`value` INT(11) NOT NULL DEFAULT '0',
   	PRIMARY KEY (`id`)
	)
");

global $database;
$database->query("INSERT INTO ".$table." (id,name,value) VALUES ('1','mod_jsadmin_persist_order','0')");
$database->query("INSERT INTO ".$table." (id,name,value) VALUES ('2','mod_jsadmin_ajax_order_pages','0')");
$database->query("INSERT INTO ".$table." (id,name,value) VALUES ('3','mod_jsadmin_ajax_order_sections','0')");

?>