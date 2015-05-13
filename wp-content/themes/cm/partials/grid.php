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

		} 

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

	}
}