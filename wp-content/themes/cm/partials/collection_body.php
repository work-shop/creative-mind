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

<section class="block padded-less crop target collection collection-<?php echo $category_nicename; ?>">
	<div class="container-fluid">
		<header class="mb1">
	
			<?php if ( is_singular( 'collections') ) { ?>
				<div class="row">
					<div class="col-sm-12">
						<h1 class="bold m0 collection-title centered"><?php echo $collection_name; ?> <span class="ml1 uppercase story-qualifier"><?php echo $story_qualifier ?></span></h1>
					</div>		
				</div>				
				<div class="row">
					<div class="col-sm-10 col-md-8 col-sm-offset-1 col-md-offset-2">
						<h2 class="collection-description centered"><?php echo $collection_description ?></h2>
					</div>
				</div>		
				<?php } else {  ?>
				<div class="row collection-title-container">
					<div class="col-sm-12">
						<a href="<?php echo $collection_permalink ?>" class="mb1 <?php echo $category_nicename ?>">
							<h2 class="bold m0 collection-title left"><?php echo $collection_name; ?> </h2>
							<span class="h2 m0 uppercase story-qualifier left bold"><?php echo $story_qualifier ?></span>
						</a>	
					</div>
				</div>					
				<?php } ?>
		</header>

		<div class="collection-slick slick-collection">
			<div class="collection-slick-slide collection-slick-intro-slide hidden-sm hidden-xs bg-<?php echo $category_nicename ?> border-<?php echo $category_nicename ?>">
				<div class="dummy"></div>
				<div class="collection-description">
					<p class="white bold"><?php echo $collection_description ?></p>
				</div>
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

					<a class="overlay display-block>" href="<?php echo '#' . $collection->post_name . '#' . $story->post_name; ?>" >
						<div class="story-slide-info info">
							<?php if ( $story_type == 'video' ) { ?>
								<p class="story-slide-icon centered m0 mb0"><span class="icon-custom white large centered" data-icon="&#xe600;"></span></p>
							<?php } elseif ( $story_type == 'image_gallery' ) { ?>
								<p class="story-slide-icon centered m0 mb0"><span class="icon large" data-icon="&#8486;"></span></p>
							<?php } else { ?>
								<p class="story-slide-icon centered m0 mb0"><span class="icon large" data-icon="K"></span></p>
							<?php } ?>							
							<h3 class="bold white centered m0"><?php echo $story_name ?></h3>
							<p class="description white hidden"><?php echo $story_description ?></p>
						</div>
					</a>
				</div>
			<?php } ?>

		</div><!-- end .slick-collection -->
	</div>	
</section>