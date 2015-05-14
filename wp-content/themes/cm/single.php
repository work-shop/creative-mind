<?php
/**
 * STORY ( single.php ) 
 *
 * 1. Header
 * 2. Story
 * 3. Back + Share
 * 4. Footer
 *
 */
?>

<?php 

/** 1. Header */
get_header(); 

?>

<main>

	<?php 

	/** 2. Story Content */
	get_template_part('partials/story');

	?>

	<?php 

	/** 3. Back + Share */
	get_template_part('partials/back_and_share');

	?>	

</main>

<?php 

/** 4. Footer */
get_footer(); 

?>