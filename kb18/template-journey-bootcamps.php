<?php

/*
Template Name: Journey Map Bootcamps
 */

// full width layout
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

// Remove 'site-inner' from structural wrap
add_theme_support( 'genesis-structural-wraps', array( 'header', 'nav', 'subnav', 'footer-widgets', 'footer' ) );

//* Add custom body class to the head
add_filter( 'body_class', 'obj_journey_development_body_class' );
function obj_journey_development_body_class( $classes ) {

	$classes[] = 'jmap-bootcamps colored-title';
	return $classes;

}

add_action( 'objectiv_page_content', 'obj_jmb_page_sections' );
function obj_jmb_page_sections() {
	obj_jmb_jump_nav();
	obj_jmb_intro_content();
	obj_jmb_featured_clients();
	obj_jmb_bootcamps();
	obj_jmb_hyo();
}

function obj_jmb_jump_nav() {
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

function obj_jmb_intro_content() {
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

function obj_jmb_featured_clients() {
	$fc_deets = get_field( 'featured_clients' );

	if ( ! empty( $fc_deets ) ) {
		$featured_clients_section = array(
			'section_id'            => $fc_deets['section_id'],
			'section_paddings'      => 'none',
			'section_margins'       => 'none',
			'section_wrap'          => false,
			'section_title'         => $fc_deets['section_title'],
			'featured_clients_grid' => $fc_deets['featured_clients_grid'],
			'bottom_image'          => $fc_deets['bottom_image'],
			'cta-button'            => $fc_deets['grid_bottom_cta'],
		);

		obj_do_featured_clients_section( $featured_clients_section, '' );

	}
}

function obj_jmb_bootcamps() {
	$sec_title  = get_field( 'be_section_title' );
	$sec_id     = get_field( 'be_section_id' );
	$event_cats = get_field( 'be_bootcamp_categories' );

	if ( is_array( $event_cats ) ) {
		$bootcamp_sec_deets = array(
			'section_id'       => $sec_id['section_id'],
			'section_paddings' => 'both',
			'section_margins'  => 'none',
			'section_wrap'     => true,
			'section_title'    => $sec_title,
			'event_cats'       => $event_cats,
		);

		$bg_shapes = array(
			'oval' => 3,
			'rect' => 3,
		);

		obj_do_event_cats_side_by_cta_section( $bootcamp_sec_deets, '', $bg_shapes );
	}

}

function obj_jmb_hyo() {
	$sec_id       = get_field( 'hyo_angled_cta_section_id' );
	$angled_image = get_field( 'hyo_angled_cta_image' );
	$block_deets  = get_field( 'hyo_angled_cta_block_details' );

	if ( ! empty( $block_deets ) && ! empty( $angled_image ) ) {
		$hyo_section_deets = array(
			'section_id'       => $sec_id['section_id'],
			'section_paddings' => 'none',
			'section_margins'  => 'none',
			'section_wrap'     => false,
			'angled_image'     => $angled_image,
			'block_deets'      => $block_deets,
		);

		obj_do_hyo_foot_cta( $hyo_section_deets, 'bg-light-gray' );

	}
}

// Build the page
get_header();
do_action( 'objectiv_page_content' );
get_footer();
