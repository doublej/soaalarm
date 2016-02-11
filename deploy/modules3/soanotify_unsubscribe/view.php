

<form action="<?php echo WB_URL;?>/modules/soanotify_unsubscribe/submit.php" method="post">
	<label>
		<span>Uw e-mailadres</span>
		<input type="text" name="address" class="inp_text val-email"
		<?php

			if(isset($_GET['address']) && $_GET['address'] != ''){
				echo 'value="'.$_GET['address'].'"';
			}
		
		?>
		 />
	</label>
	
	<label class="lab_checkbox">
		<input type="checkbox" name="terms" class="" />
		<span>Ik verklaar dat dit mijn e-mail adres is</span>
		
	</label>
	
	<div class="lab_submit">
		<input type="submit" value="Dit e-mailadres blokkeren" class="inp_submit prim" />
	</div>
</form>

