<?php

/*
Template Name: Contact Page
*/

// full width layout
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

// Remove 'site-inner' from structural wrap
add_theme_support( 'genesis-structural-wraps', array( 'header', 'nav', 'subnav', 'footer-widgets', 'footer' ) );

add_action( 'objectiv_page_content', 'contact_page_sections' );
function contact_page_sections() {
	$bg_shapes = array(
		'amp' => 2,
	);
	echo "<div class='contact-page__outer'>";
	obj_output_bg_shapes_array( $bg_shapes );
	echo '<div class="wrap">';
	contact_page_blurb();
	contact_page_form();
	echo '</div>';
	echo '</div>';
}

function contact_page_blurb() {
	$blurb = get_field( 'blurb' );
	echo '<h3 class="contact-tagline grande-text">' . $blurb . '</h3>';
}

function contact_page_form() {
	$form      = get_field( 'form' );
	$form_html = gravity_form( $form['id'], false, false, false, null, false, 1, false );
	echo "<div class='contact-form-wrap'>";
	echo remove_textarea_cols_and_rows( $form_html );
	echo '</div>';
}

// Build the page
get_header();
do_action( 'objectiv_page_content' );
get_footer();
