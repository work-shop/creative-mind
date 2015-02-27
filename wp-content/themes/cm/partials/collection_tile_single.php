<?php
	$collection = get_global('collection');
?>

<section id="collection-single" class="block collection collection-single padded-less target" async-source=<?php echo $collection->ID; ?>>
	<div class="container">
		<div class="row">
			
			<?php 

			$collection_category 	= get_global('collection_category');
			$collection_stories 	= get_global('collection_stories');

			$layout_manager		= ( ($m = get_global( 'layout_manager' )) ) ? $m: new CM_Deterministic_Layout_Manager();

			$layout_manager->reset( count( $collection_stories ) );

			set_global( 'layout_manager', $layout_manager );

			?>

			<?php foreach ($collection_stories as $i => $story) { ?>

				<?php 

				set_global('story', $story);
				set_global('story_index', $i);

				get_template_part('partials/story_tile'); 

				unset_global('story_index' );
				unset_global('story');

				?>

			<?php } ?>

		</div>
	</div>
</section>