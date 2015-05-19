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
	<body <?php body_class('before');?>>
	
		<?php 
			/**
			 * @var string $category_color the category color to use on this page.
			 */
			$category_color = (is_category()) ? CM_Collection_Controller::get_current_category()->slug
					     : ((get_post_type() == 'collections') ? CM_Collection_Controller::get_category_for_collection(get_the_ID())->slug : "brand" );

			/**
			 * set the category as a color that we can globally access.
			 */
			set_global( 'category_color', $category_color );

		?>

		<?php get_template_part('partials/ie'); ?>

		<div id="wrapper" class="loading spy">


			<header id="header" class="closed bg-white">
				<div class="container-fluid">
					<div class="row">
						<div id="logo-cm" class="col-sm-4 m0 col-xs-6">
							<a href="<?php bloginfo('url'); ?>">
								<img src="<?php bloginfo('template_directory'); ?>/assets/img/logo-cm-small.png" alt="creative mind logo" />
							</a>
						</div>

						<nav class="col-sm-8 col-xs-6 m0">
							<p class="right"><a href="#menu" class="menu-toggle">
								<span class="uppercase">Index</span>
							</a></p>
						</nav>

						<?php $activity = false; ?>

					</div>
				</div>
			</header>	

			<main id="content">
