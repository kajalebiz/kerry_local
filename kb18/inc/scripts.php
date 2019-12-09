<?php
/**
* Scripts / Styles
*
* Handles front end scripts and styles.
*
* @package     Objectiv-Genesis-Child
* @since       1.0
* @author      Wes Cole <wes@objectiv.co>
*/

function objectiv_enqueue_scripts() {

        wp_register_script( 'new-countdown', get_stylesheet_directory_uri() . '/assets/js/jquery.countdown.min.js', '', true );
        wp_register_script( 'cookie', get_stylesheet_directory_uri() . '/assets/js/jquery-cookie.js', '', true );

	// Slick
	wp_register_script( 'slick', get_stylesheet_directory_uri() . '/assets/components/slick-carousel/slick/slick.min.js', '', true );
	wp_register_style( 'slick-css', get_stylesheet_directory_uri() . '/assets/components/slick-carousel/slick/slick.css' );

	// Typekit
	wp_register_style( 'typekit', 'https://use.typekit.net/qum1tar.css' );
	wp_enqueue_style( 'typekit' );
	wp_register_style( 'AddCalEvent',  get_stylesheet_directory_uri() . '/assets/styles/AddCalEvent.css' );
	wp_enqueue_style( 'AddCalEvent' );
	wp_register_style( 'fancybox',  'https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css' );
	wp_enqueue_style( 'fancybox' );

	// Scrollmagic
	// wp_enqueue_script( 'stickyness', get_stylesheet_directory_uri() . '/assets/components/jquery.sticky/jquery.sticky.js', array( 'jquery' ), false, true );

	// Modaal
	wp_register_script( 'modaal', get_stylesheet_directory_uri() . '/assets/components/modaal/dist/js/modaal.min.js', array( 'jquery' ), false, true );
	wp_register_style( 'modaal-css', get_stylesheet_directory_uri() . '/assets/components/modaal/dist/css/modaal.min.css' );
        
	// Isotope
	wp_register_script( 'isotope', get_stylesheet_directory_uri() . '/assets/components/isotope/isotope.pkgd.min.js', array( 'jquery' ), false, true );
	wp_enqueue_script( 'isotope' );
        
	// Isotope
	wp_register_script( 'fancybox', 'https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js', array( 'jquery' ), false, true );
	wp_enqueue_script( 'fancybox' );

	// Lazyload
	wp_register_script( 'lazyload', get_stylesheet_directory_uri() . '/assets/components/lazyload/lazyload.min.js', array( 'jquery' ), false, true );
	wp_enqueue_script( 'lazyload' );

	// ScrollTo
	wp_register_script( 'scrollto', get_stylesheet_directory_uri() . '/assets/components/jquery.scrollTo/jquery.scrollTo.min.js', array( 'jquery' ), false, true );
	wp_enqueue_script( 'scrollto' );

        wp_register_script( 'public-script', get_stylesheet_directory_uri() . '/assets/js/public-script.js', array( 'jquery' ), false, true );
	wp_register_script( 'AddCalEventZones-script', get_stylesheet_directory_uri() . '/assets/js/AddCalEventZones.js', array( 'jquery' ), false, true );
	wp_register_script( 'AddCalEvent-script', get_stylesheet_directory_uri() . '/assets/js/AddCalEvent.js', array( 'jquery' ), false, true );
        wp_enqueue_script( 'public-script' );
	wp_enqueue_script( 'AddCalEventZones-script' );
	wp_enqueue_script( 'AddCalEvent-script' );

	// Accessible Menu
	wp_register_script( 'gamajo-accessible-menu', get_stylesheet_directory_uri() . '/assets/components/accessible-menu/dist/jquery.accessible-menu.min.js', array( 'jquery' ), '1.0.2', true );
    wp_register_script( 'sitewide', get_bloginfo( 'stylesheet_directory' ) . '/assets/js/build/site-wide.min.js', array( 'gamajo-accessible-menu', 'jquery' ), '1.1.4', true );

	wp_enqueue_style( 'slick-css' );
	wp_enqueue_script( 'modaal' );
	wp_enqueue_style( 'modaal-css' );
	wp_enqueue_script( 'sitewide' );
	wp_enqueue_script( 'slick' );
	wp_enqueue_style( 'simple-share-buttons-adder-ssba' );
	wp_enqueue_script( 'new-countdown' );
    wp_enqueue_script( 'cookie' );
    wp_enqueue_style( 'cx-events-css' );

	$data_array = array(
		'stylesheetUrl' => get_stylesheet_directory_uri(),
		'ajaxurl' => admin_url('admin-ajax.php'),
	);

	wp_localize_script( 'sitewide', 'data', $data_array );

}

add_action( 'wp_enqueue_scripts', 'objectiv_enqueue_scripts' ); 

add_filter ( 'woocommerce_account_menu_items', 'misha_remove_my_account_links', 9999 );
function misha_remove_my_account_links( $menu_links ){
	unset( $menu_links['edit-address'] );  
	unset( $menu_links['members-area'] );  
        return $menu_links; 
}
remove_action( 'woocommerce_order_details_after_order_table', 'woocommerce_order_again_button' );
add_action('woocommerce_order_details_order_again','fun_woo_after_order_details_order_again_btn',10,1);
function fun_woo_after_order_details_order_again_btn( $order ){
    if ( ! $order || ! $order->has_status( apply_filters( 'woocommerce_valid_order_statuses_for_order_again', array( 'completed' ) ) ) || ! is_user_logged_in() ) {
        return;
    }

    wc_get_template(
        'order/order-again.php',
        array(
            'order'           => $order,
            'order_again_url' => wp_nonce_url( add_query_arg( 'order_again', $order->get_id(), wc_get_cart_url() ), 'woocommerce-order_again' ),
        )
    );
}

add_filter ('woocommerce_cart_item_permalink', 'custom_cart_item_permalink' , 10, 3 );
function custom_cart_item_permalink( $permalink, $cart_item, $cart_item_key ) {
    $product_url = get_field('page_redirect_link',$cart_item['product_id'] );
    if( !empty( $product_url ) ) {
        $permalink = $product_url;
    }
    return $permalink;
}

//add_filter( 'somfrp_retrieve_password_message','fun_somfrp_retrieve_password_message',10,4);
function fun_somfrp_retrieve_password_message( $message, $key, $user_login, $user_data ){
    
    $message = str_replace("{site_name}",'&site_url='.$_GET['site'],$message);
    return $message;
}

//add_filter( 'wp_nav_menu_objects', 'my_dynamic_menu_items' );
function my_dynamic_menu_items( $menu_items ) {
    if( !is_user_logged_in() ) {
        foreach ( $menu_items as $menu_item ) {
            if ( in_array('my-account-item',$menu_item->classes) ) {
                $menu_item->title =  "Login";
            }
        }
    }

    return $menu_items;
} 