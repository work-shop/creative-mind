<?php
/**
 * SINGLE ( single.php ) 
 *
 * 1. Header
 * 2. Single Content
 * 3. Back + Share
 * 4. Footer
 *
 */
?>


<?php 

/** 1. Header */
get_header(); 

?>

<?php 

/** 2. Single Content */
get_template_part('partials/content_single');

?>

<?php 

/** 3. Footer */
get_footer(); 

?>