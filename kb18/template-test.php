<?php

/*
Template Name: Optinmonster Popup
 */

// full width layout
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

// Remove 'site-inner' from structural wrap
add_theme_support( 'genesis-structural-wraps', array( 'header', 'nav', 'subnav', 'footer-widgets', 'footer' ) );

//* Add custom body class to the head
add_filter( 'body_class', 'obj_optin_body_class' );
function obj_optin_body_class( $classes ) {

	$classes[] = 'test-optin-popup';
	return $classes;

}

add_action( 'objectiv_page_content', 'obj_optin_sections' );
function obj_optin_sections() {
	obj_optin();
}

function obj_optin() {
	$content = get_field( 'kerrybodine_pop_up_links' );

	if ( ! empty( $content ) ) {
		$content_section = array(
			'section_id'       => 'privacy-content',
			'section_paddings' => 'top',
			'section_margins'  => 'bottom',
			'content'          => $content,
		);

		obj_optin_monst_section( $content_section, 'bg-light-gray test_optinmonster' );
	}
}

function obj_optin_monst_section( $content_section = null, $section_classes = null, $bg_shapes = null) { 
    
    $sec_meta = decide_section_meta( 'atc', $section_classes, $content_section, $bg_shapes );

    if ( ! empty( $content_section ) ) {
        do_section_top( $sec_meta );
        obj_optin_monst( $content_section );
        do_section_bottom( $sec_meta );
    }
}

function obj_optin_monst($content_section = null){
   foreach($content_section['content'] as $content_section_val){
       $popup_links = $content_section_val['single_pop_up_link'];
       echo "<span class ='primary-button'><a target='".$popup_links['target']."' href='".$popup_links['url']."'>".$popup_links['title']."e</a></span></br>";
   }
}
// Build the page
get_header();
do_action( 'objectiv_page_content' );
get_footer();