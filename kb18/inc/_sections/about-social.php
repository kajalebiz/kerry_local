<?php

function obj_about_social_section( $social_sec = null, $section_classes = null, $bg_shapes = null ) {

	$sec_meta = decide_section_meta( 'social-section', $section_classes, $social_sec, $bg_shapes );

	if ( ! empty( $social_sec ) ) {
		do_section_top( $sec_meta );
		obj_do_about_social_section( $social_sec );
		do_section_bottom( $sec_meta );
	}
}

function obj_do_about_social_section( $social_sec = null ) {

	if ( array_key_exists( 'testimonial', $social_sec ) && ! empty( $social_sec['testimonial'] ) ) {
		obj_do_testimonial( $social_sec['testimonial'], 'padded bot-pad' );
	}

	if ( array_key_exists( 'insta', $social_sec ) && $social_sec['insta'] ) {
		obj_display_latest_insta_pics_grid();
	}

}
