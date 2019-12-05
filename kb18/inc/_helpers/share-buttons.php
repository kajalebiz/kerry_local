<?php

function obj_do_sharing_buttons( $url = null, $title = null ) {

	if ( ! empty( $url ) && ! empty( $title ) ) {
		$title = urlencode( $title );
		?>
		<div class="social-share-buttons">
			<!-- Google+ -->
			<div class="social-link google">
				<a href="https://plus.google.com/share?url=<?php echo $url; ?>" target="_blank">
				<div class="social-link__svg-wrap">
					<?php echo get_svg( 'google' ); ?>
				</div>
				</a>
			</div>

			<!-- Twitter -->
			<div class="social-link twitter">
				<a href="https://twitter.com/share?url=<?php echo $url; ?>&amp;text=<?php $title; ?>" target="_blank">
				<div class="social-link__svg-wrap">
					<?php echo get_svg( 'twitter' ); ?>
				</div>
				</a>
			</div>

			<!-- LinkedIn -->
			<div class="social-link linkedin">
				<a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo $url; ?>" target="_blank">
				<div class="social-link__svg-wrap">
					<?php echo get_svg( 'linkedin' ); ?>
				</div>
				</a>
			</div>
		</div>
	<?php
	}

}
