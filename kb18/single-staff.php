<?php

// full width layout
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

// Remove 'site-inner' from structural wrap
add_theme_support( 'genesis-structural-wraps', array( 'header', 'nav', 'subnav', 'footer-widgets', 'footer' ) );

//* Add custom body class to the head
add_filter( 'body_class', 'obj_journey_development_body_class' );
function obj_journey_development_body_class( $classes ) {
	$classes[] = 'single-staff colored-title';
	return $classes;
}

add_action( 'objectiv_page_content', 'obj_staff_page_sections' );
function obj_staff_page_sections() {
	obj_staff_header();
	obj_staff_details();
	obj_staff_bottom_cta();
}

function obj_staff_header() {
	$book_hero = get_field( 'header_book_image' );
	$bg_image  = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large' );

	if ( is_array( $bg_image ) ) {
		$bg_image = $bg_image[0];
	}

	$book_hero_section = array(
		'section_id'       => 'staff-hero',
		'section_paddings' => 'none',
		'section_margins'  => 'none',
		'section_wrap'     => false,
		'background_image' => $bg_image,
		'book_image'       => $book_hero,
	);

	obj_book_hero( $book_hero_section, '' );
}

function obj_staff_details() {
	$name         = get_the_title();
	$position     = get_field( 'position' );
	$post         = get_post();
	$post_content = $post->post_content;
	$button       = get_field( 'footer_button' );
	$bg_shapes    = array(
		'amp' => 1,
	);
	?>
	<section class="single-staff__outer">
		<?php obj_output_bg_shapes_array( $bg_shapes ); ?>
		<div class="wrap">
			<div class="single-staff__inner">
				<?php if ( ! empty( $name ) ) : ?>
					<h1 class="single-staff__name"><?php echo $name; ?></h1>
				<?php endif; ?>
				<?php if ( ! empty( $position ) ) : ?>
					<h4 class="single-staff__position"><?php echo $position; ?></h4>
				<?php endif; ?>
				<?php obj_do_social_links( get_the_ID() ); ?>
				<?php if ( ! empty( $post_content ) ) : ?>
					<div class="single-staff__content lmb0">
						<?php echo $post_content; ?>
					</div>
				<?php endif; ?>
				<?php if ( ! empty( $button ) ) : ?>
					<?php echo objectiv_link_button( $button, 'green-button large-button' ); ?>
				<?php endif; ?>
			</div>
		</div>
	</section>
	<?php
}

function obj_staff_bottom_cta() {
	$foot_cta_details = get_field( 'footer_cta_details' );

	if ( ! empty( $foot_cta_details ) ) {
		$foot_cta_section = array(
			'section_id'       => 'foot-cta',
			'section_paddings' => 'none',
			'section_wrap'     => false,
			'section_margins'  => 'none',
			'footer_cta'       => $foot_cta_details,
		);

		obj_foot_cta( $foot_cta_section, 'bg-light-gray' );
	}
}

// Build the page
get_header();
do_action( 'objectiv_page_content' );
get_footer();
