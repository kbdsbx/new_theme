<?php
if ( post_password_required() )  { return; }
?>
<div class="comment-div-form">
<h5 class="line"><span><?php _e( '评论', 'new' ); ?></span></h5>
<?php
comment_form( array(
    'title_reply'       => '',
    'comment_field'     => '<div class="form"><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea></div>'
) );
?>
</div>
<div class="comments">
    <h5 class="line"><span><?php _e( '评论列表', 'new' ); ?></span></h5>
    <div class="comments-content">
<?php if ( have_comments() ) : ?>
        <ul class="comment-list">
			<?php
				wp_list_comments( array(
                    'walker'    => new New_Walker_Comment(),
                    'type'      => 'comment',
                    'max_depth' => '0'
				) );
			?>
		</ul><!-- .comment-list -->
<?php else : ?>
<?php _e( '列表为空', 'new' ); ?>
<?php endif; ?>
<?php
if ( ! comments_open() && get_comments_number() ) : 
    _e( '抱歉，本文章评论已关闭', 'new' );
endif;
?>
    </div>
</div>
