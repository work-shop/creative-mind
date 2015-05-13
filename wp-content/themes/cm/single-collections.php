<?php
/**
 * COLLECTION ( single-collection.php ) 
 *
 * 1. Header
 * 2. Collection Header
 * 3. Collection Stories
 * 4. Back + Share
 * 5. Footer
 * [ 6. Story Modal ]
 *
 */
?>


<?php 

/** 1. Header */
get_header(); 

?>

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
	
<?php 

/** 5. Footer */
get_footer(); 

?>