<!DOCTYPE html>
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

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

    <!--[if lt IE 9]>
    <script src="<?php echo new_template_uri; ?>/js/member/html5shiv.js"></script>
    <script src="<?php echo new_template_uri; ?>/js/member/respond.min.js"></script>
    <![endif]-->
</head>
<body <?php body_class( 'login-layout' ); ?>>
    <div class="main-container">
        <div class="main-content">
            <div class="row">
                <div class="col-sm-10 col-sm-offset-1">
                    <div class="login-container">
                        <div class="center">
                            <h1>
                                <i class="icon-leaf green"></i>
                                <span class="white"><?php echo get_option( 'blogname' ); ?></span>
                            </h1>
                            <h4 class="blue">&copy; <?php echo get_option( 'blogdescription' ); ?></h4>
                        </div>

                            <div class="space-6"></div>

                            <div class="position-relative">
                                <?php WPUF_Login::init()->show_errors(); ?>
                                <?php WPUF_Login::init()->show_messages(); ?>

                                <div id="login-box" class="login-box visible widget-box no-border">
                                    <div class="widget-body">
                                        <div class="widget-main">
                                               <h4 class="header blue lighter bigger">
                                                <i class="icon-coffee green"></i><?php _e( '登陆' ,'new' ); ?>
                                            </h4>

                                            <div class="space-6"></div>
                                            <p><?php _e( '请输入您的登入账户', 'new' ); ?></p>

                                            <form method="post" action="">
                                                <fieldset>
                                                    <label class="block clearfix">
                                                        <span class="block input-icon input-icon-right">
                                                            <input type="text" name="log" class="form-control" placeholder="<?php _e( 'Username' ); ?>" />
                                                            <i class="icon-user"></i>
                                                        </span>
                                                    </label>

                                                    <label class="block clearfix">
                                                        <span class="block input-icon input-icon-right">
                                                            <input type="password" name="pwd" class="form-control" placeholder="<?php _e( 'Password' ); ?>" />
                                                            <i class="icon-lock"></i>
                                                        </span>
                                                    </label>

                                                    <div class="space"></div>

                                                    <div class="clearfix">
                                                        <label class="inline">
                                                            <input type="checkbox" class="ace" />
                                                            <span class="lbl"><?php _e( '记住我', 'new' ); ?></span>
                                                        </label>

                                                        <button type="submit" class="width-35 pull-right btn btn-sm btn-primary">
                                                            <i class="icon-key"></i><?php _e( 'Log in' ); ?>

                                                        </button>
                                                        <input type="hidden" name="redirect_to" value="<?php echo WPUF_Login::get_posted_value( 'redirect_to' ); ?>" />
                                                        <input type="hidden" name="wpuf_login" value="true" />
                                                        <input type="hidden" name="action" value="login" />
                                                        <?php wp_nonce_field( 'wpuf_login_action' ); ?>
                                                    </div>

                                                    <div class="space-4"></div>
                                                </fieldset>
                                            </form>

                                            <div class="social-or-login center">
                                                <span class="bigger-110"><?php _e( '或使用以下方式登陆', 'new' ); ?></span>
                                            </div>

                                            <div class="social-login center">
                                                <a class="btn btn-primary">
                                                    <i class="icon-facebook"></i>
                                                </a>

                                                <a class="btn btn-info">
                                                    <i class="icon-twitter"></i>
                                                </a>

                                                <a class="btn btn-danger">
                                                    <i class="icon-google-plus"></i>
                                                </a>
                                            </div>
                                        </div><!-- /widget-main -->

                                        <div class="toolbar clearfix">
                                            <div>
                                                <a href="#" onclick="show_box('forgot-box'); return false;" class="forgot-password-link"><i class="icon-arrow-left"></i><?php _e( '忘记密码点我~', 'new' ); ?></a>
                                            </div>

                                            <div>
                                                <a href="#" onclick="show_box('signup-box'); return false;" class="user-signup-link"><?php _e( '想要注册点我~', 'new' ); ?><i class="icon-arrow-right"></i></a>
                                            </div>
                                        </div>
                                    </div><!-- /widget-body -->
                                </div><!-- /login-box -->
<?php if ( isset( $_REQUEST['action'] ) && $_REQUEST['action'] == 'rp' && isset( $_REQUEST['key'] ) && ! empty( $_REQUEST['key'] )  ) : ?>

                                <div id="forgot-box" class="forgot-box widget-box no-border">
                                    <div class="widget-body">
                                        <div class="widget-main">
                                            <h4 class="header red lighter bigger">
                                                <i class="icon-key"></i><?php _e( '重置密码' ,'new' ); ?>
                                            </h4>

                                            <div class="space-6"></div>
                                            <p><?php _e( '请重新设置您的密码', 'new' ); ?></p>
                                            <form method="post" action="">
                                                <fieldset>
                                                    <label class="block clearfix">
                                                        <span class="block input-icon input-icon-right">
                                                            <input type="password" class="form-control" name="pass1" placeholder="<?php _e( '密码', 'new' ); ?>" autocomplete="off" />
                                                            <i class="icon-lock"></i>
                                                        </span>
                                                    </label>
                                                    <label class="block clearfix">
                                                        <span class="block input-icon input-icon-right">
                                                            <input type="password" class="form-control" name="pass2" placeholder="<?php _e( '重复密码', 'new' ); ?>" autocomplete="off" />
                                                            <i class="icon-retweet"></i>
                                                        </span>
                                                    </label>
                                                    <?php do_action( 'resetpassword_form' ); ?>
                                                    <div class="clearfix">
                                                        <button type="submit" name="wp-submit" id="wp-submit" class="width-35 pull-right btn btn-sm btn-danger">
                                                            <i class="icon-lightbulb"></i><?php _e( '重置密码', 'new' ); ?>
                                                        </button>
                                                        <input type="hidden" name="key" value="<?php echo WPUF_Login::get_posted_value( 'key' ); ?>" />
                                                        <input type="hidden" name="redirect_to" value="<?php echo home_url( '/login' ); ?>" />
                                                        <input type="hidden" name="login" id="user_login" value="<?php echo WPUF_Login::get_posted_value( 'login' ); ?>" />
                                                        <input type="hidden" name="wpuf_reset_password" value="true" />
                                                        <?php wp_nonce_field( 'wpuf_reset_pass' ); ?>
                                                    </div>
                                                </fieldset>
                                            </form>
                                        </div><!-- /widget-main -->
                                        <div class="toolbar center">
                                            <a href="#" onclick="show_box('login-box'); return false;" class="back-to-login-link"><?php _e( '返回登陆', 'new' ); ?><i class="icon-arrow-right"></i>
                                            </a>
                                        </div>
                                    </div><!-- /widget-body -->
                                </div><!-- /forgot-box -->

