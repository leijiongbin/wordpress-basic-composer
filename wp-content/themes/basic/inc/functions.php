<?php
/**
 * page页面重定向链接
 */
function my_permalink_redirect_page($permalink, $post_id) {
    //global $post;
    if ($meta_permalink = get_post_meta($post_id, 'meta_permalink', TRUE)) {
        $permalink = $meta_permalink;
    }
    return $permalink;
}
add_filter('page_link', 'my_permalink_redirect_page', 99, 2);

/**
 * post重定向链接
 */
function my_permalink_redirect_post($permalink, $post) {
    //global $post;
    if ($meta_permalink = get_post_meta($post->ID, 'meta_permalink', TRUE)) {
        $permalink = $meta_permalink;
    }
    return $permalink;
}
add_filter('post_link', 'my_permalink_redirect_post', 99, 2);




/*
 * 重新定义分类目录的固定链接
 */
#add_action('init', 'wp_rebuild_taxonomies', 0);
function wp_rebuild_taxonomies() {
  register_taxonomy( 'category', 'post', array(
        'hierarchical'          => true,//true为分类，false为标签
        'update_count_callback' => '_update_post_term_count',
        'query_var'             => 'category_name',
        'rewrite'               => did_action( 'init' ) ? array(
                                    'hierarchical' => false,
                                    'slug' => get_option('category_base') ? get_option('category_base') : 'category',
                                    'with_front' => false
                                    ) : false,
        'public'                => true,
        'show_ui'               => true,
        '_builtin'              => true,
        'show_in_menu'          => true,
        'show_in_nav_menus'     => true,
        //'taxonomies'          => array('category'),
        'show_admin_column'     => true, //显示分类项目
    ));
}




/**
 * 设定摘要显示的字符长度
 */
function new_excerpt_length($length) {
    return 380;
}
add_filter('excerpt_length', 'new_excerpt_length');

/**
 * 摘要截断时添加省略号显示
 */
function new_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'new_excerpt_more');


/**
 * 进一步限制摘要的长度，特别是中文时
 */
function chinese_excerpt($text, $lenth=120) {
    //var_dump( $text );
    $text = str_replace(PHP_EOL, '', $text); 
    $text = str_replace('&nbsp;', '', $text);
    $text = mb_strimwidth($text, 0, $lenth, '...');
    return $text;
}
add_filter('the_excerpt', 'chinese_excerpt');


/**
 * page页面添加摘要
 */
add_action( 'admin_menu', 'my_page_excerpt_meta_box' );
function my_page_excerpt_meta_box() {
    add_meta_box( 'postexcerpt', __('Excerpt'), 'post_excerpt_meta_box', 'page', 'normal', 'core' );
}


/**
 * 显示后台的远程请求
 */
function wpjam_admin_display_http_request($status, $r, $url){
    if( is_admin() ){
        echo 'http_request：'.$url."\n<br />";
        return $status;
    }
}
#add_filter('pre_http_request', 'wpjam_admin_display_http_request', 10, 3);


/**
 * 上传中文附件出现乱码
 */
function my_upload_file($filename) {  
    $parts     = explode('.', $filename);
    $filename  = array_shift($parts);
    $extension = array_pop($parts);  
    foreach ((array)$parts as $part)
        $filename .= '.' . $part;
        
    if (preg_match('/[一-龥]/u', $filename)) {
        $filename = md5($filename);  
    }  
    $filename .= '.' . $extension;  
    return $filename ;  
}  
add_filter('sanitize_file_name', 'my_upload_file', 5,1); 



/**
 * WordPress 发布文章前必须选择分类
 * http://www.wpdaxue.com/choose-a-category-before-publish.html
 */
