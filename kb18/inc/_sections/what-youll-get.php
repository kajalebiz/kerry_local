<?php

function obj_do_what_youll_get_section( $wyg_section = null, $section_classes = null, $bg_shapes = null ) {

	$sec_meta = decide_section_meta( 'what-youll-get-section', $section_classes, $wyg_section, $bg_shapes );

	if ( ! empty( $wyg_section ) ) {
		do_section_top( $sec_meta );
		obj_do_what_youll_get( $wyg_section );
		do_section_bottom( $sec_meta );
	}
}

function obj_do_what_youll_get( $wyg_section = null ) {
	$grid_pad_class = null;

	if ( array_key_exists( 'lower_title', $wyg_section ) && array_key_exists( 'lower_blurb', $wyg_section ) && array_key_exists( 'grid_blocks', $wyg_section ) ) {
		if ( empty( $wyg_section['lower_title'] ) && empty( $wyg_section['lower_blurb'] ) && empty( $wyg_section['grid_blocks'] ) ) {
			$grid_pad_class = 'no-bottom-padding';
		}
	}

	if ( array_key_exists( 'section_title', $wyg_section ) && array_key_exists( 'section_intro', $wyg_section ) ) {
		obj_section_header( $wyg_section['section_title'], $wyg_section['section_intro'] );
	}

	if ( array_key_exists( 'side_by_side', $wyg_section ) ) {
		obj_side_by_side_blocks( $wyg_section['side_by_side'], $grid_pad_class );
	}

	if ( array_key_exists( 'lower_title', $wyg_section ) && array_key_exists( 'lower_blurb', $wyg_section ) ) {
		obj_smaller_section_header( $wyg_section['lower_title'], $wyg_section['lower_blurb'] );
	}

	if ( array_key_exists( 'lower_content', $wyg_section ) && ! empty( $wyg_section['lower_content'] ) ) {
		echo "<div class='lmb0'>";
		echo $wyg_section['lower_content'];
		echo '</div>';
	}

	if ( array_key_exists( 'grid_blocks', $wyg_section ) ) {
		obj_do_grid_blocks( $wyg_section['grid_blocks'], 'solid white' );
	}

	if ( array_key_exists( 'image_grid_blocks', $wyg_section ) ) {
		obj_do_image_grid_blocks( $wyg_section['image_grid_blocks'] );
	}

	if ( array_key_exists( 'testimonials', $wyg_section ) ) {
		obj_do_testimonial_slider( $wyg_section['testimonials'], 'mb0' );
	}

}
