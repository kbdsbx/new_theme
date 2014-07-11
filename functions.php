<?php

require get_template_directory() . '/plugins/meta_box.php';

function new_setup() {
	load_theme_textdomain( 'new', get_template_directory() . '/languages' );
	add_theme_support( 'custom-header' );
	add_theme_support( 'custom-background' );
	add_theme_support( 'post-thumbnails' );
	if ( ! isset( $content_width ) ) { $content_width = 628; }
}
add_action( 'after_setup_theme', 'new_setup' );

function new_filter_menu_link_attributes( $atts, $item, $args ) {
	if ( $item->menu_item_parent != '0' ) {
		$args->before = '<i class="icon-right-open"></i>';
	} else {
		$args->before = '';
	}
	return $atts;
}
add_filter( 'nav_menu_link_attributes', 'new_filter_menu_link_attributes', 10, 3 );

function new_nav_menu_args( $args = '' ) {
	$args['container'] = false;
	$args['menu_class'] = 'sf-menu';
	return $args;
}
add_filter( 'wp_nav_menu_args', 'new_nav_menu_args' );
/**
 * Enqueues scripts and styles for front-end.
 *
*/
function new_scripts_styles() {
	global $wp_styles;
	wp_enqueue_style( 'new-style-base', get_template_directory_uri() . '/css/base.css' );
	wp_enqueue_style( 'new-style-960', get_template_directory_uri() . '/css/960.css' );
	wp_enqueue_style( 'new-style-ie', get_template_directory_uri() . '/css/ie.css' );
	wp_enqueue_style( 'new-style-new', get_template_directory_uri() . '/css/new.css' );
	wp_enqueue_style( 'new-style-phone', get_template_directory_uri() . '/css/phone.css' );
	wp_enqueue_style( 'new-style-ui', get_template_directory_uri() . '/css/ui.css' );
	wp_enqueue_style( 'new-style-superfish', get_template_directory_uri() . '/css/superfish.css', array(), '1.0' );
	wp_enqueue_style( 'new-style-style', get_template_directory_uri() . '/css/style.css', array(), '1.3' );
	wp_enqueue_style( 'new-style-fontello', get_template_directory_uri() . '/css/fontello/fontello.css' );


	wp_enqueue_script( 'new-superfish', get_template_directory_uri() . '/js/superfish.js', array(), '1.0' );
	wp_enqueue_script( 'new-mobilemenu', get_template_directory_uri() . '/js/mobilemenu.js', array(), '1.0' );
	wp_enqueue_script( 'new-new', get_template_directory_uri() . '/js/new.js', array(), '1.0' );
	wp_enqueue_script( 'new-passion', get_template_directory_uri() . '/js/mypassion.js', array(), '1.0' );
}
add_action( 'wp_enqueue_scripts', 'new_scripts_styles' );

/**
 * Register our menus.
 */
function new_register_my_menus() {
  register_nav_menus(
    array(
      'navigation' => __( 'Main Header Menu', 'new' ),
    )
  );
}
add_action( 'after_setup_theme', 'new_register_my_menus' );

function edit_header_image() {
}
add_action( 'wp_get_image_editor', '' );
