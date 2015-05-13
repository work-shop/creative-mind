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

?>

<?php

/**
 *
 * @var string $story_qualifier a nice description of the number of stories in a category.
 *
 */
$story_qualifier = CM_Collection_Controller::story_count_for_collection( $stories, $category );

?>

<?php

foreach ( $stories as $i => $story ) {
	if ( $i == 0 ) {
		/**
		 *
		 * @var array( array('title'=>string, 'id' => int) ) an in-order array of the titles
		 * and ids of the stories in this collection. this is a convenience variable over the $stories
		 * array, which contains the same information, and more.
		 *
		 * You'll have to iterate over one of these arrays and construct the output for the title slide here.
		 *
		 */
		$story_titles = array_map( function( $p ) { return array( 
			'title' => $p->post_title,
			'id' => $p->ID
		); }, $stories );

	}

  	/**
	 * @var string $story_type what type of media is present in the story? 
	 * options: "video", "video_gallery", "image_gallery", "video_and_image_gallery"
	 * @var string $story_name the post title of this story
	 * @var string $story_permalink href to the story
	 */
	$story_type = get_field('story_media_type', $story->ID );
	$story_name = $story->post_title;
	$story_permalink = get_permalink( $story->ID );
	
}

?>