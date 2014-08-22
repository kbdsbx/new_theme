<?php

DEFINE( 'template_uri', get_template_directory_uri() );
DEFINE( 'plugins_uri', get_template_directory_uri() . '/plugins' );
DEFINE( 'classes_uri', get_template_directory_uri() . '/classes' );
DEFINE( 'template', get_template_directory() );
DEFINE( 'plugins', get_template_directory() . '/plugins' );
DEFINE( 'classes', get_template_directory() . '/classes' );

require 'advanced-custom-fields/acf.php';
define( 'ACF_LITE', false );

require plugins . '/widget_function.php';

require plugins . '/slider_widget.php';
require plugins . '/tabs_widget.php';
require plugins . '/flink_widget.php';
require plugins . '/follow_widget.php';
require plugins . '/picture_widget.php';
require plugins . '/ads_widget.php';
require plugins . '/flink_page.php';
require plugins . '/modules_page.php';
require plugins . '/theme_setting_page.php';

require_once classes . '/class-new-flink-list-table.php';
require_once classes . '/class-new-comment-walker.php';
require_once classes . '/class-new-modules-list-table.php';

/* init */

/**
 * 关闭google fonts api，或启用360源 
 */
function new_filter_style_init() {
    wp_deregister_style( 'open-sans' );
    wp_register_style( 'open-sans', false );
}

add_action( 'admin_enqueue_scripts', 'new_filter_style_init' );
add_action( 'wp_enqueue_scripts', 'new_filter_style_init' );

/**
 * 全局变量
 * @size_enum 自定义图片规格
 * @post_types 自定义文章类型
 * @post_types_keys 文章类型部分API调用需要
 */
function new_enum_init() {
	
	global $size_enum, $post_types, $post_types_keys, $new_module_type;
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

    $post_types = array( 'post' => __( '文章', 'new' ), 'page' => __( '页面', 'new' ), 'gallery' => __( '图集', 'new' ), 'resource' => __( '资源', 'new' ), 'ware' => __( '商品', 'new' ) );
    $post_types_keys = array_keys( $post_types );

    $new_module_type = array(
        'itd' => __( '图文简介', 'new' ),
        'it' => __( '仅图文', 'new' ),
        'td' => __( '仅标题和简介', 'new' ),
        'rc' => __( '重点与滚动（纵向）', 'new' ),
        'rr' => __( '重点与滚动（横向）', 'new' ),
        's' => __( '幻灯', 'new' ),
    );
}

add_action( 'init', 'new_enum_init' );

/**
 * 自定义字段
 */
