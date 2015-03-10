
	<?php 

	//video, image_gallery, video_gallery
	$id = get_the_ID();
	$collection = get_global('collection');
	$story_type = get_field('story_media_type');

	?>

	<article class="story block target story-type-<?php echo $story_type;?>">
		<div class="story-header story-header-<?php echo $story_type;?>">
			<div class="story-hero <?php if($story_type == 'video_gallery'): echo 'story-hero-unmasked'; endif; ?>">
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
							<div class="story-video-play" data-toggle="tooltip" data-placement="top" title="watch the video!">
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
			<div class="story-meta centered">
				<div class="container">
					<div class="row">
						<div class="col-sm-10 col-sm-offset-1">
							<h1 class="m0 bold serif story-heading"><?php the_title(); ?></h1>
							<h5 class="m0 <?php echo ( $collection ) ? "" : "hidden"; ?>"><?php if ( $collection ) { echo $collection->post_title; }?></h5>
							<?php if ($description = get_field('story_description')) : ?><h2 class="m1"><?php echo $description; ?></h2><?php endif; ?>
							<?php if ($byline = get_field('story_byline')) : ?><h5 class="m0"><?php echo $byline; ?></h5><?php endif; ?>
							<?php if ($date = get_field('story_date')) : ?><h5 class="m0"><?php echo $date; ?></h5><?php endif; ?>

							<?php if ( $links = get_field('story_links') ) : ?>
							<?php foreach( $links as $link) : ?>
								<h5 class="m0"><a class="underline" href="<?php echo $link['link_url']; ?>"><?php echo $link['link_text']; ?></a></h5>
							<?php endforeach; ?>
							<?php endif; ?>

							<?php if($story_type == 'image_gallery'): ?>
								<h5 class="m0"><a class="jump" href="#story-gallery">View the Slideshow <span class="icon" data-icon="ﬁ"></span></a></h5>
							<?php endif; ?>
						</div>
					</div>
				</div>

			</div>
		</div>
		<div class="story-body">
			<div class="container">
				<?php if($gallery = get_field('story_image_gallery') ): ?>
				<div class="row m3">
					<div class="col-sm-12 col-md-10 col-md-offset-1">
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
					</div>
				</div>
				<?php endif; ?>
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

					</div>
				</div>
			</div>
		</div>
	</article>

	<?php // get_template_part('partials/break'); ?>