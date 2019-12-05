<?php
    // Exit if accessed directly
    if ( !defined( 'ABSPATH' ) ) exit;

    /**
    * Escape Tags & Slashes
    *
    * Handles escapping the slashes and tags
    */
    function hubbb_escape_attr($data) {
        return !empty( $data ) ? esc_attr( stripslashes( $data ) ) : '';
    }

    /**
    * Strip Slashes From Array
    */
    function hubbb_escape_slashes_deep($data = array(),$flag=true) {

        if($flag != true) {
             $data = hubbb_nohtml_kses($data);
        }
        $data = stripslashes_deep($data);
        return $data;
    }

    /**
    * Strip Html Tags 
    * 
    * It will sanitize text input (strip html tags, and escape characters)
    */
    function hubbb_nohtml_kses($data = array()) {

        if ( is_array($data) ) {
            $data = array_map(array($this,'hubbb_nohtml_kses'), $data);
        } elseif ( is_string( $data ) ) {
            $data = wp_filter_nohtml_kses($data);
        }
       return $data;
    }

    /**
     * Display Short Content By Character
     */
    function hubbb_excerpt_char( $content, $length = 40 ) {

        $text = '';
        if( !empty( $content ) ) {
            $text = strip_shortcodes( $content );
            $text = str_replace(']]>', ']]&gt;', $text);
            $text = strip_tags($text);
            $excerpt_more = apply_filters('excerpt_more', ' ' . ' ...');
            $text = substr($text, 0, $length);
            $text = $text . $excerpt_more;
        }
        return $text;
    }

    /**
     * search in posts and pages
     */
    function hubbb_filter_search( $query ) {
        if( !is_admin() && $query->is_search ) {
            $query->set( 'post_type', array( HUBBB_POST_POST_TYPE, HUBBB_PAGE_POST_TYPE ) );
        }
        return $query;
    }
    add_filter( 'pre_get_posts', 'hubbb_filter_search' );


    /*
     * Remove wp logo from admin bar
     */
    function hubbb_remove_wp_logo() {
        global $wp_admin_bar;

        if( class_exists('acf') ) {
            $wp_help  = get_field( 'hubbb_options_wp_help', 'option' );
            if( empty( $wp_help ) ) {
                $wp_admin_bar->remove_menu('wp-logo');
            }
        }
    }
    add_action( 'wp_before_admin_bar_render', 'hubbb_remove_wp_logo' );
    
    /*
     * Custom login logo
     */
    function hubbb_custom_login_logo() {
        if( class_exists('acf') ) {
            $wp_login_logo      = get_field( 'hubbb_options_login_logo', 'option' );
            $wp_login_w         = get_field( 'hubbb_options_login_logo_w', 'option' );
            $wp_login_h         = get_field( 'hubbb_options_login_logo_h', 'option' );
            $wp_login_bg        = get_field( 'hubbb_options_login_bg', 'option' );
            $wp_login_btn_c     = get_field( 'hubbb_options_login_btn_color', 'option' );
            $wp_login_btn_c_h   = get_field( 'hubbb_options_login_btn_color_h', 'option' );
            if( !empty( $wp_login_logo ) ) {
    ?>
            <style type="text/css">
                .login h1 a {
                    background-image: url('<?php echo $wp_login_logo; ?>') !important;
                    background-size: <?php echo $wp_login_w.'px'; ?> auto !important;
                    height: <?php echo $wp_login_h.'px'; ?> !important;
                    width: <?php echo $wp_login_w.'px'; ?> !important;
                }
            </style>
    <?php
            }
            if( !empty( $wp_login_bg ) ){
    ?>
            <style type="text/css">
                body.login{ background: #133759 url("<?php echo $wp_login_bg; ?>") no-repeat center; background-size: cover;}
                body.login div#login form#loginform input#wp-submit {background-color: <?php echo $wp_login_btn_c; ?> !important;}
                body.login div#login form#loginform input#wp-submit:hover {background-color: <?php echo $wp_login_btn_c_h; ?> !important;}
            </style>
    <?php
            }
        }
    }
    add_action( 'login_enqueue_scripts', 'hubbb_custom_login_logo' );
    
    /*
     * Change custom login page url
     */
    function hubbb_loginpage_custom_link() {
        $site_url = esc_url( home_url( '/' ) );
        return $site_url;
    }
    add_filter( 'login_headerurl', 'hubbb_loginpage_custom_link' );
    
    /*
     * Change title on logo
     */
    function hubbb_change_title_on_logo() {
        $site_title = get_bloginfo( 'name' );
        return $site_title;
    }
    add_filter( 'login_headertitle', 'hubbb_change_title_on_logo' );
    
    /*
     * Change admin your favicon
     */
    function hubbb_admin_favicon() {
        if( class_exists('acf') ) {
            $favicon_url        = get_field( 'hubbb_options_wp_favicon', 'option' );
            if( !empty( $favicon_url ) ){
                echo '<link rel="icon" type="image/x-icon" href="' . $favicon_url . '" />';
            }
        }
    }
    add_action('login_head', 'hubbb_admin_favicon');
    add_action('admin_head', 'hubbb_admin_favicon');

    /*
     * add filter to add shortcode in widget
     */
    add_filter( 'widget_text', 'do_shortcode' );
    
    function hubbb_get_user_plan($user_id, $plan_id){
        
        
        global $wpdb;
        $results = $wpdb->get_results( "SELECT post_parent FROM {$wpdb->base_prefix}posts WHERE post_author = $user_id AND post_type = 'wc_user_membership' AND post_status = 'wcm-active' ", OBJECT );
        if(!empty($results)) {
            if($results[0]->post_parent == $plan_id){
                return true;
            } else{
                return false;
            }   
        } elseif(is_super_admin($user_id)){
            return true;
        }else{
            return false;
        }
    }
    
    function is_user_has_membership(){
        if(is_user_logged_in()){
            if(is_super_admin()){
                return true;
            } elseif(hubbb_get_user_plan(get_current_user_id(), HUBBB_USE_CASE_BASIC_PLAN) == true){
                return true;
            } elseif (hubbb_get_user_plan(get_current_user_id(), HUBBB_USE_CASE_ADVANCE_PLAN) == true){
                return true;
            } elseif (hubbb_get_user_plan(get_current_user_id(), HUBBB_USE_CASE_ENTERPRISE_PLAN) == true){
                return true;
            } else{
                return false; 
            }        
        }else{
           return false;  
        }
    }
    function get_string_between($string, $start, $end){
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }
    
    add_action('wp_logout','hubbb_auto_redirect_after_logout');
    
    function hubbb_auto_redirect_after_logout(){
        if( class_exists("acf") ) {
            wp_redirect( get_field('hub_option_log_in_page' , 'option') );
        }
        exit();
    }
    
    function hubbb_acf_load_product_type_options($field) {
    
        $nav_menu = wp_get_nav_menus();
        if( !empty($nav_menu) ) {
            $field['choices'] = array();
            foreach ($nav_menu as $key => $menu){
                $field['choices'][$menu->slug] = $menu->name;
            }
            return $field;
        }
    }
    add_filter('acf/load_field/name=hub_select_sidebar_menu', 'hubbb_acf_load_product_type_options');
    
    function hubbb_starter_plan_user_posts(){
        $basic_users_post_ids = array();
        if( class_exists('acf') ) {
            $starter_plan_user_post = get_field('hub_basic_use_case_tab' ,get_option( 'page_on_front' ));
            if(!empty($starter_plan_user_post)) { 
                foreach($starter_plan_user_post as $starter_plan_user_post_val ){
                    $cur_post_id = $starter_plan_user_post_val['hub_basic_use_case_tab_link'];
                    if(!empty($cur_post_id)) {
                        $basic_users_post_ids[] = $cur_post_id->ID;
                    }
                }
                if(!empty($basic_users_post_ids)){
                    return $basic_users_post_ids;
                }else{
                    return null;
                }                 
            } else{
                return null;
            }
        } else{
            return null;
        }
    }
    
    add_action('init','hubbb_starter_plan_user_posts');
    
    function hubbb_pro_plan_user_posts(){
        $advance_users_post_ids = array();
        if( class_exists('acf') ) {
            $pro_plan_user_post = get_field('hub_advance_use_case_tab' ,get_option( 'page_on_front' ));
            if(!empty($pro_plan_user_post)) { 
                foreach($pro_plan_user_post as $pro_plan_user_post_val ){
                    $cur_post_id = $pro_plan_user_post_val['hub_advance_use_case_tab_link'];
                    if(!empty($cur_post_id)) {
                        $advance_users_post_ids[] = $cur_post_id->ID;
                    }
                }
                if(!empty($advance_users_post_ids)){
                    return $advance_users_post_ids;
                }else{
                    return null;
                }                 
            } else{
                return null;
            }
        } else{
            return null;
        }
    }
    
    add_action('init','hubbb_pro_plan_user_posts');
    
    function hubbb_enterprise_plan_user_posts(){
        $enterprise_users_post_ids = array();
        if( class_exists('acf') ) {
            $enterprise_plan_user_post = get_field('hub_enterprise_use_case_tab' ,get_option( 'page_on_front' ));
            if(!empty($enterprise_plan_user_post)) { 
                foreach($enterprise_plan_user_post as $enterprise_plan_user_post_val ){
                    $cur_post_id = $enterprise_plan_user_post_val['hub_enterprise_use_case_tab_link'];
                    if(!empty($cur_post_id)) {
                        $enterprise_users_post_ids[] = $cur_post_id->ID;
                    }
                }
                if(!empty($enterprise_users_post_ids)){
                    return $enterprise_users_post_ids;
                }else{
                    return null;
                }                 
            } else{
                return null;
            }
        } else{
            return null;
        }
    }
    
    add_action('init','hubbb_enterprise_plan_user_posts');
    
    add_action('after_setup_theme', 'hubbb_remove_admin_bar');
 
    function hubbb_remove_admin_bar() {
        if (!is_super_admin()) {
            show_admin_bar(false);
        }
    }
    
    /**
 * Disable autop shortcode for our html pages
 */
function bfp_clean_formatter($content) {
    $new_content = '';
    $pattern_full = '{(\[clean\].*?\[/clean\])}is';
    $pattern_contents = '{\[clean\](.*?)\[/clean\]}is';
    $pieces = preg_split($pattern_full, $content, -1, PREG_SPLIT_DELIM_CAPTURE);

    foreach ($pieces as $piece) {
        if (preg_match($pattern_contents, $piece, $matches)) {
            $new_content .= $matches[1];
        } else {
            $new_content .= wptexturize(wpautop($piece));
        }
    }

    return $new_content;
}

remove_filter('the_content', 'wpautop');
remove_filter('the_content', 'wptexturize');

add_filter('the_content', 'bfp_clean_formatter', 99);
?>