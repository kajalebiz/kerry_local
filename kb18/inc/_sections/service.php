<?php

function obj_do_service_section( $service_section = null, $section_classes = null, $bg_shapes = null ) {

	$sec_meta = decide_section_meta( 'service-section', $section_classes, $service_section, $bg_shapes );

	if ( ! empty( $service_section ) ) {
		do_section_top( $sec_meta );
		obj_do_service( $service_section );
		do_section_bottom( $sec_meta );
	}
}

function obj_do_service( $service_section = null ) {
	$tabs       = $service_section['tabs'];
	$slide_info = $service_section['top_info'];

	if ( ! empty( $tabs ) || ! empty( $slide_info ) ) {
		if ( ! empty( $slide_info ) ) {
			obj_do_angled_slide( $slide_info );
		}
		if ( ! empty( $tabs ) ) {
			$tab_section = array(
				'section_paddings' => 'top',
				'section_margins'  => 'none',
				'tabs'             => $tabs,
			);

			obj_tabbed_cta( $tab_section );
		}
	}
}
