<?php

DEFINE( 'new_template_uri', get_template_directory_uri() );
DEFINE( 'new_plugins_uri', get_template_directory_uri() . '/plugins' );
DEFINE( 'new_classes_uri', get_template_directory_uri() . '/classes' );
DEFINE( 'new_hooks_uri', get_template_directory_uri(). '/hooks' );
DEFINE( 'new_inc_uri', get_template_directory_uri(). '/includes' );
DEFINE( 'new_expand_uri', get_template_directory_uri(). '/expand' );
DEFINE( 'new_template', get_template_directory() );
DEFINE( 'new_plugins', get_template_directory() . '/plugins' );
DEFINE( 'new_classes', get_template_directory() . '/classes' );
DEFINE( 'new_hooks', get_template_directory(). '/hooks' );
DEFINE( 'new_inc', get_template_directory(). '/includes' );
DEFINE( 'new_expand', get_template_directory(). '/expand' );

include_once new_inc . '/external_functions.php';
include_once new_inc . '/widget_functions.php';
include_once new_inc . '/filter_functions.php';
include_once new_inc . '/post_functions.php';

include_once new_hooks . '/meta_box.php';

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
 * 自定义字段
 */
function new_field_init() {
    global $post_types;

	if(function_exists("register_field_group")) {
		register_field_group(array (
			'id' => '296',
			'title' => '资源字段',
			'fields' => array (
				array (
					'key' => 'field_53e1810d8dd21',
					'label' => '文件',
					'name' => 'file',
					'type' => 'file',
					'instructions' => '文件在本服务器的网络地址',
					'required' => 1,
					'save_format' => 'id',
					'library' => 'all',
				),
				array (
					'key' => 'field_53e181558dd22',
					'label' => '文件类型',
					'name' => 'type',
					'type' => 'select',
					'instructions' => '文件类型',
					'required' => 1,
					'choices' => array (
						'rich' => '富文本文件',
						'zip' => '压缩文件',
						'software' => '电脑软件',
						'app' => '手机APP',
						'audio' => '音频文件',
						'video' => '视频文件',
						'picture' => '图片文件',
						'other' => '其他',
					),
					'default_value' => 'other',
					'allow_null' => 0,
					'multiple' => 0,
				),
				array (
					'key' => 'field_53e2e24507824',
					'label' => '文件大小',
					'name' => 'size',
					'type' => 'text',
					'instructions' => '若留空，则自动计算文件大小',
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'formatting' => 'none',
					'maxlength' => '',
				),
				array (
					'key' => 'field_53e182a181b12',
					'label' => '文件类型-富文本',
					'name' => 'type-rich',
					'type' => 'select',
					'required' => 1,
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_53e181558dd22',
								'operator' => '==',
								'value' => 'rich',
							),
						),
						'allorany' => 'all',
					),
					'choices' => array (
						'doc' => '.doc',
						'docx' => '.docx',
						'txt' => '.txt',
						'pdf' => '.pdf',
						'rtf' => '.rtf',
						'ppt' => '.ppt',
						'xls' => '.xls',
						'xlse' => '.xlsx',
						'other' => '其他',
					),
					'default_value' => 'other',
					'allow_null' => 0,
					'multiple' => 0,
				),
				array (
					'key' => 'field_53e1833d53393',
					'label' => '文件类型-压缩文件',
					'name' => 'type-zip',
					'type' => 'select',
					'required' => 1,
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_53e181558dd22',
								'operator' => '==',
								'value' => 'zip',
							),
						),
						'allorany' => 'all',
					),
					'choices' => array (
						'zip' => '.zip',
						'7z' => '.7z',
						'rar' => '.rar',
						'gz' => '.gz',
						'iso' => '.iso',
						'jar' => '.jar',
						'cab' => '.cab',
						'tar' => '.tar',
						'other' => '其他',
					),
					'default_value' => 'other',
					'allow_null' => 0,
					'multiple' => 0,
				),
				array (
					'key' => 'field_53e183ca53394',
					'label' => '文件类型-电脑软件',
					'name' => 'type-software',
					'type' => 'select',
					'required' => 1,
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_53e181558dd22',
								'operator' => '==',
								'value' => 'software',
							),
						),
						'allorany' => 'all',
					),
					'choices' => array (
						'exe' => '.exe',
						'out' => '.out',
						'msi' => '.msi',
						'other' => '其他',
					),
					'default_value' => 'other',
					'allow_null' => 0,
					'multiple' => 0,
				),
				array (
					'key' => 'field_53e1845353395',
					'label' => '文件类型-手机APP',
					'name' => 'type-app',
					'type' => 'select',
					'required' => 1,
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_53e181558dd22',
								'operator' => '==',
								'value' => 'app',
							),
						),
						'allorany' => 'all',
					),
					'choices' => array (
						'apk' => '.akp',
						'app' => '.app',
						'other' => '其他',
					),
					'default_value' => 'other',
					'allow_null' => 0,
					'multiple' => 0,
				),
				array (
					'key' => 'field_53e1849453396',
					'label' => '文件类型-音频文件',
					'name' => 'type-audio',
					'type' => 'select',
					'required' => 1,
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_53e181558dd22',
								'operator' => '==',
								'value' => 'audio',
							),
						),
						'allorany' => 'all',
					),
					'choices' => array (
						'wav' => '.wav',
						'mp3' => '.mp3',
						'midi' => '.midi',
						'mid' => '.mid',
						'mmf' => '.mmf',
						'wma' => '.wma',
						'amr' => '.amr',
						'aac' => '.aac',
						'flv' => '.flv',
						'other' => '其他',
					),
					'default_value' => 'other',
					'allow_null' => 0,
					'multiple' => 0,
				),
				array (
					'key' => 'field_53e1852a53397',
					'label' => '文件类型-视频文件',
					'name' => 'type-video',
					'type' => 'select',
					'required' => 1,
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_53e181558dd22',
								'operator' => '==',
								'value' => 'video',
							),
						),
						'allorany' => 'all',
					),
					'choices' => array (
						'wmv' => '.wmv',
						'rmvb' => '.rmvb',
						'mpg' => '.mpg',
						'vod' => '.vod',
						'mov' => '.mov',
						'3gp' => '.3gp',
						'mp4' => '.mp4',
						'avi' => '.avi',
						'flv' => '.flv',
						'other' => '其他',
					),
					'default_value' => 'other',
					'allow_null' => 0,
					'multiple' => 0,
				),
				array (
					'key' => 'field_53e185a853398',
					'label' => '文件类型-图片文件',
					'name' => 'type-picture',
					'type' => 'select',
					'required' => 1,
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_53e181558dd22',
								'operator' => '==',
								'value' => 'picture',
							),
						),
						'allorany' => 'all',
					),
					'choices' => array (
						'bmp' => '.bmp',
						'png' => '.png',
						'jpeg' => '.jpeg',
						'jpg' => '.jpg',
						'tiff' => '.tiff',
						'gif' => '.gif',
						'exif' => '.exif',
						'psd' => '.psd',
						'cdr' => '.cdr',
						'pcd' => '.pcd',
						'other' => '其他',
					),
					'default_value' => 'other',
					'allow_null' => 0,
					'multiple' => 0,
				),
				array (
					'key' => 'field_54115caef80b2',
					'label' => '文件类型-其他',
					'name' => 'type-other',
					'type' => 'select',
					'required' => 1,
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_53e181558dd22',
								'operator' => '==',
								'value' => 'other',
							),
						),
						'allorany' => 'all',
					),
					'choices' => array (
						'other' => '其他',
					),
					'default_value' => 'other',
					'allow_null' => 0,
					'multiple' => 0,
				),
			),
			'location' => array (
				array (
					array (
						'param' => 'post_type',
						'operator' => '==',
						'value' => 'resource',
						'order_no' => 0,
						'group_no' => 0,
					),
				),
			),
			'options' => array (
				'position' => 'acf_after_title',
				'layout' => 'default',
				'hide_on_screen' => array (
				),
			),
			'menu_order' => 1,
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


