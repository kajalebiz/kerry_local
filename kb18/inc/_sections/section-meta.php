<?php

/**
 * Function returns section meta
 */
function decide_section_meta( $sec_class = null, $add_classes = null, $section_details = null, $bg_shapes = null ) {

	$the_section_id          = decide_section_id( $section_details );
	$the_section_paddings    = decide_section_padding( $section_details );
	$the_section_margins     = decide_section_margin( $section_details );
	$the_section_wrap        = decide_section_wrap( $section_details );
	$the_section_color_class = decide_section_color( $section_details );

	$section_meta = array(
		'section_id'          => $the_section_id,
		'section_margins'     => $the_section_margins,
		'section_paddings'    => $the_section_paddings,
		'section_class'       => $sec_class,
		'section_add_classes' => $add_classes,
		'section_color_class' => $the_section_color_class,
		'section_wrap'        => $the_section_wrap,
		'bg_shapes'           => $bg_shapes,
	);

	return $section_meta;
}

function decide_section_id( $section_details = null ) {
	$sec_id = null;
	if ( is_array( $section_details ) && key_exists( 'section_id', $section_details ) ) {
		$sec_id = $section_details['section_id'];
	}

	return $sec_id;
}

function decide_section_padding( $section_details = null ) {
	$sec_padding = 'normal';
	if ( is_array( $section_details ) && key_exists( 'section_paddings', $section_details ) ) {
		$sec_padding = $section_details['section_paddings'];
	}

	return $sec_padding;
}

function decide_section_margin( $section_details = null ) {
	$sec_margin = 'normal';
	if ( is_array( $section_details ) && key_exists( 'section_margins', $section_details ) ) {
		$sec_margin = $section_details['section_margins'];
	}

	return $sec_margin;
}

function decide_section_wrap( $section_details = null ) {
	$sec_wrap = true;
	if ( is_array( $section_details ) && key_exists( 'section_wrap', $section_details ) ) {
		$sec_wrap = $section_details['section_wrap'];
	}

	return $sec_wrap;
}

function decide_section_color( $section_details = null ) {
	$sec_color_class = null;
	if ( is_array( $section_details ) && key_exists( 'section_color', $section_details ) ) {
		$sec_color_class = 'section-' . $section_details['section_color'];
	}

	return $sec_color_class;
}
