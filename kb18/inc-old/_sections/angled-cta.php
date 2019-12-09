<?php

function obj_angled_cta_section( $cta_section = null, $section_classes = null, $bg_shapes = null ) {

	$sec_meta = decide_section_meta( 'angled-cta-section', $section_classes, $cta_section, $bg_shapes );

	if ( ! empty( $cta_section ) ) {
		do_section_top( $sec_meta );
		obj_do_angled_cta( $cta_section );
		do_section_bottom( $sec_meta );
	}
}

function obj_do_angled_cta( $cta_section = null ) {
	$cta_deets = $cta_section['cta_deets'];

	if ( ! empty( $cta_deets ) ) {
		obj_do_angled_slide( $cta_deets );
	}
}
