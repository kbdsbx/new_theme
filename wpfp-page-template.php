                <ul class="item-list">
<?php
if ( $favorite_post_ids ) : 
    global $post_types_keys;
    $favorite_post_ids = array_reverse( $favorite_post_ids );
    $post_per_page = wpfp_get_option( "post_per_page" );
    $page = intval( get_query_var( 'paged' ) );
    $query = array( 'post__in' => $favorite_post_ids, 'posts_per_page' => $post_per_page, 'orderby' => 'post__in', 'paged' => $page, 'post_type' => $post_types_keys );
    query_posts( $query );
?>
                    <?php while ( have_posts() ) : the_post(); ?>
                    <li class="item-default clearfix">
                        <div class="pull-left action-buttons">
                            <a href="?wpfpaction=remove&page=1&postid=<?php echo get_the_ID() ?>" class="red"><i class="icon-trash bigger-130"></i></a>
                        </div>
&nbsp;&nbsp;
                        <label class="inline"><span class="lbl"><a href="<?php echo get_permalink(); ?>" target="_blank" title="<?php echo get_the_title(); ?>"><?php echo get_the_title(); ?></a></span></label>
                    </li>
                    <?php endwhile; ?>
                    <?php wp_reset_query(); ?>
                    <li class="item-red clearfix">
                        <a class="btn btn-xs btn-danger" href="?wpfpaction=clear">
							<i class="icon-trash bigger-110"></i>
                            <span class="bigger-110 no-text-shadow"><?php echo wpfp_get_option( 'clear' ); ?></span>
						</a>
                    </li>
<?php
else : 
    $wpfp_options = wpfp_get_options();
?>
                    <li>
                        <div class="well well-sm"><?php echo $wpfp_options['favorites_empty']; ?></div>
                    </li>
<?php endif; ?>
                </ul>
