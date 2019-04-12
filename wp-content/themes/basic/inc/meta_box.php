<?php


//seo自定义字段
add_filter( 'rwmb_meta_boxes', 'page_seo_options' );
function page_seo_options( $meta_boxes )
{

    // meta box
    $meta_boxes[] = array(
        'id'         => 'standard-seo',
        'title'      => "SEO设置",
        'post_types' => array( 'page', 'post', 'product'),
        'context'    => 'normal',
        'priority'   => 'high',
        'autosave'   => false,

        'fields' => array(
            array(
                'name' => "标题",
                'id'   => "meta_seo_title",
                'type' => 'text',
                'std'  => '',
            ),

            array(
                'name' => "关键词",
                'id'   => "meta_seo_keyword",
                'desc' => "多个关键词用英文逗号隔开",
                'type' => 'text',
                'std'  => '',
            ),

            array(
                'name' => "描述",
                'id'   => "meta_seo_desc",
                'desc' => "",
                'type' => 'textarea',
                'std'  => '',
            ),

        )
    );
	return $meta_boxes;
}
//seo分类自定义字段
add_filter( 'rwmb_meta_boxes', 'page_seo_category_options' );
function page_seo_category_options( $meta_boxes )
{

    //分类目录
    $meta_boxes[] = array(

        'id'         => 'standard-topic',
        'title'      => "高级选项",
        'taxonomies' => array( 'category', 'product_cat','question_category','document_category','fitting_category' ),

        'fields' => array(
            array(
                'name' => "SEO关键词",
                'id'   => "category_seo_keyword",
                'desc' => "多个关键词用英文逗号隔开",
                'type' => 'text',
                'std'  => '',
            ),

            array(
                'name' => "SEO描述",
                'id'   => "category_seo_desc",
                'desc' => "最好在140字符以内。",
                'type' => 'textarea',
                'std'  => '',
            ),                                          
        )
    );
	return $meta_boxes;
}

//案例
function type_case_init() {
    $labels = array(
        'name' => '案例',
        'singular_name' => '案例',
        'add_new' => '添加',
        'add_new_item' => '添加',
        'edit_item' => '编辑',
        'new_item' => '新的列表',
        'view_item' => '查看',
        'search_items' => '搜索',
        'not_found' => '列表为空',
        'not_found_in_trash' => '回收站为空',
        'parent_item_colon' => ''
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'has_archive' => false,
        'menu_icon' => 'dashicons-admin-comments',
        'supports' => array('title', 'editor', 'excerpt', 'thumbnail'),
        'label' => '案例',
    );
    register_post_type('case', $args);
}
add_action('init', 'type_case_init');

//案例类型
function create_case_tax() {
    register_taxonomy(
            'case_tax', 'case', array(
        'label' => '案例分类',
        //'rewrite' => array( 'slug' => 'speaker_category' ),
        'hierarchical' => true,
        'show_admin_column' => true,
            )
    );
}
add_action('init', 'create_case_tax');

//案例额外设置
add_filter('rwmb_meta_boxes', 'page_case_extra_options');

function page_case_extra_options($meta_boxes) {
    $meta_boxes[] = array(
        'title' => '设置',
        'post_types' => 'case',
       
        'fields' => array(
            array(
                'name' => "顶部图片",
                'id' => "case_top_img",
                'type' => 'image_advanced',
                'max_file_uploads' => 1,
            ),
            array(
                'name'=>'指标项',
                'id'=>'case_target_gp',
                'type'=>'group',
                'clone'=>'true',
                'sort_clone' => 'true',
                'tab' => 'tab-banner',
                //'max_clone'=>3,
                'fields'=>array(
                    array(
                        'id' => 'case_target_title_item',
                        'name' => '标题',
                        'type' => 'text', 
                    ), 
                    array(
                        'name' => '描述',
                        'id' => "case_target_desc_item",
                        'type' => 'wysiwyg',
                        'raw' => true,
                        'std' => '',
                        'options' => array(
                            'textarea_rows' => 10,
                            'teeny' => false,
                            'media_buttons' => true,
                        ),
                    ),
                    
                )
            ),

        ),
    );
    return $meta_boxes;
}


