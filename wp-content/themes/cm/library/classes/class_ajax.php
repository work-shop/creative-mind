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

		$error = 'We couldn\'t get the story! Sorry about that.';

		if ( !isset($_POST['story']) ) {
			die( json_encode( array(
				'success' => false,
				'error'   => $error,
			) ) );
		}

		$story = get_post( $_POST['story'] );

		$post = get_post( $story->ID );

		set_global('ajax-context', true);

		setup_postdata( $post );

		ob_start();

		get_template_part( 'partials/story' );

		$html = ob_get_contents();
		
		ob_end_clean();

		unset_global('ajax-context');

		die( json_encode( array(
			'success' 			=> true,
			'title' 		=> $story->post_title,
			'post'   			=> $html
		) ) );
	}

}

new CM_Ajax();

?>