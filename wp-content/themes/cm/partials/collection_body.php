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
$collection_permalink = get_permalink( $collection );
$collection_description = $collection->collection_description;

/**
 *
 * @var $stories array(WP_Post) an array of stories attached to this post.
 */
$stories = CM_Collection_Controller::get_stories_for_collection( $collection );

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

<section class="block padded <?php if ( is_category() ) : echo 'well-dark'; endif; ?>">
	<div class="container-fluid mb2">
		<div class="row">
			<div class="col-sm-8 col-sm-offset-2">
				<header class="text-center mb1">
					<?php if ( is_singular( 'collections') ) { ?>
						<a href="<?php echo $collection_permalink ?>" class="<?php echo $category_nicename ?>"><h1 class="bold"><?php echo $collection_name; ?></h1></a>
						<h2><?php echo $collection_description ?></h2>
						<ul class="list-inline h5 uppercase bold mt1 mb2">
							<li><?php echo $story_qualifier ?></li>
						</ul>
					<?php } else { ?>
						<ul class="list-inline h5 uppercase bold">
							<li><a href="<?php echo $collection_permalink ?>" class="<?php echo $category_nicename ?>"><?php echo $story_qualifier ?></a></li><li><a href="<?php echo $collection_permalink ?>" class="<?php echo $category_nicename ?>">More Info</a></li><li>Share This Collection</li>
						</ul>
						<a href="<?php echo $collection_permalink ?>" class="<?php echo $category_nicename ?>"><h2 class="bold mt0 mb1"><?php echo $collection_name; ?></h2></a>
					<?php } ?>
				</header>					
			</div>
		</div>
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="flexslider-story flexslider" id="story-gallery-<?php echo rand(0,1000); ?>">
					<ul class="slides clearfix">
						<li class="slide bg-white border-<?php echo $category_nicename ?> padded-more clearfix">
							<h3 class="text-center bold">Table of Contents</h3>
							<div class="split-list">
								<?php 
									echo CM_Collection_Controller::create_list( $stories_halves[0], 1, 'collection' ); 
									echo CM_Collection_Controller::create_list( $stories_halves[1], $start, 'collection' ); 
								?>
							</div>
						</li> <!-- end .slide -->
						<?php foreach ($stories as $story) { 
							$story_name = $story->post_title;
							$story_description = $story->story_description;
							$story_type = $story->story_media_type;
							$story_permalink = get_permalink($story);
							/**
							 * @var string $story_featured_image URL of the featured image.
							 */
							$story_featured_image = ( has_post_thumbnail( $story->ID ) ) ? wp_get_attachment_image_src( get_post_thumbnail_id( $story->ID ), 'thumbnail' )[0] : 'http://images.wisegeek.com/scientists-in-lab.jpg';
						?>
							<li async-collection-slug="<?php echo $collection->post_name; ?>" async-category="<?php echo $category_nicename; ?>" async-background-image="<?php echo $story_featured_image ?>" async-slug="<?php echo $story->post_name; ?>" async-id="<?php echo $story->ID; ?>" class="slide story-slide border-<?php echo $category_nicename ?> text-center clearfix" style="background-image: url('<?php echo $story_featured_image ?>'); ">
							<a class="padded-more overlay" href="<?php echo '#' . $story->post_name; ?>" >
								<?php if ( is_singular( 'collections') ) {
									if ( $story_type == 'video' ) { echo '<p>Watch Video</p>'; }
									elseif ( $story_type == 'image_gallery' ) { echo "<p>View Gallery</p>"; } 
								} ?>
								<?php if ( $story_type == 'video' ) { ?>
									<span class="icon large" data-icon="&#210;"></span>
								<?php } elseif ( $story_type == 'image_gallery' ) { ?>
									<span class="icon large" data-icon="&#8486;"></span>
								<?php } ?>
								<h3><?php echo $story_name ?></h3>
								<?php if ( is_singular( 'collections') ) {
									echo '<p>' . $story_description . '</p>';
								} ?>
							</a>
							</li>
						 <?php } ?>
					</ul>
					<div id="flex-previous-story" class="flexslider-direction flex-previous previous">
						<span class="icon large <?php echo $category_nicename ?>" data-icon="&#8216;"></span>
					</div>					
					<div id="flex-next-story" class="flexslider-direction flex-next next">
						<span class="icon large <?php echo $category_nicename ?>" data-icon="&#8212;"></span>
					</div>								
				</div> <!-- end .flexslider -->
			</div>							
		</div> <!-- end .row -->
	</div> <!-- end .container -->
</section>