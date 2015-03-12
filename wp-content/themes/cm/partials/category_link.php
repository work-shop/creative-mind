<?php 

$category = get_global('collection_category'); 

if ( $category ) : 

?>

<section id="category-link" class="block target padded"><!-- href to category -->
	<a href="<?php echo esc_url( home_url( '/'.$category->slug ) ); ?>">
	<h2 class="serif centered <?php echo $category->slug; ?>">Back to <?php echo $category->name; ?></h2>
	</a>
</section>

<?php endif; ?>