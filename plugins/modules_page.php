<?php
function new_module_admin() {
    global $new_module_type;
    $module_table = new NEW_Modules_List_Table();
    $module_table->prepare_items();
?>
<div class="wrap">
    <h2><?php _e( '首页模块', 'new' ); ?></h2>
    <div class="manage-menus">
        <span><?php _e( '为你的首页增加模块', 'new' ); ?></span>
    </div>
    <div id="ajax-response"></div>
    <hr/>
    <form class="search-form" action="" method="get">
        <input type="hidden" name="page" id="page" value="<?php echo basename( __FILE__ ); ?>" />
        <?php $module_table->search_box( '搜索模块', 'module_search' ); ?>
    </form>
    <br class="clear" />
    <div id="col-container">
        <div id="col-right">
            <div id="col-wrap">
                <form id="module-form" method="post" action="">
                    <input type="hidden" name="page" id="page" value="<?php echo basename( __FILE__ ); ?>" />
                    <?php $module_table->Display(); ?>
                </form>
            </div>
        </div>
        <div id="col-left">
            <div class="col-wrap">
                <div class="form-wrap">
	                <h3><?php _e( '新增首页模块', 'new' ); ?></h3>
                    <form id="addmodule" method="post" action="" class="validate">
                        <input type="hidden" name="page" id="page" value="<?php echo basename( __FILE__ ); ?>" />
                        <input type="hidden" name="action" value="save" />
                        <div class="form-field">
                            <label for="module_name"><?php _e( '名称', 'new' ); ?></label>
                            <input name="module_name" id="module_name" type="text" value="" size="40" aria-required="true" />
                            <p><?php _e( '显示模块名称', 'new' ); ?></p>
                        </div>
                        <div class="form-field">
                            <label for="module_category"><?php _e( '分类目录', 'new' );?></label>
                            <!--select name="module_category" id="module_category" aria-required="true"-->
                            <?php wp_dropdown_categories( array( 'name' => 'module_category', 'id' => 'module_category', 'show_option_all' => __( '全部', 'new' ), 'hide_empty' => '0', 'taxonomy' => 'category' ) ); ?>
                            <!--/select-->
                            <p><?php _e( '选择显示某一分类目录下的文章', 'new' );?></p>
                        </div>
                        <div class="form-field">
                            <label for="module_post_count"><?php _e( '显示文章数量', 'new' ); ?></label>
                            <input name="module_post_count" id="module_post_count" type="text" value="" size="40" aria-required="true" />
                            <p><?php _e( '显示文章数量', 'new' ); ?></p>
                        </div>
                        <div class="form-field">
                            <label for="module_type"><?php _e( '显示类型', 'new' ); ?></label>
                            <select name="module_type" id="module_type" aria-required="true">
                            <?php foreach( $new_module_type as $key => $type ) : ?>
                                <option value="<?php echo $key; ?>"><?php echo $type; ?></option>
                            <?php endforeach; ?>
                            </select>
                            <p><?php _e( '文章的显示类型，包括图文显示，仅文字，滚动，等', 'new' ); ?></p>
                        </div>
                        <div class="form-field">
                            <label for="module_weight"><?php _e( '模块权重', 'new' ); ?></label>
                            <input name="module_weight" id="module_weight" type="text" value="" size="40" aria-required="true" />
                            <p><?php _e( '模块权重（数字），权重越小所显示的位置越靠前', 'new' ); ?></p>
                        </div>
                        <p>
                            <input type="submit" name="submit" id="submit" class="button button-primary" value="<?php _e( '新增模块', 'new' ); ?>" />
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
}

function new_modules_page() {
    if ( isset( $_REQUEST['page'] ) && $_REQUEST['page'] == basename( __FILE__ ) ) {
        $modules_data = get_option( 'modules_data' );

        switch ( $_REQUEST['action'] ) {
        case 'save':
            $module_name = sanitize_text_field( $_REQUEST['module_name'] );
            $module_category = esc_attr( $_REQUEST['module_category'] );
            $module_post_count = esc_attr( $_REQUEST['module_post_count'] );
            $module_type = esc_attr( $_REQUEST['module_type'] );
            $module_weight = esc_attr( $_REQUEST['module_weight'] );
            $module_status = 1;
            $module_date = time();

            if ( isset( $module_name) && isset( $module_category ) ) {
                if ( empty( $modules_data ) ) $modules_data = array();

                $modules_data[ $module_name ] = array(
                    'module_name'       => $module_name,
                    'module_category'   => $module_category,
                    'module_post_count' => _filter_empty( $module_post_count, 4 ),
                    'module_type'       => _filter_empty( $module_type, '0' ),
                    'module_weight'     => _filter_empty_numeric( $module_weight, 10 ),
                    'module_status'     => $module_status,
                    'module_date'       => $module_date,
                );
            }
            break;
        case 'delete':
            $modules = $_REQUEST['module'];

            if ( isset( $modules ) && is_array( $modules ) ) {
                foreach ( $modules as $m ) {
                    unset( $modules_data[$m] );
                }
            }
            break;
        case 'enabled' :
            $modules = $_REQUEST['module'];

            if ( isset( $modules ) && is_array( $modules ) ) {
                foreach( $modules as $m ) {
                    if ( isset( $modules_data[$m] ) ) {
                        $modules_data[$m]['module_status'] = 1;
                    }
                }
            }
            break;
        case 'disabled' :
            $modules = $_REQUEST['module'];

            if ( isset( $modules ) && is_array( $modules ) ) {
                foreach ( $modules as $m ) {
                    if ( isset( $modules_data[$m] ) ) {
                        $modules_data[$m]['module_status'] = 0;
                    }
                }
            }
            break;
        }

        update_option( 'modules_data', $modules_data );
    }
    add_options_page( 'new_modules_options', __( '首页模块', 'new' ), 'manage_options', basename( __FILE__, '.php' ), 'new_module_admin' );
}
add_action( 'admin_menu', 'new_modules_page' );
?>
