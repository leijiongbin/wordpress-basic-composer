<?php get_header(); ?>
        <div class="v2_banner">

            <div id="slidershow" class="carousel slide">

                <!--<ol class="carousel-indicators">
                    <li class="active" data-target="#slidershow" data-slide-to="0"></li>
                </ol>-->

                <div class="carousel-inner">
                    <?php
                        $terms = $terms = get_the_terms($post->ID, 'category');
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

        <?php
            $check_count = rwmb_meta('post_check_count') ?  rwmb_meta('post_check_count') : 1;
            $check_count += 1;
            //var_dump($post);
            //var_dump($check_count);
            //var_dump(rwmb_meta('post_check_count'));
            update_post_meta($post->ID, 'post_check_count', $check_count);
        ?>
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

                                    <!-- <li class="<?php echo ($cat_id == 1) ? "on" : ""; ?>"><a href="">二级栏目</a></li> -->
                                    <?php
                                        $terms = get_terms(array('taxonomy' => 'category','hide_empty'=>false,'orderby' => 'menu_order','exclude'=>1));    
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

                <?php if ( have_posts() ) : while( have_posts() ) : the_post(); ?>
                <section class="met_module2">
                    <h1 class="met_title"><?php the_title(); ?></h1>
                    <div class="met_infos">
                        <span class="met_time"><?php the_date('Y-m-d H:i:s'); ?></span>
                        <span class="met_source"><a href="<?php echo home_url(); ?>" title="<?php echo get_bloginfo('name'); ?>"><?php echo get_bloginfo('name'); ?></a></span>
                        <span class="met_hits">已读 <?php echo (rwmb_meta('post_check_count')) ? rwmb_meta('post_check_count') : 0; ?><span class="met_Clicks"></span></span>
                    </div>
                    <div class="met_editor">
                        <div>
                           <?php the_content(); ?>
                            <div id="metinfo_additional">
                                
                            </div>
                                
                        </div>
                        <div class="met_clear">
                            
                        </div>
                            
                    </div>
                    <div class="met_tools">
                        <div class="jiathis_style"><span class="jiathis_txt">分享到：</span><a class="jiathis_button_icons_1"></a><a class="jiathis_button_icons_2"></a><a class="jiathis_button_icons_3"></a><a class="jiathis_button_icons_4"></a><a href="http://www.jiathis.com/share" class="jiathis jiathis_txt jtico jtico_jiathis" target="_blank"></a></div><script type="text/javascript" src="http://v3.jiathis.com/code/jia.js?uid=1346378669840136" charset="utf-8"></script>
                        <ul class="met_page">
                            <li class="met_page_preinfo"><?php previous_post_link('<span>上一篇:</span>%link','%title'); ?></li>
                            <li class="met_page_next"><?php next_post_link('<span>下一篇:</span>%link','%title'); ?></li>
                        </ul>
                    </div>
                </section>
                <?php endwhile; endif; ?>

            </div>
        </article>
        <div class="met_clear"></div>
    </section>
    <?php get_footer(); ?>