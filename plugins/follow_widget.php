<?php

class WP_Widget_follow extends WP_Widget {
    function __construct() {
        add_action( 'admin_enqueue_scripts', '_add_script' );
        add_action( 'wp_ajax_img_widget_update', '_img_widget_update' );

        $widget_ops = array( 'classname' => 'widget_follow', 'description' => __( '关注', 'new' ) );
        parent::__construct( 'follow', __( '关注', 'new' ), $widget_ops );
    }

    function widget( $args, $instance ) {
		$title      = apply_filters( 'widget_title', _filter_array_empty( $instance, 'title', __( '关注', 'new' ) ), $instance, $this->id_base );
        $count      = _filter_array_empty_numeric( $instance, 'count', 3 );
        $follow_img = _filter_array_empty_array( $instance, 'follow_img', array() );

        echo $args['before_widget'];
?>
<h5 class="line"><span><?php echo $title; ?></span></h5>
<ul class="social">
    <?php for( $i = 0; $i < $count; $i++ ) : $img = $follow_img[$i]; ?>
    <li>
        <div>
        <a href="javascript:void(0)" class="follow" style="background-color:<?php echo _filter_array_empty( $img, 'color', '' ); ?>;"><img src="<?php echo new_get_image_src( $img['src'], 'full' ); ?>" alt="<?php echo $img['name']; ?>" title="<?php echo $img['name']; ?>" /></a>
        <a href="javascript:void(0)" class="hover" ><img class="hover" src="<?php echo new_get_image_src( $img['qrcode'], 'full' );  ?>" /></a>
        </div>
        <span><?php echo $img['name']; ?></span>
    </li>
    <?php endfor; ?>
</ul>
<?php
        echo $args['after_widget'];
    }

    function update( $new_instance, $old_instance ) {
        $instance = array();

        $instance['title']  = _filter_empty( $new_instance['title'], '' );
        $instance['count']  = _filter_empty_numeric( $new_instance['count'], '' );
        $i = 0;
        $follow_img = array();
        while( isset( $new_instance['follow_name_' . $i] ) ) {
            $follow_img[] = array(
                'name' => _filter_empty( $new_instance[ 'follow_name_' . $i ], '' ),
                'src' => _filter_empty( $new_instance[ 'follow_src_' . $i ], '' ),
                'qrcode' => _filter_empty( $new_instance[ 'follow_qrcode_' . $i ], '' ),
                'color' => _filter_empty( $new_instance[ 'follow_color_' . $i ], '' ),
            );
            $i++;
        }
        $instance['follow_img'] = $follow_img;

        return $instance;
    }

    function form( $instance ) {
        $title = esc_attr( _filter_array_empty( $instance, 'title', '' ) );
        $count = esc_attr( _filter_array_empty( $instance, 'count', 1 ) );
        $follow_img = _filter_array_empty( $instance, 'follow_img', array() );

?>
	<p>
		<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( '标题:', 'new' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
	<p>
    <p>
			<label for="<?php echo $this->get_field_id('count'); ?>"><?php _e( '关注模块数量:', 'new' ); ?></label>
            <select class="select-element-count" id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>">
            <?php
            $count_enum = array( 1, 2, 3, 4, 5, 6 );
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
    <?php for( $i = 0; $i < $count_max; $i++ ) : ?>
    <div class="img-div" <?php if ( $i >= $count ) : echo 'style="display:none;"'; endif; ?>>
        <p>
	        <label for="<?php echo $this->get_field_id( 'follow_src_' . $i ); ?>"><?php printf( __( '第%s个模块图片:', 'new' ), $i + 1 ) ?></label>
	        <a class="button choose-from-library-link right"
				data-update-url="<?php echo get_admin_url() . 'admin-ajax.php'; ?>"
				data-update-action="img_widget_update"
	            data-update-preview=".preview_<?php echo $i; ?>_src"
				data-update-preview-src=".<?php echo $this->get_field_id( 'follow_src_' . $i ); ?>"
				data-choose="<?php _e( '选择图片', 'new' ); ?>"
				data-update="<?php _e( '选择', 'new' ); ?>"><?php _e( '选择图片', 'new' ); ?></a>
	    </p>
        <p>
	        <img class="preview_<?php echo $i; ?>_src" src="<?php if ( ! empty( $follow_img[ $i ] ) ) echo new_get_image_src( $follow_img[ $i ][ 'src' ], 'thumbnail' ); ?>" />
	        <input class="<?php echo $this->get_field_id( 'follow_src_' . $i ); ?>" name="<?php echo $this->get_field_name( 'follow_src_' . $i ); ?>" type="hidden" value="<?php if ( ! empty( $follow_img[ $i ] ) ) echo $follow_img[ $i ][ 'src' ]; ?>" />
        </p>
        <p>
	        <label for="<?php echo $this->get_field_id( 'follow_qrcode_' . $i ); ?>"><?php printf( __( '第%s个模块二维码:', 'new' ), $i + 1 ) ?></label>
	        <a class="button choose-from-library-link right"
				data-update-url="<?php echo get_admin_url() . 'admin-ajax.php'; ?>"
				data-update-action="img_widget_update"
	            data-update-preview=".preview_<?php echo $i; ?>_qrcode"
				data-update-preview-src=".<?php echo $this->get_field_id( 'follow_qrcode_' . $i ); ?>"
				data-choose="<?php _e( '选择图片', 'new' ); ?>"
				data-update="<?php _e( '选择', 'new' ); ?>"><?php _e( '选择图片', 'new' ); ?></a>
	    </p>
        <p>
	        <img class="preview_<?php echo $i; ?>_qrcode" src="<?php if ( ! empty( $follow_img[ $i ] ) ) echo new_get_image_src( $follow_img[ $i ][ 'qrcode' ], 'thumbnail' ); ?>" />
	        <input class="<?php echo $this->get_field_id( 'follow_qrcode_' . $i ); ?>" name="<?php echo $this->get_field_name( 'follow_qrcode_' . $i ); ?>" type="hidden" value="<?php if ( ! empty( $follow_img[ $i ] ) ) echo $follow_img[ $i ][ 'qrcode' ]; ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'follow_name_' . $i ); ?>"><?php printf( __( '第%s个模块名称:', 'new' ), $i + 1 ); ?></label>
            <input id="<?php echo $this->get_field_id( 'follow_name_' . $i ); ?>" name="<?php echo $this->get_field_name( 'follow_name_' . $i ); ?>" type="text" value="<?php if ( ! empty( $follow_img[ $i ] ) ) echo $follow_img[ $i ][ 'name' ]; ?>" /> 
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'follow_color_' . $i ); ?>"><?php printf( __( '第%s个模块背景色:', 'new' ), $i + 1 ); ?></label>
            <input type="text" name="<?php echo $this->get_field_name( 'follow_color_' . $i ); ?>" id="<?php echo $this->get_field_id( 'follow_color_' . $i ); ?>" class="choose-color" value="<?php if ( ! empty( $follow_img[ $i ] ) ) echo $follow_img[ $i ][ 'color' ]; ?>"/>
        </p>
        <hr/>
    </div>
    <?php endfor; ?>
    
    <?php _img_widget_update_js(); ?>
    <?php _color_widget_update_js(); ?>
<?php
    }
}
register_widget( 'WP_Widget_follow' );
