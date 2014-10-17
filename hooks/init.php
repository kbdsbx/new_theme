<?php

/* init */

/**
 * 初始化全局变量
 *
 * @global array $size_enum 自定义图片规格
 * @global array $post_types 自定义文章类型
 * @global array $post_types_keys 文章类型部分API调用需要
 * @global array $new_module_type 首页模块类型
 * @global array $new_post_flags 文章标记
 */
function new_enum_init() {
	
	global $size_enum, $post_types, $post_types_keys, $new_module_type, $new_post_flags;
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

    $new_post_flags = array(
        'headline' => __( '头条', 'new' ),
        'recommend' => __( '推荐', 'new' ),
        'slider' => __( '幻灯', 'new' ),
        'special' => __( '特别推荐', 'new' ),
        'roll' => __( '滚动', 'new' ),
        'bold' => __( '加粗', 'new' ),
    );
}

add_action( 'init', 'new_enum_init' );

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
            'menu_icon' => 'dashicons-cart'
        )
    );
}

add_action( 'init', 'new_post_type_init' );

/**
 * 隐藏非管理员用户管理顶部栏
 */
function new_remove_adminbar() {
    if ( ! current_user_can( 'manage_options' ) ) {
        add_filter( 'show_admin_bar', '__return_false' );
    }
}
add_action( 'init', 'new_remove_adminbar' );

/**
 * 小部件注册
 */
function new_widgets_init() {
	register_sidebar( array(
		'name'          => __( '主页左上栏', 'new' ),
		'id'            => 'sidebar-home-left',
		'class'			=> '',
		'description'   => __( '在你的主页左侧显示的控件，推荐使用幻灯片', 'new' ),
		'before_widget' => '<div class="main-slider">',
		'after_widget'  => '</div>',
		'before_title'  => '',
		'after_title'   => '',
	) );
	register_sidebar( array(
		'name'          =>  __( '主页右上栏', 'new' ),
		'id'            => 'sidebar-home-right',
		'class'			=> '',
		'description'   => __( '在你的主页右侧显示的控件，推荐使用切换控件、图片广告', 'new' ),
		'before_widget' => '<div class="slider2">',
		'after_widget'  => '</div>',
		'before_title'  => '',
		'after_title'   => '',
	) );
    register_sidebar( array( 
		'name'          => __( '主页侧边栏', 'new' ),
		'id'            => 'sidebar-home-side',
		'class'			=> '',
		'description'   => __( '在你主页右侧显示的控件', 'new' ),
		'before_widget' => '<div class="sidebar">',
		'after_widget'  => '</div>',
		'before_title'  => '',
		'after_title'   => '',
    ) );
	register_sidebar( array(
		'name'          => __( '主页底部栏', 'new' ),
		'id'            => 'sidebar-home-footer',
		'class'			=> '',
		'description'   => __( '在你的主页脚部显示的控件，推荐使用友情链接', 'new' ),
		'before_widget' => '<div class="column-two-third">',
		'after_widget'  => '</div>',
		'before_title'  => '',
		'after_title'   => '',
	) );
    register_sidebar( array( 
		'name'          => __( '分类目录及文章侧边栏', 'new' ),
		'id'            => 'sidebar-category-side',
		'class'			=> '',
		'description'   => __( '在你所有的分类目录及文章中显示的控件', 'new' ),
		'before_widget' => '<div class="sidebar">',
		'after_widget'  => '</div>',
		'before_title'  => '',
		'after_title'   => '',
    ) );

}
add_action( 'widgets_init', 'new_widgets_init' );

/**
 * 使用smtp发送邮件
 * TODO
 */
function new_mail_smtp( $phpmailer ) {
    $phpmailer->IsSMTP();
    $phpmailer->From = "z@kbdsbx.com";
    $phpmailer->SMTPAuth = true;            //启用SMTPAuth服务
    $phpmailer->Port = 465;                 //MTP邮件发送端口，这个和下面的对应，如果这里填写25，则下面为空白
    $phpmailer->SMTPSecure = "ssl";         //是否验证 ssl，这个和上面的对应，如果不填写，则上面的端口须为25
    $phpmailer->Host = "smtp.qq.com";       //邮箱的SMTP服务器地址，如果是QQ的则为：smtp.exmail.qq.com
    $phpmailer->Username = "z@kbdsbx.com";  //你的邮箱地址
    $phpmailer->Password = "mtzk9b";        //你的邮箱登陆密码
}
add_action( 'phpmailer_init', 'new_mail_smtp' );

/* !init */