//首页设置
add_filter( 'rwmb_meta_boxes', 'page_home_options' );
function page_home_options($meta_boxes) {
    $meta_boxes[] = array(
        'title' => '首页内容设置',
        'post_types' => 'page',
        'include' => array(
            'template' => array('page-home.php'),
        ),
        'tabs' => array(
          'tab-banner' => array(
                'label' => "幻灯片",
            ),
            'tab-works' => array(
                'label' => "WORKS",
            ),
            'tab-about' => array(
                'label' => "ABOUT",
            ),
            'tab-contact' => array(
                'label' => "CONTACT",
            ),

        ),
        'fields' => array(
            //幻灯片
            array(
                'name'=>'导航',
                'id'=>'page_home_banner_gp',
                'type'=>'group',
                'clone'=>'true',
                'sort_clone' => 'true',
                'tab' => 'tab-banner',
                //'max_clone'=>3,
                'fields'=>array(
                    array(
                        'name' => "背景图",
                        'id' => "page_home_banner_bgimg_item",
                        'type' => 'image_advanced',
                        'max_file_uploads' => 1,
                    ),
                    array(
                        'name' => "图标",
                        'id' => "page_home_banner_labelimg_item",
                        'type' => 'image_advanced',
                        'max_file_uploads' => 1,
                    ),
                    array(
                        'id' => 'page_home_banner_title_item',
                        'name' => '标题',
                        'type' => 'text', 
                    ), 
                    array(
                        'id' => 'page_home_banner_desc_item',
                        'name' => '描述',
                        'type' => 'text', 
                    ), 
                    
                )
            ),

            //works
            array(
                'name' => "标题",
                'id' => "page_home_works_title1",
                'type' => 'text',
                'std' => 'WORKS',
                'tab' => 'tab-works',
            ),

            array(
                'name' => "默认图片1",
                'id' => "page_home_works_img1",
                'type' => 'image_advanced',
                'max_file_uploads' => 1,
                'desc' => '图片尺寸2400×1300',
                'tab' => 'tab-works',
            ),
            array(
                'name' => "滚动图片1",
                'id' => "page_home_works_active_img1",
                'type' => 'image_advanced',
                'max_file_uploads' => 1,
                'desc' => '图片尺寸2400×1300',
                'tab' => 'tab-works',
            ),
            array(
                'name' => "描述1_1",
                'id' => "page_home_works_desc1_1",
                'type' => 'text',
                'tab' => 'tab-works',
            ),
            array(
                'name' => "描述1_2",
                'id' => "page_home_works_desc1_2",
                'type' => 'text',
                'tab' => 'tab-works',
            ),

            array(
                'name' => "图片2",
                'id' => "page_home_works_img2",
                'type' => 'image_advanced',
                'max_file_uploads' => 1,
                'desc' => '图片尺寸2400×1300',
                'tab' => 'tab-works',
            ),
            array(
                'name' => "滚动图片2",
                'id' => "page_home_works_active_img2",
                'type' => 'image_advanced',
                'max_file_uploads' => 1,
                'desc' => '图片尺寸2400×1300',
                'tab' => 'tab-works',
            ),
            array(
                'name' => "描述2_1",
                'id' => "page_home_works_desc2_1",
                'type' => 'text',
                'tab' => 'tab-works',
            ),
            array(
                'name' => "描述2_2",
                'id' => "page_home_works_desc2_2",
                'type' => 'text',
                'tab' => 'tab-works',
            ),

            array(
                'name' => "图片3",
                'id' => "page_home_works_img3",
                'type' => 'image_advanced',
                'max_file_uploads' => 1,
                'desc' => '图片尺寸2400×1300',
                'tab' => 'tab-works',
            ),
            array(
                'name' => "滚动图片3",
                'id' => "page_home_works_active_img3",
                'type' => 'image_advanced',
                'max_file_uploads' => 1,
                'desc' => '图片尺寸2400×1300',
                'tab' => 'tab-works',
            ),
            array(
                'name' => "描述3_1",
                'id' => "page_home_works_desc3_1",
                'type' => 'text',
                'tab' => 'tab-works',
            ),
            array(
                'name' => "描述3_2",
                'id' => "page_home_works_desc3_2",
                'type' => 'text',
                'tab' => 'tab-works',
            ),

            array(
                'name' => "图片4",
                'id' => "page_home_works_img4",
                'type' => 'image_advanced',
                'max_file_uploads' => 1,
                'desc' => '图片尺寸2400×1300',
                'tab' => 'tab-works',
            ),
            array(
                'name' => "滚动图片4",
                'id' => "page_home_works_active_img4",
                'type' => 'image_advanced',
                'max_file_uploads' => 1,
                'desc' => '图片尺寸2400×1300',
                'tab' => 'tab-works',
            ),
            array(
                'name' => "描述4_1",
                'id' => "page_home_works_desc4_1",
                'type' => 'text',
                'tab' => 'tab-works',
            ),
            array(
                'name' => "描述4_2",
                'id' => "page_home_works_desc4_2",
                'type' => 'text',
                'tab' => 'tab-works',
            ),

            array(
                'name' => "图片5",
                'id' => "page_home_works_img5",
                'type' => 'image_advanced',
                'max_file_uploads' => 1,
                'desc' => '图片尺寸2400×1300',
                'tab' => 'tab-works',
            ),
            array(
                'name' => "滚动图片5",
                'id' => "page_home_works_active_img5",
                'type' => 'image_advanced',
                'max_file_uploads' => 1,
                'desc' => '图片尺寸2400×1300',
                'tab' => 'tab-works',
            ),
            array(
                'name' => "描述5_1",
                'id' => "page_home_works_desc5_1",
                'type' => 'text',
                'tab' => 'tab-works',
            ),
            array(
                'name' => "描述5_2",
                'id' => "page_home_works_desc5_2",
                'type' => 'text',
                'tab' => 'tab-works',
            ),

            array(
                'name' => "图片6",
                'id' => "page_home_works_img6",
                'type' => 'image_advanced',
                'max_file_uploads' => 1,
                'desc' => '图片尺寸2400×1300',
                'tab' => 'tab-works',
            ),
            array(
                'name' => "滚动图片6",
                'id' => "page_home_works_active_img6",
                'type' => 'image_advanced',
                'max_file_uploads' => 1,
                'desc' => '图片尺寸2400×1300',
                'tab' => 'tab-works',
            ),
            array(
                'name' => "描述6_1",
                'id' => "page_home_works_desc6_1",
                'type' => 'text',
                'tab' => 'tab-works',
            ),
            array(
                'name' => "描述6_2",
                'id' => "page_home_works_desc6_2",
                'type' => 'text',
                'tab' => 'tab-works',
            ),


            //about
            array(
                'name' => "标题",
                'id' => "page_home_about_title",
                'type' => 'text',
                'std' => 'ABOUT',
                'tab' => 'tab-about',
            ),
            array(
                'name' => "方块1图片",
                'id' => "page_home_about_img1",
                'type' => 'image_advanced',
                'max_file_uploads' => 1,
                'desc' => '图片尺寸2400×1300',
                'tab' => 'tab-about',
            ),
            array(
                'name' => "方块2图片",
                'id' => "page_home_about_img2",
                'type' => 'image_advanced',
                'max_file_uploads' => 1,
                'desc' => '图片尺寸2400×1300',
                'tab' => 'tab-about',
            ),
            array(
                'name' => "方块3图片",
                'id' => "page_home_about_img3",
                'type' => 'image_advanced',
                'max_file_uploads' => 1,
                'desc' => '图片尺寸2400×1300',
                'tab' => 'tab-about',
            ),
            array(
                'name' => "方块4描述1",
                'id' => "page_home_about_desc4_1",
                'type' => 'text',
                'tab' => 'tab-about',
            ),
            array(
                'name' => "方块4描述2",
                'id' => "page_home_about_desc4_2",
                'type' => 'text',
                'tab' => 'tab-about',
            ),
            array(
                'name' => "方块4描述3",
                'id' => "page_home_about_desc4_3",
                'type' => 'text',
                'tab' => 'tab-about',
            ),
            array(
                'name' => "方块4链接",
                'id' => "page_home_about_link4",
                'type' => 'text',
                'tab' => 'tab-about',
            ),
            array(
                'name'=>'导航',
                'id'=>'page_home_about_gp',
                'type'=>'group',
                'clone'=>'true',
                'sort_clone' => 'true',
                'tab' => 'tab-about',
                'max_clone'=>2,
                'fields'=>array(
                    array(
                        'name' => "图片",
                        'id' => "page_home_about_img_item",
                        'type' => 'image_advanced',
                        'max_file_uploads' => 1,
                    ),
                    array(
                        'name' => "描述1",
                        'id' => "page_home_about_desc1_item",
                        'type' => 'text',
          
                    ),
                    array(
                        'name' => "描述2",
                        'id' => "page_home_about_desc2_item",
                        'type' => 'text',
                  
                    ),
                    array(
                        'name' => "描述3",
                        'id' => "page_home_about_desc3_item",
                        'type' => 'text',
                      
                    ),
                    array(
                        'name' => "链接",
                        'id' => "page_home_about_desc4_item",
                        'type' => 'text',
                
                    ),
                    
                )
            ),


            //contact
            array(
                'name' => "大标题",
                'id' => "page_home_contact_title",
                'type' => 'text',
                'tab' => 'tab-contact',
            ),
            array(
                'name' => "公司名称",
                'id' => "page_home_contact_company",
                'type' => 'text',
                'tab' => 'tab-contact',
            ),
            array(
                'name' => "电话",
                'id' => "page_home_contact_phone",
                'type' => 'text',
                'tab' => 'tab-contact',
            ),
            array(
                'name' => "邮箱",
                'id' => "page_home_contact_email",
                'type' => 'text',
                'tab' => 'tab-contact',
            ),
            array(
                'name' => "地址",
                'id' => "page_home_contact_address",
                'type' => 'text',
                'tab' => 'tab-contact',
            ),
            array(
                'name' => "微信二维码",
                'id' => "page_home_about_wechat_img",
                'type' => 'image_advanced',
                'max_file_uploads' => 1,
                'tab' => 'tab-contact',
            ),
            array(
                'name' => "微博二维码",
                'id' => "page_home_about_weblog_img",
                'type' => 'image_advanced',
                'max_file_uploads' => 1,
                'tab' => 'tab-contact',
            ),
            array(
                'name' => "地图图片",
                'id' => "page_home_about_address_img",
                'type' => 'image_advanced',
                'max_file_uploads' => 1,
                'tab' => 'tab-contact',
            ),
        )
    );
    return $meta_boxes;
}

