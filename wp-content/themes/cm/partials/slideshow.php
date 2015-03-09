<?php if ( $slides = get_field('home_page_slideshow', 'options') ) : ?>

<section class="block crop" id="slideshow">

	<div class="flexslider flexslider-hero">
		<ul class="slides">

		<?php foreach( $slides as $i => $slide ) : ?>

				<?php


					$image_url = ( $slide['slide_type'] == 'custom') 
							  ? $slide['slide_image']['sizes']['slideshow_home']
							  : (( $slide['slide_type'] == "story") 
							  ? wp_get_attachment_url( get_post_thumbnail_id( $slide['slide_story'][0]->ID, 'slideshow_home' ) )
							  : wp_get_attachment_url( get_post_thumbnail_id( $slide['slide_collection'][0]->ID, 'slideshow_home' ) ));
				?>

				<li class="background-cover background-mask-light-broken" style="background-image: url('<?php echo $image_url; ?>');">
					<div class="vertical-center container slideshow-caption-container">
						<div class="row">

					<?php if ( $i % 2 == 0 ) : ?>
						<div class="col-sm-3 col-md-2 mt9 slideshow-caption-link bg-white">
							<h5 class="">Read more <span class="icon" data-icon="&#8222;"></span></h5>
						</div>
					<?php endif; ?>

					<?php switch ( $slide['slide_type'] ) { 

							case "custom":

						?>
							<div class="bg-white col-sm-6 col-md-4 col-md-offset-6 slideshow-caption slideshow-caption-<?php echo $i;?>">
								<a href="<?php echo $slide['slide_link']; ?>">
									<h6 class="m0"><?php echo $slide['slide_title']; ?></h6>
									<?php if ( $desc = $slide['slide_description'] ) : ?><p class="m0"><?php echo $desc; ?></p><?php endif; ?>
								</a>
							</div>										

						<?php 	break;

							case "story":
						 ?>
						 	<?php $story = $slide['slide_story'][0]; ?>
							<div class="col-sm-6 col-md-4 slideshow-caption slideshow-caption-<?php echo $i;?>">
								<a href="#">
									<h6 class="m0">Featured Story</h6>
									<h2 class="serif m0"><?php echo $story->post_title; ?></h2>
								<?php if ( $desc = get_field( 'story_description', $story->ID ) ) : ?><p class="m0"><?php echo $desc; ?></p><?php endif; ?>	
								</a>
							</div>

						<?php 	break;

							case "collection":
						 ?>	
						 	<?php $coll = $slide['slide_collection'][0];?>
						 	<div class="col-sm-6 col-md-4 slideshow-caption slideshow-caption-<?php echo $i;?>">
								<a href="#">
									<h6 class="m0">Featured Collection</h6>
									<h2 class="serif m0"><?php echo $coll->post_title; ?></h2>
								<?php if ( $desc = get_field( 'collection_description', $coll->ID ) ) : ?><p class="m0"><?php echo $desc; ?></p><?php endif; ?>		
								</a>
							</div>

						<?php 	break; ?>									

					<?php } ?>

					<?php if ( $i % 2 == 1 ) : ?>
						<div class="col-sm-3 col-md-2 mt9 slideshow-caption-link bg-white">
							<h5 class="">Read more <span class="icon" data-icon="&#8222;"></span></h5>
						</div>
					<?php endif; ?>


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