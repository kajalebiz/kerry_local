<?php

// full width layout
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

// Remove 'site-inner' from structural wrap
add_theme_support( 'genesis-structural-wraps', array( 'header', 'nav', 'subnav', 'footer-widgets', 'footer' ) );

//* Remove default loop
remove_action( 'genesis_loop', 'genesis_do_loop' );

// Swap out the placeholder text for the search box
function objectiv_search_placeholder_404( $placeholder ) {
	$place_text = 'What were you looking for?';
	return $place_text;
}
add_filter( 'genesis_search_text', 'objectiv_search_placeholder_404', 10, 1 );

add_action( 'objectiv_page_content', 'four_04_page_content' );
function four_04_page_content() {
	objectiv_404();
}

// Add the 404 page markup
function objectiv_404() {
	?>

	<section class="section-404">
		<div class="content-404 wrap inside-content-wrap">
			<div class="amp-svg-wrap">
				<?php echo get_svg( 'ampersand' ); ?>
			</div>
			<p>Even a wrong turn to a 404 page like this one. <a href="javascript:history.go(-1)">Click here to go back</a> or give a search a whirl. But in the meantime, enjoy this sleepy kitten.</p>
			<?php get_search_form(); ?>
		</div>
	</section>

	<?php
}

// Build the page
get_header();
do_action( 'objectiv_page_content' );
get_footer();
