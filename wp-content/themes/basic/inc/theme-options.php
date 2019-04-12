<?php
####################### 主题选项



/**
 * 网站设置参数
 * 启用options-framework 或是 meta-box 插件
 */
if (!function_exists('of_get_option')) {
    function of_get_option($name, $default = false) {
        
        $optionsframework_settings = get_option('optionsframework');
        
        // Gets the unique option id
        $option_name = $optionsframework_settings['id'];
    
        if(!$option_name){
            //for meta-box
            $option_name = preg_replace("/\W/", "_", strtolower( get_option( 'stylesheet' ) ) );
        }
    
        if (get_option($option_name)) {
            $options = get_option($option_name);
        }
    
        if (!isset($options)) { //解决php序列化问题
                global $wpdb;
                $get_options = $wpdb->get_var($wpdb->prepare(
                                    "SELECT option_value FROM $wpdb->options WHERE option_name='%s';",
                                    $option_name
                                ));
                $get_options = preg_replace('!s:(\d+):"(.*?)";!e', "'s:'.strlen('$2').':\"$2\";'", $get_options);
                $options = unserialize($get_options);
                if ($get_options && !empty($options)) {
                    update_option($option_name, $options);
                }
        }
    
    
        //是否有多语言
        if (function_exists('pll_current_language')) {
            $pll_current_language = pll_current_language(); //当前
            $name_for_lang = $name.'_'.$pll_current_language;
            if (isset($options[$name_for_lang]) && $options[$name_for_lang] ) {
                return $options[$name_for_lang];
            }
        }
            
        if (isset($options[$name])) {
            return $options[$name];
        } else {
            return $default;
        }
    }
}


    
add_filter( 'mb_settings_pages', 'prefix_options_page' );
function prefix_options_page( $settings_pages )
{
    $settings_pages[] = array(
        'id'          => 'options-framework',
        'option_name' => preg_replace("/\W/", "_", strtolower( get_option( 'stylesheet' ) ) ),
        'menu_title'  => __( 'Theme Options'),
        'parent'      => 'themes.php',
    );
    return $settings_pages;
}




add_filter( 'rwmb_meta_boxes', 'meta_box_tabs_options_register' );
function meta_box_tabs_options_register( $meta_boxes )
{

    // 1st Meta Box
    $meta_boxes[] = array(
        'id'             => 'options-zh',
        'settings_pages' => 'options-framework',
        'title'          => __( 'Theme Options'),
        'tabs'      => array(
            'tab-options' => array(
                'label'   => "基本设置",
            ),
            'tab-footer' => array(
                'label'  => "网站底部",
            ),
            'tab-advanced' =>array(
                'label'  => '扩展设置',
            ),            
        ),
        // Tab style: 'default', 'box' or 'left'. Optional
        'tab_style' => 'default',
        
        // Show meta box wrapper around tabs? true (default) or false. Optional
        'tab_wrapper' => true,
        'fields'    => array(
            
            array(
                'name' => 'ico图标',
                'desc' => '默认LOGO图片宽高：32x32，格式为.ico',
                'id'   => "_of_ico_logo",
                'type' => 'file_input',
                'tab'  => 'tab-options',
            ),
            array(
                'name' => 'Logo',
                'desc' => '默认LOGO图片宽高：280x56',
                'id'   => "_of_logo",
                'type' => 'file_input',
                'tab'  => 'tab-options',
            ),
            array(
                'name'=>'网站LOGO描述',
                'id'=>'_of_logo_desc',
                'type' => 'text',
                'std' => '首页',
                'tab'=>'tab-options',
            ), 
            // array(
            //     'name' => '手机Logo',
            //     'desc' => '默认LOGO图片宽高：56x56',
            //     'id'   => "_of_mlogo",
            //     'type' => 'file_input',
            //     'tab'  => 'tab-options',
            // ),

            //顶部图片
            array(
                'name' => "部分页面顶部图片",
                'id' => "_of_top_banners",
                'type' => 'image_advanced',
                'max_file_uploads' => 1,
                'desc' => '图片尺寸1920×450',
                'tab'  => 'tab-options',
            ),

            array(
                'name'    => '底部版权信息',
                'id'      => "_of_copyright",
                'type'    => 'wysiwyg',
                'tab'     => 'tab-footer',
                'raw'     => true,
                'std'     => '',

                // Editor settings, see wp_editor() function: look4wp.com/wp_editor
                'options' => array(
                    'textarea_rows' => 4,
                    'teeny'         => false,
                    'media_buttons' => false,
                ),
            ),            

            // array(
            //     'name'=>'底部链接设置',
            //     'id'=>'of_bottom_link_gp',
            //     'type'=>'group',
            //     'sort_clone' => 'true',
            //     'clone'=>'true',
            //     'max_clone'=>3,
            //     'tab' => 'tab-footer',
            //     'fields'=>array(
            //         array(
            //             'name'=>'名称',
            //             'id'=>'of_bottom_link_item_name',
            //             'type' => 'text',
            //         ),
            //         array(
            //             'name'=>'链接',
            //             'id'=>'of_bottom_link_item',
            //             //'desc' => '每段文字加在<p></p>之间，例<p>文字加在中间位置</p>',                              
            //             'type'    => 'text',
            //         ),                    

            //     ),
            // ),             

            array(
                'name'    => '第三方客服代码',
                'desc'    => '',
                'id'      => "_of_kf",
                'type'    => 'textarea',
                'std'     => '',
                'tab'  => 'tab-advanced',
            ),   
            array(
                'name'    => '第三方统计代码',
                'desc'    => '',
                'id'      => "_of_tj",
                'type'    => 'textarea',
                'std'     => '',
                'tab'  => 'tab-advanced',
            ),   
            array(
                'name'    => '验证网站所有权',
                'desc'    => '第三方需要验证所有权时可用，把代码复制到这里即可。',
                'id'      => "_of_webmaster",
                'type'    => 'textarea',
                'std'     => '',
                'tab'  => 'tab-advanced',
            ),              
 
        ),
    );



    
    $meta_boxes[] = array(
        'id'             => 'info',
        'title'          => '说明',
        'context'        => 'side',
        'settings_pages' => 'options-framework',
        'fields'         => array(
            array(
                'type' => 'custom_html',
                'std'  => '主题的基本设置: LOGO，网站底部等。',
            )
        ),
    );    
    
    return $meta_boxes;
}
