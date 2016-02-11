<h2>Hallo</h2>

<form method="post" action="<?php echo WB_URL;?>/modules/soanotify_truncate/truncate.php">
	<input type="hidden" name="section_id" value="<?php echo $section_id; ?>" />
	<input type="hidden" name="page_id" value="<?php echo $page_id; ?>" />
	<ul>
		<li>
			<label>
				<input type="checkbox" name="blacklist" value="true">	
				<span>clear blacklist</span>
			</label>
		</li>
		<li>
			<label>
				<input type="checkbox" name="soarel" value="true">	
				<span>clear soarelations</span>
			</label>
		</li>
	</ul>
	<input type="submit" value="Do it!"/>
</form>