<?php
add_action( 'genesis_after_header', 'objectiv_page_banner', 15 );

function objectiv_page_banner() {
	$exclusion_conditions = array(
		is_singular( 'resource' ),
		is_singular( 'product' ),
		is_singular( 'post' ),
		is_singular( 'staff' ),
		is_page('cart'),
		is_page('checkout'),
		is_page('reset-password'),
		is_archive('product')
	);

	$no_exclusion_conditions_met = ! in_array( true, $exclusion_conditions );

	if ( $no_exclusion_conditions_met ) {
		echo get_template_part( 'inc/_helpers/hero', 'banner' );
	}
}
