<?php

function obj_cta_blocks_grid( $cta_grid_block_section = null, $section_classes = null, $bg_shapes = null ) {

	$sec_meta = decide_section_meta( 'cta-grid-block-section', $section_classes, $cta_grid_block_section, $bg_shapes );

	if ( ! empty( $cta_grid_block_section ) ) {
		do_section_top( $sec_meta );
		obj_do_cta_grid_inner( $cta_grid_block_section );
		do_section_bottom( $sec_meta );
	}
}

function obj_do_cta_grid_inner( $cta_grid_block_section = null ) {
	$cta_blocks = $cta_grid_block_section['cta_blocks'];

	obj_do_cta_block_grid( $cta_blocks );
}

function obj_do_cta_block_grid( $cta_blocks = null ) {
	if ( ! empty( $cta_blocks ) ) {
		echo "<div class='cta-block-grid'>";
		foreach ( $cta_blocks as $block ) {
			obj_do_cta_block( $block );
		}
		echo '</div>';
	}
}
