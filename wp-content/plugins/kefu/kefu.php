<?php
/*
Plugin Name: 悬浮的在线客服
Description: 悬浮的在线QQ旺旺客服
Version: 1.0
*/


$plugin_url = WP_PLUGIN_URL . "/" . dirname(plugin_basename(__FILE__));

add_action( 'admin_enqueue_scripts', 'kefu_add_color_picker' );
function kefu_add_color_picker( $hook ) {
    if( is_admin() ) { 
        // 添加拾色器的CSS文件       
        wp_enqueue_style( 'wp-color-picker' ); 
        // 引用我们自定义的jQuery文件以及加入拾色器的支持
        wp_enqueue_script( 'custom-script-handle', plugins_url( 'asset/js/color-picker.js', __FILE__ ), array( 'wp-color-picker' ), false, true ); 
    }
}

/**
* 设置配置项
*/
function kefu_set_option($option_name, $option_value) {	
    $kefu_options               = get_option( 'kefu_options' );	
    $kefu_options[$option_name] = $option_value;	
    update_option ( 'kefu_options', $kefu_options );
}


/**
* 获取配置项
*/
function kefu_get_option($option_name) {	

    $kefu_options = get_option ( 'kefu_options' );

    if ( !$kefu_options || !array_key_exists ( $option_name, $kefu_options ) ) {		
        $kefu_default_options                          = array ();		
        $kefu_default_options ["theme"]                = "1";
        $kefu_default_options ["pos"]                  = "2";
        $kefu_default_options ["telNo"]                = "";
        $kefu_default_options ["email"]                = "";
        $kefu_default_options ["bottom"]               = "150";
        $kefu_default_options ["iconcolor"]            = "#333333";
        $kefu_default_options ["backgroundcolor"]      = "#ffffff";
        $kefu_default_options ["iconcolorhover"]       = "#f60";
        $kefu_default_options ["backgroundcolorhover"] = "#ffffff";
        $kefu_default_options ["qrCode"]               = "";
        $kefu_default_options ["enbleNavlog"]          = true;
        $kefu_default_options ["Enable_qq_Backup"]     = true;
        $kefu_default_options ["Enable_mobile"]        = true;
        $kefu_default_options ["iconTarget"]           = 1;
        $kefu_default_options ["iconImg"]              = "";
        $kefu_default_options ["iconUrl"]              = "";
        $kefu_default_options ["iconTitle"]            = "";
        $kefu_default_options ["qq"]                   = "";
        $kefu_default_options ["wangwang"]             = "";
        $kefu_default_options ["wangwangTitles"]       = "";
        $kefu_default_options ["skype"]                = "";
        $kefu_default_options ["skypeTitles"]          = "";
        $kefu_default_options ["wangwangInter"]        = "";
        $kefu_default_options ["wangwangInterTitles"]  = "";
        $kefu_default_options ["enableIndex"]          = true;
        $kefu_default_options ["enableSingle"]         = true;
        $kefu_default_options ["icoSize"]              = 1;
        $kefu_default_options ["icoSizeWang"]          = 1;
        $kefu_default_options ["icoSizeSkype"]         = 1;
        $kefu_default_options ["qqTitle"]              = "";

        $kefu_default_options ["qqtop"]                = "20";
        $kefu_default_options ['enable']               = false;

        add_option ( 'kefu_options', $kefu_default_options );

        $result = $kefu_default_options[$option_name];	
    } else {		
        $result = $kefu_options[$option_name];	
    }	

    return $result;
}



/**
* 管理菜单
*/
add_action ( 'admin_menu', 'kefu_menu' );
function kefu_menu() {	
    if (function_exists ( 'add_options_page' )) {		
        add_options_page ( '在线客服', '在线客服', 'manage_options', 'kefu', 'kefu_admin' );
    }
}

/**
* 管理界面
*/
function kefu_admin() {
    require_once( dirname(__FILE__) . '/admin.php' );
}


/**
* 输出提示信息
* @param {String} $msg 提示信息
*/
function kefu_Tip($msg) {	
    return '<div class="updated"><p><strong>' . $msg . '</strong></p></div>';
}


/**
* 输出错误提示信息
* @param {String} $msg 提示信息
*/
function kefu_error($msg) {
    return '<div class="error settings-error"><p><strong>' . $msg . '</strong></p></div>';
}


/**
 * QQ图标
 */
function getQQHtml($q1, $qqTitle1, $index){
    if( !empty($q1) ){
        if( empty($qqTitle1) ){
            $qqTitle1 = $q1;
        } 
        $html  = '<tr><td><a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin='.$q1.'&site=qq&menu=yes"><div class="kefu4" id="qqIco'.$index.'">';
        $html .= '</div></a></td></tr><tr><td><a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin='.$q1.'&site=qq&menu=yes"><div class="qqnum">'.$qqTitle1.'</div></a></td></tr>';
        return $html;
    }
}

