<?php 	
	function deliverMail($subject, $message, $from, $to){
		require_once WB_PATH.'/modules/soanotify/lib/swift_required.php';	 
	
		if (!is_array($to)){
			$to = array($to);		
		}
		
		$from = explode(",", $from);		
	
		//Create the Transport
		$transport = Swift_SmtpTransport::newInstance('mail.soaalarm.nl', 25)
		  ->setUsername('soaalarm')
		  ->setPassword('DavThoJu');
		  
		$mailer = Swift_Mailer::newInstance($transport);
		$message = Swift_Message::newInstance($subject)
		  ->setFrom(array($from[0] => $from[1]))
		  ->setTo($to)
		  ->setBody($message)
		  ->setContentType("text/html");
	
		$numSent = $mailer->send($message);
		return $numSent;
		
	}

?>