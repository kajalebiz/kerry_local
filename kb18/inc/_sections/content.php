<?php

function obj_content_section( $content_section = null, $section_classes = null, $bg_shapes = null ) {

	$sec_meta = decide_section_meta( 'content-section', $section_classes, $content_section, $bg_shapes );

	if ( ! empty( $content_section ) ) {
		do_section_top( $sec_meta );
		obj_do_content( $content_section );
		do_section_bottom( $sec_meta );
	}
}

function obj_do_content( $content_section = null ) {
	$classes = $content_section['classes'];
	$content = $content_section['content'];

	if ( array_key_exists( 'pre_content', $content_section ) && ! empty( $content_section['pre_content'] ) ) {
		echo "<div class='pre-title-content lmb0'>";
		echo $content_section['pre_content'];
		echo '</div>';
	}

	if ( array_key_exists( 'sec_title', $content_section ) && ! empty( $content_section['sec_title'] ) ) {
		echo "<h2 class='section-title page-color'>";
		echo $content_section['sec_title'];
		echo '</h2>';
	}

	if ( ! empty( $content ) ) {
		echo "<div class='lmb0 " . $classes . "'>";
		echo $content;
		echo '</div>';
	}

	if ( array_key_exists( 'blocks', $content_section ) ) {
		obj_do_grid_blocks( $content_section['blocks'], 'mb0 small-m-top' );
	}

	if ( array_key_exists( 'text-blocks', $content_section ) ) {
		obj_do_text_blocks( $content_section['text-blocks'] );
	}

	if ( array_key_exists( 'two-wide', $content_section ) ) {
		obj_do_two_wide_text_blocks( $content_section['two-wide'] );
	}
}
