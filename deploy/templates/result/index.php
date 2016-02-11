<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" dir="ltr">
<head>
	<?php
	function placePart($name){
		include WB_PATH.'/templates/incl/'.$name.'.php';
	}
	require(WB_PATH.'/templates/incl/css_browser_selector.php'); ?> 
	<meta http-equiv="Content-Type" content="text/html; charset=<?php echo defined('DEFAULT_CHARSET') ? DEFAULT_CHARSET : 'utf-8'; ?>" />
	<meta name="description" content="<?php page_description(); ?>" />
	<meta name="keywords" content="<?php page_keywords(); ?>" />
	<meta name="robots" content="noindex" />
	<meta name="robots" content="noarchive" />
	<link type="text/css" rel="stylesheet" href="<?php echo ASSETS_URL; ?>/css/screen.css" media="screen" />
	<link type="text/css" rel="stylesheet" href="<?php echo ASSETS_URL; ?>/css/jquery.fancybox-1.3.4.css" media="screen" />
	<link type="text/css" rel="stylesheet" href="<?php echo ASSETS_URL; ?>/css/print.css" media="print" />
    <script src="https://www.google.com/jsapi?key=ABQIAAAAQJKACZgLsK-lxD4NIjElCBRq5G9t-sDuxnjz5s2ynIA1u4WFUhSUouKr9B_n_05bkn93qbs6ppaIBg" type="text/javascript"></script>
    <script type="text/javascript">google.load("jquery", "1.5");</script>
	<script src="<?php echo ASSETS_URL; ?>/js/jquery.fancybox-1.3.4.pack.js" type="text/javascript"></script>
    <script src="<?php echo ASSETS_URL; ?>/js/functions.js" type="text/javascript"></script>
    
	<title><?php echo page_title(' • '); ?></title>
</head>

<body class="nojs <?php echo css_browser_selector() ?>">

	<?php //placePart('header'); ?>
			
	<?php placePart('spec');?>
			
	<div id="contentContainer">

		<div class="colleft" style="margin-top:0;padding-top:0;">
		
			<?php page_content(2); ?>			
			
			<?php page_content(3); ?>
			
		</div>
		
		<div class="colright">
			
			<div class="ads" id="contentads">
				<?php page_content(4); ?>
			</div>
			
			<div class="content">
				<?php page_content(1); ?>
			</div>
			
		</div>
		

	</div>
	
	<div class="ads" id="footads">
				<?php page_content(5); ?>
	</div>
	
	<?php //placePart('footer'); ?>
</body>
</html>
