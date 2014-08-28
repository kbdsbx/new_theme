<h4><?php the_title(); ?></h4>
<span class="meta"><?php wpfp_link() ?>   \\   <?php the_time( get_option( 'date_format' ) . ' ' . get_option( 'time_format' ) ); ?>   \\   <?php the_author(); ?>   \\   <?php the_field( 'new-article-source' ); ?>   \\   <?php the_field( 'new-article-views' ); ?></span>
<?php the_content(); ?>
