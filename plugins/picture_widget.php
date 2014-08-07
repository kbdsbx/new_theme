<?php

class WP_Widget_Picture extends WP_Widget {
    function __construct() {
        $widget_ops = array( 'classname' => 'widget_picture', 'description' => __( 'Pictures', 'new' ) );

        parent::__construct( 'picture', __( 'Pictures', 'new' ), $widget_ops );
    }

    function widget( $args, $instance ) {
        global $size_enum, $post_types_keys;
        $title      = apply_filters( 'widget_title', _filter_object_empty( $instance, 'title', __( 'Pictures', 'new' ), $instance, $this->id_base ) );
        $posts_per_page = _filter_object_empty( $instance, 'posts_per_page', 4 );
        $category_id= _filter_object_empty( $instance, 'category_id', '' );
        $size       = _filter_object_empty( $instance, 'size', 'xx' );
        $post_size  = _filter_object_empty( $size_enum, $size, $size_enum['xx'] );

        $query = new WP_Query( array(
            'posts_per_page' => $posts_per_page,
            'cat' => $category_id,
            'post_type' => $post_types_keys
        ) );

        echo $args['before_widget'];
?>
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
<?php
        echo $args['after_widget'];
    }

    function update( $new_instance, $old_instance ) {
        $instance = array();

        $instance['title']          = _filter_empty( $new_instance['title'], '' );
        $instance['posts_per_page'] = _filter_empty_numeric( $new_instance['posts_per_page'], 4 );
        $instance['category_id']    = _filter_empty( $new_instance['category_id'], '' );
        $instance['size']           = _filter_empty( $new_instance['size'], '' );
        
        return $instance;
    }

    function form( $instance ) {
        global $size_enum;

        $title = esc_attr( _filter_object_empty( $instance, 'title', '' ) );
        $posts_per_page = esc_attr( _filter_object_empty( $instance, 'posts_per_page', '' ) );
        $category_id = esc_attr( _filter_object_empty( $instance, 'category_id', '' ) );
        $picture_size = esc_attr( _filter_object_empty( $instance, 'size', '' ) );
?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title:', 'new' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
        <p>
			<label for="<?php echo $this->get_field_id('posts_per_page'); ?>"><?php _e( 'Posts count:', 'new' ); ?></label>
			<input type="text" value="<?php echo $posts_per_page; ?>" name="<?php echo $this->get_field_name('posts_per_page'); ?>" id="<?php echo $this->get_field_id('posts_per_page'); ?>" size="3" />
		</p>
        <p>
            <label for="<?php echo $this->get_field_id( 'category_id' ); ?>"><?php _e( 'Category:', 'new' ); ?></label>
            <br/>
<?php wp_dropdown_categories( array( 'name' => $this->get_field_name( 'category_id' ), 'id' => $this->get_field_id( 'category_id' ), 'depth' => 0, 'selected' => $category_id, 'hierarchical' => true, 'hide_empty' => false ) ); ?>
        </p>
        <p>
			<label for="<?php echo $this->get_field_id( 'size' ); ?>"><?php _e( 'Size:', 'new' ); ?></label>
			<br />
            <select name="<?php echo $this->get_field_name('size'); ?>" id="<?php echo $this->get_field_id('size'); ?>">
<?php foreach( $size_enum as $size_key => $size ) : ?>
                <option <?php if ( $picture_size == $size_key ) : echo 'selected="selected"'; endif ?> value="<?php echo $size_key; ?>" >
<?php echo $size[0]; ?> * <?php echo $size[1]; ?>
                </option>
<?php endforeach; ?>
            </select>
		</p>
<?php
    }
}
register_widget( 'WP_Widget_Picture' );
