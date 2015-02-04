<?php
/*
Plugin Name: ReOrder Post Within Categories
Plugin URI:   http://www.deefuse.fr/wordpress/nouveau-plugin-reorder-post-within-categories
Description: Arrange Post and Custom Post Type through drag & drop interface of selected category (or custom taxonomies).
Version: 1.1.6
Author: Aurélien Chappard
Author URI: http://www.deefuse.fr/
License: GPLv2
Copyright: Aurélien Chappard
Text Domain: deefusereorder
Domain Path: /languages
*/

if( !class_exists('ReOrderPostWithinCategory') ) {
    class ReOrderPostWithinCategory {
	public $adminOptionsName = "deefuse_ReOrderSettingAdminOptions";
	public $orderedCategoriesOptionName = "deefuse_ReOrderOrderedCategoriesOptions";
	
	public $deefuse_ReOrder_db_version = "1.0";
	public $deefuse_ReOrder_dbOptionVersionName = "deefuse_ReOrder_db_version";
	public $deefuse_ReOrder_tableName = "reorder_post_rel";
	
	public $custom_cat = 0;
	public $stop_join = false;
	
	/**
	 * Constructor
	 */
	function ReOrderPostWithinCategory() {
	    load_plugin_textdomain('deefusereorder', false, basename(dirname(__FILE__)) . '/languages');
	    
	    // hook for activation
	    register_activation_hook( __FILE__ , array(&$this, 'reOrder_install') );

	    // hook for desactivation
	    register_deactivation_hook( __FILE__ , array(&$this, 'reOrder_uninstall') );
	
	    // Link to the setting page
	    $plugin = plugin_basename(__FILE__); 
	    add_filter("plugin_action_links_$plugin", array(&$this,'display_settings_link') );

	    //Action qui sauvegardera le paamétrage du plugin
	    add_action('init', array(&$this, 'saveOptionPlugin'));
	    // Ajout de la page de paramétrage du plugins
	    add_action('admin_menu', array(&$this, 'add_setting_page'));
	    
	    // Ajout des pages de classement des post pour les post et custom post type concernés
	    add_action('admin_menu', array(&$this, 'add_order_pages'));
	    
	    add_action('wp_ajax_cat_ordered_changed', array(&$this, 'cat_orderedChangeTraiment'));
	    add_action('wp_ajax_user_ordering', array(&$this, 'user_orderingTraiment'));
	    
	    add_action( 'save_post', array(&$this, 'savePost_callBack') );
	    add_action ('before_delete_post', array(&$this, 'deletePost_callBack'));
	    add_action ('trashed_post', array(&$this, 'deletePost_callBack'));
	     
	    add_action('deleteUnecessaryEntries', array(&$this, 'deleteUnecessaryEntries_callBack'));
	    
	    if(!is_admin()){
		add_filter('posts_join', array(&$this, 'reOrder_query_join'));
		add_filter('posts_where', array(&$this, 'reOrder_query_where'));
		add_filter('posts_orderby', array(&$this, 'reOrder_query_orderby'));
	    }
	}
	
	public function reOrder_query_join($args){
	    
	    global $wpdb,$wp_query;
	    
	    $table_name = $wpdb->prefix . $this->deefuse_ReOrder_tableName;
	    
	    $queriedObj = $wp_query->get_queried_object();
	    
	    $category_id = $queriedObj->slug;
	    $theID = $queriedObj->term_id;
	    
	    
	    if(!$category_id) {
		$category_id = $this->custom_cat;
	    }
	    
	    $userOrderOptionSetting = $this->getOrderedCategoriesOptions();
	    if($userOrderOptionSetting[$theID] == "true" && $this->stop_join == false){
		$args .= " INNER JOIN $table_name ON ".$wpdb->posts.".ID = ".$table_name.".post_id and incl = 1  ";
		//echo $args;
	    }
	    
	    return $args;
	}
	public function reOrder_query_where($args){
	    global $wpdb,$wp_query;
	    
	    $table_name = $wpdb->prefix . $this->deefuse_ReOrder_tableName;
	    
	    $queriedObj = $wp_query->get_queried_object();
	    
	    $category_id = $queriedObj->slug;
	    $theID = $queriedObj->term_id;
	    
	    
	    if(!$category_id) {
		$category_id = $this->custom_cat;
	    }
	    
	    $userOrderOptionSetting = $this->getOrderedCategoriesOptions();
	    if($userOrderOptionSetting[$theID] == "true" && $this->stop_join == false){
		//$args .= " INNER JOIN $table_name ON ".$wpdb->posts.".ID = ".$table_name.".post_id and incl = 1  ";
		$args .= " AND $table_name".".category_id = '".$theID."'";
		//echo $args;
	    }
	    
	    return $args;
	}
	public function reOrder_query_orderby($args){
	    global $wpdb,$wp_query;
	    
	    $table_name = $wpdb->prefix . $this->deefuse_ReOrder_tableName;
	    
	    $queriedObj = $wp_query->get_queried_object();
	    
	    $category_id = $queriedObj->slug;
	    $theID = $queriedObj->term_id;
	    
	    
	    if(!$category_id) {
		$category_id = $this->custom_cat;
	    }
	    
	    $userOrderOptionSetting = $this->getOrderedCategoriesOptions();
	    if($userOrderOptionSetting[$theID] == "true" && $this->stop_join == false){
		$args = $table_name.".id ASC";
		
	    }
	    
	    return $args;
	}
	
	
	/**
	 * A la suppression d'un post, on supprime toutes les entrée dans notre table
	 * @param type $post_id
	 */
	public function deletePost_callBack($post_id){
	    global $wpdb;
	    $table_name = $wpdb->prefix . $this->deefuse_ReOrder_tableName;
	    $sql = $wpdb->prepare("DELETE FROM $table_name WHERE (post_id =%d)", $post_id);
	    $wpdb->query($sql);
	}
	/**
	 * Lorsque l'on enregistre un post, on a plusieurs actions à mener.
	 * On regarde toutes les taxonomies associés à celui-ci.
	 * @param type $post_id
	 */
	public function savePost_callBack($post_id)
	{
	    //verify post is not a revision
	    if ( !wp_is_post_revision( $post_id ) ) {
		global $wpdb;
		
		$table_name = $wpdb->prefix . $this->deefuse_ReOrder_tableName;
		
		
		// Type de post
		$post_type = get_post_type($post_id);
		$post_type = get_post_type_object($post_type);
		//echo "<h1>Enregistrement d'un article ".$post_type->name."</h1>";
		// Liste des taxonomies associée à ce post
		$taxonomies = get_object_taxonomies($post_type->name, 'objects');
		
		if(count($taxonomies) > 0){
		    //echo "<p>On liste maintenant toutes les taxonomies associé au post_type <strong>".$post_type->name.'</strong></p>';
		    //echo '<ul>';
		    $orderedSettingOptions = $this->getAdminOptions();
		    $orderedSettingOptions = $orderedSettingOptions['categories_checked'][$post_type->name];
		    
		    // Pour chaque taxonomie associé au CPT, on ne liste que celles qui ont la propriété hierarchical égale à 1 (ie comme les catégorie)
		    foreach ($taxonomies as $taxonomie){
			
			if($taxonomie->hierarchical == 1 && is_array($orderedSettingOptions) && in_array($taxonomie->name, $orderedSettingOptions)){
			     //echo "<li>".$taxonomie->name."</li>";
			     $terms = get_terms( $taxonomie->name );
			     
			     $terms_of_the_post = wp_get_post_terms( $post_id, $taxonomie->name );
			     $term_ids_of_the_post = wp_list_pluck( $terms_of_the_post, 'term_id' );
			     //echo "<pre>";
			     //print_r($terms);
			     //echo "</pre>";
			     if (count($terms) > 0){
				 //echo "<ul>";
				 foreach ($terms as $term){
				     //$terms_of_the_post = wp_get_post_terms( $post_id, $taxonomie->name );
				     //echo "<li>";
					//echo "<p>--" . $term->name . " (" . $term->term_id .")</p>";
					//if(in_array($term, $terms_of_the_post))
					if(in_array($term->term_id, $term_ids_of_the_post))
					{
					    $trieEnCoursEnDb = $wpdb->get_var( $wpdb->prepare("SELECT COUNT(*) FROM $table_name WHERE category_id=%d", $term->term_id) );
					    if($trieEnCoursEnDb != 0)
					    {
						$nbligne = $wpdb->get_var( $wpdb->prepare("SELECT COUNT(*) FROM $table_name WHERE post_id=%d AND category_id=%d", $post_id, $term->term_id) );
						if($nbligne == 0){
						    $wpdb->insert(
							$table_name,
							array(
							    'category_id'	=> $term->term_id,
							    'post_id'	=> $post_id
							)
						    );
						}
					    }
					}
					else
					{   
					    $wpdb->query( $wpdb->prepare("DELETE FROM $table_name WHERE post_id=%d AND category_id=%d", $post_id, $term->term_id) );
					    // Une fois supprimé, on regarde combien il reste de post en base dont on trie;
					    //S'il reste moins de deux poste, alors on le supprime
					    $nbPostRestant =  $wpdb->get_var( $wpdb->prepare("SELECT COUNT(*) FROM $table_name WHERE category_id=%d", $term->term_id) );
					    if($nbPostRestant < 2){
						$wpdb->query( $wpdb->prepare("DELETE FROM $table_name WHERE category_id=%d", $term->term_id) );
					    }
					   // echo "Il reste encore ".$nbPostRestant." pour ce trie là";
					}
				     //echo "</li>";
				 }
				 //echo "</ul>";
			     }
			}			
		     }
		     //echo '</ul>';
		}
	    }
	}
	/**
	 * Launched when the plugin is being activated
	 */
	public function reOrder_install()
	{
	   global $wpdb;
	   $table_name = $wpdb->prefix . $this->deefuse_ReOrder_tableName;
	   $sqlCreateTable = "CREATE TABLE IF NOT EXISTS $table_name (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`category_id` int(11) NOT NULL,
				`post_id` int(11) NOT NULL,
				`incl` tinyint(1) NOT NULL DEFAULT '1',
				PRIMARY KEY (`id`)
		    ) ;";
	   require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	   dbDelta($sqlCreateTable);
	   
	   add_option($this->deefuse_ReOrder_dbOptionVersionName, $this->deefuse_ReOrder_db_version);
	}
	
	/**
	 * Launched when the plugin is being desactivated
	 */
	public function reOrder_uninstall()
	{
	    global $wpdb;
	    $table_name = $wpdb->prefix . $this->deefuse_ReOrder_tableName;

	    $sqlDropTable = "DROP TABLE IF EXISTS $table_name";
	    $wpdb->query($sqlDropTable);
	    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	    dbDelta($sqlDropTable);
	    
	    delete_option($this->deefuse_ReOrder_dbOptionVersionName);
	    
	    $sqlClearOption = "delete from  wp_options where option_name like 'deefuse_ReOrder%'";
	    $wpdb->query($sqlClearOption);
	    dbDelta($sqlClearOption);
	}
	
	public function user_orderingTraiment()
	{
	    if( !isset($_POST['deefuseNounceUserOrdering']) || !wp_verify_nonce($_POST['deefuseNounceUserOrdering'], 'nonce-UserOrderingChange') )
		return;
	    
	    global $wpdb;
	    $order = explode(",",$_POST['order']);
	    $category = $_POST['category'];
	    
	    $table_name = $wpdb->prefix . $this->deefuse_ReOrder_tableName;
	    $total = $wpdb->get_var( $wpdb->prepare("select count(*) as total from `$table_name` where category_id = %d", $category) );
	    
	    // Si la catégorie n'a pas encore été classée
	    if($total == 0)
	    {
		foreach($order as $post_id) {
		    $value[] = "($category, $post_id)";
		}
		$sql = sprintf("insert into $table_name (category_id,post_id) values %s", implode(",",$value));
	        $wpdb->query($sql);
	    }
	    else
	    {
		$results = $wpdb->get_results($wpdb->prepare("select * from `$table_name` where category_id = %d order by id", $category));
		foreach($results as $index => $result_row) {
		    $result_arr[$result_row->post_id] = $result_row;
		}
		$start = 0;
		foreach($order as $post_id) {
		    $inc_row = $result_arr[$post_id];
		    $incl = 1; //$inc_row->incl; @toto
		    $row = $results[$start];
		    ++$start;
		    $id = $row->id;
		    $sql = $wpdb->prepare("update $table_name set post_id = %d,incl = %d where id = %d",$post_id, $incl, $id);
		    $wpdb->query($sql);
		}
	    }
	    
	    
	    
	    die();
	}
	
	
	public function cat_orderedChangeTraiment()
	{
	    if( !isset($_POST['deefuseNounceOrder']) || !wp_verify_nonce($_POST['deefuseNounceOrder'], 'nonce-CatOrderedChange') )
		return;
	    
	    $orderedSettingOptions = $this->getOrderedCategoriesOptions();	  
	    $orderedSettingOptions[$_POST['current_cat']] = $_POST['valueForManualOrder'];
	    update_option($this->orderedCategoriesOptionName, $orderedSettingOptions);
	    
	    // Toujours laisser le die() final;
	    die();
	}
	
	
	/**
	 * Returns an array of admin options
	 */
	public function getAdminOptions() {
	    $adminOptions = array();
	    $settingsOptions = get_option($this->adminOptionsName); 
	    if (!empty($settingsOptions)) {
		    foreach ($settingsOptions as $key => $option)
			    $adminOptions[$key] = $option;
	    }
	    update_option($this->adminOptionsName, $adminOptions);
	    return $adminOptions;
	}
	
	public function getOrderedCategoriesOptions(){
	    $orderedOptions = array();
	    $orderedSettingOptions = get_option($this->orderedCategoriesOptionName);
	    if(!empty($orderedSettingOptions)){
		foreach ($orderedSettingOptions as $key => $option)
		    $orderedOptions[$key] = $option;
	    }
	    update_option($this->orderedCategoriesOptionName, $orderedOptions);
	    return $orderedOptions;
	}
	
	/**
	 * Fonction qui affiche les pages de classement des posts pour les post et cutsom post type concernée
	 * (éléments cochés dans la page paramétrage du plugin);
	 */
	public function add_order_pages()
	{
	    //On liste toutes les catégorie dont on veut avoir la main sur le trie
	    $settingsOptions = $this->getAdminOptions();

	    //On liste tous les Post Type et leur catégorie associé
	    $post_types = get_post_types( array( 'show_in_nav_menus' => true, 'hierarchical' => false ), 'object' );
	    if( $post_types ) :
		// Pour chaque post_type, on regarde s'il y a des options de trie associé
		foreach ( $post_types as $post_type ) {
		    if (isset($settingsOptions['categories_checked'][$post_type->name])){
			if($post_type->name != "post"){
			    $the_page =  add_submenu_page('edit.php?post_type='.$post_type->name, 'Re-order', 'Reorder', 'manage_options', 're-orderPost-'.$post_type->name, array(&$this,'printOrderPage'));
			}
			else
			{
			    $the_page = add_submenu_page( 'edit.php', 'Re-order', 'Reorder', 'manage_options', 're-orderPost-'.$post_type->name, array(&$this,'printOrderPage'));
			}
			add_action('admin_head-'. $the_page, array(&$this,'myplugin_admin_header'));
		    }
		}
	    endif;
	}
	public function myplugin_admin_header()
	{
	   wp_enqueue_style( "reOrderDeefuse", plugins_url('style.css', __FILE__) );
	   wp_enqueue_script('deefusereorderAjax', plugin_dir_url(__FILE__).'js/reorderAjax.js', array('jquery'));
	   wp_enqueue_script( 'jquery-ui-sortable', '/wp-includes/js/jquery/ui/jquery.ui.sortable.min.js', array('jquery-ui-core', 'jquery-ui-mouse'), '1.8.20', 1 );
	   wp_localize_script('deefusereorderAjax', 'deefusereorder_vars', array(
	       'deefuseNounceCatReOrder' =>  wp_create_nonce('nonce-CatOrderedChange'),
	       'deefuseNounceUserOrdering' =>  wp_create_nonce('nonce-UserOrderingChange')
	   ));
	}
	public function deleteUnecessaryEntries_callBack(){
	   //Pour chaque catégorie non cochée, on efface toutes les entrées en base qui ont
	    // comme categoy_id les term->id des catégory non cochée...
	    $post_types = get_post_types( array( 'show_in_nav_menus' => true,'public'=>true, 'show_ui'=>true, 'hierarchical' => false ), 'object' );
	    $categories_checked = $this->getAdminOptions();
	    $categories_checked = $categories_checked['categories_checked'];
	    
	    $taxoPostToDelete = array();
	    if( $post_types ) :
		foreach ( $post_types as $post_type ) {
		    $taxonomies = get_object_taxonomies($post_type->name, 'objects');
		    if(count($taxonomies) > 0){
			foreach ($taxonomies as $taxonomie){
			    if($taxonomie->hierarchical == 1){

				if(isset($categories_checked[$post_type->name])){
				    if(!in_array($taxonomie->name, $categories_checked[$post_type->name])){
					$taxoPostToDelete[] = $taxonomie->name;
				    }
				}else{
				    $taxoPostToDelete[] = $taxonomie->name;
				}

			    }
			}
		    }
		}
	    endif;

	    $cat_to_delete_in_db = array();
	    $listTerms = get_terms($taxoPostToDelete);
	    foreach ($listTerms as $term){
		$cat_to_delete_in_db[] = $term->term_id;
	    }

	    $nbCatToDelete = count($cat_to_delete_in_db);

	     global $wpdb;
	      $table_name = $wpdb->prefix . $this->deefuse_ReOrder_tableName;
	    if($nbCatToDelete > 0)
	    {
		$sql = "DELETE FROM $table_name WHERE (";

		for($d = 0; $d < $nbCatToDelete ; $d++){
		    if($d > 0)
		    {
			$sql .= "OR";
		    }
		    $sql .= sprintf( " (category_id = %d) ", $cat_to_delete_in_db[$d]);
		}

		$sql.= ")";
		$wpdb->query($sql);		    
	    }

	    $nbligne = $wpdb->get_var( "SELECT COUNT(*) FROM $table_name" );
	    if($nbligne == 0){ 
		$sql = "ALTER TABLE $table_name AUTO_INCREMENT =1";
		$wpdb->query($sql);	
	    }
	}
	public function saveOptionPlugin()
	{
	    // Si le formulaire a été soumis, on ré-enregistre les catégorie dont on veut trier les éléments
	    if ( !empty($_POST) && isset($_POST['nounceUpdateOptionReorder']) && wp_verify_nonce($_POST['nounceUpdateOptionReorder'],'updateOptionSettings') )
	    {
		if (isset($_POST['selection'])) {
		    $categories_checked = $_POST['selection'];
		}
		else
		{
		    $categories_checked = array();
		}
		
		
		$settingsOptions['categories_checked'] = $categories_checked;
		
		update_option($this->adminOptionsName, $settingsOptions);
	    }
	}
	
	
	public function printOrderPage()
	{
	    // On récupère le VPT sur lequel on travaille
	    $page_name = $_GET['page'];
	    $cpt_name = substr($page_name, 13, strlen($page_name));
	    $post_type = get_post_types(array('name' => $cpt_name), 'objects');
	    $post_type_detail  = $post_type[$cpt_name];
	    unset($post_type, $page_name, $cpt_name);
	    
	    // On charge les préférences
	    $settingsOptions = $this->getAdminOptions();
	    
	    // Si le formulaire a été soumis
	    if ( !empty($_POST) && check_admin_referer('loadPostInCat', 'nounceLoadPostCat') && isset($_POST['nounceLoadPostCat']) && wp_verify_nonce($_POST['nounceLoadPostCat'],'loadPostInCat') )
	    {
		if (isset($_POST['cat_to_retrive']) && !empty($_POST['cat_to_retrive']) && $_POST['cat_to_retrive'] != null) {
		    $cat_to_retrieve_post = $_POST['cat_to_retrive'];
		    $taxonomySubmitted = $_POST['taxonomy'];
		    
		    // Si il y a une catégorie
		    if($cat_to_retrieve_post > 0)
		    {
			global $wpdb;
			
			// On sélectionne les posts trie dans notre table pour la catégorie concerné.
			$table_name = $wpdb->prefix . $this->deefuse_ReOrder_tableName;
			$sql = $wpdb->prepare("select * from $table_name where category_id = '%d' order by id", $cat_to_retrieve_post);
			$order_result = $wpdb->get_results($sql);
			$nbResult = count($order_result);
			
			for($k =0 ;$k < $nbResult; ++$k) {
			    $order_result_incl[$order_result[$k]->post_id] = $order_result[$k]->incl;
			}
			
			// arguments pour la requete des post de la catégory $taxonomySubmitted classé dans la taxonomy d'id $category;
			$args = array(
				'tax_query' => array(
						    array('taxonomy' => $taxonomySubmitted, 'operator' => 'IN', 'field' => 'id', 'terms' => $cat_to_retrieve_post)
					    ),
				'posts_per_page'			=> -1,
				'post_type'       => $post_type_detail->name,
				'orderby'            => 'title',
				'post_status'     => 'publish',
				'order' => 'ASC' 	
			);


			$this->stop_join = true;
			$this->custom_cat = $cat_to_retrieve_post;
			$query = new WP_Query( $args );
			$this->stop_join = false;
			$this->custom_cat = 0;
			$posts_array = $query->posts;
			
			// Création d'un tableau dont les clé sont les ID des posts et les valeur les posts eux-même
			$temp_order = array();
			for($j = 0; $j < count($posts_array); ++$j) {
			   $temp_order[$posts_array[$j]->ID] = $posts_array[$j];
			}
			
		    }
		}
		
	    }
	    ?>
	    <div class="wrap">
	    	<div class="icon32 icon32-posts-<?php echo $post_type_detail->name;?>" id="icon-edit"><br></div>
		<h2><?php echo sprintf(__('Tri des articles de type "%s"', 'deefusereorder'), $post_type_detail->labels->menu_name); ?></h2>
		<p>
		    <?php echo sprintf(__('Sélectionner une catégorie pour trier les articles de type <b>%s</b>. ','deefusereorder'), $post_type_detail->labels->name);?>
		</p>
		
		<form method="post" id="chooseTaxomieForm">
		<?php
		    wp_nonce_field('loadPostInCat','nounceLoadPostCat');
		    $listCategories = $settingsOptions['categories_checked'][$post_type_detail->name];
		    
		    $taxonomies= '';
		    $taxonomy= '';
		    $term_selected = '';
		    if(count($listCategories) > 0)
		    {
			echo '<select id="selectCatToRetrieve" name="cat_to_retrive">';
			echo '<option value="null" disabled="disabled" selected="selected">Selectionner</option>';
			$catDisabled = false;
			foreach($listCategories as $categorie){
			    $taxonomies = get_taxonomies(array('name'=> $categorie), 'object');
			    $taxonomy = $taxonomies[$categorie]; 

			    // On liste maintenant les terms disponibles pour la taxonomie concernée
			    $list_terms = get_terms( $taxonomy->name );
			    if(count($list_terms) > 0)
			    {
				echo '<optgroup id="'.$taxonomy->name.'" label="'.$taxonomy->labels->name.'">';
				    foreach ($list_terms as $term)
				    {
					$selected = '';
					if( isset($cat_to_retrieve_post) && ($cat_to_retrieve_post == $term->term_id))
					{
					    $selected = ' selected = "selected"';
					    $term_selected = $term->name;
					}
					$disabled = '';
					if($term->count < 2){
					    $disabled = ' disabled = "disabled"';
					    $catDisabled = true;
					}
					echo '<option' . $selected . $disabled.' value="'.$term->term_id.'">' . $term->name . '</option>';
				    }
				echo '</optgroup>';
			    }


			}
			echo '</select>';
			if($catDisabled)
			    echo '<br/><span class="description">' . __('Les catégories grisées ne sont pas accessibles au tri car elle ne contiennent pas assez d\'articles pour le moment. ','deefusereorder') .'</span>';
			    
			$valueTaxonomyField = ( isset($taxonomySubmitted) ? $taxonomySubmitted : '' );
			echo '<input type="hidden" id="taxonomyHiddenField" name="taxonomy" value="'.$valueTaxonomyField.'"/>';
		    }

		?>
		</form>
		<form id="form_result" method="post">
		<?php
		    if(isset($posts_array))
		    {
			echo '<div id="result">';
			echo '<div id="sorter_box">';
			    echo '<h3>' . __('Utiliser le tri manuel pour cette catégorie ?', 'deefusereorder') .'</h3>';
			    echo '<div id="catOrderedRadioBox">';
				
				// on regarde si un des radio est coché
				$checkedRadio1 = '';
				$checkedRadio2 = ' checked = "checked"';
				$orderedSettingOptions = $this->getOrderedCategoriesOptions();
				if(isset($orderedSettingOptions[$cat_to_retrieve_post]) && $orderedSettingOptions[$cat_to_retrieve_post] == 'true')
				{
				    $checkedRadio1 = $checkedRadio2;
				    $checkedRadio2 = '';
				}
				 
				echo '<label for="yes"><input type="radio"'.$checkedRadio1.' class="option_order" id="yes" value="true" name="useForThisCat"/> <span>'.__('Oui', 'deefusereorder').'</span></label><br/>';
				echo '<label for="no"><input type="radio"'.$checkedRadio2.' class="option_order" id="no" value="false" name="useForThisCat"/> <span>'.__('Non', 'deefusereorder').'</span></label>';
				echo '<input type="hidden" name="termID" id="termIDCat" value="'.$cat_to_retrieve_post.'">';
				echo '<span class="spinner" id="spinnerAjaxRadio"></span>';
			    echo '</div>';
			   
			    echo '<h3 class="floatLeft">' . sprintf(__('Listes des articles de type "%s", classé dans la catégorie "%s" :', 'deefusereorder'), $post_type_detail->labels->name, $term_selected) . '</h3>';
			    echo '<span id="spinnerAjaxUserOrdering" class="spinner"></span><div class="clearBoth"></div>';
			echo '<ul id="sortable-list" class="order-list" rel ="'.$cat_to_retrieve_post.'">';
		    
			// On liste les posts du tableau $posts_array pour le trie
			for($i = 0; $i < count( $order_result); ++$i) {
			    $post_id = $order_result[$i]->post_id;
			    $post = $temp_order[$post_id];
			    unset($temp_order[$post_id]);
			    $od = $order_result_incl[$post->ID];
			    
			    echo '<li id="'.$post->ID.'">';
			    echo '<span class="title">'.$post->post_title.'</span>';
			    echo '</li>';
			}
			
			// On liste maintenant les posts qu'il reste et qui ne sont pas encore dans notre table
			foreach($temp_order as $temp_order_id => $temp_order_post) {
			    $post_id = $temp_order_id;
			    $post = $temp_order_post;
			    
			    echo '<li id="'.$post->ID.'">';
			    echo '<span class="title">'.$post->post_title.'</span>';
			    echo '</li>';
			    
			}
			
			echo "</ul>";
			echo '</div>';
			echo '</div>';
		    }
		?>
		</form>
		<div id="debug">
		    
		</div>
	    </div>
	    <?php
	}
	
	/**
	 * 
	 */
	public function printAdminPage()
	{
	    if ( !empty($_POST) && check_admin_referer('updateOptionSettings','nounceUpdateOptionReorder') && wp_verify_nonce($_POST['nounceUpdateOptionReorder'],'updateOptionSettings') )
	    {
		do_action("deleteUnecessaryEntries");
		?>
		<div class="updated"><p><strong><?php _e("Options enregistrées.", "deefusereorder");?></strong> <?php _e("Vous pouvez retrouver maintenant dans le menu principal pour chaque type d'article, une page pour re-ordonner vos éléments à l'intérieur de chaque catégorie.", "deefusereorder");?></p></div>
		<?php
	    }
	    $settingsOptions = $this->getAdminOptions();
	    ?>
	    <div class="wrap">
		<div class="icon32" id="icon-options-general"><br/></div>
		<h2><?php _e('Trie des articles d\'une catégorie', 'deefusereorder'); ?></h2>
		<form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
		    <?php wp_nonce_field('updateOptionSettings','nounceUpdateOptionReorder'); ?>
		    <p><?php _e("Cocher les catégories dont vous voulez trier manuellement les articles. Une fois que vous aurez coché et validé ces informations, un nouveau menu apparaîtra dans chaque type de post concerné.", "deefusereorder"); ?></p>
		    <h3><?php _e("Types d'articles disponibles :", "deefusereorder"); ?></h3>
		    <?php
			// On liste tout les post_types
			$post_types = get_post_types( array( 'show_in_nav_menus' => true,'public'=>true, 'show_ui'=>true, 'hierarchical' => false ), 'object' );
			if( $post_types ) :			    
			    // Pour chaque post_type, on regarde s'il y a des taxonomies associées
			    foreach ( $post_types as $post_type ) {
			       $taxonomies = get_object_taxonomies($post_type->name, 'objects');
			       if(count($taxonomies) > 0)
			       {
				    echo "<strong>" . $post_type->labels->menu_name . "</strong>";
				   
				    // Pour chaque taxonomie associé au CPT, on ne liste que celles qui ont la propriété hierarchical égale à 1 (ie comme les catégorie)
				    foreach ($taxonomies as $taxonomie)
				    {
					if($taxonomie->hierarchical == 1)
					{
					    $ischecked = '';
					    if(isset($settingsOptions['categories_checked'][$post_type->name])){
						if(in_array($taxonomie->name, $settingsOptions['categories_checked'][$post_type->name]))
						{
						   $ischecked = ' checked = "checked"';
						}
					    }
					    echo '<p>&nbsp;&nbsp;<label><input type="checkbox"'.$ischecked.' value="'.$taxonomie->name.'" name="selection['.$post_type->name.'][]"> '. $taxonomie->labels->name .'</label></p>';
					}
					
				    }
				   
			       }
			    }
			    echo '<p class="submit"><input id="submit" class="button button-primary" type="submit" value="'.__('Autoriser le tri pour les catégories cochées', 'deefusereorder').'" name="submit"/>';
			endif;
		    ?>
		</form>
	    </div>
	    <?php
	}
	
	/**
	 * Add an option page link for the administrator only
	 */
	public function add_setting_page()
	{
	    if (function_exists('add_options_page')) {
		add_options_page(__('ReOrder Post Within Categories', 'deefusereorder'), __('ReOrder Post Within Categories', 'deefusereorder'), 'manage_options', basename(__FILE__), array(&$this, 'printAdminPage'));
	    }
	}
	
	/**
	 * Dispplay a link to setting page inside the plugin description
	 */
	public function display_settings_link($links)
	{
	    $settings_link = '<a href="options-general.php?page=reorder-posts-within-categories.php">' . __('Paramètres', 'deefusereorder') . '</a>'; 
	    array_unshift($links, $settings_link); 
	    return $links;
	}
			
    }
    
    
    /* Instantiate the plugin */
    $ReOrderPostWithinCategory_instance = new ReOrderPostWithinCategory();
}