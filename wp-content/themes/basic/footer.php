          <!-- 脚部 -->
                
                <!--   脚部  -->
                <footer class="footer" >
                    <section class="footer-in">
                        <div class="footer-links">
                    
                            <?php
                              //所有页面id
                              $page_ids = array();

                              $of_bottom_nav_gp = of_get_option('of_bottom_nav_gp');
                              foreach($of_bottom_nav_gp as $item){
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

          

                            <a href="<?php the_permalink(); ?>"><?php the_title();?></a>

                          <?php
                              endwhile;wp_reset_query();}            
                          }
                          ?>   
                            
                        </div>
                        <span class="footer-line"></span>
            
            <p>
                        
         
                        <?php
                            $copyright = of_get_option('_of_copyright');
                            echo $copyright;
                        ?>
                        </p>
                           
                        
                    </section>
                </footer>


                    
                <!--   脚部  end-->
                    
                    
                <!-- 脚部  end-->
            </div>
            <!-- 正文 区  结束 -->
        </div>
        <!-- 选用mm套件，最大的内容区 结束 -->
        
            <!--  选用mm套件，在手机上的导航菜单  -->
            <nav id="menu">
                <ul>
                <?php wp_nav_menu(array('theme_location' => 'top-menu', 'depth' => '0', 'items_wrap' => '%3$s', 'container' => false, 'walker' => new walker_menu_mobile())); ?>
                   <li>
 
          <form class="phone-search-box" action="<?php echo home_url('/'); ?>" >
            <input type="text" name="s" id="" value="" class="phone-search"/>
            <input type="submit" name="" id="" value="" class="phone-search-btn"/>
          </form>


      
          
        </li>
                    
                </ul>
            </nav>
            <!--  选用mm套件，在手机上的导航菜单  结束-->       
        
        
        <script src="<?php bloginfo('template_url'); ?>/js/jquery-1.9.1.min.js" type="text/javascript" charset="utf-8"></script>
        <script src="<?php bloginfo('template_url'); ?>/js/swiper.js" type="text/javascript" charset="utf-8"></script>
        <script src="<?php bloginfo('template_url'); ?>/js/jquery.mmenu.all.min.js" type="text/javascript" charset="utf-8"></script>

        <script src="<?php bloginfo('template_url'); ?>/js/index.js" type="text/javascript" charset="utf-8"></script>
    <?php wp_footer(); ?>
    </body>
</html>