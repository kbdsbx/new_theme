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
