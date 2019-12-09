<?php

function obj_event_staff_section( $event_staff_sec = null, $section_classes = null, $bg_shapes = null ) {

	$sec_meta = decide_section_meta( 'event-staff-section', $section_classes, $event_staff_sec, $bg_shapes );

	if ( ! empty( $event_staff_sec ) ) {
		do_section_top( $sec_meta );
		obj_event_staff_section_inner( $event_staff_sec );
		do_section_bottom( $sec_meta );
	}
}

function obj_event_staff_section_inner( $event_staff_sec = null ) {

	if ( array_key_exists( 'sec_title', $event_staff_sec ) && ! empty( $event_staff_sec['sec_title'] ) ) {
		echo "<h2 class='section-title page-color'>";
		echo $event_staff_sec['sec_title'];
		echo '</h2>';
	}

	if ( array_key_exists( 'staff', $event_staff_sec ) && is_array( $event_staff_sec['staff'] ) ) {
		do_event_staff_grid( $event_staff_sec['staff'] );
	}

}
