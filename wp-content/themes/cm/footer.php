		</main><!--/#content-->
		
		<?php get_template_part('partials/footer_menu'); ?>
		<?php get_template_part('partials/story_modal'); ?>
		<?php get_template_part('partials/mega_nav'); ?>

	</div><!-- /#wrapper -->

	<!-- Fontdeck -->
	<script type="text/javascript">
	WebFontConfig = { fontdeck: { id: '55448' } };

	(function() {
	  var wf = document.createElement('script');
	  wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
	  '://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
	  wf.type = 'text/javascript';
	  wf.async = 'true';
	  var s = document.getElementsByTagName('script')[0];
	  s.parentNode.insertBefore(wf, s);
	})();
	</script>	

	<script type="text/javascript">var addthis_config = {"data_track_addressbar":true};</script>
	<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-50f20b8a658458ce"></script>	
	<script type="text/javascript">var addthis_config = {"data_track_clickback":true};</script>

	<!-- 
	<script type="text/javascript">
		//google analytics
		  var _gaq = _gaq || [];
		  _gaq.push(['_setAccount', 'UA-43897729-1']);
		  _gaq.push(['_trackPageview']);
		  (function() {
		    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		  })();
	</script> 	 		
 	-->
 	
	<?php wp_footer(); ?>

	</body>
</html>