//关于模板设置
add_filter('rwmb_meta_boxes', 'page_about_options');

function page_about_options($meta_boxes) {
    $meta_boxes[] = array(
        'title' => '设置',
        'post_types' => 'page',
        'include' => array(
            'template' => array('page-about.php'),
        ),
        'fields' => array(
            // array(
            //     'name' => "顶部图片",
            //     'id' => "page_about_banner",
            //     'type' => 'image_advanced',
            //     'max_file_uploads' => 1,
            //     'desc' => '图片尺寸1920×450',
            // ),
            array(
                'name'=>'导航',
                'id'=>'page_about_nav_gp',
                'type'=>'group',
                'clone'=>'true',
                'sort_clone' => 'true',
                'tab' => 'tab-project',
                //'max_clone'=>3,
                'fields'=>array(
                   
                    array(
                        'name'  => "页面",
                        'id'    => 'page_about_page_id',
                        'type'  => 'post',
                        // 'clone'       => true,
                        // 'multiple'    => true,
                        // Post type: string (for single post type) or array (for multiple post types)
                        'post_type'   => array('page'),
                        // Default selected value (post ID)
                        //'std'         => 54,
                        // Field type, either 'select' or 'select_advanced' (default)
                        'field_type'  => 'select_advanced',
                        // Placeholder
                        'placeholder' => '选择一个页面',
                        // Query arguments (optional). No settings means get all published posts
                        // @see 
                        'query_args'  => array(
                                'post_status'    => 'publish',
                                'posts_per_page' => - 1,
                        ),
                    ),  
                    
                )
            ),
            array(
                'id' => 'page_about_title',
                'name' => '标题',
                'type' => 'text', 
            ),
            array(
                'id' => 'page_about_slave_title',
                'name' => '副标题',
                'type' => 'text', 
            ),
            array(
                'name' => '内容',
                'id' => "page_about_content",
                'type' => 'wysiwyg',
                'raw' => true,
                'std' => '',
                'options' => array(
                    'textarea_rows' => 15,
                    'teeny' => false,
                    'media_buttons' => true,
                ),
            ),

        ),
    );
    return $meta_boxes;
}

