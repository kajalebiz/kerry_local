<?php

/*
Template Name: CX Event Submission
*/

// full width layout
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

// Remove 'site-inner' from structural wrap
add_theme_support( 'genesis-structural-wraps', array( 'header', 'nav', 'subnav', 'footer-widgets', 'footer' ) );

// Add custom body class to the head
add_filter( 'body_class', 'obj_events_body_class' );
function obj_events_body_class( $classes ) {

	$classes[] = 'cx-event-submission-page colored-title';
	return $classes;

}

add_action( 'objectiv_page_content', 'obj_event_submission_page_sections' );
function obj_event_submission_page_sections() {
    $intro_text = evt_helper_get_intro_text();
    $html_form  = evt_helper_get_submission_form();
    obj_cx_event_submission_form( $intro_text, $html_form );
}

/**
 * Output the event submission form
 */
function obj_cx_event_submission_form( $intro_text, $html_form ) {
	$submission_form_deets = array(
		'section_id'       => 'cx-event-submission-form',
		'section_paddings' => 'both',
		'section_margins'  => 'none',
		'section_wrap'     => true,
	);

	$bg_shapes = array(
		'oval' => 1,
		'rect' => 1,
	);

	obj_cx_event_submission_form_section( $intro_text, $html_form, $submission_form_deets, 'content-section', $bg_shapes );
}

// Build the page
get_header();
do_action( 'objectiv_page_content' );
get_footer();