function getQQHtmlSmall($q1, $qqTitle1){
    if( !empty($q1) ){
        if( empty($qqTitle1) ){
            $qqTitle1 = $q1;
        } 
        return '<tr><td><div class="qqSmall"><a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin='.$q1.'&site=qq&menu=yes"><img src="http://wpa.qq.com/pa?p=2:'.$q1.':52"  style="vertical-align:middle" > '.$qqTitle1.'</a></div></td></tr>';
    }
}

function getQQHtmlstandard($q1, $qqTitle1){
    if( !empty($q1) ){
        if( $qqTitle1 == '' ){
            return '<tr><td><div class="qqSmall"><a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin='.$q1.'&site=qq&menu=yes"><img src="http://wpa.qq.com/pa?p=2:'.$q1.':41"  style="vertical-align:middle"  alt="点击这里给我发消息" title="点击这里给我发消息"></a></div></td></tr>';
        }else{
            return '<tr><td><p class="wangwang-names">'.$qqTitle1.'</p><div class="qqSmall"><a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin='.$q1.'&site=qq&menu=yes"><img src="http://wpa.qq.com/pa?p=2:'.$q1.':41"  style="vertical-align:middle"  alt="点击这里给我发消息" title="点击这里给我发消息"></a></div></td></tr>';
        }
    }
}


/*
 * 旺旺图标
 * $size  1大 2小
 */
function getWangHtml($wang1, $wangwangNames, $size){
    if(!empty($wang1)){
        $wang = urlencode($wang1);
        if( $size == "1" ){
            if ($wangwangNames == '') {
                return '<tr><td><div class="qqSmall"><a target="_blank" href="http://amos.im.alisoft.com/msg.aw?v=2&uid='.$wang.'&site=cntaobao&s='.$size.'&charset=utf-8" ><img border="0" src="http://amos.im.alisoft.com/online.aw?v=2&uid='.$wang.'&site=cntaobao&s='.$size.'&charset=utf-8" alt="点击这里给我发消息" style="vertical-align:middle;" /></a></div></td></tr>';
            }else{
                return '<tr><td><p class="wangwang-names">'.$wangwangNames.'</p><div class="qqSmall"><a target="_blank" href="http://amos.im.alisoft.com/msg.aw?v=2&uid='.$wang.'&site=cntaobao&s='.$size.'&charset=utf-8" ><img border="0" src="http://amos.im.alisoft.com/online.aw?v=2&uid='.$wang.'&site=cntaobao&s='.$size.'&charset=utf-8" alt="点击这里给我发消息" style="vertical-align:middle;" /></a></div></td></tr>';
            }
        }else{
            if ($wangwangNames == '') {
                return '<tr><td><div class="qqSmall"><a target="_blank" href="http://amos.im.alisoft.com/msg.aw?v=2&uid='.$wang.'&site=cntaobao&s='.$size.'&charset=utf-8" ><img border="0" src="http://amos.im.alisoft.com/online.aw?v=2&uid='.$wang.'&site=cntaobao&s='.$size.'&charset=utf-8" alt="点击这里给我发消息" style="vertical-align:middle;" />'.$wang1.'</a></div></td></tr>';
            }else{
                return '<tr><td><div class="qqSmall"><a target="_blank" href="http://amos.im.alisoft.com/msg.aw?v=2&uid='.$wang.'&site=cntaobao&s='.$size.'&charset=utf-8" ><img border="0" src="http://amos.im.alisoft.com/online.aw?v=2&uid='.$wang.'&site=cntaobao&s='.$size.'&charset=utf-8" alt="点击这里给我发消息" style="vertical-align:middle;" />'.$wangwangNames.'</a></div></td></tr>';
            }
        }
    }
}


