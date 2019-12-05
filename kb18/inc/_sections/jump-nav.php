<?php

function obj_jump_nav_section( $jump_nav_section = null, $section_classes = null, $bg_shapes = null ) {

	$sec_meta = decide_section_meta( 'jump-nav', $section_classes, $jump_nav_section, $bg_shapes );

	if ( ! empty( $jump_nav_section ) ) {
		do_section_top( $sec_meta );
		obj_jump_nav( $jump_nav_section );
		do_section_bottom( $sec_meta );
	}
}

function obj_jump_nav( $jump_nav_section = null ) {
	if ( is_array( $jump_nav_section ) && array_key_exists( 'jump_nav_items', $jump_nav_section ) ) {
		$jump_nav_items = $jump_nav_section['jump_nav_items'];
		obj_do_jump_nav( $jump_nav_items );
	}
}
