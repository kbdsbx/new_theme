<?php

class WP_Widget_Picture extends WP_Widget {
    function __construct() {
        $widget_ops = array( 'classname' => 'widget_slider', 'description' => __( 'Pictures' ) );

        parent::__construct( 'picture', __( 'Pictures' ), $widget_ops );
    }

    function widget( $args, $instance ) {
        global $posts_size;
        extract( $args );

        $title = empty( $instance['title'] ) ? '' : $instance['title'];
        $posts_per_page = empty( $instance['posts_per_page'] ) ? 8 : $instance['posts_per_page'];
        $category_id = empty( $instance['category_id'] ) ? '' : $instance['category_id'];
        $size = $instance['size'];
        $post_size = $posts_size[ $instance['size'] ] ? $posts_size[ $instance['size'] ] : $posts_size['xx'];
        $args = array(
            'posts_per_page' => $posts_per_page,
            'page' => 1,
            'cat' => $category_id
        );

        $query = new WP_Query( $args );

        echo $before_widget;
?>
<div class="sidebar">
    <h5 class="line"><span><?php echo $title; ?></span></h5>
    <ul class="picbox">
        <?php while( $query->have_posts() ) : $query->the_post(); ?>
        <li>
            <a href="<?php the_permalink(); ?>"><img src="<?php echo wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), $size )[0]; ?>" alt="<?php the_title(); ?>" /></a>
            <h6><?php the_title(); ?></h6>
            <p>
                <?php echo strip_tags( get_the_excerpt() ); ?>
            </p>
        </li>
        <?php endwhile; ?>
    </ul>
</div>
<?php
        echo $after_widget;
    }

    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;

        $instance['title'] = !empty( $new_instance['title'] ) ? $new_instance['title'] : '';
        $instance['posts_per_page'] = ( !empty( $new_instance['posts_per_page'] ) && is_numeric( $new_instance['posts_per_page'] ) ) ? $new_instance['posts_per_page'] : $instance['posts_per_page'];
        $instance['category_id'] = !empty( $new_instance['category_id'] ) ? $new_instance['category_id'] : $instance['category_id'];
        $instance['size'] = $new_instance['size'] ? $new_instance['size'] : $instance['size'];

        return $instance;
    }

    function form( $instance ) {
        global $posts_size;

        $instance = wp_parse_args( ( array ) $instance, array( 'sortby' => 'post_title', 'title' => '', 'exclude' => '' ) );
        $title = esc_attr( empty ( $instance['title'] ) ? '' :  $instance['title'] );
        $posts_per_page = esc_attr( empty ( $instance['posts_per_page'] ) ? '' : $instance['posts_per_page'] );
        $category_id = esc_attr( empty ( $instance['category_id'] ) ? '' : $instance['category_id'] );
        $picture_size = esc_attr( empty ( $instance['size'] ) ? '' : $instance['size'] );
?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
        <p>
			<label for="<?php echo $this->get_field_id('posts_per_page'); ?>"><?php _e( 'Posts count:' ); ?></label>
			<input type="text" value="<?php echo $posts_per_page; ?>" name="<?php echo $this->get_field_name('posts_per_page'); ?>" id="<?php echo $this->get_field_id('posts_per_page'); ?>" size="3" />
		</p>
        <p>
            <label for="<?php echo $this->get_field_id( 'category_id' ); ?>"><?php _e( 'Category:' ); ?></label>
            <br/>
            <?php wp_dropdown_categories( array( 'name' => $this->get_field_name( 'category_id' ), 'id' => $this->get_field_id( 'category_id' ), 'depth' => 0, 'selected' => $category_id, 'hierarchical' => true, 'hide_empty' => false ) ); ?>
        </p>
        <p>
			<label for="<?php echo $this->get_field_id( 'size' ); ?>"><?php _e( 'Size:' ); ?></label>
			<br />
			<?php foreach( $posts_size as $size_key => $size ) : ?>
			<input type="radio" name="<?php echo $this->get_field_name('size'); ?>" id="<?php echo $this->get_field_id('size'); ?>" <?php if ( $picture_size == $size_key ) : echo 'checked="checked"'; endif ?> value="<?php echo $size_key; ?>" />
			<?php echo $size[0]; ?> * <?php echo $size[1]; ?>
			<br />
			<?php endforeach; ?>
		</p>
<?php
    }
}
register_widget( 'WP_Widget_Picture' );
