<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/modules/soanotify/incl/functions.php');	

	$from_address 	= $_POST['fromAddress'];
	$to_address 	= str_replace(' ','', $_POST['toAddress']);
	$multiple 		= false;	
	$error			= false;
	$errorfrom		= false;
	$errorto		= false;
	$errorstd		= false;
	$errorcond		= false;
	$user_ip		= getIp();
	$verify_code 	= randomCode();
	
	if(!validateEmail($from_address)){
		$error = true;
		$errorfrom = true;
	}
	
	if($_POST['possibleStd'] == ''){
		$error = true;
		$errorstd = true;
	}
	
	if(!isset($_POST['conditions'])){
		$error = true;
		$errorcond = true;
	}
	
	if(strpos($to_address, ',')){
		$to_addresses = explode(",", $to_address);		
		$multiple = true;
		
	}
	
		
	if ($multiple == false){		
	// email wordt naar 1 adres verzonden 		
	    $text_addresses = $to_address;
	    $session->addresses = $to_address;		
		$i = 1;
		
		if(!validateEmail($to_address)){
			$error 		= true;
			$errorto 	= true;
		}
		
	}else{
	
		// email wordt naar meerdere adressen verzonden		
		$text_addresses = '';			
		// Loop trough the addresses and create a string
		$numItems = count($to_addresses);
	
		$i = 0;
		foreach ($to_addresses as $key=>$value) {			
		    $text_addresses .= $value;
		    $i++;
		    if($i !== $numItems) {
		      $text_addresses .= ", ";
		    }
	
			if(!validateEmail($value)){
				$error 		= true;
				$errorto 	= true;
			}		    
			
		}
		
		$session->addresses = $to_addresses;		
					
	}
	

	$session->addressesAmount = $i;
	$session->fromAddress = $from_address;
	$session->addressesText = $text_addresses;
	$session->possibleStd = $_POST['possibleStd'];
	$session->step = 1;
	
	$_SESSION['data'] = $session;
	
	session_write_close();
	
	if($error == true){	

		$gt = '?error='.$error;
		$gt .= '&errorto='.$errorto;
		$gt .= '&errorfrom='.$errorfrom;
		$gt .= '&errorstd='.$errorstd;
		$gt .= '&cond='.$errorcond;
		$gt .= '&data='.base64_encode(json_encode($session));

		session_name('soanotify');
		session_destroy();

		header('Location: ../../pages/verstuur-een-soa-alarm.php'.$gt);
		exit();
	}
	
	$user_exist = $mysqli->query("SELECT * FROM custMod_confirmation WHERE userip = '$user_ip'")->num_rows;
	if($user_exist > 0){
		$mysqli->query("UPDATE custMod_confirmation SET code = '$verify_code' WHERE userip = '$user_ip'");
	}else{
		$mysqli->query("INSERT INTO custMod_confirmation (userip, code) VALUES ('$user_ip', '$verify_code')");
	}


		
	try {
		deliverMail(
		'SOA Alarm: bevestig uw e-mailadres.',
		$verify_code,
		'bevestiging@soaalarm.nl, SOA Alarm',
		$from_address,
		'confirm'
		);
	} catch (Exception $e) {
		echo 'Unknown Error';
	}
	
	session_name('soanotify');
	session_start();
	$_SESSION['data'] = $session;
	

						
?>	
<?php echo notifyStatus(2); ?>
<div id="selectionStatus">

	<?php if($multiple == true){?>
		
		<p>Je hebt <?php echo $session->addressesAmount; ?> adressen ingevoerd:</b>
		<ul>
			<?php
				foreach ($to_addresses as $key=>$value) {
			?>
			<li><?php echo $value ?> </li>
			<?php } ?>
		</ul>
		
	<?php }else{ ?>
		
		
		<p>Je hebt <?php echo $session->addressesAmount; ?> adres ingevoerd:</p>
		<ul>
			<li><?php echo $session->addressesText; ?></li>
			
		</ul>
		
	<?php } ?>
<p>Om misbruik tegen te gaan ontvangt u een bevestigingscode per e-mail. Voer deze code hieronder in om uw SOA Alarm te bevestigen</p>
<p>Na correcte invoer worden de emails direct verstuurd.</p>
<form action="/modules/soanotify/confirm.php" method="post" name="confirm_init" >
		
		<label>
			<span>Bevestigingscode</span>
			<input class="inp_text" type="text" name="confirmation" />
			<a class="tooltip" title="Hier vult u de ... in... ">toelichting</a>
		</label>
		
		<div class="lab_submit">
			<input class="inp_reset sec" type="reset" value="Leeg alle velden" title="Leeg alle velden om ze opnieuw in te vullen"/>
			<input class="inp_submit prim" type="submit" value="Verstuur het SOA Alarm" title="Hiermee verstuurt u het SOA Alarm naar de ontvangers en is er geen weg meer terug." />	
		</div>
</form>	
		
