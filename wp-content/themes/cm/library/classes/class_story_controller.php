<?php

class CM_Story_Controller {

	public static function is_story( $story ) {
		return $story->post_type == "stories";
	}


	/**
	 *
	 * Given the id of a story, return all the collections it belongs to.
	 *
	 */
	public static function get_collections_for_story( $story_id ) {
		return get_field('story_collections', $story_id ); 
	}


	/**
	 *
	 * From array of collections related to a story, return a single one (the first).
	 *
	 */
	public static function get_collection_for_story( $story_id ) {
		$collections = self::get_collections_for_story( $story_id );
		if ( !$collections || empty( $collections ) ) {
			return false;
		} else {
			return $collections[0];
		}
	}

	/** 
	 * Given the id of a story, produce an array of categories associated
	 * with the collections this story is assigned to.
	 *
	 * @param $story_id, int, the id of the story to collect categories for.
	 * @return array(stdClass(Term))
	 *
	 */
	public static function get_categories_for_story( $story_id ) {
		$collections = self::get_collections_for_story( $story_id );
		return array_map( function( $x ) { return CM_Collection_Controller::get_category_for_collection( $x->ID ); }, $collections );
	}

	/**
	 * Given the id of a collection and the id of a story in that collection, 
	 * get the previous adjacent story.
	 *
	 * @param int $story_id the id of the target story
	 * @param int $collection_id the int of the collection to traverse
	 * @return WP_Post object representing the previous story || false
	 */
	public static function get_previous_story_in_collection( $story_id, $collection_id ) {
		$stories = get_field( 'collection_stories', $collection_id );

		// no stories, something went wrong.
		if ( !$stories ) return false;

		foreach ( $stories as $i => $story ) {
			if ( $story->ID == $story_id ) {
				return ( $i - 1 >= 0 ) ? $stories[ $i-1 ] : $stories[ count( $stories ) - 1  ];
			}
		}

		// didn't find the story in the collection, something went wrong.
		return false;
	}

	/**
	 * Given the id of a collection and the id of a story in that collection, 
	 * get the next adjacent story.
	 *
	 * @param int $story_id the id of the target story
	 * @param int $collection_id the int of the collection to traverse
	 * @return WP_Post object representing the previous story.
	 */
	public static function get_next_story_in_collection( $story_id, $collection_id ) {
		$stories = get_field( 'collection_stories', $collection_id );

		// no stories, something went wrong.
		if ( !$stories ) return false;

		foreach ( $stories as $i => $story ) {
			if ( $story->ID == $story_id ) {
				return ( $i + 1 <= count( $stories ) - 1 ) ? $stories[ $i + 1 ] : $stories[ 0 ];
			}
		}

		// didn't find the story in the collection, something went wrong.
		return false;
	}

}




?>