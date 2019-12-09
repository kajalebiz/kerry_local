<?php

function obj_do_event_cats_side_by_cta_section( $event_cat_ss_deets = null, $section_classes = null, $bg_shapes = null ) {

	$sec_meta = decide_section_meta( 'event-cats', $section_classes, $event_cat_ss_deets, $bg_shapes );

	if ( ! empty( $event_cat_ss_deets ) ) {
		do_section_top( $sec_meta );
		obj_do_event_cats_side_by_cta_inner( $event_cat_ss_deets );
		do_section_bottom( $sec_meta );
	}
}

function obj_do_event_cats_side_by_cta_inner( $event_cat_ss_deets = null ) {

	if ( array_key_exists( 'section_title', $event_cat_ss_deets ) && ! empty( $event_cat_ss_deets['section_title'] ) ) {
		echo "<h2 class='section-title page-color'>";
		echo $event_cat_ss_deets['section_title'];
		echo '</h2>';
	}

	if ( array_key_exists( 'event_cats', $event_cat_ss_deets ) ) {
		obj_do_side_by_side_event_cat_cta_grid( $event_cat_ss_deets['event_cats'] );
	}
}
