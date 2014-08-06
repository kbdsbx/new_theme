					<!-- Footer -->
					<div id="footer">
					    <div class="container">
					    	<div class="column-one-third">
                                <h5 class="line"><span><?php _e( 'The Latest', 'new' ); ?></span></h5>
                                <div id="latest"><?php echo get_option( 'new_theme_latest' ); ?></div>
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
