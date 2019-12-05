<?php

/*
Template Name: Journey Online Training
 */

// full width layout
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

// Remove 'site-inner' from structural wrap
add_theme_support( 'genesis-structural-wraps', array( 'header', 'nav', 'subnav', 'footer-widgets', 'footer' ) );

//* Add custom body class to the head
add_filter( 'body_class', 'obj_journey_online_body_class' );
function obj_journey_online_body_class( $classes ) {

	$classes[] = 'journey-online-training colored-title';
	return $classes;

}

add_action( 'objectiv_page_content', 'obj_jot_page_sections' );
function obj_jot_page_sections() {
	obj_jot_jump_nav();
        obj_jot_why_kerry();
	obj_jot_angled_tabs();
	obj_jot_what_online();
	obj_jot_footer_form();
}

function obj_jot_jump_nav() {
	$jump_nav = get_field( 'jot_jump_nav_details' );

	if ( ! empty( $jump_nav ) ) {
		$jump_nav_section = array(
			'section_paddings' => 'none',
			'section_margins'  => 'none',
			'jump_nav_items'   => $jump_nav['jump_nav_items'],
		);

		obj_jump_nav_section( $jump_nav_section );
	}
}

function obj_jot_why_kerry() {
	$sec_id         = get_field( 'jot_why_section_id' );
	$sec_title      = get_field( 'jot_why_section_title' );
	$sec_blurb      = get_field( 'jot_why_section_intro' );
	$grid_blocks    = get_field( 'jot_why_grid_blocks' );

	$why_exe = array(
		'section_id'       => $sec_id['section_id'],
		'section_paddings' => 'top',
		'section_margins'  => 'none',
		'sec_title'        => $sec_title,
		'sec_blurb'        => $sec_blurb,
		'grid_blocks'      => $grid_blocks['blocks'],
	);

	$bg_shapes = array(
		'oval' => 1,
		'rect' => 1,
	);

	if ( ! empty( $why_exe ) ) {
		obj_do_why_exe_dinner_section( $why_exe, 'bg-light-gray', $bg_shapes );
	}
}

function obj_jot_angled_tabs(){
	$tab_content  = get_field( 'jot_how_it_works_tabs' );
	$sec_title    = get_field( 'jot_how_section_title' );
        $show_vide   = get_field( 'jot_what_show_video' );

	if ( ! empty( $tab_content ) ) {
		$tab_section = array(
			'section_id'       => $tab_content['section_id'],
			'section_paddings' => 'none',
			'section_margins'  => 'none',
			'tabs'             => $tab_content['cta_blocks'],
			'section_wrap'     => false,
			'second_sec_wrap'  => true,
			'sec_title'        => $sec_title,
		);
                
        if($show_vide == FALSE){
            obj_tabbed_cta( $tab_section, 'remove-video bg-light-gray in-bg-page angled-top white-active white-blurb dark-title' );
        } else{
            obj_tabbed_cta( $tab_section, 'bg-light-gray in-bg-page angled-top white-active white-blurb dark-title' );
        }
		
	}
}

function obj_jot_what_online() {
	$sec_id      = get_field( 'jot_what_section_id' );
	$vid_url     = get_field( 'jot_what_video_url' );
	$vid_thumb   = get_field( 'jot_what_video_thumbnail' );
	$show_vide   = get_field( 'jot_what_show_video' );

	$what_online = array(
		'section_id'       => $sec_id['section_id'],
		'section_paddings' => 'none',
		'section_margins'  => 'none',
		'section_wrap'     => false,
		'video_url'        => $vid_url,
		'video_thumb'      => $vid_thumb,
//		'sec_title'        => $sec_title,
	);

	if ( ! empty( $what_online ) && $show_vide == true ) {
		obj_do_what_online_section( $what_online, '' );
	}
}

function obj_jot_footer_form() {
	$foot_form_sec  = get_field( 'jot_footer_form_details' );
	$sec_id         = get_field( 'jot_footer_section_id' );
        $show_vide      = get_field( 'jot_what_show_video' );

	if ( ! empty( $foot_form_sec ) ) {
		$footer_form_section = array(
			'section_id'       => $sec_id['section_id'],
			'section_paddings' => 'none',
			'section_margins'  => 'none',
			'section_wrap'     => false,
			'section_title'    => $foot_form_sec['section_title'],
			'form'             => $foot_form_sec['form_to_display'],
		);
        
        if($show_vide == FALSE){
            obj_do_footer_form_cta_section( $footer_form_section, 'remove_video' );
        } else{
            obj_do_footer_form_cta_section( $footer_form_section, '' );
        }
		

	}
}



	// Build the page
get_header();
do_action( 'objectiv_page_content' );
get_footer();
