<?php

class WP_Widget_ads extends WP_Widget {
    function __construct() {
        add_action( 'admin_enqueue_scripts', '_add_script' );
        add_action( 'wp_ajax_img_widget_update', '_img_widget_update' );
        $widget_ops = array( 'classname' => 'widget_ads', 'description' => __( 'Ads used to pictures', 'new' ) );
        parent::__construct( 'ads', __( 'Ads Pictures', 'new' ), $widget_ops );
    }

    function widget( $args, $instance ) {
        global $size_enum;

        $title      = apply_filters( 'widget_title', _filter_empty( $instance['title'], __( 'Ads Pictures', 'new' ), $instance, $this->id_base ) );
        $size       = _filter_empty( $instance['size'], 'x' );
        $count      = _filter_empty_numeric( $instance['count'], 1 );
        $ads_img    = _filter_empty_array( $instance['ads_img'], array() );

        if ( $size == 'auto' ) {
            $width = _filter_empty( $instance['width'], '' );
            $height = _filter_empty( $instance['height'], '');
            $img_size = array( $width, $height );
            add_image_size( $size, $width, $height, true );
        } else {
            $img_size = $size_enum[ $instance['size'] ];
        }
        echo $args[ 'before_widget' ];
?>
<h5 class="line"><span><?php echo $title; ?></span></h5>
<?php if ( $count > 1 ) : ?>
<ul class="ads125">
    <?php for( $i = 0; $i < $count; $i++ ) : $img = $ads_img[$i]; ?>
    <li><a href="<?php echo _filter_empty( $img['link'], '#' ); ?>"><img width="<?php echo $img_size[0]; ?>" height="<?php echo $img_size[1]; ?>" src="<?php echo wp_get_attachment_image_src( $img['src'], $size )[0]; ?>" alt="<?php echo $img['name']; ?>" /></a></li>
    <?php endfor; ?>
</ul>
<?php else : ?>
<a href="<?php echo _filter_empty( $ads_img[0]['link'], '#' ); ?>"><img width="<?php echo $img_size[0]; ?>" height="<?php echo $img_size[1]; ?>" src="<?php echo wp_get_attachment_image_src( $ads_img[0]['src'], $size )[0]; ?>" alt="<?php echo $ads_img[0]['name']; ?>" /></a>
<?php endif; ?>
<?php
        echo $args[ 'after_widget' ];
    }

    function update( $new_instance, $old_instance ) {
        $instance = array();

        $instance['size']   = _filter_empty( $new_instance['size'], $old_instance['size'] );
        $instance['title']  = _filter_empty( $new_instance['title'], $old_instance['title'] );
        $instance['count']  = _filter_empty_numeric( $new_instance['count'], $old_instance['count'] );
        $instance['width']  = _filter_empty( $new_instance['width'], $old_instance['width'] );
        $instance['height']  = _filter_empty( $new_instance['height'], $old_instance['height'] );
        $ads_img = array();
        $i = 0;
        while( isset( $new_instance[ 'ads_src_' . $i ] ) ) {
            $ads_img[] = array(
                'name' => _filter_empty( $new_instance[ 'ads_name_' . $i ], $old_instance[ 'ads_img' ][$i]['name'] ),
                'src' => _filter_empty( $new_instance[ 'ads_src_' . $i ], $old_instance[ 'ads_img' ][$i]['src'] ),
                'link' => _filter_empty( $new_instance[ 'ads_link_' . $i ], $old_instance[ 'ads_img' ][$i]['link'] ),
            );
            $i++;
        }
        $instance['ads_img'] = $ads_img;

        return $instance;
    }

