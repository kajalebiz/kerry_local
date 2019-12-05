<?php

/*
Template Name: CXPA landing
 */

// full width layout
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

// Remove 'site-inner' from structural wrap
add_theme_support( 'genesis-structural-wraps', array( 'header', 'nav', 'subnav', 'footer-widgets', 'footer' ) );

//* Add custom body class to the head
add_filter( 'body_class', 'obj_cxpa_landing_body_class' );
function obj_cxpa_landing_body_class( $classes ) {

	$classes[] = 'jmap-coaching colored-title';
	return $classes;

}

add_action( 'objectiv_page_content', 'obj_cxpa_landing_sections' );
function obj_cxpa_landing_sections() {
	obj_cxpa_jump_nav();
	obj_cxpa_page_intro();
	obj_cxpa_add_to_calender();
	obj_cxpa_angled_cta();
	obj_cxpa_events_list();
	obj_cxpa_foot_form();
} 
 
function obj_cxpa_jump_nav() {
	$jump_nav = get_field( 'jump_nav_details' );

	if ( ! empty( $jump_nav ) ) {
		$jump_nav_section = array(
			'section_paddings' => 'none',
			'section_margins'  => 'none',
			'jump_nav_items'   => $jump_nav['jump_nav_items'],
		);

		obj_jump_nav_section( $jump_nav_section );
	}
}

function obj_cxpa_page_intro(){
    $content = get_field( 'cxpa_intro_content' );

	if ( ! empty( $content ) ) {
		$content_section = array(
			'section_id'       => $content['section_id'],
			'section_paddings' => 'both',
			'section_margins'  => 'none',
			'content'          => $content['content'],
		);

		$bg_shapes = array(
			'oval' => 1,
			'rect' => 1,
		);

		obj_content_section( $content_section, 'bg-light-gray cxpaintro', $bg_shapes );
	}
}

function obj_cxpa_add_to_calender(){
    
    $atc_id     = get_field( 'cxpa_event_atc_section_id' );
    $atc_events = get_field( 'cxpa_add_to_calendar' );
    
    if ( ! empty( $atc_events ) ) {
	$atc_events_section = array(
		'section_id'       => $atc_id['section_id'],
		'section_paddings' => 'none',
		'section_margins'  => 'none',
                'atc_events'       => $atc_events  

	);
        
        obj_add_to_calender_section( $atc_events_section, '' );
        
    }
    
}

function obj_cxpa_angled_cta(){
    
    $slider_id      = get_field( 'cxpa_angled_section_id' );
    $slider_content = get_field( 'cxpa_single_slides' );

    if ( ! empty( $slider_content ) ) {
            $slider_section = array(
                    'section_id'       => $slider_id['section_id'],
                    'section_paddings' => 'none',
                    'section_margins'  => 'none',
                    'section_wrap'     => false,
                    'slides'           => $slider_content['angled_slides'],
            );

            obj_angled_slider( $slider_section, 'cxpa_angled' );
    }
    
}

function obj_cxpa_events_list(){
    $cxpa_event_list_id = get_field( 'cxpa_event_list_id' );
    $cxpa_select_events = get_field( 'cxpa_blocks_listing' );
    if ( ! empty( $cxpa_select_events ) ) {
        $event_section = array(
            'section_id'       => $cxpa_event_list_id['section_id'],
            'section_paddings' => 'none',
            'section_margins'  => 'none',
            'content'          => $cxpa_select_events,
        );
        
        $bg_shapes = array(
		'oval' => 1,
                'rect' => 1,

	);
        
        obj_cxpa_event_list( $event_section, 'home-lower-row-1 home-lower-row home_resources_main cxpa-event-lists', $bg_shapes );
        
    }
}

function obj_cxpa_foot_form(){
    
    $cxpa_foot_id           = get_field( 'cxpa_foot_id' );
    $cxpa_ft_form_title     = get_field( 'cxpa_ft_form_title' );
    $cxpa_footer_form_des   = get_field( 'cxpa_footer_form_des' );
    $cxpa_ft_form           = get_field( 'cxpa_ft_form' );

    if ( ! empty( $cxpa_ft_form ) ) {
            $footer_form_section = array(
                    'section_id'       => $cxpa_foot_id['section_id'],
                    'section_paddings' => 'none',
                    'section_margins'  => 'none',
                    'section_wrap'     => false,
                    'section_title'    => $cxpa_ft_form_title['section_title'],
                    'form'             => $cxpa_ft_form['form_to_display'],
                    'form_description' => $cxpa_footer_form_des,
            );
            
            $blurb = $cxpa_footer_form_des;

            obj_do_footer_form_cta_section( $footer_form_section, 'bg-light-gray cxpa-foot-form', '', $blurb );

    }
    
}
	// Build the page
get_header();
do_action( 'objectiv_page_content' );
get_footer();
