<?php

/**
 * 屏蔽后台“显示选项”和“帮助”选项卡
 */
add_filter('screen_options_show_screen', 'remove_screen_options');
function remove_screen_options(){
    return false;
}
add_filter( 'contextual_help', 'wpse50723_remove_help', 999, 3 );
function wpse50723_remove_help($old_help, $screen_id, $screen){
    $screen->remove_help_tabs();
    return $old_help;
}


/**
 *  禁用Google Open Sans字体，加速网站
 */
if (!function_exists('my_remove_open_sans_from_wp_core')) {
    function my_remove_open_sans_from_wp_core() {
        wp_deregister_style('open-sans');
        wp_register_style('open-sans', false);
        wp_enqueue_style('open-sans','');
    }
}
add_action('init', 'my_remove_open_sans_from_wp_core');

/** 
 * 关闭 heartbeat
 */ 
add_action( 'init', 'stop_heartbeat', 1 );
function stop_heartbeat() {
	wp_deregister_script('heartbeat');
}

/**
 * 禁用自动换行
 */
remove_filter('the_excerpt', 'wpautop');
//remove_filter('the_content', 'wpautop'); 
//remove_filter('comment_text','wpautop'); 


/**
 * 修改后台显示更新的代码
 */
add_filter('pre_site_transient_update_core',    create_function('$a', "return null;")); // 关闭核心提示
add_filter('pre_site_transient_update_plugins', create_function('$a', "return null;")); // 关闭插件提示
add_filter('pre_site_transient_update_themes',  create_function('$a', "return null;")); // 关闭主题提示
remove_action('admin_init', '_maybe_update_core');    // 禁止检查更新
remove_action('admin_init', '_maybe_update_plugins'); // 禁止更新插件
remove_action('admin_init', '_maybe_update_themes');  // 禁止更新主题
add_filter('xmlrpc_enabled', '__return_false'); //禁用 XML-RPC 接口
remove_filter('the_content', array($GLOBALS['wp_embed'], 'autoembed'), 8); //禁用 Auto Embeds (oEmbed)


/**
 * 移除自动修正大小写函数
 */
remove_filter('the_title', 'capital_P_dangit', 11);
remove_filter('the_content', 'capital_P_dangit', 11);
remove_filter('comment_text', 'capital_P_dangit', 31);

/**
 * 屏蔽 REST API
 */
add_filter('rest_enabled', '__return_false');
add_filter('rest_jsonp_enabled', '__return_false');

/**
 * 移除头部 wp-json 标签和 HTTP header 中的 link
 */
remove_action('wp_head', 'rest_output_link_wp_head', 10);
remove_action('template_redirect', 'rest_output_link_header', 11);


/**
 * 前台不加载语言包来提高效率
 */
function wpjam_locale($locale) {
    $locale = (is_admin()) ? $locale : 'en_US';
    return $locale;
}
#add_filter('locale', 'wpjam_locale');


/**
 * 自定义后台底部信息
 */
add_filter('admin_footer_text', 'left_admin_footer_text');
function left_admin_footer_text($text) {
    // 修改左侧信息
    $text = '';
    return $text;
}
#add_filter('update_footer', 'right_admin_footer_text', 11);
function right_admin_footer_text($text) {
    // 修改右侧信息
    $text = "";
    return $text;
}


/**
 * 移除emoji表情
 */
remove_action('admin_print_scripts', 'print_emoji_detection_script');
remove_action('admin_print_styles', 'print_emoji_styles');
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');
remove_filter('the_content_feed', 'wp_staticize_emoji');
remove_filter('comment_text_rss', 'wp_staticize_emoji');
remove_filter('wp_mail', 'wp_staticize_emoji_for_email');


/**
 * 移除仪表盘欢迎面板
 */
remove_action('welcome_panel', 'wp_welcome_panel');



/**
 * 友汇Gravatar头像调用
 */
function mytheme_get_avatar($avatar) {
    $avatar = str_replace(
        array("www.gravatar.com","0.gravatar.com","1.gravatar.com","2.gravatar.com"),
        "avatar.17uhui.com.cn",
        $avatar
    );
    return $avatar;
}
add_filter('get_avatar', 'mytheme_get_avatar', 10, 3);



