<?php

/*
Template Name: Culture Creation
 */

// full width layout
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

// Remove 'site-inner' from structural wrap
add_theme_support( 'genesis-structural-wraps', array( 'header', 'nav', 'subnav', 'footer-widgets', 'footer' ) );

//* Add custom body class to the head
add_filter( 'body_class', 'obj_journey_development_body_class' );
function obj_journey_development_body_class( $classes ) {

	$classes[] = 'culture-creation colored-title';
	return $classes;

}

add_action( 'objectiv_page_content', 'obj_cc_page_sections' );
function obj_cc_page_sections() {
	obj_cc_jump_nav();
	obj_cc_intro_content();
	obj_cc_angled_tabs();
	obj_cc_what_youll_get();
	obj_cc_footer_form();
}

function obj_cc_jump_nav() {
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

function obj_cc_intro_content() {
	$sec_title   = get_field( 'first_content_section_title' );
	$content     = get_field( 'first_content' );
	$text_blocks = get_field( 'first_content_text_blocks' );

	if ( ! empty( $content ) ) {
		$content_section = array(
			'section_id'       => $content['section_id'],
			'section_paddings' => 'top',
			'section_margins'  => 'none',
			'content'          => $content['content'],
			'classes'          => 'large-first-p larger-text',
			'sec_title'        => $sec_title,
			'blocks'           => $text_blocks['blocks'],
		);

		$bg_shapes = array(
			'oval' => 1,
			'rect' => 1,
		);

		obj_content_section( $content_section, '', $bg_shapes );
	}
}

function obj_cc_angled_tabs() {
	$tab_content  = get_field( 'how_it_works_tabs' );
	$sec_title    = get_field( 'how_it_works_section_title' );
	$bottom_image = get_field( 'how_it_works_bottom_image' );

	if ( ! empty( $tab_content ) ) {
		$tab_section = array(
			'section_id'       => $tab_content['section_id'],
			'section_paddings' => 'none',
			'section_margins'  => 'none',
			'tabs'             => $tab_content['cta_blocks'],
			'section_wrap'     => false,
			'second_sec_wrap'  => true,
			'sec_title'        => $sec_title,
			'bottom_image'     => $bottom_image,
		);

		obj_tabbed_cta( $tab_section, 'in-bg-page angled-top white-active white-blurb dark-title' );
	}
}

function obj_cc_what_youll_get() {
	$sec_id            = get_field( 'what_youll_get_section_id' );
	$sec_title         = get_field( 'what_youll_get_section_title' );
	$sec_intro         = get_field( 'what_youll_get_section_intro' );
	$image_grid_blocks = get_field( 'what_youll_get_blocks' );
	$testimonial       = get_field( 'what_youll_get_testimonial' );

	$what_you_get_section = array(
		'section_id'        => $sec_id['section_id'],
		'section_paddings'  => 'top',
		'section_margins'   => 'none',
		'section_title'     => $sec_title,
		'section_intro'     => $sec_intro,
		'image_grid_blocks' => $image_grid_blocks['image_grid_blocks'],
		'testimonial'       => $testimonial['testimonial'],
	);

	$bg_shapes = array(
		'oval' => 1,
		'rect' => 1,
	);

	obj_do_what_youll_get_section( $what_you_get_section, '', $bg_shapes );
}

function obj_cc_footer_form() {
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

		obj_do_footer_form_cta_section( $footer_form_section, '' );

	}
}



	// Build the page
get_header();
do_action( 'objectiv_page_content' );
get_footer();
