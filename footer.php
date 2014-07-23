					<!-- Footer -->
					<div id="footer">
					    <div class="container">
					    	<div class="column-one-third">
                                <h5 class="line"><span><?php _e( 'Weibo', 'new' ); ?></span></h5>
					            <div id="weibo"><iframe width="100%" height="262" class="share_self"  frameborder="0" scrolling="no" src="http://widget.weibo.com/weiboshow/index.php?language=&width=0&height=262&fansRow=2&ptype=0&speed=100&skin=1&isTitle=0&noborder=0&isWeibo=1&isFans=0&uid=1675939963&verifier=1448dc03&dpc=1"></iframe></div>
					        </div>
					        <div class="column-one-third">
                                <h5 class="line"><span><?php _e( 'Navigation', 'new' ); ?></span></h5>
                                <?php wp_nav_menu( array( 'theme_location' => 'navigation-footer', 'container' => false, 'menu_class' => 'footnav' ) ); ?>
					        </div>
					        <div class="column-one-third">
                                <h5 class="line"><span><?php _e( 'About', 'new' ); ?></span></h5>
					            <p>
                                    <?php echo get_option( 'new_theme_about' ); ?>
					            </p>
					        </div>
					        <br />
                            <p class="copyright"><?php echo get_option( 'new_theme_license' ); ?></p>
					    </div>
					</div><!-- / Footer -->
				</div><!-- end of controller2 -->
			</div><!-- end of controller -->
		</div><!-- end of body-wrapper -->
        <?php wp_footer(); ?>
	</body>
</html>
