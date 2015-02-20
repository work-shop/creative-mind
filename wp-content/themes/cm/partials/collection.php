
<section id="active-story" class="block inactive">
	<div id="active-story-loading">
		<div class="container vertical-center">
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
	<div class="container-fluid">
		<div class="row collection-intro-heading">
			<div class="col-sm-3">		
				<a class="story-toggle" href="#">
					<h5 class="serif courses bold collection-previous">
						<span class="icon" data-icon="‰"></span>	
						Previous Story: Communicating Medical Risk
					</h5>
				</a>
			</div>
			<div class="col-sm-6 collection-title">		
				<h2 class="serif courses bold centered m0">Communicating Science Through Visual Media <span class="collection-suffix bold serif">: Empathy</span></h2>
			</div>
			<div class="col-sm-3">		
				<a class="story-toggle" href="#">
					<h5 class="serif courses righted bold  collection-next">
						Next Story: Penguins
						<span class="icon" data-icon="„"></span>
					</h5>
				</a>
			</div>		
		</div>
	</div>
	<div class="container">
		<div class="row">
			<div class="col-sm-10 col-sm-offset-1">		
				<h2 class="hidden m0 centered serif bold courses <?php /* echo the category slug here, so a css style can be applied to the color of the text */ ?>">
					<span class="collection-prefix bold serif hidden">Collection:</span>
					<?php the_title(); ?>
					<span class="collection-suffix bold serif">: Empathy</span>
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

