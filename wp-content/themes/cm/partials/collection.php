<?php
/*
id index:

	#active-story-container 		-		put story markup here
	#previous-story-title			-		put previous title here
	#active-story-title			-		put story title here
	#next-story-label				-		put next story title here

*/

$collection = get_post( get_the_ID() );

$collection_category 	= CM_Collection_Controller::get_category_for_collection( get_the_ID() );
$collection_stories 	= CM_Collection_Controller::get_stories_for_collection( get_the_ID() );
$story_count 		= CM_Collection_Controller::story_count_for_collection( $collection_stories );

set_global('collection', $collection );
set_global('collection_category', $collection_category );
set_global('collection_stories', $collection_stories );
set_global('story_count', $story_count );

?>

<!-- <section id="active-story" class="block inactive">
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
	<div id="active-story-container" class="inactive" async-target="story">
	</div>
</section> -->

<section id="collection-header" class="block target padded jank">
	<div class="container-fluid">
		<div class="row <?php echo $collection_category->slug ?> padded">		
			<div class="centered">
				<h2 class="bold">
					<?php echo $collection->post_title; ?>
				</h2>
				<p class="h4 col-md-8 col-md-offset-2">
					<?php the_field('collection_description'); ?>
				</p>
				<ol class="col-md-12 mt1">
					<li><a class="ml1 underline bold" href="#">Imaginary Product Development</a></li>
					<li><a class="ml1 underline bold" href="#">Fashion Workshop</a></li>
					<li><a class="ml1 underline bold" href="#">Storytelling Workshop</a></li>
					<li><a class="ml1 underline bold" href="#">Bricolage Workshop</a></li>
					<li><a class="ml1 underline bold" href="#">Material Alchemy</a></li>
				</ol>
			</div>	
		</div>
	</div>
</section>


<?php get_template_part('partials/collection_tile_single'); ?>

<?php 

//unset_global( 'collection_category');
unset_global( 'collection_stories' );
unset_global( 'story_count' );

?>

