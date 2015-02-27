<?php

class CM_Ajax {
	public static $ns_prefix = "cm_";

	public static $actions = array(
		'get_story'
	);

	/**
	 * Constructor ( sets up action handlers )
	 */
	public function __construct() {
		foreach ( CM_Ajax::$actions as $action ) {
			add_action('wp_ajax_' . CM_Ajax::$ns_prefix . $action, array( $this, $action) );
			add_action('wp_ajax_nopriv_' . CM_Ajax::$ns_prefix . $action, array( $this, $action) );
		}
	}


	public function get_story() {
		global $post;
		$error = '<h4 class="async error vertical-center bold brand">We couldn\'t get the collection!</h4>';

		if ( !isset($_POST['story']) ) {
			die( json_encode( array(
				'error'   => $error,
			) ) );
		}

		if ( !isset($_POST['collection']) ) {
			die( json_encode( array(
				'error'   => $error,
			) ) );
		}

		$story = get_post( $_POST['story'] );
		$collection = get_post( $_POST['collection'] );

		$previous_story = CM_Story_Controller::get_previous_story_in_collection( $story->ID, $collection->ID );
		$next_story = CM_Story_Controller::get_next_story_in_collection( $story->ID, $collection->ID );

		$post = get_post( $story->ID );

		setup_postdata( $post );
		set_global('collection', $collection );

		ob_start();

		get_template_part( 'partials/story' );

		$html = ob_get_contents();
		ob_end_clean();

		unset_global('collection');

		die( json_encode( array(
			'success' 			=> true,
			'previous_story' 		=> array('title' => $previous_story->post_title, 'id' => $previous_story->ID ),
			'story_title' 		=> $story->post_title,
			'next_story'			=> array('title' => $next_story->post_title, 'id' =>  $next_story->ID),
			'post'   			=> $html
		) ) );
	}

}

new CM_Ajax();

?>