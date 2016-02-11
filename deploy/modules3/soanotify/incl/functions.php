<?php
	error_reporting(E_ALL);
	require_once($_SERVER['DOCUMENT_ROOT'].'/modules/soanotify/lib/swift/swift_required.php');

	$mysqli = new mysqli("soaalarm.nl", "soaalarm", "DavThoJu", "soaalarm");
	$user_ip = getIP();
	$checksession = $mysqli->query("SELECT * FROM custMod_sessions WHERE userip = '$user_ip'")->num_rows;
	
	
	function encrEmail($address){
			return md5(str_replace("@", "-@P3NST@@RTJ3-", $address));
	}
	
	function getSenderId($fromAddress){
		global $mysqli;
		$check = $mysqli->query("SELECT * FROM custMod_senders WHERE email = '$fromAddress'");
		if($check->num_rows > 0){
			$id = $check->fetch_object();
			return $id->id;		
		}else{
			return 0;
		}
	}
	
	function getReceiverId($toAddress){
		global $mysqli;
		$check = $mysqli->query("SELECT * FROM custMod_receivers WHERE email = '$toAddress'");
		if($check->num_rows > 0){
			$id = $check->fetch_object();
			return $id->id;		
		}else{
			return false;
		}
	}
	
	function findSenRecLink($toId, $fromId){
		global $mysqli;
		$check = $mysqli->query("SELECT * FROM custMod_lt_send_rec WHERE send_id = '$fromId' AND receive_id = '$toId'");
		if($check->num_rows > 0){
			$id = $check->fetch_object();
			return $id->couple_id;	
		}else{
			return false;
		}
	}
	
	function findStdCoupleLink($coupleId, $stdId){
		global $mysqli;
		$check = $mysqli->query("SELECT * FROM custMod_lt_std WHERE couple_id = '$coupleId' AND std_id = '$stdId'");
		if($check->num_rows > 0){
			$id = $check->fetch_object();
			return $id->couple_id;	
		}else{
			return false;
		}
	}
	
	function foundblock($address){
		global $mysqli;
		$check = $mysqli->query("SELECT * FROM custMod_blacklist WHERE address = '$address'");
		if($check->num_rows > 0){
			return true;
		}else{
			return false;
		}
	}
	
	
	function deliverMail($subject, $data, $from, $to, $template){
		if($_SERVER['SERVER_ADDR'] !== '::1'){
					
			if (!is_array($to)){
				$to = array($to);		
			}			
			$from = explode(",", $from);
			
			//Create the Transport
			
			$transport = Swift_SmtpTransport::newInstance('mail.soaalarm.nl', 25)
			  ->setUsername('soaalarm')
			  ->setPassword('DavThoJu');			  
			  
			  
			$mailer = Swift_Mailer::newInstance($transport);		
			$message = Swift_Message::newInstance($subject);
			$image = $message->embed(Swift_Image::fromPath($_SERVER['DOCUMENT_ROOT'].'/templates/emails/soaalarm_logo.jpg'));
			
			// open the template
			$sourcefile 	= $_SERVER['DOCUMENT_ROOT'].'/templates/emails/'.$template.'.html.tpl';
			$fh 			= fopen($sourcefile, 'r');
			$htmltemplate 	= fread($fh, filesize($sourcefile));
			fclose($fh);
						
			// set the content	
			if($template == 'confirm'){$replaceOld = array("[*code*]", "[*imgsrc*]", "[*address*]");}			
			if($template == 'notify'){$replaceOld = array("[*url*]", "[*imgsrc*]", "[*address*]");}
									
			$replaceNew 	= array($data, $image, $to[0]);			
			$body 			= str_replace($replaceOld, $replaceNew, $htmltemplate); 					
			
			
			$message->setFrom(array($from[0] => $from[1]))
			->setTo($to)
			->setBody($body, 'text/html');

			
		
			if (!$mailer->send($message, $failures)){
				return "Failures:";
				return print_r($failures);
			}else{
				return 'success';
			}			
		}
	}
	
	
	
	function randomCode() {
	    $chars = "abcdefghijkmnopqrstuvwxyz023456789";	
	    srand((double)microtime()*1000000);	
	    $i = 0;
	    $code = '' ;	    	
	    while ($i <= 7) {	
	        $num = rand() % 33;	
	        $tmp = substr($chars, $num, 1);	
	        $code = $code . $tmp;	
	        $i++;	
	    }	    
	    return $code;	
	}
	
	function getIP() {
		$ip;
		if (getenv("HTTP_CLIENT_IP"))
		$ip = getenv("HTTP_CLIENT_IP");
		else if(getenv("HTTP_X_FORWARDED_FOR"))
		$ip = getenv("HTTP_X_FORWARDED_FOR");
		else if(getenv("REMOTE_ADDR"))
		$ip = getenv("REMOTE_ADDR");
		else
		$ip = "UNKNOWN";
		return $ip;
	}

	function validateEmail($address){
		if (preg_match('/^[^\W][a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\@[a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\.[a-zA-Z]{2,4}$/',$address)) { 
			return true;
		}else{
			return false;
		}
	}
	
	function notifyStatus($step){
		$st1 = '';
		$st2 = '';
		$st3 = '';
						
		if($step == 1){
			$st1 = 'class="current"';
		}
		if($step == 2){
			$st2 = 'class="current"';
		}
		if($step == 3){
			$st3 = 'class="current"';
		}
		
	
	 	$status = '
	 	<div id="progress" class="wrapper">
	 		<span '.$st1.'>1. Gegevens invullen</span>
			<span '.$st2.'>2. E-mailadres bevestigen</span> 
			<span '.$st3.'>3. alarm verzonden</span> 
		</div>';
		return $status;
	}
	
	
?>