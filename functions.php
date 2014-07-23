<?php

DEFINE( 'plugins_uri', get_template_directory_uri() . '/plugins' );
DEFINE( 'classes_uri', get_template_directory_uri() . '/classes' );
DEFINE( 'plugins', get_template_directory() . '/plugins' );
DEFINE( 'classes', get_template_directory() . '/classes' );

require plugins . '/widget_function.php';

require plugins . '/meta_box.php';
require plugins . '/slider_widget.php';
require plugins . '/tabs_widget.php';
require plugins . '/flink_widget.php';
require plugins . '/follow_widget.php';
require plugins . '/picture_widget.php';
require plugins . '/ads_widget.php';
require plugins . '/flink_page.php';
require plugins . '/theme_setting.php';

require_once classes . '/class-new-flink-list-table.php';


global $posts_size;
$posts_size = array(
	'lg' => array( 960, 640 ),
	'md' => array( 540, 372 ),
	'sm' => array( 380, 253 ),
	's' => array( 380, 217 ),
	'xs' => array( 300, 162 ),
	'x' => array( 180, 135 ),
	'w' => array( 125, 125 ),
	'xx' => array( 140, 86 )
);

foreach( $posts_size as $size_key => $size ) {
	add_image_size( $size_key, $size[0], $size[1], true );
}

function new_setup() {
	load_theme_textdomain( 'new', get_template_directory() . '/languages' );
	add_theme_support( 'custom-header' );
	add_theme_support( 'custom-background' );
	add_theme_support( 'post-thumbnails' );
	if ( ! isset( $content_width ) ) { $content_width = 628; }
}
add_action( 'after_setup_theme', 'new_setup' );

function new_filter_menu_link_attributes( $atts, $item, $args ) {
    switch ( $args->theme_location ) {
    case 'navigation':
        if ( $item->menu_item_parent != '0' ) {
		    $args->before = '<i class="icon-right-open"></i>';
    	} else {
    		$args->before = '';
        }
        break;
    case 'navigation-footer':
        $args->before = '<i class="icon-right-open"></i>';
        break;
    default:
        break;
    }
    
	return $atts;
}
add_filter( 'nav_menu_link_attributes', 'new_filter_menu_link_attributes', 10, 3 );

/**
 * Enqueues scripts and styles for front-end.
 *
*/
function new_scripts_styles() {
	global $wp_styles;
	wp_enqueue_style( 'new-style-superfish', get_template_directory_uri() . '/css/superfish.css' );
	wp_enqueue_style( 'new-style-fontello', get_template_directory_uri() . '/css/fontello/fontello.css' );
	wp_enqueue_style( 'new-style-flexslider', get_template_directory_uri() . '/css/flexslider.css' );
	wp_enqueue_style( 'new-style-ui', get_template_directory_uri() . '/css/ui.css' );
	wp_enqueue_style( 'new-style-base', get_template_directory_uri() . '/css/base.css' );
	wp_enqueue_style( 'new-style-style', get_template_directory_uri() . '/css/style.css' );
	wp_enqueue_style( 'new-style-960', get_template_directory_uri() . '/css/960.css' );
	wp_enqueue_style( 'new-style-new', get_template_directory_uri() . '/css/new.css' );
	wp_enqueue_style( 'new-style-devices-1000', get_template_directory_uri() . '/css/devices/1000.css' );
	wp_enqueue_style( 'new-style-devices-479', get_template_directory_uri() . '/css/devices/479.css' );
	wp_enqueue_style( 'new-style-devices-767', get_template_directory_uri() . '/css/devices/767.css' );


	wp_enqueue_script( 'new-jquery', get_template_directory_uri() . '/js/jquery.js', array(), '1.9.1' );
	wp_enqueue_script( 'new-easing', get_template_directory_uri() . '/js/easing.min.js', array(), '1.0' );
	wp_enqueue_script( 'new-1.8.2', get_template_directory_uri() . '/js/1.8.2.min.js', array(), '1.0' );
	wp_enqueue_script( 'new-ui', get_template_directory_uri() . '/js/ui.js', array(), '1.0' );
	wp_enqueue_script( 'new-carouFreSel', get_template_directory_uri() . '/js/carouFredSel.js', array(), '1.0' );
	wp_enqueue_script( 'new-supserfish', get_template_directory_uri() . '/js/superfish.js', array(), '1.0' );
	wp_enqueue_script( 'new-customM', get_template_directory_uri() . '/js/customM.js', array(), '1.0' );
	wp_enqueue_script( 'new-flexslider', get_template_directory_uri() . '/js/flexslider-min.js', array(), '1.0' );
	wp_enqueue_script( 'new-tweetable', get_template_directory_uri() . '/js/tweetable.js', array(), '1.0' );
	wp_enqueue_script( 'new-timeago', get_template_directory_uri() . '/js/timeago.js', array(), '1.0' );
	wp_enqueue_script( 'new-jflickrfeed', get_template_directory_uri() . '/js/jflickrfeed.min.js', array(), '1.0' );
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
      'navigation-main' => __( 'Main Header Menu', 'new' ),
      'navigation-footer' => __( 'Foot Navigation Menu', 'new' ),
    )
  );
}
add_action( 'after_setup_theme', 'new_register_my_menus' );

