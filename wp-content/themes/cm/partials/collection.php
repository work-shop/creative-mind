
<section id="collection-intro" class="block padded-less target">
	<div class="container">
		<div class="row">
			<div class="col-sm-10 col-sm-offset-1">
				<h6 class="m0 centered courses uppercase hidden">Collection:</h6>			
				<h2 class=" m0 centered serif bold courses <?php /* echo the category slug here, so a css style can be applied to the color of the text */ ?>">
					<?php the_title(); ?>
					<span class="collection-title-story-title">: Empathy</span>
				</h2>
				<h3 class="centered courses"><?php the_field('collection_description'); ?></h3>
				<h5 class="m0 centered courses">
					In Courses, 7 Stories <span class="icon" data-icon=""></span>
				</h5>				
			</div>
		</div>
	</div>
</section>


<?php get_template_part('partials/collection_tile'); ?>

