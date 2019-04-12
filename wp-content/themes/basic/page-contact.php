<?php
/*
 * Template Name:模板-联系我们
 */
?>
<?php get_header(); ?>
<div class="v2_banner">

    <div id="slidershow" class="carousel slide">

        <!--<ol class="carousel-indicators">
            <li class="active" data-target="#slidershow" data-slide-to="0"></li>
        </ol>-->

        <div class="carousel-inner">
            <?php 
                $banners = rwmb_meta('page_contact_banners');
                foreach ($banners as $item):
            ?>
            <div class="item active">
                    <img src="<?php echo $item['full_url']; ?>" alt="">
            </div>
            <?php endforeach; ?>
        </div>

    </div>

</div>

        <section class="sidebar-v2__section">

            <div class="section__head">
                <div class="navbar sidebar-v2">
                    <div class="container-fluid" id="sidebar-v2__accordion">
                        <div class="navbar-header   ">

                            <h1 class="dropdown-toggle sidebar-v2__h1 btn " data-toggle="collapse" data-target="#sidebar-v2__list3" data-parent="#sidebar-v2__accordion">
                                <button type="button" disabled="disabled"></button>
                                <span>
                                    <?php
                                        //$current_term_id = get_queried_object_id();
                                        //$term = get_term($current_term_id);
                                        echo $post->post_title;
                                    ?>
                                </span>
                            </h1>

                        </div>

                        <div class="panel">	

                            <div class="collapse navbar-collapse" id="sidebar-v2__list2">
                                <!--<ul class="nav navbar-nav navbar-right" id="collapseTwo">

                                    <li class="on"><a href="../about/">二级栏目</a></li>

                                    <li class=""><a href="../about/show.php?lang=cn&id=12" >公司简介</a></li>

                                    <li class=""><a href="../about/show.php?lang=cn&id=13" >企业文化</a></li>

                                    <li class=""><a href="../about/show.php?lang=cn&id=14" >公司架构</a></li>

                                    <li class=""><a href="../about/show.php?lang=cn&id=9" >联系我们</a></li>

                                </ul>-->
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </section>

        <div class="met_clear"></div>

        <article class="sidebar-v2__article">
            <div class="met_article">


                <div class="met_editor met_module1">
                    <div>
                        <?php echo wpautop(rwmb_meta('page_contact_content')); ?>
                    </div>
                    <div class="clear"></div>
                </div>

            </div>
            <div style="width: 100%; height: 500px; margin-bottom:30px;" id="allmap"></div>
        </article>
        <script src="<?php bloginfo('template_url'); ?>/js/jquery-1.7.2.min.js" type="text/javascript"></script>
        <script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=67jMQ5DmYTe1TLMBKFUTcZAR">
        </script>
        <script type="text/javascript">
                 $(function () {
                ShowMap('<?php echo rwmb_meta('page_contact_jingdu'); ?>,<?php echo rwmb_meta('page_contact_weidu'); ?>', '<?php echo rwmb_meta('page_contact_map_name'); ?>', '<?php echo rwmb_meta('page_contact_map_address'); ?>',
                '<?php echo rwmb_meta('page_contact_map_phone'); ?>', '<?php echo rwmb_meta('page_contact_map_phone'); ?>', '17');
            })
            function getInfo(id) {
		$.ajax({
			type: "POST",
			url: "WebUserControl/Contact/GetInfo.ashx",
			cache: false,
			async: false,
			data: { ID: id },
			success: function (data) {
				data = eval(data);
				var length = data.length;
				if (length > 0) {
					ShowMap(data[0]["Image"], data[0]["NewsTitle"], data[0]["Address"], data[0]["Phone"], data[0]["NewsTags"], data[0]["NewsNum"]);
				}
			}
		});
	}
	function ShowMap(zuobiao, name, addrsee, phone, chuanzhen, zoom) {
		var arrzuobiao = zuobiao.split(',');
		var map = new BMap.Map("allmap");
		map.centerAndZoom(new BMap.Point(arrzuobiao[0], arrzuobiao[1]), zoom);
		map.addControl(new BMap.NavigationControl());
		var marker = new BMap.Marker(new BMap.Point(arrzuobiao[0], arrzuobiao[1]));
		map.addOverlay(marker);
		var infoWindow = new BMap.InfoWindow('<p style="color: #bf0008;font-size:14px;">' + name + '</p><p>地址：' + addrsee + '</p><p>电话：' + phone + '</p>');
		marker.addEventListener("click", function () {
			this.openInfoWindow(infoWindow);
		});
		marker.openInfoWindow(infoWindow);
	}
        </script>            
        <div class="met_clear"></div>
    </section>
    <?php get_footer(); ?>