#add_action('admin_footer-post.php', 'choose_a_category_before_publish');
#add_action('admin_footer-post-new.php', 'choose_a_category_before_publish');
function choose_a_category_before_publish(){
    global $post_type;
    if($post_type=='post'){
        echo "<script>
    jQuery(function($){
    $('#publish, #save-post').click(function(e){
        if($('#taxonomy-category input:checked').length==0){
            alert('抱歉，发布前，请选择一个分类目录');
            e.stopImmediatePropagation();
            return false;
        }else{
            return true;
        }
    });
    var publish_click_events = $('#publish').data('events').click;
    if(publish_click_events){
        if(publish_click_events.length>1){
            publish_click_events.unshift(publish_click_events.pop());
        }
    }
    if($('#save-post').data('events') != null){
        var save_click_events = $('#save-post').data('events').click;
        if(save_click_events){
          if(save_click_events.length>1){
              save_click_events.unshift(save_click_events.pop());
          }
        }
    }
});
</script>";
    }
}



/**
 * 通过子分类id获取父根分类id
 */
if (!function_exists('get_category_root_id')) {
    function get_category_root_id($cat) {
        $this_category = get_category($cat); // 取得当前分类
    
        // 若当前分类有上级分类时，循环
        while ($this_category->category_parent) {
            $this_category = get_category($this_category->category_parent); // 将当前分类设为上级分类（往上爬）
        }
        return $this_category->term_id; // 返回根分类的id号
    }
}

/**
 * 通过子分类id获取父根分类id，自定义分类
 */
if (!function_exists('get_custom_category_root_id')) {
function get_custom_category_root_id($cat, $taxonomy){
    $this_category = get_term($cat, $taxonomy); // 取得当前分类

    // 若当前分类有上级分类时，循环
    while ($this_category->parent) {
        $this_category = get_term($this_category->parent, $taxonomy); // 将当前分类设为上级分类（往上爬）
    }
    return $this_category->term_id; // 返回根分类的id号
}
}

/**
 * 通过子分类id获取父分类id
 */
if (!function_exists('get_category_parent_id')) {
function get_category_parent_id($cat){
    $this_category = get_category($cat); // 取得当前分类

    // 若当前分类有上级分类时，循环
    while ($this_category->category_parent) {
        $this_category = get_category($this_category->category_parent); // 将当前分类设为上级分类（往上爬）
        break; //跳出。只取父ID
    }
    return $this_category->term_id; // 返回根分类的id号
}
}

/**
 * 取得顶级父page id , 父类page id: wp_get_post_parent_id
 */
function get_root_page_id($post_id="") {
    if (!$post_id) {
        global $post;
        $post_id = $post->ID; //首次取当前post_id
    }
    $parent_id = get_post($post_id)->post_parent;
    if ($parent_id == 0) {
        return $post_id;
    } else {
        return get_root_page_id($parent_id);
    }
}


/**
 * page页面的面包屑导航
 */
function get_you_are_here_for_page($here="", $post_id=""){
    if (!$post_id) {
        global $post;
        $post_id = $post->ID; //首次取当前post_id
    }
    if (!$here) {
        $here = '<a href="'.get_permalink($post_id).'">'.get_the_title($post_id).'</a>'; //首次取当前页面
    }
    $parent_id = get_post($post_id)->post_parent;
    if ($parent_id == 0) {
        return $here;
    } else {
        $here = '<a href="'.get_permalink($parent_id).'">'.get_the_title($parent_id).'</a>'." &gt " . $here;
        return get_you_are_here_for_page($here, $parent_id);
    }
}


/**
 * category的面包屑导航
 */
function get_my_category_parents( $id, $link = false, $separator = '/', $nicename = false, $visited = array() ) {
    $chain = '';
    $parent = get_term( $id, 'category' );
    if ( is_wp_error( $parent ) )
        return $parent;

    if ( $nicename )
        $name = $parent->slug;
    else
        $name = $parent->name;

    if ( $parent->parent && ( $parent->parent != $parent->term_id ) && !in_array( $parent->parent, $visited ) ) {
        $visited[] = $parent->parent;
        $chain .= get_my_category_parents( $parent->parent, $link, $separator, $nicename, $visited );
    }

    if ( $link )
        $chain .= '<li><a href="' . esc_url( get_category_link( $parent->term_id ) ) . '">'.$name.'</a>' . $separator . '</li>';
    else
        $chain .= $name.$separator;
    return $chain;
}


