<?php

function obj_do_why_kerry_section( $why_kerry_sec = null, $section_classes = null, $bg_shapes = null ) {

	$sec_meta = decide_section_meta( 'why-kerry', $section_classes, $why_kerry_sec, $bg_shapes );

	if ( ! empty( $why_kerry_sec ) ) {
		do_section_top( $sec_meta );
		obj_do_why_kerry( $why_kerry_sec );
		do_section_bottom( $sec_meta );
	}
}

function obj_do_why_kerry( $why_kerry_sec = null ) {

	$page_color = get_field( 'page_color_colors' );
	$btn_class  = decide_page_button_class();
	$sec_button = $why_kerry_sec['sec_button'];

	if ( array_key_exists( 'video_url', $why_kerry_sec ) && array_key_exists( 'video_thumb', $why_kerry_sec ) ) {
		$vid_block = array(
			'video_url'   => $why_kerry_sec['video_url'],
			'video_thumb' => $why_kerry_sec['video_thumb'],
		);

		obj_do_pop_video( $vid_block );
	}

	if ( array_key_exists( 'sec_title', $why_kerry_sec ) && array_key_exists( 'sec_blurb', $why_kerry_sec ) ) {
		obj_section_header( $why_kerry_sec['sec_title'], $why_kerry_sec['sec_blurb'] );
	}

	if ( array_key_exists( 'grid_blocks', $why_kerry_sec ) ) {
		obj_do_grid_blocks( $why_kerry_sec['grid_blocks'] );
	}

	if ( array_key_exists( 'testimonial', $why_kerry_sec ) ) {
		obj_do_testimonial( $why_kerry_sec['testimonial'] );
	}

	if ( ! empty( $sec_button ) ) : ?>
			<div class="section__button-wrap">
				<?php echo objectiv_link_button( $sec_button, $btn_class . ' large-button' ); ?>
			</div>
		<?php
	endif;

}
