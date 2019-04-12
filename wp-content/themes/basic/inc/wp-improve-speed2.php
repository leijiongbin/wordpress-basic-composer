<?php
/**
 * 移除默认的分类目录
 */
/*add_action('init', 'unregister_taxonomy');
function unregister_taxonomy(){
    global $wp_taxonomies;
    $taxonomy = 'category';
    if (taxonomy_exists($taxonomy))
        unset($wp_taxonomies[$taxonomy]);
}
*/

/**
 * 非管理员移除Admin Bar
 */
if ( ! current_user_can( 'manage_options' ) && ! is_admin() ) {
    add_filter( 'show_admin_bar', '__return_false' );
}


/**
 * 定制Admin Bar
 */
add_action('wp_before_admin_bar_render', 'naruco_admin_bar_menu');
function naruco_admin_bar_menu(){
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu('wp-logo');
    $wp_admin_bar->remove_menu('about');
    $wp_admin_bar->remove_menu('wporg');
    $wp_admin_bar->remove_menu('documentation');
    $wp_admin_bar->remove_menu('support-forums');
    //$wp_admin_bar->remove_menu('network-admin');
    //$wp_admin_bar->remove_menu('edit-site');
    $wp_admin_bar->remove_menu('blog-1');
    $wp_admin_bar->remove_menu('network-admin-p');
    $wp_admin_bar->remove_menu('customize');
    $wp_admin_bar->remove_menu('feedback');
    #$wp_admin_bar->remove_menu('view-site');

    #$wp_admin_bar->remove_menu('new-content'); //新建
    $wp_admin_bar->remove_menu('comments');  //评论
    $wp_admin_bar->remove_menu('appearance'); //皮肤
    $wp_admin_bar->remove_menu('updates'); //插件更新信息

    if(current_user_can('manage_options')){
        $wp_admin_bar->add_menu(array(
            'id'    => 'optionsframework',
            'title' => '#主题选项',
            //'meta'  => array('target' => '_blank'),
            'href'  => admin_url('themes.php?page=options-framework') //添加制作方的链接
        ));
    }
}



/**
 * Admin Bar添加清除缓存按纽
 */
if ( function_exists('wp_super_cache_text_domain') ) {
    function clear_all_cached_files_wpsupercache() {
        global $wp_admin_bar;
        if ( ! is_super_admin() || ! is_admin_bar_showing() )
            return;
        $wp_admin_bar->add_menu(array(
                    'parent' => '',
                    'id'     => 'delete-cache-completly',
                    'title'  => '更新缓存',
                    'meta'   => array( 'title' => '更新缓存' ),
                    'href'   => wp_nonce_url(
                                admin_url(
                                    'options-general.php?page=wpsupercache&wp_delete_cache=1&wp_delete_all_cache=1&tab=contents'
                                ),
                                'wp-cache')
                    ));
    }
    add_action( 'wp_before_admin_bar_render', 'clear_all_cached_files_wpsupercache', 999 );
} 



/**
 * 移除/修改标题前的“私密”和“密码保护”
 * http://www.wpdaxue.com/remove-change-private-protected-title-format.html
 */
add_filter( 'private_title_format', 'wpdaxue_private_title_format' );
add_filter( 'protected_title_format', 'wpdaxue_private_title_format' );
function wpdaxue_private_title_format( $format ) {
	return '%s';
}


/**
 * 移除后台左侧菜单栏
 */
function remove_menus(){
 //remove_menu_page( 'index.php' );                  //Dashboard
  remove_submenu_page( 'index.php', 'update-core.php' );  //Dashboard
  // remove_menu_page( 'edit.php' );                   //Posts
  //remove_menu_page( 'upload.php' );                 //Media
  
  //2018-02-07保护后台移除start
  // remove_menu_page( 'edit.php?post_type=page' );    //移除页面
  remove_menu_page( 'edit.php?post_type=activity' );    //移除活动
  // remove_menu_page( 'edit.php?post_type=feedback' );    //移除反馈
  // remove_menu_page( 'nav-menu.php' );    //移除菜单
  // remove_menu_page( 'users.php' );    //移除用户
  // remove_menu_page( 'options-general.php' );    //移除设置
  //2018-02-07保护后台移除end

  remove_menu_page( 'edit-comments.php' );          //Comments,移除“留言”
  remove_menu_page( 'themes.php' );                 //Appearance移除外观

  remove_submenu_page( 'themes.php', 'theme-editor.php' );

  //文章
  // remove_submenu_page( 'edit.php', 'edit-tags.php?taxonomy=category' );//移除文章分类
  remove_submenu_page( 'edit.php', 'edit-tags.php?taxonomy=post_tag' );//移除文章标签

  //删除自定义文章类型的‘写文章’
  // remove_submenu_page( 'edit.php?post_type=wemedia', 'post-new.php?post_type=wemedia' );

  //设置
  remove_submenu_page( 'options-general.php', 'options-writing.php'); //移除撰写
  remove_submenu_page( 'options-general.php', 'options-reading.php'); //移除阅读
  remove_submenu_page( 'options-general.php', 'options-discussion.php'); //移除讨论
  remove_submenu_page( 'options-general.php', 'options-media.php'); //移除媒体

  //remove_submenu_page('themes.php', 'customize.php');    //customize
  global $submenu;
  unset($submenu['themes.php'][6]); // Customize

  remove_menu_page('plugins.php');                //Plugins,移除“插件”
  //remove_menu_page('users.php');                  //Users
  remove_menu_page('tools.php');                  //Tools
  remove_submenu_page('tools.php', 'import.php');                  //Tools
  remove_submenu_page('tools.php', 'export.php');                  //Tools
  remove_submenu_page('tools.php', 'wpsupercache');                  //Tools
  //remove_menu_page( 'options-general.php' );        //Settings
  //remove_submenu_page( 'options-general.php', 'options-discussion.php'); 
  // remove_submenu_page( 'options-general.php', 'wp-postviews/postviews-options.php');  //插件
  remove_submenu_page( 'options-general.php', 'pagenavi');  //插件
  remove_submenu_page( 'options-general.php', 'radio-buttons-for-taxonomies');  //插件
  remove_submenu_page( 'options-general.php', 'wp-favorite-posts');  //插件
  remove_submenu_page( 'options-general.php', 'tinymce-advanced');  //插件
  
}
add_action('admin_menu', 'remove_menus', '99999');



