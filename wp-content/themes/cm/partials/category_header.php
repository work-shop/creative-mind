<?php
	$category = CM_Collection_Controller::get_current_category();
?>
<section id="category-header" class="block target padded jank bg-<?php echo $category->slug;?>">
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-8 col-sm-offset-2">
				<h1 class=" serif m0 bold white <?php //echo $category->slug; ?> centered"><?php echo $category->name; ?></h1>
				<h2 class="centered white <?php echo $category->name; ?>"><?php echo CM_Collection_Controller::get_category_description( $category->term_id ); ?></h2>
			</div>
		</div>
	</div>
</section>