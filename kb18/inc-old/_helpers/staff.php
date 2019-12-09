<?php

function do_event_staff_grid( $staff = null ) {
	if ( is_array( $staff ) ) {
		echo "<div class='event-staff-grid'>";
		foreach ( $staff as $s ) {
			do_staff_block( $s );
		}
		echo '</div>';
	}
}

function do_staff_block( $s_id = null ) {
	if ( ! empty( $s_id ) ) {
		$headshot  = get_post_thumbnail_id( $s_id );
		$name      = get_the_title( $s_id );
		$position  = get_field( 'position', $s_id );
		$perm      = get_the_permalink( $s_id );
		$btn_class = decide_page_button_class();
		if ( ! empty( $headshot ) ) {
			$head_image = wp_get_attachment_image( $headshot, 'obj-image-blurb-block' );
		}
		if ( ! empty( $head_image ) && ! empty( $perm ) ) { ?>
			<div class="event-staff__block">
				<div class="event-staff__block-headshot-wrap">
					<a href="<?php echo $perm; ?>">
						<?php echo $head_image; ?>
					</a>
				</div>
				<div class="event-staff__block-deets-wrap">
				<?php if ( ! empty( $name ) || ! empty( $position ) ) : ?>
					<div class="event-staff__block-first-deets">
						<?php if ( ! empty( $name ) ) : ?>
							<a href="<?php echo $perm; ?>">
								<h5 class="event-staff_block-name"><?php echo $name; ?></h5>
							</a>
						<?php endif; ?>
						<?php if ( ! empty( $position ) ) : ?>
							<div class="event-staff_block-position"><?php echo $position; ?></div>
						<?php endif; ?>
						<?php obj_do_social_links( $s_id ); ?>
					</div>
					<div class="event-staff__block-second-deets">
						<span class="<?php echo $btn_class; ?>">
							<a href="<?php echo $perm; ?>">Read More</a>
						</span>
					</div>
				<?php endif; ?>
				</div>
			</div>
		<?php
		}
	}
}
