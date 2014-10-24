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

require_once new_inc . '/external_functions.php';
require_once new_inc . '/widget_functions.php';
require_once new_inc . '/filter_functions.php';
require_once new_inc . '/post_functions.php';
require_once new_inc . '/page_functions.php';
require_once new_inc . '/category_functions.php';

require_once new_hooks . '/meta_box.php';
require_once new_hooks . '/init.php';
require_once new_hooks . '/category.php';
require_once new_hooks . '/post.php';
require_once new_hooks . '/theme.php';
require_once new_hooks . '/seo.php';
require_once new_hooks . '/plugins.php';
require_once new_hooks . '/shortcode.php';

require_once new_plugins . '/slider_widget.php';
require_once new_plugins . '/tabs_widget.php';
require_once new_plugins . '/flink_widget.php';
require_once new_plugins . '/follow_widget.php';
require_once new_plugins . '/picture_widget.php';
require_once new_plugins . '/ads_widget.php';

require_once new_plugins . '/flink_page.php';
require_once new_plugins . '/modules_page.php';
require_once new_plugins . '/theme_setting_page.php';
require_once new_plugins . '/rss-importer.php';

require_once new_classes . '/class-new-flink-list-table.php';
require_once new_classes . '/class-new-comment-walker.php';
require_once new_classes . '/class-new-modules-list-table.php';
require_once new_classes . '/class-new-walker-category-radiolist.php';

