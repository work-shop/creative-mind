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

<section class="block padded crop target collection <?php if ( is_category() ) : endif; ?>">

	<header class="mb0">
		<?php if ( is_singular( 'collections') ) { ?>
			<a href="<?php echo $collection_permalink ?>" class="<?php echo $category_nicename ?>">
				<h1 class="bold collection-title"><?php echo $collection_name; ?></h1>
			</a>
			<h2><?php echo $collection_description ?></h2>
			<ul class="list-inline h5 uppercase bold mt1 mb2">
				<li><?php echo $story_qualifier ?></li>
			</ul>
		<?php } else { ?>
			<ul class="list-inline h4 uppercase bold hidden">
				<li><a href="<?php echo $collection_permalink ?>" class="<?php echo $category_nicename ?>"><?php echo $story_qualifier ?></a></li><li><a href="<?php echo $collection_permalink ?>" class="<?php echo $category_nicename ?>">More Info</a></li><li>Share This Collection</li>
			</ul>
			<a href="<?php echo $collection_permalink ?>" class="<?php echo $category_nicename ?>">
				<h2 class="bold mt0 mb0 collection-title"><?php echo $collection_name; ?></h2>
			</a>
		<?php } ?>
	</header>

	<div class="collection-slick slick-collection">
		<div class="collection-slick-slide collection-slick-intro-slide bg-<?php echo $category_nicename ?> border-<?php echo $category_nicename ?>">
			<h3 class="white bold"><?php echo $collection_description ?></h3>
		</div>

		<?php foreach ($stories as $story) { ?>
			<?php 	
			$story_name = $story->post_title;
			$story_description = $story->story_description;
			$story_type = $story->story_media_type;
			$story_permalink = get_permalink($story);
			$story_featured_image = ( has_post_thumbnail( $story->ID ) ) ? wp_get_attachment_image_src( get_post_thumbnail_id( $story->ID ), 'thumbnail' )[0] : 'http://images.wisegeek.com/scientists-in-lab.jpg';
			?>

			<div 
				class="story-slide collection-slick-slide collection-slick-story-slide bg-<?php echo $category_nicename ?> border-<?php echo $category_nicename ?>"
				style="background-image: url('<?php echo $story_featured_image ?>'); "
			   	async-collection-slug="<?php echo $collection->post_name; ?>" 
			   	async-category="<?php echo $category_nicename; ?>" 
			   	async-background-image="<?php echo $story_featured_image ?>" 
			   	async-slug="<?php echo $story->post_name; ?>" 
			   	async-id="<?php echo $story->ID; ?>"
			>	 
				<div class="story-slide-info info">
					<p class="media-type white bold"><?php 
						if ( $story_type == 'video' ) { echo 'Watch Video'; }
						elseif ( $story_type == 'image_gallery' ) { echo "View Gallery"; } 
					?></p>
					<?php if ( $story_type == 'video' ) { ?>
						<span class="icon-custom white large" data-icon="&#xe600;"></span>
					<?php } elseif ( $story_type == 'image_gallery' ) { ?>
						<span class="icon large" data-icon="&#8486;"></span>
					<?php } ?>
					<h3 class="bold white"><?php echo $story_name ?></h3>
					<p class="description white"><?php echo $story_description ?></p>
				</div>
			</div>
		<?php } ?>

	</div><!-- end .slick-collection -->	
</section>