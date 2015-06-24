
<?php if ( $slides = get_field('home_page_slideshow', 'options') ) : ?>

<section class="block crop" id="slideshow">

	<div class="slick variable-width">

		<?php foreach( $slides as $i => $slide ) : ?>
		
			<?php
			$image_url = ( $slide['slide_type'] == 'custom') 
					  ? $slide['slide_image']['sizes']['slideshow_home']
					  : (( $slide['slide_type'] == "story") 
					  ? wp_get_attachment_url( get_post_thumbnail_id( $slide['slide_story'][0]->ID, 'slideshow_home' ) )
					  : wp_get_attachment_url( get_post_thumbnail_id( $slide['slide_collection'][0]->ID, 'slideshow_home' ) ));
			?>

			<div class="slide">
				<div class="img-wrap"><img src="<?php echo $image_url; ?>" alt="slide"/></div>
					<h1><?php echo $slide['slide_title']; ?></h1>
					<h4 class="hidden"></h4>
					<a href="#" class="">Read more <span class="icon" data-icon="&#8222;"></span></a>
			</div>

		<?php endforeach; ?>

	</div>	
	
<!-- 	<div id="previous-home" class="flexslider-direction flex-previous previous">
		<span class="icon" data-icon="&#8250;"></span>
	</div>					
	
	<div id="next-home" class="flexslider-direction flex-next next">
		<span class="icon" data-icon="&#8249;"></span>
	</div>	 -->
	
</section>


<?php endif; ?>