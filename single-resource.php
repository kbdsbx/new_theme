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
    get_template_part( 'content', 'resource' );
endwhile;
?>
            <div class="column-two-third">
                <div class="share">
                    <h5 class="line"><span><?php _e( '分享', 'new' ); ?></span></h5>
                    <?php echo get_option( 'new_theme_share' ); ?>
                </div>
            </div>
            <div class="column-two-third">
                <div class="relatednews">
                    <h5 class="line"><span><?php _e( '其他文章.', 'new' ); ?></span></h5>
                    <ul>
<?php
global $post_types_keys;
$category = get_the_category();
if ( ! empty( $category ) )
    $cat = $category[0]->cat_ID;
else
    $cat = 0;
$args = array(
    'posts_per_page'=> 4,
	'orderby'		=> 'rand',
    'cat'           => $cat,
    'post_type'     => $post_types_keys
);
$query = new WP_Query( $args );
while( $query->have_posts() ) : $query->the_post();
    get_template_part( 'content', 'category' );
endwhile;
?>
                    </ul>
                </div>
            </div>
                <?php wp_reset_postdata(); ?>
            <div class="column-two-third">
                <?php comments_template(); ?>
            </div>
            </div>
        </div>
        <?php get_sidebar( 'category' ); ?>
    </div>
</section>

<?php get_footer(); ?>