/**
 * 重定义网站标题
 */
function reset_wp_title($title, $sep) {
    global $paged, $page;

    if (is_feed()) {
        return $title;
    }

    // Add the site name.
    $title .= get_bloginfo('name', 'display');

    // Add the site description for the home/front page.
    $site_description = get_bloginfo('description', 'display');

    if ( $site_description && (is_home() || is_front_page()) ) {
        $title = "$title $sep $site_description";
        #$title = "$site_description $sep $title";
    }

    // Add a page number if necessary.
    if ( $paged >= 2 || $page >= 2 ) {
        $title = "$title $sep " . sprintf( __( 'Page %s' ), max( $paged, $page ) );
    }

    return $title;
}
add_filter('wp_title', 'reset_wp_title', 10, 2);


/**
 * 当前page页面的slug
 */
function the_page_slug() {
    global $post;
    if (!is_page()) { return; }
    $post_data = get_post($post->ID, ARRAY_A);
    $slug = $post_data['post_name'];
    return ucwords($slug);
}

/**
 * 取指定page页面的slug
 */
function get_the_page_slug($page_id) {
    global $post;
    if (!is_page()) { return; }
    $post_data = get_post($post->ID, ARRAY_A);
    $slug = $post_data['post_name'];
    $slug = str_replace("-"," ",$slug);
    if (!preg_match("/^[a-z]/i", $slug)) {
        return;
    }
    $slug = ucwords($slug);
    $slug = str_replace(" A "," a ",$slug);
    return $slug;
}


/**
 * 文章上一页，下一页函数
 */
function my_previous_post_link($format='&laquo; %link', $link='%title', $in_same_cat = false, $excluded_categories = '', $string_lenght=22, $pre_link='') {

    if ( is_attachment() )
        $post = & get_post($GLOBALS['post']->post_parent);
    else
        $post = get_adjacent_post($in_same_cat, $excluded_categories, true);

    if ( !$post )
        return;		
        
    $title = apply_filters('the_title', $post->post_title, $post);	
    
    //create substring of the title to the last space and add dots
    $short = wp_trim_words($title, $string_lenght, '...');

    $string = '<a href="'.get_permalink($post->ID).'" title="'.$title.'">';
    $link = str_replace('%title', $short, $link);
    //$link = $pre . $string . $link . '</a>';
    $link = $string . $link . '</a>';
    $format = str_replace('%link', $link, $format);
    echo $pre_link.$format;
}

function  my_next_post_link($format='%link &raquo;', $link='%title', $in_same_cat = false, $excluded_categories = '', $string_lenght=22, $pre_link='') {
        
    if ( is_attachment() )
        $post = & get_post($GLOBALS['post']->post_parent);
    else
        $post = get_adjacent_post($in_same_cat, $excluded_categories, false);

    if ( !$post )
    return;
    
    $title = apply_filters('the_title', $post->post_title, $post);

    //create substring of the title to the last space and add dots
    $short = wp_trim_words($title, $string_lenght, '...');
    
    $string = '<a href="'.get_permalink($post->ID).'" title="'.$title.'">';
    $link = str_replace('%title', $short, $link);
    //$link = $pre . $string . $link . '</a>';
    $link = $string . $link . '</a>';
    $format = str_replace('%link', $link, $format);
    echo $pre_link.$format;
}


/**
 * 上一页下一页，增加class
 */
add_filter('previous_posts_link_attributes', 'pre_posts_link_attributes');
function pre_posts_link_attributes($output) {
    return 'class="pre"';
}
add_filter('next_posts_link_attributes', 'next_posts_link_attributes');
function next_posts_link_attributes($output) {
    return 'class="next"';
}

/**
 * 留言分页：上一页下一页，增加class
 */
