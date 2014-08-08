<?php


class WP_Widget_Slider extends WP_Widget {

    function __construct() {
		global $size_enum;
		$widget_ops = array('classname' => 'widget_slider', 'description' => __( '使用幻灯片播放文章特色图像', 'new' ) );
		
		parent::__construct('slider', __( '幻灯', 'new' ), $widget_ops);
	}

	function widget( $args, $instance ) {
		global $size_enum, $post_types_keys;

		$title          = apply_filters( 'widget_title', _filter_object_empty( $instance, 'title', __( '幻灯', 'new' ) ), $instance, $this->id_base );
		$posts_per_page = _filter_object_empty_numeric( $instance, 'posts_per_page', 5 );
		$orderby        = _filter_object_empty( $instance, 'orderby', 'post_date' );
		$meta_key       = 'new-article-flags';
		$meta_value     = _filter_object_empty( $instance, 'new_meta_article_flag', '' );
        $size           = _filter_object_empty( $instance, 'size', 'lg' );
        $post_size      = _filter_object_empty( $size_enum, $size, $size_enum['lg'] );

		$query = new WP_Query( array(
            'posts_per_page' => $posts_per_page,
			'orderby' => $orderby,
            'meta_query' => array(
                array( 'key' => $meta_key, 'value' => $meta_value, 'compare' => 'LIKE' )
            ),
            'post_type' => $post_types_keys
		) );
		
		echo $args['before_widget'];
?>
    <?php if ( ! empty( $title ) ) : ?>
	<div class="badg">
		<p><a href="#"><?php echo $title; ?></a></p>
	</div>
    <?php endif; ?>
	<div class="flexslider">
		<ul class="slides">
            <?php while( $query->have_posts() ) : $query->the_post(); ?>
			<li>
				<input type="hidden" id="<?php the_ID(); ?>" />
				<a href="<?php the_permalink(); ?>">
                <?php if ( has_post_thumbnail() ) : ?>
                <!-- width="<?php echo $post_size[0]; ?>" height="<?php echo $post_size[1]; ?>"  -->
					<img src="<?php echo wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), $size )[0]; ?>" alt="<?php the_title(); ?>" />
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
    <?php wp_reset_query(); ?>
<?php
		echo $args['after_widget'];
	}

	function update( $new_instance, $old_instance ) {
		$instance = array();

		$instance['title']          = _filter_empty( $new_instance['title'], '' );
        $instance['posts_per_page'] = _filter_empty_numeric( $new_instance['posts_per_page'], 5 );
		$instance['orderby']        = _filter_empty( $new_instance['orderby'], '' );
		$instance['new_meta_article_flag'] = _filter_empty( $new_instance['new_meta_article_flag'], '' );
        $instance['size']           = _filter_empty( $new_instance['size'], '' );

		return $instance;
	}

	function form( $instance ) {
		global $size_enum;
		//Defaults
        if ( function_exists( 'get_field_object' ) ) {
            $posts_flags = get_field_object( 'field_53def322e5039' ); // new-article-flag
        }
		$title = esc_attr( _filter_object_empty( $instance, 'title', '' ) );
        $posts_per_page = esc_attr( _filter_object_empty( $instance, 'posts_per_page', '' ) );
		$orderby = esc_attr( _filter_object_empty( $instance, 'orderby', '' ) );
		$article_flag = esc_attr( _filter_object_empty( $instance, 'new_meta_article_flag', '' ) );
		$article_size = esc_attr( _filter_object_empty( $instance, 'size', '' ) );
	?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( '标题:', 'new' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
			</p>
		<p>
			<label for="<?php echo $this->get_field_id('orderby'); ?>"><?php _e( '排序:', 'new' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('orderby'); ?>" name="<?php echo $this->get_field_name('orderby'); ?>" type="text" value="<?php echo $orderby; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('posts_per_page'); ?>"><?php _e( '文章数量:', 'new' ); ?></label>
			<input type="text" value="<?php echo $posts_per_page; ?>" name="<?php echo $this->get_field_name('posts_per_page'); ?>" id="<?php echo $this->get_field_id('posts_per_page'); ?>" size="3" />
		</p>
        <?php if ( isset( $posts_flags ) && is_array( $posts_flags ) ) :?>
		<p>
            <label for="<?php echo $this->get_field_id('new_meta_article_flag'); ?>"><?php echo $posts_flags['label']; ?></label>
            <br />
                <select name="<?php echo $this->get_field_name('new_meta_article_flag'); ?>" id="<?php echo $this->get_field_id('new_meta_article_flag'); ?>">
                    <?php foreach( $posts_flags['choices'] as $flag_key => $flag_value ) : ?>
                    <option value="<?php echo $flag_key; ?>" <?php if ( $flag_key == $article_flag ) : echo 'selected="selected"'; endif ?>>
                    <?php _e( strtoupper( $flag_value ) ) ?>
                    </option>
                    <?php endforeach; ?>
                </select>
		</p>
        <?php endif; ?>
		<p>
			<label for="<?php echo $this->get_field_id( 'size' ); ?>"><?php _e( '图片大小:', 'new' ); ?></label>
			<!--input type="radio" name="<?php echo $this->get_field_name('size'); ?>" id="<?php echo $this->get_field_id('size'); ?>" <?php if ( $article_size == $size_key ) : echo 'checked="checked"'; endif ?> value="<?php echo $size_key; ?>" /-->
			<br />
            <select name="<?php echo $this->get_field_name('size'); ?>" id="<?php echo $this->get_field_id('size'); ?>">
                <?php foreach( $size_enum as $size_key => $size ) : ?>
                <option value="<?php echo $size_key; ?>" <?php if ( $article_size == $size_key ) : echo 'selected="selected"'; endif ?>>
                <?php echo $size[0]; ?> * <?php echo $size[1]; ?>
                </option>
                <?php endforeach; ?>
            </select>
		</p>
<?php
	}
}
register_widget( 'WP_Widget_Slider' );
