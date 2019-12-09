<?php

function obj_about_kerry( $about_section = null, $section_classes = null, $bg_shapes = null ) {

	$sec_meta = decide_section_meta( 'about-kerry', $section_classes, $about_section, $bg_shapes );

	if ( ! empty( $about_section ) ) {
		do_section_top( $sec_meta );
		obj_do_about_kerry( $about_section );
		do_section_bottom( $sec_meta );
	}
}

function obj_do_about_kerry( $about_section = null ) {

	$content     = $about_section['about_content'];
	$testimonial = $about_section['testimonial'];
	$logos       = $about_section['logos'];
	$button      = $about_section['button'];

	// ovdump( $content );

	if ( ! empty( $content ) ) {
		echo "<div class='about-content'>";
		if ( ! empty( $content['title'] ) ) {
			echo "<h2 class='about-content__title'>";
			echo $content['title'];
			echo '</h2>';
		}
		if ( $content['content'] ) {
			echo "<div class='about-content__content lmb0'>";
			echo $content['content'];
			echo '</div>';
		}
		echo '</div>';
	}

	if ( ! empty( $testimonial ) ) {
		obj_do_testimonial( $testimonial['testimonial'] );
	}

	if ( ! empty( $logos ) ) {
		obj_do_logos_row( $logos['logos'] );
	}

	if ( ! empty( $button ) ) {
		echo "<div class='button-wrap'>";
		echo objectiv_link_button( $button );
		echo '</div>';
	}

}
