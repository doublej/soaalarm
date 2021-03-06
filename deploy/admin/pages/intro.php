<?php

// $Id: intro.php 1073 2009-07-16 18:53:43Z Ruebenwurzel $

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

// Create new admin object
require('../../config.php');
require_once(WB_PATH.'/framework/class.admin.php');
$admin = new admin('Pages', 'pages_intro');

// Get page content
$filename = WB_PATH.PAGES_DIRECTORY.'/intro'.PAGE_EXTENSION;
if(file_exists($filename)) {
	$handle = fopen($filename, "r");
	$content = fread($handle, filesize($filename));
	fclose($handle);
} else {
	$content = '';
}

if(!isset($_GET['wysiwyg']) OR $_GET['wysiwyg'] != 'no') {
	if (!defined('WYSIWYG_EDITOR') OR WYSIWYG_EDITOR=="none" OR !file_exists(WB_PATH.'/modules/'.WYSIWYG_EDITOR.'/include.php')) {
		function show_wysiwyg_editor($name,$id,$content,$width,$height) {
			echo '<textarea name="'.$name.'" id="'.$id.'" style="width: '.$width.'; height: '.$height.';">'.$content.'</textarea>';
		}
	} else {
		$id_list=array('content');
		require(WB_PATH.'/modules/'.WYSIWYG_EDITOR.'/include.php');
	}
}
?>


<form action="intro2.php" method="post">

<input type="hidden" name="page_id" value="{PAGE_ID}" />

<?php
show_wysiwyg_editor('content','content',$content,'100%','500px');
?>

<table cellpadding="0" cellspacing="0" border="0" class="form_submit">
<tr>
	<td class="left">
		<input type="submit" value="<?php echo $TEXT['SAVE'];?>" class="submit" />
	</td>
	<td class="right">
		<input type="button" value="<?php echo $TEXT['CANCEL'];?>" onclick="javascript: window.location = 'index.php';" class="submit" />
	</td>
</tr>
</table>

</form>
<?php
// Print admin footer
$admin->print_footer();

?>