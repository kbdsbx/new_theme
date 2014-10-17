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
include_once new_hooks . '/init.php';
include_once new_hooks . '/category.php';
include_once new_hooks . '/post.php';
include_once new_hooks . '/theme.php';
include_once new_hooks . '/seo.php';
include_once new_hooks . '/plugins.php';
include_once new_hooks . '/shortcode.php';

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

