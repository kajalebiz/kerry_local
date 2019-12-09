<?php

function obj_do_hyo_foot_cta( $cta_deets = null, $section_classes = null, $bg_shapes = null ) {

	$sec_meta = decide_section_meta( 'hyo-foot-cta', $section_classes, $cta_deets, $bg_shapes );

	if ( ! empty( $cta_deets ) ) {
		do_section_top( $sec_meta );
		obj_do_hyo_foot_inside( $cta_deets );
		do_section_bottom( $sec_meta );
	}
}

function obj_do_hyo_foot_inside( $cta_deets = null ) {
	if ( array_key_exists( 'angled_image', $cta_deets ) && array_key_exists( 'block_deets', $cta_deets ) ) {
		obj_do_angled_foot_block_cta( $cta_deets['angled_image'], $cta_deets['block_deets'] );
	}
}
