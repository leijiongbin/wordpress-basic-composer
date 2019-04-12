<?php
/**
 * 管理表单提交处理
 */

$submit = isset($_POST['Submit']) ? trim ( $_POST['Submit'] ) : '';
if( $submit ) {
	if (isset( $_POST ['enable'] ) ) {		
		kefu_set_option ('enable', true );	
	} else {
		kefu_set_option ('enable', false );			
	}	
	kefu_set_option( 'enbleNavlog', isset ( $_POST ['enbleNavlog'] ) ? true : false );	

	if (isset ( $_POST ['theme'] )) {		
		kefu_set_option ( 'theme', $_POST ['theme'] );	
	}

	if (isset ( $_POST ['bottom'] )) {		
		kefu_set_option ( 'bottom', $_POST ['bottom'] );	
	}

	if (isset ( $_POST ['iconcolor'] )) {		
		kefu_set_option ( 'iconcolor', $_POST ['iconcolor'] );	
	}

	if (isset ( $_POST ['backgroundcolor'] )) {		
		kefu_set_option ( 'backgroundcolor', $_POST ['backgroundcolor'] );	
	}

	if (isset ( $_POST ['iconcolorhover'] )) {		
		kefu_set_option ( 'iconcolorhover', $_POST ['iconcolorhover'] );	
	}

	if (isset ( $_POST ['backgroundcolorhover'] )) {		
		kefu_set_option ( 'backgroundcolorhover', $_POST ['backgroundcolorhover'] );	
	}

	if (isset ( $_POST ['Enable_qq_Backup'] )) {		
		kefu_set_option ('Enable_qq_Backup', true );	
	} else {
		kefu_set_option ('Enable_qq_Backup', false );			
	}

	if (isset ( $_POST ['Enable_mobile'] )) {		
		kefu_set_option ('Enable_mobile', true );	
	} else {
		kefu_set_option ('Enable_mobile', false );			
	}

	if (isset ( $_POST ['enableIndex'] )) {		
		kefu_set_option ('enableIndex', true );	
	} else {
		kefu_set_option ('enableIndex', false );			
	}

	if (isset ( $_POST ['enableSingle'] )) {		
		kefu_set_option ('enableSingle', true );	
	} else {
		kefu_set_option ('enableSingle', false );			
	}

	if (isset ( $_POST ['telNo'] )) {		
		kefu_set_option ( 'telNo', $_POST ['telNo'] );	
	}

	if (isset ( $_POST ['email'] )) {		
		kefu_set_option ( 'email', $_POST ['email'] );	
	}

	if (isset ( $_POST ['qrCode'] )) {		
		kefu_set_option ( 'qrCode', $_POST ['qrCode'] );	
	}

	if (isset (  $_POST ['qq'] )) {
		kefu_set_option ( 'qq', $_POST ['qq'] );
	}else{
		kefu_set_option ( 'qq', "" );
	}

	if (isset ( $_POST ['wangwang'] )) {		
		kefu_set_option ( 'wangwang', $_POST ['wangwang'] );	
	}else{
		kefu_set_option ( 'wangwang', "" );
	}

	if (isset ( $_POST ['wangwangInter'] )) {		
		kefu_set_option ( 'wangwangInter', $_POST ['wangwangInter'] );	
	}else{
		kefu_set_option ( 'wangwangInter', "" );
	}

	if (isset ( $_POST ['icoSize'] )) {		
		kefu_set_option ( 'icoSize', $_POST ['icoSize'] );	
	}

	if (isset ( $_POST ['icoSizeWang'] )) {		
		kefu_set_option ( 'icoSizeWang', $_POST ['icoSizeWang'] );	
	}

	if (isset ( $_POST ['pos'] )) {		
		kefu_set_option ( 'pos', $_POST ['pos'] );	
	}
	
	if (isset ( $_POST ['iconTarget'] )) {		
		kefu_set_option ( 'iconTarget', $_POST ['iconTarget']  );	
	}

	if (isset ( $_POST ['iconImg'] )) {		
		kefu_set_option ( 'iconImg', $_POST ['iconImg'] );	
	}else{
		kefu_set_option ( 'iconImg', "" );
	}

	if (isset ( $_POST ['iconUrl'] )) {		
		kefu_set_option ( 'iconUrl', $_POST ['iconUrl']  );	
	}	

	if (isset ( $_POST ['iconTitle'] )) {		
		kefu_set_option ( 'iconTitle', $_POST ['iconTitle']  );	
	}	

	if (isset ( $_POST ['qqTitle'] )) {		
		kefu_set_option ( 'qqTitle', $_POST ['qqTitle']  );	
	}	

	if (isset ( $_POST ['qqTitle2'] )) {		
		kefu_set_option ( 'qqTitle2', $_POST ['qqTitle2'] );	
	}
	if (isset ( $_POST ['wangwangTitles'] )) {		
		kefu_set_option ( 'wangwangTitles', $_POST ['wangwangTitles'] );	
	}
	if (isset ( $_POST ['wangwangInterTitles'] )) {		
		kefu_set_option ( 'wangwangInterTitles', $_POST ['wangwangInterTitles'] );	
	}	

	if (isset ( $_POST ['qq3'] )) {		
		kefu_set_option ( 'qq3', $_POST ['qq3'] );	
	}

	if (isset ( $_POST ['qqtop'] )) {		
		kefu_set_option ( 'qqtop', $_POST ['qqtop'] );	
	}

	if ( isset( $_POST ['skype'] ) ) {		
		kefu_set_option( 'skype', $_POST['skype'] );	
	}
	
	if ( isset( $_POST ['skypeTitles'] ) ) {		
		kefu_set_option( 'skypeTitles', $_POST['skypeTitles'] );	
	}

	if ( isset ( $_POST['icoSizeSkype'] ) ) {		
		kefu_set_option( 'icoSizeSkype', $_POST ['icoSizeSkype'] );	
	}
}

