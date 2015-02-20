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

		<div id="wrapper" class="loading spy">

			<div id="topbar" class="bg-brand"></div>
			<?php if(!is_single()): ?>
			<header id="header" class="closed">
				<div id="header-brown" class="bg-brown hidden-xs">
					<div class="container-fluid">
						<div class="row">
							<div id="logo-brown" class="col-sm-4 m0">
								<a href="http://brown.edu" target="blank">
									<img src="<?php bloginfo('template_directory'); ?>/assets/img/logo-brown-small.png" alt="brown logo" />
								</a>
							</div>
						</div>
					</div>
				</div>
				<?php endif; ?>
				<div id="header-cm" class="bg-white">
					<div class="container-fluid">
						<div class="row">
							<div id="logo-cm" class="col-sm-4 m0 col-xs-6">
								<a href="<?php bloginfo('url'); ?>">
									<img src="<?php bloginfo('template_directory'); ?>/assets/img/logo-cm-small.png" alt="creative mind logo" />
								</a>
							</div>
							<div class="visible-xs col-xs-6 m0">
								<p class="right"><a href="#menu" class="menu-toggle">Menu<span class="icon" data-icon="&#64257;"></span></a></p>
							</div>
							<nav class="col-sm-8 m0 col-xs-12">
								<ul class="nav nav-inline right">
									<li><a href="<?php bloginfo('url'); ?>/courses">Courses</a></li>
									<li><a href="<?php bloginfo('url'); ?>/research">Research</a></li>
									<li><a href="<?php bloginfo('url'); ?>/interviews">Interviews</a></li>		
									<li><a href="<?php bloginfo('url'); ?>/lectures">Lectures</a></li>
									<li><a href="<?php bloginfo('url'); ?>/about">About</a></li>
									<li><a href="#search" data-toggle="modal" data-target="#searchModal"><span class="icon" data-icon="s"></span></a></li>
								</ul>
							</nav>
						</div>
					</div>
				</div>
			</header>	
			<div id="headerfix"></div>

			<div id="content">