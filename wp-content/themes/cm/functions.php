<?php

/**
 * Table of Contents ( rooted at ./library/ )
 *
 * [1]. globals.php – defines independent, globally available php functions
 * [2] abstracts – abstract classes that build common structure
 * [2.1]. abstracts/class-abstract-action-set.php – a class that scaffolds the definition of action sets encapsulating functionality
 * [2.2]. abstracts/class-abstract-filter-set.php– a class that scaffolds the definition of filter sets encapsulating functionality
 * [3] theme-options.php, acf custom theme functionality, loaded pre init
 * [4] classes – classes that encapsulate site functionality and site actions.
 * [4.1] classes/class-init-actions.php, a class that initializes state via actions on theme-load.
 * [4.2] classes/class-init-actions.php, a class that sets up init-specific filters on theme-load.
 * [4.3] classes/class_ajax.php, this class encapsulates asynchronous loading and delivery of content.
 * [4.4] classes/class_collection_controller.php, this class provides static methods for dealing with categories/collections
 * [4.5] classes/class_story_controller.php, this class provides static methods for dealing with stories
 * [4.6] DEPRACATED classes/class_tile_layout_manager, this class lays out tile grids 
 * [4.7] DEPRACATED classes/class_deterministic_layour_manager.php, this class lays out tile grids
 * [4.8] classes/class_grid_layout_manager.php, this class amalgamates data for the home page grid.
 *
 */
	
	/* [1] */
	require_once('library/globals.php');

	/* [2] */
	require_once('library/abstracts/abstract_action_set.php');
	require_once('library/abstracts/abstract_filter_set.php');

	/* [3] */
	require_once('library/theme_options.php');

	/* [4] */
	require_once( 'library/classes/class_init_actions.php' );
	require_once( 'library/classes/class_init_filters.php');
 	require_once( 'library/classes/class_ajax.php');
 	require_once( 'library/classes/class_collection_controller.php');
 	require_once( 'library/classes/class_story_controller.php');
 	// require_once( 'library/classes/class_tile_layout_manager.php');
 	// require_once( 'library/classes/class_deterministic_layout_manager.php');
 	require_once( 'library/classes/class_grid_layout_manager.php');

?>