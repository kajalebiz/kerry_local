<?php
    // Exit if accessed directly
    if ( !defined( 'ABSPATH' ) ) exit;
    
    /*
     * Custom Theme Options
     */
    if( function_exists('acf_add_options_page') ) {

        // Hubbb General Settings
        $general_settings   = array(
                                    'page_title' 	=> __( 'Hubbb Settings(For Frontend View)', 'hubbb' ),
                                    'menu_title'	=> __( 'Hubbb Settings', 'hubbb' ),
                                    'menu_slug' 	=> 'hubbb-general-settings',
                                    'capability'	=> 'edit_posts',
                                    'redirect'          => false,
                                    'icon_url'          => 'dashicons-admin-customizer'
                                );
        acf_add_options_page( $general_settings );

        // Hubbb Header Settings
        $header_settings    = array(
                                        'page_title'    => __( 'Header Settings', 'hubbb' ),
                                        'menu_title'    => __( 'Header', 'hubbb' ),
                                        'parent_slug'   => 'hubbb-general-settings',
                                );
//        acf_add_options_sub_page( $header_settings );
        
        // Hubbb Social Settings
        $social_settings    = array(
                                        'page_title'    => __( 'Social Settings', 'hubbb' ),
                                        'menu_title'    => __( 'Social', 'hubbb' ),
                                        'parent_slug'   => 'hubbb-general-settings',
                                );
//        acf_add_options_sub_page( $social_settings );

        // Hubbb Footer Settings
        $footer_settings    = array(
                                        'page_title'    => __( 'Footer Settings', 'hubbb' ),
                                        'menu_title'    => __( 'Footer', 'hubbb' ),
                                        'parent_slug'   => 'hubbb-general-settings',
                                );
//        acf_add_options_sub_page( $footer_settings );
        
        // Hubbb Admin Settings
        $general_settings   = array(
                                    'page_title' 	=> __( 'Hubbb Admin Settings(For Frontend View)', 'hubbb' ),
                                    'menu_title'	=> __( 'Hubbb Admin Settings', 'hubbb' ),
                                    'menu_slug' 	=> 'hubbb-admin-settings',
                                    'capability'	=> 'edit_posts',
                                    'redirect'          => false,
                                    'icon_url'          => 'dashicons-admin-generic'
                                );
        acf_add_options_page( $general_settings );
    }