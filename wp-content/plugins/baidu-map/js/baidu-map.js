/*
* @Last Modified time: 2017-08-29
*/

// 清除table的类名
function clearTableCss(tag) {
	var table = document.querySelectorAll(tag);
	for (var i=0; i<table.length; i++  ){
		table[i].setAttribute('class','');
	}
}

function BaiduMap(json) {
	var map   = new BMap.Map(json.id);
	var point = new BMap.Point(json.lng, json.lat);

	map.centerAndZoom(point, 16); // 初始化放大倍数

	if (json.disable_dragging == 1) {
		map.disableScrollWheelZoom(); // 禁用鼠标滚轮放大缩小
		map.disableDragging();        // 禁止拖拽
		map.disableContinuousZoom();  // 禁用连续缩放效果
		map.disablePinchToZoom();     // 禁用双指操作缩放
	} else {
		map.enableScrollWheelZoom(true); // 鼠标滚轮放大缩小
		map.enableDragging();            // 允许拖拽
		map.enableContinuousZoom();      // 启用连续缩放效果
		map.enablePinchToZoom();         // 启用双指操作缩放
	}

	if (json.control == 1) {
		map.addControl( new BMap.ScaleControl({anchor: BMAP_ANCHOR_TOP_LEFT}) ); // 左上角，添加比例尺
		map.addControl( new BMap.NavigationControl() );                          // 左上角，添加默认缩放平移控件
		map.addControl( new BMap.NavigationControl({anchor: BMAP_ANCHOR_TOP_RIGHT, type: BMAP_NAVIGATION_CONTROL_SMALL}) );  // 右上角，包含平移和缩放按钮
	}
	
	// 是否自定义图标
	if (json.icon) {
		var myIcon = new BMap.Icon(json.icon, new BMap.Size(100,100));
		var marker = new BMap.Marker(point,{icon:myIcon});  // 创建标注
	} else {
		var marker = new BMap.Marker(point); // 创建标注
	}


	if (json.animation == 1) {
		marker.setAnimation(BMAP_ANIMATION_BOUNCE); // 跳动的动画
	}

	map.addOverlay(marker);      // 将标注添加到地图中

	var content = '';

	// 是否创建检索信息窗口对象
	if (json.windows == 1) {
		content += '<div style="margin:0;line-height:20px;padding:2px;">';
		if (json.image) {
			content += '<img src="'+ json.image +'" alt="'+ json.title +'" style="float:right;zoom:1;overflow:hidden;width:100px;height:100px;margin-left:3px;"/>';
		}
		if (json.info) {
			content += json.info + '<br/>';
		}
		if (json.address) {
			content += json.address + '<br/>';
		}
		if (json.email) {
			content += json.email + '<br/>';
		}
		if (json.phone) {
			content += json.phone + '<br/>';
		}
		if (json.url) {
			content += json.url + '<br/>';
		}
		content += '</div>';
		var searchInfoWindow = null;
		searchInfoWindow = new BMapLib.SearchInfoWindow(map, content, {
				title  : json.title,      //标题
				width  : 300,             //宽度
				//height : 105,           //高度
				panel  : "panel",         //检索结果面板
				enableAutoPan : true,     //自动平移
				searchTypes   :[
					BMAPLIB_TAB_SEARCH,   //周边检索
					BMAPLIB_TAB_TO_HERE,  //到这里去
					BMAPLIB_TAB_FROM_HERE //从这里出发
				]
		});

		marker.addEventListener("click", function(e){
			searchInfoWindow.open(marker);
		});

		// 默认打开
		searchInfoWindow.open(marker);

	} else {
		content += "<h4 style='margin:0 0 5px 0;padding:0.2em 0'>"+ json.title +"</h4>";
		if (json.image) {
			content += "<img style='float:right;margin:4px' id='baidu-map-img' src='"+ json.image +"' width='100' height='100' title='"+ json.title +"'/>"
		}
		if (json.info) {
			content += "<p style='margin:0;line-height:1.5;font-size:13px;'>"+ json.info +"</p>"
		}
		if (json.address) {
			content += "<p style='margin:0;line-height:1.5;font-size:13px;'>"+ json.address +"</p>"
		}
		if (json.email) {
			content += "<p style='margin:0;line-height:1.5;font-size:13px;'>"+ json.email +"</p>"
		}
		if (json.phone) {
			content += "<p style='margin:0;line-height:1.5;font-size:13px;'>"+ json.phone +"</p>"
		}
		if (json.url) {
			content += "<p style='margin:0;line-height:1.5;font-size:13px;'>"+ json.url +"</p>"
		}
			
		var infoWindow = new BMap.InfoWindow(content);  // 创建信息窗口对象
		marker.addEventListener("click", function(){          
		   this.openInfoWindow(infoWindow);
		   //图片加载完毕重绘infowindow
		   if (json.image) {
			   document.getElementById('baidu-map-img').onload = function (){
				   infoWindow.redraw();   //防止在网速较慢，图片未加载时，生成的信息框高度比图片的总高度小，导致图片部分被隐藏
			   }
		   }
		});

		// 默认打开
		map.openInfoWindow(infoWindow,point);
	}


	if (json.style) {
		map.setMapStyle({style:json.style});
	}

	// 清除table的类名
	setTimeout( function(){
		clearTableCss('#' + json.id + ' table')
	}, 2000 );
	//setTimeout( "document.querySelector('#" + json.id + " table').className = '';", 5000 );
}

