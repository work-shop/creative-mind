<?php
/**
 * the Collection Controller provides convenience methods 
 * pertaining to the construction of collection views.
 */

class CM_Collection_Controller {
	/**
	 * This method returns the description of the given category by that category's id tag.
	 *
	 * @param int $id the term_id of the category in question
	 * @return string, the description of the category with term_id = $id
	 */
	public static function get_category_description( $id ) {
		switch( $id ) {

			case 6: //research
				return get_field('research_description', 'options');

			case 7: //interviews
				return get_field('conversations_description', 'options');

			case 8: //courses
				return get_field('courses_description', 'options');

			case 9: //lectures
				return get_field('lectures_description', 'options');

			default:
				return "Unrecognized Category.";
		}
	}

	/**
	 * This method delivers an in-order array of
	 * the collections that are currently
	 * featured on the site.
	 *
	 * @return an array(WP_Post(type='collections')) objects
	 */
	public static function get_featured_collections() {
		return get_field('featured_collections', 'option');
	}

	/**
	 * This method delivers an in-order array of
	 * the collections that are currently contained in
	 * the category specified by cat.
	 *
	 * @param string $category the id of the category to retrieve collections for.
	 * @return an array(WP_Post(type='collections', category=$category)) objects
	 */
	public static function get_collections_for_category( $category ) {
		$posts = get_posts( array(
			'posts_per_page' => -1,
			'category' => $category,
			'orderby' => 'menu_order',
			'post_type' => 'collections'
		));
		return $posts;
	}

	// public static function get_collections_by_topology() { // cool idea...

	// }

	/**
	 * returns the category of a given collection indicated by it's id.
	 *
	 * @param int $id the id of the collection to retrieve categories for.
	 * @return a taxonomy term, the category of the collection.
	 */
	public static function get_category_for_collection( $collection_id ) {
		return get_the_category( $collection_id )[0];
	}

	/**
	 * returns the stories present in a given collection.
	 *
	 * @param int $id the id of the collection to retrieve stories for.
	 * @return an array of WP_Post objects representing stories.
	 */
	public static function get_stories_for_collection( $collection_id ) {
		return get_field( 'collection_stories', $collection_id );
	}

	/**
	 * returns a pretty string describing the number of stories in
	 * the collection.
	 *
	 * @param array(WP_Post) $stories the stories in this collection
	 * @return pretty printed string
	 */
	public static function story_count_for_collection( $stories ) {
		switch ( ($total = count( $stories )) ) {
			case 1:
				return "1 Story";

			default:
				return $total . " Stories";
		}
	}

	/**
	 * This function return the current category of the page as a stdClass
	 * or else WP_Error if there is none.
	 *
	 * @return stdClass('taxonomy term') || WP_Error
	 */
	public static function get_current_category() {
		return get_category( get_query_var( 'cat' ) );
	}

	/**
	 * This function return the slug of the current category of the page
	 * or the empty string if there is none.
	 *
	 * @return string the category slug or the empty string
	 */
	public static function get_current_category_slug() {
		$category = get_category( get_query_var( 'cat' ) );
		if ( is_wp_error( $category ) ) return '';
		else return $category->slug;
	}



}


?>