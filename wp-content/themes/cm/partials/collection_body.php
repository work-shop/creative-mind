<?php
/**
 * CATEGORY > Collection > Collection_Body | COLLECTION > Collection_Body
 */
?>

<?php
/**
 * Are we viewing the collection from the category page or the collection page?
 *
 * @var $is_category boolean true if we're on a category page
 */
$is_category = get_global( 'is_category' );

/**
 * @var stdClass $category an object refering to the current category of the collection
 */
$category = get_global( 'current_category' );
$category_name = $category->name;
$category_nicename = $category->category_nicename;

/**
 *
 * @var WP_Post $collection the post object for the current collection.
 */
$collection = get_global( 'current_collection' );
$collection_name = $collection->post_title;

/**
 *
 * @var $stories array(WP_Post) an array of stories attached to this post.
 * @var int $story_count the number of stories in this collection
 */
$stories = get_field('collection_stories', $collection->ID );
$story_count = count( $stories );

/**
 *
 * @var string $story_qualifier a nice description of the number of stories in a category.
 *
 */
$story_qualifier = CM_Collection_Controller::story_count_for_collection( $stories, $category );


/**
 *
 * @var array $stories_halves contains two arrays, each containing half the stories in a collection
 * @var int $start the number of items in the first half of stories, plus 1
 *
*/
$stories_halves = CM_Collection_Controller::split_array( $stories );
$start = count($stories_halves[0]) + 1;

?>

<section class="block padded-less">
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-6 col-sm-offset-3">
				<header class="text-center">
					<ul class="list-inline">
						<li><?php echo $story_count, '&nbsp;', $category_name; ?></li><li>Table of Contents</li><li>More Info</li><li>Share This Collection</li>
					</ul>
					<h2><?php echo $collection_name; ?></h2>
				</header>					
			</div>
		</div>
		<div class="row">
			<div class="col-sm-8 col-sm-offset-2">
				<div class="slide border-<?php echo $category_nicename ?> padded-more clearfix">
					<h3 class="text-center">Table of Contents</h3>
					<?php 
						echo CM_Collection_Controller::create_list( $stories_halves[0], 1, 'collection' ); 
						echo CM_Collection_Controller::create_list( $stories_halves[1], $start, 'collection' ); 
					?>
				</div> <!-- end .slide -->
			</div>							
		</div> <!-- end .row -->
	</div> <!-- end .container -->
</section>