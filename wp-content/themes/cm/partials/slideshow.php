<?php if ( $slides = get_field('home_page_slideshow', 'options') ) : ?>

<section class="block crop" id="slideshow">

	<div class="flexslider flexslider-hero">
		<ul class="slides">

		<?php foreach( $slides as $i => $slide ) : ?>

				<?php
					if($i%2 == 0){
						$size = 'col-md-6 col-sm-10 col-xs-12';
					} else{
						$size = 'col-md-6 col-md-offset-6 col-sm-10 col-sm-offset-1 col-xs-12';						
					}


					$image_url = ( $slide['slide_type'] == 'custom') 
							  ? $slide['slide_image']['sizes']['slideshow_home']
							  : (( $slide['slide_type'] == "story") 
							  ? wp_get_attachment_url( get_post_thumbnail_id( $slide['slide_story'][0]->ID, 'slideshow_home' ) )
							  : wp_get_attachment_url( get_post_thumbnail_id( $slide['slide_collection'][0]->ID, 'slideshow_home' ) ));
				?>

				<li class="background-cover background-mask-light-jank" style="background-image: url('<?php echo $image_url; ?>');">
					<div class="vertical-center container slideshow-caption-container">
						<div class="row">

					<?php switch ( $slide['slide_type'] ) { 

							case "custom":

						?>
							<div class="<?php echo $size; ?> bg-white slideshow-caption slideshow-caption-<?php echo $i;?>">
								<a href="<?php echo $slide['slide_link']; ?>">
									<h2 class="serif m0"><?php echo $slide['slide_title']; ?></h2>
									<?php if ( $desc = $slide['slide_description'] ) : ?><p class="m0"><?php echo $desc; ?></p><?php endif; ?>
									<h5 class="m1">Read more <span class="icon" data-icon="&#8222;"></span></h5>
								</a>
							</div>										

						<?php 	break;

							case "story":
						 ?>
						 	<?php $story = $slide['slide_story'][0]; ?>
							<div class="<?php echo $size; ?> slideshow-caption bg-white slideshow-caption-<?php echo $i;?>">
								<a href="#">
									<h6 class="m0">Featured Story</h6>
									<h2 class="serif m0"><?php echo $story->post_title; ?></h2>
								<?php if ( $desc = get_field( 'story_description', $story->ID ) ) : ?><p class="m0"><?php echo $desc; ?></p><?php endif; ?>	
								<h5 class="m1">Read more <span class="icon" data-icon="&#8222;"></span></h5>
								</a>
							</div>

						<?php 	break;

							case "collection":
						 ?>	
						 	<?php $coll = $slide['slide_collection'][0];?>
						 	<div class="<?php echo $size; ?> bg-white slideshow-caption slideshow-caption-<?php echo $i;?>">
								<a href="#">
									<h6 class="m0">Featured Collection</h6>
									<h2 class="serif m0"><?php echo $coll->post_title; ?></h2>
								<?php if ( $desc = get_field( 'collection_description', $coll->ID ) ) : ?><p class="m0"><?php echo $desc; ?></p><?php endif; ?>
								<h5 class="m1">Read more <span class="icon" data-icon="&#8222;"></span></h5>		
								</a>
							</div>

						<?php 	break; ?>									

					<?php } ?>

				
						<div class=" hidden col-sm-3 col-md-3 slideshow-caption-link bg-white">
							<h5 class="">Read more <span class="icon" data-icon="&#8222;"></span></h5>
						</div>
				


						</div>	
					</div>
				</li>


		<?php endforeach; ?>
		</ul>	
	
		<div class="flexslider-controls"></div> 
		
		<div id="previous-home" class="flexslider-direction flex-previous previous">
			<span class="icon" data-icon="&#8250;"></span>
		</div>					
		
		<div id="next-home" class="flexslider-direction flex-next next">
			<span class="icon" data-icon="&#8249;"></span>
		</div>	
		
	</div>		

</section>
<?php endif; ?>