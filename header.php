<?php
?><!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=<?php bloginfo( 'charset' )?>" />
	<meta name="viewport" content="width=device-width">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<meta name="keywords" content="<?php bloginfo( 'keyword' )?>" />
	<meta name="description" content="<?php bloginfo( 'description' )?>" />	
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js"></script>
	<![endif]-->
	<?php wp_head(); ?>
</head>

<body>
<!-- Body Wrapper -->
<div class="body-wrapper">
	<div class="controller">
	    <div class="controller2">
			<!-- Header -->
			<div id="header">
			    <div class="container">
			        <div class="column">
			            <div class="logo">
				    		<a href="<?php esc_url( home_url( '/' ) );?>"><img src="<?php header_image(); ?>" alt="<?php bloginfo( 'name' ); ?>" /></a>
			            </div>
			            
			            <div class="search">
						<?php get_search_form(); ?>	
			            </div>
			            
			            <!-- Nav -->
			            <div id="nav">
							<?php wp_nav_menu( array( 'theme_location'=>'navigation' ) ); ?>	
			            </div>
			            <!-- /Nav -->
			        </div>
			    </div>
			</div><!-- end of header -->