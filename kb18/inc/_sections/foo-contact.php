<?php
function obj_contact_section( $content_section = null, $section_classes = null, $bg_shapes = null ) {

	$sec_meta = decide_section_meta( 'contact', $section_classes, $content_section, $bg_shapes );

	if ( ! empty( $content_section ) ) {

		do_section_top( $sec_meta );
		obj_con_prepare( $content_section );
		do_section_bottom( $sec_meta );
	}
}

function obj_con_prepare( $content_section = null ) {
    echo "<div class='inner-foot-cta'>";
    echo "<div class='foot-cta__outer section-padding default-background event_single_contact_main'>";
    echo "<div class='wrap'>";
    echo "<div class='foot-cta__content'>";
    if ( array_key_exists( 'sec_title', $content_section ) && ! empty( $content_section['sec_title'] ) ) {
        echo "<h2 class='foot-cta__title'>";
        echo $content_section['sec_title'];
        echo '</h2>';
    }
    if ( array_key_exists( 'contact_content', $content_section ) && ! empty( $content_section['contact_content'] ) ) {
        echo "<div class='event_single_contact'>";
        echo $content_section['contact_content'];
        echo '</h2>';
    }
    echo "</div>";
    echo "</div>";
    echo "</div>";
    echo "</div>";
}