/* !init */


/* action */

/**
 * 添加新增分类目录所需属性相关设置
 */
function new_category_form_fields() {
    global $post_types;
?>
<div class="form-field">
    <label for="new_post_type"><?php _e( '文章类型', 'new' ); ?></label>
    <select name="new_post_type" id="new_post_type" class="postform">
    <?php foreach ( $post_types as $key => $post_type ) : ?>
        <option value="<?php echo $key; ?>"><?php echo $post_type; ?></option>
    <?php endforeach; ?>
    </select> 
    <p><?php _e( '用于调用不同文章类型模板', 'new' ); ?></p>
</div>
<?php
}
add_action( 'category_add_form_fields', 'new_category_form_fields' );

/**
 * 添加编辑分类目录所需属性相关设置
 */
function new_category_edit_form_fields( $tag ) {
    global $post_types;
    $categories_post_type = _filter_empty_array( get_option( 'categories_post_type' ) );
?>
<tr class="form-field">
    <th scope="row"><label for="new_post_type"><?php _e( '文章类型', 'new' ); ?></label></th>
    <td>
        <select name="new_post_type" id="new_post_type" class="postform">
        <?php foreach ( $post_types as $key => $post_type ) : ?>
            <option value="<?php echo $key; ?>" <?php if( isset( $categories_post_type[ $tag->term_id ] ) && $categories_post_type[ $tag->term_id ] == $key ) { echo 'selected="selected"'; } ?>><?php echo $post_type; ?></option>
        <?php endforeach; ?>
        </select> 
		<p class="description"><?php _e( '用于调用不同文章类型模板', 'new' ); ?></p>
	</td>
</tr>
<?php
}
add_action( 'category_edit_form_fields', 'new_category_edit_form_fields' );

