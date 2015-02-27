<?php 

$category = get_global('collection_category'); 
if ( $category ) : 

?>

<section id="category-link" class="block target padded-less"><!-- href to category -->
	<h2 class="serif centered <?php echo $category->slug; ?>">Back to <?php echo $category->name; ?></h2>
</section>

<?php endif; ?>