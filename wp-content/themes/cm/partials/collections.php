<div id="collections" class="target padded-less">
	<?php /*unsure about general concept of collections-intro */ ?>
	<?php 
		$category = CM_Collection_Controller::get_current_category();
		$featured = is_single() || is_home();
	?>
	<section id="collections-intro" class="block target padded-less">
		<?php if( $featured ){ ?>
			<h1 class="centered serif bold m0 ">Featured Collections</h1>
		<?php } else{ ?>

		<?php } ?>
	</section>

	<?php

	$collections = ( $featured ) 
			 ? CM_Collection_Controller::get_featured_collections() 
			 : CM_Collection_Controller::get_collections_for_category( $category->term_id ); 

	set_global( 'featured', $featured );

	foreach ($collections as $collection) { 

		set_global( 'current_collection', $collection );

		get_template_part('partials/collection_tile');

		unset_global( 'current_collection', $collection );
		
	} 

	unset_global( 'featured' );

	?>

</div>
