<?php 
	session_name('soanotify');
	session_start();
	$session = $_SESSION['data'];
?>
<?php echo notifyStatus(3); ?>
<div id="resultpage" class="wrapper">	
	<div id="sentStatus">
	<?php
		
		echo '<h4>Verzendrapport</h4>
		<ul class="reset" id="mailresult">';
		foreach($session->results as $addr=>$spec) {
			$adrclass=' skipped ';
			if($spec->sent){$adrclass = ' sent ';}		
			echo '<li class="address '.$adrclass.'" ><span class="email">'.$addr.'</span>';
			echo '<ul>';
			if($spec->user_std_link_exists == true){
				echo'<li>U heeft dit e-mailadres al een alarm gestuurd over deze SOA.</li>';
			}else if($adrclass==' skipped '){
				echo'<li>Het alarm kan niet verzonden worden aan dit adres..</span></li>';			
			}else{
				echo'<li>Het alarm is succesvol verzonden.</span></li>';
			}
			echo '</ul>';
			echo '</li>';
		}
		echo '</ul>';
	?>
	</div>
	<div class="side">
		
		<p>De ingevulde bevestigingscode was juist. Er <?php if($session->amountSent == 1 ){echo'is ';}else{echo'zijn ';} echo $session->amountSent; ?> e-mail<?php if($session->amountSent !== 1 ){echo's';} ?> verzonden.</p>
		<p>Bedankt voor het gebruik van SOA Alarm. Door het gebruiken van SOA Alarm heb je een belangrijke stap gemaakt om te voorkomen dat de geslachtsziekte verder wordt verspreid, of voor anderen pijnlijke gevolgen krijgt. </p>
		
		<p><strong>Help SOA Alarm</strong><br/>
		Met behulp van jou en vele andere gebruikers  van SOA Alarm kunnen seksueel overdraagbare aandoeningen in de Nederlandse maatschappij in kaart worden gebracht.</p>		
		<p>Doe mee aan het <a href="/onderzoek/">anonieme onderzoek</a>.</p>
			
	</div>	
	
</div>


<script type="text/javascript">
	$(function(){
		soaalarm.initiate.soanotify.resultPage();				
	})
</script>