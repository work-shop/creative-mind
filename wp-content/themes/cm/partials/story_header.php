<?php
	$id = get_the_ID();
	$collection = CM_Story_Controller::get_collection_for_story( $id );
	$story_type = get_field('story_media_type'); //video, image_gallery, video_gallery
	$story_featured_image = wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) );
?>


<header class="story-header story-header-<?php echo $story_type;?>">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1">
				<h5 class="bread-crumb uppercase m1 bold centered">
					<?php if ( $collection ) { echo $collection->post_title . ' / '; } the_title() ?>
				</h5>

				<?php if ( ($story_type == 'video') && ($vimeo_id = get_field('story_vimeo_id')) ) { ?>
					<div class="video">
	 					<div class="story-video-play centered" data-toggle="tooltip" data-placement="top" title="watch the video!">
	 						<span class="icon-custom large" data-icon="&#xe600;"></span>
	 					</div>
	 					
	 					<div class="story-video-poster" style="background-image: url('<?php echo $story_featured_image ?>');"><div class="overlay padded">
	 						<h1 class="mt4 bold story-heading centered"><?php the_title(); ?></h1>
	 					</div></div>
	 					<div class="story-video">				
	 						<?php
	 						echo vimeo_frame($vimeo_id,'story-video-1'); 
	 						?>
	 					</div>
	 				</div>
	 				<?php if ($description = get_field('story_description')) : ?>
	 					<p class="mt1 h2 centered"><?php echo $description; ?></p>
	 				<?php endif; ?>	

 				<?php } elseif ( ($story_type == 'video_gallery') && ($clips = get_field('video_gallery')) ) { ?>
 					<div id="video-gallery">
 						<div class="container-fluid">
 							<div class="row">
 							<?php foreach ( $clips as $i => $clip ) :
 								if ( $i == 0 ) {
 							?>
	 								<div class="col-sm-10 video-gallery-main mt3 mb2">
	 									<?php echo vimeo_frame($clip['vimeo_id'],'story-video-1'); ?>
	 									<p><?php echo $clip['video_title']; ?></p>
	 								</div> 
	 							<?php } else { ?>
	 								<div class="col-sm-2">
		 								<div class="video-gallery-clip">
		 									<?php echo vimeo_frame($clip['vimeo_id'],'story-video-1'); ?>
		 									<p><?php echo $clip['video_title']; ?></p>
		 								</div>
		 							</div>
 								<?php } ?>
 							<?php endforeach; ?>
							</div>								
 						</div>
 					</div> <!-- end #video-gallery -->
 					<?php if ($description = get_field('story_description')) : ?>
 						<p class="mt1 h2"><?php echo $description; ?></p>
 					<?php endif; ?>		

	 			<?php } elseif ( ($story_type == 'image_gallery') && ($gallery = get_field('story_image_gallery')) ) { ?>
	 				<div class="flexslider-story flexslider" id="story-gallery">
	 					<ul class="slides clearfix">
	 						<li class="title" style="background-image: url('<?php echo $story_featured_image ?>');" data-thumb="<?php echo $story_featured_image ?>">
	 							<div class="overlay">
		 							<div class="h4 centered">Gallery</div>
		 							<div class="centered"><span class="icon large" data-icon="&#8486;"></span></div>
		 							<h1 class="m0 bold story-heading centered"><?php the_title(); ?></h1>
		 							<?php if ($description = get_field('story_description')) : ?>
		 								<p class="mt1 h2 centered"><?php echo $description; ?></p>
		 							<?php endif; ?>
		 						</div>
	 						</li>
	 						<?php foreach ($gallery as $gallery_image) { ?>
	 							<li data-thumb="<?php echo $gallery_image['sizes']['medium'] ?>">
	 							<img title="<?php echo $gallery_image['title']; ?>" src="<?php echo $gallery_image['sizes']['large'] ?>" alt="<?php echo $gallery_image['alt']; ?>"/>
	 							</li>
	 						 <?php } ?>
	 					</ul>
	 					<div class="flexslider-controls"></div> 
	 					<div id="flex-previous-story" class="flexslider-direction flex-previous previous">
	 						<span class="icon large" data-icon="&#8250;"></span>
	 					</div>					
	 					<div id="flex-next-story" class="flexslider-direction flex-next next">
	 						<span class="icon large" data-icon="&#8249;"></span>
	 					</div>								
	 				</div>
`
 				<?php } elseif ( ($story_type == 'video_and_image_gallery') && ($gallery = get_field('story_image_gallery')) && ($clips = get_field('video_gallery')) ) { ?>
 					<div id="video-gallery">
 						<div class="container-fluid">
 							<div class="row">
 							<?php foreach ( $clips as $i => $clip ) :
 								if ( $i == 0 ) {
 							?>
	 								<div class="col-sm-10 video-gallery-main mt3 mb2">
	 									<?php echo vimeo_frame($clip['vimeo_id'],'story-video-1'); ?>
	 									<p><?php echo $clip['video_title']; ?></p>
	 								</div> 
	 							<?php } else { ?>
	 								<div class="col-sm-2">
		 								<div class="video-gallery-clip">
		 									<?php echo vimeo_frame($clip['vimeo_id'],'story-video-1'); ?>
		 									<p><?php echo $clip['video_title']; ?></p>
		 								</div>
		 							</div>
 								<?php } ?>
 							<?php endforeach; ?>
							</div>								
 						</div>
 					</div> <!-- end #video-gallery -->

				<?php }  
					else { ?> 
					<h1 class="m0 bold story-heading centered"><?php the_title(); ?></h1>
					<?php if ($description = get_field('story_description')) : ?>
						<p class="mt1 h2 centered"><?php echo $description; ?></p>
					<?php endif; ?>
				<?php } //endif ?>

			</div> <!-- end .col-sm-10 -->
		</div>
	</div> <!-- end .container-fluid -->
</header>