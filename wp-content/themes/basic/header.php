<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />

        <meta name="renderer" content="webkit">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />
        <meta name="generator" content="MetInfo 5.3.16" data-variable="http://mobantest.17uhui.com.cn/muban/res001/342/|cn|10001||10001|res001" />
 
        <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url'); ?>/css/swiper.css" />
        <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url'); ?>/css/metinfo.css" />
        <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url'); ?>/css/metinfo-v2.css" />
        <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url'); ?>/css/jquery.mmenu.all.css"/>
        <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url'); ?>/css/phone_menu.css"/>
        <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url'); ?>/css/cssreset.css"/>
        <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/index-style.css" type="text/css" />
        <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/pad.css" type="text/css" media="(max-width:1024px)">
        <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/phone.css" type="text/css" media="(max-width:640px)">
 
        <?php wp_seo();?>
        <?php
            $ico_img = of_get_option('_of_ico_logo');
        ?>
        <?php 
            if($ico_img){
        ?>
            <link href="<?php echo $ico_img; ?>" rel="shortcut icon" type="image/x-icon" />

        <?php }?>

    </head>
    <body>
        <!-- 选用mm套件，最大的内容区  -->
        <div id="page" >
            <!-- 移动端   网站头部  -->
            <div class="header" >
                <a href="#menu" class="btn-menu"></a>
                <?php echo get_bloginfo('name'); ?>
            </div>
            <!-- 移动端   网站头部  结束 --> 
            
            <!-- 正文区 -->
            <div class="content">
                
                <!-- pc端导航   -->
                
                <!--   头部  -->
                <header class="header-box" >
                    <div class="header-top">
                        <a href="index.html" class="nav-logo">
                            <?php 
                                $logo = of_get_option('_of_logo');
                                if(!empty($logo)): 
                            ?>
                              <img src="<?php echo $logo; ?>"/>
                            <?php endif; ?>
           
                            <h1 class="logo-text">
                                <strong><?php echo of_get_option('of_logo_name'); ?></strong><br />
                                <span><?php echo of_get_option('of_logo_name_slave'); ?></span>
                            </h1>
                        </a>
                        
                        <div class="header-top-right">
                            <div class="header-mobile header-infor">
                            <?php 
                                $logo = of_get_option('of_top_phone_img');
                                if(!empty($logo)): 
                            ?>
                              <img src="<?php echo $logo; ?>"/>
                            <?php endif; ?>
                                <div class="header-mobile-text header-infor-text">
                                    <strong>联系电话</strong><br />
                                    <span><?php echo of_get_option('of_top_phone'); ?></span>
                                </div>
                            </div>
                            <div class="header-email header-infor">
                            <?php 
                                $logo = of_get_option('of_top_email_img');
                                if(!empty($logo)): 
                            ?>
                              <img src="<?php echo $logo; ?>"/>
                            <?php endif; ?>
                                <div class="header-email-text header-infor-text">
                                    <strong>邮箱地址</strong><br />
                                    <span><?php echo of_get_option('of_top_email'); ?></span>
                                </div>
                            </div>
                            <form class="header-search-form" action="<?php echo getHomeUrl()?>">
                                
                                <input type="text" class="text" name="s" placeholder="输入关键词"/>
                                <button  class="btn" type="submit" /></button>
                            </form>

                          

     
                        </div>
                        
                        
                    </div>
                    
                    <nav class="pc-nav">
                        <ul class="pc-nav-in">

                            <?php wp_nav_menu(array('theme_location' => 'top-menu', 'depth' => '0', 'items_wrap' => '%3$s', 'container' => false, 'walker' => new walker_menu_top())); ?>

                        </ul>
                    </nav>
                    <?php wp_head(); ?>
                </header>
                <!-- pc端导航   end -->