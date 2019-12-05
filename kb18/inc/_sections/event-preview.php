<?php

function obj_event_preview_section( $prev_section = null, $section_classes = null, $bg_shapes = null ) {

	$sec_meta = decide_section_meta( 'workshop-preview-section', $section_classes, $prev_section, $bg_shapes );

	if ( ! empty( $prev_section ) ) {
		do_section_top( $sec_meta );
		obj_do_event_preview_section_inner( $prev_section );
		do_section_bottom( $sec_meta );
	}
}

function obj_do_event_preview_section_inner( $prev_section = null ) {
	if ( array_key_exists( 'sec_title', $prev_section ) && ! empty( $prev_section['sec_title'] ) ) {
		echo "<h2 class='section-title page-color'>";
		echo $prev_section['sec_title'];
		echo '</h2>';
	}

	if ( array_key_exists( 'slider', $prev_section ) && ! empty( $prev_section['slider'] ) ) {
		obj_do_event_preview_slider( $prev_section['slider'] );
	}
}
