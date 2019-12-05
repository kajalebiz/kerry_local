<?php

/*
Template Name: Speaking Webinars
 */

// full width layout
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

// Remove 'site-inner' from structural wrap
add_theme_support( 'genesis-structural-wraps', array( 'header', 'nav', 'subnav', 'footer-widgets', 'footer' ) );

//* Add custom body class to the head
add_filter( 'body_class', 'obj_service_landing_body_class' );
function obj_service_landing_body_class( $classes ) {

	$classes[] = 'speaking-webinars colored-title';
	return $classes;

}

add_action( 'objectiv_page_content', 'obj_spw_page_sections' );
function obj_spw_page_sections() {
	obj_spw_jump_nav();
	obj_spw_intro_content();
	obj_spw_featured_clients();
	obj_spw_why_kerry();
	obj_spw_angled_image();
	obj_spw_what_youll_get();
	obj_spw_footer_form();
}

function obj_spw_jump_nav() {
	$jump_nav = get_field( 'sk_jump_nav_details' );

	if ( ! empty( $jump_nav ) ) {
		$jump_nav_section = array(
			'section_paddings' => 'none',
			'section_margins'  => 'none',
			'jump_nav_items'   => $jump_nav['jump_nav_items'],
		);

		obj_jump_nav_section( $jump_nav_section );
	}
}

function obj_spw_intro_content() {
	$content = get_field( 'sk_first_content' );

	if ( ! empty( $content ) ) {
		$content_section = array(
			'section_id'       => $content['section_id'],
			'section_paddings' => 'top',
			'section_margins'  => 'none',
			'content'          => $content['content'],
			'classes'          => 'large-first-p larger-text',
		);

		$bg_shapes = array(
			'oval' => 1,
			'rect' => 1,
		);

		obj_content_section( $content_section, 'bg-light-gray', $bg_shapes );
	}
}

function obj_spw_why_kerry() {
	$sec_id      = get_field( 'sk_why_kerry_section_id' );
	$vid_url     = get_field( 'sk_why_kerry_video_url' );
	$vid_thumb   = get_field( 'sk_why_kerry_video_thumbnail' );
	$sec_title   = get_field( 'sk_why_kerry_section_title' );
	$sec_blurb   = get_field( 'sk_why_kerry_section_blurb' );
	$grid_blocks = get_field( 'sk_why_kerry_grid_blocks' );
	$testimonial = get_field( 'sk_why_kerry_testimonial' );
	$button      = get_field( 'sk_why_kerry_button' );

	$why_kerry = array(
		'section_id'       => $sec_id['section_id'],
		'section_paddings' => 'top',
		'section_margins'  => 'none',
		'video_url'        => $vid_url,
		'video_thumb'      => $vid_thumb,
		'sec_title'        => $sec_title,
		'sec_blurb'        => $sec_blurb,
		'grid_blocks'      => $grid_blocks['blocks'],
		'testimonial'      => $testimonial['testimonial'],
		'sec_button'       => $button,
	);

	$bg_shapes = array(
		'oval' => 1,
		'rect' => 1,
	);

	if ( ! empty( $why_kerry ) ) {
		obj_do_why_kerry_section( $why_kerry, 'bg-light-gray', $bg_shapes );
	}
}

function obj_spw_angled_image() {
	$image = get_field( 'sw_angled_image' );
	if ( ! empty( $image ) ) {
		obj_do_top_angled_image( $image, 'bg-light-gray' );
	}
}

function obj_spw_featured_clients() {
	$fc_deets = get_field( 'sk_featured_client_details' );

	if ( ! empty( $fc_deets ) ) {
		$featured_clients_section = array(
			'section_id'            => $fc_deets['section_id'],
			'section_paddings'      => 'none',
			'section_margins'       => 'none',
			'section_wrap'          => false,
			'section_title'         => $fc_deets['section_title'],
			'featured_clients_grid' => $fc_deets['featured_clients_grid'],
			'bottom_image'          => $fc_deets['bottom_image'],
		);

		obj_do_featured_clients_section( $featured_clients_section, 'bg-light-gray' );

	}
}

function obj_spw_what_youll_get() {
	$sec_id       = get_field( 'sk_wyg_section_id' );
	$sec_title    = get_field( 'sk_wyg_section_title' );
	$sec_intro    = get_field( 'sk_wyg_section_intro' );
	$side_by_side = get_field( 'sk_wyg_side_by_side_sections' );
	$lower_title  = get_field( 'sk_wyg_lower_title' );
	$lower_blurb  = get_field( 'sk_wyg_lower_blurb' );
	$grid_blocks  = get_field( 'sk_wyg_blocks' );

	$what_you_get_section = array(
		'section_id'       => $sec_id['section_id'],
		'section_paddings' => 'top',
		'section_margins'  => 'none',
		'section_title'    => $sec_title,
		'section_intro'    => $sec_intro,
		'side_by_side'     => $side_by_side,
		'lower_title'      => $lower_title,
		'lower_blurb'      => $lower_blurb,
		'grid_blocks'      => $grid_blocks['blocks'],
	);

	$bg_shapes = array(
		'oval' => 1,
		'rect' => 1,
	);

	obj_do_what_youll_get_section( $what_you_get_section, '', $bg_shapes );
}

function obj_spw_footer_form() {
	$foot_form_sec = get_field( 'sk_footer_form_details' );
	$sec_id        = get_field( 'sk_footer_section_id' );

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
