<h4><?php the_title(); ?></h4>
<span class="meta"><?php if ( function_exists( 'wpfp_link' ) ) { wpfp_link(); echo '   \\   '; } ?><?php the_time( get_option( 'date_format' ) . ' ' . get_option( 'time_format' ) ); ?>   \\   <?php the_author(); ?>   \\   <?php echo new_get_source(); ?>   \\   <?php echo new_get_view_count(); ?></span>
<?php the_content(); ?>
