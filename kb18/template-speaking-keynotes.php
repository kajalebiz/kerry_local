<?php

/*
Template Name: Speaking Keynotes
 */

// full width layout
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

// Remove 'site-inner' from structural wrap
add_theme_support( 'genesis-structural-wraps', array( 'header', 'nav', 'subnav', 'footer-widgets', 'footer' ) );

//* Add custom body class to the head
add_filter( 'body_class', 'obj_service_landing_body_class' );
function obj_service_landing_body_class( $classes ) {

	$classes[] = 'speaking-keynote colored-title';
	return $classes;

}

add_action( 'objectiv_page_content', 'obj_spk_page_sections' );
function obj_spk_page_sections() {
	obj_spk_jump_nav();
	obj_spk_intro_content();
	obj_spk_angled_cta();
	obj_spk_why_kerry();
	obj_spk_featured_clients();
	obj_spk_what_youll_get();
	obj_spk_footer_form();
}

function obj_spk_jump_nav() {
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

function obj_spk_intro_content() {
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


function obj_spk_angled_cta() {
	$sec_id        = get_field( 'sk_angled_id' );
	$bg_image      = get_field( 'sk_bg_image' );
	$block_deets   = get_field( 'sk_block_details' );
	$cta_type      = get_field( 'sk_cta_type' );
	$angled_slider = get_field( 'sk_angled_slider' );

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

			obj_angled_cta_section( $angled_cta, 'bg-light-gray' );
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

function obj_spk_why_kerry() {
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

function obj_spk_featured_clients() {
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

		obj_do_featured_clients_section( $featured_clients_section, '' );

	}
}

function obj_spk_what_youll_get() {
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

	obj_do_what_youll_get_section( $what_you_get_section, 'bg-light-gray', $bg_shapes );
}

function obj_spk_footer_form() {
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

		obj_do_footer_form_cta_section( $footer_form_section, '' );

	}
}



	// Build the page
get_header();
do_action( 'objectiv_page_content' );
get_footer();
