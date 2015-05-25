<?php
/**
 * HOME > GRID (partials/grid.php)
 */

/**
 * The $grid_elements variable collects the featured items by their category. We'll set up an iterator
 * to iterate through each category in turn and display the posts in the appropriate way.
 *
 * @var array( string => array(WP_Post)) a mapping of categories to featured posts in that category.
 */
$grid_elements = CM_Grid_Layout_Manager::build_grid( );

/**
 * The categories we're working with are precisely the keys of the $grid_elements associative array.
 *
 * @var array(string) categories
 */
$categories = array_keys( $grid_elements );
?>

<section class="block target padded" id="grid">
	<div class="container-fluid">
		<div class="row m4">
			<div class="col-xs-10 col-xs-offset-1 col-sm-4 col-sm-offset-0">
				<div class="tile padded brand border-brand text-center">
					<h3 class="bold">Explore the Creative Mind</h3> <span class="icon" data-icon="&#91;"></span>
				</div>
			</div>
<?php
/**
 * Now that we've done our setup, let's iterate through each category and build the grid.
 */
foreach ($categories as $category) {
	foreach ($grid_elements[ $category ] as $i => $grid_element ) {
		if ( $i == 0 ) {

			$category_term = get_term_by( 'slug', $category, 'category' );

			/**
			 * @var string $category_name the name of this category.
			 * @var string $category_description text the name of this category.
			 */
			$category_name = $category_term->name;
			$category_description = CM_Collection_Controller::get_category_description( $category_term->term_id );
		?>

			<div class="col-xs-6 col-sm-4">
				<a href="<?php echo esc_url( home_url( '/'.$category ) ); ?>">
				<div class="tile tile-category mb2 white bg-<?php echo $category; ?> clearfix" >
					<header>
						<h2 class="bold"><?php echo $category_name; ?></h2>
						<p><?php echo $category_description ?></p>
					</header>
					<footer class="action bold text-center bg-<?php echo $category; ?>">
						<?php echo "View $category_name"; ?>
					</footer>
				</div>
				</a>
			</div>

		<?php } 

		/**
		 * @var string $story_type what type of media is present in the story? 
		 * options: "video", "video_gallery", "image_gallery", "video_and_image_gallery"
		 * @var string $story_name the post title of this story
		 * @var string $story_permalink href to the story
		 * @var string $story_collection_name the name of the colleciton to which this story belongs
		 */
		$story_type = get_field('story_media_type', $grid_element->ID );
		$story_name = $grid_element->post_title;
		$story_permalink = get_permalink( $grid_element->ID );
		$story_collection_name = CM_Story_Controller::get_collections_for_story( $grid_element->ID )[0]->post_title; 
		$story_featured_image = ( has_post_thumbnail( $grid_element->ID ) ) ? wp_get_attachment_image_src( get_post_thumbnail_id( $grid_element->ID ), 'thumbnail' )[0] : 'http://images.wisegeek.com/scientists-in-lab.jpg';
		?>

			<div class="col-xs-6 col-sm-4">
				<a href="<?php echo $story_permalink ?>">
				<div class="tile tile-story mb2 <?php echo $category; ?> border-<?php echo $category; ?>" style="background-image: url('<?php echo $story_featured_image; ?>');" >
					<header>
						<?php if ( $story_type == 'video' ) { ?>
							<span class="icon-custom" data-icon="&#xe600;"></span>
						<?php } elseif ( $story_type == 'image_gallery' ) { ?>
							<span class="icon" data-icon="&#8486;"></span>
						<?php } ?>
						<div class="h5 m0 uppercase bold"><?php echo $story_collection_name ?></div>
						<h2 class="bold m0"><?php echo $story_name ?></h2>
					</header>
					<footer class="action text-center bold white bg-<?php echo $category; ?>">
						<?php 
							if ( ($story_type == 'video') ) { echo "Watch Video"; } 
							elseif ( $story_type == 'image_gallery' ) { echo "View Gallery"; } 
							else { echo "View Story"; }
						?>
					</footer>
				</div>
				</a>
			</div>
	<?php

	}
}
?>

		</div>	
	</div>
</section>

