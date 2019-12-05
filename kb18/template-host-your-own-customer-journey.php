<?php

/*
Template Name: Host Your Own Customer Journey
*/

// full width layout
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

// Remove 'site-inner' from structural wrap
add_theme_support( 'genesis-structural-wraps', array( 'header', 'nav', 'subnav', 'footer-widgets', 'footer' ) );

//* Add custom body class to the head
add_filter( 'body_class', 'obj_journey_development_body_class' );
function obj_journey_development_body_class( $classes ) {

	$classes[] = 'ed-bootcamps colored-title';
	return $classes;

}

add_action( 'objectiv_page_content', 'obj_host_your_own_cj_page_sections' );
function obj_host_your_own_cj_page_sections() {

	obj_host_your_own_cj_jump_nav();
	obj_hyo_cj_angled_tabs();
	obj_host_your_own_cj_leaders();
	obj_host_your_own_cj_cta();
}

function obj_host_your_own_cj_jump_nav() {
	$jump_nav = get_field( 'jump_nav_details' );

	if ( ! empty( $jump_nav ) ) {
		$jump_nav_section = array(
			'section_paddings' => 'none',
			'section_margins'  => 'none',
			'jump_nav_items'   => $jump_nav['jump_nav_items'],
		);

		obj_jump_nav_section( $jump_nav_section, 'darker' );
	}
}

function obj_hyo_cj_angled_tabs() {
	$tab_content = get_field( 'why_host_your_own_cj_tabs' );
	$sec_title   = get_field( 'why_host_your_own_cj_section_title' );
	$display     = is_array( $tab_content ) && array_key_exists( 'cta_blocks', $tab_content ) && ! empty( $tab_content['cta_blocks'] );

	if ( ! empty( $tab_content ) && $display ) {
		$tab_section = array(
			'section_id'       => $tab_content['section_id'],
			'section_paddings' => 'none',
			'section_margins'  => 'none',
			'tabs'             => $tab_content['cta_blocks'],
			'section_wrap'     => false,
			'second_sec_wrap'  => true,
			'sec_title'        => $sec_title,
		);

		obj_tabbed_cta( $tab_section, 'in-bg-page angled-bottom white-active white-blurb dark-title' );
	}
}

function obj_host_your_own_cj_leaders() {
	$staff_title = get_field( 'host_your_own_cj_staff_title' );
	$staff       = get_field( 'staff_for_this_host_your_own_cj' );
	$sec_id      = get_field( 'host_your_own_cj_staff_sec_id' );

	if ( ! empty( $staff ) ) {
		$event_staff_section = array(
			'section_id'       => $sec_id['section_id'],
			'section_paddings' => 'none',
			'section_margins'  => 'none',
			'section_wrap'     => true,
			'staff'            => $staff,
			'sec_title'        => $staff_title,
		);

		$bg_shapes = array(
			'oval' => 1,
			'rect' => 1,
		);

		obj_event_staff_section( $event_staff_section, 'bg-light-gray host-your-own-page section-padding-top section-padding-bottom', $bg_shapes );
	}
}

function obj_host_your_own_cj_cta() {
	$foot_form_sec = get_field( 'footer_form_details' );
	$sec_id        = get_field( 'footer_section_id' );

	if ( ! empty( $foot_form_sec ) ) {
		$footer_form_section = array(
			'section_id'       => $sec_id['section_id'],
			'section_paddings' => 'none',
			'section_margins'  => 'none',
			'section_wrap'     => false,
			'section_title'    => $foot_form_sec['section_title'],
			'form'             => $foot_form_sec['form_to_display'],
		);

		obj_do_footer_form_cta_section( $footer_form_section, 'bg-light-gray' );

	}
}

// Build the page
get_header();
do_action( 'objectiv_page_content' );
get_footer();
