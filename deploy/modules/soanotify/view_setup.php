<?php echo notifyStatus(1); ?>

<?php
	$error		= false;
	$errorto 	= false;
	$errorfrom 	= false;
	$errorstd 	= false;
	$errcond	= false;
if(isset($_GET['error']) && $_GET['error'] == '1'){
	$error 		= true;
	$errorto 	= $_GET['errorto'];
	$errorfrom 	= $_GET['errorfrom'];
	$errorstd 	= $_GET['errorstd'];
	$datagt		= $_GET['data'];
	$errcond	= $_GET['cond'];
	$datacomp 	= base64_decode($datagt);
	$data 		= json_decode($datacomp);
}

 ?>
	
<script>
	$(document).ready(function(){
		$("#vrwrdn").fancybox({
			'width'				: 800,
			'height'			: 500,
			'padding'			: 30,
	        'autoScale'     	: false,
	        'autoDimensions'	: false,
	        'transitionIn'		: 'none',
			'transitionOut'		: 'none',
			'type'				: 'ajax'
		});
	});
</script>

	<form action="?pagetype=confirm_init" method="post" name="setup">
		<p>Vul de gegevens in. Je eigen e-mailadres wordt gevraagd ter verificatie om spam tegen te gaan, dit adres blijft anoniem. Vul &eacute;&eacute;n of meerdere ontvangstadressen in en selecteer de aandoening die van toepassing is.</p>
		<?php if($error == true){echo '<p style="margin:20px 0;color:#f00">Niet alle velden zijn (volledig) ingevuld. Deze zijn met rood gemarkeerd.</p> ';}?>
		<label>
			
			<span>Uw e-mailadres</span>
			
			<input class="inp_text <?php if($errorfrom == 1){echo' invalid ';}?> val-email"
			type="text"
			name="fromAddress"
			id="fromAddress"
			autocomplete="off"
			tabindex="1"			
			<?php if($errorto == 1){echo 'value="'.$data->fromAddress.'"';}?>
			/>
		</label>
		
		<div class="multiple">
			<label class="">
				<span>Ontvangende e-mailadressen (kommagescheiden)</span>
				
				<input class="inp_text duplicating <?php if($errorto == 1){echo' invalid ';}?> val-email"
					type="text"
					name="toAddress"
					id="toAddress"
					autocomplete="off"
					tabindex="2"
					 />			
			</label>
		</div>
		<label class="">
			<span>Aandoening</span>
			<select name="possibleStd" id="possibleStd" class="<?php if($errorstd){echo' invalid ';}?>" tabindex="3" >
				<option selected="select" disabled="disabled">selecteer...</option>
				<?php  
					$fetchStds = $database->query("SELECT * FROM custMod_stds");
					while( false != ( $std = $fetchStds->fetchRow() ) ){
						$selected = '';
						if($errorto == 1 && $std['id'] == $data->possibleStd){
							$selected = 'selected="selected"';
						}
						
						echo '<option value="'.$std['id'].'" '.$selected.'>'.$std['name'].'</option>';
					}
				?>
			</select>
		</label>
		<p class="lab_checkbox <?php if($errcond){echo' invalid ';}?>">
			<input class="inp_checkbox  " type="checkbox"  name="conditions" id="conditions" tabindex="4" />
			<span>Ik ga akkoord met de <a id="vrwrdn" href="/over-soa-alarm/algemene-voorwaarden/">voorwaarden</a>
			<?php if($errcond){echo'<br><span style="color:red;">Om een SOA Alarm te kunnen versturen moet u akkoord gaan met de voorwaarden.</span>';}?>
			</span>
		</p>
		<div class="lab_submit">
			<input class="inp_reset sec" type="reset" value="leeg velden" />
			<input class="inp_submit prim" type="submit" value="naar de volgende stap" tabindex="5"  />	
		</div>
	</form>
