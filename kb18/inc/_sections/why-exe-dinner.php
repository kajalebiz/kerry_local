<?php

function obj_do_why_exe_dinner_section( $why_exe_dinner_sec = null, $section_classes = null, $bg_shapes = null ) {

	$sec_meta = decide_section_meta( 'why-exe_dinner', $section_classes, $why_exe_dinner_sec, $bg_shapes );

	if ( ! empty( $why_exe_dinner_sec ) ) {
		do_section_top( $sec_meta );
		obj_do_why_exe_dinner( $why_exe_dinner_sec );
		do_section_bottom( $sec_meta );
	}
}

function obj_do_why_exe_dinner( $why_exe_dinner_sec = null ) {

	$page_color = get_field( 'page_color_colors' );
	$btn_class  = decide_page_button_class();
	$sec_button = $why_exe_dinner_sec['sec_button'];

	if ( array_key_exists( 'sec_title', $why_exe_dinner_sec ) && array_key_exists( 'sec_blurb', $why_exe_dinner_sec ) ) {
		obj_section_header( $why_exe_dinner_sec['sec_title'], $why_exe_dinner_sec['sec_blurb'] );
	}

	if ( array_key_exists( 'grid_blocks', $why_exe_dinner_sec ) ) {
		obj_do_grid_blocks( $why_exe_dinner_sec['grid_blocks'] );
	}

}