//联系我们模板设置
add_filter('rwmb_meta_boxes', 'page_contact_options');

function page_contact_options($meta_boxes) {
    $meta_boxes[] = array(
        'title' => '设置',
        'post_types' => 'page',
        'include' => array(
            'template' => array('page-contact.php'),
        ),
        'fields' => array(
            // array(
            //     'name' => "顶部图片",
            //     'id' => "page_contact_banner",
            //     'desc' => '图片设置',
            //     'type' => 'image_advanced',
            //     'max_file_uploads' => 1,
            //     'desc' => '图片尺寸1920×450',
            // ),          
            array(
                'id' => 'page_contact_title_en',
                'name' => '主标题（英文）',
                'type' => 'text', 
            ),
            array(
                'id' => 'page_contact_title_zh',
                'name' => '主标题（中文）',
                'type' => 'text', 
            ),
            array(
                'id' => 'page_contact_slave_title_zh',
                'name' => '副标题（中文）',
                'type' => 'text', 
            ),
            array(
                'id' => 'page_contact_slave_title_en',
                'name' => '副标题（英文）',
                'type' => 'text', 
            ),

            array(
                'name'=>'联系表第一列',
                'id'=>'page_contact_table_gp1',
                'type'=>'group',
                'clone'=>'true',
                'sort_clone' => 'true',
                'max_clone'=>3,
                'fields'=>array(
                    array(
                        'id' => 'page_contact_table_item_title',
                        'name' => '标题',
                        'type' => 'text', 
                    ),
                    array(
                        'id' => 'page_contact_table_item_desc1',
                        'name' => '第一项',
                        'type' => 'text', 
                    ),
                    array(
                        'id' => 'page_contact_table_item_desc2',
                        'name' => '第二项',
                        'type' => 'text', 
                    ),
                    array(
                        'id' => 'page_contact_table_item_desc3',
                        'name' => '第三项',
                        'type' => 'text', 
                    ),
                    array(
                        'id' => 'page_contact_table_item_desc4',
                        'name' => '第四项',
                        'type' => 'text', 
                    ),
                    
                    
                )
            ),
            array(
                'name'=>'联系表第二列',
                'id'=>'page_contact_table_gp2',
                'type'=>'group',
                'clone'=>'true',
                'sort_clone' => 'true',
                'max_clone'=>3,
                'fields'=>array(
                   
                    array(
                        'id' => 'page_contact_table_item_title',
                        'name' => '标题',
                        'type' => 'text', 
                    ),
                    array(
                        'id' => 'page_contact_table_item_desc1',
                        'name' => '第一项',
                        'type' => 'text', 
                    ),
                    array(
                        'id' => 'page_contact_table_item_desc2',
                        'name' => '第二项',
                        'type' => 'text', 
                    ),
                    array(
                        'id' => 'page_contact_table_item_desc3',
                        'name' => '第三项',
                        'type' => 'text', 
                    ),
                    array(
                        'id' => 'page_contact_table_item_desc4',
                        'name' => '第四项',
                        'type' => 'text', 
                    ), 
                    
                )
            ),
            array(
                'name' => '内容',
                'id' => "page_contact_content",
                'type' => 'wysiwyg',
                'raw' => true,
                'std' => '',
                'options' => array(
                    'textarea_rows' => 15,
                    'teeny' => false,
                    'media_buttons' => true,
                ),
            ),

        ),
    );
    return $meta_boxes;
}

