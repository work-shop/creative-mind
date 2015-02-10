<section id="collections-intro" class="block padded-less target">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
			<?php if(is_home() || is_single() ){ ?>
				<h3 class="centered serif bold brand">Featured Collections</h3>
			<?php } else{ ?>
				<h2 class="centered serif bold courses <?php /* echo the category slug here, so a css style can be applied to the color of the text */ ?>">Take a look into the inspiring and innovative research endeavors by students and faculty at Brown.</h2>
			<?php } ?>
			</div>
		</div>
	</div>
</section>

<?php 
	/* 
	loop through the collections on this page
	*/

	$collections = 5;
	for ($i=1; $i <= $collections; $i++) { ?>

		<?php get_template_part('partials/collection_tile'); ?>
		
	<?php } ?>

