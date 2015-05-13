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


<section class="block target share padded-less" id="share">
	<div class="container">
		<div class="row">
			<div class="col-sm-8 col-sm-offset-2">
				<h1 class="bold centered mb1">
				Share the Creativity!
				</h1>
			</div>
			<div class="col-sm-4 col-sm-offset-4 mb3">
				<div class="share-icons">
					<a class="addthis_button_facebook"><span class="icon social" data-icon="F"></span></a>
					<a class="addthis_button_twitter"><span class="icon social" data-icon="t"></span></a>
					<a class="addthis_button_email"><span class="icon social" data-icon="m"></span></a>
				</div>
			</div>
		</div>
	</div>


	<a href="<?php echo esc_url( home_url( '/'.$category->slug ) ); ?>">
	<h2 class="serif centered <?php echo $category->slug; ?>">
		<span class="p1 border-<?php echo $category->slug; ?>">Back to <?php echo $category->name; ?></span>
	</h2>
	</a>


</section>

