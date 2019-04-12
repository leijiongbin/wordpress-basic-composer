<?php
if ( post_password_required() ) {
    return;
}
?>

<?php
    comment_form( array(
        'title_reply'        => '评论<span class="reply-data reply-sum">' . get_comments_number( '0', '1', '%' ) . '</span>',
        'title_reply_before' => '<h2 id="reply-title" class="comment-reply-title">',
        'title_reply_after'  => '</h2>',
        'comment_field'      => '<p class="comment-form-comment"><label for="comment">请输入评论内容</label><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea></p>',
        'must_log_in'        => '<p class="must-log-in"><a href="javascript:;" show="login-box">登陆</a>后，发表评论</p>',
        'logged_in_as'       => '<p class="logged-in-as">' . sprintf( __( '欢迎 <a href="%1$s">%2$s</a>， <a href="%3$s" title="退出">退出?</a>' ), of_get_option('of_account_link'), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink( ) ) ) ) . '</p>',
    ) );
?>

<div class="comment" id="comment">    
    <?php if ( have_comments() ) : ?>

            <?php
                wp_list_comments(array(
                    'per_page' => 5, //Allow comment pagination
                    'type'     => 'comment',
                    'walker'   => new Walker_Comment_custom(),
                    'max_depth'         => '',
                    'style'             => 'div',
                    'callback'          => null,
                    'end-callback'      => null,
                    'reply_text'        => '回复',
                    'page'              => '',
                    'avatar_size'       => 96,
                    'reverse_top_level' => null,
                    'reverse_children'  => '',
                    'format'            => 'html5', 
                    'short_ping'        => false,
                    'echo'              => true,
                ));
            ?>
    <?php else : ?>

    <div class="no-comment">
    <p><a href="#addcomment">沙发还没有人坐，赶紧来霸位吧~</a></p>
    </li>

    <?php endif;  ?>

</div><!-- .comments-area -->

    <?php if (get_comment_pages_count()) : ?>
        <div class="pages2">
        <?php //echo paginate_comments_links('prev_text=上一页&next_text=下一页');?>
        <p><?php previous_comments_link(' ') ?><span><?php echo get_query_var('cpage') ?: 1; ?>/<?php echo get_comment_pages_count(); ?></span><?php next_comments_link(' ') ?></p>
        </div>
    <?php endif; ?>


<?php
/**
 * Comment API: Walker_Comment class
 */
class Walker_Comment_custom extends Walker_Comment {

    public $tree_type = 'comment';

    public $db_fields = array ('parent' => 'comment_parent', 'id' => 'comment_ID');


    public function start_lvl( &$output, $depth = 0, $args = array() ) {
        $GLOBALS['comment_depth'] = $depth + 1;

        switch ( $args['style'] ) {
            case 'div':
                break;
            case 'ol':
                $output .= '<ol class="children">' . "\n";
                break;
            case 'ul':
            default:
                $output .= '<ul class="children">' . "\n";
                break;
        }
    }


    public function end_lvl( &$output, $depth = 0, $args = array() ) {
        $GLOBALS['comment_depth'] = $depth + 1;

        switch ( $args['style'] ) {
            case 'div':
                break;
            case 'ol':
                $output .= "</ol><!-- .children -->\n";
                break;
            case 'ul':
            default:
                $output .= "</ul><!-- .children -->\n";
                break;
        }
    }