kefu_admin_html( get_option( 'kefu_options' ) );


/**
 * 管理界面的段落
 */
 function getSectionPre($title, $id, $diplay='none'){
	if ($id) {
		$id    = ' id="'.$id.'"';
		$class = ' kefu_tab'; 
	} else {
		$id    = '';
		$class = '';
	}

	if ( !$diplay || $diplay == 'none'  ) {
		return '<div class="kefu_section'.$class.'" style="display:none;"'.$id.'><div class="rm_title"><h3><img src="'.plugins_url("kefu/asset/images/clear.png").'" class="active" alt="">'.$title.'</h3><div class="clearfix"></div></div><div class="rm_options" style="display: block; ">';		
	}
	return '<div class="kefu_section'.$class.'"'.$id.'><div class="rm_title"><h3><img src="'.plugins_url("kefu/asset/images/clear.png").'" class="active" alt="">'.$title.'</h3><div class="clearfix"></div></div><div class="rm_options" style="display: block; ">';
}
function getSectionSuf(){
    return '</div></div>';
}

/**
 * 输出设置页HTMl
 * @param {Array} $options 配置项信息
 */
function kefu_admin_html($options) {
	$enable           = $options ['enable'] ? ' checked="true"' : '';	
	$Enable_qq_Backup = $options ['Enable_qq_Backup'] ? ' checked="true"' : '';	
	$Enable_mobile    = $options ['Enable_mobile'] ? ' checked="true"' : '';	
	$enbleNavlog      = $options ['enbleNavlog'] ? ' checked="true"' : '';	
	$enableIndex      = $options ['enableIndex'] ? ' checked="true"' : '';		
	$enableSingle     = $options ['enableSingle'] ? ' checked="true"' : '';

	$adminHtml  = '';	
	$adminHtml .='<link rel="stylesheet" href="'.plugins_url('kefu/asset/css/main.css').'" type="text/css" media="screen" />';
	$adminHtml .= '<div class=wrap id="qqAdmin">';
	$adminHtml .= '<div>';
	$adminHtml .= '<h3 class="qq-cus-title">在线客服设置</h3>';
	$adminHtml .= '<p class="kefu-update update-nag"></p>';
	$adminHtml .= '</div><div>';
	$adminHtml .= '<form method="post">';	


	// tab面板
	$adminHtml .= '
	<div style="clear:both;">
	<ul class="setting-set">
		<li style="background-color: rgb(0, 115, 170); color: rgb(255, 255, 255);" data-id="tab-general">基本设置</li>
		<li style="background-color: rgb(255, 255, 255); color: rgb(0, 0, 0);" data-id="tab-tel">客服电话</li>
		<li style="background-color: rgb(255, 255, 255); color: rgb(0, 0, 0);" data-id="tab-email">电子邮箱</li>
		<li style="background-color: rgb(255, 255, 255); color: rgb(0, 0, 0);" data-id="tab-qrcode">二维码图片</li>
		<li style="background-color: rgb(255, 255, 255); color: rgb(0, 0, 0);" data-id="tab-qq">QQ客服</li>
		<li style="background-color: rgb(255, 255, 255); color: rgb(0, 0, 0);" data-id="tab-wangwang">旺旺客服</li>
		<li style="background-color: rgb(255, 255, 255); color: rgb(0, 0, 0);" data-id="tab-skype">Skype</li>
		<li style="background-color: rgb(255, 255, 255); color: rgb(0, 0, 0);" data-id="tab-custom">自定义图标</li>
	</ul>
	</div>
	';

	$adminHtml .= getSectionPre('基本设置', 'tab-general', 'display');

	$adminHtml .= '<p><span class="qq-cus-label">启用在线客服:</span> <input type="checkbox" value="true" id="Enable_QQ" name="enable"' . $enable . '></p>';	
	$tradition  = '';

	$modern     = '';
	$options['theme'] == "1" ? $tradition = "checked" : $modern="checked";

	$adminHtml .= ' <p><span class="qq-cus-label">选择客服风格:</span> <input type="radio" name="theme" value="1" '.$tradition.' />传统风格  &nbsp;&nbsp;<input type="radio" name="theme" value="2" '.$modern.'/>现代风格 <span class="dtl">(现代风格不支持缩进，不支持页面左侧停靠，不支持QQ客服大图标形式)</span></p>';
	$adminHtml .= '<p><span class="qq-cus-label">显示回到顶部:</span> <input type="checkbox" value="true" id="Enable_qq_Backup" name="Enable_qq_Backup"' . $Enable_qq_Backup . '></p>';

	$adminHtml .= '<p class="qq-cus-modern"><span class="qq-cus-label">启用移动端样式:</span> <input type="checkbox" value="true" id="Enable_mobile" name="Enable_mobile"' . $Enable_mobile . '><span class="dtl">(启用后在移动端只显示一个客服按钮，点击后展开客服列表)</span></p>';

	$adminHtml .= '<p class="qq-cus-tradition"><span class="qq-cus-label">是否缩进客服框:</span> <input type="checkbox" value="true" id="enbleNavlog" name="enbleNavlog"' . $enbleNavlog . '><span class="dtl">(如果勾上,则页面只露一个客服头像,移上去后就会伸缩对话框,仅对传统风格有效)</span></p>';	

	$bsize = $options['pos'];
	$left  = '';
	$right = '';
	$options['pos'] == "1" ? $left = "checked" : $right = "checked";

	$adminHtml .= '<p class="qq-cus-tradition"><span class="qq-cus-label">客服框位置:</span> <input class="large-text code" id="QQ_top" style="width:40px" name="qqtop" value="' . stripslashes ( $options ['qqtop'] ) . '">% <span class="dtl">(设置传统风格客服框顶部与页面顶部的距离，单位是百分比)</span></p>';
	$adminHtml .= '<p class="qq-cus-modern"><span class="qq-cus-label">客服框位置:</span> <input class="large-text" id="bottom" style="width:40px" name="bottom" value="' . stripslashes ( $options ['bottom'] ) . '"> px <span class="dtl">(设置现代风格客服框底部与页面底部的距离，单位是像素)</span></p>';
	$adminHtml .= '<p class="qq-cus-modern"><span class="qq-cus-label">图标颜色:</span> <input class="large-text color-field" id="iconcolor" style="width:80px" name="iconcolor" value="' . stripslashes ( $options ['iconcolor'] ) . '"> <span class="dtl">(设置现代风格图标颜色)</span></p>';
	$adminHtml .= '<p class="qq-cus-modern"><span class="qq-cus-label">按钮背景色:</span> <input class="large-text color-field" id="backgroundcolor" style="width:80px" name="backgroundcolor" value="' . stripslashes ( $options ['backgroundcolor'] ) . '"> <span class="dtl">(设置现代风格按钮背景颜色)</span></p>';
	$adminHtml .= '<p class="qq-cus-modern"><span class="qq-cus-label">指向时图标颜色:</span> <input class="large-text color-field" id="iconcolorhover" style="width:80px" name="iconcolorhover" value="' . stripslashes ( $options ['iconcolorhover'] ) . '"> <span class="dtl">(设置现代风格鼠标指向时图标颜色)</span></p>';
	$adminHtml .= '<p class="qq-cus-modern"><span class="qq-cus-label">指向时按钮背景色:</span> <input class="large-text color-field" id="backgroundcolorhover" style="width:80px" name="backgroundcolorhover" value="' . stripslashes ( $options ['backgroundcolorhover'] ) . '"> <span class="dtl">(设置现代风格鼠标指向时按钮背景色)</span></p>';
	$adminHtml .= ' <p class="qq-cus-tradition"><span class="qq-cus-label">左右停靠:</span> <input type="radio" name="pos" value="1" '.$left.' />左  &nbsp;&nbsp;<input type="radio" name="pos" value="2" '.$right.'/>右</p>';

	$adminHtml .= '<span class="qq-cus-label">面板显示范围:</span> <input type="checkbox" name="enableIndex" ' . $enableIndex . '>首页  &nbsp;&nbsp;<input type="checkbox" name="enableSingle" ' . $enableSingle . '>内页';
	$adminHtml .= getSectionSuf();


	// 客服电话
	$adminHtml .= getSectionPre('客服电话', 'tab-tel');
	$adminHtml .= '<p><span class="qq-cus-label">客服电话:</span> <input class="large-text code" id="telno" style="width:226px" name="telNo" value="' . stripslashes ( $options ['telNo'] ) . '"> <span class="dtl">(留空则不显示)</span></p>';
	$adminHtml .= getSectionSuf();

	// 电子邮件
	$adminHtml .= getSectionPre('电子邮箱', 'tab-email');
	$adminHtml .= '<p><span class="qq-cus-label">电子邮箱:</span> <input class="large-text code" id="email" style="width:226px" name="email" value="' . stripslashes ( $options ['email'] ) . '"> <span class="dtl">(留空则不显示)</span></p>';
	$adminHtml .= getSectionSuf();

	// 二维码图片
	$adminHtml .= getSectionPre('二维码图片', 'tab-qrcode');
	$adminHtml .= '<p><span class="qq-cus-label">二维码图片地址:</span> <input class="large-text code" id="qrCode" style="width:400px" name="qrCode" value="' . stripslashes ( $options ['qrCode'] ) . '"><span class="dtl">(留空则不显示二维码，您可以去<a href="'.admin_url().'upload.php">多媒体</a>上传图片)</span></p>';
	$adminHtml .= getSectionSuf();


// QQ客服
	$adminHtml .= getSectionPre('QQ客服', 'tab-qq');

	$qs     = kefu_get_option('qq');
	$count1 = 0;
	$bsize  = $options['icoSize'];
	$sizeCk1 = $sizeCk2 = $sizeCk3 = '';

	if ($options['icoSize'] == 1) {
		$sizeCk1 ="checked";
	}else if($options['icoSize'] == 2){
		$sizeCk2 ="checked";
	}else if($options['icoSize'] == 3){
		$sizeCk3 ="checked";
	}

	$adminHtml.= '<p><span class="qq-cus-label">图标大小:</span> <input type="radio" name="icoSize" value="1" '.$sizeCk1.' />大图标&nbsp;&nbsp;<input type="radio" name="icoSize" value="2" '.$sizeCk2.'/>小图标&nbsp;&nbsp;<input type="radio" name="icoSize" value="3" '.$sizeCk3.'/>标准图标</P>';
	$adminHtml.= '<ul id="qqLi">';

	if( isset($qs) && !empty($qs) ){
	  	foreach($qs as $q){
			$adminHtml.= '<li>标题<input name="qqTitle[]" value="' . stripslashes ( $options ['qqTitle'][$count1] ) . '"><span class="dtl">(5个汉字之内，否则标题会换行，标准图标形式下不设置则不显示)</span> QQ号码<input class="large-text code" id="QQ_1" style="width:126px" name="qq[]"  value="' . stripslashes ( $options ['qq'][$count1] ) . '"> <input type="button" class="button btnDelQQ" value="删除此客服" ></li>';	
			$count1++;
	  	}
  	}

  $adminHtml .= '</ul><input id="btnAddQQ" class="button" type="button" value="增加QQ客服">';
  $adminHtml .= getSectionSuf();
// QQ客服 结束

  //旺旺
	$adminHtml .= getSectionPre('旺旺客服', 'tab-wangwang');
	$wangwangs = kefu_get_option('wangwang');
	$wangwangTitles = kefu_get_option('wangwangTitles');
	$count1  = 0;
	$sizeCkw = $sizeCkw2 = '';
	$options['icoSizeWang']=="1"?$sizeCkw ="checked":$sizeCkw2="checked";

	$adminHtml .= '<p><span class="qq-cus-label">图标大小:</span> <input type="radio" name="icoSizeWang" value="1" '.$sizeCkw.' />大图标&nbsp;&nbsp;<input type="radio" name="icoSizeWang" value="2" '.$sizeCkw2.'/>小图标<span class="dtl"></span></p>';
	$adminHtml .= '<ul id="wangwangLi">';

	if( isset($wangwangs) && !empty($wangwangs) ){
		foreach( $wangwangs as $w ){
			$adminHtml .= '<li>旺旺账号：<input name="wangwang[]" value="' . stripslashes ($w ) . '">  旺旺昵称：<input name="wangwangTitles[]" value="'.stripslashes ($wangwangTitles[$count1] ) .'"/><span class="dtl">(大图标时不设置则不显示，小图标时不设置则显示旺旺号。)</span><input type="button" class="button btnDelQQ" value="删除此客服" ></li>';	
			$count1++;
		}
	}

	$adminHtml .= '</ul><input id="btnAddWang" type="button" class="button" value="增加旺旺客服">';
	$adminHtml .= getSectionSuf();
  //旺旺 ed



  //旺旺国际 st wangwangInter
  /*
	$adminHtml .= getSectionPre('国际旺旺客服', 'tab-wangwangInter');

	$wangwangInter = kefu_get_option('wangwangInter');
	$count1        = 0;

	$adminHtml .= '<ul id="wangwangInterLi">';

	if(isset($wangwangInter)&&!empty($wangwangInter)){
		$wangwangInterTitles = kefu_get_option('wangwangInterTitles');
		$wwiCounts = 0;
		foreach($wangwangInter as $w){
			$adminHtml.= '<li><input name="wangwangInter[]" value="' . stripslashes ($w ) . '">  客服名称:<input name="wangwangInterTitles[]" value="' . stripslashes ($wangwangInterTitles[$wwiCounts] ) . '">  <input type="button" class="button btnDelQQ" value="删除此客服" ></li>';	
			$wwiCounts++;
		}
	  }
	  
	$adminHtml .= '</ul><input id="btnAddwangwangInter" class="button"  type="button" value="增加国际旺旺客服">';
	$adminHtml .= getSectionSuf();
  */
  //旺旺国际 ed


  //skype st
  $adminHtml  .= getSectionPre('Skype', 'tab-skype');
  $skypes      = kefu_get_option('skype');
  $skypeTitles = kefu_get_option('skypeTitles');
  $count1  = 0;
  $sizeCks = $sizeCks2 = '';
  $options['icoSizeSkype'] == "1" ? $sizeCks = "checked" : $sizeCks2 = "checked";

  $adminHtml .= '<p><span class="qq-cus-label">图标大小:</span> <input type="radio" name="icoSizeSkype" value="1" '.$sizeCks.' />大图标&nbsp;&nbsp;<input type="radio" name="icoSizeSkype" value="2" '.$sizeCks2.'/>小图标<span class="dtl"></span></p>';
  $adminHtml .= '<ul id="skypeLi">';

  if( isset($skypes) && !empty($skypes) ){
	  foreach( $skypes as $skype ){
		  $adminHtml .= '<li>账号：<input name="skype[]" value="' . stripslashes ($skype ) . '">  昵称：<input name="skypeTitles[]" value="'.stripslashes ($skypeTitles[$count1] ) .'"/><span class="dtl"></span><input type="button" class="button btnDelQQ" value="删除此客服" ></li>';	
		  $count1++;
	  }
  }

  $adminHtml .= '</ul><input id="btnAddSkype" type="button" class="button" value="增加Skype客服">';
  $adminHtml .= getSectionSuf();
  //skype ed


  //自定义图标
	$adminHtml .= getSectionPre('自定义图标（仅对现代风格有效）', 'tab-custom');
	
		$icons   = kefu_get_option('iconImg');
		$count0  = 0;
		$target1 = $target2 = '';
	
		$options['iconTarget']=="1" ? $target1 = "checked" : $target2 = "checked";
		$adminHtml .= '<p><span class="qq-cus-label">链接打开方式:</span> <input type="radio" name="iconTarget" value="1" '.$target1.' />当前窗口打开&nbsp;&nbsp;<input type="radio" name="iconTarget" value="2" '.$target2.'/>新标签/页面打开&nbsp;&nbsp;</P>';
		$adminHtml .= '<ul id="iconLi">';
	
		if( isset($icons) && !empty($icons) ){
			  foreach($icons as $i){
				$adminHtml.= '<li>
				<div class="kefuicon-item"><span class="kefuicon-title">图标标题</span><input style="width:400px" name="iconTitle[]" value="' . stripslashes ( $options ['iconTitle'][$count0] ) . '"><span class="dtl">(7个汉字之内，否则会换行)</span></div>
				<div class="kefuicon-item"><span class="kefuicon-title">图标链接</span><input class="large-text code" style="width:400px" name="iconUrl[]"  value="' . stripslashes ( $options ['iconUrl'][$count0] ) . '"><span class="dtl">(设置图标的跳转链接)</span></div>
				<div class="kefuicon-item"><span class="kefuicon-title">图标图片</span><input class="large-text code" style="width:400px" name="iconImg[]"  value="' . stripslashes ( $options ['iconImg'][$count0] ) . '"><span class="dtl">(输入图片地址，必须为透明的正方形图片，建议大小为40*40)</span></div>
				<input type="button" class="button btnDelIcon" value="删除此图标" ></li>';	
				$count0++;
			  }
		  }
	
		$adminHtml .= '</ul><input id="btnAddIcon" class="button" type="button" value="增加图标">';
		$adminHtml .= getSectionSuf();
	//自定义图标 结束 

	$adminHtml.= '<p class="submit"><input type="submit" class="button button-primary button-large" value="保存设置" name="Submit"></p>';	
	

	$adminHtml.= getSectionPre("注意事项", '', 'display');
	$adminHtml.='<ol>';
	$adminHtml.='<li>如果出现“QQ在线状态服务尚未启用”则参考 <a href="http://jingyan.baidu.com/article/b24f6c823425a586bfe5da1f.html" target="_blank">提示“QQ在线状态”服务尚未启用怎么办</a></li>';
	$adminHtml.='<li>客服QQ权限不要设置成"需要验证信息", 否则点击客服QQ时会提示需要加好友才能对话</li>';
	$adminHtml.='</ol>';
	$adminHtml.= getSectionSuf();


	$adminHtml.= '</div></fieldset>';	
	$adminHtml.= '</form>';	
	$adminHtml.= '';
	$adminHtml.= '<script src="'.plugins_url('kefu/asset/js/main.js').'"></script>';
	echo $adminHtml;
}