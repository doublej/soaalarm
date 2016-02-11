<?php
	session_write_close();
	session_name('soanotify');
	session_start();	
	
		
	require_once($_SERVER['DOCUMENT_ROOT'].'/modules/soanotify/incl/functions.php');
	$database = new mysqli("soaalarm.nl", "soaalarm", "DavThoJu", "soaalarm");
	
	$user_ip = getIp();
	$user_exist = $database->query("SELECT * FROM custMod_confirmation WHERE userip = '$user_ip'")->num_rows;
	$fetch_user = $database->query("SELECT * FROM custMod_confirmation WHERE userip = '$user_ip'")->fetch_object();	
	$session = $_SESSION['data'];
	$session->step = 2;
	
	//Validate the code	
	if($_POST['confirmation'] == $fetch_user->code){

		$from = $session->fromAddress;
		$to = $session->addresses;
		$std_id = $session->possibleStd;
		$fetch_sender = $database->query("SELECT * FROM custMod_senders WHERE email = '$from'")->fetch_object();	
		$new_date = time();
			
		if (!is_array($to)){
			$to = array($to);		
		}
		
					
		if(!getSenderID($from)){
			// doesnt exist. Insert in DB and get ID.
			$database->query("INSERT INTO custMod_senders (email, timestamp) VALUES ('$from', '$new_date')");
			$send_id = $database->insert_id;						
		}else{
			// does exist. Get ID.
			$send_id = getSenderID($from);
			if($fetch_sender->timestamp == '' OR $fetch_sender->timestamp == 0){
				$database->query("UPDATE custMod_senders SET timestamp = '$new_date' WHERE email = '$from'");		
			}else{			
				$old_date = $fetch_sender->timestamp;
				$dateDiff = $new_date - $old_date;
				$fullDays = floor($dateDiff/(60*60*24));
				if($fullDays < 1){
					$gt = '?shortspan=1';
					header('Location: ../../pages/verstuur-een-soa-alarm.php'.$gt);
					exit();
				};

			}
		}
		
		$session->amountSent = 0;	
				
		foreach($to as $address) {	
			$send_this_user = true;
			$receiver_data->$address->address = $address;
			$receiver_data->$address->exists = false;
			$receiver_data->$address->user_link_exists = false;
			$receiver_data->$address->user_std_link_exists = false;
			$receiver_data->$address->sent = false;
				
			if(!getReceiverID($address)){
				// doesnt exist. Insert in DB and get ID.
				$database->query("INSERT INTO custMod_receivers (email) VALUES ('$address')");
				$receive_id = $database->insert_id;				
			}else{
				// does exist. Get ID.	
				$receive_id = getReceiverID($address);
				$receiver_data->$address->exists = true;		
			}
			
			if(!findSenRecLink($receive_id, $send_id)){
				// doesnt exist. Insert in DB and get ID.
				$database->query("INSERT INTO custMod_lt_send_rec (send_id, receive_id) VALUES ('$send_id', '$receive_id')");
				$couple_id = $database->insert_id;
			}else{
				// does exist. Get ID.
				$couple_id = findSenRecLink($receive_id, $send_id);
				$receiver_data->$address->user_link_exists = true;	
			}
			
			if(!findStdCoupleLink($couple_id, $std_id)){
				// doesnt exist. Insert in DB and get ID.
				$database->query("INSERT INTO custMod_lt_std (couple_id, std_id) VALUES ('$couple_id', '$std_id')");
				$couple_id = $database->insert_id;
			}else{				
				$send_this_user = false;
				$receiver_data->$address->user_std_link_exists = true;					
			}			
			
			if(foundblock($address)){			
				$send_this_user = false;					
			}			
			
			
			if($send_this_user){					
					$detail_url = 'http://www.soaalarm.nl/resultaatpagina/?id='.base64_encode($session->possibleStd);					
					$receiver_data->$address->mail_return = deliverMail('Belangrijk bericht van SOA Alarm', $detail_url, 'berichtgeving@soaalarm.nl,SOA Alarm', $address, 'notify');
					$receiver_data->$address->sent = true;
					$session->amountSent++;
			}else{
				
			}			
		}		
		
		$session->results = $receiver_data;			
		$_SESSION['data'] = $session;
		
	
		session_write_close();
		
			
		$pagetype = '?pagetype=confirm_success';	
	}else if($user_exist > 0){
		session_name('soanotify');
		session_destroy();
		$pagetype = '?pagetype=confirm_error_code';
	}else{
		session_name('soanotify');
		session_destroy();	
		$pagetype = '?pagetype=confirm_error_other';
	}
	
	$database->query("DELETE FROM custMod_confirmation WHERE userip = '$user_ip'");	
	header('Location: ../../pages/verstuur-een-soa-alarm.php'.$pagetype);
	exit;
	
?> 