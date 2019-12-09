<?php

function obj_event_details_section( $details_section = null, $section_classes = null, $bg_shapes = null ) {

	$sec_meta = decide_section_meta( 'content-section', $section_classes, $details_section, $bg_shapes );

	if ( ! empty( $details_section ) ) {
		do_section_top( $sec_meta );
		obj_event_details_section_inner( $details_section );
		do_section_bottom( $sec_meta );
	}
}

function obj_event_details_section_inner( $details_section = null ) {

	if ( array_key_exists( 'sec_title', $details_section ) && ! empty( $details_section['sec_title'] ) ) {
		echo "<h2 class='section-title page-color'>";
		echo $details_section['sec_title'];
		echo '</h2>';
	}

	if ( array_key_exists( 'when_deets', $details_section ) && is_array( $details_section['when_deets'] ) ) {
		$when_deets = $details_section['when_deets'];
		obj_do_event_detail_section_when( $when_deets );
	}

	if ( array_key_exists( 'where_deets', $details_section ) && is_array( $details_section['where_deets'] ) ) {
		$where_deets = $details_section['where_deets'];
		obj_do_event_detail_section_where( $where_deets );
	}

	if ( array_key_exists( 'price_deets', $details_section ) && is_array( $details_section['price_deets'] ) ) {
		$price_deets = $details_section['price_deets'];
            if ( ! empty( is_singular( 'sc_event' ) ) ) {
		obj_do_event_detail_section_price( $price_deets );
            }
        }
}