#add_filter('previous_comments_link_attributes', 'pre_comments_link_attributes');
function pre_comments_link_attributes($output) {
    return 'class="page-1"';
}
#add_filter('next_comments_link_attributes', 'next_comments_link_attributes');
function next_comments_link_attributes($output) {
    return 'class="page-2"';
}




/**
 * 指定某目录下的所有子孙目录, in_category的升级版
 */
if ( ! function_exists( 'post_is_in_descendant_category' ) ) {
    function post_is_in_descendant_category( $cats, $_post = null ) {
        foreach ( (array) $cats as $cat ) {
            // get_term_children() accepts integer ID only
            $descendants = get_term_children( (int) $cat, 'category' );
            if ( $descendants && in_category( $descendants, $_post ) )
                return true;
        }
        return false;
    }
}

/**
 * 防SQL注入, 对数组的key也进行检查
 */
if ( ! function_exists( 'wpSafeSQL' ) ) {
    function wpSafeSQL($data){
        if(is_array($data)){
            foreach ( $data as $k => $v ) {

                $k = esc_sql($k);
                $data[$k] = esc_sql($v);
            }
            //esc_sql($data);
        }else{
            esc_sql($data);
        }
        return $data;
    }
}

/**
 * array 2 Json, 支持中文
 */
function wp_array2json($data){
    if(version_compare('5.3',PHP_VERSION,'<')){
        //5.3以上
        return json_encode($data,JSON_UNESCAPED_UNICODE);
    }else{
        return urldecode(json_encode(wp_url_encode($data)));
    }
}


/**
 * URL编码（可迭代数组）
 */
function wp_url_encode($str) {
    if(is_array($str)) {
        foreach($str as $key=>$value) {
            $str[urlencode($key)] = wp_url_encode($value);
        }
    } else {
        $str = urlencode($str);
    }
    return $str;
}




/**
 * 后台登陆数学验证码
 */
function myplugin_add_login_fields() {
    //最终网页中的具体内容
    echo "
        <p><label for='math' class='small'>验证码</label><br />
        <input type='text' name='math' class='input' value='' size='25'></p>
        ";
    echo "<p>";
    my_auth_form_handler();
    echo "</p><br/><br/>";
}
#add_action('login_form','myplugin_add_login_fields');


/**
 * 后台登陆数学验证码
 */
function mylogin_val($user, $username='', $password='') {
    session_start(); 
    $math=$_REQUEST['math'];
    if($math != $_SESSION['authNum']){
        $errors = new WP_Error;
        $errors->add( 'math_comfirm', '验证码不正确！');
        return $errors;
    } 
    return $user;
}
#add_action('wp_authenticate_user','mylogin_val');


/**
 * 搜索排除page页面.. 更改搜索的post_type
 */
// add_filter('pre_get_posts','wpjam_exclude_page_from_search');
function wpjam_exclude_page_from_search($query) {
    if (!is_admin() && $query->is_search) {
        $query->set( 'post_type', array( 'post', 'product','case' ) );
    }
    return $query;
}


/**
 * 只搜索文章的标题
 * http://www.wpdaxue.com/search-by-title-only.html
 */
function __search_by_title_only( $search, &$wp_query )
{
    global $wpdb;
 
    if ( empty( $search ) )
        return $search; // skip processing
 
    $q = $wp_query->query_vars;    
    $n = ! empty( $q['exact'] ) ? '' : '%';
 
    $search =
    $searchand = '';
 
    foreach ( (array) $q['search_terms'] as $term ) {
        $term = esc_sql( like_escape( $term ) );
        $search .= "{$searchand}($wpdb->posts.post_title LIKE '{$n}{$term}{$n}')";
        $searchand = ' AND ';
    }
 
    if ( ! empty( $search ) ) {
        $search = " AND ({$search}) ";
        if ( ! is_user_logged_in() )
            $search .= " AND ($wpdb->posts.post_password = '') ";
    }
 
    return $search;
}
#add_filter( 'posts_search', '__search_by_title_only', 500, 2 );




/**
 * 自定义模板文件
 */
