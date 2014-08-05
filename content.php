<h6><?php the_title(); ?></h6>
<span class="meta"><?php the_time( get_option( 'date_format' ) . ' ' . get_option( 'time_format' ) ); ?>   \\   <?php the_author(); ?>   \\   <?php if ( function_exists( 'the_field' ) ) the_field( 'new-article-source' ); ?>  \\   <?php if ( function_exists( 'the_field' ) ) the_field( 'new-article-views' ); ?></span>
<?php the_content(); ?>
