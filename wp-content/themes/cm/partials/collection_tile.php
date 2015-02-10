
<section id="collection-<?php echo $i; ?>" class="block padded target">
	<div class="container">
		<div class="row">
			
			<?php /*
			loop through stories in this collection, maximum 7 in featured collections, no max in categories
			*/
			?>

			<?php for ($j=0; $j <= 7; $j++) { ?>

				<?php if($j === 0){ ?>
				
					<article class="col-sm-4 story-tile story-tile-collection-title" id="story-<?php echo $j; ?>">
						<a href="<?php the_permalink();?>">
							<h2 class="serif">
								Communicating Science Through Visual Media
							</h2>
						</a>
					</article>

				<?php } else{ ?>

					<?php get_template_part('partials/story_tile'); ?>

				<?php } ?>

			<?php } ?>

		</div>
	</div>
</section>