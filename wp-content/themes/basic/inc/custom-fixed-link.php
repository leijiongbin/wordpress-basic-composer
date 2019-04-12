<?php


$mytypes = array(
    'case' => 'case',
    'post' => 'post',
    'report' => 'report',
    'recruit' => 'recruit',
);


add_filter('post_type_link', 'custom_link', 1, 3);
function custom_link( $link, $post = 0 ){
    global $mytypes;
    if ( in_array( $post->post_type,array_keys($mytypes) ) ){
        return home_url( $mytypes[$post->post_type].'/' . $post->ID .'.html' );
    } else {
        return $link;
    }
}

add_action( 'init', 'custom_rewrites_init' );
function custom_rewrites_init(){
    global $mytypes;
    foreach( $mytypes as $k => $v ) {
        add_rewrite_rule(
            $v.'/([0-9]+)?.html$',
            'index.php?post_type='.$k.'&p=$matches[1]',
            'top' );
    }
}