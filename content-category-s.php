<?php new_get_gallery_shortcode() ?>
<h6 class="regular"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h6>
<span class="meta"><?php the_time( get_option( 'date_format' ) ); ?>   \\   <?php the_author() ?>   \\   <?php echo new_get_source(); ?></span>
<p><?php echo strip_tags( get_the_excerpt() ); ?></p>