    function form( $instance ) {
        global $size_enum;
        $title = esc_attr( _filter_object_empty( $instance, 'title', '' ) );
        $count = esc_attr( _filter_object_empty( $instance, 'count', 1 ) );
        $img_size = esc_attr( _filter_object_empty( $instance, 'size', '' ) );
        $ads_img = _filter_object_empty( $instance, 'ads_img', array() );
        $width = _filter_object_empty( $instance, 'width', '' );
        $height = _filter_object_empty( $instance, 'height', '' );
?>
        <p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title:', 'new' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
			</p>
		<p>
		<p>
			<label for="<?php echo $this->get_field_id('count'); ?>"><?php _e( 'Ads count:', 'new' ); ?></label>
            <select class="select-element-count" id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>">
            <?php
            $count_enum = array( 1, 2, 4, 6, 8 );
            $count_max = max( $count_enum );
            foreach( $count_enum as $c ) {
                if ( $c == $count ) {
                    printf( '<option value="%s" selected="selected">%s</option>', $c, $c );
                } else {
                    printf( '<option value="%s">%s</option>', $c, $c );
                }
            }
            ?>
            </select>
            <?php _select_update_js(); ?>
		</p>
        <p>
			<label for="<?php echo $this->get_field_id( 'size' ); ?>"><?php _e( 'Size:', 'new' ); ?></label>
			<br />
			<?php foreach( $size_enum as $size_key => $size ) : ?>
			<input type="radio" name="<?php echo $this->get_field_name('size'); ?>" id="<?php echo $this->get_field_id('size'); ?>" <?php if ( $img_size == $size_key ) : echo 'checked="checked"'; endif ?> value="<?php echo $size_key; ?>" />
			<?php echo $size[0]; ?> * <?php echo $size[1]; ?>
			<br />
			<?php endforeach; ?>
            <input type="radio" name="<?php echo $this->get_field_name('size'); ?>" id="<?php echo $this->get_field_id('size'); ?>" <?php if ( $img_size == 'auto' ) : echo 'checked="checked"'; endif ?> value="auto" />
            <input type="text" value="<?php echo $width; ?>" size="6" name="<?php echo $this->get_field_name('width'); ?>" id="<?php echo $this->get_field_id('width'); ?>" placeholder="<?php _e( 'Width', 'new' ); ?>" /> * <input type="text" value="<?php echo $height; ?>" size="6" name="<?php echo $this->get_field_name('height'); ?>" id="<?php echo $this->get_field_id('height'); ?>" placeholder="<?php _e( 'Height', 'new' ); ?>" />
		</p>
	    <?php for( $i = 0; $i < $count_max; $i++ ) : ?>
        <div class="img-div" <?php if ( $i >= $count ) : echo 'style="display:none;"'; endif; ?>>
        <p>
	        <label for="<?php echo $this->get_field_id( 'ads_src_' . $i ); ?>"><?php printf( __( 'Image No.%s:', 'new' ), $i + 1 ) ?></label>
	        <a class="button choose-from-library-link"
				data-update-url="<?php echo get_admin_url() . 'admin-ajax.php'; ?>"
				data-update-action="img_widget_update"
	            data-update-preview=".preview_<?php echo $i; ?>_src"
				data-update-preview-src=".<?php echo $this->get_field_id( 'ads_src_' . $i ); ?>"
				data-choose="<?php _e( 'Choose a Image', 'new' ); ?>"
				data-update="<?php _e( 'Select', 'new' ); ?>"><?php _e( 'Choose Image', 'new' ); ?></a>
	    </p>
        <p>
            <img class="preview_<?php echo $i; ?>_src" src="<?php if ( ! empty( $ads_img[ $i ] ) ) echo wp_get_attachment_image_src( $ads_img[ $i ][ 'src' ] )[0]; ?>" />
	        <input class="<?php echo $this->get_field_id( 'ads_src_' . $i ); ?>" name="<?php echo $this->get_field_name( 'ads_src_' . $i ); ?>" type="hidden" value="<?php if ( ! empty( $ads_img[ $i ] ) ) echo $ads_img[ $i ][ 'src' ]; ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'ads_name_' . $i ); ?>"><?php printf( __( 'Name No.%s:', 'new' ), $i + 2 ); ?></label>
            <input id="<?php echo $this->get_field_id( 'ads_name_' . $i ); ?>" name="<?php echo $this->get_field_name( 'ads_name_' . $i ); ?>" type="text" value="<?php if ( ! empty( $ads_img[ $i ] ) ) echo $ads_img[ $i ][ 'name' ]; ?>" /> 
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'ads_link_' . $i ); ?>"><?php printf( __( 'Link No.%s:', 'new' ), $i + 3 ); ?></label>
            <input id="<?php echo $this->get_field_id( 'ads_link_' . $i ); ?>" name="<?php echo $this->get_field_name( 'ads_link_' . $i ); ?>" type="text" value="<?php if ( ! empty( $ads_img[ $i ] ) ) echo $ads_img[ $i ][ 'link' ]; ?>" /> 
        </p>
        <hr/>
        </div>
	    <?php endfor; ?>
        <?php _img_widget_update_js(); ?>
<?php
    }
}
register_widget( 'WP_Widget_ads' );
