
<?php 

$collection 		= get_global('current_collection');
$story 		= get_global('story');
$story_index 	= get_global('story_index');
$manager 		= get_global('layout_manager');

$size 			= $manager->layout_tile( $story_index );

?>


<article id="story-<?php echo $story->ID; ?>" class="story-tile inactive <?php echo $size; ?>" <?php if ( is_single() ) : ?> async-source=<?php echo $story->ID; ?> <?php endif; ?> >
	<a href="<?php echo ( $collection ) ? get_permalink( $collection->ID ).'?story='.$story->ID : "#"; ?>">
		<div class="story-tile-image">
			<?php echo get_the_post_thumbnail( $story->ID, (strstr($size, 'col-sm-6')) ? 'tile_large' : 'tile_small'); ?>
		</div>
		<div class="story-tile-overlay">
			<div class="overlay"></div>
			<h3 class="story-title story-tile-title"><?php echo $story->post_title; ?></h3>
		</div>
	</a>
</article>	