function new_widgets_init() {
	register_sidebar( array(
		'name'          => 'sidebar-home-head',
		'id'            => 'sidebar-home-head',
		'class'			=> '',
		'description'   => __( 'The main slider of the home page.', 'new' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '',
		'after_title'   => '',
	) );
	register_sidebar( array(
		'name'          => 'sidebar-home-footer',
		'id'            => 'sidebar-home-footer',
		'class'			=> '',
		'description'   => __( 'The main slider of the home page.', 'new' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '',
		'after_title'   => '',
	) );
    register_sidebar( array( 
		'name'          => 'sidebar-side',
		'id'            => 'sidebar-side',
		'class'			=> '',
		'description'   => __( 'The right slider of the page.', 'new' ),
		'before_widget' => '<div class="sidebar">',
		'after_widget'  => '</div>',
		'before_title'  => '',
		'after_title'   => '',
    ) );
}
add_action( 'widgets_init', 'new_widgets_init' );

function new_custom_color_register( $wp_customize ) {
	$colors = array();
	
	$colors[] = array(
		'slug'=>'color_primary', 
		'default' => '#ea4748',
		'label' => __('Primary Color ', 'new')
	);
	
	foreach( $colors as $color ) {
		$wp_customize->add_setting(
			$color['slug'], array(
				'default' => $color['default'],
				'type' => 'option', 
				'capability' => 'edit_theme_options'
			)
		);
		// CONTROLS
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				$color['slug'], 
				array('label' => $color['label'], 
				'section' => 'colors',
				'settings' => $color['slug'])
			)
		);
	}
}

add_action( 'customize_register', 'new_custom_color_register' );

function new_add_css_styles() { 
	global $posts_size;
	$color_primary = get_option('color_primary');
	
?>
<style type="text/css">
	<?php foreach ( $posts_size as $size_key => $size ) : ?>
	.main-slider-<?php echo $size_key; ?> {
		width: <?php echo $size[0]; ?>px;
		height: <?php echo $size[1]; ?>px;
		margin: 0 10px;
		float: left;
	}
	.slider-<?php echo $size_key; ?> {
		width: <?php echo $size[0]; ?>px;
		height: auto;
		margin: 0 10px;
		float: left;
	}
	<?php endforeach; ?>
.badg,
.search .fs,
.flex-direction-nav a,
.flexslider:hover .flex-next:hover,
.flexslider:hover .flex-prev:hover,
p.copyright
{ background-color: <?php echo $color_primary; ?>; }
a,
.sf-menu li:hover,
.sf-menu a:focus,
.sf-menu a:hover,
.sf-menu a:active,
.sf-menu li a:hover,
ul.sf-menu li.sfHover ul li:hover i,
ul.sf-menu li.sfHover ul li a:hover,
.block span,
span.meta
{ color: <?php echo $color_primary; ?> }
div#nav,
.sf-menu li:hover ul, 
.sf-menu li.sfHover ul,
.sf-menu>li>a:hover,
.ui-tabs .ui-tabs-panel,
.ui-tabs .ui-tabs-nav li.ui-tabs-active,
h5.line,
h5.line>span,
#footer
{ border-color: <?php echo $color_primary; ?>; }
</style>

    <?php
}

add_action('wp_head', 'new_add_css_styles');

// register click times to every posts' head;
function new_record_visitors() {
	if ( is_singular() ) 
	{
		global $post;
		$post_ID = $post->ID;
		if( $post_ID )	{
			$post_views = ( int )get_post_meta( $post_ID, 'views', true );
			if( !update_post_meta( $post_ID, 'views', ( $post_views + 1 ) ) ) {
				add_post_meta( $post_ID, 'views', 1, true );
			}
		}
	}
}
add_action('wp_head', 'new_record_visitors'); 

function get_post_views() {
	global $post;
	$post_ID = $post->ID;
	$views = ( int ) get_post_meta( $post_ID, 'views', true );
	return $views;
}


function new_register_custom_background() {
    $args = array(
        'default-color' => '',
        'default-image' => '',
    );

    $args = apply_filters( 'new_custom_background_args', $args );

    add_theme_support( 'custom-background', $args );
}

add_action( 'after_setup_theme', 'new_register_custom_background' );
