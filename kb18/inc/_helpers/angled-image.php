<?php

function obj_do_top_angled_image( $image = null, $class = null ) {
	if ( ! empty( $image ) ) {
		$img_id = $image['ID'];
		$image  = wp_get_attachment_image( $img_id, 'obj-large' );

		if ( ! empty( $image ) ) {
			echo "<div class='top-angled-image {$class}'>";
			echo $image;
			echo '</div>';
		}
	}
}
