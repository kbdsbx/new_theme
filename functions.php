<?php

DEFINE( 'plugins_uri', get_template_directory_uri() . '/plugins' );
DEFINE( 'classes_uri', get_template_directory_uri() . '/classes' );
DEFINE( 'plugins', get_template_directory() . '/plugins' );
DEFINE( 'classes', get_template_directory() . '/classes' );

require plugins . '/widget_function.php';

require plugins . '/slider_widget.php';
require plugins . '/tabs_widget.php';
require plugins . '/flink_widget.php';
require plugins . '/follow_widget.php';
require plugins . '/picture_widget.php';
require plugins . '/ads_widget.php';
require plugins . '/flink_page.php';
require plugins . '/theme_setting_page.php';

require_once classes . '/class-new-flink-list-table.php';
require_once classes . '/class-new-comment-walker.php';

function new_script_init() {
    wp_deregister_style( 'open-sans' );
    wp_register_style( 'open-sans', false );
}

add_action( 'admin_enqueue_scripts', 'new_script_init' );
add_action( 'wp_enqueue_scripts', 'new_script_init' );

function new_enum_init() {
	
	global $size_enum, $post_types;
	$size_enum = array(
		'lg' => array( 960, 640 ),
		'md' => array( 540, 372 ),
		'sm' => array( 380, 253 ),
		's' => array( 380, 217 ),
		'xs' => array( 300, 162 ),
		'x' => array( 180, 135 ),
		'w' => array( 125, 125 ),
		'xx' => array( 140, 86 )
	);
	
	foreach( $size_enum as $size_key => $size ) {
		add_image_size( $size_key, $size[0], $size[1], true );
	}

    $post_types = array( 'post', 'page', 'gallery', 'resource', 'ware' );
}

add_action( 'init', 'new_enum_init' );

function new_field_init() {
    global $post_types;
	if( function_exists( "register_field_group") )	{
		register_field_group( array (
			'id' => '247',
			'title' => '公共字段',
			'fields' => array (
				array (
					'key' => 'field_53def322e5039',
					'label' => '文章标记',
					'name' => 'new-article-flags',
					'type' => 'checkbox',
					'instructions' => '为你的文章添加标记，使之在页面中特殊的地方或以特殊的形式展示出来',
					'choices' => array (
						'headline' => '头条',
						'recommend' => '推荐',
						'slider' => '幻灯',
						'special' => '特别推荐',
						'roll' => '滚动',
						'bold' => '加粗',
					),
					'default_value' => '',
					'layout' => 'horizontal',
				),
				array (
					'key' => 'field_53df3aadae5b3',
					'label' => '文章来源',
					'name' => 'new-article-source',
					'type' => 'text',
					'instructions' => '显示文章来源',
					'required' => 1,
					'default_value' => 'www.jiehengsen.org',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'formatting' => 'html',
					'maxlength' => '',
				),
				array (
					'key' => 'field_53df244673d32',
					'label' => '访问次数',
					'name' => 'new-article-views',
					'type' => 'number',
					'instructions' => '文章的已访问次数',
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'min' => '',
					'max' => '',
					'step' => '',
				),
			),
			'location' => array (
				array (
					array (
						'param' => 'post_type',
						'operator' => '==',
						'value' => 'post',
						'order_no' => 0,
						'group_no' => 0,
					),
				),
				array (
					array (
						'param' => 'post_type',
						'operator' => '==',
						'value' => 'page',
						'order_no' => 0,
						'group_no' => 1,
					),
				),
				array (
					array (
						'param' => 'post_type',
						'operator' => '==',
						'value' => 'gallery',
						'order_no' => 0,
						'group_no' => 2,
					),
				),
				array (
					array (
						'param' => 'post_type',
						'operator' => '==',
						'value' => 'resource',
						'order_no' => 0,
						'group_no' => 3,
					),
                ),
                array (
					array (
						'param' => 'post_type',
						'operator' => '==',
						'value' => 'ware',
						'order_no' => 0,
						'group_no' => 4,
					),
				),
			),
			'options' => array (
				'position' => 'acf_after_title',
				'layout' => 'default',
				'hide_on_screen' => array (
				),
			),
			'menu_order' => 0,
		) );
    }

	if(function_exists("register_field_group"))
	{
		register_field_group(array (
			'id' => '285',
			'title' => '分类目录字段',
			'fields' => array (
				array (
					'key' => 'field_53e19dd6d5ccb',
					'label' => '所属文章类型',
					'name' => 'post_type',
					'type' => 'select',
					'instructions' => '通过不同文章类型调用不同模板',
					'required' => 1,
					'choices' => $post_types,
					'default_value' => 'post',
					'allow_null' => 0,
					'multiple' => 0,
				),
			),
			'location' => array (
				array (
					array (
						'param' => 'ef_taxonomy',
						'operator' => '==',
						'value' => 'category',
						'order_no' => 0,
						'group_no' => 0,
					),
				),
			),
			'options' => array (
				'position' => 'normal',
				'layout' => 'no_box',
				'hide_on_screen' => array (
				),
			),
			'menu_order' => 0,
		));
	}
    
}

