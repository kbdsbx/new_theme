<?php

class WP_Widget_ads extends WP_Widget {
    function __construct() {
        add_action( 'admin_enqueue_scripts', '_add_script' );
        add_action( 'wp_ajax_img_widget_update', '_img_widget_update' );
        $widget_ops = array( 'classname' => 'widget_ads', 'description' => __( '使用图片作为广告的控件', 'new' ) );
        parent::__construct( 'ads', __( '图片广告控件', 'new' ), $widget_ops );
    }

    function widget( $args, $instance ) {
        global $size_enum;

        $title      = apply_filters( 'widget_title', _filter_array_empty( $instance, 'title', __( '图片广告控件', 'new' ), $instance, $this->id_base ) );
        $size       = _filter_array_empty( $instance, 'size', 'x' );
        $count      = _filter_array_empty_numeric( $instance, 'count', 1 );
        $ads_img    = _filter_array_empty_array( $instance, 'ads_img', array() );

        if ( $size == 'auto' ) {
            $width = _filter_arrayt_empty( $instance, 'width', '' );
            $height = _filter_array_empty( $instance, 'height', '');
            $img_size = array( $width, $height );
        } else {
            $img_size = $size_enum[ $instance['size'] ];
        }
        echo $args[ 'before_widget' ];
?>
<h5 class="line"><span><?php echo $title; ?></span></h5>
<?php if ( $count > 1 ) : ?>
<ul class="ads125">
    <?php for( $i = 0; $i < $count; $i++ ) : $img = $ads_img[$i]; ?>
        <li><a href="<?php echo _filter_empty( $img['link'], '#' ); ?>"><img width="<?php echo $img_size[0]; ?>" height="<?php echo $img_size[1]; ?>" src="<?php echo new_get_image_src( $img['src'], $size ) ?>" alt="<?php echo $img['name']; ?>" title="<?php echo $img['name']; ?>" /></a></li>
    <?php endfor; ?>
</ul>
    <?php else : ?>
    <a href="<?php echo _filter_empty( $ads_img[0]['link'], '#' ); ?>"><img width="<?php echo $img_size[0]; ?>" height="<?php echo $img_size[1]; ?>" src="<?php echo new_get_image_src( $ads_img[0]['src'], $size ); ?>" alt="<?php echo $ads_img[0]['name']; ?>" title="<?php echo $ads_img[0]['name']; ?>" /></a>
    <?php endif; ?>
<?php
        echo $args[ 'after_widget' ];
    }

    function update( $new_instance, $old_instance ) {
        $instance = array();

        $instance['size']   = _filter_empty( $new_instance['size'], '' );
        $instance['title']  = _filter_empty( $new_instance['title'], '' );
        $instance['count']  = _filter_empty_numeric( $new_instance['count'], '' );
        $instance['width']  = _filter_empty( $new_instance['width'], '' );
        $instance['height']  = _filter_empty( $new_instance['height'], '' );
        $ads_img = array();
        $i = 0;
        while( isset( $new_instance[ 'ads_src_' . $i ] ) ) {
            $ads_img[] = array(
                'name' => _filter_empty( $new_instance[ 'ads_name_' . $i ], '' ),
                'src' => _filter_empty( $new_instance[ 'ads_src_' . $i ], '' ),
                'link' => _filter_empty( $new_instance[ 'ads_link_' . $i ], '' ),
            );
            $i++;
        }
        $instance['ads_img'] = $ads_img;

        return $instance;
    }

    function form( $instance ) {
        global $size_enum;
        $title = esc_attr( _filter_array_empty( $instance, 'title', '' ) );
        $count = esc_attr( _filter_array_empty( $instance, 'count', 1 ) );
        $img_size = esc_attr( _filter_array_empty( $instance, 'size', '' ) );
        $ads_img = _filter_array_empty( $instance, 'ads_img', array() );
        $width = _filter_array_empty( $instance, 'width', '' );
        $height = _filter_array_empty( $instance, 'height', '' );
?>
        <p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( '标题:', 'new' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
			</p>
		<p>
		<p>
			<label for="<?php echo $this->get_field_id('count'); ?>"><?php _e( '广告数量:', 'new' ); ?></label>
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
			<label for="<?php echo $this->get_field_id( 'size' ); ?>"><?php _e( '图片大小:', 'new' ); ?></label>
			<br />
			<?php foreach( $size_enum as $size_key => $size ) : ?>
			<input type="radio" name="<?php echo $this->get_field_name('size'); ?>" id="<?php echo $this->get_field_id('size'); ?>" <?php if ( $img_size == $size_key ) : echo 'checked="checked"'; endif ?> value="<?php echo $size_key; ?>" />
			<?php echo $size[0]; ?> * <?php echo $size[1]; ?>
			<br />
			<?php endforeach; ?>
            <input type="radio" name="<?php echo $this->get_field_name('size'); ?>" id="<?php echo $this->get_field_id('size'); ?>" <?php if ( $img_size == 'auto' ) : echo 'checked="checked"'; endif ?> value="auto" />
            <input type="text" value="<?php echo $width; ?>" size="6" name="<?php echo $this->get_field_name('width'); ?>" id="<?php echo $this->get_field_id('width'); ?>" placeholder="<?php _e( '宽度', 'new' ); ?>" /> * <input type="text" value="<?php echo $height; ?>" size="6" name="<?php echo $this->get_field_name('height'); ?>" id="<?php echo $this->get_field_id('height'); ?>" placeholder="<?php _e( '高度', 'new' ); ?>" />
		</p>
	    <?php for( $i = 0; $i < $count_max; $i++ ) : ?>
        <div class="img-div" <?php if ( $i >= $count ) : echo 'style="display:none;"'; endif; ?>>
        <p>
	        <label for="<?php echo $this->get_field_id( 'ads_src_' . $i ); ?>"><?php printf( __( '第%s位广告图片:', 'new' ), $i + 1 ) ?></label>
	        <a class="button choose-from-library-link right"
				data-update-url="<?php echo get_admin_url() . 'admin-ajax.php'; ?>"
				data-update-action="img_widget_update"
	            data-update-preview=".preview_<?php echo $i; ?>_src"
				data-update-preview-src=".<?php echo $this->get_field_id( 'ads_src_' . $i ); ?>"
				data-choose="<?php _e( '选择图片', 'new' ); ?>"
				data-update="<?php _e( '选择', 'new' ); ?>"><?php _e( '选择图片', 'new' ); ?></a>
	    </p>
        <p>
            <img class="preview_<?php echo $i; ?>_src" src="<?php if ( ! empty( $ads_img[ $i ] ) ) echo new_get_image_src( $ads_img[ $i ][ 'src' ] ); ?>" />
	        <input class="<?php echo $this->get_field_id( 'ads_src_' . $i ); ?>" name="<?php echo $this->get_field_name( 'ads_src_' . $i ); ?>" type="hidden" value="<?php if ( ! empty( $ads_img[ $i ] ) ) echo $ads_img[ $i ][ 'src' ]; ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'ads_name_' . $i ); ?>"><?php printf( __( '第%s位广告名称:', 'new' ), $i + 1 ); ?></label>
            <input id="<?php echo $this->get_field_id( 'ads_name_' . $i ); ?>" name="<?php echo $this->get_field_name( 'ads_name_' . $i ); ?>" type="text" value="<?php if ( ! empty( $ads_img[ $i ] ) ) echo $ads_img[ $i ][ 'name' ]; ?>" /> 
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'ads_link_' . $i ); ?>"><?php printf( __( '第%s位广告链接:', 'new' ), $i + 1 ); ?></label>
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
