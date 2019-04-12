<?php get_header(); ?>

    <div class="v2_banner">

        <div id="slidershow" class="carousel slide">

        

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
                                    搜索结果
                                </span>
                            </h1>

                        </div>

                        <div class="panel"> 

                            <div class="collapse navbar-collapse" id="sidebar-v2__list2">
                                <ul class="nav navbar-nav navbar-right" id="collapseTwo">
                                    <!-- <li class="<?php echo ($current_term_id == 1) ? "on" : ""; ?>"><a href="<?php echo get_term_link(1); ?>">二级栏目</a></li> -->
                                  <!--   <?php
                                        $terms = get_terms(array('taxonomy' => 'category','hide_empty'=>false,'orderby' => 'menu_order','exclude'=>1));    
                                        foreach ($terms as  $key => $term):
                                    ?>
                                    <li class="<?php echo ($current_term_id == $term->term_id) ? "on" : ""; ?>"><a href="<?php echo get_term_link($term->term_id); ?>"><?php echo $term->name; ?></a></li>
                                    <?php endforeach; ?> -->
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


                <div class="met_module2_list">
                    <ul>

                      <?php 
                          // $page_news_list_display_news_count = rwmb_meta('page_news_list_display_news_count');
        $paged = get_query_var('paged', 1);
                           $args = array(
                           //'post_type' => 'post' //自定义文章类型名称
                            'posts_per_page' => 5 ,
                            's' => $_GET['s'], 
                            // 'offset' =>   explode('/', parse_url($_SERVER['HTTP_REFERER'])['path'])[2]-1 ,
                            'paged' => $paged,                
                            );

                          $my_query = new WP_Query($args);
                          if(function_exists('wpjam_exclude_page_from_search')){
                            $my_query = wpjam_exclude_page_from_search($my_query);
                          }
                          
                          if( $my_query->have_posts() ) {                                                 
                            while ($my_query->have_posts()) : $my_query->the_post();
                      ?>

                 

                          <li class="list_1">

                            <h2><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" target='_self'><i class="fa fa-caret-right"></i><?php the_title(); ?></a></h2>

                            <span class='time'><?php echo get_the_date('Y-m-d'); ?></span>
                        </li>
                      <?php endwhile; wp_reset_query(); }?>


                 <!--        <?php if ( have_posts() ) : while( have_posts() ) : the_post(); ?>
                        <li class="list_1">

                            <h2><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" target='_self'><i class="fa fa-caret-right"></i><?php the_title(); ?></a></h2>

                            <span class='time'><?php echo get_the_date('Y-m-d'); ?></span>
                        </li>
                        <?php endwhile; endif; ?> -->

                    </ul>

                    <div class='met_pager'>
                        <!--<span class='PreSpan'>上一页</span><a href=../news/ class='Ahover'>1</a><a href=news.php?lang=cn&class1=2&page=2 >2</a><a href=news.php?lang=cn&class1=2&page=2 class='NextA'>下一页</a>
                        <span class='PageText'>转至第</span>
                        <input type='text' id='metPageT' data-pageurl='news.php?lang=cn&class1=2&page=||2' value='1' />
                        <input type='button' id='metPageB' value='页' />-->
                        <?php
                            wp_pagenavi();
                        ?>
                    </div>

                </div>

            </div>
        </article>
        <div class="met_clear"></div>
    </section>
    <?php get_footer(); ?>