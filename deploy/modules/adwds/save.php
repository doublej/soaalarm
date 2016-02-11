<?php
/**
 *
 * @category        modules
 * @package         code
 * @author          WebsiteBaker Project
 * @copyright       2004-2009, Ryan Djurovich
 * @copyright       2009-2010, Website Baker Org. e.V.
 * @link			http://www.websitebaker2.org/
 * @license         http://www.gnu.org/licenses/gpl.html
 * @platform        WebsiteBaker 2.8.x
 * @requirements    PHP 4.3.4 and higher
 * @version         $Id: save.php 1277 2010-01-28 05:18:18Z Luisehahne $
 * @filesource		$HeadURL: http://svn.websitebaker2.org/branches/2.8.x/wb/modules/code/save.php $
 * @lastmodified    $Date: 2010-01-28 06:18:18 +0100 (Do, 28. Jan 2010) $
 *
 */

require('../../config.php');

// Include WB admin wrapper script
$update_when_modified = true; // Tells script to update when this page was last updated
require(WB_PATH.'/modules/admin.php');

print_r($_POST);

if(isset($_POST['template']) && $_POST['template'] == 'get'){
	
	$templ_id = $_POST['templ_id'];
	
	$query2 = "SELECT code FROM ".TABLE_PREFIX."mod_adwds_templates WHERE id = '$templ_id'";
	$get_content2 = $database->query($query2);
	$templ_code = $get_content2->fetchRow();
	
	
	$tags = array('<?php', '?>' , '<?');
	$content = $admin->add_slashes(str_replace($tags, '', $templ_code['code']));
	$query = "UPDATE ".TABLE_PREFIX."mod_adwds SET code = '$content' WHERE section_id = '$section_id'";
	$database->query($query);	

}else if(isset($_POST['template']) && $_POST['template'] == 'make'){
	
	
	if(isset($_POST['code']) && isset($_POST['template_name'])) {
		$templname = $_POST['template_name'];
		$tags = array('<?php', '?>' , '<?');
		$content = $admin->add_slashes(str_replace($tags, '', $_POST['code']));
		$query = "UPDATE ".TABLE_PREFIX."mod_adwds SET code = '$content' WHERE section_id = '$section_id'";
		$query2 = "INSERT INTO ".TABLE_PREFIX."mod_adwds_templates (name, code) VALUES ('$templname', '$content') ";
		$database->query($query2);	
		$database->query($query);
	}
	

}else{
	// Update the mod_wysiwygs table with the contents
	if(isset($_POST['code'])) {
		$tags = array('<?php', '?>' , '<?');
		$content = $admin->add_slashes(str_replace($tags, '', $_POST['code']));
		$query = "UPDATE ".TABLE_PREFIX."mod_adwds SET code = '$content' WHERE section_id = '$section_id'";
		$database->query($query);	
	}
}
// Check if there is a database error, otherwise say successful
if($database->is_error()) {
	$admin->print_error($database->get_error(), $js_back);
} else {
	$admin->print_success($MESSAGE['PAGES']['SAVED'], ADMIN_URL.'/pages/modify.php?page_id='.$page_id);
}

// Print admin footer
$admin->print_footer();

?>