<?php
/**
 * PAGE ( page.php ) 
 *
 * 1. Header
 * 2. Page Content
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

/** 2. Page Title, Page Introduction, Page Content */
get_template_part('partials/content_page');

?>


<?php 

/** 3. Back + Share */
get_template_part('partials/back_and_share');

?>

<?php 

/** 4. Footer */
get_footer(); 

?>