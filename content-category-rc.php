<img src="<?php echo new_get_thumbnail_src( 'xs' ); ?>" alt="<?php the_title(); ?>" class="<?php the_title(); ?>" />
<h6 class="regular"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h6>
<span class="meta"><?php the_time( get_option( 'date_format' ) ); ?>   \\   <?php the_author() ?>   \\   <?php the_field( 'new-article-source' ); ?></span>
<p><?php echo strip_tags( get_the_excerpt() ); ?></p>
