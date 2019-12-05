<?php

/*
Template Name: Events List
*/

// full width layout
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

// Remove 'site-inner' from structural wrap
add_theme_support( 'genesis-structural-wraps', array( 'header', 'nav', 'subnav', 'footer-widgets', 'footer' ) );

//* Add custom body class to the head
add_filter( 'body_class', 'obj_events_body_class' );
function obj_events_body_class( $classes ) {

	$classes[] = 'event-list colored-title';
	return $classes;

}

add_action( 'objectiv_page_content', 'obj_event_page_sections' );
function obj_event_page_sections() {
	obj_events_first_content();
	obj_events_angled_numbers_cta();
	obj_events_event_list();
	obj_events_footer_form();
}

function obj_events_first_content() {
	$content = get_field( 'first_content' );

	if ( ! empty( $content ) ) {
		$content_section = array(
			'section_id'       => $content['section_id'],
			'section_paddings' => 'top',
			'section_margins'  => 'none',
			'content'          => $content['content'],
		);

		$bg_shapes = array(
			'oval' => 1,
			'rect' => 1,
		);

		obj_content_section( $content_section, '', $bg_shapes );
	}
}

function obj_events_angled_numbers_cta() {
	$angled_events_cta = array(
		'section_id'       => 'angled-events-cta',
		'section_paddings' => 'none',
		'section_margins'  => 'none',
		'section_wrap'     => false,
	);

	obj_angled_events_numbers_section( $angled_events_cta, '' );
}

function obj_events_event_list() {
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

	obj_events_list_section( $events_list_sec, '', $bg_shapes );
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