    public function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output ) {
        if ( !$element )
            return;

        $id_field = $this->db_fields['id'];
        $id = $element->$id_field;

        parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );

        /*
         * If we're at the max depth, and the current element still has children,
         * loop over those and display them at this level. This is to prevent them
         * being orphaned to the end of the list.
         */
        if ( $max_depth <= $depth + 1 && isset( $children_elements[$id]) ) {
            foreach ( $children_elements[ $id ] as $child )
                $this->display_element( $child, $children_elements, $max_depth, $depth, $args, $output );

            unset( $children_elements[ $id ] );
        }

    }


    public function start_el( &$output, $comment, $depth = 0, $args = array(), $id = 0 ) {
        $depth++;
        $GLOBALS['comment_depth'] = $depth;
        $GLOBALS['comment'] = $comment;

        if ( !empty( $args['callback'] ) ) {
            ob_start();
            call_user_func( $args['callback'], $comment, $args, $depth );
            $output .= ob_get_clean();
            return;
        }

        if ( ( 'pingback' == $comment->comment_type || 'trackback' == $comment->comment_type ) && $args['short_ping'] ) {
            ob_start();
            $this->ping( $comment, $depth, $args );
            $output .= ob_get_clean();
        } elseif ( 'html5' === $args['format'] ) {
            ob_start();
            $this->html5_comment( $comment, $depth, $args );
            $output .= ob_get_clean();
        } else {
            ob_start();
            $this->comment( $comment, $depth, $args );
            $output .= ob_get_clean();
        }
    }


    public function end_el( &$output, $comment, $depth = 0, $args = array() ) {
        if ( !empty( $args['end-callback'] ) ) {
            ob_start();
            call_user_func( $args['end-callback'], $comment, $args, $depth );
            $output .= ob_get_clean();
            return;
        }
        if ( 'div' == $args['style'] )
            $output .= "</div><!-- #comment-## -->\n";
        else
            $output .= "</li><!-- #comment-## -->\n";
    }

    protected function ping( $comment, $depth, $args ) {
        $tag = ( 'div' == $args['style'] ) ? 'div' : 'li';
?>
        <<?php echo $tag; ?> id="comment-<?php comment_ID(); ?>" <?php comment_class( '', $comment ); ?>>
            <div class="comment-body">
                <?php _e( 'Pingback:' ); ?> <?php comment_author_link( $comment ); ?> <?php edit_comment_link( __( 'Edit' ), '<span class="edit-link">', '</span>' ); ?>
            </div>
<?php
    }


    protected function comment( $comment, $depth, $args ) {
        if ( 'div' == $args['style'] ) {
            $tag = 'div';
            $add_below = 'comment';
        } else {
            $tag = 'li';
            $add_below = 'div-comment';
        }
?>
        <<?php echo $tag; ?> <?php comment_class( $this->has_children ? 'parent' : '', $comment ); ?> id="comment-<?php comment_ID(); ?>">
        <?php if ( 'div' != $args['style'] ) : ?>
        <div id="div-comment-<?php comment_ID(); ?>" class="comment-body">
        <?php endif; ?>
        <div class="comment-author vcard">
            <?php if ( 0 != $args['avatar_size'] ) echo get_avatar( $comment, $args['avatar_size'] ); ?>
            <?php printf( __( '<cite class="fn">%s</cite> <span class="says">says:</span>' ), get_comment_author_link( $comment ) ); ?>
            
            <span class="comment-meta commentmetadata"><a href="<?php echo esc_url( get_comment_link( $comment, $args ) ); ?>">
                <?php
                    /* translators: 1: comment date, 2: comment time */
                    printf( __( '%1$s at %2$s' ), get_comment_date( '', $comment ),  get_comment_time() ); ?></a><?php edit_comment_link( __( '(Edit)' ), '&nbsp;&nbsp;', '' );
                ?>
            </span>
        
        </div>
        <?php if ( '0' == $comment->comment_approved ) : ?>
        <em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.' ) ?></em>
        <br />
        <?php endif; ?>



        <?php comment_text( get_comment_id(), array_merge( $args, array( 'add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>

        <?php
        comment_reply_link( array_merge( $args, array(
            'add_below' => $add_below,
            'depth'     => $depth,
            'max_depth' => $args['max_depth'],
            'before'    => '<div class="reply">',
            'after'     => '</div>'
        ) ) );
        ?>

        <?php if ( 'div' != $args['style'] ) : ?>
        </div>
        <?php endif; ?>
<?php
    }


    protected function html5_comment( $comment, $depth, $args ) {
        $tag = ( 'div' === $args['style'] ) ? 'div' : 'li';
?>
        <?php if($depth==1) : ?>
        <<?php echo $tag; ?> id="comment-<?php comment_ID(); ?>" <?php comment_class( $this->has_children ? 'parent list' : 'list', $comment ); ?>>
        <?php else : ?>
        <<?php echo $tag; ?> id="comment-<?php comment_ID(); ?>" <?php comment_class( $this->has_children ? 'parent' : '', $comment ); ?>>
        <?php endif; ?>

            <article id="div-comment-<?php comment_ID(); ?>" class="comment-body" style="padding-top:80px;margin-top:-80px;">
                
                <?php if($depth==1) : ?>
                <div class="t comment-meta">
                    <span class="comment-author vcard">
                        <?php if ( 0 != $args['avatar_size'] ) echo get_avatar( $comment, $args['avatar_size'] ); ?>
                        <?php printf( __( '%s' ), sprintf( '<b class="fn">%s</b>', get_comment_author_link( $comment ) ) ); ?>
                    </span><!-- .评论者 -->
                    
                    <span class="comment-metadata">
                        <time datetime="<?php comment_time( 'c' ); ?>">
                            <?php
                                /* translators: 1: comment date, 2: comment time */
                                printf( __( '%1$s at %2$s' ), get_comment_date( '', $comment ), get_comment_time() );
                            ?>
                        </time>

                        <?php //edit_comment_link( __( 'Edit' ), '<span class="edit-link">', '</span>' ); ?>
                    </span><!-- .comment-metadata -->

                </div><!-- .comment-meta -->
                
                <div class="con comment-content">
                    <?php comment_text(); ?>
                    <?php
                    comment_reply_link( array_merge( $args, array(
                        'add_below' => 'comment-content',
                        'depth'     => $depth,
                        'max_depth' => $args['max_depth'],
                        'before'    => '<span class="fr">',
                        'after'     => '</span>'
                    ) ) );
                    ?>
                    <span class="like icon">20</span>
                </div><!-- .comment-content -->
                <?php if ( '0' == $comment->comment_approved ) : ?>
                <p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.' ); ?></p>
                <?php endif; ?>
                
                <?php else : ?>
                
                <div>
                    <div class="t2">
                    <span>
                        <?php if ( 0 != $args['avatar_size'] ) echo get_avatar( $comment, $args['avatar_size'] ); ?>
                        <?php printf( __( '%s' ), sprintf( '<b class="fn">%s</b>', get_comment_author_link( $comment ) ) ); ?>
                    </span><!-- .comment-author -->	
                    <span>
                        <time datetime="<?php comment_time( 'c' ); ?>">
                            <?php
                                /* translators: 1: comment date, 2: comment time */
                                printf( __( '%1$s at %2$s' ), get_comment_date( '', $comment ), get_comment_time() );
                            ?>
                        </time>
                    </span>
                    </div>

                    <div class="con2">
                        <?php comment_text(); ?>
                        <?php
                        comment_reply_link( array_merge( $args, array(
                            'add_below' => 'comment-content',
                            'depth'     => $depth,
                            'max_depth' => $args['max_depth'],
                            'before'    => '<span class="fr">',
                            'after'     => '</span>'
                        ) ) );
                        ?>
                    </div><!-- .comment-content -->
                    
                </div><!-- .comment-meta -->
                
                <?php endif; ?>

            
            </article><!-- .comment-body -->
<?php
    }
}