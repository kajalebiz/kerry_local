<?php

/*
Template Name: New Front Page
*/

// full width layout
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

// Remove 'site-inner' from structural wrap
add_theme_support( 'genesis-structural-wraps', array( 'header', 'nav', 'subnav', 'footer-widgets', 'footer' ) );

add_action( 'objectiv_page_content', 'front_page_sections' );
function front_page_sections() {        
//	obj_front_first_content();
        obj_front_tabbed_cta();
	obj_front_angled_slider();
        obj_front_featured_clients();
	obj_front_book_hero();
	obj_front_about_kerry();
	obj_front_angled_slider_2();
	obj_front_blog_cta_twitter();
}

function obj_front_first_content() {
	$content = get_field( 'front_first_content' );

	if ( ! empty( $content ) ) {
		$content_section = array(
			'section_id'       => $content['section_id'],
			'section_paddings' => 'top',
			'section_margins'  => 'none',
			'content'          => $content['content'],
		);

		$bg_shapes = array(
			'oval' => 1,
			'rect' => 1,
		);

		obj_content_section( $content_section, '', $bg_shapes );
	}
}

function obj_front_tabbed_cta() {
	$tab_content = get_field( 'front_tabbed_cta_details' );

	if ( ! empty( $tab_content ) ) {
		$tab_section = array(
			'section_id'       => $tab_content['section_id'],
			'section_paddings' => 'both',
			'section_margins'  => 'none',
			'tabs'             => $tab_content['cta_blocks'],
		);

//		obj_tabbed_cta( $tab_section, 'bg-yellow section-yellow' );
		obj_tabbed_cta( $tab_section, 'front-tabbing' );
	}
}

function obj_front_angled_slider() {
	$slider_content = get_field( 'front_angled_slider' );

	if ( ! empty( $slider_content ) ) {
		$slider_section = array(
			'section_id'       => $slider_content['section_id'],
			'section_paddings' => 'none',
			'section_margins'  => 'none',
			'section_wrap'     => false,
			'slides'           => $slider_content['angled_slides'],
			'classes'          => 'top-gray bottom-yellow',
		);

		obj_angled_slider( $slider_section, null );
	}
}

function obj_front_featured_clients() {
	$fc_deets  = get_field( 'front_featured_clients' );
//	$fc_button = get_field( 'featured_clients_button' );

	if ( ! empty( $fc_deets ) ) {
		$featured_clients_section = array(
			'section_id'            => $fc_deets['section_id'],
			'section_paddings'      => 'none',
			'section_margins'       => 'none',
			'section_wrap'          => false,
			'section_title'         => $fc_deets['section_title'],
			'featured_clients_grid' => $fc_deets['featured_clients_grid'],
//			'cta-button'            => $fc_button,
		);

		obj_do_featured_clients_section( $featured_clients_section, 'front_feature_client' );

	}
}

function obj_front_book_hero() {
	$book_hero = get_field( 'front_book_hero_details' );

	if ( ! empty( $book_hero ) ) {
		$book_hero_section = array(
			'section_id'       => $book_hero['section_id'],
			'section_paddings' => 'none',
			'section_margins'  => 'none',
			'section_wrap'     => false,
			'background_image' => $book_hero['background_image'],
			'book_image'       => $book_hero['book_image'],
		);

		$bg_shapes = array(
			'oval' => 1,
		);

		obj_book_hero( $book_hero_section, '', $bg_shapes );
	}
}

function obj_front_about_kerry() {
	$about_content = get_field( 'front_about_content' );
	$section_id    = get_field( 'front_about_section_id' );
	$testimonial   = get_field( 'front_about_testimonial' );
	$logos         = get_field( 'front_about_logos' );
	$button        = get_field( 'front_about_button' );

	if ( ! empty( $about_content ) ) {
		$about_kerry_section = array(
			'section_id'       => $section_id['section_id'],
			'section_paddings' => 'top',
			'section_margins'  => 'none',
			'about_content'    => $about_content,
			'testimonial'      => $testimonial,
			'logos'            => $logos,
			'button'           => $button,
		);

		$bg_shapes = array(
			'rect' => 1,
		);

		obj_about_kerry( $about_kerry_section, '', $bg_shapes );
	}
}

function obj_front_angled_slider_2() {
	$slider_content = get_field( 'front_angled_slider_2' );
	$slider_showing = get_field( 'front_sec_showing_slider' );

	if ( ! empty( $slider_content ) && $slider_showing == true ) {
		$slider_section = array(
			'section_id'       => $slider_content['section_id'],
			'section_paddings' => 'none',
			'section_margins'  => 'none',
			'section_wrap'     => false,
			'slides'           => $slider_content['angled_slides'],
			'classes'          => 'top-gray bottom-gray',
		);

		obj_angled_slider( $slider_section, null );
	}
}

function obj_front_blog_cta_twitter() {
	$display_blog       = get_field( 'front_display_recent_blog_posts' );
	$resources          = get_field( 'front_resource_details' );
	$email_cta          = get_field( 'front_email_cta' );
	$email_form         = get_field( 'front_email_optin_form' );
	$display_tweet      = get_field( 'front_latest_tweet' );
	$home_event_image   = get_field( 'front_home_event_image' );
	$home_event_details = get_field( 'front_home_event_details' );
	$sec_showing_slider = get_field( 'front_sec_showing_slider' );
        if($sec_showing_slider == false){
            $bg_shapes     = array(
		'rect' => 1,
		'twit' => 1,
            );
        } else {
            $bg_shapes     = array(
		'oval' => 1,
		'rect' => 1,
		'twit' => 1,
	);
        }	

	echo "<section class='home-lower section-padding'>";
	obj_output_bg_shapes_array( $bg_shapes );
	echo "<div class='wrap'>";
	if ( is_array( $resources ) || is_array( $email_cta ) ) {
		echo "<div class='home-lower-row-1 home-lower-row home_resources_main'>";
		echo "<div class='two-posts-grid'>";
		if ( is_array( $resources ) ) {
			obj_do_resources( $resources );
		}
		echo '</div>';
		echo '</div>';
	}
        if($home_event_details){
            echo '<div class="home_event_miss" style="background-image: url('.$home_event_image['url'].')">';
            echo $home_event_details;
            echo "</div>";
        }
        if ( $display_blog ) {
		echo "<div class='home-lower-row-1 home-lower-row front_blogs'>";
		obj_do_two_recent_posts();
		echo '</div>';
	}
	if ( $display_tweet ) {
		echo "<div class='home-lower-row-1 home-lower-row twitter_responsive_sec'>";
                echo "<div class='two-posts-grid'>";
                echo "<div class='home-lower-row-2__second'>";
		obj_do_latest_tweet_hero();
		echo '</div>';
                echo "<div class='home-lower-row-2__second'>";
		if ( !empty( $email_form ) ) {
			echo $email_form;
		}
		echo '</div>';
                echo '</div>';
                echo '</div>';
                
	}
	echo '</div>';
	echo '</section>';
}

// Build the page
get_header();
do_action( 'objectiv_page_content' );
get_footer();
