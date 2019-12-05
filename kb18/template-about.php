<?php

/*
Template Name: About
 */

// full width layout
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

// Remove 'site-inner' from structural wrap
add_theme_support( 'genesis-structural-wraps', array( 'header', 'nav', 'subnav', 'footer-widgets', 'footer' ) );

//* Add custom body class to the head
add_filter( 'body_class', 'obj_about_us_body_class' );
function obj_about_us_body_class( $classes ) {

	$classes[] = 'about-template colored-title';
	return $classes;

}

add_action( 'objectiv_page_content', 'obj_about_page_sections' );
function obj_about_page_sections() {
	obj_about_intro_content();
	obj_about_team();
	obj_about_social();
	obj_about_featured_clients();
	obj_about_footer_cta();
}

function obj_about_intro_content() {
	$content     = get_field( 'first_content' );
	$text_blocks = get_field( 'first_content_blocks' );
	$left_block  = get_field( 'first_content_left' );
	$right_block = get_field( 'first_content_right' );
	$two_wide    = array();

	if ( ! empty( $right_block ) && ! empty( $left_block ) ) {
		$two_wide['left']  = $left_block;
		$two_wide['right'] = $right_block;
	}

	if ( ! empty( $content ) ) {
		$content_section = array(
			'section_id'       => $content['section_id'],
			'section_paddings' => 'top',
			'section_margins'  => 'none',
			'content'          => $content['content'],
			'classes'          => 'large-first-p larger-text',
			'text-blocks'      => $text_blocks,
			'two-wide'         => $two_wide,
		);

		$bg_shapes = array(
			'amp' => 4,
		);

		obj_content_section( $content_section, '', $bg_shapes );
	}
}

function obj_about_team() {
	$staff_title = get_field( 'team_section_title' );
	$staff       = get_field( 'team_team_members' );

	if ( ! empty( $staff ) ) {
		$event_staff_section = array(
			'section_id'       => '',
			'section_paddings' => 'both',
			'section_margins'  => 'none',
			'section_wrap'     => true,
			'staff'            => $staff,
			'sec_title'        => $staff_title,
		);

		obj_event_staff_section( $event_staff_section, '' );
	}
}

function obj_about_social() {
	$testimonial = get_field( 'social_testimonial' );
	$insta       = get_field( 'social_instagram' );

	if ( ! empty( $testimonial ) || $insta ) {
		$about_social = array(
			'section_id'       => '',
			'section_paddings' => 'none',
			'section_margins'  => 'none',
			'section_wrap'     => true,
			'testimonial'      => $testimonial,
			'insta'            => $insta,
		);

		obj_about_social_section( $about_social, '' );
	}
}

function obj_about_featured_clients() {
	$fc_deets  = get_field( 'featured_client_details' );
	$fc_button = get_field( 'featured_clients_button' );

	if ( ! empty( $fc_deets ) ) {
		$featured_clients_section = array(
			'section_id'            => $fc_deets['section_id'],
			'section_paddings'      => 'none',
			'section_margins'       => 'none',
			'section_wrap'          => false,
			'section_title'         => $fc_deets['section_title'],
			'featured_clients_grid' => $fc_deets['featured_clients_grid'],
			'cta-button'            => $fc_button,
		);

		obj_do_featured_clients_section( $featured_clients_section, 'no-bottom-padding' );

	}
}

function obj_about_footer_cta() {
	$foot_cta_details = get_field( 'footer_cta_details' );

	if ( ! empty( $foot_cta_details ) ) {
		$foot_cta_section = array(
			'section_id'       => 'foot-cta',
			'section_paddings' => 'none',
			'section_wrap'     => false,
			'section_margins'  => 'none',
			'footer_cta'       => $foot_cta_details,
		);

		obj_foot_cta( $foot_cta_section, 'bg-yellow' );
	}
}

// Build the page
get_header();
do_action( 'objectiv_page_content' );
get_footer();
