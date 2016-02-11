<?php
	session_start();
	
	
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
	
	
	
	$step = 1;
	if(isset($_GET['step']) && $_GET['step'] != ''){
		$step = $_GET['step'];
	}
	
	if($step == 1){
		
		$fromMail = $_POST['fromMail'];
		
		$addresses = str_replace(' ','', $_POST['toMail']);
	
		if(strpos($addresses, ',')){
			$addresses = explode(",", $addresses);		
		}
		
		if (!is_array($addresses)){  
		    $txtMsg = "Uw mail wordt naar het volgende adres verzonden: ";
		    $txtAddresses = $addresses;
		}else{
			$txtAddresses = '';
			
			// Loop trough the addresses
			$numItems = count($addresses);
			$i = 0;
			foreach ($addresses as $key=>$value) {
			    $txtAddresses .= $value;
			    $i++;
			    if($i !== $numItems) {
			      $txtAddresses .= ",";
			    }
			}
		
			$txtMsg = "Uw mail wordt naar de volgende ".$i." addressen verzonden: ";
		
			
		}
			
			$_SESSION['message'] = $txtMsg.$txtAddresses;
			$_SESSION['addresses'] = $addresses;
			$_SESSION['confirmation'] = randomCode();
			include'incl/confirm/send.php';
?>
			U heeft zojuist een bevestiginscode per email ontvangen. vul in bla bla..
			<form action="?step=2" method="post">
				<input type="text" name="confirmation" />
				<input type="submit" />
			</form>			
<?php }	
	
	if($step == 2){
		
		if($_POST['confirmation'] == $_SESSION['confirmation']){
			$addresses = $_SESSION['addresses'];
			
			echo'code is juist, mails worden verzonden';
			
			include'incl/receivers/write.php';
			include'incl/receivers/send.php';
		}else{
			echo'code is onjuist.';
		}
	}
	
?>