/**
 * 取消自动保存
 */
add_action('admin_init', 'disable_autosave');
function disable_autosave() {
    wp_deregister_script('autosave');
}



/**
 * 禁止加载WP自带的jquery.js
 */
function my_init_method() {
    if (!is_admin()) { // 后台不禁止
        wp_deregister_script('jquery'); // 取消原有的 jquery 定义
        wp_register_script('jquery','',''); //必须要重新注册一个jquery
        wp_enqueue_script('jquery');
    }
}
add_action('wp_enqueue_scripts', 'my_init_method'); 


/**
 * 屏蔽后台仪表盘无用模块
 */
function example_remove_dashboard_widgets() {
    // Globalize the metaboxes array, this holds all the widgets for wp-admin
    global $wp_meta_boxes;
    // 以下这一行代码将删除 "快速发布" 模块
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
    // 以下这一行代码将删除 "引入链接" 模块
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
    // 以下这一行代码将删除 "插件" 模块
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
    // 以下这一行代码将删除 "近期评论" 模块
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
    // 以下这一行代码将删除 "近期草稿" 模块
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts']);
    // 以下这一行代码将删除 "WordPress 开发日志" 模块
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
    // 以下这一行代码将删除 "其它 WordPress 新闻" 模块
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
    // 以下这一行代码将删除 "概况" 模块
    #unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
}
add_action('wp_dashboard_setup', 'example_remove_dashboard_widgets' );


/**
 * 阻止站内文章互相Pingback
 */
function Bing_noself_ping($links) {
    $home = get_option('home');
    foreach ($links as $l => $link)
        if (0 === strpos($link, $home))
            unset($links[$l]);
}
add_action('pre_ping','Bing_noself_ping');


/**
 * 媒体库显示文件的链接地址
 */
add_filter('manage_media_columns', 'wpdaxue_media_column');
function wpdaxue_media_column($columns) {
    $columns["media_url"] = "URL";
    return $columns;
}
add_action('manage_media_custom_column', 'wpdaxue_media_value', 10, 2);
function wpdaxue_media_value($column_name, $id) {
    if ($column_name == "media_url")
        echo '<input type="text" width="100%" onclick="jQuery(this).select();" value="'. wp_get_attachment_url($id). '" readonly="readonly" />';
}

/**
 * 后台媒体库显示文件的链接地址
 */
add_filter('media_row_actions', 'wpdaxue_media_row_actions', 10, 2);
function wpdaxue_media_row_actions( $actions, $object ) {
    $actions['url'] = '<a href="'.wp_get_attachment_url($object->ID).'" target="_blank">URL</a>';
    return $actions;
}


/**
 * WordPress 去除后台标题中的“—— WordPress”
 * 参考 https://core.trac.wordpress.org/browser/tags/4.2.2/src/wp-admin/admin-header.php#L44
 */
add_filter('admin_title', 'wpdx_custom_admin_title', 10, 2);
function wpdx_custom_admin_title($admin_title, $title){
    return $title.' &lsaquo; '.get_bloginfo('name');
}


/**
 * 精简WordPress中的wp_head
 */
remove_action('wp_head', 'wp_generator'); //删除generator meta标签
remove_action('wp_head', 'wlwmanifest_link' );
remove_action('wp_head', 'rsd_link' );//清除离线编辑器接口
//remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );//清除前后文信息
remove_action('wp_head', 'feed_links',2 );
remove_action('wp_head', 'feed_links_extra',3 );//清除feed信息
remove_action('wp_head', 'wp_shortlink_wp_head',10,0 );


/**
 * 自定义登陆页
 * 自定义登录页面的LOGO图片
 */
function my_custom_login_logo() {
    echo '<style type="text/css">
        h1 a { background-image:url() !important; }
    </style>';
}
add_action('login_head', 'my_custom_login_logo');

/**
 * 自定义登录页面的LOGO链接为首页链接
 */
add_filter('login_headerurl', create_function(false,"return get_bloginfo('url');"));

/**
 * 自定义登录页面的LOGO提示为网站名称
 */
add_filter('login_headertitle', create_function(false,"return get_bloginfo('name');"));


