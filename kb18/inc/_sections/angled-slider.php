<?php

function obj_angled_slider( $section_details = null, $section_classes = null, $bg_shapes = null ) {

	$sec_meta = decide_section_meta( 'angled-slider-section', $section_classes, $section_details, $bg_shapes );

	if ( ! empty( $section_details ) ) {
		do_section_top( $sec_meta );
		obj_do_slides( $section_details );
		do_section_bottom( $sec_meta );
	}
}

function obj_do_slides( $section_details = null ) {

	$classes                 = $section_details['classes'];
	$slides                  = $section_details['slides'];
	$use_dots                = count( $slides ) > 1;
	$use_dots_data_attribute = 'data-use-dots="' . ( $use_dots ? 'true' : 'false' ) . '"';

	if ( ! empty( $slides ) ) {
		echo "<div class='angled-slider-outer-wrap " . $classes . "'>";
		echo "<div class='top-color-block'></div>";
		echo "<div class='angled-slider-wrap'" . $use_dots_data_attribute . '>';
		foreach ( $slides as $slide ) {
			obj_do_angled_slide( $slide );
		}
		echo '</div>';
		echo "<div class='angled-slider__dots-outer'>";
		echo "<div class='wrap'>";
		echo "<div class='angled-slider__dots-inner'>";
		echo '</div>';
		echo '</div>';
		echo '</div>';
		echo '</div>';
	}
}

function obj_do_angled_slide( $slide = null ) {
	$slide_image       = $slide['image'];
	$block_title       = $slide['block_title'];
	$block_sub_title   = $slide['block_sub_title'];
	$block_image       = $slide['block_image'];
	$block_button      = $slide['block_button'];
	$block_button_type = $slide['block_button_type'];

	if ( 'video_modal' === $block_button_type ) {
		$block_button['video_modal'] = true;
	}

	if ( ! empty( $slide_image ) ) {
            if(is_page_template( 'template-cxpa-landing.php' )){
                $slide_image = $slide_image['url'];
            } else {
		$slide_image = $slide_image['sizes']['obj-angled-slide'];
	}
	}

	if ( ! empty( $slide_image ) ) {
		?>
		<div class="angled-slide">
			<div class="angled-slide__bg-image bg-cover" style="background-image: url(<?php echo $slide_image; ?>)" data-image-url="<?php echo parse_url( $slide_image )['path']; ?>"></div>
			<div class="angled-slide__block-wrap">
				<div class="wrap">
					<div class="angled-slide__block">
						<?php if ( ! empty( $block_title ) ) : ?>
							<div class="angled-slide__block__title"><?php echo esc_html( $block_title ); ?></div>
						<?php endif; ?>
						<?php if ( ! empty( $block_sub_title ) ) : ?>
							<div class="angled-slide__block__sub-title"><?php echo esc_html( $block_sub_title ); ?></div>
						<?php endif; ?>
						<?php if ( ! empty( $block_image ) ) : ?>
							<div class="angled-slide__block__image">
								<?php $block_image = wp_get_attachment_image( $block_image['ID'], 'large' ); ?>
								<?php echo $block_image; ?>
							</div>
						<?php endif; ?>
						<?php if ( ! empty( $block_button ) ) : ?>
							<div class="angled-slide__block__button-wrap">
								<?php echo objectiv_link_button( $block_button ); ?>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
		<?php
	}
}
