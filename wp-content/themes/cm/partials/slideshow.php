<?php if ( $slides = get_field('home_page_slideshow', 'options') ) : ?>

<section class="block mb6" id="slideshow">

	<div class="flexslider flexslider-hero">
		<ul class="slides">

		<?php foreach( $slides as $i => $slide ) : ?>

				<?php  if($i == 0): ?>

					<!-- <li class="background-cover"> -->

					<?php //  get_template_part('partials/logo_animated'); ?>

					<!-- </li> -->


				<?php endif; ?>

				<?php
					if($i%2 == 0){
						$size = 'col-md-4 col-md-offset-1 col-sm-6 col-sm-offset-1 col-xs-10 col-xs-offset-1';
					} else{
						$size = 'col-md-4 col-md-offset-7 col-sm-6 col-sm-offset-5 col-xs-10 col-xs-offset-1';						
					}


					$image_url = ( $slide['slide_type'] == 'custom') 
							  ? $slide['slide_image']['sizes']['slideshow_home']
							  : (( $slide['slide_type'] == "story") 
							  ? wp_get_attachment_url( get_post_thumbnail_id( $slide['slide_story'][0]->ID, 'slideshow_home' ) )
							  : wp_get_attachment_url( get_post_thumbnail_id( $slide['slide_collection'][0]->ID, 'slideshow_home' ) ));
				?>

				<li style="background-image: url('<?php echo $image_url; ?>');">
					<div class="vertical-center container slideshow-caption-container">
						<div class="row">

					<?php switch ( $slide['slide_type'] ) { 

							case "custom":

						?>
							<div class="bg-white <?php echo $size; ?>slideshow-caption slideshow-caption-<?php echo $i;?>">
								<a href="<?php echo $slide['slide_link']; ?>">
									<h3 class="m0"><?php echo $slide['slide_title']; ?></h3>
									<p class="m1">Watch Videos</p>
								</a>
							</div>										

						<?php 	break;

							case "story":
						 ?>
						 	<?php $story = $slide['slide_story'][0]; ?>
							<div class="bg-white border-courses <?php echo $size; ?> slideshow-caption slideshow-caption-<?php echo $i;?>">
								<a href="#">
									<h6 class="underline">Featured Story</h6>
									<h3 class="m0"><?php echo $story->post_title; ?></h3>
									<p class="m1">Watch Videos</span></p>
								</a>
							</div>

						<?php 	break;

							case "collection":
						 ?>	
						 	<?php $coll = $slide['slide_collection'][0];?>
						 	<div class="bg-white border-courses <?php echo $size; ?> slideshow-caption slideshow-caption-<?php echo $i;?>">
								<a href="#">
									<h6 class="underline">Featured Course</h6>
									<h3 class="m0"><?php echo $coll->post_title; ?></h3>
									<p class="m1">Watch Videos</span></p>		
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
			<span class="icon" data-icon="&#8216;"></span>
		</div>					
		
		<div id="next-home" class="flexslider-direction flex-next next">
			<span class="icon" data-icon="&#8212;"></span>
		</div>	
		
	</div>		

</section>
<?php endif; ?>