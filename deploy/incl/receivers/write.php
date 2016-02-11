<?php
	
	include 'incl/connect.php';
	
	if(!is_array($addresses)){
		$address = $addresses;
		mysql_query("INSERT INTO recievers (emailEncr) VALUES('".md5($address)."') ") 
		or die(mysql_error());  
	}else{	
		foreach ($addresses as $key=>$value) {		    
			$address = md5($value);
		    mysql_query("INSERT INTO recievers (emailEncr) VALUES('".$address."') ")
		    or die(mysql_error());  		    
		}
	}	
	
	
?>