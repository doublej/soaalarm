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
	<link type="text/css" rel="stylesheet" href="<?php echo ASSETS_URL; ?>/css/screen.css" media="screen" />
	<link type="text/css" rel="stylesheet" href="<?php echo ASSETS_URL; ?>/css/jquery.fancybox-1.3.4.css" media="screen" />
	<link type="text/css" rel="stylesheet" href="<?php echo ASSETS_URL; ?>/css/print.css" media="print" />
    <script src="https://www.google.com/jsapi?key=ABQIAAAAQJKACZgLsK-lxD4NIjElCBRq5G9t-sDuxnjz5s2ynIA1u4WFUhSUouKr9B_n_05bkn93qbs6ppaIBg" type="text/javascript"></script>
    <script type="text/javascript">google.load("jquery", "1.5");</script>
	<script src="<?php echo ASSETS_URL; ?>/js/jquery.fancybox-1.3.4.pack.js" type="text/javascript"></script>
    <script src="<?php echo ASSETS_URL; ?>/js/functions.js" type="text/javascript"></script>
    <?php register_frontend_modfiles('js');?>
	<title><?php echo page_title(' • '); ?></title>
</head>

<?php
function getClientIP() {

    if (isset($_SERVER)) {

        if (isset($_SERVER["HTTP_X_FORWARDED_FOR"]))
            return $_SERVER["HTTP_X_FORWARDED_FOR"];

        if (isset($_SERVER["HTTP_CLIENT_IP"]))
            return $_SERVER["HTTP_CLIENT_IP"];

        return $_SERVER["REMOTE_ADDR"];
    }

    if (getenv('HTTP_X_FORWARDED_FOR'))
        return getenv('HTTP_X_FORWARDED_FOR');

    if (getenv('HTTP_CLIENT_IP'))
        return getenv('HTTP_CLIENT_IP');

    return getenv('REMOTE_ADDR');
}
?>

<body class="nojs <?php echo css_browser_selector() ?>" style="min-width: 1300px">

	<?php placePart('header'); ?>

	<?php placePart('spec');?>

	<div id="contentContainer">

		<div class="colleft">

			<?php page_content(2); ?>
			<div id="subMenu" class="menu">
				<?php
				   show_menu2(
				        $aMenu          = 1,
				        $aStart         = SM2_ROOT+1,
				        $aMaxLevel      = SM2_START,
				        $aOptions       = SM2_TRIM,
				        $aItemOpen      = '[li][a][menu_title]</a>',
				        $aItemClose     = '</li>',
				        $aMenuOpen      = '<ul class="reset">',
				        $aMenuClose     = '</ul>',
				        $aTopItemOpen   = false,
				        $aTopMenuOpen   = false
				        );
				?>
				<div class="sideShade"><div class="fadeN"></div><div class="fadeS"></div></div>

			</div>

			<?php page_content(3); ?>

            <?php


            if(getClientIP() == "77.95.98.131"){?>
                <img src="emiel.png" style="position: absolute;top:-231px;left: 610px;">
            <?php
            }
            ?>

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

	<?php placePart('footer'); ?>
</body>
</html>
