<?php
/*
 * Template Name:模板-产品目录
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
                $banners = rwmb_meta('page_custom_banners');
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

                    <button type="button" class="navbar-toggle collapsed sidebar-v2__button btn" data-toggle="collapse" data-target="#sidebar-v2__list2" aria-expanded="false" data-parent="#sidebar-v2__accordion">
                        <span class="glyphicon glyphicon-menu-hamburger"></span>
                    </button>
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
                                <li class="on"><a href="<?php echo get_page_link(93); ?>">二级栏目</a></li>
                                <?php
                                    $terms = get_terms(array('taxonomy' => 'product_tax','hide_empty'=>false,'orderby' => 'menu_order',));    
                                    foreach ($terms as  $key => $term):
                                ?>
                                <li class=""><a href="<?php echo get_term_link($term->term_id); ?>"><?php echo $term->name; ?></a></li>
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
                    $paged = get_query_var('paged', 1);
                    $args = array(
                        'post_type' => 'product', //自定义文章类型名称
                        'showposts' => 12,
                        /*'tax_query' => array(
                            array(
                            'taxonomy' => 'product_tax',//自定义分类法名称
                            'terms' => $current_term_id //id为64的分类。也可是多个分类array(12,64)
                            ),
                        ),*/
                        //'orderby' => 'menu_order',                                                                                            
                        //'order' =>'ASC',
                        'paged' => $paged,
                    );
                    //var_dump($category->term_id);
                    $my_query = new WP_Query($args);
                    if ($my_query->have_posts()) {
                        while ($my_query->have_posts()) : $my_query->the_post();
                ?>
                <li class="col-lg-3 col-md-4 col-sm-6 v2-mtb15">
                    <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" target='_self'>
                        <img src="<?php echo wp_get_attachment_url( get_post_thumbnail_id() );?>" />
                    </a>
                    <div class="product-v2__list__box v2-ac product-v2__dg">
                        <h2><?php the_title(); ?></h2>

                        <ol class="list-unstyled v2-ac v2-mt15">

                            <li class="col-xs-4"><em>面积</em><span><?php echo rwmb_meta('post_product_area'); ?>m²</span></li>

                            <li class="col-xs-4"><em>地址</em><span><?php echo rwmb_meta('post_product_address'); ?></span></li>

                            <li class="col-xs-4"><em>风格</em><span><?php echo rwmb_meta('post_product_style'); ?></span></li>

                        </ol>

                        <p class="v2-mt15 v2-lc"><i>●</i>
                            <?php the_excerpt(); ?>
                        </p>

                        <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="v2-mt15" target='_self'>查看详情<i class="glyphicon glyphicon-menu-right"></i></a>

                    </div>
                </li>
                <?php
                    endwhile;
                    wp_reset_query();
                }
                ?>
            </ul>

            <div class="met_clear"></div>

            <div class='met_pager'>
                <!--<span class='PreSpan'>上一页</span><a href=../product/ class='Ahover'>1</a><a href=product.php?lang=cn&class1=3&page=2 >2</a><a href=product.php?lang=cn&class1=3&page=2 class='NextA'>下一页</a>
                <span class='PageText'>转至第</span>
                <input type='text' id='metPageT' data-pageurl='product.php?lang=cn&class1=3&page=||2' value='1' />
                <input type='button' id='metPageB' value='页' />-->
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