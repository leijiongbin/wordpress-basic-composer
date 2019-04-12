<?php
/**
 * 重定置菜单
 */
class walker_menu extends Walker_Nav_Menu {
    function start_lvl( &$output, $depth = 0, $args = array() ) {
        // $indent = str_repeat("\t", $depth);
        //$output .= "\n$indent<ul class=\"nav_under\">\n";
        $ul_class = 'class="pc-nav-item-downlist"';//二级ulclass设置
        // $output .= "\n$indent<ul ".$ul_class.">\n";
        $output .= "<ol ".$ul_class.">\n";
    }
    public function end_lvl( &$output, $depth = 0, $args = array() ) {
        // $indent = str_repeat("\t", $depth);
        // $output .= "$indent</ul>\n";
        $output .= "</ol>\n";
    }	
    function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
        global $wp_query;
        //print_r($item);

        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
        
         
        $class_names = $value = '';
 
        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        //print_r($classes);
        $classes[] = 'menu-item-' . $item->ID;

        $menu_item_has_children = false; //是否有子菜单
        foreach($classes as $tmp){
            if($tmp == 'menu-item-has-children'){
                $menu_item_has_children = true;
            }
        }

        $current_menu_item = false;//是否是当前页面
        foreach($classes as $tmp){
            if($tmp == 'current-menu-item'){
                $current_menu_item = true;
            }
        }

        $current_menu_parent = false;//是否是当前父级页面
        foreach($classes as $tmp){
            if($tmp == 'current-menu-parent' || $tmp == 'current-menu-ancestor'){
                $current_menu_parent = true;
            }
        }

 
        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
        //$class_names = ' class="nLi ' . esc_attr( $class_names ) . '"';
        $class_names = '';
 
        //$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
        //$id = strlen( $id ) ? ' id="' . esc_attr( $id ) . '"' : '';
        $id='';
        
        
        if( $depth == 0 && ($current_menu_item || $current_menu_parent) ) {
             $output .= $indent . '<li' . $id . $value . $class_names .' class="current pc-nav-item">';//一级当前菜单
        }elseif($depth == 0){
             $output .= $indent . '<li' . $id . $value . $class_names .' class="pc-nav-item">';//一级菜单
        }elseif( $depth != 0 && ($current_menu_item || $current_menu_parent) ) {
             $output .= $indent . '<li' . $id . $value . $class_names .' class="current pc-nav-second-item" >';//二级当前菜单
        }else{ 
            $output .= $indent . '<li class="pc-nav-second-item">';
        }

        


        $prepend = ''; //文字左边
        $append = '';  //文字右边
        $description  = ! empty( $item->attr_title ) ? '<br />' . esc_attr( $item->attr_title ) . '' : '';
 
        if($depth != 0) {
            $description = $append = $prepend = "";
            $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
        }
        $attributes  = '';
        $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
        $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
        $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
 
        $item_output = isset($args->before) ? $args->before : '';
        if($depth == 0 && ($current_menu_item || $current_menu_parent) ) {
            $item_output .= '<a '. $attributes .'>';
        }else{
            $item_output .= '<a '. $attributes .'>';
            /*if ( $item->object==='product' && function_exists('z_taxonomy_image_url') && $thecimage = z_taxonomy_image_url($item->object_id) ) {
                $item_output .= '<a '. $attributes .'><img src="'.$thecimage.'">';
            }else{
                $item_output .= '<a '. $attributes .'>';
            }*/
        }
        $item_output .= isset($args->link_before) ? $args->link_before : '';
        $item_output .= $prepend . apply_filters( 'the_title', $item->title, $item->ID ) . $append;
        $item_output .= isset($args->link_after) ? $description . $args->link_after : $description;
        if($depth == 0) {
            $item_output .= '</a>';
        }else{
            $item_output .= '</a>';
        }
        $item_output .= isset($args->after) ? $args->after : '';

 
        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }
    public function end_el( &$output, $item, $depth = 0, $args = array() ) {

        /*$classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $nosep = false;//是否特殊样式，最后一个栏目
        foreach($classes as $tmp){
            if($tmp == 'nosep'){
                $nosep = true;
            }
        }*/

        if($depth == 0){
            $output .= "</li>\n";
        }else{
            $output .= "</li>\n";
        }
    }	
}


