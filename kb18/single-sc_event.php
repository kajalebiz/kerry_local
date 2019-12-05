<?php

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

add_action( 'objectiv_page_content', 'obj_event_page_sections' );
function obj_event_page_sections() {

	$passed = obj_event_has_passed( get_the_ID() );

	if ( $passed ) {
		obj_event_cant_make_it();
		obj_event_hyo();
	} else {
		$is_universe_link = get_field( 'register_section_is_this_a_universe_event_link' );
		$universe_link    = get_field( 'register_section_universe_event_link' );

		if ( $is_universe_link && ! empty( $universe_link ) ) {
			echo '<script src="https://www.universe.com/embed2.js" data-state=""></script>';
		}

		obj_event_jump_nav();
		obj_event_angled_tabs();
		obj_event_testimonials();
		obj_event_leaders();
		obj_event_angled_image();
		obj_event_preview();
		obj_event_details();
		obj_event_register();
		obj_event_cant_make_it();
		obj_event_hyo();
	}

}

function obj_event_jump_nav() {
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

function obj_event_angled_tabs() {
	$tab_content = get_field( 'why_event_tabs' );
	$sec_title   = get_field( 'why_event_section_title' );
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

		obj_tabbed_cta( $tab_section, 'bg-light-gray in-bg-page angled-bottom white-active white-blurb dark-title' );
	}
}

function obj_event_testimonials() {
	$testimonials = get_field( 'event_testimonials' );

	if ( ! empty( $testimonials ) ) {
		$testimonials_section = array(
			'section_id'       => null,
			'section_paddings' => 'none',
			'section_margins'  => 'none',
			'section_wrap'     => true,
			'testimonials'     => $testimonials,
		);

		obj_testimonials_section( $testimonials_section, 'bg-light-gray' );
	}
}

function obj_event_leaders() {
	$staff_title = get_field( 'event_staff_title' );
	$staff       = get_field( 'staff_for_this_event' );
	$sec_id      = get_field( 'event_staff_sec_id' );

	if ( ! empty( $staff ) ) {
		$event_staff_section = array(
			'section_id'       => $sec_id['section_id'],
			'section_paddings' => 'top',
			'section_margins'  => 'none',
			'section_wrap'     => true,
			'staff'            => $staff,
			'sec_title'        => $staff_title,
		);

		obj_event_staff_section( $event_staff_section, 'bg-light-gray' );
	}
}

function obj_event_angled_image() {
	$angled_image = get_field( 'event_angled_image' );

	if ( ! empty( $angled_image ) ) {
		obj_do_top_angled_image( $angled_image, 'bg-light-gray' );
	}
}

function obj_event_preview() {
	$sec_id    = get_field( 'event_prev_section_id' );
	$sec_title = get_field( 'event_prev_section_title' );
	$slider    = get_field( 'event_prev_slider' );

	$prev_section = array(
		'section_id'       => $sec_id['section_id'],
		'section_paddings' => 'top',
		'section_wrap'     => true,
		'section_margins'  => 'none',
		'sec_title'        => $sec_title,
		'slider'           => $slider,
	);
	if ( ! empty( $sec_title ) ) {
		obj_event_preview_section( $prev_section, 'bg-light-gray' );
	}

}

function obj_event_details() {
	$sec_id      = get_field( 'event_details_section_id' );
	$sec_title   = get_field( 'event_details_sec_title' );
	$when_deets  = get_field( 'event_when_details_group' );
	$where_deets = get_field( 'event_where_details' );
	$price_deets = get_field( 'event_price_details_group' );

	$details_section = array(
		'section_id'       => $sec_id['section_id'],
		'section_paddings' => 'top',
		'section_wrap'     => true,
		'section_margins'  => 'none',
		'sec_title'        => $sec_title,
		'when_deets'       => $when_deets,
		'where_deets'      => $where_deets,
		'price_deets'      => $price_deets,
	);

	if ( ! empty( $sec_title ) ) {
		obj_event_details_section( $details_section, 'bg-light-gray' );
	}
}

function obj_event_register() {
	$cta_id           = get_field( 'register_section_id' );
	$cta_details      = get_field( 'register_details' );
	$display          = is_array( $cta_details ) && array_key_exists( 'title', $cta_details ) && ! empty( $cta_details['title'] );
	$is_universe_link = get_field( 'register_section_is_this_a_universe_event_link' );
	$universe_link    = get_field( 'register_section_universe_event_link' );

	if ( ! empty( $cta_details ) && $display ) {
		$cta_section = array(
			'section_id'             => $cta_id['section_id'],
			'section_paddings'       => 'none',
			'section_wrap'           => false,
			'section_margins'        => 'none',
			'footer_cta'             => $cta_details,
			'is_universe_event_link' => $is_universe_link,
			'universe_event_link'    => $universe_link,
		);

		obj_foot_cta( $cta_section, 'bg-light-gray foot-cta-title-fw600' );
	}
}
function obj_event_cant_make_it() {
	$event_id = get_the_ID();

	if ( ! empty( $event_id ) ) {
		$upcoming_event_section = array(
			'section_id'       => 'upcoming-events',
			'section_paddings' => 'both',
			'section_wrap'     => true,
			'section_margins'  => 'none',
			'event_id'         => $event_id,
		);
		obj_do_upcoming_events_section( $upcoming_event_section, 'bg-light-gray' );
	}
}


function obj_event_hyo() {
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
