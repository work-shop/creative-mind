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

<section class="block target grid" id="grid">
	<div class="container-fluid">
	<div class="row">

	<div class="col-sm-3">
		<div class="tile tile-explore grid-item brand border-brand bg-white text-center">
			<a href="#grid" class="jump display-block"><h3 class="bold">Explore the Creative Mind</h3> <span class="icon" data-icon="&#91;"></span></a>
		</div>
</div>
	</div>
	<div class="row">		
<?php
/**
 * Now that we've done our setup, let's iterate through each category and build the grid.
 */
$col = 1;
foreach ($categories as $category) {

	?><div class="col-sm-3 grid-col  grid-col-<?php echo $col;?>"><?php

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

				<div class="tile tile-category grid-item white bg-<?php echo $category; ?>" >
					<a href="<?php echo esc_url( home_url( '/'.$category ) ); ?>">
						<header>
							<h2 class="bold mt1"><?php echo $category_name; ?></h2>
							<p><?php echo $category_description ?></p>
						</header>
						<footer class="action bold text-center bg-<?php echo $category; ?>">
							<?php echo "View $category_name"; ?>
						</footer>
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

				<div class="tile tile-story grid-item <?php echo $category; ?> border-<?php echo $category; ?>" style="background-image: url('<?php echo $story_featured_image; ?>');" >
					<a href="<?php echo $story_permalink ?>">
						<header>
							<?php if ( $story_type == 'video' ) { ?>
								<span class="icon-custom hidden" data-icon="&#xe600;"></span>
							<?php } elseif ( $story_type == 'image_gallery' ) { ?>
								<span class="icon hidden" data-icon="&#8486;"></span>
							<?php } else { ?>
								<span class="icon hidden"></span>
							<?php } ?>
							<p class="h5 m1 uppercase bold hidden"><?php echo $story_collection_name ?>:</p>
							<h2 class="bold m0"><?php echo $story_name ?></h2>
						</header>
						<footer class="action text-center bold white bg-<?php echo $category; ?>">
							<?php 
								if ( ($story_type == 'video') ) { echo "Watch Video"; } 
								elseif ( $story_type == 'image_gallery' ) { echo "View Gallery"; } 
								else { echo "View Story"; }
							?>
						</footer>
					</a>					
				</div>
		<?php } ?>
	</div>
	<?php $col++; } ?>
	</div>
	</div>

</section>

