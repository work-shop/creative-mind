<?php
/**
 * ALL > BACK + SHARE (partials/back_and_share.php)
 *
 */

/**
 * This is the current category of the page. It will either be a stdClass object representing
 * a category, or a WP_Error object, if we are on an uncategorized page (ie, the home page).
 *
 * WP_Error can be tested for with the function is_wp_error( $obj ), which returns true if $obj is a WP_Error instance.
 *
 * if $category is not WP_Error, useful fields are:
 *
 * @var string $category->slug the slug of the current category
 * @var string $category->name the name of the current category
 * @var int $category->term_id the id of the current category
 */
$category = CM_Collection_Controller::get_current_category();


?>

