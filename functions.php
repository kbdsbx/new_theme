<?php

DEFINE( 'new_template_uri', get_template_directory_uri() );
DEFINE( 'new_plugins_uri', get_template_directory_uri() . '/plugins' );
DEFINE( 'new_classes_uri', get_template_directory_uri() . '/classes' );
DEFINE( 'new_inc_uri', get_template_directory_uri(). '/includes' );
DEFINE( 'new_template', get_template_directory() );
DEFINE( 'new_plugins', get_template_directory() . '/plugins' );
DEFINE( 'new_classes', get_template_directory() . '/classes' );
DEFINE( 'new_inc', get_template_directory(). '/includes' );

require 'advanced-custom-fields/acf.php';
define( 'ACF_LITE', false );

include_once new_inc . '/external_functions.php';
include_once new_inc . '/widget_functions.php';
include_once new_inc . '/filter_functions.php';
include_once new_inc . '/post_functions.php';

include_once new_plugins . '/slider_widget.php';
include_once new_plugins . '/tabs_widget.php';
include_once new_plugins . '/flink_widget.php';
include_once new_plugins . '/follow_widget.php';
include_once new_plugins . '/picture_widget.php';
include_once new_plugins . '/ads_widget.php';

include_once new_plugins . '/flink_page.php';
include_once new_plugins . '/modules_page.php';
include_once new_plugins . '/theme_setting_page.php';
include_once new_plugins . '/rss-importer.php';

include_once new_classes . '/class-new-flink-list-table.php';
include_once new_classes . '/class-new-comment-walker.php';
include_once new_classes . '/class-new-modules-list-table.php';
include_once new_classes . '/class-new-walker-category-radiolist.php';

/* init */

/**
 * 关闭google fonts / ajax apis，或启用360(useso)源 
 */
function new_filter_style_init( $src ) {
    $src = preg_replace( '/([a-z]+?)\\.googleapis\\.com/', '$1.useso.com', $src );
    return $src;
}
add_filter( 'script_loader_src', 'new_filter_style_init' );
add_filter( 'style_loader_src', 'new_filter_style_init' );

/**
 * 使用smtp发送邮件
 */
function new_mail_smtp( $phpmailer ) {

    $phpmailer->IsSMTP();
    $phpmailer->From = "kbdsbx@qq.com";
    $phpmailer->SMTPAuth = true;//启用SMTPAuth服务
    $phpmailer->Port = 25;//MTP邮件发送端口，这个和下面的对应，如果这里填写25，则下面为空白
    $phpmailer->SMTPSecure = "";//是否验证 ssl，这个和上面的对应，如果不填写，则上面的端口须为25
    $phpmailer->Host = "smtp.qq.com";//邮箱的SMTP服务器地址，如果是QQ的则为：smtp.exmail.qq.com
    $phpmailer->Username = "kbdsbx@qq.com";//你的邮箱地址
    $phpmailer->Password ="mtzk9b";//你的邮箱登陆密码
}
add_action( 'phpmailer_init', 'new_mail_smtp' );

/**
 * 初始化全局变量
 *
 * @global array $size_enum 自定义图片规格
 * @global array $post_types 自定义文章类型
 * @global array $post_types_keys 文章类型部分API调用需要
 * @global array $new_module_type 首页模块类型
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

    $post_types = array( 
        'post' => __( '文章', 'new' ), 
        'gallery' => __( '图集', 'new' ), 
        'resource' => __( '资源', 'new' ), 
        'ware' => __( '商品', 'new' ) 
    );
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
            ),
            'menu_icon' => 'dashicons-format-gallery'
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
            ),
            'menu_icon' => 'dashicons-media-archive'
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
            ),
            'menu_icon' => 'dashicons-cart'
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
 * 添加模板样式
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
      || is_tag()
      || is_404() ) {
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

/**
 * 添加模板脚本
 */
