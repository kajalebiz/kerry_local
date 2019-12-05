<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Enqueue scripts and styles for the back end.
 */
function hubbb_admin_scripts() {
    
        global $wp_version;
    
    // Load our admin stylesheet.
	wp_enqueue_style( 'hubbb-admin-style', get_template_directory_uri() . '/css/admin-style.css' );

    // Load our admin script.
    wp_enqueue_script( 'hubbb-admin-script', get_template_directory_uri() . '/js/admin-script.js' );

        //localize script
        $newui = $wp_version >= '3.5' ? '1' : '0'; //check wp version for showing media uploader
        wp_localize_script( 'hubbb-admin-script', 'HUBBBADMIN', array(
                                                                        'new_media_ui'	=>  $newui,
                                                                    ));
        wp_enqueue_media();
}

/**
 * Enqueue scripts and styles for the front end.
 */
function hubbb_public_scripts() {

    // Load our bootstrap stylesheet.
    wp_enqueue_style( 'hubbb-admin-bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css' );

     // Load our font-awesome stylesheet.
    wp_enqueue_style( 'hubbb-admin-font-awesome', get_template_directory_uri() . '/css/all.min.css' );

    // Load our fancybox stylesheet.
    wp_enqueue_style( 'hubbb-admin-fancybox', get_template_directory_uri() . '/css/jquery.fancybox.css' );

	// Load our main stylesheet.
	wp_enqueue_style( 'hubbb-style', get_stylesheet_uri(), array(), NULL );
	
	// Load our public style stylesheet.
	wp_enqueue_style( 'hubbb-public-style', get_template_directory_uri() . '/css/public-style.css', array(), NULL );

           // Load main jquery
        wp_enqueue_script( 'jquery', array(), NULL );
        
    // Load our bootstrap script.
    wp_enqueue_script( 'hubbb-admin-bootstrap-js', get_template_directory_uri() . '/js/bootstrap.js' );

    // Load our slick script.
    wp_enqueue_script( 'hubbb-admin-slick-js', get_template_directory_uri() . '/js/slick.js' );
    
    //Load sticky js script.
    wp_enqueue_script( 'hubbb-public-sticky-js', get_template_directory_uri() . '/js/jquery.sticky-kit.js' );

    // Load our fancybox script.
    wp_enqueue_script( 'hubbb-admin-fancybox-js', get_template_directory_uri() . '/js/jquery.fancybox.min.js' );
        
    // Load public script
    wp_enqueue_script( 'hubbb-public-script', get_template_directory_uri() . '/js/public-script.js', array(), NULL );
}

/**
 * Enqueue scripts and styles for the admin login screen.
 */
function hubbb_login_stylesheet() {
    wp_enqueue_style( 'hubbb-login-style', get_stylesheet_directory_uri() . '/css/login-style.css' );
}

//add action to load scripts and styles for the back end
add_action( 'admin_enqueue_scripts', 'hubbb_admin_scripts' );

//add action load scripts and styles for the front end
add_action( 'wp_enqueue_scripts', 'hubbb_public_scripts' );

//add action load scripts and styles for admin login screen
add_action( 'login_enqueue_scripts', 'hubbb_login_stylesheet' );
?>