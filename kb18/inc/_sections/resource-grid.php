<?php

function obj_resource_template_grid_section( $resource_sec = null, $section_classes = null, $bg_shapes = null ) {

	$sec_meta = decide_section_meta( 'resource-grid-section', $section_classes, $resource_sec, $bg_shapes );

	if ( ! empty( $resource_sec ) ) {
		do_section_top( $sec_meta );
		obj_resource_template_grid_inner( $resource_sec );
		do_section_bottom( $sec_meta );
	}
}

function obj_resource_template_grid_inner( $resource_sec = null ) {
	$resources = $resource_sec['resources'];
	$top       = $resource_sec['top'];
	obj_resource_grid( $resources, $top );
}
