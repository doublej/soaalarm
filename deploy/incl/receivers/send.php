<?php 
	
	// Report all PHP errors (see changelog)
	error_reporting(E_ALL);
	
	require_once 'lib/swift_required.php'; 

	//Create the Transport
	$transport = Swift_SmtpTransport::newInstance('smtp.gmail.com', 465, 'ssl')
	  ->setUsername('jurrejan@gmail.com')
	  ->setPassword('guh92j');
	  
	$mailer = Swift_Mailer::newInstance($transport);
	$message = Swift_Message::newInstance('U heeft 1 nieuwe soa(\'s)')
	  ->setFrom(array('alert@soaalert.com' => 'Soa Alert'))
	  ->setTo(array('anoniem@soaalarm.nl' => 'Anonieme ontvanger'))
	  ->setBcc($addresses)
	  ->setBody('<h1>U heeft 1 nieuwe SOA\'(s)</h1>')
	  ->setContentType("text/html");

	$numSent = $mailer->send($message);
	printf("Sent %d messages\n", $numSent - 1);
	


?>