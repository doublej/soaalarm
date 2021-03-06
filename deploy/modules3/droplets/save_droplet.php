<?php

// $Id: save_droplet.php 1072 2009-07-16 18:50:11Z Ruebenwurzel $

/*
*	@version	1.0
*	@author		Ruud Eisinga (Ruud) John (PCWacht)
*	@date		June 2009
*
*	droplets are small codeblocks that are called from anywhere in the template. 
* 	To call a droplet just use [[dropletname]]. optional parameters for a droplet can be used like [[dropletname?parameter=value&parameter2=value]]
*/

require('../../config.php');

// Get id
if(!isset($_POST['droplet_id']) OR !is_numeric($_POST['droplet_id'])) {
	header("Location: ".ADMIN_URL."/pages/index.php");
} else {
	$droplet_id = $_POST['droplet_id'];
}
// Include WB admin wrapper script
require_once(WB_PATH.'/framework/class.admin.php');
require_once(WB_PATH.'/framework/functions.php');

// check website baker platform (with WB 2.7, Admin-Tools were moved out of settings dialogue)
if(file_exists(ADMIN_PATH .'/admintools/tool.php')) {
	$admintool_link = ADMIN_URL .'/admintools/index.php';
	$module_edit_link = ADMIN_URL .'/admintools/tool.php?tool=droplets';
	$admin = new admin('admintools', 'admintools');
} else {
	$admintool_link = ADMIN_URL .'/settings/index.php?advanced=yes#administration_tools"';
	$module_edit_link = ADMIN_URL .'/settings/tool.php?tool=droplets';
	$admin = new admin('Settings', 'settings_advanced');
}

// Validate all fields
if($admin->get_post('title') == '') {
	$admin->print_error($MESSAGE['GENERIC']['FILL_IN_ALL'], WB_URL.'/modules/droplets/modify_droplet.php?droplet_id='.$droplet_id);
} else {
	$title = $admin->add_slashes($admin->get_post('title'));
	$active = $admin->get_post('active');
	$admin_view = $admin->get_post('admin_view');
	$admin_edit = $admin->get_post('admin_edit');
	$show_wysiwyg = $admin->get_post('show_wysiwyg');
	$description = $admin->add_slashes($admin->get_post('description'));
	$tags = array('<?php', '?>' , '<?');
	$content = $admin->add_slashes(str_replace($tags, '', $_POST['savecontent']));
	
	$comments = $admin->add_slashes($admin->get_post('comments'));
	$modified_when = time();
	$modified_by = $admin->get_user_id(); 
}

// Update row
$database->query("UPDATE ".TABLE_PREFIX."mod_droplets SET name = '$title', active = '$active', admin_view = '$admin_view', admin_edit = '$admin_edit', show_wysiwyg = '$show_wysiwyg', description = '$description', code = '$content', comments = '$comments', modified_when = '$modified_when', modified_by = '$modified_by' WHERE id = '$droplet_id'");

// Check if there is a db error, otherwise say successful
if($database->is_error()) {
	$admin->print_error($database->get_error(), WB_URL.'/modules/droplets/modify_droplet.php?droplet_id='.$droplet_id);
} else {
    $admin->print_success($TEXT['SUCCESS'], $module_edit_link);
}

// Print admin footer
$admin->print_footer();

?>