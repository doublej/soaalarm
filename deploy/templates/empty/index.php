<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" dir="ltr">
<head>
	<?php require(WB_PATH.'/templates/incl/css_browser_selector.php'); ?> 
	<meta http-equiv="Content-Type" content="text/html; charset=<?php echo defined('DEFAULT_CHARSET') ? DEFAULT_CHARSET : 'utf-8'; ?>" />
	<meta name="description" content="<?php page_description(); ?>" />
	<meta name="keywords" content="<?php page_keywords(); ?>" />
	<meta name="robots" content="noindex">
	<meta name="robots" content="noarchive">
    <script src="https://www.google.com/jsapi?key=ABQIAAAAQJKACZgLsK-lxD4NIjElCBRq5G9t-sDuxnjz5s2ynIA1u4WFUhSUouKr9B_n_05bkn93qbs6ppaIBg" type="text/javascript"></script>
    <script type="text/javascript">google.load("jquery", "1.5");</script>
    <script src="<?php echo ASSETS_URL; ?>/js/functions.js" type="text/javascript"></script>
    <script type="text/javascript">
    	$(document).ready(function(){
    		$('#fancybox-wrap a').click(function(){
    			return false;
    		})
    	})
    </script>
	<title><?php echo page_title(' • '); ?></title>
</head>

	<body class="nojs <?php echo css_browser_selector() ?>">
		<?php page_content(1); ?>
	</body>

</html>