/*
 * skype图标
 * $size  1大 2小
 */
 function getSkypetml($skype, $name, $size){
    $skypeImg = plugins_url( 'asset/images/skype.png', __FILE__ );
    if(!empty($skype)){
        $skype = urlencode($skype);
        if( $size == "1" ){
            if ($name == '') {
                return '<tr><td><a target="_blank" href="skype:'.$skype.'?call" ><div class="kefuicon-skype" style="点击这里给我发消息"></div><div class="qqnum">'.$skype.'</div></a></td></tr>';
            }else{
                return '<tr><td><a target="_blank" href="skype:'.$skype.'?call" ><div class="kefuicon-skype" style="'.$name.'"></div><div class="qqnum">'.$name.'</div></a></td></tr>';
            }
        }else{
            if ($name == '') {
                return '<tr><td><div class="qqSmall"><a target="_blank" href="skype:'.$skype.'?call" ><img border="0" src="'.$skypeImg.'" alt="点击这里给我发消息" style="vertical-align:middle;height:16px;width:16px;" />'.$skype.'</a></div></td></tr>';
            }else{
                return '<tr><td><div class="qqSmall"><a target="_blank" href="skype:'.$skype.'?call" ><img border="0" src="'.$skypeImg.'" alt="点击这里给我发消息" style="vertical-align:middle;height:16px;width:16px;" />'.$name.'</a></div></td></tr>';
            }
        }
    }
}


/*
 * 国际旺旺图标
 */
function getWangwangInterHtml($wang1, $wangName){
    if( !empty($wang1) ){
        $wang = urlencode($wang1);
            return '<tr><td><div class="qqSmall" style="overflow:hidden"><a href=" http://amos.alicdn.com/msg.aw?v=2&amp;uid='.$wang1.'&amp;site='.wang1.'&amp;s=24&amp;charset=UTF-8" ><img border="0" style="width:18px;height:18px; position:relative; top:0px;" src="http://amos.alicdn.com/online.aw?v=2&amp;uid='.$wang1.'&amp;site='.wang1.'&amp;s=21&amp;charset=UTF-8" style="vertical-align:middle;"/>'.$wangName.'</a></div></td></tr>';
    }
}

