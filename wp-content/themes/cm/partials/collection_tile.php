
<section id="collection-<?php echo rand(0,25); ?>" class="block collection padded target">
	<div class="container">
		<div class="row">
			
			<?php /*
			loop through stories in this collection, maximum 7 in featured collections, no max in categories
			*/
			?>

			<?php for ($j=0; $j <= 7; $j++) { ?>

				<?php if($j === 0){ ?>
				
					<?php if(!is_single()): ?>
						<article class="story-tile story-tile-collection-title col-sm-4" id="story-<?php echo $j; ?>">
							<a href="<?php bloginfo('url' );?>/collections/communicating-science-through-visual-media">
								<div class="collection-title">
									<h2 class="serif">
										Communicating Science Through Visual Media
									</h2>
									<h6 class="m0">In Courses, 7 Stories</h6>
									<h6 class="m0">View collection <span class="icon" data-icon="&#8222;"></span></h6>
								</div>
							</a>
						</article>
					<?php endif; ?>


				<?php } else{ ?>

					<?php get_template_part('partials/story_tile'); ?>

				<?php } ?>

			<?php } ?>

		</div>
	</div>
</section>