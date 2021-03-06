<?php

// $Id: modify.php 1070 2009-07-15 20:31:43Z Ruebenwurzel $

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

// Setup template object
$template = new Template(WB_PATH.'/modules/wrapper');
$template->set_file('page', 'modify.htt');
$template->set_block('page', 'main_block', 'main');

// Get page content
$query = "SELECT url,height FROM ".TABLE_PREFIX."mod_wrapper WHERE section_id = '$section_id'";
$get_settings = $database->query($query);
$settings = $get_settings->fetchRow();
$url = ($settings['url']);
$height = $settings['height'];

// Insert vars
$template->set_var(array(
								'PAGE_ID' => $page_id,
								'SECTION_ID' => $section_id,
								'WB_URL' => WB_URL,
								'URL' => $url,
								'HEIGHT' => $height,
								'TEXT_URL' => $TEXT['URL'],
								'TEXT_HEIGHT' => $TEXT['HEIGHT'],
								'TEXT_SAVE' => $TEXT['SAVE'],
								'TEXT_CANCEL' => $TEXT['CANCEL']
								)
						);

// Parse template object
$template->parse('main', 'main_block', false);
$template->pparse('output', 'page');

?>