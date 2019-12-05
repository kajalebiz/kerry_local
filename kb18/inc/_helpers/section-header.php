<?php

function obj_section_header( $sec_title = null, $sec_blurb = null ) {

	if ( ! empty( $sec_title ) ) : ?>
		<h2 class="large-colored-section-title"><?php echo $sec_title; ?></h2>
	<?php endif; ?>
	<?php if ( ! empty( $sec_blurb ) ) : ?>
		<div class="section-intro-blurb lmb0">
			<?php echo $sec_blurb; ?>
		</div>
	<?php
	endif;
}

function obj_smaller_section_header( $sec_title = null, $sec_blurb = null ) {
	if ( ! empty( $sec_title ) ) :
	?>
		<h3 class="smaller-section-title"><?php echo $sec_title; ?></h3>
	<?php endif; ?>
	<?php if ( ! empty( $sec_blurb ) ) : ?>
		<div class="smaller-section-intro-blurb lmb0">
			<?php echo $sec_blurb; ?>
		</div>
	<?php
endif;
}
