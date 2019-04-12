<?php
/**
 * 增强默认编辑器
 */
function Bing_editor_buttons($buttons){
    $buttons[] = 'fontselect';
    $buttons[] = 'fontsizeselect';
    $buttons[] = 'backcolor';
    $buttons[] = 'cut';
    $buttons[] = 'copy';
    $buttons[] = 'paste';
    $buttons[] = 'hr';
    $buttons[] = 'cleanup';
    $buttons[] = 'wp_page';
    return $buttons;
}
add_filter("mce_buttons_3", "Bing_editor_buttons");

/**
 * 为编辑器增加中文字体
 */
function custum_fontfamily($initArray){
    $initArray['font_formats']  = "微软雅黑='微软雅黑';";
    $initArray['font_formats'] .= "宋体='宋体';";
    $initArray['font_formats'] .= "黑体='黑体';";
    $initArray['font_formats'] .= "仿宋='仿宋';";
    $initArray['font_formats'] .= "楷体='楷体';";
    $initArray['font_formats'] .= "隶书='隶书';";
    $initArray['font_formats'] .= "幼圆='幼圆';";
    $initArray['font_formats'] .= "Arial=arial,helvetica,sans-serif;";
    $initArray['font_formats'] .= "Arial Black=arial black,avant garde;";
    $initArray['font_formats'] .= "Courier New=courier new,courier;";
    $initArray['font_formats'] .= "ClearSans='clear_sansregular',Helvetica,Arial,sans-serif;";
    $initArray['font_formats'] .= "ClearSans Medium='clear_sans_mediumregula',Helvetica,Arial,sans-serif;";
    $initArray['font_formats'] .= "Times New Roman=times new roman,times;";
    return $initArray;
}
add_filter('tiny_mce_before_init', 'custum_fontfamily');

