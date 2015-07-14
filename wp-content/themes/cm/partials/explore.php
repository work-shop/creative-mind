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

<section class="block target grid padded-less" id="explore">
	<div class="container-fluid mt2">
		<div class="row">		
<?php
/**
 * Now that we've done our setup, let's iterate through each category and build the grid.
 */
$col = 1;
for ( $i = 0; $i < count( $categories ); $i++ ) {
	$category = CM_Grid_Layout_Manager::$canonical_order[ $i ];

	if($category != 'uncategorized'){

	?><div class="col-sm-3 grid-col  grid-col-<?php echo $col;?>"><?php

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

	</div>
	<?php } $col++; } ?>
	</div>
	</div>

</section>

