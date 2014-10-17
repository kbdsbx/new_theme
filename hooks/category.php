<?php

/* category */

/**
 * 添加新增分类目录所需属性相关设置
 */
function new_category_form_fields() {
    global $post_types;
?>
<div class="form-field">
    <label for="new_post_type"><?php _e( '文章类型', 'new' ); ?></label>
    <select name="new_post_type" id="new_post_type" class="postform">
    <?php foreach ( $post_types as $key => $post_type ) : ?>
        <option value="<?php echo $key; ?>"><?php echo $post_type; ?></option>
    <?php endforeach; ?>
    </select> 
    <p><?php _e( '用于调用不同文章类型模板', 'new' ); ?></p>
</div>
<?php
}
add_action( 'category_add_form_fields', 'new_category_form_fields' );

/**
 * 添加编辑分类目录所需属性相关设置
 */
function new_category_edit_form_fields( $tag ) {
    global $post_types;
    $categories_post_type = _filter_empty_array( get_option( 'categories_post_type' ) );
?>
<tr class="form-field">
    <th scope="row"><label for="new_post_type"><?php _e( '文章类型', 'new' ); ?></label></th>
    <td>
        <select name="new_post_type" id="new_post_type" class="postform">
        <?php foreach ( $post_types as $key => $post_type ) : ?>
            <option value="<?php echo $key; ?>" <?php if( isset( $categories_post_type[ $tag->term_id ] ) && $categories_post_type[ $tag->term_id ] == $key ) { echo 'selected="selected"'; } ?>><?php echo $post_type; ?></option>
        <?php endforeach; ?>
        </select> 
		<p class="description"><?php _e( '用于调用不同文章类型模板', 'new' ); ?></p>
	</td>
</tr>
<?php
}
add_action( 'category_edit_form_fields', 'new_category_edit_form_fields' );

/**
 * 保存分类目录所需属性
 */
function new_category_save_fields( $term_id ) {
    $categories_post_type = _filter_empty_array( get_option( 'categories_post_type' ) );
    $categories_post_type[ $term_id ] = _filter_array_empty( $_POST, 'new_post_type', 'post' );
    update_option( 'categories_post_type', $categories_post_type );
}
add_action( 'created_category', 'new_category_save_fields' );
add_action( 'edited_category','new_category_save_fields' );

/**
 * 分类目录针对不同文章类型的模板筛选
 */
function new_filter_category_template( $template_path ) {
    $cat_ID = get_query_var( 'cat' );
    $categories_post_type = get_option( 'categories_post_type' );
    $post_type = _filter_array_empty( $categories_post_type, $cat_ID, '' );
    $template = get_template_directory() . '/category-' . $post_type . '.php';
    if ( $post_type != 'post' && file_exists( $template ) ) {
        $template_path = $template;
    }

    return $template_path;
}
add_filter( 'category_template', 'new_filter_category_template' );

/**
 * 修改文章分类目录选择形式，使用自定义new_walker_category_radiolist将其更改为单项选择
 */
function new_terms_checklist_args( $args ) {
    if ( $args['taxonomy'] == 'category' ) {
        $args['walker'] = new New_Walker_Category_Radiolist();
    }

    return $args;
}
add_filter( 'wp_terms_checklist_args', 'new_terms_checklist_args' );

/**
 * 过滤文章分类目录选择形式
 */
function new_filter_get_terms( $terms, $taxonomies, $args ) {
    global $post;

    $post_type = _filter_object_empty( $post, 'post_type', _filter_array_empty( $_REQUEST, 'post_type', '' ) );
    if ( in_array( 'category', $taxonomies ) ) {
        foreach ( $terms as $key => $term ) {
            $categories_post_type = get_option( 'categories_post_type' );
            $category_post_type = _filter_array_empty( $categories_post_type, _filter_object_empty( $term, 'term_id', '' ), '' );
            if ( ! empty( $post_type ) && ! empty( $category_post_type ) && $post_type != $category_post_type ) {
                unset( $terms[ $key ] );
            }
        }
    }
    return $terms;
}
add_filter( 'get_terms', 'new_filter_get_terms', 10, 3 );

/* !category */
