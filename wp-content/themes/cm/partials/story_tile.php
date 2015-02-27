
<?php 

$story 		= get_global('story');
$story_index 	= get_global('story_index');
$manager 		= get_global('layout_manager');

$size 			= $manager->layout_tile( $story_index );

?>


<article class="story-tile inactive <?php echo $size; ?>" async-source=<?php echo $story->ID; ?> >
	<a href="<?php echo get_permalink( $story->ID ); // this will need to be a different URL ultimately... ?>">
		<div class="story-tile-image">
			<img src="<?php echo get_template_directory_uri();?>/assets/img/2.jpg" alt="story thumbnail" class="display-block" />
		</div>
		<div class="story-tile-overlay">
			<div class="overlay"></div>
			<h3 class="story-title story-tile-title"><?php echo $story->post_title; ?></h3>
		</div>
	</a>
</article>	