<?php
/**
 * HOME ( index.php ) 
 *
 * 1. Header
 * 2. Site Description
 * 3. Grid
 * 4. Back + Share
 * 5. Footer
 *
 */
?>


<?php 

/** 1. Header */
get_header(); 

?>

<?php 

/** 2. Site Description */

get_template_part('partials/slideshow');

get_template_part('partials/site_description');

?>	

<?php 

/** 3. Grid */
get_template_part('partials/grid4col2');

?>	

<?php 

/** 4. Back + Share */
get_template_part('partials/back_and_share');

?>	
	
<?php 

/** 5. Footer */
get_footer(); 

?>
