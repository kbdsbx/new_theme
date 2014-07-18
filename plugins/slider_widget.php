<?php


class WP_Widget_Slider extends WP_Widget {

		function __construct() {
		global $posts_size;
		$widget_ops = array('classname' => 'widget_slider', 'description' => __( 'The slider of article that incoding pictures.') );
		
		// wp_enqueue_style( 'new-style-flexslider', get_template_directory_uri() . '/css/flexslider.css' );
		// wp_enqueue_script( 'new-flexslider', get_template_directory_uri() . '/js/flexslider-min.js', array('new-jquery'), '1.0' );

		parent::__construct('slider', __('Slider'), $widget_ops);
	}

	function widget( $args, $instance ) {
		global $posts_size;
		extract( $args );

		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? __( 'Slider' ) : $instance['title'], $instance, $this->id_base );

		$post_count = empty( $instance['post_count'] ) ? 5 : $instance['post_count'];
		$title = empty( $instance['title'] ) ? '' : $instance['title'];
		$orderby = empty( $instance['orderby'] ) ? 'post_date' : $instance['orderby'];
		$meta_key = empty( $instance['new_meta_article_flag'] ) ? '' :  $instance['new_meta_article_flag'];
		$meta_value = 'true';
		$size = $instance['size'];
		$post_size = $posts_size[ $instance['size'] ] ? $posts_size[ $instance['size'] ] : $posts_size['lg'];
		$args = array(
			'post_count' => $post_count,
			'order' => 'DESC',
			'orderby' => $orderby,
			'meta_key' => '_new_meta_article_' . $meta_key,
			'meta_value' => 'true'
		);

		$query = new WP_Query( $args );
		
		echo $before_widget;
?>
<div class="main-slider-<?php echo $size;?>">
	<?php if ( !empty( $title ) ) : ?>
	<div class="badg">
		<p><a href="#"><?php echo $title; ?></a></p>
	</div>
	<?php endif; ?>
	<div class="flexslider">
		<ul class="slides">
		<?php while( $query->have_posts() ) : $query->the_post(); ?>
			<li>
				<input hidden="hidden" id="<?php the_ID(); ?>" />
				<a href="<?php the_permalink(); ?>">
					<?php if ( has_post_thumbnail() ) : ?>
					<img width="<?php echo $post_size[0]; ?>" height="<?php echo $post_size[1]; ?>" src="<?php echo wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), $size )[0]; ?>" alt="<?php the_title(); ?>" />
					<?php endif; ?>
				</a>
				<p class="flex-caption">
					<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
					<?php echo strip_tags( get_the_excerpt() ); ?>
				</p>
			</li>
		<?php endwhile // end of foreach ?>
		</ul>
	</div>
</div>
	<?php
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['title'] = !empty( $new_instance['title'] ) ? $new_instance['title'] : '';
		$instance['post_count'] = ( !empty( $new_instance['post_count'] ) && is_numeric( $new_instance['post_count'] ) ) ? $new_instance['post_count'] : 5;
		$instance['orderby'] = $new_instance['orderby'] ? $new_instance['orderby'] : '';
		$instance['new_meta_article_flag'] = $new_instance['new_meta_article_flag'] ? $new_instance['new_meta_article_flag'] : '';
		$instance['size'] = $new_instance['size'] ? $new_instance['size'] : 'lg';

		return $instance;
	}

	function form( $instance ) {
		global $posts_flags, $posts_size;
		//Defaults
		$instance = wp_parse_args( (array) $instance, array( 'sortby' => 'post_title', 'title' => '', 'exclude' => '') );
		$title = esc_attr( $instance['title'] );
		$post_count = esc_attr( $instance['post_count'] );
		$orderby = esc_attr( $instance['orderby'] );
		$article_flag = esc_attr( $instance['new_meta_article_flag'] );
		$article_size = esc_attr( $instance['size'] );
	?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
			</p>
		<p>
			<label for="<?php echo $this->get_field_id('orderby'); ?>"><?php _e( 'Order by:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('orderby'); ?>" name="<?php echo $this->get_field_name('orderby'); ?>" type="text" value="<?php echo $orderby; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('post_count'); ?>"><?php _e( 'Posts count:' ); ?></label>
			<input type="text" value="<?php echo $post_count; ?>" name="<?php echo $this->get_field_name('post_count'); ?>" id="<?php echo $this->get_field_id('post_count'); ?>" size="3" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('new_meta_article_flag'); ?>"><?php _e( 'Flags:' ); ?></label>
			<br />
			<?php foreach( $posts_flags as $flag ) : ?>
			<input type="radio" name="<?php echo $this->get_field_name('new_meta_article_flag'); ?>" id="<?php echo $this->get_field_id('new_meta_article_flag'); ?>" <?php if ( $flag == $article_flag ) : echo 'checked="checked"'; endif ?> value="<?php echo $flag; ?>" />
			<?php _e( strtoupper( $flag ) ) ?>
			<br />
			<?php endforeach; ?>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'size' ); ?>"><?php _e( 'Size:' ); ?></label>
			<br />
			<?php foreach( $posts_size as $size_key => $size ) : ?>
			<input type="radio" name="<?php echo $this->get_field_name('size'); ?>" id="<?php echo $this->get_field_id('size'); ?>" <?php if ( $article_size == $size_key ) : echo 'checked="checked"'; endif ?> value="<?php echo $size_key; ?>" />
			<?php echo $size[0]; ?> * <?php echo $size[1]; ?>
			<br />
			<?php endforeach; ?>
		</p>
<?php
	}
}
register_widget('WP_Widget_Slider');
