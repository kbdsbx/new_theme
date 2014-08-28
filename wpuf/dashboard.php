<div class="main-content">
    <div class="breadcrumbs breadcrumbs-fixed" id="breadcrumbs">
        <ul class="breadcrumb">
            <li><i class="icon-home home-icon"></i><?php _e( '主页', 'new' ); ?></li>
            <li class="active"><?php _e( '文章列表', 'new' ); ?></li>
        </ul>
        <div class="nav-search" id="nav-search">
			<form class="form-search">
				<span class="input-icon">
                    <input type="text" placeholder="<?php _e( '搜索', 'new' ); ?>" class="nav-search-input" id="nav-search-input" autocomplete="off">
					<i class="icon-search nav-search-icon"></i>
				</span>
			</form>
		</div>
    </div>
    <div class="page-content">
        <div class="page-header">
            <h1><?php _e( '文章列表', 'new' ); ?></h1>
        </div>
        <div class="row">
            <div class="col-xs-12 infobox-container">
                <div class="infobox infobox-green">
			        <div class="infobox-icon">
						<i class="icon-file-alt"></i>
					</div>

					<div class="infobox-data">
						<span class="infobox-data-number"><?php echo $dashboard_query->found_posts; ?></span>
                        <div class="infobox-content"><?php echo $post_type_obj->label; ?></div>
					</div>
				</div>
                
                <div class="infobox infobox-blue">
					<div class="infobox-icon">
						<i class="icon-comments"></i>
					</div>

					<div class="infobox-data">
<?php
$comment_count = 0;
foreach( $dashboard_query->posts as $post ) {
    $comment_count += $post->comment_count;
}
?>
                        <span class="infobox-data-number"><?php echo $comment_count; ?></span>
                        <div class="infobox-content"><?php _e( 'Comments' ); ?></div>
					</div>
                </div>
            </div>
        </div>
        <div class="space-6"></div>
        <div class="row">
            <div class="col-xs-12">
