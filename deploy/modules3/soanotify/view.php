<div id="soanotify">
	<link type="text/css" rel="stylesheet" href="<?php echo ASSETS_URL; ?>/css/validationEngine.jquery.css" media="screen" />

	<?php
	
	error_reporting(E_ALL);
	// Must include code to stop this file being accessed directly
	if(defined('WB_PATH') == false){
		exit("Cannot access this file directly");
	}
	require_once($_SERVER['DOCUMENT_ROOT'].'/modules/soanotify/incl/functions.php');
	
	session_write_close();
	session_name('soanotify');
	session_start();	
	session_write_close();
	
	?>

	<?php
	
	if(isset($_GET['shortspan']) && $_GET['shortspan'] == '1'){
	?>
	<h3>Ho ho...</h3>
	
	<p>U probeert te vaak achter elkaar een SOA Alarm te versturen. Uw IP-adres is tijdelijk uitgesloten van onze dienst.</p>
	<p>Om misbruik te voorkomen kunnen gebruikers van SOA Alarm maar eens in een door ons bepaalde periode een SOA Alarm versturen. Probeer het later nog eens.</p>
	<p><a href="http://www.soaalarm.nl/over-soa-alarm/algemene-voorwaarden/">Lees ook de voorwaarden.</a></p>
	
	<?php
		
	}else{
	?>
	
	<h3>Verstuur een SOA Alarm</h3>
	<?php
		if(isset($_GET['pagetype']) && $_GET['pagetype'] !== ''){
			include 'view_'.$_GET['pagetype'].'.php';
		}else{
			include 'view_setup.php';
		}
	}
	?>
</div>
