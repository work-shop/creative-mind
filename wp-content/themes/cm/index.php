<?php
/**
 * HOME ( index.php ) 
 *
 * 1. Header
 * 2. Site Description
 * 3. Grid
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

/** 2. Site Description */
get_template_part('partials/site_description');

?>	

<?php 

/** 3. Grid */
get_template_part('partials/grid');

?>	

<?php 

/** 4. Back + Share */
get_template_part('partials/back_and_share');

?>	
	
<?php 

/** 5. Footer */
get_footer(); 

?>