//设计案例模板设置
add_filter('rwmb_meta_boxes', 'page_case_options');

function page_case_options($meta_boxes) {
    $meta_boxes[] = array(
        'title' => '设置',
        'post_types' => 'page',
        'include' => array(
            'template' => array('page-case.php'),
        ),
        'fields' => array(
            // array(
            //     'name' => "顶部图片",
            //     'id' => "page_case_banner",
            //     'desc' => '图片设置',
            //     'type' => 'image_advanced',
            //     'max_file_uploads' => 1,
            //     'desc' => '图片尺寸1920×450',
            // ),
            array(
                'id' => 'page_case_show_count',
                'name' => '每页展示数量',
                'type' => 'number',
                'desc' => '请输入显示数量,最小显示5个',
                'min' => 5,
                
            ),
        ),
    );
    return $meta_boxes;
}

add_filter( 'rwmb_meta_boxes', 'post_options' );
function post_options( $meta_boxes )
{
    $meta_boxes[] = array(
        'title' => '设置',
        'post_types'=>'post',      
        'fields' => array(
            array(
                'name'=>'查看数',
                'id'=>'post_check_count',
                'type' => 'text',
            ),                                 

        ),      
    );
    return $meta_boxes;
}

add_filter('rwmb_meta_boxes', 'page_category_options');
function page_category_options($meta_boxes) {

    $meta_boxes[] = array(
        'title' => '设置',
        //'post_types'=>'page',
        'taxonomies' => array('category','project_tax','product_tax'),
        'fields' => array(
            array(
                'name' => 'Banner图片',
                'id' => 'page_category_banners',
                'type' => 'image_advanced',
                'max_file_uploads' => 1,
                'desc' => '图片大小：1920x545',
            ),
        ),
    );
    return $meta_boxes;
}

