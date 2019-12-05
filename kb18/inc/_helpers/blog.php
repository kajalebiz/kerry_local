<?php

function obj_do_two_recent_posts() {
	$args         = array(
		'numberposts'      => 2,
		'orderby'          => 'post_date',
		'order'            => 'DESC',
		'post_type'        => 'post',
		'post_status'      => 'publish',
		'suppress_filters' => true,
	);
	$recent_posts = wp_get_recent_posts( $args, ARRAY_A );

	if ( ! empty( $recent_posts ) ) {
		echo "<div class='two-posts-grid'>";
		foreach ( $recent_posts as $rp ) {
			$id       = $rp['ID'];
			$title    = $rp['post_title'];
			$perm     = get_the_permalink( $id );
			$feat_img = get_the_post_thumbnail( $id, 'full' );
			?>
			<div class="two-grid__post-block-outer">
				<a href="<?php echo $perm; ?>">
					<div class="two-grid__post-block">
						<?php if ( ! empty( $feat_img ) ) : ?>
							<?php echo $feat_img; ?>
						<?php endif; ?>
						<h5 class="two-grid__post-block__title"><?php echo $title; ?></h5>
						<div class="fake-button">Read More</div>
					</div>
				</a>
			</div>
			<?php
		}
		echo '</div>';
	}
}
