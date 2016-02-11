<?php

// $Id: search.php 915 2009-01-21 19:27:01Z Ruebenwurzel $

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

function form_search($func_vars) {
	extract($func_vars, EXTR_PREFIX_ALL, 'func');
	
	// how many lines of excerpt we want to have at most
	$max_excerpt_num = $func_default_max_excerpt;
	$divider = ".";
	$result = false;
	
	// fetch all form-fields on this page
	$table = TABLE_PREFIX."mod_form_fields";
	$query = $func_database->query("
		SELECT title, value
		FROM $table
		WHERE section_id='$func_section_id'
		ORDER BY position ASC
	");
	// now call print_excerpt() only once for all items
	if($query->numRows() > 0) {
		$text="";
		while($res = $query->fetchRow()) {
			$text .= $res['title'].$divider.$res['value'].$divider;
		}
		$mod_vars = array(
			'page_link' => $func_page_link,
			'page_link_target' => "#wb_section_$func_section_id",
			'page_title' => $func_page_title,
			'page_description' => $func_page_description,
			'page_modified_when' => $func_page_modified_when,
			'page_modified_by' => $func_page_modified_by,
			'text' => $text,
			'max_excerpt_num' => $max_excerpt_num
		);
		if(print_excerpt2($mod_vars, $func_vars)) {
			$result = true;
		}
	}
	return $result;
}

?>
