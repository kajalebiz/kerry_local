<?php

function obj_do_foot_cta( $foot_cta = null, $display_universe_button, $display_universe_link ) {
	if ( ! empty( $foot_cta ) ) {
		$bg_color  = $foot_cta['colors'];
		$title     = $foot_cta['title'];
		$blurb     = $foot_cta['blurb'];
		$buttons   = $foot_cta['buttons'];
		$bg_class  = $bg_color . '-background';
		$btn_class = 'green-button';

		if ( $bg_color === 'green' || $bg_color === 'default' ) {
			$btn_class = 'yellow-button';
		} elseif ( $bg_color === 'yellow' ) {
			$btn_class = 'red-button';
		}

		?>
		<div class="foot-cta__outer section-padding <?php echo $bg_class; ?>">
			<div class="wrap">
				<div class="foot-cta__content">
					<?php if ( ! empty( $title ) ) : ?>
						<h2 class="foot-cta__title"><?php echo $title; ?></h2>
					<?php endif; ?>
					<?php if ( ! empty( $blurb ) ) : ?>
						<div class="footer-cta__blurb lmb0"><?php echo $blurb; ?></div>
					<?php endif; ?>
					<?php if ( ! empty( $buttons ) && ! $display_universe_button ) : ?>
						<?php foreach ( $buttons as $button ) : ?>
							<?php echo objectiv_link_button( $button['button'], $btn_class . ' large-button' ); ?>
						<?php endforeach; ?>
					<?php endif; ?>
					<?php if ( $display_universe_button ) : ?>
					<span class="large-button <?php echo $btn_class; ?>">
						<a class="unii-listing-button" href="<?php echo $display_universe_link; ?>">Get Tickets</a>
					</span>
					<?php endif; ?>
				</div>
			</div>
		</div>
		<?php
	}
}

function obj_do_angled_foot_block_cta( $image = null, $block = null ) {
	if ( ! empty( $image ) && ! empty( $block ) ) {
		obj_do_top_angled_image( $image );
		echo "<div class='block-outer-wrap'>";
		echo "<div class='wrap'>";
		echo "<div class='block-inner-wrap'>";
		obj_do_cta_block( $block );
		echo '</div>';
		echo '</div>';
		echo '</div>';
	}
}
