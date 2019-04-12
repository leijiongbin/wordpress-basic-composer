<?php
/*
 * Template Name:模板-产品中心
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
                // $banners = rwmb_meta('page_custom_banners');
                // foreach ($banners as $item):
            ?>
          <!--   <div class="item active">
                    <img src="<?php echo $item['full_url']; ?>" alt="">
            </div> -->
             <?php //endforeach; ?>           

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
                                //$current_term_id = get_queried_object_id();
                                //$term = get_term($current_term_id);
                                echo $post->post_title;
                            ?>
                        </span>
                    </h1>

                </div>
                <div class="panel">	

                    <div class="collapse navbar-collapse" id="sidebar-v2__list2">
                        <ul class="nav navbar-nav navbar-right" id="collapseTwo">

                        <?php 
                            $query = home_url( add_query_arg( null, null ));
                            $new_query = add_query_arg( array(
                                'project_tax' => false,//清除project_tax字段
                            ), $query );
                          ?>

                          <?php 
                            if(isset($_GET['project_tax'])){
                                $isOn = "";
                            }else{
                                $isOn = "on";
                            };

                          ?>
                       
                          <li class="<?php echo $isOn?>"><a href="<?php echo $new_query ?>">全部</a></li>
              
                          <?php
                          $current_cat_id = get_queried_object_id();
                          $terms = get_terms(array(
                              'taxonomy' => 'project_tax',
                              'orderby' => 'menu_order',
                              'order' => 'ASC',
                              'hide_empty' => false,
                          ));
                          foreach ($terms as $key => $term):?>   

                          <?php
                              $tax_id = $term->term_id;
                              $arr_params = array( 'project_tax' => $tax_id );
                              $url = esc_url( add_query_arg( $arr_params ));
                          ?>   

                           <?php 
                            if(isset($_GET['project_tax']) && ($tax_id == $_GET['project_tax'])){
                                $isOn = "on";
                            }else{
                                $isOn = "";
                            };

                          ?>                                                  

                              <li class="<?php echo $isOn?>"><a href="<?php echo $url ?>"><?php echo $term->name; ?></a></li>
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


        <div class="product-v2">

            <ul class="product-v2__list list-unstyled">

             <?php
               $current_cat_id = get_queried_object_id();
               $page_project_show_count = rwmb_meta('page_project_show_count');
               $paged = get_query_var('paged', 1);
               $args = array(
               'post_type' => 'project', //自定义文章类型名称
               // 'showposts' => -1,   
               'posts_per_page' => $page_project_show_count  ,                                                                                         
               'orderby' => 'menu_order',                                                                                            
               'order' =>'ASC',
               'paged' => $paged, 
               'tax_query' => array(),  
               );

              $case_tax_id = isset($_GET['project_tax']) ? $_GET['project_tax'] : '';

              //如设置了tax，添加过滤条件
              if ( isset($_GET['project_tax']) ) {
                $arr_item = array(
                      'taxonomy' => 'project_tax',
                      'field'    => 'term_id',
                      'terms'    =>  $case_tax_id ,
                );
                array_push($args['tax_query'], $arr_item); 
              } 
              $index = 0;
              $my_query = new WP_Query($args);
              if( $my_query->have_posts() ) {                                                 
                  while ($my_query->have_posts()) : $my_query->the_post();
            ?>                                                 
              

                <li class="col-lg-3 col-md-4 col-sm-6 v2-mtb15">
                    <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" target='_self'>
                        <img src="<?php echo wp_get_attachment_url( get_post_thumbnail_id() );?>" />
                    </a>
                    <div class="product-v2__list__box v2-ac product-v2__dg">
                        <h2><?php the_title(); ?></h2>

                        <ol class="list-unstyled v2-ac v2-mt15">

                
                            <!-- <li class="col-xs-4"><em>面积</em><span><?php echo rwmb_meta('post_product_area'); ?></span></li>

                            <li class="col-xs-4"><em>地址</em><span><?php echo rwmb_meta('post_product_address'); ?></span></li>

                            <li class="col-xs-4"><em>风格</em><span><?php echo rwmb_meta('post_product_style'); ?></span></li> -->

                            <li class="col-xs-4"><em><?php echo rwmb_meta('post_product_title_1'); ?></em><span><?php echo rwmb_meta('post_product_1'); ?></span></li>
                            <li class="col-xs-4"><em><?php echo rwmb_meta('post_product_title_2'); ?></em><span><?php echo rwmb_meta('post_product_2'); ?></span></li>
                            <li class="col-xs-4"><em><?php echo rwmb_meta('post_product_title_3'); ?></em><span><?php echo rwmb_meta('post_product_3'); ?></span></li>

                        </ol>

                        <p class="v2-mt15 v2-lc"><i>●</i>
                            <?php the_excerpt(); ?>
                        </p>

                        <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="v2-mt15" target='_self'>查看详情<i class="glyphicon"></i></a>

                    </div>
                </li>
            <?php endwhile; wp_reset_query(); } ?>   

            </ul>

            <div class="met_clear"></div>

            <div class='met_pager'>
          
                <?php
                    if($my_query->have_posts() ){
                        wp_pagenavi(array('query'=>$my_query));
                    }
                ?>
            </div>

        </div>

    </div>
</article>
<div class="met_clear"></div>
</section>
<?php get_footer(); ?>