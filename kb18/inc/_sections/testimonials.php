<?php

function obj_testimonials_section( $testimonials_section = null, $section_classes = null, $bg_shapes = null ) {

	$sec_meta = decide_section_meta( 'testimonials-section', $section_classes, $testimonials_section, $bg_shapes );

	if ( ! empty( $testimonials_section ) ) {
		do_section_top( $sec_meta );
		obj_testimonials_section_inner( $testimonials_section );
		do_section_bottom( $sec_meta );
	}
}

function obj_testimonials_section_inner( $testimonials_section = null ) {
	if ( array_key_exists( 'testimonials', $testimonials_section ) && ! empty( $testimonials_section['testimonials'] ) ) {
		if ( is_array( $testimonials_section['testimonials'] ) ) {
			obj_do_testimonial_slider( $testimonials_section['testimonials'] );
		}
	}
}
