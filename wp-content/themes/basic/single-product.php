<?php get_header(); ?>
<div class="v2_banner">

    <div id="slidershow" class="carousel slide">

        <!--<ol class="carousel-indicators">
            <li class="active" data-target="#slidershow" data-slide-to="0"></li>
        </ol>-->

        <div class="carousel-inner">
            <?php
                $terms = get_the_terms($post->ID, 'product_tax');
                $cat_id = $terms[0]->term_id;
                $image_ids = get_term_meta( $cat_id, 'page_category_banners', false );
                $image = RWMB_Image_Field::file_info( $image_ids[0], array( 'size' => 'full' ) );
                //var_dump($image);
            ?>
            <div class="item active">
                    <img src="<?php echo $image['full_url']; ?>" alt="">
            </div>

        </div>

    </div>

</div>

<section class="sidebar-v2__section">

    <div class="section__head">
        <div class="navbar sidebar-v2">
            <div class="container-fluid" id="sidebar-v2__accordion">
                <div class="navbar-header   ">
                    <button type="button" class="navbar-toggle collapsed sidebar-v2__button btn" data-toggle="collapse" data-target="#sidebar-v2__list2" aria-expanded="false" data-parent="#sidebar-v2__accordion">
                        <span class="glyphicon glyphicon-menu-hamburger"></span>
                    </button>

                    <h1 class="dropdown-toggle sidebar-v2__h1 btn " data-toggle="collapse" data-target="#sidebar-v2__list3" data-parent="#sidebar-v2__accordion">
                        <button type="button" disabled="disabled"></button>
                        <span>
                            <?php
                                echo $terms[0]->name;
                            ?> 
                        </span>
                    </h1>

                </div>

                <div class="panel">	

                        <div class="collapse navbar-collapse" id="sidebar-v2__list2">
                            <ul class="nav navbar-nav navbar-right" id="collapseTwo">
                                <li class=""><a href="<?php echo get_page_link(93); ?>">二级栏目</a></li>
                                <?php
                                    $terms = get_terms(array('taxonomy' => 'product_tax','hide_empty'=>false,'orderby' => 'menu_order',));    
                                    foreach ($terms as  $key => $term):
                                ?>
                                <li class="<?php echo ($cat_id == $term->term_id) ? "on" : ""; ?>"><a href="<?php echo get_term_link($term->term_id); ?>"><?php echo $term->name; ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>

                </div>
            </div>
        </div>
    </div>

</section>

<div class="met_clear"></div>

<article class="sidebar-v2__article">
    <div class="met_article">


        <div id="showproduct">
            <div class='pshow v2-ac showproduct-v2__main'>
                <div class="col-sm-6 showproduct-v2__left">
                    <div class="met_box">
                        <div class="met_imgshowbox showproduct-v2">
                            <div class="my-simple-gallery slides tab-content">
                                <?php
                                    $images = rwmb_meta('post_product_image_gp');
                                    foreach ($images as $key => $item):
                                ?>
                                <figure class="tab-pane fade in <?php echo (0 == $key) ? "active" : ""; ?>" id="pro_<?php echo $key; ?>">
                                    <a href="<?php echo wp_get_attachment_url($item['post_product_image_gp_big_one'][0]); ?>">
                                        <img src="<?php echo wp_get_attachment_url($item['post_product_image_gp_big_one'][0]); ?>" alt="" />
                                    </a>
                                    <figcaption></figcaption>
                                </figure>
                                <?php endforeach; ?>

                            </div>
                        </div>                                                 
                        <ul class="nav nav-pills showproduct-v2__list" role="tablist">

                            <?php
                                $images = rwmb_meta('post_product_image_gp');
                                foreach ($images as $key => $item):
                            ?>
                            <li class="<?php echo (0 == $key) ? "active" : ""; ?>"><a href="#pro_<?php echo $key; ?>" role="tab" data-toggle="tab">
                                    <img src="<?php echo wp_get_attachment_url($item['post_product_image_gp_small_one'][0]); ?>" alt="" />
                                </a>
                            </li>                            
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
                
                <div class="col-sm-6 showproduct-v2__right">
                    <div class="showproduct-v2__para">
                        <h1 class='showproduct-v2__para__h1'><?php echo $post->post_title; ?></h1>

                        <ul class="v2-list showproduct-v2__para__ul">

                            <li><span>面积</span><?php echo rwmb_meta('post_product_area',null,$post->ID); ?>m²</li>

                            <li><span>地址</span><?php echo rwmb_meta('post_product_address',null,$post->ID); ?></li>

                            <li><span>风格</span><?php echo rwmb_meta('post_product_style',null,$post->ID); ?></li>

                        </ul>

                        <p class="desc">
                            <?php echo get_the_excerpt($post->ID); ?>
                        </p>
                    </div>
                </div>
            </div>
            <div class="met_clear"></div>

            <ol class="met_nav v2-ac showproduct-v2__nav">

                <li class="met_now"><a href="#mettab1">详细信息</a></li>

            </ol>
            <?php if ( have_posts() ) : while( have_posts() ) : the_post(); ?>
            <div class="met_nav_contbox">

                <div class="met_editor ">
                    <div>
                        <?php the_content(); ?>
                        <div id="metinfo_additional">
                            
                        </div>
                            
                    </div>
                    <div class="met_clear">
                        
                    </div>
                        
                </div>

            </div>
            <?php endwhile; endif; ?>

            <script src="<?php bloginfo('template_url'); ?>/js/sea.js" type="text/javascript"></script>
            <div class="met_tools">
                <div class="jiathis_style"><span class="jiathis_txt">分享到：</span><a class="jiathis_button_icons_1"></a><a class="jiathis_button_icons_2"></a><a class="jiathis_button_icons_3"></a><a class="jiathis_button_icons_4"></a><a href="http://www.jiathis.com/share" class="jiathis jiathis_txt jtico jtico_jiathis" target="_blank"></a></div><script type="text/javascript" src="http://v3.jiathis.com/code/jia.js?uid=1346378669840136" charset="utf-8"></script>
                <span class="met_Clicks met_none"><!--累计浏览次数--></span>
                <ul class="met_page">
                    <li class="met_page_preinfo"><?php previous_post_link('<span>上一条:</span>%link','%title'); ?></li>
                    <li class="met_page_next"><?php next_post_link('<span>下一条:</span>%link','%title'); ?></li>
                </ul>
            </div>

        </div>

    </div>
</article>
<div class="met_clear"></div>
</section>
<?php get_footer(); ?>