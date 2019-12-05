<?php

/*
Template Name: What We Do
 */

// full width layout
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

// Remove 'site-inner' from structural wrap
add_theme_support( 'genesis-structural-wraps', array( 'header', 'nav', 'subnav', 'footer-widgets', 'footer' ) );

add_action( 'objectiv_page_content', 'wwd_page_sections' );
function wwd_page_sections() {
	obj_wwd_intro_content();
	obj_wwd_services_block();
	obj_wwd_block_ctas();
	obj_wwd_footer_cta();
}

function obj_wwd_intro_content() {
	$content = get_field( 'wwd_intro_content' );

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

		obj_content_section( $content_section, 'bg-light-gray', $bg_shapes );
	}
}

function obj_wwd_services_block() {
	$service_sections = get_field( 'wwd_service_sections' );

	if ( ! empty( $service_sections ) && is_array( $service_sections ) ) {
		foreach ( $service_sections as $ss ) {
			$service_section = array(
				'section_id'       => $ss['section_id'],
				'section_paddings' => 'bottom',
				'section_wrap'     => false,
				'section_margins'  => 'none',
				'section_color'    => $ss['colors'],
				'tabs'             => $ss['cta_blocks'],
				'top_info'         => array(
					'image'           => $ss['background_image'],
					'block_title'     => $ss['block_title'],
					'block_sub_title' => $ss['block_sub_title'],
					'block_button'    => $ss['block_button'],
				),
			);

			obj_do_service_section( $service_section );
		}
	}

}

function obj_wwd_block_ctas() {
	$cta_b = get_field( 'wwd_cta_blocks_section' );

	if ( ! empty( $cta_b ) ) {
		$cta_blocks_section = array(
			'section_id'       => $cta_b['section_id'],
			'section_paddings' => 'top',
			'section_margins'  => 'none',
			'cta_blocks'       => $cta_b['cta_blocks'],
		);

		obj_cta_blocks_grid( $cta_blocks_section, 'bg-light-gray' );
	}
}

function obj_wwd_footer_cta() {
	$foot_cta_id      = get_field( 'footer_cta_id' );
	$foot_cta_details = get_field( 'wwd_footer_cta_details' );

	if ( ! empty( $foot_cta_details ) ) {
		$foot_cta_section = array(
			'section_id'       => $foot_cta_id['section_id'],
			'section_paddings' => 'top',
			'section_wrap'     => false,
			'section_margins'  => 'none',
			'footer_cta'       => $foot_cta_details,
		);

		obj_foot_cta( $foot_cta_section, 'bg-light-gray' );
	}
}

// Build the page
get_header();
do_action( 'objectiv_page_content' );
get_footer();
