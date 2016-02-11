<h2>Soa Notify Beheer</h2>
<div class="wrapper">


	<div class="ssection wrapper">
		<?php 
			$mysqli = new mysqli("soaalarm.nl", "soaalarm", "DavThoJu", "soaalarm");
						
			$send = $mysqli->query("SELECT * FROM custMod_senders")->num_rows;
			$rec = $mysqli->query("SELECT * FROM custMod_receivers")->num_rows;
			$black = $mysqli->query("SELECT * FROM custMod_blacklist")->num_rows;
		
		
		?>
		<h3>Stats</h3>
		<table>
			<tr>
				<td>Aantal afzenders</td>
				<td><?php echo $send; ?></td>
			</tr>
			<tr>
				<td>Aantal ontvangers</td>
				<td><?php echo $rec; ?></td>
			</tr>
			<tr>
				<td>Aantal adressen op blacklist</td>
				<td><?php echo $black; ?></td>
			</tr>
		</table>
	</div>
	
	
	<div class="ssection wrapper">
		<h3>database beheer (testing purposes only)</h3>
		<p>Leeg hier databases.</p>
		<form method="post" action="<?php echo WB_URL;?>/modules/soanotify/admin/truncate.php">
			<input type="hidden" name="section_id" value="<?php echo $section_id; ?>" />
			<input type="hidden" name="page_id" value="<?php echo $page_id; ?>" />
			<ul>
				<li>
					<label>
						<input type="checkbox" name="blacklist" value="true" />	
						<span>clear blacklist</span>
					</label>
				</li>
				<li>
					<label>
						<input type="checkbox" name="soarel" value="true" />	
						<span>clear soarelations</span>
					</label>
				</li>
				<li>
					<input type="submit" value="Do it!"/>
				</li>
			</ul>
		</form>	
	</div>
	
	
	<div class="ssection wrapper">
		<h3>Soa beheer</h3>
		<ul>
			<li>
				<label class="">
					<span>Wijzig:</span>
					<select name="possibleStd" id="possibleStd" class="<?php if($errorstd){echo' invalid ';}?>" tabindex="3" >
						<option selected="select" disabled="disabled">selecteer soa</option>
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
			</li>
		</ul>
		to do...
	</div>		
</div>