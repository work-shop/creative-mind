<?php
/**
 * CATEGORY ( category.php ) 
 *
 * 1. Header
 * 2. Category Header
 * 3. Category Collections
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

/** 2. Category Header */
get_template_part('partials/category_header');

?>	

<?php 

/** 3. Category Collections */
get_template_part('partials/collections');

?>

<?php 

/** 4. Back + Share */
get_template_part('partials/back_and_share');

?>	
	
<?php 

/** 5. Footer */
get_footer(); 

?>