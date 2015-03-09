<?php
	$slug = get_global('x_category_slug');
	$name = get_global('x_category_name');
	$desc = get_global('x_category_description');

?>

<div class="col-sm-4 sign">
	<a href="<?php bloginfo('url');?>/<?php echo $slug; ?>">
		<h3 class="serif bold centered <?php echo $slug; ?>">
		<?php echo $name; ?>
		</h3>
		<h4 class="centered">
		<?php echo $desc; ?>
		</h4>
	</a>
</div>