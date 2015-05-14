<?php
/**
 * PAGE ( page.php ) 
 *
 * 1. Header
 * 2. Page Header
 * 3. Page Content
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

	/** 2. Page Header */
	get_template_part('partials/page_header');

	?>

	<?php 

	/** 3. Page Content */
	get_template_part('partials/page_body');

	?>

	<?php 

	/** 4. Back + Share */
	get_template_part('partials/back_and_share');

	?>

</main>

<?php 

/** 5. Footer */
get_footer(); 

?>