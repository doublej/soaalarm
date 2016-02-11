<?php	
	if(!isset($_GET['id'])){
		header('Location: http://www.soaalarm.nl');
		exit();
	}
	$std_id = base64_decode($_GET['id']);
	$mysqli = new mysqli("soaalarm.nl", "soaalarm", "DavThoJu", "soaalarm");
	$fetchStds = $database->query("SELECT * FROM custMod_stds WHERE id = $std_id");
	while( false != ( $std = $fetchStds->fetchRow() ) ){	
		echo '<p>De SOA die hij of zij heeft opgelopen is: <br/><b>'.$std['name'].'</b></p>';		
	}	
?>