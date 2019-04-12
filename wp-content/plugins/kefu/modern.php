<?php
/**
 * 取自定义图标（现代风格）
 */
function getIcon($iconTitle, $iconUrl, $iconImg, $iconTarget){
	if ( !empty($iconImg) ) {
		if(!empty($iconTitle)){
			return '<div class="kefu-cus-phone">
	        			<a target="'.$iconTarget.'" href="'.$iconUrl.'"><img src="'.$iconImg.'" width="100%"></a>
				        <div class="kefu-cus-list-box">
				            <div class="kefu-cus-list">
				            	<ul>
				            		<li>
				                		<a target="'.$iconTarget.'" style="display:block; padding:10px 0; text-align:center;" href="'.$iconUrl.'">'.$iconTitle.'</a>
				                	</li>
				                </ul>
				            </div>
				        </div>
    				</div>';
		}else{
			return '<div class="kefu-cus-phone">
	        			<a target="'.$iconTarget.'" href="'.$iconUrl.'"><img src="'.$iconImg.'" width="100%"></a>
    				</div>';
		}
	}
}

/**
 * QQ图标（现代风格）
 */
function getQQModernHtml($q1, $qqTitle1){
	if( !empty($q1) ){
		if( $qqTitle1 == '' ){
			return '<li><a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin='.$q1.'&site=qq&menu=yes"><img src="http://wpa.qq.com/pa?p=2:'.$q1.':41"  style="vertical-align:middle"  alt="点击这里给我发消息" title="点击这里给我发消息"></a></li>';
		}else{
			return '<li><p class="wangwang-names">'.$qqTitle1.'</p><a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin='.$q1.'&site=qq&menu=yes"><img src="http://wpa.qq.com/pa?p=2:'.$q1.':41"  style="vertical-align:middle"  alt="点击这里给我发消息" title="点击这里给我发消息"></a></li>';
		}
	}
}
function getQQModernSmall($q1, $qqTitle1){
	if( !empty($q1) ){
		if( empty($qqTitle1) ){
			$qqTitle1 = $q1;
		} 
		return '<li><a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin='.$q1.'&site=qq&menu=yes"><img src="http://wpa.qq.com/pa?p=2:'.$q1.':52"  style="vertical-align:middle" > '.$qqTitle1.'</a></li>';
	}
}

/**
 * 旺旺图标（现代风格）
 */
function getWangModernHtml($wang1, $wangwangNames, $size){
	if( !empty($wang1) ){
	   $wang = urlencode($wang1);
	   if($size == "1"){
			if ($wangwangNames == '') {
				return '<li><a target="_blank" href="http://amos.im.alisoft.com/msg.aw?v=2&uid='.$wang.'&site=cntaobao&s='.$size.'&charset=utf-8" ><img border="0" src="http://amos.im.alisoft.com/online.aw?v=2&uid='.$wang.'&site=cntaobao&s='.$size.'&charset=utf-8" alt="点击这里给我发消息" style="vertical-align:middle;" /></a></li>';
			}else{
				return '<li><p class="wangwang-names">'.$wangwangNames.'</p><a target="_blank" href="http://amos.im.alisoft.com/msg.aw?v=2&uid='.$wang.'&site=cntaobao&s='.$size.'&charset=utf-8" ><img border="0" src="http://amos.im.alisoft.com/online.aw?v=2&uid='.$wang.'&site=cntaobao&s='.$size.'&charset=utf-8" alt="点击这里给我发消息" style="vertical-align:middle;" /></a></li>';
			}
	   }else{
			if ($wangwangNames == '') {
				return '<li><a target="_blank" href="http://amos.im.alisoft.com/msg.aw?v=2&uid='.$wang.'&site=cntaobao&s='.$size.'&charset=utf-8" ><img border="0" src="http://amos.im.alisoft.com/online.aw?v=2&uid='.$wang.'&site=cntaobao&s='.$size.'&charset=utf-8" alt="点击这里给我发消息" style="vertical-align:middle;" />'.$wang1.'</a></li>';
			}else{
				return '<li><a target="_blank" href="http://amos.im.alisoft.com/msg.aw?v=2&uid='.$wang.'&site=cntaobao&s='.$size.'&charset=utf-8" ><img border="0" src="http://amos.im.alisoft.com/online.aw?v=2&uid='.$wang.'&site=cntaobao&s='.$size.'&charset=utf-8" alt="点击这里给我发消息" style="vertical-align:middle;" />'.$wangwangNames.'</a></li>';
			}
	   }
	}

}


