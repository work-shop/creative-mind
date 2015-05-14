<?php
/**
 * COLLECTION ( single-collections.php ) 
 *
 * 1. Header
 * 2. Collection Header
 * 3. Collection Stories
 * 4. Back + Share
 * 5. Footer
 *
 */
?>


<?php 

/** 1. Header */
get_header(); 

?>

<main>

	<?php 

	/** 2. Collection Header */
	get_template_part('partials/collection_header');

	?>

	<?php 

	/** 3. Collection Stories */
	get_template_part('partials/collection_stories');

	?>			

	<?php 

	/** 4. Back + Share */
	get_template_part('partials/back_and_share');


	?>	

</main>
	
<?php 

/** 5. Footer */
get_footer(); 

unset_global('current_collection' );
?>