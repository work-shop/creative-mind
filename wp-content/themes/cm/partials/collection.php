
<section id="collection-intro" class="block padded-less bg-courses target">
	<div class="container">
		<div class="row">
			<div class="col-sm-10 col-sm-offset-1">
				<h2 class="centered serif bold white <?php /* echo the category slug here, so a css style can be applied to the color of the text */ ?>"><?php the_title(); ?></h2>
				<h3 class="centered white"><?php the_field('collection_description'); ?></h3>
			</div>
		</div>
	</div>
</section>


<?php get_template_part('partials/collection_tile'); ?>