#add_action( 'template_redirect', 'mytheme_template_redirect' );
function mytheme_template_redirect() {
    global $post;
    $template = 'archive-product.php';
    if ( $template && isset($post->post_type)  && is_tax() ) {
        $file = STYLESHEETPATH . '/' . $template;
        if( is_file( $file ) ) {
            require_once $file;
            exit;
        }
    }
}


/**
 * 自定义列表页的模板文件
 */
function my_template_chooser($template)
{
    global $post;
    if ( is_tax() && $post->post_type ) {
        return locate_template('archive-'. $post->post_type .'.php');
    }
    return $template;
}
#add_filter('template_include', 'my_template_chooser');



/**
 * @param $post_id
 * @return null|string
 */
function post_id2user_id($post_id){
    global $wpdb;
    $return = $wpdb->get_var(
        "SELECT post_author FROM $wpdb->posts WHERE ID = '$post_id' LIMIT 1"
    );
    return $return;
}


/**
 * 通过分类/tag id取分类/tag名称。
 */
function get_term_name($term_id){
    global $wpdb;
    $return = $wpdb->get_var(
        "SELECT name FROM $wpdb->terms WHERE term_id = '$term_id' LIMIT 1"
    );
    return $return;
}


/**
 * 自定义WP_Query搜索的字段
 */
add_filter('posts_where', 'wp_set_posts_where', 10, 2);
function wp_set_posts_where( $where, &$wp_query )
{
    global $wpdb;
    if ( $title_like = $wp_query->get( 'title_like' ) ) {
        $where .= ' AND ' . $wpdb->posts . '.post_title LIKE \'%' . esc_sql( $wpdb->esc_like( $title_like ) ) . '%\'';
    }
    return $where;
}


/**
 * 取post_id
 */
function get_ID_by_page_name($page_name){
    global $wpdb;
    $page_name_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE post_name ='".$page_name."'");
    return $page_name_id;
}



/**
* 详情页： 获取当前文章所属的分类id
* 如有多个分类时，只取第一个分类
*/
function get_the_term_id($post_id=''){
   global $wpdb;
   
   $term_id = '';
   $post_id = get_the_ID();

   $sql = "SELECT `term_taxonomy_id` FROM $wpdb->term_relationships WHERE `object_id` = '". $post_id ."';";

   $cat_ids = $wpdb->get_results($sql); 

   if (!empty($cat_ids)) {
       $term_id  = $cat_ids[0]->term_taxonomy_id;
       $term_id = intval($term_id); //这里就获得当前文章所属分类的分类ID
   }
   
   return $term_id;
}




/**
 * 显示网站的SEO关键词与描述
 */
function wp_seo()
{
    $return = '';

    if(get_post_meta(get_the_ID(), 'meta_seo_title', TRUE)){
        $return .= '<title>' . get_post_meta(get_the_ID(), 'meta_seo_title', TRUE). '</title>';
    }else{
        $return .= '<title>' . wp_title('-', false, right). '</title>';
    }

    if (is_single() || is_page()) { //详情页
        if (get_post_meta(get_the_ID(), 'meta_seo_keyword', TRUE)) {
            $return .= '<meta name="keywords" content="' . get_post_meta(get_the_ID(), 'meta_seo_keyword', TRUE) . '" />';
        }
        if (get_post_meta(get_the_ID(), 'meta_seo_desc', TRUE)) {
            $return .= '<meta name="description" content="' . get_post_meta(get_the_ID(), 'meta_seo_desc', TRUE) . '" />';
        }
    } elseif (is_home() || is_front_page()) { //首页
        if (of_get_option('_of_keyword')) {
            $return .= '<meta name="keywords" content="' . of_get_option('_of_keyword') . '" />';
        }
        if (of_get_option('_of_desc')) {
            $return .= '<meta name="description" content="' . of_get_option('_of_desc') . '" />';
        }
    } elseif (is_category()) { //分类
        $thisCat = get_category(get_query_var('cat'), false);//当前默认分类
        if (@get_term_meta($thisCat->term_id, 'meta_seo_keyword', TRUE)) {
            $return .= '<meta name="keywords" content="' . get_term_meta($thisCat->term_id, 'meta_seo_keyword', TRUE) . '" />';
        }
        if (@get_term_meta($thisCat->term_id, 'meta_seo_desc', TRUE)) {
            $return .= '<meta name="description" content="' . get_term_meta($thisCat->term_id, 'meta_seo_desc', TRUE) . '" />';
        }
    } elseif (is_tax()) { //分类
        $thisCat = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
        if (@get_term_meta($thisCat->term_id, 'meta_seo_keyword', TRUE)) {
            $return .= '<meta name="keywords" content="' . get_term_meta($thisCat->term_id, 'meta_seo_keyword', TRUE) . '" />';
        }
        if (@get_term_meta($thisCat->term_id, 'meta_seo_desc', TRUE)) {
            $return .= '<meta name="description" content="' . get_term_meta($thisCat->term_id, 'meta_seo_desc', TRUE) . '" />';
        }
    } 

    echo $return;
}


