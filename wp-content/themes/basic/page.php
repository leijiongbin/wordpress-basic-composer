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
            <div class="item active">
                    <img src="<?php echo $item['full_url']; ?>" alt="">
            </div>
            <?php //endforeach; ?>
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
                                        echo $post->post_title;
                                    ?>
                                </span>
                            </h1>

                        </div>

                        <div class="panel">	

                            <div class="collapse navbar-collapse" id="sidebar-v2__list2">
                                <ul class="nav navbar-nav navbar-right" id="collapseTwo">



                                <?php
                                  //所有页面id
                                  $page_ids = array();

                                  $page_default_nav_gp = rwmb_meta('page_default_nav_gp');
                                  foreach($page_default_nav_gp as $item){
                                    $page_ids[] = $item['_of_all_page_id'];
                                  }
                                  //var_dump($news);
                                  if(!empty($page_ids)){             
                                      $args = array(
                                          'post_type' => 'page',
                                          //'posts_per_page' => -1,
                                          'order' => 'DESC',
                                          'post__in' =>   $page_ids,
                                      );

                                  $my_query = new WP_Query($args);
                              
                                  if ($my_query->have_posts()) {
                                      while ($my_query->have_posts()) : $my_query->the_post();
                              ?>  

                                <?php 
                                    $current_id = get_queried_object_id();
                                    if($current_id == get_the_ID()){
                                        $isOn = "on";
                                    }else{
                                        $isOn = "";
                                    }

                                ?>

                                <li class="<?php echo $isOn?>"><a href="<?php the_permalink(); ?>" ><?php the_title();?></a></li>

                              <?php
                                  endwhile;wp_reset_query();}            
                              }
                              ?>   

                 

                                </ul>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </section>

        <div class="met_clear"></div>

        <?php if ( have_posts() ) : while( have_posts() ) : the_post(); ?>
        <article class="sidebar-v2__article">
            <div class="met_article">


                <div class="met_editor met_module1">
                    <div class="simple-article">
                        <?php the_content(); ?>
                    </div>
                    <div class="clear"></div>
                </div>

            </div>
        </article>
        <?php endwhile; endif; ?>
        <div class="met_clear"></div>
    </section>
    <?php get_footer(); ?>