<?php
/**
 * CATEGORY > Category Header (category_header.php)
 */
?>

<?php
	/**
	 * @var stdClass $category the current category we're in.
	 * @var string $category_name the name of the current category
	 * @var string $category_description the description of the current category
	 */
	$category = CM_Collection_Controller::get_current_category();
	$category_name = $category->name;
	$category_nicename = $category->category_nicename;
	$category_description = CM_Collection_Controller::get_category_description( $category->term_id );

	/**
	 * @var $collections array(array('title' => title, 'id' => id, 'permalink' => permalink )) the set of collections in this category.
	 */
	$collections = array_map( function( $p ) { return array(
		'id' => $p->ID,
		'title' => $p->post_title
	); }, CM_Collection_Controller::get_collections_for_category( $category->term_id ) );

	/**
	 *
	 * @var array $collections_halves contains two arrays, each containing half the collections in a category
	 * @var int $start the number of items in the first half of stories, plus 1
	 *
	*/
	$collections_halves = CM_Collection_Controller::split_array( $collections );
	$start = count($collections_halves[0]) + 1;

?>

<header class="block padded-less mb2 bg-<?php echo $category_nicename ?> white" id="category-header">
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-10 col-sm-offset-1">
				<h1 class="centered bold m0"><?php echo $category_name; ?></h1>
				<h2 class="centered mb0 mt1"><?php echo $category_description; ?></h2>
			</div>
		</div>	
		<div class="row mb2 hidden">
			<div class="col-sm-8 col-sm-offset-2">
				<div class="split-list">
					<?php 
						echo CM_Collection_Controller::create_list( $collections_halves[0], null, 'category' ); 
						echo CM_Collection_Controller::create_list( $collections_halves[1], null, 'category' ); 
					?>
				</div>
			</div>
		</div>
	</div>
</header>