<?php if ( $dashboard_query->have_posts() ) : ?>
                <div class="table-responsive">
    <?php
    $featured_img = wpuf_get_option( 'show_ft_image', 'wpuf_dashboard' );
    $featured_img_size = wpuf_get_option( 'ft_img_size', 'wpuf_dashboard' );
    $charging_enabled = wpuf_get_option( 'charge_posting', 'wpuf_payment' );
    ?>
					<table id="sample-table-1" class="table table-striped table-bordered table-hover">
					    <thead>
				            <tr>
				                <?php
				                if ( 'on' == $featured_img ) {
				                    echo '<th>' . __( 'Featured Image', 'wpuf' ) . '</th>';
				                }
				                ?>
				                <th><?php _e( 'Title', 'wpuf' ); ?></th>
				                <th><?php _e( 'Status', 'wpuf' ); ?></th>
				                <th><?php _e( 'Comments' ); ?></th>
				
				                <?php do_action( 'wpuf_dashboard_head_col', $args ) ?>
				
				                <?php
				                if ( 'yes' == $charging_enabled ) {
				                    echo '<th>' . __( 'Payment', 'wpuf' ) . '</th>';
				                }
				                ?>
				                <th><?php _e( 'Options', 'wpuf' ); ?></th>
				            </tr>
				        </thead>
				        <tbody>
				            <?php
				            global $post;
				
				            while ( $dashboard_query->have_posts() ) {
				                $dashboard_query->the_post();
				                $show_link = !in_array( $post->post_status, array('draft', 'future', 'pending') );
				                ?>
				                <tr>
				                    <?php if ( 'on' == $featured_img ) { ?>
				                        <td>
				                            <?php
				                            echo $show_link ? '<a href="' . get_permalink( $post->ID ) . '">' : '';
				
				                            if ( has_post_thumbnail() ) {
				                                the_post_thumbnail( $featured_img_size );
				                            } else {
				                                printf( '<img src="%1$s" class="attachment-thumbnail wp-post-image" alt="%2$s" title="%2$s" />', apply_filters( 'wpuf_no_image', plugins_url( '/assets/images/no-image.png', dirname( __FILE__ ) ) ), __( 'No Image', 'wpuf' ) );
				                            }
				
				                            echo $show_link ? '</a>' : '';
				                            ?>
				                        </td>
				                    <?php } ?>
				                    <td>
				                        <?php if ( !$show_link ) { ?>
				
				                            <?php the_title(); ?>
				
				                        <?php } else { ?>
				
				                            <a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'wpuf' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
				
				                        <?php } ?>
				                    </td>
				                    <td>
				                        <?php wpuf_show_post_status( $post->post_status ) ?>
				                    </td>
                                    <td>
                                        <?php echo $post->comment_count; ?>
                                    </td>
				
				                    <?php do_action( 'wpuf_dashboard_row_col', $args, $post ) ?>
				
				                    <?php
				                    if ( $charging_enabled == 'yes' ) {
				                        $order_id = get_post_meta( $post->ID, '_wpuf_order_id', true );
				                        ?>
				                        <td>
				                            <?php if ( $post->post_status == 'pending' && $order_id ) { ?>
				                                <a href="<?php echo trailingslashit( get_permalink( wpuf_get_option( 'payment_page', 'wpuf_payment' ) ) ); ?>?action=wpuf_pay&type=post&post_id=<?php echo $post->ID; ?>"><?php _e( 'Pay Now', 'wpuf' ); ?></a>
				                            <?php } ?>
				                        </td>
				                    <?php } ?>
				
				                    <td>
				                        <?php
				                        if ( wpuf_get_option( 'enable_post_edit', 'wpuf_dashboard', 'yes' ) == 'yes' ) {
				                            $disable_pending_edit = wpuf_get_option( 'disable_pending_edit', 'wpuf_dashboard', 'on' );
				                            $edit_page = (int) wpuf_get_option( 'edit_page_id', 'wpuf_general' );
				                            $url = add_query_arg( array('pid' => $post->ID), get_permalink( $edit_page ) );
				
				                            if ( $post->post_status == 'pending' && $disable_pending_edit == 'on' ) {
				                                // don't show the edit link
				                            } else {
				                                ?>
                                                <a href="<?php echo wp_nonce_url( $url, 'wpuf_edit' ); ?>"><i class="icon-edit"></i>&nbsp;<?php _e( 'Edit', 'wpuf' ); ?></a>
				                                <?php
				                            }
				                        }
				                        ?>
				
				                        <?php
				                        if ( wpuf_get_option( 'enable_post_del', 'wpuf_dashboard', 'yes' ) == 'yes' ) {
				                            $del_url = add_query_arg( array('action' => 'del', 'pid' => $post->ID) );
				                            ?>
                                            <a href="<?php echo wp_nonce_url( $del_url, 'wpuf_del' ) ?>" onclick="return confirm('Are you sure to delete?');"><span style="color: red;"><i class="icon-trash"></i>&nbsp;<?php _e( 'Delete', 'wpuf' ); ?></span></a>
				                        <?php } ?>
				                    </td>
				                </tr>
				                <?php
				            }
				
				            wp_reset_postdata();
				            ?>
				
				        </tbody>
				    </table>	
				</div>
                <div class="wpuf-pagination">
			        <?php
			        $pagination = paginate_links( array(
			            'base' => add_query_arg( 'pagenum', '%#%' ),
			            'format' => '',
			            'prev_text' => __( '&laquo;', 'wpuf' ),
			            'next_text' => __( '&raquo;', 'wpuf' ),
			            'total' => $dashboard_query->max_num_pages,
			            'current' => $pagenum
			        ) );
			
			        if ( $pagination ) {
			            echo $pagination;
			        }
			        ?>
                </div>

<?php else : ?>
                <div class="well well-sm"> <?php printf( __( '您还没有创建%s。', 'new' ), $post_type_obj->label ); ?> </div>
                <?php do_action( 'wpuf_dashboard_nopost', $userdata->ID, $post_type_obj ); ?>
<?php endif; ?>
            </div>
        </div>
    </div>
</div>
