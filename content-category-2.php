<li>
    <a href="<?php the_permalink(); ?>" class="title"><?php the_title(); ?></a>
    <span class="meta"><?php the_time( get_option( 'date_format' ) ); ?>   \\   <?php the_author() ?>   \\   <?php echo get_post_meta( get_the_ID(), 'source', true ) ?></span>
	<span class="rating"><span style="width:<?php echo ( ( get_post_views() / 350 ) > 1 ? 100 : ( get_post_views() / 3.5 ) ) ?>%;"></span></span>
</li>
