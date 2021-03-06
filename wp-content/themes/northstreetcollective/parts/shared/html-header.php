<!DOCTYPE HTML>
<!--[if IEMobile 7 ]><html class="no-js iem7" manifest="default.appcache?v=1"><![endif]--> 
<!--[if lt IE 7 ]><html class="no-js ie6" lang="en"><![endif]--> 
<!--[if IE 7 ]><html class="no-js ie7" lang="en"><![endif]--> 
<!--[if IE 8 ]><html class="no-js ie8" lang="en"><![endif]--> 
<!--[if (gte IE 9)|(gt IEMobile 7)|!(IEMobile)|!(IE)]><!--><html class="no-js" lang="en"><!--<![endif]-->
	<head>
		<title><?php bloginfo( 'name' ); ?><?php wp_title( '|' ); ?></title>
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
  	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
		<link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri(); ?>/img/favicon.ico"/>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		<script src="<?php bloginfo('template_url'); ?>/js/modernizr.custom.js"></script>
		<script src="<?php bloginfo('template_url'); ?>/bootstrap/js/bootstrap.js"></script>
		<script src="<?php bloginfo('template_url'); ?>/js/classie.js"></script>
		<script src="<?php bloginfo('template_url'); ?>/js/uisearch.js"></script>
    <script src="<?php bloginfo('template_url'); ?>/js/jquery.scrollTo-1.4.3.1-min.js"></script>
    <script src="<?php bloginfo('template_url'); ?>/js/jquery.easing.1.3.js"></script>
    <script src="<?php bloginfo('template_url'); ?>/js/jquery.mobile.custom.js"></script> 
    <link rel="icon" 
          type="image/png" 
          href="<?php echo bloginfo('template_url'); ?>/favicon(32).png">
		<?php wp_head(); ?>
	</head>
	<body <?php body_class(); ?>>
