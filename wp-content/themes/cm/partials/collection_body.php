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
 * @var string $collection_name the name of this collection
 * @var string $collection_permalink the href for this collection
 */
$collection = get_global( 'current_collection' );
$collection_name = $collection->post_title;
$collection_permalink = get_permalink( $collection->ID );

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


/*
* create a function to create display markup for list item
*** <li><a>text</a></li>
* create a new function to create list, given an array of items
* call function on first half, then call function again on 2nd half
*/

/**
 *
 * split the array of stories into two pieces. 
 * if the story count is an odd number, the first array has more items than the second. 
 *
 */
function split_stories_array( $stories ) {
	$length = count( $stories );
	$midway = ceil( $length/2 );
	$half_first = array_slice( $stories, 0, $midway );
	$half_last = array_slice( $stories, $midway, $length - $midway );
	return [$half_first, $half_last];
}

function create_list_item( $story ) {
	return '<li><a href="#">' . $story->post_title . '</a></li>';
}

function create_list( $half ) {
	$output = '';
	foreach ( $half as $story ) {
		$output = $output . create_list_item( $story );
	}
	return '<ol>' . $output . '</ol>';
}

$halves = split_stories_array( $stories );


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
				<div class="slide border-<?php echo $category_nicename ?> padded">
					<h3 class="text-center">Table of Contents</h3>
					<?php echo create_list( $halves[0] ); echo create_list( $halves[1] ) ?>
				</div> <!-- end .slide -->
			</div>							
		</div> <!-- end .row -->
	</div> <!-- end .container -->
</section>