/**
 * 显示分类页或是详情页，page页的banner。单张图片。
 */
function wp_one_banner($default = ''){

    if (is_page()) {

        $cur_page_id  = get_the_ID(); 
        $root_page_id = get_root_page_id(); //顶级page id

        $banner = get_post_meta($cur_page_id, 'meta_page_banner', true);
        if (empty($banner)) { //父page
            $banner = get_post_meta( $root_page_id, 'meta_page_banner', true ); 
        }

    } elseif (is_single()) {
        $term_id = get_the_term_id();
        if(empty($term_id)){
            return $default;
        }
        $category_root_id = get_category_root_id($term_id); //顶级分类ID

        if (@get_term_meta($term_id, 'meta_topic_banner', TRUE)) {
            $banner = get_term_meta($term_id, 'meta_topic_banner', TRUE);
        }
        if (empty($banner)) { //父分类
            $banner = get_term_meta($category_root_id, 'meta_topic_banner', TRUE); 
        }
    } elseif (is_category()) {
        $thisCat = get_category(get_query_var('cat'), false);//当前默认分类
        $term_id = $thisCat->term_id;
        $category_root_id = get_category_root_id($term_id); //顶级分类ID

        if (@get_term_meta($term_id, 'meta_topic_banner', TRUE)) {
            $banner = get_term_meta($term_id, 'meta_topic_banner', TRUE);
        }
        if (empty($banner)) { //父分类
            $banner = @get_term_meta($category_root_id, 'meta_topic_banner', TRUE); 
        }
    } elseif (is_tax()) {
        $thisCat = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
        $term_id = $thisCat->term_id;
        $category_root_id = get_category_root_id($term_id); //顶级分类ID

        if (@get_term_meta($term_id, 'meta_topic_banner', TRUE)) {
            $banner = get_term_meta($term_id, 'meta_topic_banner', TRUE);
        }
        if (empty($banner)) { //父分类
            $banner = @get_term_meta($category_root_id, 'meta_topic_banner', TRUE); 
        }   
    }
    

    if (!empty($banner)) {
        //$return = wp_get_attachment_url( $banner );
        $return = wp_get_attachment_image($banner, 'full');
    } else {
        $return = $default;
    }

    return $return; 
}


/** 
 * 实现文章发表时间格式为“几分钟前”的方法
 */
function timeago() {
    global $post;
    $date = $post->post_date;
    $time = get_post_time('G', true, $post);
    $time_diff = time() - $time;
    if ($time_diff > 0 && $time_diff < 24*60*60*30)
        $display = sprintf('%s前', human_time_diff($time));
    else
        $display = date(get_option('date_format'), strtotime($date));	 
    return $display;
}	 
//add_filter('the_time', 'timeago');
//add_filter('the_modified_time', 'timeago');




/**
 * 更改作者的url
 */ 
