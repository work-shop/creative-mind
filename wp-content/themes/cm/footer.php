
		</div><!--/#content-->
		
		<?php get_template_part('break'); ?>	
		<?php get_template_part('back_to_top'); ?>
		<?php get_template_part('guidepost'); ?>
		<?php get_template_part('footer_menu'); ?>
		<?php get_template_part('search_modal'); ?>

	</div><!-- /#wrapper -->

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

	<?php if ( !file_exists( dirname(__FILE__) . 'env_prod' )  ) : include('less.php'); endif; ?>

	<?php wp_footer(); ?>

	</body>
</html>