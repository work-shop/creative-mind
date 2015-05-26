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

<section class="block target padded-less mt6" id="back-share">
	<div class="container-fluid mb5">
		<div class="row">
			<div class="col-sm-10 col-sm-offset-1">
				<div class="container-fluid">
					<div class="row">
						<div class="col-sm-6" id="back-link">
							<?php if ( is_home() ) { ?>
								<div class="h2 bold centered brand">
								<a href="#">
									<span class="icon-wrapper bg-brand"><span class="icon white" data-icon="&#8218;"></span></span>
									<span class="text">Back to Top</span>
								</a>
								</div>
							<?php } elseif ( is_category() ) { ?>
								<div class="h2 bold centered brand">
								<a href="<?php echo esc_url( home_url() ); ?>">
									<span class="icon-wrapper bg-brand"><span class="icon white" data-icon="&#8218;"></span></span>
									<span class="text">Home</span>
								</a>
								</div>
							<?php } elseif ( is_singular('collections') ) { ?>
								<div class="h2 bold centered <?php echo $category->slug; ?>">
								<a href="<?php echo esc_url( home_url( '/'.$category->slug ) ); ?>">
									<span class="icon-wrapper bg-<?php echo $category->slug; ?>"><span class="icon white" data-icon="&#8218;"></span></span>
									<span class="text">Back to <?php echo $category->name; ?></span>
								</a>
								</div>
							<?php } else { ?>
								<?php
								/**
								 * @var array(WP_Post) an array of collections that this story belongs to.
								 */
								$collection = CM_Story_Controller::get_collections_for_story( get_the_ID() )[0];
								?>

								<div class="h2 bold centered">
								<a href="<?php echo get_permalink( $collection->ID ); ?>">
									<span class="icon-wrapper bg-white <?php echo $category->slug ?>"><span class="icon" data-icon="&#8218;"></span></span>
									<span class="text">Back to <?php echo $collection->post_title; ?></span>
								</a>
								</div>

							<?php } ?>
						</div> <!-- end #back-link" -->
						<div class="col-sm-6" id="share-links">
							<?php if ( is_home() ) { ?>
								<h2 class="bold centered brand">
								Share the Creativity!
								</h2>
								<div class="share-icons">
									<a class="addthis_button_facebook bg-brand white"><span class="icon social" data-icon="F"></span></a>
									<a class="addthis_button_twitter bg-brand white"><span class="icon social" data-icon="t"></span></a>
									<a class="addthis_button_email bg-brand white"><span class="icon social" data-icon="m"></span></a>
								</div>
							<? } elseif ( is_singular('stories') ) { ?>	
								<h2 class="bold centered white">
								Share the Creativity!
								</h2>
								<div class="share-icons">
									<a class="addthis_button_facebook bg-white"><span class="icon social <?php echo $category->slug ?>" data-icon="F"></span></a>
									<a class="addthis_button_twitter bg-white"><span class="icon social <?php echo $category->slug ?>" data-icon="t"></span></a>
									<a class="addthis_button_email bg-white"><span class="icon social <?php echo $category->slug ?>" data-icon="m"></span></a>
								</div>
							<? } else { ?>
								<h2 class="bold centered <?php echo $category->slug ?>">
								Share the Creativity!
								</h2>
								<div class="share-icons">
									<a class="addthis_button_facebook bg-<?php echo $category->slug ?>"><span class="icon social white" data-icon="F"></span></a>
									<a class="addthis_button_twitter bg-<?php echo $category->slug ?>"><span class="icon social white" data-icon="t"></span></a>
									<a class="addthis_button_email bg-<?php echo $category->slug ?>"><span class="icon social white" data-icon="m"></span></a>
								</div>
							<?php } ?>
						</div> <!-- end #share-links -->
					</div>
				</div> <!-- end .container-fluid -->
			</div>
		</div>
	</div> <!-- end .container-fluid -->
</section>

