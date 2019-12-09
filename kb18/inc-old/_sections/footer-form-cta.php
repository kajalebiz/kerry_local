<?php

function obj_do_footer_form_cta_section( $ff_section = null, $section_classes = null, $bg_shapes = null, $blurb = null ) {

	$sec_meta = decide_section_meta( 'footer-form-cta', $section_classes, $ff_section, $bg_shapes );

	if ( ! empty( $ff_section ) ) {
		do_section_top( $sec_meta );
		obj_do_footer_form_cta( $ff_section, $blurb );
		do_section_bottom( $sec_meta );
	}
}

function obj_do_footer_form_cta( $ff_section = null, $blurb = null ) {
	$section_title = $ff_section['section_title'];
	$form          = $ff_section['form'];

	echo "<div class='wrap'>";
	if ( ! empty( $section_title ) ) {
		echo "<h3 class='footer-form-cta__title section-title'>";
		echo $section_title;
		echo '</h3>';
	}

	if ( ! empty( $blurb ) ) {
		echo '<div class="footer-form-blurb">';
		echo $blurb;
		echo '</div>';
	}

	if ( ! empty( $form ) ) {
		gravity_form_enqueue_scripts( $form['id'], true );
		gravity_form( $form['id'], false, false, false, null, true );
	}
	echo '</div>';
}