add_rewrite_rule(
    'profile/([0-9]+)/?$',
    'index.php?author=$matches[1]',
    'top'
);
#add_action('author_rewrite_rules', 'my_author_rewrite_rules');
function my_author_rewrite_rules() {
    $author_rules['profile/([0-9]+)/?$'] = 'index.php?author=$matches[1]';
    $author_rules['profile/([0-9]+)/page/?([0-9]{1,})/?$'] = 'index.php?author=$matches[1]&paged=$matches[2]';
    $author_rules['profile/([0-9]+)/(feed|rdf|rss|rss2|atom)/?$'] = 'index.php?author=$matches[1]&feed=$matches[2]';
    $author_rules['profile/([0-9]+)/feed/(feed|rdf|rss|rss2|atom)/?$'] = 'index.php?author=$matches[1]&feed=$matches[2]';
    return $author_rules;
}
function my_permalink_redirect_author() {
	global $authordata;
	if ( ! is_object( $authordata ) ) {
		return;
	}

    $url = home_url('/profile/') . $authordata->ID;

	$link = sprintf(
		'<a href="%1$s" title="%2$s" rel="author">%3$s</a>',
		esc_url( $url ),
		esc_attr( sprintf( __( 'Posts by %s' ), get_the_author() ) ),
		get_the_author()
	);

    return $link;
}
#add_filter('the_author_posts_link', 'my_permalink_redirect_author');


/**
 * ajax分页
 */
function ajax_navi(){
	if( isset($_POST['action']) && $_POST['action'] == 'ajax_product_sale_RMB'){
		include TEMPLATEPATH.'/product-sale-RMB.php'; 
		die();
	}elseif( isset($_POST['action']) && $_POST['action'] == 'ajax_product_sale_USD'){
		include TEMPLATEPATH.'/product-sale-USD.php'; 
		die();
	}else{
		return;
	}
}
#add_action('template_redirect', 'ajax_navi');



/**
 * 仪表盘显示待审核的文章列表
 * http://blog.wpjam.com/m/pending-posts-dashboard-widget/
 */
#add_action( 'wp_dashboard_setup', 'wpjam_modify_dashboard_widgets' );
function wpjam_modify_dashboard_widgets() {
	global $wp_meta_boxes;
 
	if(current_user_can('manage_options')){ //只有管理员才能看到
		add_meta_box( 'pending_posts_dashboard_widget', '预约列表', 'pending_posts_dashboard_widget_function','dashboard', 'normal', 'core' );
	}
}
 
function pending_posts_dashboard_widget_function() {
	global $wpdb;
	$pending_posts = $wpdb->get_results("SELECT * FROM {$wpdb->posts}  WHERE post_status = 'pending' ORDER BY post_modified DESC");

	$post_type = array(
		'order'        => '预约',
	);
 
	if($pending_posts){ //判断是否有待审文章
		echo '<ul>';
		foreach ($pending_posts as $pending_post){
			echo '<li>['.$post_type[$pending_post->post_type].'] <a href="'.admin_url().'post.php?post='.$pending_post->ID.'&action=edit">'.$pending_post->post_title.'</a></li>';
		}
		echo '</ul>';
	}else echo '目前还没有预约';
}

//关闭展示工具栏
add_filter('show_admin_bar', '__return_false');

/**
 * 验证网站所有权---第三方代码插入头部
 * @return [type] [description]
 */
function custom_wp_head(){
    $_of_webmaster = of_get_option('_of_webmaster');
    echo $_of_webmaster;
}
add_action('wp_head', 'custom_wp_head');

/**
 * 第三方客服代码---第三方代码插入脚部
 * @return [type] [description]
 */
function custom_wp_footer_kf(){
    $_of_kf = of_get_option('_of_kf');
    echo $_of_kf;
}
add_action('wp_footer', 'custom_wp_footer_kf');

/**
 * 第三方统计代码---第三方代码插入脚部
 * @return [type] [description]
 */
function custom_wp_footer_tj(){
    $_of_tj = of_get_option('_of_tj');
    echo $_of_tj;
}
add_action('wp_footer', 'custom_wp_footer_tj');


