<?php

function obj_foot_cta( $foot_cta_section = null, $section_classes = null, $bg_shapes = null ) {

	$sec_meta = decide_section_meta( 'foot-cta', $section_classes, $foot_cta_section, $bg_shapes );

	if ( ! empty( $foot_cta_section ) ) {
		do_section_top( $sec_meta );
		obj_foot_cta_inner( $foot_cta_section );
		do_section_bottom( $sec_meta );
	}
}

function obj_foot_cta_inner( $foot_cta_section = null ) {
	$foot_cta_deets          = $foot_cta_section['footer_cta'];
	$display_universe_button = false;

	if ( array_key_exists( 'is_universe_event_link', $foot_cta_section ) && array_key_exists( 'universe_event_link', $foot_cta_section ) && $foot_cta_section['is_universe_event_link'] && ! empty( $foot_cta_section['universe_event_link'] ) ) {
		$display_universe_button = true;
		$display_universe_link   = $foot_cta_section['universe_event_link'];
	}

	if ( ! empty( $foot_cta_deets ) ) {
		obj_do_foot_cta( $foot_cta_deets, $display_universe_button, $display_universe_link );
	}
}
