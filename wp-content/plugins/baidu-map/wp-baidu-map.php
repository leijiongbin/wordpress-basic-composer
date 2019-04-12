<?php
/*
Plugin Name:百度地图api
Description: 百度地图api
Version: 1.2
*/
/*
1.0 : 初始发布;
1.1 : 添加编辑器按钮插入;支持将输入的地址转换为百度地图的坐标;代码优化;支持在同一页面显示N多地图;
1.2 : 优化并添加更多设置
 */

defined('ABSPATH') || exit;

function wp_baidu_maps_url($path = '') {
	return plugins_url( $path, __FILE__ );
}

if(!class_exists('WP_Baidu_Maps')):

class WP_Baidu_Maps{

    /*百度地图AK , 请在 http://lbsyun.baidu.com/apiconsole/key 这里申请,免费的。*/

    public static $ak  = 'Fcn0BH2IdyavM6sm0gUech0luLQGKjjc'; //5upeZi9ESotIhhBvDkERXuUB
	public static $ver = '1.2';

    private static $instance;
    public function __wakeup() {}
    public function __clone() {}
    public function __construct(){ }
    public static function instance() {

        if ( ! isset( self::$instance ) && ! ( self::$instance instanceof WP_Baidu_Maps ) ) {
            self::$instance = new self();
            self::$instance->hooks();
        }
        return self::$instance;

    }
    
    public function hooks(){
        add_action('init', array( $this, 'add_shortcode' ) );
        #add_action('admin_init', array ( __CLASS__, 'add_insert_btn' ) );
        add_filter('mce_buttons', array( __CLASS__, 'register_baidumap_button') );
        add_filter('mce_external_plugins', array( __CLASS__, 'add_baidumap_button_plugin') );    

		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'reg_js_css') );
	}


    public static function register_baidumap_button( $buttons ) {
        array_push( $buttons, "|", "baidumap" );
        return $buttons;
    }

    public static function add_baidumap_button_plugin($plugin_array){
        echo '<script>var baiduMapAK ="'.self::$ak.'";</script>';

        $plugin_array['baidumap'] =  wp_baidu_maps_url('js/baidu-map-button.js');
        return $plugin_array;
    }

	public static function reg_js_css() {
		//wp_register_script( 'baidu-api', 'https://api.map.baidu.com/api?v=2.0&ak=' . self::$ak, false, '', true );
		wp_register_script( 'baidu-api', 'https://api.map.baidu.com/getscript?v=2.0&ak=' . self::$ak, false, '', true );

		wp_register_script( 'baidu-search-info-window-js', 'http://api.map.baidu.com/library/SearchInfoWindow/1.5/src/SearchInfoWindow_min.js', array( 'baidu-api' ), '', true );
		wp_register_style( 'baidu-search-info-window-css', 'http://api.map.baidu.com/library/SearchInfoWindow/1.5/src/SearchInfoWindow_min.css', false, self::$ver );
		
		wp_register_script( 'baidu-map', wp_baidu_maps_url('js/baidu-map.js'), array( 'baidu-api' ), self::$ver, true );
	}

    public function add_shortcode(){
        add_shortcode('baidu_map', array( __CLASS__ ,'add_sc' ) );
    }

    public function add_sc( $atts= array(), $content='' ){

        extract(shortcode_atts(array(
            'id'               => '',
            'width'            => '',
            'height'           => '',
            'lat'              => '',
            'lng'              => '',
			'animation'        => '',
			'icon'             => '',
			'disable_dragging' => '',
			'control'          => '',
			'windows'          => '',
			'style'            => '',
			'style_json'       => '',
            'title'            => '',
			'info'             => '',
            'address'          => '',
            'email'            => '',
			'phone'            => '',
            'url'              => '',
			'image'            => '',
            'ak'               => self::$ak,
            ) ,$atts));

        $json['id']     = $id ? esc_attr($id) : 'map_' . time();
        $json['width']  = $width ? $width : '100%';
        $json['height'] = $height ? $height : '450px';
        
        $json['lat'] = $lat ? $lat : '';
        $json['lng'] = $lng ? $lng : '';

		$json['animation']        = $animation == 1 ? $animation : 0;
		$json['icon']             = $icon ? $icon : '';
		$json['disable_dragging'] = $disable_dragging == 1 ? $disable_dragging : 0;
		$json['control']          = $control == 1 ? $control : 0;
		$json['windows']          = $windows == 1 ? $windows : 0;
		$json['style']            = $style ? $style : '';
		$json['style_json']       = $style_json ? $style_json : '';

		$json['title']   = $title ? $title : '';
		$json['info']    = $info ? $info : '';
        $json['address'] = $address ? $address : '';
        $json['email']   = $email ? $email : '';
        $json['phone']   = $phone ? $phone : '';
		$json['url']     = $url ? $url : '';
		$json['image']   = $image ? $image : '';

        if ( !$json['lat'] || !$json['lng'] ) {
            return '设置经纬度后才能显示地图哦！';
        }

		wp_enqueue_script( 'baidu-api' );

		if ( $json['windows'] == 1 ) {
			wp_enqueue_script( 'baidu-search-info-window-js' );
			wp_enqueue_style( 'baidu-search-info-window-css' );
		}

		wp_enqueue_script( 'baidu-map' );



        ob_start();
        ?>
		<style>#<?php echo $json['id'] ?> .BMap_Marker img{max-width: none!important;width: none!important;}#<?php echo $json['id'] ?> *{box-sizing:content-box;}</style>
        <div class="map"><div id="<?php echo $json['id'] ?>" style="width:<?php echo $json['width']; ?>;height:<?php echo $json['height']; ?>;overflow:hidden;margin:5px;"></div></div>
       <?php
        $output = ob_get_clean();

		wp_add_inline_script( 'baidu-map', 'BaiduMap(JSON.parse(\'' . json_encode($json) . '\'));' );

        return $output;
    }
    
}

//$GLOBALS['wp_baidu_map'] = WP_Baidu_Maps::instance();
WP_Baidu_Maps::instance();

endif;