function new_add_scripts() {
    if ( is_home()
      || is_preview()
      || is_archive()
      || is_attachment()
      || is_author()
      || is_category()
      || is_search()
      || is_single()
      || is_tag()
      || is_404() ) {
	wp_enqueue_script( 'new-jquery', get_template_directory_uri() . '/js/new/jquery.js', array(), '1.9.1' );
	wp_enqueue_script( 'new-jquery-migrate', get_template_directory_uri() . '/js/new/jquery-migrate.js', array(), '1.2.1' );
	wp_enqueue_script( 'new-ui', get_template_directory_uri() . '/js/new/ui.js', array(), '1.10.2' );
	wp_enqueue_script( 'new-carouFreSel', get_template_directory_uri() . '/js/new/carouFredSel.js', array(), '6.0.4' );
	wp_enqueue_script( 'new-supserfish', get_template_directory_uri() . '/js/new/superfish.js', array(), '1.4.8' );
	wp_enqueue_script( 'new-customM', get_template_directory_uri() . '/js/new/customM.js', array(), '2.6.2' );
	wp_enqueue_script( 'new-flexslider', get_template_directory_uri() . '/js/new/flexslider-min.js', array(), '2.1' );
	wp_enqueue_script( 'new-mobilemenu', get_template_directory_uri() . '/js/new/mobilemenu.js', array(), '1.0' );
    wp_enqueue_script( 'new', get_template_directory_uri() . '/js/new/new.js', array(), '1.0' );
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

if ( function_exists( 'get_field' ) && function_exists( 'update_field' ) ) {

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

}

/* !action */


/* filter */

/**
 * 重制修改密码发送邮件
 */
function new_filter_retrieve_password_message( $msg, $key ) {
	if ( strpos($_POST['user_login'], '@') ) {
		$user_data = get_user_by('email', trim($_POST['user_login']));
	} else {
		$login = trim($_POST['user_login']);
		$user_data = get_user_by('login', $login);
	}
	$user_login = $user_data->user_login;
	$msg = __('有人要求重设如下帐号的密码：'). "\r\n\r\n";
	$msg .= network_site_url() . "\r\n\r\n";
	$msg .= sprintf(__('用户名：%s'), $user_login) . "\r\n\r\n";
	$msg .= __('若这不是您本人要求的，请忽略本邮件，一切如常。') . "\r\n\r\n";
	$msg .= __('要重置您的密码，请打开下面的链接：'). "\r\n\r\n";
	$msg .= network_site_url("login?action=rp&key=$key&login=" . rawurlencode($user_login), 'login') ;
	return $msg;
}
add_filter( 'retrieve_password_message', 'new_filter_retrieve_password_message', null, 2 );

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
 * 针对中文链接与文章采集防范所设置的固定链接更改
 * 使用Unix时间戳防止相同标题导致相同固定链接
 */
function new_filter_permalink( $link ) {
    if ( preg_match( "/(^[0-9]+$)|([\x80-\xff])/", $link ) )
        return CUtf8_PY::encode( $link, '', 'head' ) . date( 'Ymdhis', time() );
    else
        return $link;
}
add_filter( 'editable_slug', 'new_filter_permalink' );

/**
 * wpuf
 */
function new_wpuf_filter_post_status( $show_status, $status ) {
    switch ( $status ) {
    case 'publish':
        $title = __( '已发布', 'new' );
        $fontcolor = "#33CC33";
        $icon = "icon-ok-circle";
        break;
    case 'draft':
        $title = __( '草稿', 'new' );
        $fontcolor = "#bbbbbb";
        $icon = "icon-file-alt";
        break;
    case 'pending':
        $title = __( '等待审核', 'new' );
        $fontcolor = "#C00202";
        $icon = "icon-question-sign";
        break;
    case 'future':
        $title = __( '定时发布', 'new' );
        $fontcolor = "#bbbbbb";
        $icon = "icon-time";
        break;
    case 'private':
        $title = __( '私人', 'new' );
        $fontcolor = "#bbbbbb";
        $icon = "icon-lock";
        break;
    }
    $show_status = '<span style="color:' . $fontcolor . ';"><i class="' . $icon . '"></i>&nbsp;&nbsp;' . $title . '</span>';
    return $show_status;
}
add_filter( 'wpuf_show_post_status', 'new_wpuf_filter_post_status', 10, 2 );

/**
 * 修改页面模板，未完成
 * TODO:
 */
function new_filter_page_template( $page ) {
    $pages = array(
        'dashboard',
        'add_new',
        'edit',
        'favourite',
        'pm',
        'info',
        'membership-Account',
        'membership-billing',
        'membership-cancel',
        'membership-checkout',
        'membership-confirmation',
        'membership-invoice',
        'membership-levels',
        'protected-content',
        'reigster'
    );
    if ( is_page() ) {
        if ( is_page( $pages ) ) {
            $new_template = locate_template( array( 'page-user.php' ) );
            if ( '' != $new_template ) {
                return $new_template;
            } else {
                return $page;
            }
        }
        return $page;
    }
    return $page;
}
add_filter( 'template_include', 'new_filter_page_template' );

/**
 * 仅更改私人会话（站内信）会员头像
 */
function new_filter_avatar( $avatar ) {
    if ( ! empty( $avatar ) && is_page( 'pm' ) ) {
        return str_replace( 'photo', 'photo pull-left', $avatar );
    }
    return $avatar;
}
add_filter( 'get_avatar', 'new_filter_avatar' );

/**
 * 修改文章分类目录选择形式，使用自定义new_walker_category_radiolist将其更改为单项选择
 */
function wp_terms_checklist_args( $args ) {
    if ( $args['taxonomy'] == 'category' ) {
        $args['walker'] = new New_Walker_Category_Radiolist();
    }

    return $args;
}
add_filter( 'wp_terms_checklist_args', 'wp_terms_checklist_args' );

/**
 * 过滤文章分类目录选择形式
 */
function wp_filter_get_terms( $terms, $taxonomies, $args ) {
    global $post;
    $post_type = isset( $post->post_type ) ? $post->post_type : ( isset( $_REQUEST['post_type'] ) ? $_REQUEST['post_type'] : '' );
    if ( in_array( 'category', $taxonomies ) ) {
        foreach ( $terms as $key => $term ) {
            $category_post_type = get_field( 'new-post-type', 'category_' . $terms[ $key ]->term_id );
            if ( ! empty( $post_type ) && ! empty( $category_post_type ) && $post_type != $category_post_type ) {
                unset( $terms[ $key ] );
            }
        }
    }
    return $terms;
}
add_filter( 'get_terms', 'wp_filter_get_terms', 10, 3 );

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


