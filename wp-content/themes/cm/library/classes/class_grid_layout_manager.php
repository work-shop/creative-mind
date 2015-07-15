<?php
/**
 * This class constructs the grid data structure for use on the front end
 * 
 */
class CM_Grid_Layout_Manager {

	public static $canonical_order = array('courses', 'projects', 'interviews', 'lectures' );


	/**
	 * 
	 * 
	 * @return array( string => WP_Post ), a map of categories to posts in that Category.
	 */
	public static function build_grid( ) {

		$featured_content = get_field('featured_content', 'option');

		$ordered_content = array();

		foreach ( $featured_content as $featured_item ) {
			if (CM_Story_Controller::is_story( $featured_item ) ) {

				$categories = CM_Story_Controller::get_categories_for_story( $featured_item->ID );
				
				$category = ($categories && !empty($categories)) ? $categories[0]->slug : 'uncategorized';

				$ordered_content[ $category ][] = $featured_item;

			} else {

				$category = CM_Collection_Controller::get_category_for_collection( $featured_item->ID );

				$ordered_content[ $category->slug ][] = $featured_item;

			}
		}

		return $ordered_content;
	}

	/**
	 * Enforces a linear ordering on the categories in the creative mind.
	 *
	 * @param object mapping category names to objects.
	 * @return in-order version of the passed object. 
	 */
	public static function order_object( $index, $object ) {
		if ( $object[ self::$canonical_order[ $index ] ] ) {
			return $object[ self::$canonical_order[ $index ] ];
		}

		return false;
	}

}


?>