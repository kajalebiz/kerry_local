<?php

function obj_do_cta_block( $block = null ) {
	if ( ! empty( $block ) ) {
		$color        = $block['colors'];
		$title        = $block['title'];
		$blurb        = $block['blurb'];
		$buttons      = $block['buttons'];
		$button_style = $color . '-button';
		$bg_type      = $block['block_bg'];
		$bg_class     = null;

		if ( $bg_type === 'solid' ) {
			$bg_class = 'solid-bg';

			if ( $color === 'green' ) {
				$button_style = 'yellow-button';
			}

			if ( $color === 'yellow' ) {
				$button_style = 'red-button';
			}

			if ( $color === 'blue' ) {
				$button_style = 'green-button';
			}

			if ( $color === 'red' ) {
				$button_style = 'blue-button';
			}
                        
		} else {
			if ( $color === 'default' ) {
				$button_style = 'primary-button';
			}

			if ( $color === 'green' ) {
				$button_style = 'green-button';
			}

			if ( $color === 'yellow' ) {
				$button_style = 'yellow-button';
			}

			if ( $color === 'blue' ) {
				$button_style = 'blue-button';
			}

                        if ( $color === 'red' ) {
				$button_style = 'blue-button';
                        }

		}

		?>
		<div class="cta-block <?php echo $color; ?>-block <?php echo $bg_class; ?>">
			<div class="cta-block__content">
				<?php if ( ! empty( $title ) ) : ?>
					<h3 class="cta-block__title"><?php echo $title; ?></h3>
				<?php endif; ?>
				<?php if ( ! empty( $blurb ) ) : ?>
					<div class="cta-block__blurb"><?php echo $blurb; ?></div>
				<?php endif; ?>
				<?php if ( ! empty( $buttons ) ) : ?>
					<?php foreach ( $buttons as $button ) : ?>
						<?php echo objectiv_link_button( $button['button'], $button_style ); ?>
					<?php endforeach; ?>
				<?php endif; ?>
			</div>
		</div>
		<?php
	}
}
