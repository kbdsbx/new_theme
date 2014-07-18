<?php 
$args = array(
    'posts_per_page'=> 4,
    'page'          => 1,
	'order'			=> 'DESC',
	'orderby'		=> 'date'	
);
$query = new WP_Query( $args );
?>
<!-- Todays -->
<div class="column-one-third">
    <h5 class="line"><span><?php _e( 'Today\'s News', 'new' ); ?></span></h5>
    <div class="outertight">
    	<ul class="block">
			<?php while ( $query->have_posts() ) : $query->the_post(); ?>
            <li>
				<a href="<?php the_permalink(); ?>">
					<img src="<?php echo wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'xx' )[0]; ?>" alt="<?php the_title(); ?>" class="alignleft" width="140" height="86" />
				</a>
                <p>
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
					<span><?php the_time( 'Y-m-d' ) ?></span>
                </p>
				<span class="rating">
					<span style="width:<?php echo ( ( get_post_views() / 350 ) > 1 ? 100 : ( get_post_views() / 3.5 ) ) ?>%;"></span>
				</span>
            </li>
			<?php endwhile; ?>
        </ul>
    </div>
</div>
<!-- /Todays -->

<?php
$args = array(
    'posts_per_page'=> 4,
    'page'          => 1,
    'order'         => 'DESC',
    'orderby'       => 'date',
    'category_name' => 'activites'
);
$query = new WP_Query( $args );
?>
<!-- Hot -->
<div class="column-one-third">
    <h5 class="line"><span><?php _e( 'Activites', 'new' ); ?></span></h5>
    <div class="outertight">
    	<ul class="block">
			<?php while ( $query->have_posts() ) : $query->the_post(); ?>
            <li>
				<a href="<?php the_permalink(); ?>">
					<img src="<?php echo wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'xx' )[0]; ?>" alt="<?php the_title(); ?>" class="alignleft" width="140" height="86" />
				</a>
                <p>
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
					<span><?php the_time( 'Y-m-d' ) ?></span>
                </p>
				<span class="rating">
					<span style="width:<?php echo ( ( get_post_views() / 350 ) > 1 ? 100 : ( get_post_views() / 3.5 ) ) ?>%;"></span>
				</span>
            </li>
			<?php endwhile; ?>
        </ul>
    </div>
</div>
<!-- /Hot -->

<!-- Teachers -->
<div class="column-two-third">
	<h5 class="line">
        <span><?php _e( 'Teachers', 'new' ); ?></span>
        <div class="navbar">
            <a id="next1" class="next" href="#"><span></span></a>	
            <a id="prev1" class="prev" href="#"><span></span></a>
        </div>
    </h5>
<?php
$args = array(
    'posts_per_page'=> 1,
    'page'          => 1,
    'order'         => 'DESC',
    'orderby'       => 'date',
    'category_name' => 'teachers'
);
$query = new WP_Query( $args );
?>
    <?php if ( $query->have_posts() ) : $query->the_post(); ?>
    <div class="outertight">
        <img src="<?php echo wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'xs' )[0]; ?>" alt="<?php the_title(); ?>" width="300" height="162" />
        <h6 class="regular"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h6>
        <p><?php the_excerpt(); ?></p>
    </div>
    <?php endif; ?>
<?php
$args = array(
    'posts_per_page'=> 8,
    'page'          => 1,
    'offset'        => 1,
    'order'         => 'DESC',
    'orderby'       => 'date',
    'category_name' => 'teachers'
);
$query = new WP_Query( $args );
?> 
    <div class="outertight m-r-no">
    	<ul class="block" id="carousel">
            <?php while ( $query->have_posts() ) : $query->the_post(); ?>
		    <li>
                <a href="<?php the_permalink(); ?>"><img src="<?php echo wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'xx' )[0]; ?>" alt="<?php the_title(); ?>" alt="<?php the_title(); ?>" class="alignleft" width="140" height="86" /></a>
	                <p>
	                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
	                </p>
                <p><?php the_excerpt(); ?></p>
	        </li>
            <?php endwhile; ?>
        </ul>
    </div>
</div>
<!-- /Teachers -->


<!-- Spanish -->
<div class="column-two-third">
<?php
$args = array(
    'posts_per_page'=> 4,
    'page'          => 1,
    'order'         => 'DESC',
    'orderby'       => 'date',
    'category_name' => 'study'
);
$query = new WP_Query( $args );
?> 
    <div class="outertight">
        <h5 class="line"><span><?php _e( 'Spanish Study', 'new' ); ?></span></h5>
        <div class="outertight m-r-no">

    	<ul class="block">
			<?php while ( $query->have_posts() ) : $query->the_post(); ?>
            <li>
                <a href="<?php the_permalink(); ?>" class="title"><?php the_title(); ?></a>
                <span class="meta"><?php the_date( 'Y-m-d' ); ?>   \\   <?php the_author() ?>   \\   <?php echo get_post_meta( get_the_ID(), 'source', true ) ?></span>
				<span class="rating">
					<span style="width:<?php echo ( ( get_post_views() / 350 ) > 1 ? 100 : ( get_post_views() / 3.5 ) ) ?>%;"></span>
				</span>
            </li>
			<?php endwhile; ?>
        </ul>
        </div>
    </div>
<?php
$args = array(
    'posts_per_page'=> 8,
    'page'          => 1,
    'order'         => 'DESC',
    'orderby'       => 'date',
    'category_name' => 'downcenter'
);
$query = new WP_Query( $args );
?> 
    <div class="outertight m-r-no">
        <h5 class="line"><span><?php _e( 'Spanish Source', 'new' ); ?></span></h5>
        <div class="outertight m-r-no">

	    	<ul class="block">
				<?php while ( $query->have_posts() ) : $query->the_post(); ?>
	            <li>
	                <a href="<?php the_permalink(); ?>" class="title"><?php the_title(); ?></a>
	                <span class="meta"><?php the_date( 'Y-m-d' ); ?>   \\   <?php the_author() ?>   \\   <?php echo get_post_meta( get_the_ID(), 'source', true ) ?></span>
					<span class="rating">
						<span style="width:<?php echo ( ( get_post_views() / 350 ) > 1 ? 100 : ( get_post_views() / 3.5 ) ) ?>%;"></span>
					</span>
	            </li>
				<?php endwhile; ?>
	        </ul>
        </div>
    </div>
</div>
<!-- /Spanish -->
