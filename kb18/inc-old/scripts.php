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

	// Scrollmagic
	// wp_enqueue_script( 'stickyness', get_stylesheet_directory_uri() . '/assets/components/jquery.sticky/jquery.sticky.js', array( 'jquery' ), false, true );

	// Modaal
	wp_register_script( 'modaal', get_stylesheet_directory_uri() . '/assets/components/modaal/dist/js/modaal.min.js', array( 'jquery' ), false, true );
	wp_register_style( 'modaal-css', get_stylesheet_directory_uri() . '/assets/components/modaal/dist/css/modaal.min.css' );
        
	// Isotope
	wp_register_script( 'isotope', get_stylesheet_directory_uri() . '/assets/components/isotope/isotope.pkgd.min.js', array( 'jquery' ), false, true );
	wp_enqueue_script( 'isotope' );

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
