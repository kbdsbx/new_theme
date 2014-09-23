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
<?php $modules_data = new_modules(); ?>
<?php foreach ( $modules_data as $module ) : ?>
<?php $module_key = md5( $module['module_name'] ); ?>
<?php switch ( $module['module_type'] ) : ?>
<?php case 'itd': ?>
<!-- 图文简介 -->
<div class="column-two-third">
    <h5 class="line"><span><?php echo $module['module_name'] ?></span></h5>
    <div class="outerwide">
        <ul class="block">
<?php
$args = array(
    'posts_per_page'    => $module['module_post_count'],
    'orderby'           => 'date',
    'post_type'         => $post_types_keys,
    'cat'               => $module['module_category']
);
$query = new WP_Query( $args );
while ( $query->have_posts() ) {
    $query->the_post();
    get_template_part( 'content', 'category-' . $module['module_type'] );
}
wp_reset_query();
?>
        </ul>
    </div>
</div>
<?php break; ?>
<?php case 'it': ?>
<!-- 仅图文 -->
<div class="column-one-third">
    <h5 class="line"><span><?php echo $module['module_name'] ?></span></h5>
    <div class="outertight">
        <ul class="block">
<?php
$args = array(
    'posts_per_page'    => $module['module_post_count'],
    'orderby'           => 'date',
    'post_type'         => $post_types_keys,
    'cat'               => $module['module_category']
);
$query = new WP_Query( $args );
while ( $query->have_posts() ) {
    $query->the_post();
    get_template_part( 'content', 'category-' . $module['module_type'] );
}
wp_reset_query();
?>
        </ul>
    </div>
</div>
<?php break; ?>
<?php case 'td': ?>
<!-- 仅标题简介 -->
<div class="column-one-third">
    <h5 class="line"><span><?php echo $module['module_name'] ?></span></h5>
    <div class="outertight">
        <ul class="block">
<?php
$args = array(
    'posts_per_page'    => $module['module_post_count'],
    'orderby'           => 'date',
    'post_type'         => $post_types_keys,
    'cat'               => $module['module_category']
);
$query = new WP_Query( $args );
while ( $query->have_posts() ) {
    $query->the_post();
    get_template_part( 'content', 'category-' . $module['module_type'] );
}
wp_reset_query();
?>
        </ul>
    </div>
</div>
<?php break; ?>
<?php case 'rc': ?>
<!-- 重点与滚动-横向 -->
<div class="column-two-third">
    <h5 class="line">
        <span><?php echo $module['module_name']; ?></span>
        <div class="navbar">
            <a id="next-<?php echo $module_key; ?>" class="next" href="#"><span></span></a>	
            <a id="prev-<?php echo $module_key; ?>" class="prev" href="#"><span></span></a>
        </div>
        <script type='text/javascript'>
            /* <![CDATA[ */
            jQuery(function() {
                jQuery('#carousel-<?php echo $module_key; ?>').carouFredSel({
		            width: '100%',
		            direction   : "bottom",
		            scroll : 400,
		            items: {
		            	visible: '+3'
	            	},
	            	auto: {
	            		items: 1,
            			timeoutDuration : 4000
            		},
            		prev: {
            			button: '#prev-<?php echo $module_key; ?>',
            			items: 1
            		},    
            		next: {
            			button: '#next-<?php echo $module_key; ?>',
            			items: 1
            		}
                });
            });
            /* ]]> */
        </script>
    </h5>
    <div class="outertight">
<?php
$args = array(
    'posts_per_page'    => 1,
    'orderby'           => 'date',
    'post_type'         => $post_types_keys,
    'cat'               => $module['module_category']
);
$query = new WP_Query( $args );
while ( $query->have_posts() ) {
    $query->the_post();
    get_template_part( 'content', 'category-' . $module['module_type'] );
}
wp_reset_query();
?>
    </div>
    <div class="outertight m-r-no">
    <ul class="block" id="carousel-<?php echo $module_key; ?>">
