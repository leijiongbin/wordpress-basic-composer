<link rel="stylesheet" href="../wp-content/plugins/baidu-map/css/modal.min.css?ver=1.1">
<div class="media-frame-title"> <h1>插入百度地图<span class="dashicons dashicons-arrow-down"></span></h1></div>
<button type="button" class="button-link media-modal-close"  onclick="tb_remove();" ><span class="media-modal-icon"><span class="screen-reader-text">关闭</span></span></button>
<div class="media-frame-content">
  <div class="attachments-browser">
    <div class="p_pof" id="e_cst1_menu">
      <div class="mtm">
      <div class="pl-content">
        <div id="bdmap"> 
          <div id="pl-box">
            <div class="pl-main basic-grey">
              <input type="hidden" id="map_id" value="map_<?php echo time(); ?>">
              <div class="form-control"><label>地图经度X：</label>  <input type="text" id="map_lng"><a href="http://api.map.baidu.com/lbsapi/creatmap/" target="_blank">取经纬度</a></div>  
              <div class="form-control"><label>地图纬度Y：</label>  <input type="text" id="map_lat"></div>  
              <div class="form-control"><label>地图高度：</label>  <input type="text" id="map_height"  value="450px"></div>
              <div class="form-control"><label>地图宽度：</label>  <input type="text" id="map_width" value="100%"></div>  
			  <div class="form-control"><label>指示点弹跳动画：</label>  <input type="checkbox" id="map_set_animation" value="1"></div>
			  <div class="form-control"><label>指示点图标：</label>  <input type="text" id="map_set_icon">大小:100x100</div>
			  <div class="form-control"><label>禁止拖拽地图：</label>  <input type="checkbox" id="map_disable_dragging" value="1"></div>
			  <div class="form-control"><label>添加工具条、比例尺控件：</label>  <input type="checkbox" id="map_add_control" value="1"></div>
			  <div class="form-control"><label>带检索功能窗口：</label>  <input type="checkbox" id="map_windows" value="1"></div>
			  <div class="form-control"><label>地图样式：</label>  
			  <select name="map_style" id="map_style">
			  <option value="">默认地图样式</option>
			  <option value="light">清新蓝风格</option>
			  <option value="dark">黑夜风格</option>
			  <option value="redalert">红色警戒风格</option>
			  <option value="googlelite">精简风格</option>
			  <option value="grassgreen">自然绿风格</option>
			  <option value="midnight">午夜蓝风格</option>
			  <option value="pink">浪漫粉风格</option>
			  <option value="darkgreen">青春绿风格</option>
			  <option value="bluish">清新蓝绿风格</option>
			  <option value="grayscale">高端灰风格</option>
			  <option value="hardedge">强边界风格</option>
			  </select>
			  <a href="http://lbsyun.baidu.com/custom/list.htm" target="_blank">个性化模板列表</a>
			  </div>
              <div style="margin-top:30px;"></div>
              <div class="form-control"><label>标题/名称：</label>  <input type="text" id="map_title"></div>
			  <div class="form-control"><label>简介：</label>   <textarea rows="3" id="map_info"></textarea></div>
			  <div class="form-control"><label>地址：</label>   <input type="text" id="map_address"></div>
              <div class="form-control"><label>Email：</label>    <input type="text" id="map_email"></div>  
              <div class="form-control"><label>电话：</label>    <input type="text" id="map_phone"></div> 
			  <div class="form-control"><label>网址：</label>    <input type="text" id="map_url"></div>
			  <div class="form-control"><label>图片：</label>   <input type="text" id="map_image">大小:100x100</div>
            </div>
          </div>
<script> 
;jQuery(function(a) {
    a("#pl-show").click(function() {
        a("#pl-box").show()
    }),
    a("#pl-close").click(function() {
        a("#pl-box").hide()
    }),
    a("#pl-box #map_address").on("blur",
    function(l) {
		var lng = a("#pl-box #map_lng").val(), lat = a("#pl-box #map_lat").val();
		if (lng || lat) {
			return false;
		}
        var o = a(this).val(),
        t = "http://api.map.baidu.com/geocoder/v2/?address=" + o + "&output=json&ak=" + baiduMapAK;
        a.ajax({
            url: t,
            dataType: "jsonp",
            jsonpCallback: "data",
            success: function(l) {
                "0" == l.status && l.result && (a("#pl-box #map_lng").val(l.result.location.lng), a("#pl-box #map_lat").val(l.result.location.lat))
            }
        })
    }),
    a("#baidumap-insert-btn").on("click",
    function() {
        var id = a("#pl-box #map_id").val(),
        w     = a("#pl-box #map_width").val(),
        h     = a("#pl-box #map_height").val(),
        lat   = a("#pl-box #map_lat").val(),
        lng   = a("#pl-box #map_lng").val(),
		anim  = 0,
		icon  = a("#pl-box #map_set_icon").val(),
		drag  = 0,
		cont  = 0,
		wind  = 0,
		style = a("#pl-box #map_style").val(),

        title = a("#pl-box #map_title").val(),
		info  = a("#pl-box #map_info").val(),
        add   = a("#pl-box #map_address").val(),
        email = a("#pl-box #map_email").val(),
        phone = a("#pl-box #map_phone").val(),
		url   = a("#pl-box #map_url").val(),
		image = a("#pl-box #map_image").val();
		
		if(a('#pl-box #map_set_animation').prop('checked')) anim  = 1;
		if(a('#pl-box #map_disable_dragging').prop('checked')) drag  = 1;
		if(a('#pl-box #map_add_control').prop('checked')) cont  = 1;
		if(a('#pl-box #map_windows').prop('checked')) wind  = 1;

        var d = '[baidu_map id="' + id + '" width="' + w + '" height="' + h + '" lat="' + lat + '" lng="' + lng + '" animation="' + anim + '" icon="' + icon + '" disable_dragging="' + drag + '" control="' + cont + '" windows="' + wind + '" style="' + style + '" title="' + title + '" info="' + info + '" address="' + add + '" email="' + email + '" phone="' + phone + '" url="' + url + '" image="' + image + '"]';
        tinymce.activeEditor.execCommand("mceInsertContent", !1, d), tb_remove();
    })
}); 
</script>

        </div>
      </div>
      </div>
    </div>
  </div>
 <div style="clear:both"></div>
 <button type="button" class="button button-primary button-large" id="baidumap-insert-btn">插入</button>
 </div>
</div>