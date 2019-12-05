<?php

function obj_mailchimp_section( $sub_deets = null, $section_classes = null, $bg_shapes = null ) {
	$sec_meta = decide_section_meta( 'mailchimp-section', $section_classes, $sub_deets, $bg_shapes );
	if ( ! empty( $sub_deets ) ) {
		do_section_top( $sec_meta );
		obj_do_mailchimp_content( $sub_deets );
		do_section_bottom( $sec_meta );
	}
}

function obj_do_mailchimp_content( $sub_deets = null, $class = null ) {
	$mc_title = $sub_deets['mc_title'];
	$mc_blurb = $sub_deets['mc_blurb'];
	$gform    = $sub_deets['gravity_form'];
	$form     = get_field( 'default_mailchimp_form', 'option' );

	if ( ! empty( $form ) || ! empty( $form ) ) {
	?>
		<div class="obj-mailchimp-form-wrap <?php echo $class; ?>">
			<?php if ( ! empty( $mc_title ) ) : ?>
				<h2 class="mailchimp-section__title mlra"><?php echo esc_html( $mc_title ); ?></h2>
			<?php endif; ?>
			<?php if ( ! empty( $mc_blurb ) ) : ?>
				<div class="mailchimp-section__blurb lmb0 mlra green-li">
					<?php echo $mc_blurb; ?>
				</div>
			<?php endif; ?>
			<div class="mailchimp-section__form-wrap mlra">
				<?php if ( ! empty( $gform ) ) : ?>
					<?php gravity_form( $gform['id'], false, false, false, '', true ); ?>
				<?php elseif ( ! empty( $form ) ) : ?>
					<?php echo $form; ?>
				<?php endif; ?>
			</div>
		</div>
	<?php
	}
}

// The angled version of a similar section
function obj_mailchimp_centered_angled_section( $sub_deets = null, $section_classes = null ) {
	$sec_meta = decide_section_meta( 'mailchimp-centered-angled-section', $section_classes, $sub_deets );
	if ( ! empty( $sub_deets ) ) {
		do_section_top( $sec_meta );
		obj_do_mailchimp_centered_angled_content( $sub_deets );
		do_section_bottom( $sec_meta );
	}
}

function obj_do_mailchimp_centered_angled_content( $sub_deets = null, $class = null ) {
	$mc_title  = $sub_deets['sec_title'];
	$grav_form = $sub_deets['grav_form'];
	$form      = get_field( 'default_mailchimp_form', 'option' );

	if ( ! empty( $form ) || ! empty( $grav_form ) ) {
		?>
		<div class="obj-mailchimp-form-wrap <?php echo $class; ?>">
			<?php if ( ! empty( $mc_title ) ) : ?>
				<h2 class="mailchimp-section__title"><?php echo esc_html( $mc_title ); ?></h2>
			<?php endif; ?>
				<div class="mailchimp-section__form-wrap">
					<?php if ( ! empty( $grav_form ) ) : ?>
						<?php gravity_form( $grav_form['id'], false, false, false, '', true ); ?>
					<?php elseif ( ! empty( $form ) ) : ?>
						<?php echo $form; ?>
					<?php endif; ?>
				</div>
		</div>
		<?php
	}
}
