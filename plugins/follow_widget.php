<?php

class WP_Widget_follow extends WP_Widget {
    function __construct() {
        add_action( 'admin_enqueue_scripts', array( $this, '_add_script' ) );
        add_action( 'wp_ajax_follow_widget_image_update', array( $this, '_follow_widget_image_update' ) );

        $widget_ops = array( 'classname' => 'widget_follow', 'description' => __( 'Follow', 'new' ) );
        parent::__construct( 'follow', __( 'Follow', 'new' ), $widget_ops );
    }

    function widget( $args, $instance ) {
        extract( $args ); 
        $first_name = empty( $instance['first_name'] ) ? '' : $instance['first_name'];
        $first_img = empty( $instance['first_img'] ) ? '' : $instance['first_img'];
        $first_qrcode = empty( $instance['first_qrcode'] ) ? '' : $instance['first_qrcode'];
        $second_name = empty( $instance['second_name'] ) ? '' : $instance['second_name'];
        $second_img = empty( $instance['second_img'] ) ? '' : $instance['second_img'];
        $second_qrcode= empty( $instance['second_qrcode'] ) ? '' : $instance['second_qrcode'];
        $third_name = empty( $instance['third_name'] ) ? '' : $instance['third_name'];
        $third_img = empty( $instance['third_img'] ) ? '' : $instance['third_img'];
        $third_qrcode = empty( $instance['third_qrcode'] ) ? '' : $instance['third_qrcode'];

        echo $before_widget;
?>
<div class="sidebar">
<h5 class="line"><span><?php _e( 'Attention to our', 'new' ); ?></span></h5>
    <ul class="social">
    	<li data-hover='' data-target=".wb">
        	<a href="#" class="weibo"><img src="<?php echo $first_img; ?>" alt="<?php echo $first_name; ?>"></img></a>
            <span><?php echo $first_name; ?></span>
            <img class="wb hover" src="<?php echo $first_qrcode; ?>" />
        </li>
        <li data-hover='' data-target=".wx">
        	<a href="#" class="weixin"><img src="<?php echo $second_img; ?>" alt="<?php echo $second_name; ?>"></img></a>
            <span><?php echo $second_name; ?></span>
            <img class="wx hover" src="<?php echo $second_qrcode; ?>" />
        </li>
        <li>
        	<a href="#" class="phone"><img src="<?php echo $third_img; ?>" alt="<?php echo $third_name; ?>"></img></a>
            <span><?php echo $third_name; ?></span>
            <img class="wx hover" src="<?php echo $third_qrcode; ?>" />
        </li>
    </ul>
</div>
<?php
    }

    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
var_dump( $new_instance );
        $instance['first_name'] = !empty( $new_instance['first_name'] ) ? $new_instance['first_name'] : '';
        $instance['first_img'] = !empty( $new_instance['first_img'] ) ? $new_instance['first_img'] : '';
        $instance['first_qrcode'] = !empty( $new_instance['first_qrcode'] ) ? $new_instance['first_qrcode'] : '';
        $instance['second_name'] = !empty( $new_instance['second_name'] ) ? $new_instance['second_name'] : '';
        $instance['second_img'] = !empty( $new_instance['second_img'] ) ? $new_instance['second_img'] : '';
        $instance['second_qrcode'] = !empty( $new_instance['second_qrcode'] ) ? $new_instance['second_qrcode'] : '';
        $instance['third_name'] = !empty( $new_instance['third_name'] ) ? $new_instance['third_name'] : '';
        $instance['third_img'] = !empty( $new_instance['third_img'] ) ? $new_instance['third_img'] : '';
        $instance['third_qrcode'] = !empty( $new_instance['third_qrcode'] ) ? $new_instance['third_qrcode'] : '';

