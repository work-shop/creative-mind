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
				'admin_menu'						=> 'remove_menus'
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
	}


	/** THEME ASSETS */
	public function enqueue_theme_assets() {
		$this->enqueue_theme_scripts();
		$this->enqueue_theme_styles();
	}

	private function enqueue_theme_scripts() {
		wp_deregister_script( 'jquery' );

		wp_register_script( 'jquery', get_template_directory_uri() . '/_/js/jquery.js');
		wp_register_script( 'jquery-viewport', get_template_directory_uri() . '/_/js/jquery.viewport.js');
		wp_register_script( 'less', get_template_directory_uri() . '/_/js/less.js');
		wp_register_script( 'bootstrap', get_template_directory_uri() . '/_/js/bootstrap.js');
		wp_register_script( 'flexslider', get_template_directory_uri() . '/_/js/flexslider.js');
		wp_register_script( 'functions', get_template_directory_uri() . '/_/js/functions.js');
		//wp_register_script( 'instafeed', get_template_directory_uri() . '/_/js/instafeed.min.js' );
		//wp_register_script( 'current', get_template_directory_uri() . '/_/js/current.js' );

		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'jquery-viewport' );
		wp_enqueue_script( 'less' );    
		wp_enqueue_script( 'bootstrap' );
		wp_enqueue_script( 'flexslider' );
		//wp_enqueue_script( 'instafeed' ); 
		wp_enqueue_script( 'functions' );
		//wp_enqueue_script( 'current', $deps = array( 'jquery', 'instafeed' ) );

	}

	private function enqueue_theme_styles() { 

		wp_register_style( 'bootstrap', get_template_directory_uri() . '/_/css/bootstrap/bootstrap.css');    

		if ( file_exists( dirname( __FILE__ ) . '/env_prod' ) ) { wp_register_style( 'style-css', get_template_directory_uri() . '/_/css/style.css'); } 
		else { wp_register_style( 'style-less', get_template_directory_uri() . '/_/css/style.less'); }

		wp_register_style( 'pictograms', get_template_directory_uri() . '/_/fonts/pictograms.css');  

		wp_enqueue_style( 'bootstrap' );   

		if ( file_exists( dirname( __FILE__ ) . '/env_prod' ) )  {  wp_enqueue_style( 'style-css' ); }
		else { wp_enqueue_style( 'style-less' ); }

		wp_enqueue_style( 'pictograms' );  

	}
	


	/** ADMIN ASSETS */
	public function remove_post_formats() { remove_theme_support('post-formats'); }

	public function login_css() { wp_enqueue_style( 'login_css', get_template_directory_uri() . '/assets/css/login.css' ); }

	public function admin_css() { wp_enqueue_style( 'admin_css', get_template_directory_uri() . '/assets/css/admin.css' ); }


	/** MENU SETTINGS */
	public function remove_menus () {
		global $menu;

		$restricted = array( __('Comments'),/*__('Tools') ,__('Posts'),__('Settings') */ );
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



