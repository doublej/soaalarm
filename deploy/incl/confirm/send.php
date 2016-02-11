<?php 
	
	// Report all PHP errors (see changelog)
	error_reporting(E_ALL);
		
	require_once 'lib/swift_required.php'; 
	
	//Create the Transport
	$transport = Swift_SmtpTransport::newInstance('smtp.gmail.com', 465, 'ssl')
	  ->setUsername('jurrejan@gmail.com')
	  ->setPassword('guh92j');
	  
	$mailer = Swift_Mailer::newInstance($transport);
	$message = Swift_Message::newInstance('Bevestig uw alert')
	  ->setFrom(array('alert@soaalert.com' => 'Soa Bevestigingsmachine'))
	  ->setTo(array($fromMail => 'Anonieme ontvanger'))
	  ->setBody('<h1>code is '.$_SESSION['confirmation'].' </h1>')
	  ->setContentType("text/html");

	$numSent = $mailer->send($message);
	printf("Sent %d messages\n", $numSent);


?>