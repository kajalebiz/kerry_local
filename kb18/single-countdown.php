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

add_action( 'objectiv_page_content', 'obj_count_event_page_sections' );
function obj_count_event_page_sections() {
	$passed = obj_event_has_passed( get_the_ID() );

//	if ( $passed ) {
//		// obj_event_cant_make_it();
//		// obj_event_hyo();
//	} else {
		$is_universe_link = get_field( 'register_section_is_this_a_universe_event_link' );
		$universe_link    = get_field( 'register_section_universe_event_link' );

		if ( $is_universe_link && ! empty( $universe_link ) ) {
			echo '<script src="https://www.universe.com/embed2.js" data-state=""></script>';
		}
		obj_count_jump_navs();
		obj_count_prepared();
		obj_count_angled_image();
		obj_count_event_preview();
		obj_count_event_details();
//		obj_event_register();
                obj_event_resources();		
		//obj_event_cant_make_it();
		// obj_event_hyo();
		obj_event_contactus();
//	}

}

function obj_count_jump_navs() {
//    die;
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

function obj_count_prepared(){
    $sec_id         = get_field( 'countdown_prepare_sec_id' );
    $sec_title      = get_field( 'countdown_prepare_sec_title' );
    $prepared_list  = get_field( 'countdown_prepared_list' );
    if ( ! empty( $prepared_list ) ) {
		$prepared_section = array(
			'section_id'        => $sec_id['section_id'],
                        'sec_title'         => $sec_title,
			'prepared_content'  => $prepared_list,
		);

		$bg_shapes = array(
			'rect' => 1,
			'oval' => 1
		);
		obj_count_prepared_section( $prepared_section, '', $bg_shapes );
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

function obj_count_angled_image() {
	$angled_image = get_field( 'countdown_angled_image' );

	if ( ! empty( $angled_image ) ) {
		obj_do_top_angled_image( $angled_image, 'bg-light-gray' );
	}
}

function obj_count_event_preview() {
	$sec_id    = get_field( 'countdown_prev_section_id' );
	$sec_title = get_field( 'countdown_prev_section_title' );
	$slider    = get_field( 'countdown_prev_slider' );

	$prev_section = array(
		'section_id'       => $sec_id['section_id'],
		'section_paddings' => 'top',
		'section_wrap'     => true,
		'section_margins'  => 'none',
		'sec_title'        => $sec_title,
		'slider'           => $slider,
	);
	if ( ! empty( $sec_title ) ) {
		obj_count_event_preview_section( $prev_section, 'bg-light-gray' );
	}

}

function obj_count_event_details() {
	$sec_id      = get_field( 'countdown_details_section_id' );
	$sec_title   = get_field( 'countdown_details_sec_title' );
	$when_deets  = get_field( 'countdown_when_details_group' );
	$where_deets = get_field( 'countdown_where_details' );
	$price_deets = get_field( 'countdown_price_details_group' );

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
        
        $bg_shapes = array(
                'rect' => 1,
                'oval' => 1
        );

	if ( ! empty( $sec_title ) ) {
		obj_event_details_section( $details_section, 'bg-light-gray event_detail', $bg_shapes );
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

function obj_event_resources() {
	$sec_id         = get_field( 'resources_sec_id' );
	$sec_title      = get_field( 'resources_sec_title' );
	$blog_list      = get_field( 'blog_post_list' );

	if ( !empty( $blog_list )) {
		$foot_resource = array(
			'section_id'        => $sec_id['section_id'],
                        'sec_title'         => $sec_title,
			'section_paddings'  => 'none',
			'section_wrap'      => false,
			'section_margins'   => 'none',
			'blog_list'         => $blog_list,
		);
		obj_foot_resource( $foot_resource, 'foot-cta bg-light-gray foot-cta-title-fw600' );
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

function obj_event_contactus(){
    	$sec_id             = get_field( 'contact_sec_id' );
	$sec_title          = get_field( 'contact_sec_title' );
	$contact_details    = get_field( 'contact_details' );
        
        if ( ! empty( $contact_details ) ) {
		$cont_section = array(
			'section_id'        => $sec_id['section_id'],
                        'sec_title'         => $sec_title,
			'contact_content'   => $contact_details,
                        'section_paddings'  => 'none',
			'section_wrap'      => false,
			'section_margins'   => 'none',
		);
                
		obj_contact_section( $cont_section, 'foot-cta bg-light-gray foot-cta-title-fw600');
	}
}

// Build the page
get_header();
do_action( 'objectiv_page_content' );
get_footer();
