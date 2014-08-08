<?php

function new_flink_admin () {
    $flink_table = new NEW_Flink_List_Table();
    $flink_table -> prepare_items();
?>
<div class="wrap" >
    <h2><?php _e( '友情链接', 'new' ); ?></h2>
    <div class="manage-menus">
        <span><?php _e( '使用友情链接控件显示你的友情链接', 'new' ); ?><a href="<?php echo esc_url( admin_url( 'widgets.php' ) ); ?>" ><?php _e( '点击编辑', 'new' ); ?></a></span>
    </div>
    <div id="ajax-response"></div>
    <hr/>
    <form class="search-form" action="" method="get">
        <input type="hidden" name="page" id="page" value="<?php echo basename( __FILE__ ); ?>" />
        <?php $flink_table -> search_box( '搜索友情链接', 'flink_search' ); ?>
    </form>
    <br class="clear" />
    <div id="col-container" />
        <div id="col-right">
            <div id="col-wrap">
                <form id="flink-form" method="post" action="">
<?php $flink_table->Display(); ?>
                </form>
            </div> 
        </div>
        <div id="col-left">
            <div class="col-wrap">
                <div class="form-wrap">
                    <h3><?php _e( '新增友情链接', 'new' ); ?></h3>
                    <form id="addflink" method="post" class="validate">
                        <input type="hidden" name="action" value="save" />
                        <div class="form-field" >
                            <label for="link_name"><?php _e( '网站名称', 'new' ); ?></label>
                            <input name="link_name" id="link_name" type="text" value="" size="40" aria-required="true" />
                            <p><?php _e( '显示友情链接的网站名称', 'new' ); ?></p>
                        </div>
                        <div class="form-field" >
                            <label for="link_url"><?php _e( '网站链接', 'new' ); ?></label>
                            <input name="link_url" id="link_url" type="text" value="" size="40" aria-required="true" />
                            <p><?php _e( '友情链接所跳转到的网站链接', 'new' ); ?></p>
                        </div>
                        <p>
                            <input type="submit" name="submit" id="submit" class="button button-primary" value="<?php _e( '新增友链', 'new' ); ?>" />
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>    
<?php 
}
function new_flink_page () {
    if ( isset( $_REQUEST['action'] ) ) {
        $flink_data = get_option( 'flink_data' );

        switch ( $_REQUEST['action'] ) {
        case 'save':
	        $link_name = sanitize_text_field( $_REQUEST['link_name'] );
	        $link_url = esc_url_raw( $_REQUEST['link_url'] );
	        $link_date = time();
	        $link_data = array();
	
	        if ( ! empty( $link_name ) && ! empty( $link_url ) ) {
		        if ( empty( $flink_data ) ) : $flink_data = array(); endif;
		        if ( isset( $flink_data[ $link_name ] ) ) : $link_data = $flink_data[ $link_name ]; endif;
		
		        $flink_data[ $link_name ] = array(
		            'link_name'     => isset( $link_name ) ? $link_name : $link_data['link_name'],
		            'link_url'      => isset( $link_url ) ? $link_url : $link_data['link_url'],
		            'link_date'     => $link_date,
		            'link_status'   => isset( $link_data['link_status'] ) ? $link_data['link_status'] : 1
	            );
	        }
            break;
        case 'delete':
            $flinks = $_REQUEST['flink'];

            if ( isset( $flinks ) && is_array( $flinks ) ) {
                foreach ( $flinks as $n ) {
                    unset( $flink_data[$n] );
                }
            }
            break;
        case 'enabled':
            $flinks = $_REQUEST['flink'];

            if ( isset( $flinks ) && is_array( $flinks ) ) {
                foreach ( $flinks as $n ) {
                    if ( isset( $flink_data[$n] ) ) {
                        $flink_data[$n]['link_status'] = 1;
                    }
                }
            }
            break;
        case 'disabled':
            $flinks = $_REQUEST['flink'];

            if ( isset( $flinks ) && is_array( $flinks ) ) {
                foreach ( $flinks as $n ) {
                    if ( isset( $flink_data[$n] ) ) {
                        $flink_data[$n]['link_status'] = 0;
                    }
                }
            }
            break;
        }

        update_option( 'flink_data', $flink_data );
    }

    add_options_page( 'new_flink_options', 'Friendly links', 'manage_options', basename( __FILE__ ), 'new_flink_admin' );
}
add_action( 'admin_menu', 'new_flink_page' );
?>
