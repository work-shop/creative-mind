<!doctype html>
<html class="no-js">
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
		if ( is_home() ) {
			body_class('home menu-closed before');
		}
		else {
			$category_nicename = CM_Collection_Controller::get_current_category()->category_nicename;
			body_class('menu-closed before category-' . $category_nicename);
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

			<header id="header" class="closed border-bottom-<?php echo $category_color ?>">
				<div class="container-fluid">
					<div class="row">
						<div id="logo-cm" class="m0">
							<a href="<?php bloginfo('url'); ?>">
								<?php get_template_part('partials/logo_svg_header' ); ?>
							</a>
						</div>

						<div class="hidden-xs mt1">
							<ul id="category-nav">
								<li><a href="<?php bloginfo('url'); ?>/courses" class="courses-link uppercase bold 
								<?php if($category_nicename == 'courses'): echo 'courses'; else: echo 'gray'; endif; ?>
								">Courses</a></li>
								<li><a href="<?php bloginfo('url'); ?>/projects" class="projects-link uppercase bold
								<?php if($category_nicename == 'projects'): echo 'projects'; else: echo 'gray'; endif; ?>
								">Projects</a></li>
								<li><a href="<?php bloginfo('url'); ?>/interviews" class="interviews-link uppercase bold
								<?php if($category_nicename == 'interviews'): echo 'interviews'; else: echo 'gray'; endif; ?>
								">Interviews</a></li>
								<li><a href="<?php bloginfo('url'); ?>/lectures" class="lectures-link uppercase bold
								<?php if($category_nicename == 'lectures'): echo 'lectures'; else: echo 'gray'; endif; ?>
								">Lectures</a></li>
							</ul>
 						</div>	

						<?php $activity = false; ?>
 
					</div>
				</div>
			</header>	

			<nav class="right righted m0" id="nav">
				<a href="#menu" class="menu-toggle uppercase closed" id="menu-toggle">
					<span id="menu-toggle-title" >Index</span>
					<div id="hamburger">
						<div class="hamburger-line bg-courses" id="hamburger-line-1"></div>
						<div class="hamburger-line bg-projects" id="hamburger-line-2"></div>
						<div class="hamburger-line bg-interviews" id="hamburger-line-3"></div>
						<div class="hamburger-line bg-lectures" id="hamburger-line-4"></div>
					</div>
				</a>
			</nav>			

			<div id="headerfix"></div>

			<main id="content" <?php if ( is_singular('stories') ) 
				echo 'class="bg-' . CM_Collection_Controller::get_current_category()->slug . ' white"' 
			?>>
