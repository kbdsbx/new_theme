<?php

$categories = array(
    'dashboard' => array( 'slug' => 'dashboard', 'title' => __( '我的文章', 'new' ), 'icon' => 'icon-dashboard' ),
    'add_new' => array( 'slug' => 'add_new', 'title' => __( '发布文章', 'new' ), 'icon' => 'icon-edit' ),
    'favourite' => array( 'slug' => 'favourite', 'title' => __( '我的收藏', 'new' ), 'icon' => 'icon-heart' ),
    'pm' => array( 'slug' => 'pm', 'title' => __( '站内信息', 'new' ), 'icon' => 'icon-envelope' ),
    'c' => array( 'slug' => 'c', 'title' => __( '消费清单', 'new' ), 'icon' => 'icon-shopping-cart' ),
    'd' => array( 'slug' => 'd', 'title' => __( '订单查询', 'new' ), 'icon' => 'icon-list' ),
    'e' => array( 'slug' => 'e', 'title' => __( '账户充值', 'new' ), 'icon' => 'icon-jpy' ),
    'info' => array( 'slug' => 'info', 'title' => __( '编辑资料', 'new' ), 'icon' => 'icon-cog' ),
);

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=<?php bloginfo( 'charset' ); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="keywords" content="<?php bloginfo( 'keyword' ); ?>" />
    <meta name="description" content="<?php bloginfo( 'description' ); ?>" />
    <title><?php wp_title( '|', true, 'right' ); ?></title>
    <?php wp_head(); ?>
    <!-- basic styles -->
    <link rel="stylesheet" href="<?php echo new_template_uri; ?>/css/member/bootstrap.min.css" />
    <link rel="stylesheet" href="<?php echo new_template_uri; ?>/css/member/font-awesome.min.css" />
    <link rel="stylesheet" href="http://fonts.useso.com/css?family=Open+Sans:400,300" />
    <link rel="stylesheet" href="<?php echo new_template_uri; ?>/css/member/ace.min.css" />
    <link rel="stylesheet" href="<?php echo new_template_uri; ?>/css/member/ace-rtl.min.css" />
    <!--[if IE 7]>
    <link rel="stylesheet" href="<?php echo new_template_uri; ?>/css/member/font-awesome-ie7.min.css" />
    <![endif]-->

    <!-- page specific plugin styles -->

    <!--[if lte IE 8]>
    <link rel="stylesheet" href="<?php echo new_template_uri; ?>/css/member/ace-ie.min.css" />
    <![endif]-->

    <!-- inline styles related to this page -->

</head>
<body <?php body_class( array( 'navbar-fixed', 'breadcrumbs-fixed' ) ); ?>>
    <div class="navbar navbar-default navbar-fixed-top" id="navbar">
        <div class="navbar-container" id="navbar-container">
            <div class="navbar-header pull-left">
                <a href="<?php echo home_url( '/' ); ?>" class="navbar-brand">
                    <small><i class="icon-leaf"></i>&nbsp;&nbsp;<?php echo get_option( 'blogname' ); ?></small>
                </a>
            </div>
            <div class="navbar-header pull-right" role="navigation">
                <ul class="nav ace-nav">
                    <li class="green">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="javascript:void(0);">
                            <i class="icon-envelope icon-animated-vertical"></i>
                            <span class="badge badge-important">8</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="main-container container" id="main-container">
        <div class="main-container-inner">
            <a class="menu-toggler" id="menu-toggler" href="#">
				<span class="menu-text"></span>
			</a>
            <div class="sidebar sidebar-fixed" id="sidebar">
                <ul class="nav nav-list">
                    <?php foreach( $categories as $k => $category ) : ?>
                    <li <?php if ( is_page( $category['slug'] ) ) echo 'class="active"'; ?>>
                        <a href="<?php echo home_url( '/' . $category['slug'] ); ?>">
                            <i class="<?php echo $category['icon']; ?>"></i>
                            <span class="menu-text"><?php echo $category['title']; ?></span>
                        </a>
                    </li>
                    <?php endforeach; ?>
                </ul>
                <div class="sidebar-collapse" id="sidebar-collapse">
					<i class="icon-double-angle-left" data-icon1="icon-double-angle-left" data-icon2="icon-double-angle-right"></i>
				</div>
            </div>
