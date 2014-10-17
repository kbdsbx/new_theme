<?php

/* theme */

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
 * 添加后台样式与脚本
 */
function new_admin_enqueue_scripts_styles() {
    if ( is_admin() ) {
        wp_enqueue_style( 'new-admin-style', new_template_uri . '/css/admin/style.css', array(), null );

        wp_enqueue_script( 'new-dc', new_template_uri . '/js/admin/dc.js', array(), '1.4.0', true );
    }
}
add_action( 'admin_enqueue_scripts', 'new_admin_enqueue_scripts_styles' );

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
        // wp_enqueue_style( 'new-flexslider', new_template_uri . '/css/new/reset.css', array(), '2.0' );
        wp_enqueue_style( 'google-fonts', 'http://fonts.useso.com/css?family=Merriweather+Sans:400,300,700,800', array(), null );
        wp_enqueue_style( 'new-flexslider', new_template_uri . '/css/new/flexslider.min.css', array(), '2.0' );
        wp_enqueue_style( 'new-ui', new_template_uri . '/css/new/ui.min.css', array(), '1.10.2' );
        wp_enqueue_style( 'new-base', new_template_uri . '/css/new/base.min.css', array(), null );
        wp_enqueue_style( 'new-style', new_template_uri . '/css/new/style.min.css', array(), '1.0.0' );

        wp_enqueue_style( 'new-fontello', new_template_uri . '/css/new/fontello/fontello.min.css', array(), null );

        wp_enqueue_style( 'new-960', new_template_uri . '/css/new/960.min.css', array(), '1.0' );
        wp_enqueue_style( 'new-1000', new_template_uri . '/css/new/devices/1000.min.css', array(), null );
        wp_enqueue_style( 'new-767', new_template_uri . '/css/new/devices/767.min.css', array(), null );
        wp_enqueue_style( 'new-479', new_template_uri . '/css/new/devices/479.min.css', array(), null );
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
        wp_enqueue_script( 'jquery-ui-core' );
        wp_enqueue_script( 'jquery-ui-tabs' );
        wp_enqueue_script( 'jquery-ui-accordion' );
        wp_enqueue_script( 'new-carouFreSel', new_template_uri . '/js/new/carouFredSel.min.js', array(), '6.0.4', true );
        wp_enqueue_script( 'new-supserfish', new_template_uri . '/js/new/superfish.min.js', array(), '1.4.8', true );
        wp_enqueue_script( 'new-customM', new_template_uri . '/js/new/customM.min.js', array(), '2.6.2', true );
        wp_enqueue_script( 'new-flexslider', new_template_uri . '/js/new/flexslider.min.js', array(), '2.1', true );
        wp_enqueue_script( 'new-mobilemenu', new_template_uri . '/js/new/mobilemenu.min.js', array(), '1.0', true );
        wp_enqueue_script( 'new', new_template_uri . '/js/new/new.js', array(), '1.0', true );
    }

    if ( is_singular()
      || is_page() ) {
    }
}
add_action( 'wp_enqueue_scripts', 'new_add_scripts' );

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
.badg,.search-form .fs,.user .ub,.flex-direction-nav a,.flexslider:hover .flex-next:hover,.flexslider:hover .flex-prev:hover,p.copyright,a.comment-reply-link:hover{ background-color: <?php echo $color_primary; ?>; }
a,.sf-menu li:hover,.sf-menu a:focus,.sf-menu a:hover,.sf-menu a:active,.sf-menu li a:hover,ul.sf-menu li.sfHover ul li:hover i,ul.sf-menu li.sfHover ul li a:hover,.block span,.block2 span,span.meta,.comment-data p span,.relatednews ul li span{ color: <?php echo $color_primary; ?> }
div#nav,.sf-menu li:hover ul, .sf-menu li.sfHover ul,.sf-menu>li>a:hover,.ui-tabs .ui-tabs-panel,.ui-tabs .ui-tabs-nav li.ui-tabs-active,h5.line,h5.line>span,#footer{ border-color: <?php echo $color_primary; ?>; }
input#submit,input.post-comment,.pager a:hover,.pager span.current,.navbar .next:hover,.navbar .prev:hover {background: <?php echo $color_primary; ?>;background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(<?php echo $color_primary; ?>), to(<?php echo $color_primary_2; ?>)); /* Safari 4-5, Chrome 1-9 */ background: -webkit-linear-gradient(top, <?php echo $color_primary; ?>, <?php echo $color_primary_2; ?>);/* Safari 5.1, Chrome 10+ */  background: -moz-linear-gradient(top, <?php echo $color_primary; ?>, <?php echo $color_primary_2; ?>); /* Firefox 3.6+ */ background: -ms-linear-gradient(top, <?php echo $color_primary; ?>, <?php echo $color_primary_2; ?>); /* IE 10 */ background: -o-linear-gradient(top, <?php echo $color_primary; ?>, <?php echo $color_primary_2; ?>);/* Opera 11.10+ */ }
input#submit:hover,input.post-comment:hover,.navbar .next:hover,.navbar .prev:hover {background: <?php echo $color_primary_2; ?>;background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(<?php echo $color_primary_2; ?>), to(<?php echo $color_primary; ?>)); /* Safari 4-5, Chrome 1-9 */ background: -webkit-linear-gradient(top, <?php echo $color_primary_2; ?>, <?php echo $color_primary; ?>);/* Safari 5.1, Chrome 10+ */  background: -moz-linear-gradient(top, <?php echo $color_primary_2; ?>, <?php echo $color_primary; ?>); /* Firefox 3.6+ */ background: -ms-linear-gradient(top, <?php echo $color_primary_2; ?>, <?php echo $color_primary; ?>); /* IE 10 */ background: -o-linear-gradient(top, <?php echo $color_primary_2; ?>, <?php echo $color_primary; ?>);/* Opera 11.10+ */ }
</style>

    <?php
}
add_action('wp_head', 'new_add_css_styles');

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
 * 去除移动端浏览时的背景，减少流量
 */
function new_filter_background_color( $classes ) {
    if ( wp_is_mobile() ) {
        unset( $classes[ array_search( 'custom-background', $classes ) ] );
    }
    return $classes;
}
add_filter( 'body_class', 'new_filter_background_color' );


/* !theme */
