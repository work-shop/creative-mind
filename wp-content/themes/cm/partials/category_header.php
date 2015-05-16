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

?>

<header class="block padded bg-<?php echo $category_nicename ?> white">
	<div class="container-fluid">
		<div class="row mt4 mb2">
			<div class="col-sm-10 col-sm-offset-1">
				<h1 class="centered"><?php echo $category_name; ?></h1>
				<p class="centered"><?php echo $category_description; ?></p>
			</div>
		</div>	
		<div class="row mb2">
			<div class="col-sm-8 col-sm-offset-2">
				<ul>
<?php

	/**
	 * @var $collections array(array('title' => title, 'id' => id, 'permalink' => permalink )) the set of collections in this category.
	 */
	$collections = array_map( function( $p ) { return array(
		'id' => $p->ID,
		'title' => $p->post_title
	); }, CM_Collection_Controller::get_collections_for_category( $category->term_id ) );

	/**
	 * Let's iterate through all the collections in teh category and construct a list.
	 */
	foreach ( $collections as $collection ) {
		$collection_name = $collection[ 'title' ];
		$collection_id = $collection['id'];
		$collection_permalink = get_permalink( $collection_id );
	?>
					<li><?php echo $collection_name; ?></li>
	<?php } ?>
				</ul>
			</div>
		</div>
	</div>
</header>