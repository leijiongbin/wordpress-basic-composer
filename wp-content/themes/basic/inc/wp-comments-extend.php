<?php

/**
 * 移除评论表单中的 字段选项
 */
add_filter('comment_form_default_fields', 'unset_url_field');
function unset_url_field($fields){
    if(isset($fields['url'])){
        unset($fields['url']);
    }
    return $fields;
}



/**
 * 后台显示评论自定义字段
 */
add_filter( 'manage_edit-comments_columns', 'my_comments_columns' );
function my_comments_columns( $columns ){
    unset( $columns[ 'comment' ] );
    $columns[ 'author' ]    = '姓名';
    $columns[ 'phone' ]     = '电话';
    $columns[ 'qq' ]   = 'QQ'; 
    //$columns[ 'comment' ]   = '留言';
    return $columns;
}
add_action( 'manage_comments_custom_column', 'output_my_comments_columns', 10, 2 );
function  output_my_comments_columns( $column_name, $comment_id ){
    echo get_comment_meta( $comment_id, $column_name, true );
}


/**
 * 留言板添加自定义字段
 */
add_action( 'wp_insert_comment', 'wp_insert_guestbook', 99, 2 );
function wp_insert_guestbook( $comment_ID, $commmentdata ) {
    /*$columns = my_comments_columns('');
    foreach ($columns as $key => $value) {
        $data = isset( $_POST[$key] ) ? $_POST[$key] : false;
        update_comment_meta( $comment_ID, $key, $data );
    }*/
    $phone = isset($_POST['phone']) ? $_POST['phone'] : false;
    update_comment_meta( $comment_ID, 'phone', $phone );

    $qq = isset($_POST['qq']) ? $_POST['qq'] : false;
    update_comment_meta( $comment_ID, 'qq', $qq );
}

/**
 * 增加必填字段
 */
function my_comments_required() {
    $author  = ( isset($_POST['author']) )    ? trim($_POST['author']) : null;
    $email   = ( isset($_POST['email']) )     ? trim($_POST['email']) : null;
    $phone   = ( isset($_POST['phone']) )     ? trim($_POST['phone']) : null;
    $qq   = ( isset($_POST['qq']) )     ? trim($_POST['qq']) : null;
    //$company   = ( isset($_POST['company']) )     ? trim($_POST['company']) : null;
    $comment   = ( isset($_POST['comment']) )     ? trim($_POST['comment']) : null;
    if (!$phone) {
        wp_die( __('错误提示：请输入手机号码等必填信息。') );
    }
}
add_filter('pre_comment_on_post', 'my_comments_required');


/**
 * 允许评论内容重复
 */
function enable_duplicate_comments_preprocess_comment($comment_data)
{
    //add some random content to comment to keep dupe checker from finding it
    $random = md5(time());
    $comment_data['comment_content'] .= "disabledupes{" . $random . "}disabledupes";
    return $comment_data;
}
add_filter('preprocess_comment', 'enable_duplicate_comments_preprocess_comment');
function enable_duplicate_comments_comment_post($comment_id)
{
    global $wpdb;
    //remove the random content
    $comment_content = $wpdb->get_var("SELECT comment_content FROM $wpdb->comments WHERE comment_ID = '$comment_id' LIMIT 1");
    $comment_content = preg_replace("/disabledupes\{.*\}disabledupes/", "", $comment_content);
    $wpdb->query(
        "UPDATE $wpdb->comments SET comment_content = '" . $wpdb->escape($comment_content) . "' WHERE comment_ID = '$comment_id' LIMIT 1"
    );
}
add_action('comment_post', 'enable_duplicate_comments_comment_post');


