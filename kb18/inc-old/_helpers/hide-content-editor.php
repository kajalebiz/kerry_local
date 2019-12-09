<?php

/**
 * Hide editor for content builder pages.
 *
 */
function objectiv_hide_editor() {

	// Get the Post ID.
	$post_id = $_GET['post'] ? $_GET['post'] : $_POST['post_ID'];
	if ( ! isset( $post_id ) ) {
		return;
	}

	// Get the name of the Page Template file.
	$template_file = get_post_meta( $post_id, '_wp_page_template', true );

	$front_page_id = get_option( 'page_on_front' );
	$blog_id       = get_option( 'page_for_posts' );

	$template_list = array(
		'template-content-builder.php',
		'template-front-page.php',
		'template-subscribe.php',
		'template-what-we-do.php',
		'template-service-landing.php',
		'template-speaking-keynotes.php',
		'template-speaking-webinars.php',
		'template-journey-development.php',
		'template-journey-coaching.php',
		'template-journey-bootcamps.php',
		'template-experience-sub-page.php',
		'template-experience-bootcamps.php',
		'template-culture-creation.php',
		'template-events-list.php',
		'template-resources.php',
		'template-about.php',
		'template-privacy.php',
	);

	if ( in_array( $template_file, $template_list ) || $front_page_id === $post_id || $blog_id === $post_id ) { // edit the template name
		remove_post_type_support( 'page', 'editor' );
	}
}
add_action( 'admin_init', 'objectiv_hide_editor' );
