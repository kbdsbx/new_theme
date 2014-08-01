<h6><?php the_title(); ?></h6>
<span class="meta"><?php the_time( get_option( 'date_format' ) . ' ' . get_option( 'time_format' ) ); ?>   \\   <?php the_author(); ?>   \\   <?php echo get_post_meta( get_the_ID(), 'source', true ); ?>   \\   <?php echo get_post_meta( get_the_ID(), 'views', true ); ?></span>
<?php the_content(); ?>
