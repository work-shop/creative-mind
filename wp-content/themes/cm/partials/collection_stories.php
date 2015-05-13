<?php
/**
 * COLLECTION > Collection Stories
 */
?>

<?php

/**
 * @var WP_Post the collection whose page we're currently on.
 */
$collection = get_post( get_the_ID() );

/**
 * @var WP_Post the category of the colleciton whose page we're currently on.
 */
$category = CM_Collections_Controller::get_category_for_collection( get_the_ID() );

/**
 * Let's set some global values and include the body of the collection.
 */

set_global( 'current_collection', $collection );
set_global( 'current_category', $category );

get_template_part('partials/collection_body');

unset_global( 'current_collection' );
unset_global( 'current_category' );

?>

