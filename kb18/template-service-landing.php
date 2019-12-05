<?php

/*
Template Name: Service Landing
 */

// full width layout
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

// Remove 'site-inner' from structural wrap
add_theme_support( 'genesis-structural-wraps', array( 'header', 'nav', 'subnav', 'footer-widgets', 'footer' ) );

//* Add custom body class to the head
add_filter( 'body_class', 'obj_service_landing_body_class' );
function obj_service_landing_body_class( $classes ) {

	$classes[] = 'service-landing';
	return $classes;

}

add_action( 'objectiv_page_content', 'sl_page_sections' );
function sl_page_sections() {
	obj_sl_intro_content();
	obj_sl_angled_cta();
	obj_sl_lower();
}

function obj_sl_intro_content() {
	$content = get_field( 'sl_first_content' );

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

		obj_content_section( $content_section, '', $bg_shapes );
	}
}


function obj_sl_angled_cta() {
	$sec_id        = get_field( 'sl_angled_id' );
	$bg_image      = get_field( 'sl_bg_image' );
	$block_deets   = get_field( 'sl_block_details' );
	$cta_type      = get_field( 'sl_cta_type' );
	$angled_slider = get_field( 'sl_angled_slider' );

	if ( $cta_type !== 'slider' ) {
		$slide = array(
			'image'             => $bg_image,
			'block_title'       => $block_deets['block_title'],
			'block_sub_title'   => $block_deets['block_sub_title'],
			'block_button'      => $block_deets['block_button'],
			'block_button_type' => $block_deets['block_button_type'],
		);

		if ( ! empty( $slide ) ) {
			$angled_cta = array(
				'section_id'       => $sec_id['section_id'],
				'section_paddings' => 'none',
				'section_margins'  => 'none',
				'section_wrap'     => false,
				'cta_deets'        => $slide,
				'classes'          => '',
			);

			obj_angled_cta_section( $angled_cta, '' );
		}
	} else {
		$slider_content = $angled_slider;

		if ( ! empty( $slider_content ) ) {
			$slider_section = array(
				'section_id'       => $slider_content['section_id'],
				'section_paddings' => 'none',
				'section_margins'  => 'none',
				'section_wrap'     => false,
				'slides'           => $slider_content['angled_slides'],
			);

			obj_angled_slider( $slider_section, '' );
		}
	}

}

function obj_sl_lower() {
	$sec_id      = get_field( 'sl_low_section_id' );
	$sec_title   = get_field( 'sl_low_section_title' );
	$sec_blurb   = get_field( 'sl_low_blurb' );
	$cta_blocks  = get_field( 'sl_low_cta_blocks' );
	$testimonial = get_field( 'sl_low_testimonial' );
	$button      = get_field( 'sl_low_bottom_button' );

	$lower_section = array(
		'section_id'       => $sec_id['section_id'],
		'section_paddings' => 'both',
		'section_margins'  => 'none',
		'sec_title'        => $sec_title,
		'sec_blurb'        => $sec_blurb,
		'cta_blocks'       => $cta_blocks['cta_blocks'],
		'testimonial'      => $testimonial['testimonial'],
		'sec_button'       => $button,
	);

	$bg_shapes = array(
		'oval' => 1,
		'rect' => 1,
	);

	if ( ! empty( $lower_section ) ) {
		obj_do_service_land_lower_section( $lower_section, '', $bg_shapes );
	}
}

// Build the page
get_header();
do_action( 'objectiv_page_content' );
get_footer();
