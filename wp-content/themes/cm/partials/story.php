
	<?php 

	$story_id = get_the_ID();
	$collection = CM_Story_Controller::get_collection_for_story( $id );
	$collection_id = $collection->ID;
	$story_type = get_field('story_media_type'); //video, image_gallery, video_gallery

	$previous_story_url = CM_Story_Controller::get_previous_story_in_collection( $story_id, $collection_id )->guid;
	$next_story_url = CM_Story_Controller::get_next_story_in_collection( $story_id, $collection_id )->guid;

	?>

	<article class="story block target story-type-<?php echo $story_type;?>">
		
		<?php get_template_part('partials/story_header'); ?>

		<div class="story-body">

			<div class="container-fluid">
				<div class="row">
					<div class="col-sm-10 col-sm-offset-1">
						<div class="story-meta centered">
							<?php if ($byline = get_field('story_byline')) : ?>
								<h4 class="mt0 mb1">
								<?php 
									echo $byline;
									echo '&nbsp; &nbsp;';
									if ($date = get_field('story_date')) : echo $date; endif; 
								?>
								</h4>
							<?php endif; ?>
							<?php if ( $links = get_field('story_links') ) : ?>
								<h5 class="mb2">
								<?php foreach( $links as $link) : ?>
									&nbsp; &nbsp;<a class="underline" href="<?php echo $link['link_url']; ?>"><?php echo $link['link_text']; ?></a>&nbsp; &nbsp;
								<?php endforeach; ?>
								</h5>
							<?php endif; ?>
						</div> <!-- end .story-meta -->
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12 col-sm-offset-0 col-md-10 col-md-offset-1">
						
						<?php 

						// stupid hack to avoid a weird WP-internal global null condition.
						if ( $text = get_global('formatted_content')  ) { 
							// Asynchronously Generated Context
							echo $text;
						} else if ( have_posts() ) {
							// Synchronously generated context.
							while ( have_posts() ) : the_post();
								the_content();
							endwhile;
						}

						?>

						<?php if (($cl = get_field('story_callout_link')) && ($cc = get_field('story_callout'))) : ?>
							<aside class="story-callout bg-courses white">
								<a href="<?php echo $cl; ?>">
									<h3 class="white">
									<?php echo $cc; ?>
									</h3>
								</a>
							</aside>
						<?php endif; ?>

						<?php if ( ($story_type == 'video_and_image_gallery') && ($gallery = get_field('story_image_gallery')) && ($clips = get_field('video_gallery')) ) { ?>
		 					<div class="flexslider-story flexslider" id="story-gallery">
		 						<ul class="slides clearfix">
								<?php foreach ($gallery as $gallery_image) { ?>
									<li>
									<img title="<?php echo $gallery_image['title']; ?>" src="<?php echo $gallery_image['sizes']['large'] ?>" alt="<?php echo $gallery_image['alt']; ?>"/>
									</li>
								 <?php } ?>
		 						</ul>
		 						<div class="flexslider-controls"></div> 
		 						<div id="flex-previous-story" class="flexslider-direction flex-previous previous">
		 							<span class="icon" data-icon="&#8250;"></span>
		 						</div>					
		 						<div id="flex-next-story" class="flexslider-direction flex-next next">
		 							<span class="icon" data-icon="&#8249;"></span>
		 						</div>								
		 					</div>
	 					<?php } ?>

					</div>
				</div>
			</div>

		</div> <!-- end .story-body -->

		<div class="stories-nav hidden-xs">
			<a class="prev-story" href="<?php echo $previous_story_url; ?>">
				<span class="icon" data-icon="&#8216;"></span>
			</a>
			<a class="next-story" href="<?php echo $next_story_url; ?>">
				<span class="icon" data-icon="&#8212;"></span>
			</a>
		</div>
		
	</article>

	<?php // get_template_part('partials/break'); ?>