/**
 * skype图标（现代风格）
 */
 function getSkypeModernHtml($skype, $name, $size){
	$skypeImg = plugins_url( 'asset/images/skype-standard.png', __FILE__ );
	if( !empty($skype) ){
	   $wang = urlencode($skype);
	   if($size == "1"){
			if ($name == '') {
				return '<li><a target="_blank" href="skype:'.$skype.'?call" ><img border="0" src="'.$skypeImg.'" alt="点击这里给我发消息" style="vertical-align:middle;" /></a></li>';
			}else{
				return '<li><p class="wangwang-names">'.$name.'</p><a target="_blank" href="skype:'.$skype.'?call" ><img border="0" src="'.$skypeImg.'" alt="点击这里给我发消息" style="vertical-align:middle;" /></a></li>';
			}
	   }else{
			if ($name == '') {
				return '<li><a target="_blank" href="skype:'.$skype.'?call" ><img border="0" src="'.$skypeImg.'" alt="点击这里给我发消息" style="vertical-align:middle;" />'.$skype.'</a></li>';
			}else{
				return '<li><a target="_blank" href="skype:'.$skype.'?call" ><img border="0" src="'.$skypeImg.'" alt="点击这里给我发消息" style="vertical-align:middle;" />'.$name.'</a></li>';
			}
	   }
	}

}

/**
 * 客服初始化
 */
function kefuInitModern(){
	$icoSize2         = kefu_get_option('icoSize');
	$qqdisplay        = 'style="display:none;"';
	$wangwangdisplay  = 'style="display:none;"';
	$skypedisplay     = 'style="display:none;"';
	$iconColor        = kefu_get_option('iconcolor');
	$backgroundColor  = kefu_get_option('backgroundcolor');
	$hiconColor       = kefu_get_option('iconcolorhover');
	$hbackgroundColor = kefu_get_option('backgroundcolorhover');
	$Enable_mobile    = kefu_get_option('Enable_mobile');

	$style  = '';//添加自定义样式
	$style .= '<style type="text/css">';
	$style .= '#kefu-cus-box > div > a{';
	if (!empty($iconColor)){
		$style .= 'color:'.$iconColor.';';
	}
	if (!empty($backgroundColor)){
		$style .= 'background-color:'.$backgroundColor.';';
	}
	$style .= '}';

	if ($Enable_mobile) {
		$style .= '@media screen and (max-width:450px){
					#kefu-cus-box{-webkit-transition: all 0.6s;-ms-transition: all 0.6s;-moz-transition: all 0.6s; -webkit-transform:translate(100px,0);-moz-transform:translate(100px,0);-ms-transform:translate(100px,0);opacity:0;
					}
					#kefu-mobile-cus{display:block;}
		}';
	}
	$style .= '#kefu-cus-box > div > a:hover{';
	if (!empty($hiconColor)){
		$style .= 'color:'.$hiconColor.';';
	}
	if (!empty($hbackgroundColor)){
		$style .= 'background-color:'.$hbackgroundColor.';';
	}	
	$style .= '}';
	$style .= '</style>';


	$qs        = kefu_get_option('qq');
	$wangwangs = kefu_get_option('wangwang');
	if ( !empty($qs) ) {
		$qqdisplay = 'style="display:block;"';
	}
	if ( !empty($wangwangs) ) {
		$wangwangdisplay = 'style="display:block;"';
	}
	$kefuHtml  = '';
	$kefuHtml .= '<!-- QQ客服代码开始--><link rel="stylesheet" href="'.plugins_url('kefu/asset/css/modern.css').'" type="text/css" media="screen" /><link rel="stylesheet" href="'.plugins_url('kefu/asset/css/kefuicon.css').'" type="text/css" media="screen" /><script type="text/javascript" src="'.plugins_url('kefu/asset/js/front.js').'"></script>';
	$kefuHtml .= $style;
	$bottom    = kefu_get_option('bottom');

	//手机端客服图标
	if ($Enable_mobile){
		$kefuHtml .='<a id="kefu-mobile-cus" class="kefuicon kefuicon-SER" href="javascript:;" style="bottom:'.$bottom.'px;"></a>';
	}

	//添加移动端遮罩
	if ($Enable_mobile) {
		$kefuHtml .= '<div id="kefu-mobile-cus-mask"></div>';
	}

	$kefuHtml .= '<div id="kefu-cus-box" style="bottom:'.$bottom.'px;">';

	//自定义图标开始
	kefu_get_option('iconTarget') == "1" ? $iconTarget = "_self" : $iconTarget = "_blank";

	$iconTitle = kefu_get_option('iconTitle');
	$iconUrl   = kefu_get_option('iconUrl');
	$iconImg   = kefu_get_option('iconImg');

	if( isset($iconImg) && !empty($iconImg) ){
		for($i=0;$i<count($iconImg);$i++){
			$kefuHtml .= getIcon($iconTitle[$i],$iconUrl[$i],$iconImg[$i],$iconTarget);
		}
	}

	//客服电话开始
	$telNo = kefu_get_option('telNo');
	if (!empty($telNo)) {
		$kefuHtml .= '<div class="kefu-cus-phone">
			<a href="javascript:;" class="kefuicon kefuicon-dianhua"></a>
			<div class="kefu-cus-list-box">
				<div class="kefu-cus-list">
					<ul>
						<li>
							<a style="display:block; padding:10px 0; font-size:12px;" href="tel:'.$telNo.'">'.$telNo.'</a>
						</li>
					</ul>
				</div>
			</div>
		</div>';
	}

	//邮箱开始
	$email = kefu_get_option('email');
	if (!empty($email)) {
		$kefuHtml .= '<div class="kefu-cus-email">
			<a href="javascript:;" class="kefuicon kefuicon-email"></a>
			<div class="kefu-cus-list-box">
				<div class="kefu-cus-list">
					<ul>
						<li>
							<a style="display:block; padding:10px 0; font-size:12px;" href="mailto:'.$email.'">'.$email.'</a>
						</li>
					</ul>
				</div>
			</div>
		</div>';
	}	

	// QQ客服
	$kefuHtml.='<div class="kefu-cus-qq" '.$qqdisplay.'>
				<a href="javascript:;" class="kefuicon kefuicon-qqxian"></a>
				<div class="kefu-cus-list-box">
					<div class="kefu-cus-list">
						<ul>';

	$qTitle = kefu_get_option('qqTitle');
	if( !empty($qs) ){
		for($i=0;$i<count($qs);$i++){
			if ($icoSize2=="1" || $icoSize2=="3") {
				$kefuHtml .= getQQModernHtml($qs[$i],$qTitle[$i],$i);
				}else if($icoSize2=="2"){
				$kefuHtml .= getQQModernSmall($qs[$i],$qTitle[$i]);
			}
		}
	}
	
	$kefuHtml.='</ul>
				</div>
			</div>
		</div>';