/**
 * 重定置菜单，手机菜单
 */
class walker_menu_mobile extends Walker_Nav_Menu {
    function start_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat("\t", $depth);
        //$output .= "\n$indent<ul class=\"dropdown-menu\">\n";
        $user_name = $_SESSION['account_name'];
        $logout_link = get_the_permalink(6);
        //$before_li = '<li><span class="account">'.$user_name.'</span>   <a href="'.$logout_link.'" class="log-off">退出登录</a></li>';

        //$output = $before_li.$output;
        //var_dump($output);
        $output .= "\n$indent<ul>\n";
    }
    function start_el(&$output, $item, $depth = 0, $args = array(), $id=0) {
        global $wp_query;
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
        
         
        $class_names = $value = '';
 
        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;
        
        $menu_item_has_children = false; //是否有子菜单
        foreach($classes as $tmp){
            if($tmp === 'menu-item-has-children'){
                $menu_item_has_children = true;
            }
        }

        $current_menu_item = false;//是否是当前页面
        foreach($classes as $tmp){
            if($tmp === 'current-menu-item'){
                $current_menu_item = true;
            }
        }

        $current_menu_parent = false;//是否是当前父级页面
        foreach($classes as $tmp){
            if($tmp === 'current-menu-parent' || $tmp == 'current-menu-ancestor'){
                $current_menu_parent = true;
            }
        }

 
        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
        //$class_names = ' class="nLi ' . esc_attr( $class_names ) . '"';
        $class_names = '';
 
        //$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
        //$id = strlen( $id ) ? ' id="' . esc_attr( $id ) . '"' : '';
        $id='';
        
        if( $depth == 0 && ($current_menu_item || $current_menu_parent) ) {
             $output .= $indent . '<li' . $id . $value . $class_names .' class="current">';
        }else{ 
            $output .= $indent . '<li>';
        }
 
        $prepend = '';
        $append = '';
        //$description  = ! empty( $item->attr_title ) ? '<span>' . esc_attr( $item->attr_title ) . '</span>' : '';
        $description  = '';
 

        $attributes  = '';
        $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
        $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
        $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
 
        $item_output = isset($args->before) ? $args->before : '';
        if($depth == 0) {
            if( $menu_item_has_children ){
                $item_output .= '<a '. $attributes .'>';
            }else{
                $item_output .= '<a '. $attributes .'>';
            }
        }else{
            $item_output .= '<a '. $attributes .'>';
        }

        $item_output .= isset($args->link_before) ? $args->link_before : '';
        if( is_home() || is_front_page() ){
            $item_output .= $prepend . apply_filters( 'the_title', $item->title, $item->ID ) . $append;
        }else{
            $item_output .= $prepend . apply_filters( 'the_title', $item->title, $item->ID ) . $append;
        }

        $item_output .= isset($args->link_after) ? $description . $args->link_after : $description;
        if($depth == 0) {
            if( $menu_item_has_children ){
                $item_output .= '</a>';
            }else{
                $item_output .= '</a>'; 
            }
        }else{
            $item_output .= '</a>';
        }
        $item_output .= isset($args->after) ? $args->after : '';
 
        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }
}


/**
 * 替换菜单的多余CSS选择器
 * @form http://www.wpdaxue.com/remove-wordpress-nav-classes.html
 */
add_filter('nav_menu_css_class', 'my_css_attributes_filter', 100, 1);
add_filter('nav_menu_item_id', 'my_css_attributes_filter', 100, 1);
add_filter('page_css_class', 'my_css_attributes_filter', 100, 1);
function my_css_attributes_filter($var) {
    return is_array($var) ? array_intersect($var, array('current-menu-item','current_page_item')) : '';
}

