<?php
/**
 * The main template file
 */
global $post_types_keys;
get_header(); ?>
<section class="slider">
    <div class="container">
    <?php dynamic_sidebar( 'sidebar-main-slider' ); ?>
    <?php dynamic_sidebar( 'sidebar-slider2' ); ?>
    </div>    
</section>
<!-- / Slider -->

<!-- Content -->
<section id="content">
    <div class="container">
    	<!-- Main Content -->

        <div class="main-content">
            <div class="column-one-third">
                <h5 class="line"><span><?php _e( 'Today\'s news.', 'new' ); ?></span></h5>
                <div class="outertight">
                    <ul class="block">
<?php
$args = array(
    'posts_per_page' => 4,
    'orderby'        => 'date',
    'post_type'      => $post_types_keys
);
$query = new WP_Query( $args );
while ( $query->have_posts() ) : $query->the_post();
    get_template_part( 'content', 'category' );
endwhile;
?>
                    </ul>
                </div>
            </div>
            <div class="column-one-third">
            <h5 class="line"><span><?php _e( 'Activites.', 'new' ); ?></span></h5>
                <div class="outertight">
                    <ul class="block">
<?php
$args = array(
    'posts_per_page'=> 4,
    'orderby'       => 'date',
    'category_name' => 'activites',
    'post_type'     => $post_types_keys
);
$query = new WP_Query( $args );
while ( $query->have_posts() ) : $query->the_post();
    get_template_part( 'content', 'category' );
endwhile;
?>
                    </ul>
                </div>
            </div>
<!-- Teachers -->
<div class="column-two-third">
	<h5 class="line">
        <span><?php _e( 'Teachers.', 'new' ); ?></span>
        <div class="navbar">
            <a id="next1" class="next" href="#"><span></span></a>	
            <a id="prev1" class="prev" href="#"><span></span></a>
        </div>
    </h5>
<?php
$args = array(
    'posts_per_page'=> 1,
    'orderby'       => 'date',
    'category_name' => 'teachers',
    'post_type'     => $post_types_keys
);
$query = new WP_Query( $args );
?>
    <?php if ( $query->have_posts() ) : $query->the_post(); ?>
    <div class="outertight">
        <img src="<?php echo wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'xs' )[0]; ?>" alt="<?php the_title(); ?>" width="300" height="162" />
        <h6 class="regular"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h6>
        <p><?php strip_tags( the_excerpt() ); ?></p>
    </div>
    <?php endif; ?>
<?php
$args = array(
    'posts_per_page'=> 8,
    'offset'        => 1,
    'orderby'       => 'date',
    'category_name' => 'teachers',
    'post_type'     => $post_types_keys
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
                <p><?php strip_tags( the_excerpt() ); ?></p>
	        </li>
            <?php endwhile; ?>
        </ul>
    </div>
</div>
<!-- /Teachers -->
			<div class="column-one-third">
				<h5 class="line"><span><?php _e( 'Spanish study.', 'new' ); ?></span></h5>
                <div class="outertight">
					<ul class="block">
<?php
$args = array(
    'posts_per_page'=> 4,
    'orderby'       => 'date',
    'category_name' => 'study',
    'post_type'     => $post_types_keys
);
$query = new WP_Query( $args );
while ( $query->have_posts() ) : $query->the_post();
    get_template_part( 'content', 'category-2' );
endwhile;
?>
					</ul>
				</div>
			</div>
			<div class="column-one-third">
				<h5 class="line"><span><?php _e( 'Spanish sources.', 'new' ); ?></span></h5>
                <div class="outertight">
					<ul class="block">
<?php
$args = array(
    'posts_per_page'=> 8,
    'orderby'       => 'date',
    'category_name' => 'downcenter',
    'post_type'     => $post_types_keys
);
$query = new WP_Query( $args );
while ( $query->have_posts() ) : $query->the_post();
    get_template_part( 'content', 'category-2' );
endwhile;
?>
					</ul>
				</div>
			</div>
        <?php dynamic_sidebar( 'sidebar-home-footer' ); ?> 
        </div>
        <!-- /Main Content -->
        <?php get_sidebar(); ?>
        
    </div>    
</section>
<!-- / Content -->

<?php get_footer(); ?>
