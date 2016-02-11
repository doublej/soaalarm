<?php	
	
	$email = $_POST['address'];
	
	$mysqli = new mysqli("soaalarm.nl", "soaalarm", "DavThoJu", "soaalarm");
	$mysqli->query("INSERT INTO custMod_blacklist (address) VALUES ('$email')");
	
	
?>