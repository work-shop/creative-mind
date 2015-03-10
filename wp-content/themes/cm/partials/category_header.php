<?php
	$category = CM_Collection_Controller::get_current_category();
?>
<section id="category-header" class="block target padded-less jank">
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">
				<h1 class="serif <?php echo $category->slug; ?> centered"><?php echo $category->name; ?></h1>
				<h2 class="centered <?php echo $category->name; ?>"><?php echo CM_Collection_Controller::get_category_description( $category->term_id ); ?></h2>
			</div>
		</div>
	</div>
</section>