<?php
	$category = CM_Collection_Controller::get_current_category();
?>
<section id="category-header" class="block target jank">
	<h2 class="serif <?php echo $category->slug; ?> centered"><?php echo $category->name; ?></h2>
	<h3 class="centered"><?php echo CM_Collection_Controller::get_category_description( $category->term_id ); ?></h3>
</section>