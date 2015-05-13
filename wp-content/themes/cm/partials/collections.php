<?php
/**
 * CATEGORY > Category Collections ( partials/collections.php ) 
 */
?>

<?php

/**
 * The category of the CATEGORY page that we're on.
 * 
 * @var $category stdClass, a class representing the current category, or WP_Error if something went wrong.
 *
 * if $category is not WP_Error, useful fields are:
 *
 * @var string $category->slug the slug of the current category
 * @var string $category->name the name of the current category
 * @var int $category->term_id the id of the current category
 */

$category = CM_Collection_Controller::get_current_category();

/**
 * @var $collections array(WP_Post) the set of collections in this category
 */
$collections = CM_Collection_Controller::get_collections_for_category( $category->term_id ); 

/**
 * Let's iterate through the collections, and build a tile for each one.
 * We'll note that we're viewing collections from the category page.
 */
foreach ($collections as $collection) { 

	set_global( 'is_category', true );
	set_global( 'current_category', $category );
	set_global( 'current_collection', $collection );

	get_template_part('partials/collection_body');

	unset_global( 'current_collection' );
	unset_global( 'current_category' );
} 

?>


