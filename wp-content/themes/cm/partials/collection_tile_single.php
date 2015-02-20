
<section id="collection-single" class="block collection collection-single padded-less target">
	<div class="container">
		<div class="row">
			
			<?php /*
			loop through stories in this collection
			*/
			?>

			<?php for ($j=0; $j <= 7; $j++) { ?>

				<?php get_template_part('partials/story_tile'); ?>

			<?php } ?>

		</div>
	</div>
</section>