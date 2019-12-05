<?php

function obj_do_upcoming_events_section( $upcoming_events_section = null, $section_classes = null, $bg_shapes = null ) {

	$sec_meta = decide_section_meta( 'upcoming-events-section', $section_classes, $upcoming_events_section, $bg_shapes );

	if ( ! empty( $upcoming_events_section ) ) {
		do_section_top( $sec_meta );
		obj_do_upcoming_events_section_inner( $upcoming_events_section );
		do_section_bottom( $sec_meta );
	}
}

function obj_do_upcoming_events_section_inner( $upcoming_events_section = null ) {
	if ( array_key_exists( 'event_id', $upcoming_events_section ) ) {
		obj_do_upcoming_events_grid( $upcoming_events_section['event_id'] );
	}
}
