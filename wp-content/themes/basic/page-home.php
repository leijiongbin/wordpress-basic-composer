<?php
/*
 * Template Name:模板-首页
 */
?>
<?php get_header(); ?>

          
                <div class="index-swiper-container swiper-container">
                    <div class="swiper-wrapper">
                    <?php
                          $banners = rwmb_meta('page_home_banners');
                          foreach ($banners as $banner):
                      ?>                                          
                          <div class="swiper-slide"> 
                            <img src="<?php echo $banner['full_url']; ?>"/>
                          </div>


                      <?php endforeach; ?>  

                    </div>
                    <div class="swiper-button-prev"> < </div>
                    <div class="swiper-button-next"> > </div>
                    <div class="swiper-pagination"></div>
                </div>
                
                <section class="about-section section-box">
                    <div class="section-in">
                        <div class="section-title">
                            <h2 class="section-title-big"><?php echo rwmb_meta('page_home_about_title'); ?></h2>
                            <h4 class="section-title-small"><?php echo rwmb_meta('page_home_about_title_slave'); ?></h4>
                        </div>
                        <ul class="about-list">
                          <?php
                              $page_home_about_gp = rwmb_meta('page_home_about_gp');
                              foreach ($page_home_about_gp as $id => $item):
                          ?>  
         
                            <li class="about-item">
                                <a href="<?php echo ($item['page_home_about_item_link']) ? $item['page_home_about_item_link'] : "javascript:void(0);"; ?>">
                                    <img src="<?php echo wp_get_attachment_url($item['page_home_about_item_img'][0]); ?>" alt="" class="about-img" />
                                    <img src="<?php echo wp_get_attachment_url($item['page_home_about_item_img_active'][0]); ?>" alt="" class="about-img-active" />
                                    <h6 class="about-item-name"><?php echo $item['page_home_about_item_name']; ?></h6>
                                </a>
                            </li>
                          <?php endforeach; ?>  

                          
                        </ul>
                    </div>
                    
                </section>
                
                <section class="honour-box section-box">
                    <div class="section-in">
                        <div class="section-title section-title-white">
                            <h2 class="section-title-big"><?php echo rwmb_meta('page_home_authentication_title'); ?></h2>
                            <h4 class="section-title-small"><?php echo rwmb_meta('page_home_authentication_title_slave'); ?></h4>
                        </div>
                        <div class="honour-wall">
                          <?php
                              $page_home_authentication_gp = rwmb_meta('page_home_authentication_gp');
                              foreach ($page_home_authentication_gp as $id => $item):
                          ?>  
                            <?php 
                                if($id<2){
                                    $item_class = "honour-item honour-item-big";
                                }else{
                                    $item_class = "honour-item honour-item-small";
                                }
                            ?>
                            <div class="<?php echo $item_class?>">
                                <h3 class="honour-title"><?php echo $item['page_home_authentication_item_name']; ?></h3>
                                <img src="<?php echo wp_get_attachment_url($item['page_home_authentication_item_img'][0]); ?>" alt="" class="honour-pic"/>
                            </div>
                          <?php endforeach; ?>  


                      
                        </div>
                        
                        
                        
                    </div>
                    
                </section>
                
                <section class="cooperation-section section-box">
                    <div class="section-in">
                        <div class="section-title">
                            <h2 class="section-title-big"><?php echo rwmb_meta('page_home_cooperate_title'); ?></h2>
                            <h4 class="section-title-small"><?php echo rwmb_meta('page_home_cooperate_title_slave'); ?></h4>
                        </div>
                        <ul class="cooperation-list">
                            <?php 

                  

                                $term_str = get_post_meta( get_the_ID(), 'page_home_cooperate_tax_option', true );
                                $term_arr = explode(",",$term_str);
                                $query_arr = array();
                                foreach ($term_arr as $key => $term) {
                                  array_push($query_arr, $term);
                                }

                                $args = array(
                                'post_type' => 'post', //自定义文章类型名称
                                'posts_per_page' => 3 ,
                                'tax_query' => array(
                                    array(
                                         'taxonomy' => 'category',//自定义分类法名称
                                         'terms' => $query_arr //id为64的分类。也可是多个分类array(12,64)
                                    ),
                                  )                         
                                );

                                $my_query = new WP_Query($args);
                                // print_r($my_query);
                                if( $my_query->have_posts() ) {                                                 
                                  while ($my_query->have_posts()) : $my_query->the_post();
                                ?>

                                    <li class="cooperation-item">
                                    <a href="<?php the_permalink(); ?>">
                                        <div class="img-wrap">
                                            <img src="<?php echo wp_get_attachment_url(get_post_thumbnail_id()); ?>" alt="" />
                                            <div class="hover-box">
                                                <div class="hover-in">
                                                    <h4><?php the_title(); ?></h4>
                                                    <p><?php the_excerpt(); ?></p>
                                                    <span class="hover-more">+</span>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <h4 class="cooperation-item-name"><?php the_title(); ?></h4>
                                    </a>
                                </li>
                            <?php endwhile; wp_reset_query(); } ?>


                        </ul>
                        <a href="<?php echo rwmb_meta('page_home_cooperate_link'); ?>" class="cooperation-more-btn section-more-btn">more+</a>
                        
                        

                    </div>
                    
                </section>
                
                <section class="cooperation-section case-section section-box">
                    <div class="section-in">
                        <div class="section-title">
                            <h2 class="section-title-big"><?php echo rwmb_meta('page_home_case_title'); ?></h2>
                            <h4 class="section-title-small"><?php echo rwmb_meta('page_home_case_title_slave'); ?></h4>
                        </div>
                        <ul class="cooperation-list case-list">

                            <?php 
                                $page_home_case_show_count = rwmb_meta('page_home_case_show_count');

                                $args = array(
                                    'post_type' => 'project', //自定义文章类型名称
                                    'posts_per_page' => $page_home_case_show_count ,                      
                                );

                                $my_query = new WP_Query($args);
                                // print_r($my_query);
                                if( $my_query->have_posts() ) {                                                 
                                  while ($my_query->have_posts()) : $my_query->the_post();
                            ?>
                     

                                <li class="cooperation-item case-item">
                                    <a href="<?php the_permalink(); ?>">
                                        <div class="img-wrap">
                                            <img src="<?php echo wp_get_attachment_url(get_post_thumbnail_id()); ?>" alt="" />
                                            <div class="hover-box">
                                                <div class="hover-in">
                                                    <h4><?php the_title(); ?></h4>
                                                    <p><?php the_excerpt(); ?></p>
                                                    <span class="hover-more">+</span>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            <?php endwhile; wp_reset_query(); } ?>


                         
                        </ul>
                        <a href="<?php echo rwmb_meta('page_home_case_link'); ?>" class="case-more-btn section-more-btn">more+</a>
                        
                        

                    </div>
                    
                </section>
                
                <section class="section-box news-section">
                    <div class="section-in">
                        <div class="section-title section-title-white">
                            <h2 class="section-title-big"><?php echo rwmb_meta('page_home_news_title'); ?></h2>
                            <h4 class="section-title-small"><?php echo rwmb_meta('page_home_news_title_slave'); ?></h4>
                        </div>
                        <div class="news-box">
                          <?php 
                            $img = rwmb_meta('page_home_news_img');
                            // var_dump($img);
                            foreach ($img as $img_item){
                              $img_url = $img_item["full_url"];
                            }

                          ?>
                            <a href="#" class="news-box-left"><img  src="<?php echo $img_url?>"></a>
                            
                            <ul class="index-news-list">

                            <?php 

                 
                                $term_str = get_post_meta( get_the_ID(), 'page_home_news_tax_option', true );
                                $term_arr = explode(",",$term_str);
                                $query_arr = array();
                                foreach ($term_arr as $key => $term) {
                                  array_push($query_arr, $term);
                                }

                                $args = array(
                                'post_type' => 'post', //自定义文章类型名称
                                'posts_per_page' => 4 ,
                                'tax_query' => array(
                                    array(
                                         'taxonomy' => 'category',//自定义分类法名称
                                         'terms' => $query_arr //id为64的分类。也可是多个分类array(12,64)
                                    ),
                                  )                         
                                );

                                $my_query = new WP_Query($args);
                                // print_r($my_query);
                                if( $my_query->have_posts() ) {                                                 
                                  while ($my_query->have_posts()) : $my_query->the_post();
                                ?>

                                <li class="index-news-item">
                                    <a href="<?php the_permalink(); ?>">
                                        <div class="news-time-box">
                                            <h4><?php the_time("d")?></h4>
                                            <h5><?php the_time("Y-m")?></h5>
                                        </div>
                                        <h2 class="index-news-title"><?php the_title()?></h2>
                                        <p class="index-news-intro"><?php the_excerpt()?></p>
                                    </a>
                                </li>
                            <?php endwhile; wp_reset_query(); } ?>


                           
                            </ul>
                            
                        </div>
                    </div>
                    
                </section>
                
                <section class="section-box friend-links-section">
                    <div class="section-in">
                        <div class="friend-links-list">
                            <span class="friend-links">友情链接：</span>
                          <?php
                              $page_home_link_gp = rwmb_meta('page_home_link_gp');
                              foreach ($page_home_link_gp as $id => $item):
                          ?>  
         
             

                            <a href="<?php echo ($item['page_home_link_item_link']) ? $item['page_home_link_item_link'] : "javascript:void(0);"; ?>" class="friend-links"><?php echo $item['page_home_link_item_name']; ?></a>
                          <?php endforeach; ?>  
                  
                        </div>
                    </div>
                    
                </section>
                
                
      

    <?php get_footer(); ?>