/**
 * 保存分类目录所需属性
 */
function new_category_save_fields( $term_id ) {
    $categories_post_type = _filter_empty_array( get_option( 'categories_post_type' ) );
    $categories_post_type[ $term_id ] = _filter_array_empty( $_POST, 'new_post_type', 'post' );
    update_option( 'categories_post_type', $categories_post_type );
}
add_action( 'created_category', 'new_category_save_fields' );
add_action( 'edited_category','new_category_save_fields' );

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
 * 过滤某些页面不需要的样式表
 */
function new_filter_styles() {
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
        // front-end-pm
        wp_dequeue_style( 'fep-style' );
        // user-frontend-pro
        wp_dequeue_style( 'wpuf-css' );
        wp_dequeue_style( 'wpuf-chosen-style' );
        // wp-pagenavi
        wp_dequeue_style( 'wp-pagenavi' );
        // paid-memberships-pro
        wp_dequeue_style( 'pmpro_frontend' );
        wp_dequeue_style( 'pmpro_print' );
        wp_dequeue_style( 'pmpro_frontend_rtl' );
    }
}
add_action( 'wp_print_styles', 'new_filter_styles', 100 );

/**
 * 过滤某些页面不需要的脚本文件
 */
function new_filter_scripts() {
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
        // front-end-pm
        wp_dequeue_script( 'fep-script' );
        // user-frontend-pro
        wp_dequeue_script( 'wpuf-chosen' );
        wp_dequeue_script( 'wpuf-form' );
        wp_dequeue_script( 'wpuf-conditional-logic' );
        wp_dequeue_script( 'wpuf-subscriptions' );
        wp_dequeue_script( 'jquery-ui-datepicker' );
        wp_dequeue_script( 'jquery-ui-autocomplete' );
        wp_dequeue_script( 'suggest' );
        wp_dequeue_script( 'jquery-ui-slider' );
        wp_dequeue_script( 'plupload-handlers' );
        wp_dequeue_script( 'jquery-ui-timepicker' );
        wp_dequeue_script( 'wpuf-upload' );
        wp_dequeue_script( 'wpuf-form' );
        wp_dequeue_script( 'wpuf-upload' );
        // paid-membership-pro
        wp_dequeue_script( 'ssmemberships_js' );
    }
}
add_action( 'wp_print_scripts', 'new_filter_scripts', 100 );

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
 * 文章默认属性计算，累计及赋值
 */
function set_post_views() {
    global $post;
    if ( ! isset ( $post->ID ) )
        return;

    if ( is_singular() ) {
        if ( isset( $post->ID ) ) {
            $new_post_options = get_post_meta( $post->ID, 'new_post_options', true );
            if ( $new_post_options ) {
                $new_post_options['new_post_view_count'] = $new_post_options['new_post_view_count'] + 1;
                update_post_meta( $post->ID, 'new_post_options', $new_post_options );
            }
        }
    }

    if ( is_admin() ) {
        if ( isset( $post->ID ) ) {
            $new_post_options = get_post_meta( $post->ID, 'new_post_options', true );
            if ( $new_post_options && isset( $new_post_options['new_post_view_count'] ) && $new_post_options['new_post_view_count'] == 0 ) {
                $new_post_options['new_post_view_count'] = rand( 0, _filter_empty_numeric( get_option( 'new_theme_heat_limit' ) ) );
                update_post_meta( $post->ID, 'new_post_options', $new_post_options );
            }
        }
    }
}
add_action('wp_head', 'set_post_views'); 
add_action('save_post', 'set_post_views'); 


/* !action */


/* filter */

/**
 * 处理bloginfo，使之显示更多有利于SEO的相关信息
 */
function new_filter_bloginfo( $bloginfo, $keyword ) {
    switch ( $keyword ) {
    case 'description':
        if ( is_category() ) {
            $category = get_category( get_query_var( 'cat' ), false );
            if ( ! empty( $category ) ) {
                $bloginfo = $category->category_description;
            } 
        } else if ( is_tag() ) {
            $tag = get_tag( get_query_var( 'tag' ), false );
            if ( ! empty ( $category ) ) {
                $bloginfo = $tag->description;
            }
        } else if ( is_single() || is_page() ) {
            $bloginfo = get_the_excerpt();
        }
        return $bloginfo;
    case 'keyword':
        if ( is_single() ) {
            $tags = get_the_tags();
            if ( $tags ) {
                foreach ( $tags as $tag ) {
                    $bloginfo .= ',' . $tag->name;
                }
            }
        }
        return $bloginfo;
    default:
        return $bloginfo;
    }
}
add_filter( 'bloginfo', 'new_filter_bloginfo', 10, 2 );