/**
 * 移除多站点的菜单栏
 */
function remove_network_menus(){
    remove_menu_page('plugins.php');
    remove_submenu_page('index.php', 'upgrade.php');
}
add_action('network_admin_menu', 'remove_network_menus', '99999');



/**
 * 后台管理菜单名称重命名
 */
function change_post_menu_label() {
    global $menu;
    global $submenu;
    //print_r($menu);
    if (isset($menu[25][0])){
        $menu[25][0] = '留言';
    }
}
add_action('admin_menu', 'change_post_menu_label');



/**
 * 去掉仪表盘“概况”下的WordPress版本信息
 */
add_filter('gettext', 'remove_admin_stuff', 20, 3);
function remove_admin_stuff($translated_text, $untranslated_text, $domain) {
    $custom_field_text = 'WordPress %1$s running %2$s theme.';
    if (is_admin() && $untranslated_text === $custom_field_text) {
        return '';
    }
    return $translated_text;
}


/**
 * 自定义修改后台的翻译文字
 */
function custom_gettext( $translated_text, $untranslated_text, $domain ) {       
    if( FALSE !== stripos( $translated_text, 'WordPress' ) ) {
        $translated_text = str_ireplace( 'WordPress', '网站', $translated_text );
    }
    return $translated_text;
}
add_filter( 'gettext', 'custom_gettext', 99, 3 );



/**
 * 多作者，后台只显示作者自己的文章
 */
function mypo_parse_query_useronly( $wp_query ) {
    if ( strpos( $_SERVER[ 'REQUEST_URI' ], '/wp-admin/edit.php' ) !== false ) {
        if ( !current_user_can( 'manage_categories' ) ) {
            global $current_user;
            $wp_query->set( 'author', $current_user->id );
        }
    }
}
#add_filter('parse_query', 'mypo_parse_query_useronly' );



/**
 * 后台添加样式
 */
function dw_admin_font(){
    $style = '
<style>
#preview-action,
.hide-if-no-customize,
.edit-term-notes,
#postexcerpt .inside p,
#home-description,
.date-time-doc
{display:none;} 
</style>
';
    echo $style;
}
add_action('admin_head', 'dw_admin_font');



/**
 * 后台移除标签功能
 */
#add_action( 'init', 'my_register_post_tags' );
function my_register_post_tags() {
    register_taxonomy( 'post_tag', array( 'my_post_type_here' ) );
}

/**
 * 移除编辑文章时的部分模块
 * 分类：categorydiv
 * 标签：tagsdiv-post_tag
 * 摘要：postexcerpt
 * 发送trackbacks：trackbacksdiv
 * 自定义域：postcustom
 * 讨论：commentstatusdiv
 * 作者：authordiv
 * 评论：commentsdiv
 * 文章别名：slugdiv
 * 文章修订版：revisionsdiv
 * https://codex.wordpress.org/Function_Reference/remove_meta_box
 */
add_action( 'admin_menu', 'my_remove_meta_boxes' );
function my_remove_meta_boxes() {
    #remove_meta_box('categorydiv','post','normal');  
    #remove_meta_box('tagsdiv-post_tag','post','normal');

    remove_meta_box('commentsdiv','post','normal');
}



/**
 * 添加侧栏顶级菜单-----菜单
 */
add_action('admin_menu', 'register_custom_menu_page');
function register_custom_menu_page() {
    add_menu_page('菜单', '菜单', 'administrator', 'nav-menus.php','','dashicons-exerpt-view', 20);
}

/**
 * 添加侧栏顶级菜单-----主题选项 
 */
add_action('admin_menu', 'register_custom_options_page');
function register_custom_options_page() {
    add_menu_page('主题选项', '主题选项', 'administrator', 'themes.php?page=options-framework','','dashicons-hammer', 80);
}

