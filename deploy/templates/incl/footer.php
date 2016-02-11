<div id="sitemap">
	<?php 
	    show_menu2(
	        $aMenu          = 1,
	        $aStart         = SM2_ROOT,
	        $aMaxLevel      = SM2_ALL,
	        $aOptions       = SM2_ALL,
		    $aItemOpen      = '[li]<a href="[url]" class="[class]">[menu_title]</a>',  
	        $aItemClose     = '</li>',
	        $aMenuOpen      = '<ul class="reset wrapper">',
	        $aMenuClose     = '</ul>',
	        $aTopItemOpen   = false,
	        $aTopMenuOpen   = false
	        );
	?>
</div>
<div id="footer">			
	<div id="langswitch">
		<ul class="reset wrapper">
			<li class="label">Language</li>
			<li><a href="#" class="active"><span class="a">Nederlands</span> <span class="b">Live</span></a></li>
			<li><a class="disabled"><span class="a">English</span> <span class="b">Soon!</span></a></li>
			<li><a class="disabled"><span class="a">Deutsch</span> <span class="b">Schnell!</span></a></li>
			<li><a class="disabled"><span class="a">Espa&ntilde;ol</span> <span class="b">Rapido!</span></a></li>
			<li><a class="disabled"><span class="a">Fran&ccedil;ais</span> <span class="b">Rapide!</span></a></li>
		</ul>
	</div>
	<div id="finword"><?php page_footer(); ?></div>
</div>

<?php include WB_PATH.'/templates/incl/share.php';?>
<script type="text/javascript">	
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-20425865-1']);
  _gaq.push(['_setDomainName', 'none']);
  _gaq.push(['_setAllowLinker', true]);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>