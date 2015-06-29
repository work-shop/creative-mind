
<?php if ( $slides = get_field('home_page_slideshow', 'options') ) : ?>

<section class="block crop" id="slideshow">

	<div class="slick variable-width">

		<?php foreach( $slides as $i => $slide ) : ?>

			<?php $text = true; ?>

			<?php
			$image_url = ( $slide['slide_type'] == 'custom') 
					  ? $slide['slide_image']['sizes']['slideshow_home']
					  : (( $slide['slide_type'] == "story") 
					  ? wp_get_attachment_url( get_post_thumbnail_id( $slide['slide_story'][0]->ID, 'slideshow_home' ) )
					  : wp_get_attachment_url( get_post_thumbnail_id( $slide['slide_collection'][0]->ID, 'slideshow_home' ) ));
			?>

			<div class="home-slide">
				<div class="slide-background block-background" style="background-image: url('<?php echo $image_url;?>'); "></div>
					<div class="slide-overlay">

					<?php if($text): switch ( $slide['slide_type'] ) { 

						case "custom": ?>
							<div class="slideshow-caption slideshow-caption-<?php echo $i;?>">
								<a href="<?php echo $slide['slide_link']; ?>">
									<h1 class="white bold m0"><?php echo $slide['slide_title']; ?></h1>
									<?php if ( $desc = $slide['slide_description'] ) : ?>
									<p class="m0 white hidden"><?php echo $desc; ?></p>
									<?php endif; ?>
									<h4 class=" white">Read more <span class="icon" data-icon="&#8222;"></span></h4>
								</a>
							</div>										

						<?php 	break;

						case "story": ?>
						 	<?php $story = $slide['slide_story'][0]; ?>
							<div class=" slideshow-caption slideshow-caption-<?php echo $i;?>">
								<a href="#">
									<h3 class="m0 white bold uppercase">Featured Story</h3>
									<h1 class="bold m0 white"><?php echo $story->post_title; ?></h1>
									<?php if ( $desc = get_field( 'story_description', $story->ID ) ) : ?>
									<p class="m0 white hidden"><?php echo $desc; ?></p>
									<?php endif; ?>	
									<h4 class=" white">Read more <span class="icon" data-icon="&#8222;"></span></h4>
								</a>
							</div>

						<?php 	break;

						case "collection": ?>	
						 	<?php $coll = $slide['slide_collection'][0];?>
						 	<div class="slideshow-caption slideshow-caption-<?php echo $i;?>">
								<a href="#">
									<h3 class="m0 white bold uppercase">Featured Collection</h3>
									<h1 class="bold m0 white"><?php echo $coll->post_title; ?></h1>
								<?php if ( $desc = get_field( 'collection_description', $coll->ID ) ) : ?>
									<p class="m0 white hidden"><?php echo $desc; ?></p><?php endif; ?>
									<h4 class=" white">Read more <span class="icon" data-icon="&#8222;"></span></h4>
								</a>
							</div>

						<?php 	break; ?>	
						<?php } endif; ?>
				</div>
			</div>

		<?php endforeach; ?>

	</div>	

	<div id="learn" class="scrolly">
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-12">
				<a href="#site-description" class="jump">
					<h2 class="courses centered bold mt1 mb0">Learn About The Creative Mind!</h2>
					<h6 class="centered m0"><span class="icon courses large" data-icon="ﬁ"></span></h6>
				</a>
				</div>
			</div>

		</div>
	</div>
	
</section>


<?php endif; ?>