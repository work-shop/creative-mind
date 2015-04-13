<?php


class CM_Init_Actions extends WS_Action_Set {

	/**
	 * @var array(string => string) $field_keys, an ACF lookup table of field_names to field keys.
	 */
	public static $field_keys = array(
		'story_collections' => 'field_54cbc00606362',
		'collection_stories' => 'field_54cba3508d3c7'
	);

	/**
	 * Constructor
	 */
	public function __construct() {
		show_admin_bar(false);

		parent::__construct(
			array(
				'init' 							=> 'create_post_types',
				'wp_enqueue_scripts' 					=> 'enqueue_theme_assets',
				'after_theme_setup'					=> array( 'remove_post_formats', 11, 0 ),
				'login_head'						=> 'login_css',
				'admin_head'						=> 'admin_css',
				'admin_menu'						=> 'remove_menus',
				'save_post'							=> 'ensure_consistency'
		));
	}

	/** POST TYPES */
	public function create_post_types() {
		register_post_type( 'collections',
			array(
				'labels' => array(
					'name' => 'Collections',
					'singular_name' =>'Collection',
					'add_new' => 'Add New',
				    'add_new_item' => 'Add New Collection',
				    'edit_item' => 'Edit Collection',
				    'new_item' => 'New Collection',
				    'all_items' => 'All Collections',
				    'view_item' => 'View Collection',
				    'search_items' => 'Search Collections',
				    'not_found' =>  'No Collections found',
				    'not_found_in_trash' => 'No Collections found in Trash', 				
				),
				'public' => true,
				'has_archive' => true,
				'rewrite' => array('slug' => 'collections'),
				'supports' => array( 'title', 'thumbnail'),		
				'taxonomies' => array( 'category' )				
		));

		register_post_type( 'stories',
			array(
				'labels' => array(
					'name' => 'Stories',
					'singular_name' =>'Story',
					'add_new' => 'Add New',
				    'add_new_item' => 'Add New Story',
				    'edit_item' => 'Edit Story',
				    'new_item' => 'New Story',
				    'all_items' => 'All Stories',
				    'view_item' => 'View Story',
				    'search_items' => 'Search Stories',
				    'not_found' =>  'No Stories found',
				    'not_found_in_trash' => 'No Stories found in Trash', 				
				),
				'public' => true,
				'has_archive' => true,
				'rewrite' => array('slug' => 'stories'),
				'supports' => array( 'title', 'thumbnail', 'editor')
		));

		if ( function_exists( 'add_theme_support' ) ) {
			add_theme_support( 'post-thumbnails' );
		    	set_post_thumbnail_size( 300, 150, true ); 
		}
		if ( function_exists( 'add_image_size' ) ) { 
			add_image_size( 'tile_small', 300, 150, true );  	
			add_image_size( 'tile_large', 600, 330, true );  
			add_image_size( 'story_hero', 1440, 768, true );  					
			add_image_size( 'slideshow_home', 1440, 600, true );  
		}

	}

	/** POST CONSISTENCY */
	/**
	 * Given the post_id of a collection or story, this routine ensures that the given
	 * post's included-in or included list is consistent in both directions.
	 *
	 * @param int $post_id
	 */
	public function ensure_consistency( $post_id ) {
		$post = get_post( $post_id );

		if ( $post->post_type == 'collections' ) {
			$this->set_collection_category( $post );
			$this->set_collections_for_story( $post_id );
		}

		else if ( $post->post_type == 'stories' ) {
			$this->set_stories_for_collection( $post_id );
		}

	}

	/**
	 * Given a post object of type collections,
	 * Ensure that the selected category is reflected in the built in a category.
	 * Additionally, ensure that no collection is in more than one category.
	 *
	 * @param WP_Post $post the post to manipulate.
	 */
	private function set_collection_category( $post ) {
		$c1 = get_field('collection_category', $post->ID );
		$c2 = ( $c1 ) ? get_category_by_slug( $this->normalize_category_slug( $c1 ) ) : false;

		if ( $c2 ) wp_set_post_categories( $post->ID, $c2->term_id, false );
	}

