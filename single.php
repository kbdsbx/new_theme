<?php
/**
 * The single template file
 */
get_header(); ?>

<section id="content">
    <div class="container">
        <div class="breadcrumbs column">
        <?php if ( function_exists( 'bcn_display' ) ) : bcn_display(); endif; ?>
        </div>
        <div class="main-content">
            <div class="column-two-third single">
<?php
while ( have_posts() ) : the_post();
    get_template_part( 'content', '' );
endwhile;
?>
                <div class="share">
                    <?php get_option( 'new_theme_share' ); ?>
                </div>
                <div class="relatednews">
                    <h5 class="line"><?php _e( 'Other articles.', 'new' ); ?></h5>
                    <ul>
<?php
$category = get_the_category();
$cat = $category[0]->cat_ID;
$args = array(
    'posts_per_page'=> 4,
    'page'          => 1,
	'order'			=> 'DESC',
	'orderby'		=> 'rand',
    'cat'           => $cat
);
$query = new WP_Query( $args );
while( $query->have_posts() ) : $query->the_post();
    get_template_part( 'content', 'category' );
endwhile;
?>
                    </ul>
                </div>
                <?php wp_reset_postdata(); ?>
                <?php comments_template(); ?>
            </div>
        </div>
        <?php get_sidebar( 'category' ); ?>
    </div>
</section>

<?php get_footer(); ?>