add_action( 'init', 'new_field_init' );

function new_post_type_init() {
    // Gallery
    register_post_type( 'gallery', 
        array(
            'labels' => array(
                'name' => __( 'Galleries', 'new' ),
                'singular_name' => __( 'Gallery', 'new' ),
            ),
            'public' => true,
            'supports' => array(
                'title',
                'editor',
                'thumbnail',
                'excerpt',
                'trackbacks',
                'comments',
                'revisions',
                'page-attributes',
            ),
            'taxonomies' => array(
                'category',
                'post_tag'
            ),
            'query_var' => 'g'
        )
    );

    // Downloads center
    register_post_type( 'resource',
        array(
            'labels' =>array(
                'name' => __( 'Resources', 'new' ),
                'singular_name' => __( 'Resource', 'new' ),
            ),
            'public' => true,
            'supports' => array(
                'title',
                'editor',
                'thumbnail',
                'excerpt',
                'trackbacks',
                'comments',
                'revisions',
                'page-attributes'
            ),
            'taxonomies' => array(
                'category',
                'post_tag'
            ),
            'query_var' => 'd'
        )
    );
    register_post_type( 'ware',
        array(
            'labels' =>array(
                'name' => __( 'Wares', 'new' ),
                'singular_name' => __( 'Ware', 'new' ),
            ),
            'public' => true,
            'supports' => array(
                'title',
                'editor',
                'thumbnail',
                'excerpt',
                'trackbacks',
                'comments',
                'revisions',
                'page-attributes'
            ),
            'taxonomies' => array(
                'category',
                'post_tag'
            ),
            'query_var' => 'w'
        )
    );
}

add_action( 'init', 'new_post_type_init' );

function new_setup() {
	load_theme_textdomain( 'new', get_template_directory() . '/languages' );
	add_theme_support( 'custom-header' );
	add_theme_support( 'custom-background' );
	add_theme_support( 'post-thumbnails' );
}
add_action( 'after_setup_theme', 'new_setup' );

/* filter */