        return $instance;
    }

    function _follow_widget_image_update() {
        $aid = $_REQUEST['attachment_id'];
        $asrc =  wp_get_attachment_image_src( $aid );

        $data = array(
            'aid' => $aid,
            'asrc' => $asrc
        );
        wp_send_json_success( $data );
    }

    function _add_script() {
		wp_enqueue_media();
        wp_enqueue_script( 'imgareaselect' );
        wp_enqueue_style( 'imgareaselect' );
        wp_enqueue_script( 'follow_widget_js', get_template_directory_uri() . '/plugins/js/follow_widget.js' );
    }

    function form( $instance ) {
        $first_name = esc_attr( $instance['first_name'] );
        $first_img = esc_attr( $instance['first_img'] );
        $first_qrcode = esc_attr( $instance['first_qrcode'] );
        $second_name= esc_attr( $instance['second_name'] );
        $second_img= esc_attr( $instance['second_img'] );
        $second_qrcode= esc_attr( $instance['second_qrcode'] );
        $third_name= esc_attr( $instance['third_name'] );
        $third_img= esc_attr( $instance['third_img'] );
        $third_qrcode= esc_attr( $instance['third_qrcode'] );
?>
    <p>
        <label for="<?php echo $this->get_field_id('first_name'); ?>"><?php _e('First Name:'); ?></label>
	    <input class="widefat" id="<?php echo $this->get_field_id('first_name'); ?>" name="<?php echo $this->get_field_name('first_name'); ?>" type="text" value="<?php echo $first_name; ?>" />
    </p>
    <p>
        <label for="<?php echo $this->get_field_id( 'first_img' ); ?>"><?php _e( 'First image:', 'new' ); ?></label>
        <br />
        <img id="preview_first_img" src="<?php echo esc_url( $first_img ); ?>" />
        <br />
        <input id="<?php echo $this->get_field_id('first_img'); ?>" name="<?php echo $this->get_field_name('first_img'); ?>" type="text" value="<?php echo $first_img; ?>" />
        <a id="<?php echo $this->get_field_id( 'first_img' ); ?>" name="<?php echo $this->get_field_name( 'first_img' ); ?>" class="button choose-from-library-link"
			data-update-url="<?php echo get_admin_url() . '/admin-ajax.php'; ?>"
			data-update-action="follow_widget_image_update"
			data-update-preview="preview_first_img"
			data-update-preview-id="<?php echo $this->get_field_id('first_img'); ?>"
			data-choose="<?php _e( 'Choose a Image', 'new' ); ?>"
			data-update="<?php _e( 'Select', 'new' ); ?>"><?php _e( 'Choose Image' ); ?></a>
	</p>
    <p>
        <label for="<?php echo $this->get_field_id( 'first_qrcode' ); ?>"><?php _e( 'First QR code:', 'new' ); ?></label>
        <br />
        <img id="preview_first_qrcode" src="<?php echo esc_url( $first_qrcode ); ?>" />
        <br />
        <input id="<?php echo $this->get_field_id('first_qrcode'); ?>" name="<?php echo $this->get_field_name('first_qrcode'); ?>" type="text" value="<?php echo $first_qrcode; ?>" />
        <a id="<?php echo $this->get_field_id( 'first_qrcode' ); ?>" name="<?php echo $this->get_field_name( 'first_qrcode' ); ?>" class="button choose-from-library-link"
			data-update-url="<?php echo get_admin_url() . '/admin-ajax.php'; ?>"
			data-update-action="follow_widget_image_update"
			data-update-preview="preview_first_qrcode"
			data-update-preview-id="<?php echo $this->get_field_id('first_qrcode'); ?>"
			data-choose="<?php _e( 'Choose a Image', 'new' ); ?>"
			data-update="<?php _e( 'Select', 'new' ); ?>"><?php _e( 'Choose Image' ); ?></a>
	</p>
    <p>
        <label for="<?php echo $this->get_field_id('second_name'); ?>"><?php _e('Second Name:'); ?></label>
	    <input class="widefat" id="<?php echo $this->get_field_id('second_name'); ?>" name="<?php echo $this->get_field_name('second_name'); ?>" type="text" value="<?php echo $second_name; ?>" />
    </p>
    <p>
        <label for="<?php echo $this->get_field_id( 'second_img' ); ?>"><?php _e( 'Second image:', 'new' ); ?></label>
        <br />
        <img id="preview_second_img" src="<?php echo esc_url( $second_img ); ?>" />
        <br />
        <input id="<?php echo $this->get_field_id('second_img'); ?>" name="<?php echo $this->get_field_name('second_img'); ?>" type="text" value="<?php echo $second_img; ?>" />
        <a id="<?php echo $this->get_field_id( 'second_img' ); ?>" name="<?php echo $this->get_field_name( 'second_img' ); ?>" class="button choose-from-library-link"
			data-update-url="<?php echo get_admin_url() . '/admin-ajax.php'; ?>"
			data-update-action="follow_widget_image_update"
			data-update-preview="preview_second_img"
			data-update-preview-id="<?php echo $this->get_field_id('second_img'); ?>"
			data-choose="<?php _e( 'Choose a Image', 'new' ); ?>"
			data-update="<?php _e( 'Select', 'new' ); ?>"><?php _e( 'Choose Image' ); ?></a>
	</p>
    <p>
        <label for="<?php echo $this->get_field_id( 'second_qrcode' ); ?>"><?php _e( 'Second QR code:', 'new' ); ?></label>
        <br />
        <img id="preview_second_qrcode" src="<?php echo esc_url( $second_qrcode ); ?>" />
        <br />
        <input id="<?php echo $this->get_field_id('second_qrcode'); ?>" name="<?php echo $this->get_field_name('second_qrcode'); ?>" type="text" value="<?php echo $second_qrcode; ?>" />
        <a id="<?php echo $this->get_field_id( 'second_qrcode' ); ?>" name="<?php echo $this->get_field_name( 'second_qrcode' ); ?>" class="button choose-from-library-link"
			data-update-url="<?php echo get_admin_url() . '/admin-ajax.php'; ?>"
			data-update-action="follow_widget_image_update"
			data-update-preview="preview_second_qrcode"
			data-update-preview-id="<?php echo $this->get_field_id('second_qrcode'); ?>"
			data-choose="<?php _e( 'Choose a Image', 'new' ); ?>"
			data-update="<?php _e( 'Select', 'new' ); ?>"><?php _e( 'Choose Image' ); ?></a>
	</p>
    <p>
        <label for="<?php echo $this->get_field_id('third_name'); ?>"><?php _e('Second Name:'); ?></label>
	    <input class="widefat" id="<?php echo $this->get_field_id('third_name'); ?>" name="<?php echo $this->get_field_name('third_name'); ?>" type="text" value="<?php echo $third_name; ?>" />
    </p>
    <p>
        <label for="<?php echo $this->get_field_id( 'third_img' ); ?>"><?php _e( 'Third image:', 'new' ); ?></label>
        <br />
        <img id="preview_third_img" src="<?php echo esc_url( $third_img ); ?>" />
        <br />
        <input id="<?php echo $this->get_field_id('third_img'); ?>" name="<?php echo $this->get_field_name('third_img'); ?>" type="text" value="<?php echo $third_img; ?>" />
        <a id="<?php echo $this->get_field_id( 'third_img' ); ?>" name="<?php echo $this->get_field_name( 'third_img' ); ?>" class="button choose-from-library-link"
			data-update-url="<?php echo get_admin_url() . '/admin-ajax.php'; ?>"
			data-update-action="follow_widget_image_update"
			data-update-preview="preview_third_img"
			data-update-preview-id="<?php echo $this->get_field_id('third_img'); ?>"
			data-choose="<?php _e( 'Choose a Image', 'new' ); ?>"
			data-update="<?php _e( 'Select', 'new' ); ?>"><?php _e( 'Choose Image' ); ?></a>
	</p>
    <p>
        <label for="<?php echo $this->get_field_id( 'third_qrcode' ); ?>"><?php _e( 'Third QR code:', 'new' ); ?></label>
        <br />
        <img id="preview_third_qrcode" src="<?php echo esc_url( $third_qrcode ); ?>" />
        <br />
        <input id="<?php echo $this->get_field_id('third_qrcode'); ?>" name="<?php echo $this->get_field_name('third_qrcode'); ?>" type="text" value="<?php echo $third_qrcode; ?>" />
        <a id="<?php echo $this->get_field_id( 'third_qrcode' ); ?>" name="<?php echo $this->get_field_name( 'third_qrcode' ); ?>" class="button choose-from-library-link"
			data-update-url="<?php echo get_admin_url() . '/admin-ajax.php'; ?>"
			data-update-action="follow_widget_image_update"
			data-update-preview="preview_third_qrcode"
			data-update-preview-id="<?php echo $this->get_field_id('third_qrcode'); ?>"
			data-choose="<?php _e( 'Choose a Image', 'new' ); ?>"
			data-update="<?php _e( 'Select', 'new' ); ?>"><?php _e( 'Choose Image' ); ?></a>
	</p>
<?php
    }
}
register_widget( 'WP_Widget_follow' );
