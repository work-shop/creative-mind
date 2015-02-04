
<!doctype html>
<html class="no-js menu-closed">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

		<title> 
		   <?php
	   	    if (is_category()) : single_cat_title(); echo ' - '; 
	        elseif (is_archive()): wp_title(''); echo ' - ';  
	      	elseif (is_search()) : echo 'Search for &quot;'.wp_specialchars($s).'&quot; - '; 
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

		<?php get_template_part('partials/ie'); ?>
		<?php get_template_part('partials/landing'); ?>

		<div id="wrapper" class="loading">
	
			<header id="header" class="closed">
			   <?php
		   	    if (is_category()) : single_cat_title(); echo ' - '; 
		        elseif (is_archive()): wp_title(''); echo ' - ';  
		      	elseif (is_search()) : echo 'Search for &quot;'.wp_specialchars($s).'&quot; - '; 
		      	elseif (!(is_404()) && (is_single()) || (is_page())) : wp_title(''); echo ' - '; 
		     	elseif (is_404()) : echo 'Not Found - ';
		     	endif;
		      	if (is_home()) : bloginfo('name'); echo ' - '; bloginfo('description'); 
		      	else : bloginfo('name'); 
		      	endif;
			   ?>					
			</header>	
			<div id="headerfix"></div>

			<div id="content">
