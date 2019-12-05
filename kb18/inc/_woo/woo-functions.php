<?php

// All functions having to do with WooCommerce

//declare WC support
function objectiv_child_wc_support() {
  add_theme_support( 'woocommerce' );
}
add_action( 'after_setup_theme', 'objectiv_child_wc_support' );

//Full Width Pages on WooCommerce
function objectiv_shopping_cpt_layout() {
    if ( class_exists( 'WooCommerce' ) ) {
        if( is_page ( array( 'cart', 'checkout' )) || is_shop() || 'product' == get_post_type() ) {
            remove_action( 'genesis_sidebar', 'genesis_do_sidebar' );
            remove_action( 'genesis_sidebar', 'objectiv_do_podcast_sidebar' );
            return 'full-width-content';
        }
    }
}
add_filter( 'genesis_site_layout', 'objectiv_shopping_cpt_layout' );

/**
 * woo_hide_page_title
 *
 * Removes the "shop" title on the main shop page
 *
 * @access      public
 * @since       1.0
 * @return      void
*/
function objectiv_woo_hide_page_title() {
	return false;
}
add_filter( 'woocommerce_show_page_title' , 'objectiv_woo_hide_page_title' );

function objectiv_remove_wc_breadcrumbs() {
    remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
}
add_action( 'init', 'objectiv_remove_wc_breadcrumbs' );


function objectiv_wc_order_completed_subject_filter( $subject, $order ) {
    $subject = str_replace('&amp;', '&', $subject);
    return $subject;
}

add_filter('woocommerce_email_subject_customer_completed_order', 'objectiv_wc_order_completed_subject_filter', 1, 2);


function objectiv_wc_change_return_to_shop_text( $translated_text, $text, $domain ) {
    switch ( $translated_text ) {
        case 'Return to shop':
            $translated_text = __( 'Return to resources', 'woocommerce' );
            break;
    }
    return $translated_text;
}
add_filter( 'gettext', 'objectiv_wc_change_return_to_shop_text', 20, 3 );

function iconic_cart_count_fragments( $fragments ) {
    $fragments['a.icon-cart.icon-cart--desktop'] = '<a href="/cart/" class="icon-cart icon-cart--desktop" title="View your shopping cart"><div class="icon-cart__counter">' . WC()->cart->get_cart_contents_count() . '</div></a>';
    return $fragments;
}

add_filter( 'woocommerce_add_to_cart_fragments', 'iconic_cart_count_fragments', 10, 1 );


function objectiv_wc_change_order_received_text( $str, $order ) {
    $new_str = 'Thank you. Check your inbox for your download.';
    return $new_str;
}
add_filter('woocommerce_thankyou_order_received_text', 'objectiv_wc_change_order_received_text', 10, 2 );