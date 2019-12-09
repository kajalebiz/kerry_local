<?php

function obj_do_featured_clients_section( $fc_section = null, $section_classes = null, $bg_shapes = null ) {

	$sec_meta = decide_section_meta( 'featured-clients', $section_classes, $fc_section, $bg_shapes );

	if ( ! empty( $fc_section ) ) {
		do_section_top( $sec_meta );
		obj_do_featured_clients( $fc_section );
		do_section_bottom( $sec_meta );
	}
}

function obj_do_featured_clients( $fc_section = null ) {
	$sec_title          = $fc_section['section_title'];
	$clients_grid       = $fc_section['featured_clients_grid'];
	$bottom_image       = $fc_section['bottom_image'];
	$bottom_image_class = null;

	if ( empty( $bottom_image ) ) {
		$bottom_image_class = 'no-bottom-image';
	}

	echo "<div class=' tesst wrap {$bottom_image_class}'>";
	if ( ! empty( $sec_title ) ) {
		echo "<h2 class='section-title'>";
		echo $sec_title;
		echo '</h2>';
	}

	if ( ! empty( $clients_grid ) ) {
		obj_do_clients_grid( $clients_grid );
	}

	// End the wrap div
	echo '</div>';

	if ( array_key_exists( 'cta-button', $fc_section ) && ! empty( $fc_section['cta-button'] ) ) {
		echo "<div class='featured-clients__button-wrap'>";
		echo "<div class='wrap tac'>";
			echo objectiv_link_button( $fc_section['cta-button'], 'yellow-button' );
		echo '</div>';
		echo '</div>';
	}

	if ( ! empty( $bottom_image ) ) {
		obj_do_top_angled_image( $bottom_image );
	}

}
