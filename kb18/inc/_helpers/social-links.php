<?php

function obj_do_social_links( $staff_id = null ) {

	if ( ! empty( $staff_id ) ) {
		$pull_from = $staff_id;
	} else {
		$pull_from = 'option';
	}

	$selection = get_field( 'social_selection', $pull_from );

	if ( ! empty( $selection ) && is_array( $selection ) ) { ?>
		<div class="social-links">
			<?php foreach ( $selection as $social_platform ) : ?>
				<?php $link_field = $social_platform . '_link'; ?>
				<?php $selection  = get_field( $link_field, $pull_from ); ?>
				<span class="social-link <?php echo $social_platform; ?>">
					<a href="<?php echo $selection; ?>" target="_blank">
						<div class="social-link__svg-wrap">
							<?php echo get_svg( $social_platform ); ?>
						</div>
					</a>
				</span>
			<?php endforeach; ?>
		</div>
	<?php
	}

}
