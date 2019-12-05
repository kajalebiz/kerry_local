<?php

/*
Template Name: Privacy Policy
 */

// full width layout
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

// Remove 'site-inner' from structural wrap
add_theme_support( 'genesis-structural-wraps', array( 'header', 'nav', 'subnav', 'footer-widgets', 'footer' ) );

//* Add custom body class to the head
add_filter( 'body_class', 'obj_privacy_body_class' );
function obj_privacy_body_class( $classes ) {

	$classes[] = 'privacy-page super-short-banner';
	return $classes;

}

add_action( 'objectiv_page_content', 'obj_privacy_page_sections' );
function obj_privacy_page_sections() {
	obj_privacy_intro_content();
	obj_privacy_footer_form();
}

function obj_privacy_intro_content() {
	$content = get_field( 'first_content' );
	if ( function_exists( 'eae_encode_emails' ) ) {
		$content = eae_encode_emails( $content );
	}

	if ( ! empty( $content ) ) {
		$content_section = array(
			'section_id'       => 'privacy-content',
			'section_paddings' => 'top',
			'section_margins'  => 'none',
			'content'          => $content,
		);

		obj_content_section( $content_section, 'bg-light-gray' );
	}
}

function obj_privacy_footer_form() {
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
