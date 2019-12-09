<?php

/**
 * Viewport Meta Tag for Mobile Browsers
 *
 * @author Bill Erickson
 * @link http://www.billerickson.net/code/responsive-meta-tag
 */
function objectiv_viewport_meta_tag() {
	echo '<meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover"/>';
}

/**
 * Add Mobile Menu Trigger
 *
 * @author Wesley Cole
 * @link http://objectiv.co/
 */
add_action( 'genesis_header', 'objectiv_mobile_trigger' );
function objectiv_mobile_trigger() {

	if ( has_nav_menu( 'mobile-menu' ) ) { ?>
		<div class="mobile-show mobile-menu-icon">
			<span></span>
			<span></span>
			<span></span>
			<span></span>
		</div>
	<?php
	}
}

/**
 * Add Mobile Menu
 *
 * @author Wesley Cole
 * @link http://objectiv.co/
 */
add_action( 'genesis_before_header', 'objectiv_mobile_menu' );
function objectiv_mobile_menu() {

	if ( has_nav_menu( 'mobile-menu' ) ) {
	?>
		<div id="mobile-menu" class="mobile-menu">
			<?php wp_nav_menu( array( 'theme_location' => 'mobile-menu' ) ); ?>
		</div>
	<?php
	}
}

// Add an "Author" meta tag with  the blog name as the value.
function objectiv_add_author_to_head() {
	?>
	<meta name="author" content="<?php bloginfo( 'name' ); ?>">
	<?php
}
add_action( 'wp_head', 'objectiv_add_author_to_head' );

// Wrapper to allow for safe "getting of file contents" replaces "file_get_contents"
function objective_url_get_contents( $url ) {
	$args = array(
		'sslverify' => false,
	);
	return wp_remote_retrieve_body( wp_remote_get( $url, $args ) );
}
