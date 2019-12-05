<?php

/*
Template Name: Subscribe Page
*/

// full width layout
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

// Remove 'site-inner' from structural wrap
add_theme_support( 'genesis-structural-wraps', array( 'header', 'nav', 'subnav', 'footer-widgets', 'footer' ) );

add_action( 'objectiv_page_content', 'sub_page_sections' );
function sub_page_sections() {
	obj_sub_content();
}

function obj_sub_content() {
	$sub_deets = get_field( 'subscribe_details' );
	if ( ! empty( $sub_deets ) ) {
		$sub_deets['section_paddings'] = 'both';
		$sub_deets['section_margins']  = 'none';

		$bg_shapes = array(
			'amp' => 1,
		);

		obj_mailchimp_section( $sub_deets, 'bg-light-gray', $bg_shapes );
	}
}

// Build the page
get_header();
do_action( 'objectiv_page_content' );
get_footer();
