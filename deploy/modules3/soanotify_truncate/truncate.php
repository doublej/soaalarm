<?php
/**
 *
 * @category        modules
 * @package         news
 * @author          WebsiteBaker Project
 * @copyright       2004-2009, Ryan Djurovich
 * @copyright       2009-2010, Website Baker Org. e.V.
 * @link			http://www.websitebaker2.org/
 * @license         http://www.gnu.org/licenses/gpl.html
 * @platform        WebsiteBaker 2.8.x
 * @requirements    PHP 4.3.4 and higher
 * @version         $Id: save_settings.php 1280 2010-01-29 02:59:35Z Luisehahne $
 * @filesource		$HeadURL: http://svn.websitebaker2.org/branches/2.8.x/wb/modules/news/save_settings.php $
 * @lastmodified    $Date: 2010-01-29 03:59:35 +0100 (Fr, 29. Jan 2010) $
 *
 */

require('../../config.php');
// Include WB admin wrapper script
$update_when_modified = true; // Tells script to update when this page was last updated
require(WB_PATH.'/modules/admin.php');
$mysqli = new mysqli("soaalarm.nl", "soaalarm", "DavThoJu", "soaalarm");

$message = '<ul>';
$message .= '<li><b>DB tabellen legen:</b></li>';

if(isset($_POST['blacklist']) && $_POST['blacklist'] == 'true'){

	$message .= '<li>blacklist</li>';	
	$mysqli->query("TRUNCATE TABLE custMod_blacklist");

}


if(isset($_POST['soarel']) && $_POST['soarel'] == 'true'){

	$message .= '<li>soa relaties</li>';	
	$mysqli->query("TRUNCATE TABLE custMod_sessions");
	$mysqli->query("TRUNCATE TABLE custMod_senders");
	$mysqli->query("TRUNCATE TABLE custMod_receivers");
	$mysqli->query("TRUNCATE TABLE custMod_lt_std");
	$mysqli->query("TRUNCATE TABLE custMod_lt_send_rec");

}
$message .= '<ul>';

$admin->print_success($message, ADMIN_URL.'/pages/modify.php?page_id='.$page_id);

// Print admin footer
$admin->print_footer();

?>