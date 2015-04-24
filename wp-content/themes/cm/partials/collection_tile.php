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

<section id="collection-<?php echo $collection->post_title; ?>" class="block collection padded target">
	<div class="container-fluid">
		<a href="<?php echo get_permalink( $collection->ID ); ?>">
		<div class="row bg-<?php echo $collection_category->slug ?> border-light padded">

			<?php foreach ($collection_stories as $i => $story) { ?>
				<?php if ( $featured && $i == $featured_limit ) break; ?>

				<?php if($i === 0 && !is_single()) : ?>
					
					<div class="centered">
							<article class="story-tile story-tile-collection-title col-sm-12 mt6" id="story-<?php echo $i; ?>">
								<div class="collection-title white">
									<?php // if(!is_category()) : ?>
										<h6 class="mt0 mb1 underline">
											<span class="uppercase"><?php echo $collection_category->name; ?> collection:</span> 
											<?php echo $story_count; ?>
										</h6>
									<?php // endif; ?>
									<h2>
										<?php echo $collection->post_title; ?>
									</h2>
									<p class="h4 col-md-8 col-md-offset-2">
										This workshop explored collaborative strategies for developing new and innovative products.
										<?php the_field('collection_description'); ?>
									</p>
								</div>
							</article>
					</div>
					<div class="col-sm-10 col-sm-offset-1">
					<div class="row">

				<?php endif; ?>

				<?php 

				set_global('story', $story);
				set_global('story_index', $i);

				//get_template_part('partials/story_tile'); 

				unset_global('story_index' );
				unset_global('story');

				?>

			<?php } ?>

			<?php if ( !is_single() ) : ?> </div></div> <?php endif; ?>

		</div>
		</a>
	</div>
</section>

<?php
unset_global('layout_manager');
endif; 

?>

