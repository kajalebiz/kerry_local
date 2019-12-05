<?php

function obj_do_testimonial( $t_id = null, $class = null ) {
	if ( ! empty( $t_id ) ) {
		$t        = get_post( $t_id );
		$quote    = wp_strip_all_tags( $t->post_content, true );
		$name     = $t->post_title;
		$company  = get_field( 'testimonial_company', $t_id );
		$position = get_field( 'testimonial_position', $t_id );

		if ( ! empty( $quote ) ) {
			?>
			<div class="testimonial lmb0 <?php echo $class; ?>">
				<div class="testimonial__quote lmb0">
					&ldquo;<?php echo $quote; ?>&rdquo;
				</div>
				<?php if ( ! empty( $name ) ) : ?>
					<p class="testimonial__name"><?php echo $name; ?></p>
				<?php endif; ?>
				<?php if ( ! empty( $position ) ) : ?>
					<p class="testimonial__position"><?php echo $position; ?></p>
				<?php endif; ?>
				<?php if ( ! empty( $company ) ) : ?>
					<p class="testimonial__company"><?php echo $company; ?></p>
				<?php endif; ?>
			</div>
			<?php
		}
	}
}

function obj_do_testimonial_slider( $testimonials = null, $class = null ) {
	if ( is_array( $testimonials ) ) {
		echo "<div class='testimonial-slider__outer'>";

		foreach ( $testimonials as $t ) {
			obj_do_testimonial( $t, 'testimonial-slide ' . $class );
		}

		echo '</div>';
	}
}
