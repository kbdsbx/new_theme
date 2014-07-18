<?php

class WP_Widget_Tabs extends WP_Widget {

		function __construct() {
		global $posts_size;
		$widget_ops = array('classname' => 'widget_tabs', 'description' => __( 'The tabs of posts and incoding ranks, recommends, randoms.') );
		
		// wp_enqueue_style( 'new-style-flexslider', get_template_directory_uri() . '/css/flexslider.css' );
		// wp_enqueue_script( 'new-flexslider', get_template_directory_uri() . '/js/flexslider-min.js', array('new-jquery'), '1.0' );

		parent::__construct('tabs', __('Tabs'), $widget_ops);
	}

	function widget( $args, $instance ) {
		global $posts_size;
		extract( $args );

		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? __( 'Tabs' ) : $instance['title'], $instance, $this->id_base );

		$post_count= empty( $instance['post_count'] ) ? 4 : $instance['post_count'];
		$title = empty( $instance['title'] ) ? '' : $instance['title'];

		$size = $instance['size'];
		$post_size = $posts_size[ $instance['size'] ] ? $posts_size[ $instance['size'] ] : $posts_size['lg'];

		$args_rank = array(
            'posts_per_page'=> $post_count,
            'page'          => 1,
			'order'			=> 'DESC',
			'meta_key'		=> 'views',
			'orderby'		=> 'meta_value_num'
		);
		$args_recommend = array(
            'posts_per_page'=> $post_count,
            'page'          => 1,
			'order'			=> 'DESC',
			'meta_key'		=> '_new_meta_article_recommend',
			'meta_value'	=> 'true',
			'orderby'		=> 'post_date'
		);
		$args_random = array(
            'posts_per_page'=> $post_count,
            'page'          => 1,
			'order'			=> 'DESC',
			'orderby'		=> 'rand'
		);

		echo $before_widget;
?>
<div class="slider-<?php echo $size;?>">
	<div id="tabs">
        <ul>
			<li><a href="#tabs1"><?php _e( 'Rank', 'new' ); ?></a></li>
            <li><a href="#tabs2"><?php _e( 'Recommend', 'new' ); ?></a></li>
            <li><a href="#tabs3"><?php _e( 'Random', 'new' ); ?></a></li>
        </ul>
        <div id="tabs1">
            <ul>
<?php
				$query = new WP_Query( $args_rank );
			 	while( $query->have_posts() ) : $query->the_post();
?>
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
        <div id="tabs2">
            <ul>
<?php
				$query = new WP_Query( $args_recommend );
			 	while( $query->have_posts() ) : $query->the_post();
?>
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
        <div id="tabs3">
            <ul>
<?php
				$query = new WP_Query( $args_random );
			 	while( $query->have_posts() ) : $query->the_post();
?>
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

	<?php
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['title'] = !empty( $new_instance['title'] ) ? $new_instance['title'] : '';
		$instance['post_count'] = ( !empty( $new_instance['post_count'] ) && is_numeric( $new_instance['post_count'] ) ) ? $new_instance['post_count'] : 4;
		$instance['size'] = $new_instance['size'] ? $new_instance['size'] : 'lg';

		return $instance;
	}

	function form( $instance ) {
		global $posts_size;
		//Defaults
		$instance = wp_parse_args( (array) $instance, array( 'sortby' => 'post_title', 'title' => '', 'exclude' => '') );
		$title = esc_attr( $instance['title'] );
		$post_count = esc_attr( $instance['post_count'] );
		$article_size = esc_attr( $instance['size'] );
	?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('post_count'); ?>"><?php _e( 'Post count:' ); ?></label>
			<input type="text" value="<?php echo $post_count; ?>" name="<?php echo $this->get_field_name('post_count'); ?>" id="<?php echo $this->get_field_id('post_count'); ?>" size="3" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'size' ); ?>"><?php _e( 'Size:' ); ?></label>
			<br />
			<?php foreach( $posts_size as $size_key => $size ) : ?>
			<input type="radio" name="<?php echo $this->get_field_name('size'); ?>" id="<?php echo $this->get_field_id('size'); ?>" <?php if ( $article_size == $size_key ) : echo 'checked="checked"'; endif ?> value="<?php echo $size_key; ?>" />
			<?php echo $size[0]; ?> px
			<br />
			<?php endforeach; ?>
		</p>
<?php
	}
}
register_widget('WP_Widget_Tabs');