// QQ客服结束


// 旺旺客服开始
	$kefuHtml .= '<div class="kefu-cus-wangwang"'.$wangwangdisplay.'>
			<a href="javascript:;" class="kefuicon kefuicon-wangwangxian"></a>
			<div class="kefu-cus-list-box">
				<div class="kefu-cus-list">
					<ul>';
	$wangwangNames = kefu_get_option('wangwangTitles');
	$icoSizeWang   = kefu_get_option('icoSizeWang');
	if( !empty($wangwangs) ){
		for( $i=0; $i<count($wangwangs); $i++ ){
			$kefuHtml .= getWangModernHtml($wangwangs[$i], $wangwangNames[$i], $icoSizeWang);
		}
	}
	$kefuHtml.='</ul>
				</div>
			</div>
		</div>';
// 旺旺客服结束

// Skype开始
$skypes = kefu_get_option('skype');
if ( !empty($skypes) ) {
	$skypedisplay = 'style="display:block;"';
}
	$kefuHtml .= '<div class="kefu-cus-skype"'.$skypedisplay.'>
	<a href="javascript:;" class="kefuicon kefuicon-skype"></a>
	<div class="kefu-cus-list-box">
		<div class="kefu-cus-list">
			<ul>';
	$skypeNames   = kefu_get_option('skypeTitles');
	$icoSizeSkype = kefu_get_option('icoSizeSkype');
	if( !empty($skypes) ){
	for( $i=0; $i<count($skypes); $i++ ){
		$kefuHtml .= getSkypeModernHtml($skypes[$i], $skypeNames[$i], $icoSizeSkype);
	}
	}
	$kefuHtml.='</ul>
		</div>
	</div>
	</div>';
// Skype结束

//输出二维码
	$erweimaSrc = kefu_get_option('qrCode');
	if (!empty($erweimaSrc)) {
		$kefuHtml.='<div class="kefu-cus-erweima">
				<a href="javascript:;" class="kefuicon kefuicon-erweima"></a>
				<div class="kefu-cus-list-box kefu-erweima">
					<div class="kefu-cus-list">';
		$kefuHtml.='<img width="200" src="'.$erweimaSrc.'">';
		$kefuHtml.='</div>
				</div>
			</div>';
	}
//输出二维码结束

	if (kefu_get_option('Enable_qq_Backup')=="1") {
		$kefuHtml.= '<div class="kefu-cus-top kefuicon">
			<a href="javascript:scroll(0,0);" class="kefuicon kefuicon-topxian"></a>
		</div>';
	}
	$kefuHtml.='</div>';
	return $kefuHtml;
}