	/**
	 * Given a backend-entered category slug, normalize it to the slug name for the desired category
	 *
	 * @param string $category_name the name of the category to return the slug for
	 * @return the desired category slug.
	 */
	private function normalize_category_slug( $category_name ) {
		return $category_name;
	}

	/**
	 *
	 * Given a post object of type collections,
	 * Ensure that newly-added stories have this collection in their collection-set
	 *
	 * @param WP_Post $post the post to manipulate.
	 *
	 */
	private function set_collections_for_story( $post_id ) {
		$this->set_xs_for_ys_with_y( 'story_collections', 'collection_stories', $post_id );
	}

	/**
	 * Given a post object of type collections or type stories,
	 * Ensure that newly-added collections have this story in their story-set
	 * 
	 * @param int $post_id the id of the post to manipulate.
	 */
	private function set_stories_for_collection( $post_id ) {
		$this->set_xs_for_ys_with_y( 'collection_stories', 'story_collections', $post_id );
	}

	/**
	 * This is a GENERAL database consistency routine that ensures bidirectional consistency across a pair
	 * of mutually inverse one->many relationship. Effectively, it maintains a many<->many relationship accross
	 * post types in the database
	 *
	 * @param string $xs name of the set to normalize
	 * @param string $ys name of the normal set
	 * @param string $y name of the element in the normal set to manipulate.
	 */
	private function set_xs_for_ys_with_y( $xs, $ys, $y ) { // story_collections, collection_stories, collection_id 
		global $wpdb;

		/* 	[1.]
			This query will establish our frame condition, ensuring that we select any and ALL
			xs affected by this update. We may as well save time and 
			select their y-sets as well. 
 		*/
		$all_xs = $wpdb->get_results(
			$wpdb->prepare( 
				"SELECT post_id, meta_value FROM $wpdb->postmeta
			  	  WHERE meta_key = %s
			  	  AND meta_value LIKE %s",
			  	  $xs, "%" . $y . "%"
			), ARRAY_N
		);

		/* 	[2.]
			Now that we have all the xs that are affected by this update, [the frame condition],
			We can ensure that they're still consistent with the affected y record,
			and operate on them accordingly.
 		*/
		$y_xs 		= ( $cll = get_field( self::$field_keys[ $ys ], $y ) ) 
					? array_map( function( $x ) { return $x->ID; }, $cll) 
					: array();

		$found_xs		= array();

		foreach ( $all_xs as $an_x ) {
			
			$x_id = $an_x[0];
			$x_ys = unserialize( $an_x[ 1 ] );

			array_push( $found_xs, $x_id );
			if ( 
			      !in_array($x_id, $y_xs) 	
			   && in_array($y, $x_ys ) 		
			) {
				/* this given x is no longer in the y's xs, but still in the x's ys. remove it. */
				$x_ys = remove_array_value($y, $x_ys);
			}

			else if ( 
				in_array($x_id, $y_xs) 
			  && !in_array($y, $x_ys )
			) {
				/* this given x is in the y's xs, but not in the x's ys. add it. */
				$x_ys[] = $y; 
			}

			update_field( self::$field_keys[ $xs ], $x_ys, $x_id );
		}

		/*	[3.]
			Finally, we need to add this y to any xs that didn't previously have it. To do this,
			we take the difference of the ys (representing the normal set), and the xs
			we've found. Any xs in this difference represent xs we haven't discovered yet, and need to update.

			NB: ACF does not like it if a field is uninitialized. To circumvent this, we use field_keys, not field names, as throughout.
		 */

		foreach ( array_diff($y_xs, $found_xs) as $x_id ) {
			$x_ys = ( $coll = get_field( $xs, $x_id ) ) ? $coll : array();
			$x_ys[] = $y;
			update_field( self::$field_keys[ $xs ], $x_ys, $x_id );
		}

		/*	[4.]
			At this point, the data should be consistent, IE:
		
			all x : xs, y : ys . [ x : xs( y ) <=> y : ys( x ) ]
			

		 */
	}


