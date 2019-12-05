<?php

/*
Template Name: CX Events List
*/

// full width layout
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

// Remove 'site-inner' from structural wrap
add_theme_support( 'genesis-structural-wraps', array( 'header', 'nav', 'subnav', 'footer-widgets', 'footer' ) );

// Add custom body class to the head
add_filter( 'body_class', 'obj_events_body_class' );
function obj_events_body_class( $classes ) {

	$classes[] = 'event-list colored-title';
	return $classes;

}

add_action( 'objectiv_page_content', 'obj_event_page_sections' );
function obj_event_page_sections() {

    // Show featured events
    $featured = evt_helper_get_sponsored_events();
    obj_cx_events_featured( $featured );

    // our events grid
    $the_query = evt_helper_get_all_events_query();
    if ($the_query->have_posts() ) {
        $events     = evt_helper_load_all_events( $the_query->posts );
        $pagination = evt_helper_get_pagination($the_query);
        obj_cx_events_event_list( $events, $featured['bottom_banner'], $pagination );
    }else {
        $events     = evt_helper_load_all_events( array() );
        $pagination = '';
        obj_cx_events_event_list( $events, $featured['bottom_banner'], $pagination );
    }

    // the footer form
    obj_events_footer_form();
}


/**
 * Output the featured event list
 */
function obj_cx_events_featured( $events ) {
	$events_feat_sec = array(
		'section_id'       => 'cx-featured-events',
		'section_paddings' => 'both',
		'section_margins'  => 'none',
		'section_wrap'     => true,
	);
	obj_cx_events_featured_section( $events, $events_feat_sec, '' );
}

/**
 * Output the event list
 */
function obj_cx_events_event_list( $events, $bottom_banner, $pagination ) {
	$events_list_sec = array(
		'section_id'       => 'events-list',
		'section_paddings' => 'both',
		'section_margins'  => 'none',
		'section_wrap'     => true,
	);

	$bg_shapes = array(
		'oval' => 4,
		'rect' => 4,
	);

	obj_cx_events_list_section( $events, $bottom_banner, $pagination, $events_list_sec, '', $bg_shapes );
}

function obj_events_footer_form() {
	$foot_form_sec = get_field( 'footer_form_details' );
	$sec_id        = get_field( 'footer_section_id' );
	$blurb         = get_field( 'footer_form_blurb' );

	if ( ! empty( $foot_form_sec ) ) {
		$footer_form_section = array(
			'section_id'       => $sec_id['section_id'],
			'section_paddings' => 'none',
			'section_margins'  => 'none',
			'section_wrap'     => false,
			'section_title'    => $foot_form_sec['section_title'],
			'form'             => $foot_form_sec['form_to_display'],
		);

		obj_do_footer_form_cta_section( $footer_form_section, 'bg-light-gray', null, $blurb );

	}
}

// Build the page
get_header();
do_action( 'objectiv_page_content' );
get_footer();