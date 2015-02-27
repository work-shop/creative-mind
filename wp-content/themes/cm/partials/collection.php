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

//var_dump( $collection );

?>

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
	<div id="active-story-container" class="inactive" async-target="story">
	</div>
</section>

<section id="collection-intro" class="block padded-less target">
	<div class="container-fluid">
		<div class="row collection-intro-heading">
			<div class="col-sm-3 col-xs-1">		
				<a class="story-toggle" href="#">
					<h6 class="serif <?php echo $collection_category->slug; ?> bold collection-previous">
						<span class="icon previous" data-icon="‰"></span>	
						<span class="h6 previous-story-label">Previous Story</span> 
						<span id="previous-story-title" class="previous-story-title h6 bold">: <span async-target="previous" class="next-story-title h6 bold"></span></span>
					</h6>
				</a>
			</div>
			<div class="col-sm-6 col-xs-10">		
				<h2 class="serif <?php echo $collection_category->slug; ?> bold centered m0 collection-title"><?php echo get_the_title(); ?>
				<span id="active-story-title" class="collection-suffix bold serif h2">: <span async-target="current" class="next-story-title h6 bold"></span>
				</h2>
			</div>
			<div class="col-sm-3 col-xs-1">		
				<a class="story-toggle" href="#">
					<h6 class="serif <?php echo $collection_category->slug; ?> righted bold collection-next">
						<span class="h6 next-story-label">Next Story</span> 
						<span id="next-story-title" class="next-story-title h6 bold">: <span async-target="next" class="next-story-title h6 bold"></span></span>
						<span class="icon next" data-icon="„"></span>
					</h6>
				</a>
			</div>		
		</div>
	</div>
	<div class="container">
		<div class="row">
			<div class="col-sm-10 col-sm-offset-1">		
				<h2 class="hidden m0 centered serif bold <?php echo $collection_category->slug; ?>">
					<span class="collection-prefix bold serif hidden">Collection:</span>
					<?php the_title(); ?>
					<span class="collection-suffix bold serif">: Empathy</span>
				</h2>
				<h3 class="centered <?php echo $collection_category->slug; ?>"><?php the_field('collection_description'); ?></h3>
				<h5 class="m0 centered <?php echo $collection_category->slug; ?>">
					In <?php echo $collection_category->name; ?>, <?php echo $story_count; ?> <span class="icon" data-icon="ﬁ"></span>
				</h5>				
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

