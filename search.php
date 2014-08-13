<?php
/**
 * The search template file.
 */
get_header(); ?>

<section id="content">
    <div class="container">
        <div class="breadcrumbs column">
            <?php if( function_exists( 'bcn_display' ) ) : bcn_display(); endif; ?>
        </div>
        <!-- Main Content -->
        <div class="main-content">
            <div class="column-two-third">
	            <?php if ( have_posts() ) : ?>
	            <h5 class="line"><?php printf( __( '查找到匹配结果为: %s 条', 'new' ), $wp_query->found_posts ); ?></h5>
	            <ul class="block">
	            <?php while (have_posts()) : the_post(); ?>
	            <?php get_template_part( 'content', 'category-itd' ); ?>
	            <?php endwhile; ?>
	            </ul>
	            <?php else : ?>
	            <h5 class="line"><?php _e( '无匹配结果', 'new' ); ?></h5>
	            <?php _e( '十分抱歉，没有找到您想要的结果，请更换您的关键词重试或喝杯咖啡休息一下', 'new' ); ?>
	            <?php endif; ?>
                <div class="pager">
                <?php wp_pagenavi(); ?>
                </div>
            </div>
        </div>
        <!-- /Main Content -->
        <?php get_sidebar( 'category' ); ?>
    </div>
</section>

<?php get_footer(); ?>
