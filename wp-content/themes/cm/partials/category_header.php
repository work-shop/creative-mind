<?php
	$category = CM_Collection_Controller::get_current_category();
?>
<section id="category-header" class="block target padded jank bg-<?php echo $category->slug;?>">
	<div class="container-fluid">
		<div class="row mt2">
			<div class="col-md-10 col-md-offset-1 col-sm-8 col-sm-offset-2 centered">
				<h1 class=" m0 bold white <?php //echo $category->slug; ?>"><?php echo $category->name; ?></h1>
				<p class="col-md-10 col-md-offset-1 white <?php echo $category->name; ?>"><?php echo CM_Collection_Controller::get_category_description( $category->term_id ); ?></p>
				<ul class="col-md-12 mt2 white">
					<li><a class="ml1 underline bold white">Brown IE + MBA Program Workshops</a></li>
					<li><a class="ml1 underline bold white">Creative Mind Sponsored Projects</a></li>
					<li><a class="ml1 underline bold white">Pick-me-up Projects</a></li>
					<li><a class="ml1 underline bold white">Neuroscience Research</a></li>
					<li><a class="ml1 underline bold white">Better World By Design</a></li>
				</ul>
			</div>
		</div>
	</div>
</section>