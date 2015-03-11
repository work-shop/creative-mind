<?php
// general functions for use in setting up post data, etc.

// Monadic functions for echoing content to the page.
function ws_ifdef_do_else( $check, $content, $else ) {
	return ( $check || !empty($check) ) ? $content : $else;
}

function ws_ifdef_do( $check, $content ) {
	return ws_ifdef_do_else( $check, $content, "");
}

function ws_ifdef_show( $content ) {
	return ws_ifdef_do( $content, $content );
}

function ws_ifdef_concat($before, $content, $after) {
	return ws_ifdef_do( $content, $before.$content.$after );
}

function ws_split_array_by_key( $array, $delimiter, $format_function ) {
	$accumulator = "";
	if ( $array ) {
		$count = count( $array );
		foreach ( $array as $i => $tag ) { 
			if ( $i < $count - 1 ) {
				$accumulator .= $format_function($tag) . $delimiter;
			} else {
				$accumulator .= $format_function($tag);
			}
		}
	}
	return $accumulator;	
}

function ws_parity( $i, $zero, $one ) {
	return ( $i % 2 == 0 ) ? $zero : $one;
}

function ws_render_taxonomy( $taxonomy, $action ) {
	$accumulator = "";
	foreach ( $taxonomy as $i => $term ) {
		$accumulator .= $action( $term );
	}
	return $accumulator;
}

function ws_render_date( $datestring ) {
	$date = date_parse( $datestring );
	return $date['month'] . '/' . $date['day'] . '/' . $date['year'];
}

function ws_decide_image_type( $file ) {
		return '<img type="'.$file['mime_type'].'" src="'.$file['url'].'" />';
}

function ws_decide_link_type( $link ) {
	return ( !strpos($link, 'http://') ) ? $link : get_bloginfo('url').$link;
	
}

function get_template_parts( $parts = array() ) {
	foreach( $parts as $part ) {
		get_template_part( $part );
	};
}	


/**
 * Check the url-string for an accompanying get-var, and if it is set, return it
 * otherwise return false
 *
 * @param string $varname the name of the GET variable to check for
 * @return string|bool, value of get var, or failure.
 */
function get_GETVAR( $varname ) {
	return (isset( $_GET[ $varname ] ) && strlen( $_GET[ $varname ] ) > 0) ? $_GET[ $varname ] : false;
}

/**
 * Sets a new global name, just in case the global has not
 * yet been set. If it has been set, fail. This is an effort to 
 * promote judicious tracking of global values...
 *
 * @return boolean, true if set is successful, false if not
 */
function set_global( $name, $value ) {
	if ( !isset( $GLOBALS[ $name ]) ) {
		$GLOBALS[ $name ] = $value;
		return true;
	}

	return false;
}

/**
 * Reads a the value of a global name, just in case the global has been
 *  been set. If it has been set, fail. This is an effort to 
 * promote judicious tracking of global values...
 *
 * @return Mixed value of the global if successful, false if not
 */
function get_global( $name ) {
	if ( isset( $GLOBALS[ $name ]) ) {
		return $GLOBALS[ $name ];
	}

	return false;
}

/**
 * unsets an existing global name, just in case the global has 
 * been set. If it has not been set, fail. This is an effort to 
 * promote judicious tracking of global values...
 *
 * @return boolean, true if unset is successful, false if not
 */
function unset_global( $name ) {
	if ( isset( $GLOBALS[ $name ] ) ) {
		unset( $GLOBALS[ $name ] );
		return true;
	}

	return false;
}



function is_child( $parent = '' ) {
    global $post;

    $parent_obj = get_page( $post->post_parent, ARRAY_A );
    $parent = (string) $parent;
    $parent_array = (array) $parent;

    if ( in_array( (string) $parent_obj['ID'], $parent_array ) ) {
        return true;
    } elseif ( in_array( (string) $parent_obj['post_title'], $parent_array ) ) {
        return true;    
    } elseif ( in_array( (string) $parent_obj['post_name'], $parent_array ) ) {
        return true;
    } else {
        return false;
    }
}


function vimeo_frame( $vimeo_id, $player_id, $classes = '' ) {
	return '<iframe class="vimeo-video '.$classes.'" id="'.$player_id.'" src=' 
	     . '"//player.vimeo.com/video/' 
	     . $vimeo_id 
	     . '?js_api=1&player_id='
	     . $player_id
	     . '" frameborder=0 width="100%" height="100%" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
}	

/**
 */
function remove_array_value( $needle, $haystack, $once = false ) {
	$r = array();

	foreach ( $haystack as $value ) {
		if ( $needle != $value ) $r[] = $value; 
		if ( $once ) break;
	}

	return $r;
}

?>