<?php else : ?>
                                <div id="forgot-box" class="forgot-box widget-box no-border">
                                    <div class="widget-body">
                                        <div class="widget-main">
                                            <h4 class="header red lighter bigger">
                                                <i class="icon-key"></i><?php _e( '重置密码' ,'new' ); ?>
                                            </h4>

                                            <div class="space-6"></div>
                                            <p><?php _e( '请输入您的注册邮箱', 'new' ); ?></p>
                                            <form method="post" action="">
                                                <fieldset>
                                                    <label class="block clearfix">
                                                        <span class="block input-icon input-icon-right">
                                                            <input type="email" class="form-control" name="user_login" placeholder="<?php _e( 'Email' ); ?>" />
                                                            <i class="icon-envelope"></i>
                                                        </span>
                                                    </label>
                                                    <div class="clearfix">
                                                        <button type="submit" name="wp-submit" id="wp-submit" class="width-35 pull-right btn btn-sm btn-danger">
                                                            <i class="icon-lightbulb"></i><?php _e( 'Submit' ); ?>
                                                        </button>
                                                        <input type="hidden" name="redirect_to" value="<?php echo WPUF_Login::get_posted_value( 'redirect_to' ); ?>" />
                                                        <input type="hidden" name="wpuf_reset_password" value="true" />
                                                        <input type="hidden" name="action" value="lostpassword" />
                                                        <?php wp_nonce_field( 'wpuf_lost_pass' ); ?>
                                                    </div>
                                                </fieldset>
                                            </form>
                                        </div><!-- /widget-main -->

                                        <div class="toolbar center">
                                            <a href="#" onclick="show_box('login-box'); return false;" class="back-to-login-link"><?php _e( '返回登陆', 'new' ); ?><i class="icon-arrow-right"></i>
                                            </a>
                                        </div>
                                    </div><!-- /widget-body -->
                                </div><!-- /forgot-box -->

<?php endif; ?>

                                <div id="signup-box" class="signup-box widget-box no-border">
                                    <div class="widget-body">
                                        <div class="widget-main">
                                            <h4 class="header green lighter bigger">
                                                <i class="icon-group blue"></i><?php _e( '注册新用户' ); ?>
                                            </h4>

                                            <div class="space-6"></div>
                                            <p><?php _e( '请输入您的注册信息', 'new' ); ?></p>
                                            <?php echo do_shortcode( '[wpuf_profile type="registration" id="263"]' ); ?>
                                        </div>

                                        <div class="toolbar center">
                                            <a href="#" onclick="show_box('login-box'); return false;" class="back-to-login-link">
                                                <i class="icon-arrow-left"></i><?php _e( '返回登陆', 'new' ); ?>
                                            </a>
                                        </div>
                                    </div><!-- /widget-body -->
                                </div><!-- /signup-box -->
                            </div><!-- /position-relative -->
                        </div>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div>
        </div><!-- /.main-container -->

        <!-- basic scripts -->

        <!--[if !IE]> -->

        <script src="http://ajax.useso.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>

        <!-- <![endif]-->

        <!--[if IE]>
        <script src="http://ajax.useso.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <![endif]-->

        <!--[if !IE]> -->

        <script type="text/javascript">
            window.jQuery || document.write("<script src='js/member/jquery-2.0.3.min.js'>"+"</"+"script>");
        </script>

        <!-- <![endif]-->

        <!--[if IE]>
        <script type="text/javascript">
        window.jQuery || document.write("<script src='js/member/jquery-1.10.2.min.js'>"+"<"+"/script>");
        </script>
        <![endif]-->

        <script type="text/javascript">
            if("ontouchend" in document) document.write("<script src='js/member/jquery.mobile.custom.min.js'>"+"</"+"script>");
        </script>

        <!-- inline scripts related to this page -->

        <script type="text/javascript">
            function show_box(id) {
                jQuery('.widget-box.visible').removeClass('visible');
                jQuery('#'+id).addClass('visible');
            }
<?php if ( isset( $_REQUEST['action'] ) && $_REQUEST['action'] == 'rp' && isset( $_REQUEST['key'] ) && ! empty( $_REQUEST['key'] ) ) : ?>
            show_box( 'forgot-box' );
<?php endif; ?>
        </script>
</body>
</html>


