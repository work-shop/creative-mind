<section id="collections-intro" class="block target">
	<?php if(is_home() || is_single() ){ ?>
		<h3 class="centered uppercase bold m0 ">Featured Collections</h3>
	<?php } else{ ?>
		<h3 class="centered bold m0 white bg-courses uppercase<?php /* echo the category slug here, so a css style can be applied to the color of the text */ ?>">Courses</h3>
	<?php } ?>
</section>

	<?php 
	/* 
	loop through the collections on this page
	*/

	$collections = 5;
	for ($i=1; $i <= $collections; $i++) { ?>

		<?php get_template_part('partials/collection_tile'); ?>
		
	<?php } ?>