function new_filter_menu_link_attributes( $atts, $item, $args ) {
    switch ( $args->theme_location ) {
    case 'navigation-main':
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

function new_filter_category_template( $a ) {
    var_dump( $a );
    exit();
}

add_filter( 'category_template', 'new_filter_category_template' );

/* !filter */

/**
 * Enqueues scripts and styles for front-end.
 *
*/
function new_scripts_styles() {
	global $wp_styles;
    wp_enqueue_style( 'google-fonts', 'http://fonts.useso.com/css?family=Merriweather+Sans:400,300,700,800', array(), null );
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
 * Register menus.
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
		'name'          => 'sidebar-main-slider',
		'id'            => 'sidebar-main-slider',
		'class'			=> '',
		'description'   => __( 'The main slider of the home page.', 'new' ),
		'before_widget' => '<div class="main-slider">',
		'after_widget'  => '</div>',
		'before_title'  => '',
		'after_title'   => '',
	) );
	register_sidebar( array(
		'name'          => 'sidebar-slider2',
		'id'            => 'sidebar-slider2',
		'class'			=> '',
		'description'   => __( 'The main slider2 of the home page.', 'new' ),
		'before_widget' => '<div class="slider2">',
		'after_widget'  => '</div>',
		'before_title'  => '',
		'after_title'   => '',
	) );
	register_sidebar( array(
		'name'          => 'sidebar-home-footer',
		'id'            => 'sidebar-home-footer',
		'class'			=> '',
		'description'   => __( 'The main slider of the home page.', 'new' ),
		'before_widget' => '<div class="column-two-third">',
		'after_widget'  => '</div>',
		'before_title'  => '',
		'after_title'   => '',
	) );
    register_sidebar( array( 
		'name'          => 'sidebar-category-side',
		'id'            => 'sidebar-category-side',
		'class'			=> '',
		'description'   => __( 'The right slider of the category page.', 'new' ),
		'before_widget' => '<div class="sidebar">',
		'after_widget'  => '</div>',
		'before_title'  => '',
		'after_title'   => '',
    ) );
    register_sidebar( array( 
		'name'          => 'sidebar-side',
		'id'            => 'sidebar-side',
		'class'			=> '',
		'description'   => __( 'The right slider of the homepage.', 'new' ),
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
	global $size_enum;
	$color_primary = get_option('color_primary');
    $color_primary_2 = '#' . _filter_empty( dechex( hexdec( $color_primary ) - 0x323333 ), '000000' );
	
?>
<style type="text/css">
.badg,
.search-form .fs,
.flex-direction-nav a,
.flexslider:hover .flex-next:hover,
.flexslider:hover .flex-prev:hover,
p.copyright,
a.comment-reply-link:hover
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
.block2 span,
span.meta,
.comment-data p span,
.relatednews ul li span
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
input#submit,
input.post-comment,
.pager a:hover,
.pager span.current {
background: <?php echo $color_primary; ?>;
background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(<?php echo $color_primary; ?>), to(<?php echo $color_primary_2; ?>)); /* Safari 4-5, Chrome 1-9 */ 
background: -webkit-linear-gradient(top, <?php echo $color_primary; ?>, <?php echo $color_primary_2; ?>);/* Safari 5.1, Chrome 10+ */  
background: -moz-linear-gradient(top, <?php echo $color_primary; ?>, <?php echo $color_primary_2; ?>); /* Firefox 3.6+ */ 
background: -ms-linear-gradient(top, <?php echo $color_primary; ?>, <?php echo $color_primary_2; ?>); /* IE 10 */ 
background: -o-linear-gradient(top, <?php echo $color_primary; ?>, <?php echo $color_primary_2; ?>);/* Opera 11.10+ */ 
}
input#submit:hover,
input.post-comment:hover {
background: <?php echo $color_primary_2; ?>;
background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(<?php echo $color_primary_2; ?>), to(<?php echo $color_primary; ?>)); /* Safari 4-5, Chrome 1-9 */ 
background: -webkit-linear-gradient(top, <?php echo $color_primary_2; ?>, <?php echo $color_primary; ?>);/* Safari 5.1, Chrome 10+ */  
background: -moz-linear-gradient(top, <?php echo $color_primary_2; ?>, <?php echo $color_primary; ?>); /* Firefox 3.6+ */ 
background: -ms-linear-gradient(top, <?php echo $color_primary_2; ?>, <?php echo $color_primary; ?>); /* IE 10 */ 
background: -o-linear-gradient(top, <?php echo $color_primary_2; ?>, <?php echo $color_primary; ?>);/* Opera 11.10+ */ 
}
</style>

    <?php
}

add_action('wp_head', 'new_add_css_styles');

if ( function_exists( 'get_field' ) ) {

// increase click times to every posts' head;
function set_post_views() {
    global $post;
    if ( ! isset ( $post->ID ) )
        return;

    $post_ID = $post->ID;
    $post_views = get_field( 'new-article-views', $post_ID );
	if ( is_singular() ) {
		if( $post_ID )	{
            update_field( 'new-article-views', $post_views + 1, $post_ID );
		}
	} else if ( is_admin() ) {
        if ( $post_ID && empty( $post_views ) ) {
            update_field( 'new-article-views', rand( 50, 300 ), $post_ID );
        }
    }
}
add_action('wp_head', 'set_post_views'); 
add_action('save_post', 'set_post_views'); 
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

// 去除移动端浏览时的背景，减少流量
function new_filter_background_color( $classes ) {
    if ( wp_is_mobile() ) {
        unset( $classes[ array_search( 'custom-background', $classes ) ] );
    }
    return $classes;
}

add_filter( 'body_class', 'new_filter_background_color' );

