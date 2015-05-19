<?php
	$collection = CM_Story_Controller::get_collection_for_story( $id );
	$story_type = get_field('story_media_type'); //video, image_gallery, video_gallery
?>


<header class="story-header story-header-<?php echo $story_type;?>">
	<h5 class="uppercase centered">
		<?php if ( $collection ) { echo $collection->post_title . ' / '; } the_title(); ?>
	</h5>


	<div class="story-hero <?php if($story_type == 'video_gallery'): echo 'story-hero-unmasked'; endif; ?>">

		<h1 class="m0 bold story-heading"><?php the_title(); ?></h1>
		<?php 
		switch ($story_type) {
			case 'video': ?>
				<div class="story-video-container">
				<?php if ($vimeo_id = get_field('story_vimeo_id')) : ?>	
					<div class="story-video">				
						<?php
						echo vimeo_frame($vimeo_id,'story-video-1'); 
						?>
					</div>
				<?php endif; ?>
					<div class="story-video-poster">
						<?php the_post_thumbnail('story_hero'); ?>
					</div>
				<?php if ( $vimeo_id ) : ?>
					<div class="story-video-play text-center" data-toggle="tooltip" data-placement="top" title="watch the video!">
						<span class="icon" data-icon="Ò"></span>
					</div>
				<?php endif; ?>
				</div>
			<?php break;

			case 'image_gallery': ?>
				<div class="story-hero-image-container">	
					<?php the_post_thumbnail('story_hero'); ?>
				</div>

			<?php break;

			case 'video_and_image_gallery':
			case 'video_gallery': 

				if ($clips = get_field('video_gallery')) :
				?>
				<div id="video-gallery">
					<div class="container">
						<?php foreach ( $clips as $i => $clip ) :
							if ( $i == 0 ) {
						?>
						<div class="row">
							<div class="col-sm-12 video-gallery-main mt3 mb2">
								<?php echo vimeo_frame($clip['vimeo_id'],'story-video-1'); ?>
								<h6><?php echo $clip['video_title']; ?></h6>
							</div> 
						</div>
						<?php } else { ?>
						<?php if ( $i == 1 ) : ?><div class="row"><?php endif; ?>
							<div class="col-sm-2 col-xs-6 video-gallery-clip">
								<?php echo vimeo_frame($clip['vimeo_id'],'story-video-1'); ?>
								<h6><?php echo $clip['video_title']; ?></h6>
							</div> 																											
						<?php if ( $i == count( $clips ) - 1 ) : ?></div><?php endif; ?>
						<?php } endforeach; ?>								
					</div>
				</div>
			<?php endif; ?>
			<?php break;

		       default: ?>
				<div class="story-hero-image-container">
					<?php the_post_thumbnail('story_hero'); ?>
					<!-- <img src="<?php bloginfo('template_directory');?>/assets/img/empathy.jpg" /> -->
				</div>
			<?php break;

		} 
		?>
	</div>

</header>