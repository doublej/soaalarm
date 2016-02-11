<?php
	
	error_reporting(E_ALL);
	// Must include code to stop this file being accessed directly
	if(defined('WB_PATH') == false){
		exit("Cannot access this file directly");
	}
	
	$template 	= 'notify';
	
	
	// open the file
	$sourcefile 	= $_SERVER['DOCUMENT_ROOT'].'/templates/emails/'.$template.'.html.tpl';
	$fh 			= fopen($sourcefile, 'r');
	$htmltemplate 		= fread($fh, filesize($sourcefile));
	fclose($fh);
	
	// set the content	
	if($template == 'confirm'){$replaceOld = array("[*code*]", "[*imgsrc*]");}			
	if($template == 'notify'){$replaceOld = array("[*url*]", "[*imgsrc*]");}
				
	$replaceNew 	= array('http://www.soaalarm.nl/resultaatpagina/?id='.base64_encode(1) , WB_URL.'/templates/emails/soaalarm_logo.jpg');			
	$body 			= str_replace($replaceOld, $replaceNew, $htmltemplate); 		
	
	echo $body;
	


?>