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

/**
 * @var $collection WP_Post | false, either the in-scope collection, or false if no collection is in scope.
 */
$collection = get_post( get_the_ID() );

?>

<footer>
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
	</section>
	<section id="back-link">
		<?php if ( is_home() ) { ?>
			<a href="#">
			<div class="h2 centered brand">
				<span class="icon-wrapper"><span class="icon" data-icon="&#8218;"></span></span>
				<span class="p1">Back to Top</span>
			</div>
			</a>
		<?php } elseif ( is_category() ) { ?>
			<a href="<?php echo esc_url( home_url() ); ?>">
			<div class="h2 centered brand">
				<span class="icon-wrapper"><span class="icon" data-icon="&#8218;"></span></span>
				<span class="p1">Home</span>
			</div>
			</a>
		<?php } elseif ( is_singular('collections') ) { ?>
			<a href="<?php echo esc_url( home_url( '/'.$category->slug ) ); ?>">
			<div class="h2 centered <?php echo $category->slug; ?>">
				<span class="icon-wrapper bg-<?php echo $category->slug; ?>"><span class="icon" data-icon="&#8218;"></span></span>
				<span class="p1">Back to <?php echo $category->name; ?></span>
			</div>
			</a>
		<?php } else { ?>
			<?php
			/**
			 * @var array(WP_Post) an array of collections that this story belongs to.
			 */
			$collection = CM_Story_Controller::get_collections_for_story( get_the_ID() )[0];
			?>

			<a href="<?php echo get_permalink( $collection->ID ); ?>">
			<div class="h2 centered <?php echo $category->slug; ?>">
				<span class="icon-wrapper bg-<?php echo $category->slug; ?>"><span class="icon" data-icon="&#8218;"></span></span>
				<span class="p1">Back to <?php echo $collection->post_title; ?></span>
			</div>
			</a>

		<?php } ?>
	</section>
</footer>