add_filter( 'rwmb_meta_boxes', 'post_product_options' );
function post_product_options( $meta_boxes )
{
    $meta_boxes[] = array(
        'title' => '设置',
        'post_types'=>array('product','project'),
        'fields' => array(
            array(
                'name'=>'属性描述1题目',
                'id'=>'post_product_title_1',
                'type' => 'text',
            ), 
            array(
                'name'=>'属性描述1值',
                'id'=>'post_product_1',
                'type' => 'text',
            ),
            array(
                'name'=>'属性描述2题目',
                'id'=>'post_product_title_2',
                'type' => 'text',
            ), 
            array(
                'name'=>'属性描述2值',
                'id'=>'post_product_2',
                'type' => 'text',
            ), 
            array(
                'name'=>'属性描述3题目',
                'id'=>'post_product_title_3',
                'type' => 'text',
            ), 
            array(
                'name'=>'属性描述3值',
                'id'=>'post_product_3',
                'type' => 'text',
            ),                                  
            // array(
            //     'name'=>'地址',
            //     'id'=>'post_product_address',
            //     'type' => 'text',
            // ),                                 
            // array(
            //     'name'=>'风格',
            //     'id'=>'post_product_style',
            //     'type' => 'text',
            // ),              
            array(
                'name'=>'产品图片设置',
                'id'=>'post_product_image_gp',
                'type'=>'group',
                'clone'=>'true',
                'sort_clone' => 'true',
                'max_clone'=>5,
                'fields'=>array(                              
                    array(
                        'name'=>'大图片',
                        'id'=>'post_product_image_gp_big_one',
                        'type' => 'image_advanced',
                        'max_file_uploads' => 1,
                        'desc' => '图片大小：720x400',
                    ),  
                    array(
                        'name'=>'小图片',
                        'id'=>'post_product_image_gp_small_one',
                        'type' => 'image_advanced',
                        'max_file_uploads' => 1,
                        'desc' => '图片大小：70x70',
                    ),                      

                ),
            ),                                                                                                        

        ),      
    );
    return $meta_boxes;
}



//成功案例模板设置
add_filter( 'rwmb_meta_boxes', 'page_example_options' );
function page_example_options( $meta_boxes ) {

    $meta_boxes[] = array(
        'title' => '页面设置',
        'post_types'=>'page',
        'include' => array(
            'template' => array('page-example.php'),
        ),          
        'fields' => array(
                
            array(
                'name'=>'页面展示数量',
                'id'=>'page_project_show_count',
                'type' => 'number',
            ),
                              
            
        ),
    );

    return $meta_boxes;
}


/**
 * 按分类目录筛选
 */
function pippin_add_taxonomy_filters_product() {
    global $typenow;

    if ($typenow == 'product'){
        $tax = 'product_tax';
        $tax_obj = get_taxonomy($tax);
        $tax_name = $tax_obj->labels->name;
        $terms = get_terms($tax);

        if (count($terms) > 0) {
            echo "<select name='$tax' id='$tax' class='postform'>";
            echo "<option value=''>显示所有 $tax_name</option>";
            foreach ($terms as $term) { 
                echo '<option value='. $term->slug, @$_GET[$tax] == $term->slug ? ' selected="selected"' : '','>' . $term->name .'</option>';
            }
            echo "</select>";
        }
    }
}
add_action('restrict_manage_posts', 'pippin_add_taxonomy_filters_product');


add_action( 'admin_init', 'wpjam_remove_editor' );
function wpjam_remove_editor() {
	$post_id = isset( $_GET['post'] ) ? $_GET['post'] : @$_POST['post_ID'];
	if( ! isset( $post_id ) ) return;

	$template_file = get_post_meta( $post_id, '_wp_page_template', true );

    if ( ! empty( $template_file ) && $template_file != 'default' ) {
        remove_post_type_support( 'page', 'editor' );
    }
}

