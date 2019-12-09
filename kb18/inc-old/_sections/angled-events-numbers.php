<?php

function obj_angled_events_numbers_section( $aen_section = null, $section_classes = null, $bg_shapes = null ) {

	$sec_meta = decide_section_meta( 'angled-event-numbers', $section_classes, $aen_section, $bg_shapes );

	if ( ! empty( $aen_section ) ) {
		do_section_top( $sec_meta );
		obj_do_angled_events_numbers_inner( $aen_section );
		do_section_bottom( $sec_meta );
	}
}

function obj_do_angled_events_numbers_inner( $aen_section = null ) {
	$cx_events_count = obj_get_events_number();
	$kb_events_count = obj_get_kb_events_number();
	$form            = get_field( 'angled_events_numb_custom_form' );
	$blurb           = get_field( 'angled_events_numbers_blurb' );
	$grav_form       = get_field( 'angled_events_gravity_form' );

	if ( empty( $form ) ) {
		$form = get_field( 'default_mailchimp_form', 'option' );
	}

	echo "<div class='wrap'>";
	echo "<div class='event-numbers__wrap'>";
	if ( ! empty( $cx_events_count ) && $cx_events_count > 0 ) {
		echo "<div class='event-numbers__cx-events'>";
		echo "<div class='event-numbers__cx-events-number'>";
		echo $cx_events_count;
		echo '</div>';
		echo "<div class='event-numbers__cx-events-title'>";
		if ( $cx_events_count > 1 ) {
			echo 'CX Events';
		} else {
			echo 'CX Event';
		}
		echo '</div>';
		echo '</div>';
	}
	// if ( ! empty( $kb_events_count ) && $kb_events_count > 0 ) {
	// 	echo "<div class='event-numbers__kb-events'>";
	// 	echo "<div class='event-numbers__kb-events-number'>";
	// 	echo $kb_events_count;
	// 	echo '</div>';
	// 	echo "<div class='event-numbers__kb-events-title'>";
	// 	if ( $kb_events_count > 1 ) {
	// 		echo 'Kerry Bodine & Co Bootcamps';
	// 	} else {
	// 		echo 'Kerry Bodine & Co Bootcamp';
	// 	}
	// 	echo '</div>';

	// 	echo '</div>';
	// }
	if ( ! empty( $blurb ) ) {
		echo "<div class='event-numbers__blurb'>";
		echo $blurb;
		echo '</div>';
	}
	if ( ! empty( $form || ! empty( $grav_form ) ) ) {
		echo "<div class='event-numbers__cta-form'>";
		if ( ! empty( $grav_form ) ) {
			gravity_form( $grav_form['id'], false, false, false, '', true );
		} elseif ( ! empty( $form ) ) {
			echo $form;
		}
		echo '</div>';
	}
	echo '</div>';
	echo '</div>';
}