	/** THEME ASSETS */
	public function enqueue_theme_assets() {
		$this->enqueue_theme_scripts();
		$this->enqueue_theme_styles();
	}

	private function enqueue_theme_scripts() {
		wp_deregister_script( 'jquery' );

		wp_register_script( 'modernizr', get_template_directory_uri() . '/assets/js/modernizr.js');
		wp_register_script( 'jquery', get_template_directory_uri() . '/assets/js/jquery.js');
		wp_register_script( 'jquery-viewport', get_template_directory_uri() . '/assets/js/jquery.viewport.js');
		wp_register_script( 'bootstrap', get_template_directory_uri() . '/assets/js/bootstrap.js');
		wp_register_script( 'flexslider', get_template_directory_uri() . '/assets/js/flexslider.js');
		wp_register_script( 'vimeo', '//f.vimeocdn.com/js/froogaloop2.min.js');
		//wp_register_script('vimeo', get_template_directory_uri() . '/assets/js/froogaloop.js');
		wp_register_script( 'functions', get_template_directory_uri() . '/assets/js/functions.js');
		wp_register_script('header-click', get_template_directory_uri() . '/assets/js/header-click.js' );

		wp_enqueue_script( 'modernizr' );
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'jquery-viewport' );
		wp_enqueue_script( 'bootstrap' );
		wp_enqueue_script( 'flexslider' );
		wp_enqueue_script( 'vimeo' );
		wp_enqueue_script( 'functions' );
		wp_enqueue_script( 'header-click' );

		wp_localize_script( 'functions', 'async', array('url' => admin_url('admin-ajax.php') ) );

		if (!file_exists( dirname( __FILE__ ) . '/env_prod' )){
			wp_register_script( 'cssrefresh', get_template_directory_uri() . '/assets/js/cssrefresh.js');
			wp_enqueue_script( 'cssrefresh' );		
		}		

	}

	private function enqueue_theme_styles() { 
		wp_register_style( 'bootstrap', get_template_directory_uri() . '/assets/css/bootstrap/bootstrap.css');    
		wp_register_style( 'pictograms', get_template_directory_uri() . '/assets/fonts/pictograms.css');  
		wp_register_style( 'style', get_template_directory_uri() . '/assets/css/style.css');
		
		wp_enqueue_style( 'bootstrap' );   
		wp_enqueue_style( 'pictograms' );
		wp_enqueue_style( 'style' );   
	}	


	/** ADMIN ASSETS */
	public function remove_post_formats() { remove_theme_support('post-formats'); }

	public function login_css() { wp_enqueue_style( 'login_css', get_template_directory_uri() . '/assets/css/login.css' ); }

	public function admin_css() { wp_enqueue_style( 'admin_css', get_template_directory_uri() . '/assets/css/admin.css' ); }


	/** MENU SETTINGS */
	public function remove_menus () {
		global $menu;

		$restricted = array( __('Comments'),__('Posts')/*__('Tools'),__('Settings') */ );
		end ($menu);

		while (prev($menu)){
			$value = explode(' ',$menu[key($menu)][0]);
			if(in_array($value[0] != NULL?$value[0]:"" , $restricted)){unset($menu[key($menu)]);}
		}

		$this->remove_acf_menu();
	}


	private function remove_acf_menu(){
	    // provide a list of usernames who can edit custom field definitions here
	    $admins = array( 
	        'dev','greg','nic'
	    );
	 
	    // get the current user
	    $current_user = wp_get_current_user();
	 
	    // match and remove if needed
	    if( !in_array( $current_user->user_login, $admins ) )
	    {
	        remove_menu_page('edit.php?post_type=acf');
	    }
	 
	}

}


new CM_Init_Actions();



