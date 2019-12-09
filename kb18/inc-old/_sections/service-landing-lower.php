<?php


function obj_do_service_land_lower_section( $low_sec = null, $section_classes = null, $bg_shapes = null ) {

	$sec_meta = decide_section_meta( 'service-lower', $section_classes, $low_sec, $bg_shapes );

	if ( ! empty( $low_sec ) ) {
		do_section_top( $sec_meta );
		obj_do_service_land_lower( $low_sec );
		do_section_bottom( $sec_meta );
	}
}

function obj_do_service_land_lower( $low_sec = null ) {

	$sec_title   = $low_sec['sec_title'];
	$sec_blurb   = $low_sec['sec_blurb'];
	$cta_blocks  = $low_sec['cta_blocks'];
	$testimonial = $low_sec['testimonial'];
	$sec_button  = $low_sec['sec_button'];
	$page_color  = get_field( 'page_color_colors' );
	$btn_class   = decide_page_button_class();

	?>
	<?php obj_section_header( $sec_title, $sec_blurb ); ?>
	<?php obj_do_cta_block_grid( $cta_blocks ); ?>
	<?php obj_do_testimonial( $testimonial ); ?>
	<?php if ( ! empty( $sec_button ) ) : ?>
		<div class="service-lower__button-wrap tac">
			<?php echo objectiv_link_button( $sec_button, $btn_class . ' large-button' ); ?>
		</div>
	<?php endif; ?>
	<?php
}
