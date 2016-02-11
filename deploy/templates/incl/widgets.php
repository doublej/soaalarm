<div class="widget" id="fbWidget">
	<iframe src="http://www.facebook.com/plugins/likebox.php?href=http%3A%2F%2Fwww.facebook.com%2Fpages%2FSOA-Alarm%2F173126506052493&amp;width=292&amp;colorscheme=light&amp;show_faces=false&amp;stream=false&amp;header=false&amp;height=62" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:292px; height:62px;" allowTransparency="true"></iframe>
</div>

<div class="widget" id="twWidget">
	<script src="http://widgets.twimg.com/j/2/widget.js"></script>
	<script>
	new TWTR.Widget({
	  version: 2,
	  type: 'profile',
	  rpp: 1,
	  interval: 6000,
	  width: 240,
	  height: 300,
	  theme: {
	    shell: {
	      background: '#f0f4ed',
	      color: '#000000'
	    },
	    tweets: {
	      background: '#ffffff',
	      color: '#000000',
	      links: '#ff3300'
	    }
	  },
	  features: {
	    scrollbar: false,
	    loop: false,
	    live: false,
	    hashtags: true,
	    timestamp: false,
	    avatars: false,
	    behavior: 'all'
	  }
	}).render().setUser('soaalarm').start();
	</script>
</div>
