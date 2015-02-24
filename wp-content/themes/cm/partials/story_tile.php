
<?php $random = rand(0,3); ?>
<article class="story-tile inactive <?php if($random == 2){ echo 'col-sm-4';}else{echo 'col-sm-2';}?>">
	<a href="<?php bloginfo('url' );?>/stories/imaginary-product-development">
		<div class="story-tile-image">
			<img src="<?php echo get_template_directory_uri();?>/assets/img/2.jpg" alt="story thumbnail" class="display-block" />
		</div>
		<div class="story-tile-overlay">
			<div class="overlay"></div>
			<h3 class="story-title story-tile-title"><?php the_title(); ?></h3>
		</div>
	</a>
</article>	