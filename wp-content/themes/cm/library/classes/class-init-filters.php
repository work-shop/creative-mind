<?php


class CM_Init_Filters extends WS_Filter_Set {
	
	/**
	 * Constructor
	 *
	 */
	public function __construct() {
		parent::__construct( array(
			'style_loader_tag' 		=> array( 'enqueue_less_styles', 5, 2 ),
			'upload_mimes' 			=> 'svg_mime_types'
		));
	}

	public function enqueue_less_styles($tag, $handle) {
		global $wp_styles;
		$match_pattern = '/\.less$/U';

		if ( preg_match( $match_pattern, $wp_styles->registered[$handle]->src ) ) {
			$handle = $wp_styles->registered[$handle]->handle;
			$media = $wp_styles->registered[$handle]->args;
			$href = $wp_styles->registered[$handle]->src . '?ver=' . $wp_styles->registered[$handle]->ver;
			$rel = isset($wp_styles->registered[$handle]->extra['alt']) && $wp_styles->registered[$handle]->extra['alt'] ? 'alternate stylesheet' : 'stylesheet';
			$title = isset($wp_styles->registered[$handle]->extra['title']) ? "title='" . esc_attr( $wp_styles->registered[$handle]->extra['title'] ) . "'" : '';

			$tag = "<link rel='stylesheet' id='$handle' $title href='$href' type='text/less' media='$media' />";
		}

		return $tag;
	}

	public function svg_mime_types( $mimes ) {
		$mimes['svg'] = 'image/svg+xml';
		return $mimes;
	}

}


new CM_Init_Filters();
?>