function new_field_init() {
    global $post_types;
	if( function_exists( "register_field_group") )	{
		register_field_group( array (
			'id' => '247',
			'title' => __( '公共字段', 'new' ),
			'fields' => array (
				array (
					'key' => 'field_53def322e5039',
					'label' => __( '文章标记', 'new' ),
					'name' => 'new-article-flags',
					'type' => 'checkbox',
					'instructions' => __( '为你的文章添加标记，使之在页面中特殊的地方或以特殊的形式展示出来', 'new' ),
					'choices' => array (
						'headline' => __( '头条', 'new' ),
						'recommend' => __( '推荐', 'new' ),
						'slider' => __( '幻灯', 'new' ),
						'special' => __( '特别推荐', 'new' ),
						'roll' => __( '滚动', 'new' ),
						'bold' => __( '加粗', 'new' ),
					),
					'default_value' => '',
					'layout' => 'horizontal',
				),
				array (
					'key' => 'field_53df3aadae5b3',
					'label' => __( '文章来源', 'new' ),
					'name' => 'new-article-source',
					'type' => 'text',
					'instructions' => __( '显示文章来源', 'new' ),
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
					'label' => __( '访问次数', 'new' ),
					'name' => 'new-article-views',
					'type' => 'number',
					'instructions' => __( '文章的已访问次数', 'new' ),
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
			'title' => __( '分类目录字段', 'new' ),
			'fields' => array (
				array (
					'key' => 'field_53e19dd6d5ccb',
					'label' => __( '所属文章类型', 'new' ),
					'name' => 'new-post-type',
					'type' => 'select',
					'instructions' => __( '通过不同文章类型调用不同模板', 'new' ),
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

/**
 * 自定义文章类型
 */
function new_post_type_init() {
    // 图片集
    register_post_type( 'gallery', 
        array(
            'labels' => array(
                'name' => __( '图片集', 'new' ),
                'singular_name' => __( '图片集', 'new' ),
                'add_new' => __( '添加图片集', 'new' ),
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
            'query_var' => false,
            'rewrite' => array(
                'with_front' => false,
            )
        )
    );

    // 资源
    register_post_type( 'resource',
        array(
            'labels' =>array(
                'name' => __( '资源', 'new' ),
                'singular_name' => __( '资源', 'new' ),
                'add_new' => __( '添加新资源', 'new' ),
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
            'query_var' => false,
            'rewrite' => array(
                'with_front' => false,
            )
        )
    );
    // 商品
    register_post_type( 'ware',
        array(
            'labels' =>array(
                'name' => __( '商品', 'new' ),
                'singular_name' => __( '商品', 'new' ),
                'add_new' => __( '添加新商品', 'new' ),
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
            'query_var' => false,
            'rewrite' => array(
                'with_front' => false,
            )
        )
    );
}

add_action( 'init', 'new_post_type_init' );


/* !init */


/* action */

/**
 * 添加默认主题支持
 */
function new_setup() {
	load_theme_textdomain( 'new', get_template_directory() . '/languages' );
	add_theme_support( 'custom-header' );
	add_theme_support( 'custom-background' );
	add_theme_support( 'post-thumbnails' );
    $args = array(
        'default-color' => '',
        'default-image' => '',
    );
    $args = apply_filters( 'new_custom_background_args', $args );
    add_theme_support( 'custom-background', $args );

    register_nav_menus(
        array(
            'navigation-main' => __( '主导航栏', 'new' ),
            'navigation-footer' => __( '脚部附加导航栏', 'new' ),
        )
    );
}
add_action( 'after_setup_theme', 'new_setup' );

/**
 * 添加模板样式及脚本
 */
function new_add_styles() {
    // 仅单页（page / singular）不使用模板
    if ( is_home()
      || is_preview()
      || is_archive()
      || is_attachment()
      || is_author()
      || is_category()
      || is_search()
      || is_single()
      || is_tag() ) {
        wp_enqueue_style( 'google-fonts', 'http://fonts.useso.com/css?family=Merriweather+Sans:400,300,700,800', array(), null );
        wp_enqueue_style( 'new-style', get_stylesheet_uri(), array(), null );
        if ( wp_style_is( 'jquery-ui' ) ) {
        wp_dequeue_style( 'jquery-ui' );
        }
    }
    if ( is_singular()
      || is_page() ) {
        
    }
}
add_action( 'wp_enqueue_scripts', 'new_add_styles' );

function new_add_scripts() {
    if ( is_home()
      || is_preview()
      || is_archive()
      || is_attachment()
      || is_author()
      || is_category()
      || is_search()
      || is_single()
      || is_tag() ) {
	wp_enqueue_script( 'new-jquery', get_template_directory_uri() . '/js/jquery.js', array(), '1.9.1' );
	wp_enqueue_script( 'new-ui', get_template_directory_uri() . '/js/ui.js', array(), '1.10.2' );
	wp_enqueue_script( 'new-carouFreSel', get_template_directory_uri() . '/js/carouFredSel.js', array(), '6.0.4' );
	wp_enqueue_script( 'new-supserfish', get_template_directory_uri() . '/js/superfish.js', array(), '1.4.8' );
	wp_enqueue_script( 'new-customM', get_template_directory_uri() . '/js/customM.js', array(), '2.6.2' );
	wp_enqueue_script( 'new-flexslider', get_template_directory_uri() . '/js/flexslider-min.js', array(), '2.1' );
	wp_enqueue_script( 'new-mobilemenu', get_template_directory_uri() . '/js/mobilemenu.js', array(), '1.0' );
    wp_enqueue_script( 'new', get_template_directory_uri() . '/js/new.js', array(), '1.0' );
    }

    if ( is_singular()
      || is_page() ) {
        
    }
}
add_action( 'wp_enqueue_scripts', 'new_add_scripts' );

/**
 * 小部件注册
 */
function new_widgets_init() {
	register_sidebar( array(
		'name'          => 'sidebar-main-slider',
		'id'            => 'sidebar-main-slider',
		'class'			=> '',
		'description'   => __( '在你的主页左侧显示的控件', 'new' ),
		'before_widget' => '<div class="main-slider">',
		'after_widget'  => '</div>',
		'before_title'  => '',
		'after_title'   => '',
	) );
	register_sidebar( array(
		'name'          => 'sidebar-slider2',
		'id'            => 'sidebar-slider2',
		'class'			=> '',
		'description'   => __( '在你的主页右侧显示的控件', 'new' ),
		'before_widget' => '<div class="slider2">',
		'after_widget'  => '</div>',
		'before_title'  => '',
		'after_title'   => '',
	) );
	register_sidebar( array(
		'name'          => 'sidebar-home-footer',
		'id'            => 'sidebar-home-footer',
		'class'			=> '',
		'description'   => __( '在你的主页脚部显示的控件', 'new' ),
		'before_widget' => '<div class="column-two-third">',
		'after_widget'  => '</div>',
		'before_title'  => '',
		'after_title'   => '',
	) );
    register_sidebar( array( 
		'name'          => 'sidebar-category-side',
		'id'            => 'sidebar-category-side',
		'class'			=> '',
		'description'   => __( '在你所有的分类中显示的控件', 'new' ),
		'before_widget' => '<div class="sidebar">',
		'after_widget'  => '</div>',
		'before_title'  => '',
		'after_title'   => '',
    ) );
    register_sidebar( array( 
		'name'          => 'sidebar-side',
		'id'            => 'sidebar-side',
		'class'			=> '',
		'description'   => __( '在你主页右侧显示的控件', 'new' ),
		'before_widget' => '<div class="sidebar">',
		'after_widget'  => '</div>',
		'before_title'  => '',
		'after_title'   => '',
    ) );
}
add_action( 'widgets_init', 'new_widgets_init' );

/**
 * 主色调颜色注册
 */
function new_custom_color_register( $wp_customize ) {
	$colors = array();
	
	$colors[] = array(
		'slug'=>'color_primary', 
		'default' => '#ea4748',
		'label' => __( '主色调', 'new' )
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

/**
 * 主色调颜色调用
 */
function new_add_css_styles() { 
	$color_primary = get_option('color_primary');
    // $color_primary_2 = '#' . max( dechex( hexdec( $color_primary ) - 0x323333 ), '0x000000' );
    // $color_primary_2 = '#' . sprintf( '%06X',  max( hexdec( $color_primary ) - 0x323333, 0 ) );
	$color_primary_2 = $color_primary;
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
.pager span.current,
.navbar .next:hover,
.navbar .prev:hover {
background: <?php echo $color_primary; ?>;
background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(<?php echo $color_primary; ?>), to(<?php echo $color_primary_2; ?>)); /* Safari 4-5, Chrome 1-9 */ 
background: -webkit-linear-gradient(top, <?php echo $color_primary; ?>, <?php echo $color_primary_2; ?>);/* Safari 5.1, Chrome 10+ */  
background: -moz-linear-gradient(top, <?php echo $color_primary; ?>, <?php echo $color_primary_2; ?>); /* Firefox 3.6+ */ 
background: -ms-linear-gradient(top, <?php echo $color_primary; ?>, <?php echo $color_primary_2; ?>); /* IE 10 */ 
background: -o-linear-gradient(top, <?php echo $color_primary; ?>, <?php echo $color_primary_2; ?>);/* Opera 11.10+ */ 
}
input#submit:hover,
input.post-comment:hover,
.navbar .next:hover,
.navbar .prev:hover {
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

/** 
* Converts bytes into human readable file size. 
* 
* @param string $bytes 
* @return string human readable file size (2,87)
* @author Mogilev Arseny 
*/  
function FileSizeConvert($bytes)
{
    $bytes = floatval($bytes);
        $arBytes = array(
            0 => array(
                "UNIT" => "TB",
                "VALUE" => pow(1024, 4)
            ),
            1 => array(
                "UNIT" => "GB",
                "VALUE" => pow(1024, 3)
            ),
            2 => array(
                "UNIT" => "MB",
                "VALUE" => pow(1024, 2)
            ),
            3 => array(
                "UNIT" => "KB",
                "VALUE" => 1024
            ),
            4 => array(
                "UNIT" => "B",
                "VALUE" => 1
            ),
        );

    foreach($arBytes as $arItem)
    {
        if($bytes >= $arItem["VALUE"])
        {
            $result = $bytes / $arItem["VALUE"];
            $result = str_replace(".", "," , strval(round($result, 2)))." ".$arItem["UNIT"];
            break;
        }
    }
    return $result;
}

/**
 * 文章默认属性计算，累计及赋值
 */
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
            update_field( 'new-article-views', rand( 0, get_option( 'new_theme_heat_limit' ) ), $post_ID );
        }

        $size = get_field( 'size', $post_ID );
        $file = get_field( 'file', $post_ID );
        if ( empty( $size ) && ! empty( $file ) ) {
            $file_path = WP_CONTENT_DIR . '/uploads/' . wp_get_attachment_metadata( $file )['file'];
            $file_size = FileSizeConvert( filesize( $file_path ) );
            update_field( 'field_53e2e24507824', $file_size, $post_ID );
        }
    }
}
add_action('wp_head', 'set_post_views'); 
add_action('save_post', 'set_post_views'); 

/* !action */


/* filter */

/**
 * 导航样式设置
 */
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

/**
 * 分类目录针对不同文章类型的模板筛选
 */
function new_filter_category_template( $template_path ) {
    $post_type = get_field( 'new-post-type', get_queried_object() );
    $template = get_template_directory() . '/category-' . $post_type . '.php';
    if ( $post_type != 'post' && file_exists( $template ) ) {
        $template_path = $template;
    }
    return $template_path;
}
add_filter( 'category_template', 'new_filter_category_template' );

/**
 * 文章针对不同文章类型的模板筛选
 */
function new_filter_single_template( $template_path ) {
    $post_type = get_queried_object()->post_type;
    $template = get_template_directory() . '/single-' . $post_type . '.php';
    if ( $post_type != 'post' && file_exists( $template ) ) {
        $template_path = $template;
    }
    return $template_path;
}
add_filter( 'single_template', 'new_filter_single_template' );


/**
 * 去除移动端浏览时的背景，减少流量
 */
function new_filter_background_color( $classes ) {
    if ( wp_is_mobile() ) {
        unset( $classes[ array_search( 'custom-background', $classes ) ] );
    }
    return $classes;
}
add_filter( 'body_class', 'new_filter_background_color' );

function new_filter_the_title( $title, $id = null ) {
    $flags = get_field( 'new-article-flags' );
    if ( is_array( $flags ) ) {
        if ( array_search( 'bold', $flags) !== false ) {
            $title = '<strong>' . $title . '</strong>';
        }
    }
    return $title;
}
add_filter( 'the_title', 'new_filter_the_title' );

/**
 * 针对中文链接与文章采集防范所设置的固定连接更改
 */
function new_filter_permalink( $link ) {
    if ( preg_match( "/(^[0-9]+$)|([\x80-\xff])/", $link ) )
        return md5( $link . time() );
    else
        return $link;
}
add_filter( 'editable_slug', 'new_filter_permalink' );

/* !filter */


/* shortcode */

function new_shortcode_gallery( $atts ) {
    $atts = shortcode_atts( array(
        'link'  => '',
        'ids'   => '',
        'size'  => 'md',
    ), $atts );
    $ids = explode( ',', $atts['ids'] );
?>
<div class="flexslider">
    <ul class="slides">
<?php foreach( $ids as $id ) : ?>
        <li><?php echo wp_get_attachment_image( $id, $atts['size'] ); ?></li>
<?php endforeach; ?>
    </ul>
</div>
<?php
}
add_shortcode( 'gallery', 'new_shortcode_gallery' );

/* !shortcode */


/* other function */

// in the loop
function new_get_thumbnail_src( $size ) {
    return wp_get_attachment_image_src( '' == get_post_thumbnail_id() ? get_option( 'new_theme_default_thumbnail_id' ) : get_post_thumbnail_id(), $size )[0]; 
}

// in the loop
function new_get_thumbnail_alt() {
    return strip_tags( get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', true ) );
}

// in the loop
function new_get_rating() {
    $w = get_field( 'new-article-views' ) / _filter_empty_numeric( get_option( 'new_theme_heat_limit' ), 400 );
    $w = $w > 1 ? 100 : $w * 100;
    return $w;
}

function new_get_gallery_shortcode() {
    $content = get_the_content();
    $matches = array();
    $count = preg_match( '/(\[gallery[\s\S]+?\])/', $content, $matches );
    if ( $count !== 0 ) {
        // echo do_shortcode( $matches[0] );
        $shortcode = $matches[0];
        if ( strpos( $shortcode, 'size' ) === false ) {
            $shortcode = str_replace( 'gallery', 'gallery size="xs"', $shortcode );
        }
        do_shortcode( $shortcode );
    }
    //echo $content;
}

function _new_sort_modules( $a, $b ) {
    if ( $a['module_weight'] < $b['module_weight'] ) return -1; 
    elseif ( $a['module_weight'] > $b['module_weight'] ) return 1; 
    else return 0;
}
function _new_filter_modules( $v ) {
    if ( $v['module_status'] == 0 ) return false;
    else return true;
}
function new_modules() {
    $modules_data = get_option( 'modules_data' );
    usort( $modules_data, '_new_sort_modules' );
    $modules_data = array_filter( $modules_data, '_new_filter_modules' );
    return $modules_data;
}

function new_get_module( $id ) {
    $modules_data = get_option( 'modules_data' );
    foreach ( $modules_data as $module ) {
        if ( $module['module_id'] == $id )
            return $module;
    }
    return false;
}

/* !other function */

