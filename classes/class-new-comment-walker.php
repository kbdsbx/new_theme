<?php

class New_Walker_Comment extends Walker {
    var $tree_type = 'comment';

    var $db_fields = array ( 'parent' => 'comment_parent', 'id' => 'comment_ID' );

    function start_lvl( &$output, $depth = 0, $args = array() ) {
        $GLOBALS['comment_depth'] = $depth + 1;
        $output .= '<ul class="children">' . "\n";
    }

    function end_lvl( &$output, $depth = 0, $args = array() ) {
        $GLOBALS['comment_depth'] = $depth + 1;
        $output .= '</ul>' . "\n";
    }

    function start_el( &$output, $comment, $depth = 0, $args = array(), $id = 0 ) {
        $depth++;
		$GLOBALS['comment_depth'] = $depth;
        $GLOBALS['comment'] = $comment;

        $output .= '<li>' . "\n";
        ob_start();
?>
<div>
    <div class="comment-avatar">
        <?php if ( 0 != $args['avatar_size'] ) echo get_avatar( $comment, $args['avatar_size'] ); ?>
    </div>
        <div class="commment-text-wrap">
            <div class="comment-data">
            <p><a href="#" class="url"><?php echo get_comment_author_link(); ?></a> <br /> <span><?php echo get_comment_date() . ' ' . get_comment_time(); ?> - <?php comment_reply_link( array_merge( $args, array( 'add_below' => 'comment', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?></span></p>
            </div>
        <div class="comment-text"><?php comment_text( get_comment_id(), array_merge( $args, array( 'add_below' => 'comment', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?></div>
    </div>
</div>
<?php
        $output .= ob_get_clean();
    }

    function end_el( &$output, $comment, $depth = 0, $args = array() ) {
        $output .= '</li>' . "\n";
    }
}
