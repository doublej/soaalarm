<?php

// $Id: er_levels.php 1010 2009-06-25 16:57:43Z Ruebenwurzel $

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

/*

Error Reporting Level's list file

This file is used to generate a list of PHP
Error Reporting Level's for the user to select

*/

if(!defined('WB_URL')) {
	header('Location: ../index.php');
	exit(0);
}

// Define that this file is loaded
if(!defined('ERROR_REPORTING_LEVELS_LOADED')) {
	define('ERROR_REPORTING_LEVELS_LOADED', true);
}

// Create array
$ER_LEVELS = array();

// Add values to list
if(isset($TEXT['SYSTEM_DEFAULT'])) {
	$ER_LEVELS[''] = $TEXT['SYSTEM_DEFAULT'];
} else {
	$ER_LEVELS[''] = 'System Default';
}
$ER_LEVELS['6135'] = 'E_ALL^E_NOTICE'; // standard: E_ALL without E_NOTICE
$ER_LEVELS['0'] = 'E_NONE';
$ER_LEVELS['6143'] = 'E_ALL';
$ER_LEVELS['8191'] = htmlentities('E_ALL&E_STRICT'); // for programmers

?>