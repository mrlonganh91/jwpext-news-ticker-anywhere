<?php
/*
* Plugin Name: News Ticker Anywhere
* Plugin URI: https://joomlaweb.site/wordpress_plugin/news-ticker-anywhere.html
* Description: This plugin will create news/ticker Anywhere where you want show Popup
* Version: 1.0
* Author: Mr.LongAnh
* Author URI: https://joomlaweb.site
* License: GPLv2 or later
* Text Domain: news-ticker-anywhere	
*/

if(!class_exists("JWEXT_NEWS_TICKER_ANYWHERE")) {    
    define( 'NEWSANW_DIRURL', plugin_dir_url( __FILE__ ));
    define( 'NEWSANW_DIREXT', plugin_dir_path( __FILE__ ));
    define( 'NEWSANW_COREEXT', NEWSANW_DIREXT . "/core" );
    define( 'NEWSANW_TEMP', NEWSANW_DIREXT . "/template" );
    
    

    class JWEXT_NEWS_TICKER_ANYWHERE {

        /**
         * A reference to an instance of this class.
         */
        private static $instance;

        /**
         * The array of templates that this plugin tracks.
         */
        
        protected $templates;        


        /**
         * Returns an instance of this class.
         */
        public static function get_instance() {
            
            if ( null == self::$instance ) {
                self::$instance = new JWEXT_NEWS_TICKER_ANYWHERE();
            }
               
            return self::$instance;

        }

        /**
         * Initializes the plugin by setting filters and administration functions.
         */
        private function __construct() {
            /**
		    * Loads Plugin textdomain
		    */
            
            include NEWSANW_TEMP.'/widget-news-ticker.php';
            load_plugin_textdomain( 'news-ticker-anywhere', false, dirname( plugin_basename( __FILE__ ) ) . '/lang/' );
            $this->templates = array();

            /* kich hoat tao custom post type */           
            add_action('admin_menu', array( $this, 'add_submenu_options_private'));           
            add_shortcode( 'newsanywhere', array( $this, 'newstag_func'));

            // add script admin
            add_action( 'admin_enqueue_scripts', array( $this, 'news_ticker_load_admin_scripts') );
            // add script frontend
            //add_action('wp_enqueue_scripts', array( $this, 'frontend_scripts_method'));            
            add_action( 'wp_ajax_news_ticker_get_assignshow', array( $this, 'news_ticker_get_assignshow') );
            add_filter( 'wp_kses_allowed_html', array( $this, 'custom_wpkses_post_tags'), 10, 2 );
            
            
            // register css
            add_action('wp_enqueue_scripts', array( $this, 'register_my_css'));            
            // register javascript
            add_action('wp_enqueue_scripts', array( $this, 'register_my_scripts'));
        }
        function register_my_css () {
            
            wp_register_style('animate-news-ticker-css', NEWSANW_DIRURL.'template/assets/css/animate.compat.css');
            wp_register_style('custom-news-ticker-css', NEWSANW_DIRURL.'template/assets/css/custom_news_ticker.css');
        }
        
        function register_my_scripts () {            
            if ( ! wp_script_is( 'jquery', 'enqueued' )) {
                //Enqueue
                wp_enqueue_script( 'jquery' );
            }
            wp_register_script('news-ticker-easing', NEWSANW_DIRURL.'template/assets/js/news-ticker/jquery.easing.min.js');
            wp_register_script('news-ticker', NEWSANW_DIRURL.'template/assets/js/news-ticker/jquery.easy-ticker.js');
        }
        
        function custom_wpkses_post_tags( $tags, $context ) {
            if ( 'post' === $context ) {
                $tags['iframe'] = array(
                    'src'             => true,
                    'height'          => true,
                    'width'           => true,
                    'frameborder'     => true,
                    'allowfullscreen' => true,
                    'style' => true,
                );
				$tags['script'] = array(
                    'type'             => true,                    
                );
            }        
            return $tags;
        }       
        
        function newstag_func( $atts ) {
			
            $news_ticker_attr = shortcode_atts( array(
                'style' => '',
                'direction' => '',
                'animate' => '',
                'width'=>'',
                'height'=>'',
                'interval'=>'',
                'visible'=>'',
                'auto_play'=>'',
                'mouse_pause'=>'',
                'controll_button'=>'',                              
                'cat'=>'',//1,2,3
                'title'=>'',
                'limit_desc'=>'',
                'limit_post'=>'',
                
            ), $atts );
            
            
            if(empty($news_ticker_attr)){
                return;
            }
            // if shortcode attr value null, overide admin config plugin: admin.php?page=options_news_ticker_anywhere
            
            $jwext_news_stype           = get_option('jwext_news_stype', '0');
            if(!$jwext_news_stype){
                echo __( 'You need config plugin new ticker anywhere before use shortcode', 'news-ticker-anywhere' );
                return;
            }
            $jwext_news_direction       = get_option('jwext_news_direction', '');
            $jwext_news_animate         = get_option('jwext_news_animate', '');
            
            $jwext_news_width           = get_option('jwext_news_width', 'auto');
            $jwext_news_height          = get_option('jwext_news_height', 'auto');
            $jwext_news_interval        = get_option('jwext_news_interval', '3000');
            
            $jwext_news_visible         = (int)get_option('jwext_news_visible', '3');
            $jwext_news_mouse_pause     = get_option('jwext_news_mouse_pause', '');
            $jwext_news_controll_button = get_option('jwext_news_controll_button', '');

            $jwext_news_ticker_assigncat= get_option('jwext_news_ticker_assigncat', '');
            $jwext_cat_postype          = get_option('jwext_cat_postype', '');
            $jwext_news_auto_play       = get_option('jwext_news_auto_play', '');

            $jwext_news_title           = get_option('jwext_news_title', '');
            $jwext_news_limit_desc      = get_option('jwext_news_limit_desc', '300');
            $jwext_news_limit_post      = get_option('jwext_news_limit_post', '15');

            
            
            if($jwext_cat_postype){
                $jwext_cat_postype = json_decode($jwext_cat_postype);
            }else{
                $jwext_cat_postype = array();
            }

            if($jwext_news_ticker_assigncat){
                $jwext_news_ticker_assigncat = json_decode($jwext_news_ticker_assigncat);
            }else{
                $jwext_news_ticker_assigncat = array();
            }
            
            
            if(!sanitize_text_field($news_ticker_attr['style'])){
                $news_ticker_attr['style']      = sanitize_text_field($jwext_news_stype);
            }
            if(!sanitize_text_field($news_ticker_attr['direction'])){
                $news_ticker_attr['direction']  = sanitize_text_field($jwext_news_direction);
            }
            if(!sanitize_text_field($news_ticker_attr['animate'])){
                $news_ticker_attr['animate']    = sanitize_text_field($jwext_news_animate);
            }
            if(!sanitize_text_field($news_ticker_attr['width'])){
                $news_ticker_attr['width']      = sanitize_text_field($jwext_news_width);
            }
            if(!sanitize_text_field($news_ticker_attr['height'])){
                $news_ticker_attr['height']     = sanitize_text_field($jwext_news_height);
            }
            if(!sanitize_text_field($news_ticker_attr['interval'])){
                $news_ticker_attr['interval']   = sanitize_text_field($jwext_news_interval);
            }
            if(!sanitize_text_field($news_ticker_attr['visible'])){
                $news_ticker_attr['visible']    = sanitize_text_field($jwext_news_visible);
            }
            if(!sanitize_text_field($news_ticker_attr['mouse_pause'])){
                $news_ticker_attr['mouse_pause'] = sanitize_text_field($jwext_news_mouse_pause);
            }
            if(!sanitize_text_field($news_ticker_attr['controll_button'])){
                $news_ticker_attr['controll_button'] = sanitize_text_field($jwext_news_controll_button);
            }

            if(!sanitize_text_field($news_ticker_attr['title'])){
                $news_ticker_attr['title']      = sanitize_text_field($jwext_news_title);
            }
            if(!sanitize_text_field($news_ticker_attr['limit_desc'])){
                $news_ticker_attr['limit_desc'] = sanitize_text_field($jwext_news_limit_desc);
            }
            
            if(!sanitize_text_field($news_ticker_attr['limit_post'])){
                $news_ticker_attr['limit_post'] = sanitize_text_field($jwext_news_limit_post);
            }
           
            if(!sanitize_text_field($news_ticker_attr['cat'])){
                $news_ticker_attr['cat'] = $jwext_cat_postype;//array
                // auto get taxonomies , in plugin config
                $news_ticker_attr['taxonomies'] = $jwext_news_ticker_assigncat;

            }else if(sanitize_text_field($news_ticker_attr['cat']) && strpos(sanitize_text_field($news_ticker_attr['cat']), ',')){ 
                $news_ticker_attr['cat'] = explode(",",sanitize_text_field($news_ticker_attr['cat']));
                if(!is_array($news_ticker_attr['cat'])){
                    echo __( '[newsanywhere cat="1,2..."]', 'news-ticker-anywhere' );
                    return;
                }
                // get taxonomies from cat
                $news_ticker_attr['taxonomies'] = array();
                foreach($news_ticker_attr['cat'] as $ar_cat){
                    $term = get_term( $ar_cat );   
                    if($term && !in_array(sanitize_text_field($term->taxonomy),$news_ticker_attr['taxonomies'])){
                        $news_ticker_attr['taxonomies'][] = sanitize_text_field($term->taxonomy);  
                    }
                }
                              

            }else if(sanitize_text_field($news_ticker_attr['cat']) && !strpos(sanitize_text_field($news_ticker_attr['cat']), ',')){               
                $news_ticker_attr['cat'] = array((int)sanitize_text_field($news_ticker_attr['cat']));
                // get taxonomies from cat
                $news_ticker_attr['taxonomies'] = array();
                foreach($news_ticker_attr['cat'] as $ar_cat){
                    $term = get_term( $ar_cat );   
                    if($term && !in_array(sanitize_text_field($term->taxonomy),$news_ticker_attr['taxonomies'])){
                        $news_ticker_attr['taxonomies'][] = sanitize_text_field($term->taxonomy);  
                    }
                }
            }

            if(empty($news_ticker_attr['taxonomies']) || empty($news_ticker_attr['cat'])){
                echo __( 'Could not find taxonomies or cat to show post', 'news-ticker-anywhere' );
                return;
            }

            if(!sanitize_text_field($news_ticker_attr['auto_play'])){
                $news_ticker_attr['auto_play'] = sanitize_text_field($jwext_news_auto_play);
            }
            
            
            wp_enqueue_style('animate-news-ticker-css');
            wp_enqueue_style('custom-news-ticker-css');
            wp_enqueue_script('news-ticker-easing');
            wp_enqueue_script('news-ticker');
            
            

            $postids = array();
            $i = 0;
            foreach($news_ticker_attr['taxonomies'] as $taxonom){
                $args = array(                
                'tax_query' => array(
                    array(
                        'taxonomy' => sanitize_text_field($taxonom),
                        'field'    => 'term_id',
                        'terms'    => $news_ticker_attr['cat'],//cat 1, cat 2, (and cat3 in child cat 2)
                        'include_children' => false,// chon cat 2 se show ca post thuoc cat 3 la child cat 2                          
                        ),
                    ),
                    'orderby' => 'ID', 
                    'order' => 'ASC',   
                );
                $query = new WP_Query($args);
                
                if ( $query->have_posts() ){                    
                    while($query -> have_posts()) : $query -> the_post();
                        if(!in_array(get_the_ID(),$postids)){                        
                            $postids[$i] = get_the_ID();//get_the_title();
                        }
                        if((int)$news_ticker_attr['limit_post'] && count($postids)>=(int)$news_ticker_attr['limit_post']){
                            break;
                        }
                        $i++;
                    endwhile;
                }                 
                wp_reset_query();
            }
            if(empty($postids)){
                echo __( 'Could not find post ids', 'news-ticker-anywhere' );
                return;
            }
           
            ob_start();
            $output = '';
            include NEWSANW_TEMP.'/shortcode.php';
            $output = ob_get_contents();
            ob_end_clean();
            return $output;            
        }
        public function limit_string($value, $limit = 300, $end = '...'){
            if (mb_strwidth($value, 'UTF-8') <= $limit) {
                return $value;
            }
            return rtrim(mb_strimwidth($value, 0, $limit, '', 'UTF-8')).$end;
        }
        function add_submenu_options_private(){
            // Options Private la option rieng cua custom post type
            // jwext options la option cua tong the plugin
            // jwtheme options la option cua tong the theme
            add_menu_page(                
                'News Ticker Anywhere',
                'News Ticker Anywhere',
                'manage_options',
                'options_news_ticker_anywhere',
                array( $this, 'render_options_news_ticker_anywhere'), // This function will be defined in a moment
                'dashicons-cover-image',
                999
            );            
        }
        function frontend_scripts_method(){    
            if ( ! wp_script_is( 'jquery', 'enqueued' )) {
                //Enqueue
                wp_enqueue_script( 'jquery' );
            }
            
            
            wp_enqueue_script('popup-js', NEWSANW_DIRURL.'template/assets/js/popup/jquery.popup.js');            
            wp_enqueue_style('popup-css', NEWSANW_DIRURL.'template/assets/css/jwpext_popup.css');
            wp_enqueue_style('animate-popup-css', NEWSANW_DIRURL.'template/assets/css/animate.compat.css');
            wp_enqueue_style('custom-popup-css', NEWSANW_DIRURL.'template/assets/css/custom_popup.css');
            
        }
        function news_ticker_load_admin_scripts(){     
            $current_screen = get_current_screen();            
            if ( strpos($current_screen->base, 'news_ticker_anywhere') === false) {
                return;
            }else{  
                //wp_enqueue_media();
                //wp_enqueue_style('admin-metro-css', 'https://cdn.korzh.com/metroui/v4/css/metro-all.min.css');
                wp_enqueue_script('admin-metro-js', NEWSANW_DIRURL.'template/assets/js/metro.min.js');
                wp_enqueue_style('admin-newsanywhere-custom-css', NEWSANW_DIRURL.'template/assets/css/css.css');
                wp_enqueue_script('admin-newsanywhere-custom-js', NEWSANW_DIRURL.'template/assets/js/js.js');
                wp_enqueue_style('animate-popup-css', NEWSANW_DIRURL.'template/assets/css/animate.compat.css');
            }
        }
        function news_ticker_get_assignshow() {
            
            if(!isset($_POST['assignshow']) || !sanitize_textarea_field($_POST['assignshow']) ){
                exit('NOT_FOUND_ASSIGN_SHOW_ITEM');
            }
            $data = str_replace('\\','',sanitize_textarea_field($_POST['assignshow']));
            $jwext_popup_assignshow = json_decode($data,true);
            //$jwext_popup_assignshow = array_flip($jwext_popup_assignshow);
            
            $data = str_replace('\\','',sanitize_textarea_field($_POST['jwext_hid_cat_postype']));
            $jwext_hid_cat_postype = json_decode($data,true);
            
            $result = array();            
            $result['posttype'] = '';
            $result['posttype'] .=  $this->getItemsCustom($jwext_hid_cat_postype,$jwext_popup_assignshow); 

            echo json_encode($result);
            die();
            echo "<pre>";
            print_r($result);exit;            
            
        }
        function render_options_news_ticker_anywhere() {             
            if (!current_user_can('manage_options')) {
                wp_die('Unauthorized user');
            }            
            if( isset( $_POST['news-ticker-anywhere-page-save-nonce'] ) ) {    
             
                $thongtin_nonce = @sanitize_text_field($_POST['news-ticker-anywhere-page-save-nonce']);              
                
                if( !wp_verify_nonce( $thongtin_nonce, 'news-ticker-anywhere-page-save' ) ) {
                    return;
                }
                
                $jwext_news_stype           = isset($_POST['jwext_news_stype'])?sanitize_text_field($_POST['jwext_news_stype']):'1';
                $jwext_news_direction       = isset($_POST['jwext_news_direction'])?sanitize_text_field($_POST['jwext_news_direction']):'1';
				
                $jwext_news_animate         = isset($_POST['jwext_news_animate'])?sanitize_text_field($_POST['jwext_news_animate']):'bounce';
                $jwext_news_width           = (isset($_POST['jwext_news_width'])&&$_POST['jwext_news_width']&&$_POST['jwext_news_width']!='auto')?(int)sanitize_text_field($_POST['jwext_news_width']):'auto';
                $jwext_news_height          = (isset($_POST['jwext_news_height'])&&$_POST['jwext_news_height']&&$_POST['jwext_news_height']!='auto')?(int)sanitize_text_field($_POST['jwext_news_height']):'auto';
                $jwext_news_interval        = isset($_POST['jwext_news_interval'])?sanitize_text_field($_POST['jwext_news_interval']):'3000';
                $jwext_news_visible         = isset($_POST['jwext_news_visible'])?sanitize_text_field($_POST['jwext_news_visible']):'3';
                
                $jwext_news_mouse_pause     = isset($_POST['jwext_news_mouse_pause'])?sanitize_text_field($_POST['jwext_news_mouse_pause']):'';
                $jwext_news_controll_button = isset($_POST['jwext_news_controll_button'])?sanitize_text_field($_POST['jwext_news_controll_button']):'';
                $jwext_news_auto_play       = isset($_POST['jwext_news_auto_play'])?sanitize_text_field($_POST['jwext_news_auto_play']):'';
                $jwext_news_title           = isset($_POST['jwext_news_title'])?sanitize_text_field($_POST['jwext_news_title']):'';
                $jwext_news_limit_desc      = isset($_POST['jwext_news_limit_desc'])?(int)sanitize_text_field($_POST['jwext_news_limit_desc']):'';
                $jwext_news_limit_post      = isset($_POST['jwext_news_limit_post'])?(int)sanitize_text_field($_POST['jwext_news_limit_post']):'';
                
                
				if(isset($_POST['jwext_news_ticker_assigncat']) && is_array($_POST['jwext_news_ticker_assigncat'])){
					//Sanitizing here:
                    $new_input = array();                    
					foreach ( $_POST['jwext_news_ticker_assigncat'] as $key => $val ) {						
                        $new_input[ $key ] = sanitize_text_field( $val );
					}
					$jwext_news_ticker_assigncat  = sanitize_text_field(json_encode($new_input));
				}else{
				    $jwext_news_ticker_assigncat  = '';
				}
                				
				if(isset($_POST['jwext_cat_postype']) && is_array($_POST['jwext_cat_postype'])){
					//Sanitizing here:
                    $new_input = array();   
					foreach ( $_POST['jwext_cat_postype'] as $key => $val ) {
						$new_input[ $key ] = sanitize_text_field( $val );
					}					
					$jwext_cat_postype       = sanitize_text_field(json_encode($new_input));
				}else{
				    $jwext_cat_postype		 = '';
				}
				
                
				update_option('jwext_news_stype', $jwext_news_stype);
				update_option('jwext_news_direction', $jwext_news_direction);
				update_option('jwext_news_animate', $jwext_news_animate);
                
				update_option('jwext_news_width', $jwext_news_width);
				update_option('jwext_news_height', $jwext_news_height);
                
				update_option('jwext_news_interval', $jwext_news_interval);
				update_option('jwext_news_visible', $jwext_news_visible);

				update_option('jwext_news_ticker_assigncat', $jwext_news_ticker_assigncat);
				update_option('jwext_cat_postype', $jwext_cat_postype);
				
				update_option('jwext_news_mouse_pause', $jwext_news_mouse_pause);
				update_option('jwext_news_controll_button', $jwext_news_controll_button);

                update_option('jwext_news_auto_play', $jwext_news_auto_play);
                
                update_option('jwext_news_title', $jwext_news_title);
                update_option('jwext_news_limit_desc', $jwext_news_limit_desc);
                update_option('jwext_news_limit_post', $jwext_news_limit_post);
               
            }
            
            
            
            $jwext_news_stype           = get_option('jwext_news_stype', '');
            $jwext_news_direction       = get_option('jwext_news_direction', '');
            $jwext_news_animate         = get_option('jwext_news_animate', '');
            
            $jwext_news_width           = get_option('jwext_news_width', 'auto');
            $jwext_news_height          = get_option('jwext_news_height', 'auto');
            $jwext_news_interval        = get_option('jwext_news_interval', '3000');
            
            $jwext_news_visible         = get_option('jwext_news_visible', '3');
            $jwext_news_mouse_pause     = get_option('jwext_news_mouse_pause', 'on');
            $jwext_news_controll_button = get_option('jwext_news_controll_button', 'on');
            
            $jwext_news_ticker_assigncat= get_option('jwext_news_ticker_assigncat', '');
            $jwext_cat_postype          = get_option('jwext_cat_postype', '');
            $jwext_news_auto_play       = get_option('jwext_news_auto_play', 'on');

            $jwext_news_title           = get_option('jwext_news_title', '');
            $jwext_news_limit_desc      = get_option('jwext_news_limit_desc', '300');
            $jwext_news_limit_post      = get_option('jwext_news_limit_post', '15');
            
            
                     
            
            if($jwext_news_ticker_assigncat){
                $jwext_news_ticker_assigncat = json_decode($jwext_news_ticker_assigncat);                
            }else{
                $jwext_news_ticker_assigncat = array();
            }
            if($jwext_cat_postype){
                $jwext_cat_postype = json_decode($jwext_cat_postype);
            }else{
                $jwext_cat_postype = array();
            }
            
            include_once dirname( __FILE__ ) . '/core/options_news_ticker_anywhere.php';   
        }
        function sort_hierarchical(array &$cats, array &$into, $parent_id = 0){
            
            foreach ($cats as $i => $cat) {
                if ($cat->parent == $parent_id) {
                    $into[$cat->term_id] = $cat;
                    unset($cats[$i]);
                }
            }
            
            foreach ($into as $top_cat) {
                $top_cat->children = array();
                $this->sort_hierarchical($cats, $top_cat->children, $top_cat->term_id);
            }
        }
        
        function showchild2(array $stchild,&$htmlchild,$data, $parent_id = 0){
            foreach ($stchild as $i => $k) {
                $parent_id++;
                for($i=0;$i<$parent_id;$i++){
                    $htmlchild .= '--| ';
                }
                $htmlchild.=$k->name."<br/>";
                if($k->children && !empty($k->children)){
                    $this->showchild($k->children, $htmlchild,$data,$parent_id );
                }
            }
        }
        function showchild(array $stchild,&$htmlchild,$data, &$parent_id = 0){
			
            foreach ($stchild as $i => $k) {
				
                $parent_id++;
				
				$subchild = '';
                for($i=0;$i<$parent_id;$i++){
                    $subchild .= '--| ';
                }
                $catname = $subchild.$k->name;
                if(is_array($data) && $data && in_array($k->term_id, $data)){
                    $selected = 'selected';
                }else{
                    $selected = '';
                }
                $htmlchild .= '<option value="'.$k->term_id.'" '.$selected.'>'.$catname.'</option>';				
                if(isset($k->children) && !empty($k->children)){					
                    $this->showchild($k->children, $htmlchild,$data,$parent_id );
                }else{
					
					$parent_id = 0;
				}
            }
        }
        function getItemsCustom($data=Array(),$assignshow=Array()){
            if(empty($assignshow)){
                return;
            }    
            $html = '';
            foreach($assignshow as $cat){
                $terms = get_terms( array(
                    'taxonomy' => $cat,//$jwext_popup_assignshow,
                    'hide_empty' => true,// Whether to hide terms not assigned to any posts. Accepts 1|true or 0|false. Default 1|true.
                    //'fields'   => 'slug'//'fields'   => 'ids'// chi show ID
                ));
                if(empty($terms)){
                   continue; 
                }
                $hierarchy = _get_term_hierarchy( $cat );
                $cats = array();
                $this->sort_hierarchical($terms,$cats);
                
                $html .= '<optgroup label="Category: '.$cat.'">';
                foreach($cats as $st){
                    if($st->parent==0){
                        if(is_array($data) && $data && in_array($st->term_id, $data)){
                            $selected = 'selected';
                        }else{
                            $selected = '';
                        }
                        $html .= '<option value="'.$st->term_id.'" '.$selected.'>'.$st->name.'</option>';
                        
                        $htmlchild ='';
                        if($st->children && !empty($st->children)){
                            $this->showchild($st->children,$htmlchild,$data);
                        }
                        $html.= $htmlchild;
                    }
                }
                $html .= '</optgroup>';
                
                /*khong co sub cat*/
                /* $html .= '<optgroup label="Category: '.$cat.'">';
                    if(!empty($terms)){
                        foreach($terms as $t){
                            if(is_array($data) && $data && in_array($t->id, $data)){
                                $selected = 'selected';
                            }else{
                                $selected = '';
                            }
                            $html .= '<option value="'.$t->id.'" '.$selected.'>'.$t->name.'</option>';
                        }
                    }
                $html .= '</optgroup>';  */   
                /*khong co sub cat*/
            }
            return $html;
        }
                
    }
}
add_action( 'plugins_loaded', array( 'JWEXT_NEWS_TICKER_ANYWHERE', 'get_instance' ) );
