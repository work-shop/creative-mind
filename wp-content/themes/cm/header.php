<!doctype html>
<html class="no-js menu-closed">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

		<title> 
		   <?php
	   	    if (is_category()) : single_cat_title(); echo ' - '; 
	        elseif (is_archive()): wp_title(''); echo ' - ';  
	      	elseif (!(is_404()) && (is_single()) || (is_page())) : wp_title(''); echo ' - '; 
	     	elseif (is_404()) : echo 'Not Found - ';
	     	endif;
	      	if (is_home()) : bloginfo('name'); echo ' - '; bloginfo('description'); 
	      	else : bloginfo('name'); 
	      	endif;
		   ?>
		</title>

        <meta name="description" content="<?php bloginfo('description'); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">			   
		<meta name="description" content="<?php bloginfo('description'); ?>">
		<meta name="author" content="Work-Shop">		
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

		<!-- Twitter Card data -->
		<meta name="twitter:card" value="<?php bloginfo('description'); ?>">
		
		<!-- Open Graph data -->
		<meta property="og:title" content="<?php bloginfo('name'); ?>" />
		<meta property="og:type" content="article" />
		<meta property="og:url" content="<?php bloginfo('url'); ?>" />
		<meta property="og:image" content="<?php bloginfo('template_directory'); ?>/_/img/logo.png" />
		<meta property="og:description" content="<?php bloginfo('description'); ?>" />	  		
        
        <link rel="apple-touch-icon" href="apple-touch-icon.png">		
		<link rel="shortcut icon" href="<?php bloginfo('template_directory'); ?>/assets/img/favicon.ico">
		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />	
				
	    <!--[if lt IE 9]>
	      <script src="<?php bloginfo('template_directory'); ?>/assets/js/html5shiv.js"></script>
	      <script src="<?php bloginfo('template_directory'); ?>/assets/js/respond.js"></script>
	    <![endif]-->		 
	        	
		<?php wp_head(); ?>

    </head>
	<body <?php 
		if ( !is_home() ) {
			$category_nicename = CM_Collection_Controller::get_current_category()->category_nicename;
			body_class('category-' . $category_nicename);
		}
	?> >
	
		<?php 

			/**
			 * @var string $category_name the name of the current category.
			 * @var string $category_color the color name for the current category.
			 */
			if ( is_home() ) {
				$category_color ='brand';
			} else {
				$category_name = CM_Collection_Controller::get_current_category()->name;
				$category_color = CM_Collection_Controller::get_current_category()->slug;
			}

		?>

		<?php get_template_part('partials/ie'); ?>

		<div id="wrapper" class="loading spy">


			<header id="header" class="closed bg-light border-bottom-<?php echo $category_color ?>">
				<div class="container-fluid">
					<div class="row">
						<div id="logo-cm" class="col-sm-3 m0 col-xs-6">
							<a href="<?php bloginfo('url'); ?>">
								<img src="<?php bloginfo('template_directory'); ?>/assets/img/logo-cm-small.png" alt="creative mind logo" />
							</a>
						</div>

						<div class="col-sm-6 hidden-xs centered mt1">
							<?php if ( !is_home() ) {
								echo '<span class="h4 uppercase bold ' . $category_color . '">' . $category_name . '</span>' ;
							} ?>
						</div>

						<nav class="col-sm-2 right righted m0">
							<a href="#menu" class="menu-toggle">
								<span class="uppercase">Index</span>
							</a>
						</nav>

						<?php $activity = false; ?>

					</div>
				</div>
			</header>	

			<main id="content" <?php if ( is_singular('stories') ) 
				echo 'class="bg-' . CM_Collection_Controller::get_current_category()->slug . ' white"' 
			?>>
