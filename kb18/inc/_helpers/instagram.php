<?php

// Client ID d1eb2edd89d14fbabfa5e5db4306568b - it is under KB's account.

function obj_display_latest_insta_pics_grid( $num = 8 ) {
	$at  = '7315618994.d1eb2ed.d6eade7cd7ac406ab205db93f689df32';
	$url = "https://api.instagram.com/v1/users/self/media/recent?access_token={$at}";

	$result = wp_safe_remote_get( $url );
	if ( is_wp_error( $result ) ) {
		return false; // Bail early
	}
	$body = wp_remote_retrieve_body( $result );
	$data = json_decode( $body );

	if ( ! empty( $data ) ) {
		$data  = $data->data;
		$count = 1;

		echo "<div class='instagram-grid__wrap'>";
		foreach ( $data as $image ) {
			$url  = $image->images->standard_resolution->url;
			$link = $image->link;

			if ( ! empty( $url ) && $count <= $num ) {
				echo "<div class='instagram-grid__image-wrap'>";
				?>
				<a target="_blank" href="<?php echo $link; ?>">
					<div class="instagram-grid__image" style="background-image:url(<?php echo $url; ?>)"></div>
				</a>
				<?php
				echo '</div>';
				$count += 1;
			}
		}
		echo '</div>';
	}
}
