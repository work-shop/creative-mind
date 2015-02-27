<?php

/**
 * Table of Contents
 *
 * [1]. globals.php – defines independent, globally available php functions
 * [2] abstracts – abstract classes that build common structure
 * [2.1]. abstracts/class-abstract-action-set.php – a class that scaffolds the definition of action sets encapsulating functionality
 * [2.2]. abstracts/class-abstract-filter-set.php– a class that scaffolds the definition of filter sets encapsulating functionality
 * [3] theme-options.php, acf custom theme functionality, loaded pre init
 * [4] classes – classes that encapsulate site functionality and site actions.
 * [4.1] classes/class-init-actions.php, a class that initializes state via actions on theme-load.
 * [4.2] classes/class-init-actions.php, a class that sets up init-specific filters on theme-load.
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
 	require_once( 'library/classes/class_category_controller.php');
 	require_once( 'library/classes/class_story_controller.php');
 	require_once( 'library/classes/class_tile_layout_manager.php');
 	require_once( 'library/classes/class_deterministic_layout_manager.php');

?>