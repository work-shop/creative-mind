
<section id="active-story" class="block inactive">
	<div id="active-story-loading">
		<div class="container">
			<div class="row">
				<div class="col-sm-4 col-sm-offset-4">
					<div class="dots">
						<div class="dot-1 dot bg-brand"></div>
						<div class="dot-2 dot bg-brand"></div>
					</div>
				</div>
			</div>
		</div>	
	</div>
	<div id="active-story-container" class="inactive">
		<?php get_template_part('partials/story'); ?>
	</div>
</section>

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
					In Courses, 7 Stories <span class="icon" data-icon="ﬁ"></span>
				</h5>				
			</div>
		</div>
	</div>
</section>


<?php get_template_part('partials/collection_tile_single'); ?>

