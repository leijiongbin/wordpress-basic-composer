<?php
/**
 * 优化项
 * @必须引入
 */
require( dirname(__FILE__).'/inc/wp-improve-speed.php' );


/**
 * 优化项2
 * @线上环境必须引入
 */
require( dirname(__FILE__).'/inc/wp-improve-speed2.php' );



/**
 * 自定义字段：META-BOX
 */
require(dirname(__FILE__).'/inc/meta_box.php');



/**
 * 主题选项 = 网站设置
 */
include(dirname(__FILE__).'/inc/theme-options.php');



/**
 * 注册菜单
 */
register_nav_menus(array('top-menu'   => '顶部菜单'));
register_nav_menus(array('mobile-menu'   => '手机菜单'));


/**
 * 其它自定义函数
 */
include(dirname(__FILE__).'/inc/functions.php');


/**
 * 扩展菜单功能
 */
include(dirname(__FILE__).'/inc/walker_nav_menu.php');



/**
 * 支持特色图象
 */
add_theme_support('post-thumbnails');

/**
 * 特色图象提示文字
 */
add_filter('admin_post_thumbnail_html', 'wpjam_admin_post_thumbnail_html',10,2);
function wpjam_admin_post_thumbnail_html($content, $post_id){
	$post = get_post($post_id);
	$post_type = $post->post_type;
	if($post_type == 'product'){
            return $content.'<p>图片大小：192x192</p>';
	}elseif($post_type == 'post'){
            return $content.'<p>图片大小：160x100</p>';            
        }
	return $content;
}

/**
 * 设定自定裁减图象的大小
 */
#add_action('after_setup_theme', 'baw_theme_setup');
function baw_theme_setup() {
    add_image_size('thumbnail-300x185', 300, 185, true); // (cropped)
}


/**
 * 增强默认编辑器
 */
include(dirname(__FILE__).'/inc/wp-editor-extend.php');



/**
 * 评论表单扩展
 */
include(dirname(__FILE__).'/inc/wp-comments-extend.php');



/**
 * 分页插件pagenavi的自定义扩展
 */
include(dirname(__FILE__).'/inc/custom-pagenavi.php');



/**
 * 优化自定义post_type的固定链接
 */
include(dirname(__FILE__)."/inc/custom-post-type-permalinks/custom-post-type-permalinks.php"); 

