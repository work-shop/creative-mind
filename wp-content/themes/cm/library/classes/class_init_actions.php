<?php


class CM_Init_Actions extends WS_Action_Set {

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
			//$this->set_collections_for_story( $post );
		}

		else if ( $post->post_type == 'stories' ) {
			//$this->set_stories_for_collection( $post );
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
	 * Given a post object of type collections,
	 * Ensure that newly-added stories have this collection in their collection-set
	 *
	 * @param WP_Post $post the post to manipulate.
	 */
	private function set_collections_for_story( $post ) {
		
	}

	/**
	 * Given a post object of type collections or type stories,
	 * Ensure that newly-added collections have this story in their story-set
	 * 
	 * @param WP_Post $post the post to manipulate.
	 */
	private function set_stories_for_collection( $post ) {
		
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
		wp_register_script( 'functions', get_template_directory_uri() . '/assets/js/functions.js');

		wp_enqueue_script( 'modernizr' );
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'jquery-viewport' );
		wp_enqueue_script( 'bootstrap' );
		wp_enqueue_script( 'flexslider' );
		wp_enqueue_script( 'functions' );

		if (!file_exists( dirname( __FILE__ ) . '/env_prod' )){
			wp_register_script( 'cssrefresh', get_template_directory_uri() . '/assets/js/cssrefresh.js');
			wp_enqueue_script( 'cssrefresh' );		
		}
		else{} 		

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



