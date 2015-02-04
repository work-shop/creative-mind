
	</div><!--/#content-->

	
	<?php if(!is_home()): get_template_part('signpost'); endif; ?>
	
	<?php if(is_page(8)): 
	
		 get_template_part('contact');
		 get_template_part('invitation');
	 
	 else:
	 
	 	get_template_part('invitation');	
	 	get_template_part('contact'); 
	 	
	 	endif; ?>	
  
</div><!-- /#state -->

<div id="foot" class="hidden">

	<script type="text/javascript">
		//get fonts
		WebFontConfig = { fontdeck: { id: '37770' } };
		
		(function() {
		  var wf = document.createElement('script');
		  wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
		  '://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
		  wf.type = 'text/javascript';
		  wf.async = 'true';
		  var s = document.getElementsByTagName('script')[0];
		  s.parentNode.insertBefore(wf, s);
		})();	
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

	<?php 
		if ( !file_exists( dirname(__FILE__) . 'env_prod' )  ) { 
			include('less.php');
		}
	?>

</div>

<?php wp_footer(); ?>

</body>

</html>