<?php
$args = array(
    'posts_per_page'    => $module['module_post_count'] - 1,
    'offset'            => 1,
    'orderby'           => 'date',
    'post_type'         => $post_types_keys,
    'cat'               => $module['module_category']
);
$query = new WP_Query( $args );
while ( $query->have_posts() ) {
    $query->the_post();
    get_template_part( 'content', 'category-it' );
}
wp_reset_query();
?>
        </ul>
    </div>
</div>
<?php break; ?>
<?php case 'rr': ?>
<!-- 重点与滚动-纵向 -->
<div class="column-two-third">
    <h5 class="line">
        <span><?php echo $module['module_name']; ?></span>
        <div class="navbar">
            <a id="next-<?php echo $module_key; ?>" class="next" href="#"><span></span></a>
            <a id="prev-<?php echo $module_key; ?>" class="prev" href="#"><span></span></a>
        </div>
        <script type='text/javascript'>
            /* <![CDATA[ */
            jQuery(function() {
                jQuery('#carousel-<?php echo $module_key; ?>').carouFredSel({
		            width: '100%',
		            direction   : "left",
		            scroll : {
	                    duration : 800
	                },
		            items: {
		            	visible: '1'
	            	},
	            	auto: {
	            		items: 1,
            			timeoutDuration : 4000
            		},
            		prev: {
            			button: '#prev-<?php echo $module_key; ?>',
            			items: 1
            		},    
            		next: {
            			button: '#next-<?php echo $module_key; ?>',
            			items: 1
            		}
                });
            });
            /* ]]> */
        </script>
    </h5>
    <div class="outerwide" >    
        <ul class="wnews" id="carousel-<?php echo $module_key; ?>">
<?php
$args = array(
    'posts_per_page'    => $module['module_post_count'] - 4,
    'orderby'           => 'date',
    'post_type'         => $post_types_keys,
    'cat'               => $module['module_category']
);
$query = new WP_Query( $args );
while ( $query->have_posts() ) {
    $query->the_post();
    get_template_part( 'content', 'category-' . $module['module_type'] );
}
wp_reset_query();
?>
        </ul>
    </div>
    <div class="outerwide">
        <ul class="block2">
<?php
$args = array(
    'posts_per_page'    => 4,
    'offset'            => $module['module_post_count'] - 4,
    'orderby'           => 'date',
    'post_type'         => $post_types_keys,
    'cat'               => $module['module_category']
);
$query = new WP_Query( $args );
while ( $query->have_posts() ) {
    $query->the_post();
    get_template_part( 'content', 'category-it' );
}
wp_reset_query();
?>
        </ul>
    </div>
</div>
<?php break; ?>
<?php case 's': ?>
<!-- 幻灯 -->
<div class="column-one-third">
    <h5 class="line"><span><?php echo $module['module_name']; ?></span></h5>
    <div class="outertight">
<?php
$args = array(
    'posts_per_page'    => 1,
    'orderby'           => 'date',
    'post_type'         => $post_types_keys,
    'cat'               => $module['module_category']
);
$query = new WP_Query( $args );
while ( $query->have_posts() ) {
    $query->the_post();
    get_template_part( 'content', 'category-' . $module['module_type'] );
}
wp_reset_query();
?>
    </div>
    <ul class="block">
<?php
$args = array(
    'posts_per_page'    => $module['module_post_count'],
    'offset'            => 1,
    'post_type'         => $post_types_keys,
    'cat'               => $module['module_category']
);
$query = new WP_Query( $args );
while ( $query->have_posts() ) {
    $query->the_post();
    get_template_part( 'content', 'category-it' );
}
wp_reset_query();
?>
    </ul>
</div>
<?php break; ?>
<?php endswitch; ?>
<?php endforeach; ?>

        <?php dynamic_sidebar( 'sidebar-home-footer' ); ?> 
        </div>
        <!-- /Main Content -->
        <?php get_sidebar(); ?>
        
    </div>    
</section>
<!-- / Content -->

<?php get_footer(); ?>

