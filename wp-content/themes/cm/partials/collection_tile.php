<?php

$featured_limit = 7;

$collection 	= get_global('current_collection');
$featured 	= get_global('featured');

$collection_category 	= CM_Collection_Controller::get_category_for_collection( $collection->ID );
$collection_stories 	= CM_Collection_Controller::get_stories_for_collection( $collection->ID );

if ( $collection_stories ) :

	$story_count 		= CM_Collection_Controller::story_count_for_collection( $collection_stories );
	$layout_manager		= new CM_Deterministic_Layout_Manager();

	$layout_manager->reset( count($collection_stories) );

	set_global( 'layout_manager', $layout_manager );	

?>

<section id="collection-<?php echo $collection->post_name; ?>" class="block collection padded target">
	<div class="container-fluid">
		<div class="row bg-<?php echo $collection_category->slug ?> border-light padded">

			<?php foreach ($collection_stories as $i => $story) { ?>
				<?php if ( $featured && $i == $featured_limit ) break; ?>

				<?php if($i === 0 && !is_single()) : ?>
					
					<div class="centered">
							<article class="m6" id="story-<?php echo $i; ?>">
								<a href="<?php echo get_permalink( $collection->ID ); ?>"><img src="<?php bloginfo('template_directory'); ?>/assets/img/placeholder-collection.jpg" alt="<?php echo $collection->post_title; ?>"></a>
								<div class="collection-title">
									<?php // if(!is_category()) : ?>
										<h6 class="mt0 mb1 white">
											<span class="uppercase"><?php echo $collection_category->name; ?> collection:</span> 
											<?php echo $story_count; ?>
										</h6>
									<?php // endif; ?>
									<h2 class="bold white">
										<?php echo $collection->post_title; ?>
									</h2>
									<p class="h4 white">
										This workshop explored collaborative strategies for developing new and innovative products.
										<?php the_field('collection_description'); ?>
									</p>
									<ol class="col-md-12 mt2">
										<li><a class="ml1 underline bold white" href="#">Imaginary Product Development</a></li>
										<li><a class="ml1 underline bold white" href="#">Fashion Workshop</a></li>
										<li><a class="ml1 underline bold white" href="#">Storytelling Workshop</a></li>
										<li><a class="ml1 underline bold white" href="#">Bricolage Workshop</a></li>
										<li><a class="ml1 underline bold white" href="#">Material Alchemy</a></li>
									</ol>
								</div>
							</article>
					</div>

				<?php endif; ?>

				<?php 

				set_global('story', $story);
				set_global('story_index', $i);

				//get_template_part('partials/story_tile'); 

				unset_global('story_index' );
				unset_global('story');

				?>

			<?php } ?>

		</div>
	</div>
</section>

<?php
unset_global('layout_manager');
endif; 

?>

