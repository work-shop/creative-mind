<?php
/**
 * the Collection Controller provides convenience methods 
 * pertaining to the construction of collection views.
 */

class CM_Collection_Controller {
	/**
	 * Returns the singular form of the name for the given CM category 
	 *
	 * @param stdClass Taxonomy Term 
	 * @return string
	 */
	public static function category_singular( $category ) {
		switch ( trim( strtolower( $category->slug ) ) ) {
			case "courses":
				return "Course";

			case "research":
				return "Research";

			case "interviews":
				return "Interview";

			case "lectures":
				return "Lecture";

			default:
				return false;
		}
	}

	/**
	 * This method takes a slug for a category and post-type and gives it 
	 * a human-readible description. 
	 *
	 * @param stdClass Taxonomy Term 
	 * @param string {'story' | 'collection'}
	 * @return string
	 */
	public static function slideshow_format_string( $category, $datatype ) {
		if ( trim( strtolower( $datatype ) ) == 'collection' ) {
			return $category->name . ' Collection';
		} else {
			return "Featured " . self::category_singular( $category );
		}
	}

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
	public static function story_count_for_collection( $stories, $category ) {
		switch ( ($total = count( $stories )) ) {
			case 1:
				return "1 " . (($category->name == "Research") ? "Story" : substr( $category->name, 0, count( $category->name ) - 2 ));

			default:
				return $total . (($category->name == "Research") ? " Stories" : " " . $category->name );
		}
	}


	/**
	 *
	 * This function takes a group of items and splits them into two arrays.
	 *
	 * @param array $items the items within the current group
	 * @return the two sub-arrays that make up $items
	 *
	 */
	public static function split_array( $items ) {
		$length = count( $items );
		$midway = ceil( $length/2 );
		$half_first = array_slice( $items, 0, $midway );
		$half_last = array_slice( $items, $midway, $length - $midway );
		return [$half_first, $half_last];
	}

	/**
	 *
	 * This function takes a given item and creates an html list-item for it.
	 *
	 * @param object $item an item
	 * @param string $type the type of item – either a story or a collection
	 * @return a list item containing the title of the story or collection
	 *
	 */
	public static function create_list_item( $item, $type ) {
		if ( $type == 'story' ) {
			$story_name = $item->post_title;
			return '<li>' . $story_name . '</li>';	
		}
		elseif ( $type == 'collection' ) {
			$collection_name = $item[ 'title' ];
			$collection_id = $item['id'];
			$collection_permalink = get_permalink( $collection_id );
			return '<li><a href="' . $collection_permalink . '">' . $collection_name . '</a></li>';
		} 
		elseif ( $type == "menu" ) {

			$collection_name = $item[ 'title' ];
			$collection_id = $item['id'];
			$collection_permalink = get_permalink( $collection_id );

			$output = '<li><a class="bold" href="' . $collection_permalink . '">' . $collection_name . '</a>';

			$stories = CM_Collection_Controller::get_stories_for_collection( $item['id'] );

			if ( $stories ) {
				$output .= '<ol>';

				foreach ($stories as $story) {

					$output .= '<li><a href="' . get_permalink( $story->ID ) . '">' . $story->post_title . '</a></li>';
				}

				$output .= '</ol>';

			}
			

			return $output . '</li>';

		}
	}

	/**
	 *
	 * This function takes a given half of an array and displays it as a list.
	 *
	 * @param array $half a subarray comprised of half of the array
	 * @param int $start where to begin the numbering for the ordered list
	 * @return a list containing half of the items in a group as list-items
	 *
	 */
	public static function create_list( $half, $start, $type ) {
		$output = '';
		if ( $type == 'collection' ) {
			foreach ( $half as $story ) {
				$output = $output . self::create_list_item( $story, 'story' );
			}
			return '<ol start="' . $start . '" >' . $output . '</ol>';
		}
		elseif ( $type == 'category' ) {
			foreach ( $half as $collection ) {
				$output = $output . self::create_list_item( $collection, 'collection' );
			}
			return '<ul>' . $output . '</ul>';
		}

		elseif ( $type == 'menu' ) {

			foreach ($half as $collection) {
				
				$output .= self::create_list_item( $collection, 'menu' );

			}


			return '<ul>' . $output . '</ul>';
		}
	}


	/**
	 * This function return the current category of the page as a stdClass
	 * or else WP_Error if there is none.
	 *
	 * @return stdClass('taxonomy term') || WP_Error
	 */
	public static function get_current_category() {
		if ( is_wp_error($category = $error = get_category( get_query_var( 'cat' ) ) ) ) {

			if ( is_home() ) {
				
				return $error;

			} else if ( is_singular( 'collections') ) {
				
				return self::get_category_for_collection( get_post( get_the_ID() ) );

			} else if ( is_single() || get_global('ajax-context') ) {


				
				if ( empty( $categories = CM_Story_Controller::get_categories_for_story( get_the_ID() ) ) ) {

					return $error;

				} else {

					return $categories[ 0 ];

				}

			} else {

				throw new RuntimeException('Undefined Case! Or is it??!');

			}

		} else {
			return $category;
		}
	}

	/**
	 * This function return the slug of the current category of the page
	 * or the empty string if there is none.
	 *
	 * @return string the category slug or the empty string
	 */
	public static function get_current_category_slug() {
		$category = self::get_current_category();
		if ( is_wp_error( $category ) ) return '';
		else return $category->slug;
	}



}


?>