/**
* 初始化QQ客服
*/
include_once('modern.php');
function kefuInit1() {
    $pos1      = kefu_get_option('pos') == "1" ? "left" : "right";
    $icoSize2  = kefu_get_option('icoSize');
    $qs        = kefu_get_option('qq');

    $kefuHtml .= '<!-- QQ客服代码开始--><link rel="stylesheet" href="'.plugins_url('kefu/asset/css/main.css').'" type="text/css" media="screen" />';
    $kefuHtml .= '<script>
        if (typeof jQuery == "undefined") {
            var script = document.createElement("script");
            script.setAttribute("src",
                    "http://cdn.bootcss.com/jquery/1.12.4/jquery.min.js");
            document.getElementsByTagName("BODY")[0].appendChild(script);
        }
    </script>';

    $kefuHtml .= '<div id="divStayTopright" style="position:fixed;z-index:999999;top:'.kefu_get_option('qqtop').'%;'.$pos1.':0px;height:16px;">';

    $panelRight = kefu_get_option('enbleNavlog') == "1" ? "-109" : "0";
    $isIn       = kefu_get_option('enbleNavlog') == "1" ? "true" : "false";
    $kefuHtml  .= '<div id="kefu-kefuDv" style="'.$pos1.':'.$panelRight.'px;position:fixed;"><script>var isIn = '.$isIn.';var isLeft="'.$pos1.'";</script>';


    if(kefu_get_option('enbleNavlog')=="1"){
        $kefuHtml .= '<table><tr>';
        if( kefu_get_option('pos') == "2" ){
            $kefuHtml .= '<td id="navLog"><img src="'.plugins_url('kefu/asset/images/open_im.png').'" id="imgNav"></td><td>';
        }else{
            $kefuHtml .= '<td>';
        }
    }

    $kefuHtml .= '<table id="__01" width="105" class="customer-list" style="min-width:105px" border="0" cellpadding="0" cellspacing="0">';

    $telNo = kefu_get_option('telNo');
    if( !empty($telNo) ){
        $kefuHtml .= '<tr><td><div class="kefu1">服务热线：</div></td></tr>';
        $kefuHtml .= '<tr><td><div class="telNo" id="txtTelNo"><a href="tel:'. $telNo .'">'.$telNo.'</a></div></td></tr>';
    }

    $email = kefu_get_option('email');
    if( !empty($email) ){
        $kefuHtml .= '<tr><td><div class="kefu1">电子邮箱：</div></td></tr>';
        $kefuHtml .= '<tr><td><div class="telNo" id="txtEmail"><a href="mailto:'. $email .'">'.$email.'</a></div></td></tr>';
    }   

    $kefuHtml .='<tr><td><div class="kefu3"></div></td></tr>';

    $qTitle    = kefu_get_option('qqTitle');

    //输出QQ
    if( !empty($qs) ){
        for($i=0;$i<count($qs);$i++){
            if ($icoSize2=="1") {
                $kefuHtml .= getQQHtml($qs[$i],$qTitle[$i],$i);
            }else if($icoSize2=="2"){
                $kefuHtml .= getQQHtmlSmall($qs[$i],$qTitle[$i]);
            }else if($icoSize2=="3"){
                $kefuHtml .= getQQHtmlstandard($qs[$i],$qTitle[$i]);
            }
        }
        $kefuHtml .= '<tr><td><div class="line"></div></td></tr>';
    }

    //输出旺旺
    $wangwangs     = kefu_get_option('wangwang');
    $wangwangNames = kefu_get_option('wangwangTitles');
    $icoSizeWang   = kefu_get_option('icoSizeWang');
    if( !empty($wangwangs) ){
        for( $i=0; $i<count($wangwangs); $i++ ){
            $kefuHtml .= getWangHtml( $wangwangs[$i], $wangwangNames[$i], $icoSizeWang );
        }
    }

    // 输出skype
    $skypes       = kefu_get_option('skype');
    $skypeNames   = kefu_get_option('skypeTitles');
    $icoSizeSkype = kefu_get_option('icoSizeSkype');
    if( !empty($skypeNames) ){
        for( $i=0; $i<count($skypeNames); $i++ ){
            $kefuHtml .= getSkypetml( $skypes[$i], $skypeNames[$i], $icoSizeSkype );
        }
    }

    //输出国际旺旺
    $wangwangInter      = kefu_get_option('wangwangInter');
    $wangwangInterNames = kefu_get_option('wangwangInterTitles');
    if( !empty($wangwangs) ){
        for($i=0;$i<count($wangwangInter);$i++){
            $kefuHtml .= getWangwangInterHtml($wangwangInter[$i],$wangwangInterNames[$i]);
        }
        $kefuHtml .= '<tr><td><div class="line"></div></td></tr>';
    }

    if( kefu_get_option('Enable_qq_Backup')=="1" ){
        if(kefu_get_option('qrCode')){
            $kefuHtml .= '<tr><td><div class="qq-kefu-fun-box"><a class="qq-kefu-qrCode" id="qq-kefu-qrCode" href="javascript:;"></a><a class="qq-kefu-backUp-2" id="qq-kefu-backUp" onclick="backUp()" href="javascript:;"></a><div class="kefu-qrcode-box" pos="'.kefu_get_option('pos').'"><img  width="100%" src="'.kefu_get_option('qrCode').'"></div></div></td></tr>';
        }else{
            $kefuHtml .= '<tr><td><div class="qq-kefu-fun-box"><a class="qq-kefu-backUp" id="qq-kefu-backUp" onclick="backUp()" href="javascript:;"></a></div></td></tr>';
        }
    }else if(kefu_get_option('qrCode')){
        $kefuHtml .= '<tr><td><div class="qq-kefu-fun-box"><a class="qq-kefu-qrCode-2" id="qq-kefu-qrCode" href="javascript:;"></a><div class="kefu-qrcode-box" pos="'.kefu_get_option('pos').'"><img  width="100%" src="'.kefu_get_option('qrCode').'"></div></div></td></tr>';
    }
    $kefuHtml .= '</table>';

    if( kefu_get_option('enbleNavlog') == "1" ){
        if( kefu_get_option('pos') == "2" ){
            $kefuHtml .= '</td></tr></table>';
        }else{
            $kefuHtml .= '</td><td id="navLog"  id="imgNav"><img src="'.plugins_url('kefu/asset/images/open_im.png').'" id="imgNav"></td></tr></table>';
        }
    }

    $kefuHtml .= '</div></div>';	

    if( !empty($telNo) ){
        $kefuHtml .= '<script>window.document.getElementById("txtTelNo").onclick=function(){window.prompt("客服电话","'.$telNo.'")}</script>';
    }
    $kefuHtml .='<script src="'.plugins_url('kefu/asset/js/front.js').'"></script>';
    $kefuHtml .='<!-- QQ客服代码结束-->';
    return $kefuHtml;
}



function kefuInit() {
    $theme = kefu_get_option('theme');
    if( kefu_get_option('enableIndex') ){
        if(is_front_page() && $theme == 1){
        echo kefuInit1();
        } else if(is_front_page() && $theme == 2){
            echo kefuInitModern();
        }
    }

    if( kefu_get_option('enableSingle') ){
        if(!is_front_page() && $theme == 1){
            echo kefuInit1();
        }else if(!is_front_page() && $theme == 2){
            echo kefuInitModern();
        }
    }
}



/*
function qqshortcode() {
    $theme = kefu_get_option('theme');
    if ($theme == 1) {
        return kefuInit1();
    }elseif($theme == 2){
        return kefuInitModern();
    }
}
add_shortcode('kefu', 'qqshortcode');
*/




if ( kefu_get_option('enable') ) {
    add_action( 'get_footer', 'kefuInit' );
}