/**
 * 对网站title添加网站名称，利于SEO
 */
function new_filter_title_parts( $title ) {
    if ( is_category() ) {
    } else if ( is_single() ) {
        $categories = get_the_category();
        if ( $categories ) {
            foreach ( $categories as $category ) {
                $title[] = $category->name;
            }
        }
    }
    $title[] = get_bloginfo( 'name' );
    return $title;
}
add_filter( 'wp_title_parts', 'new_filter_title_parts', 10, 2 );

/**
 * 对网站title添加网站URL，利于SEO
 */
function new_filter_title( $title ) {
    return $title . get_bloginfo( 'url' );
}
add_filter( 'wp_title', 'new_filter_title' );

/**
 * 添加文章主循环中文章类型字段以保证分页时不会由于找不到文件而返回404
 */
function new_filter_request( $query_vars ) {
    global $post_types_keys;
    if ( ! is_admin() && isset( $query_vars['paged'] ) && isset( $query_vars['category_name'] ) ) {
        $query_vars['post_type'] = $post_types_keys;
    }
    return $query_vars;
}
add_filter( 'request', 'new_filter_request' );

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
    $cat_ID = get_query_var( 'cat' );
    $categories_post_type = get_option( 'categories_post_type' );
    $post_type = _filter_array_empty( $categories_post_type, $cat_ID, '' );
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
    global $post;
    $post_type = $post->post_type;
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

/**
 * 为标记为加粗的文章设置粗体
 */
function new_filter_the_title( $title, $id = null ) {
    if ( ! is_admin() ) {
        $flags = _filter_array_empty_array( get_post_meta( $id, 'new_post_options', true ), 'new_post_flags' );
        if ( array_search( 'bold', $flags) !== false ) {
            $title = '<strong>' . $title . '</strong>';
        }
    }
    return $title;
}
add_filter( 'the_title', 'new_filter_the_title', 10, 2 );

/**
 * 针对中文链接与文章采集防范所设置的固定链接更改
 * 使用Unix时间戳防止相同标题导致相同固定链接
 */
function new_filter_permalink( $link ) {
    if ( preg_match( "/(^[0-9]+$)|([\x80-\xff])/", $link ) )
        return CUtf8_PY::encode( $link, '', 'head' ) . date( 'ymdhis', time() );
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
        'account',
        'membership-account',
        'membership-billing',
        'membership-cancel',
        'membership-checkout',
        'membership-confirmation',
        'membership-invoice',
        'membership-levels',
        'protected-content',
        'reigster'
    );
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
add_filter( 'template_include', 'new_filter_page_template' );

/**
 * 仅更改私人会话（站内信）会员头像
 */
function new_filter_get_avatar( $avatar ) {
    if ( ! empty( $avatar ) && is_page( 'pm' ) ) {
        return str_replace( 'photo', 'photo pull-left', $avatar );
    }
    return $avatar;
}
add_filter( 'get_avatar', 'new_filter_get_avatar' );

/**
 * 修改文章分类目录选择形式，使用自定义new_walker_category_radiolist将其更改为单项选择
 */
function new_terms_checklist_args( $args ) {
    if ( $args['taxonomy'] == 'category' ) {
        $args['walker'] = new New_Walker_Category_Radiolist();
    }

    return $args;
}
add_filter( 'wp_terms_checklist_args', 'new_terms_checklist_args' );

/**
 * 过滤文章分类目录选择形式
 */
function new_filter_get_terms( $terms, $taxonomies, $args ) {
    global $post;

    $post_type = _filter_object_empty( $post, 'post_type', _filter_array_empty( $_REQUEST, 'post_type', '' ) );
    if ( in_array( 'category', $taxonomies ) ) {
        foreach ( $terms as $key => $term ) {
            $categories_post_type = get_option( 'categories_post_type' );
            $category_post_type = _filter_array_empty( $categories_post_type, _filter_object_empty( $term, 'term_id', '' ), '' );
            if ( ! empty( $post_type ) && ! empty( $category_post_type ) && $post_type != $category_post_type ) {
                unset( $terms[ $key ] );
            }
        }
    }
    return $terms;
}
add_filter( 'get_terms', 'new_filter_get_terms', 10, 3 );

/* !filter */


/* shortcode */

/**
 * 修改图片集显示方式
 */
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


