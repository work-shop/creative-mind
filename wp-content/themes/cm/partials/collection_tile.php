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
		<div class="row">

			<?php foreach ($collection_stories as $i => $story) { ?>
				<?php if ( $featured && $i == $featured_limit ) break; ?>

				<?php if($i === 0 && !is_single()) : ?>
					
					<div class="col-sm-4">
						<article class="story-tile story-tile-collection-title col-sm-12" id="story-<?php echo $i; ?>">
							<a href="<?php echo get_permalink( $collection->ID ); ?>">
								<div class="collection-title">
									<h6 class="mt0 mb1 uppercase white"><span class="bg-<?php echo $collection_category->slug ?> h4 white category-badge"><?php echo $collection_category->name; ?> collection:</span></h6>
									<h2 class="serif">
										<?php echo $collection->post_title; ?>
									</h2>
									<h6 class="m0"><?php echo $story_count; ?>  &nbsp; View collection <span class="icon" data-icon="&#8222;"></span></h6>
								</div>
							</a>
						</article>
					</div>
					<div class="col-sm-8">
					<div class="row">

				<?php endif; ?>

				<?php 

				set_global('story', $story);
				set_global('story_index', $i);

				get_template_part('partials/story_tile'); 

				unset_global('story_index' );
				unset_global('story');

				?>

			<?php } ?>

			<?php if ( !is_single() ) : ?> </div></div> <?php endif; ?>

		</div>
	</div>
</section>

<?php
unset_global('layout_manager');
endif; 

?>

