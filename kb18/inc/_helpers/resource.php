<?php

function obj_do_resources( $resources = null, $num = null ) {

	$resource_display     = null;
	$resources_to_display = null;
	if ( empty( $num ) ) {
		$num = 1;
	}

	if ( is_array( $resources ) ) {
		$resource_display     = $resources['resource_display'];
		$resources_to_display = $resources['resources_to_display'];
	}

	if ( $resource_display === 'auto' ) {
		$order = null;
	} elseif ( $resource_display === 'random' ) {
		$order = 'rand';
	}

	if ( $resource_display !== 'manual' ) {
        
		$args = array(
			'posts_per_page' => $num,
			'orderby'        => $order,
			'post_type'      => 'resource',
			'post_status'    => 'publish',
		);

		$resources = get_posts( $args );
	} else {
		$resources = $resources_to_display;
	}

	if ( is_array( $resources ) && ! empty( $resources ) ) {
		// echo "<div class='resources-outer'>";
		foreach ( $resources as $r ) {
			obj_do_resource_block( $r );
		}
		// echo '</div>';
	}

}

function obj_do_resource_block( $r = null ) {
	$id    = $r->ID;
	$title = $r->post_title;
	$perm  = get_permalink( $id );
	$blurb = get_field( 'blurb', $id );
	$thumb = get_the_post_thumbnail_url( $id, 'medium_large' );
	?>
	<div class="resource-block__outer">
		<a href="<?php echo $perm; ?>">
			<div class="resource-block">
				<img src="<?php echo $thumb; ?>" alt="<?php echo $title; ?> featured image" class="attachment-obj-blog-block size-obj-blog-block wp-post-image">
				<h4 class="resource-block__title"><?php echo $title; ?></h4>
				<?php if ( ! empty( $blurb ) ) : ?>
					<div class="resource-block__blurb"><?php echo $blurb; ?></div>
				<?php endif; ?>
				<div class="fake-button">Download</div>
			</div>
		</a>
	</div>
	<?php
}

function obj_resource_grid( $resources = null, $top = false ) {
	if ( ! empty( $resources ) && is_array( $resources ) ) {
		$top_class = ( $top ) ? 'top-grid' : 'alt-grid';
		$count     = 1;

		// Output the actual resource grid
		echo "<div class='resource-grid__wrap {$top_class}'>";
		foreach ( $resources as $r ) {
			$status = get_post_status( $r );
			if ( $status === 'publish' ) {
				obj_resource_grid_block( $r, $top, $count );
				$count += 1;
			}
		}
		echo '</div>';
	}
}

function obj_resource_grid_block( $r_id = null, $top = false, $count = null ) {
	$title          = get_the_title( $r_id );
	$perm           = get_permalink( $r_id );
	$hover_blurb    = get_field( 'hover_blurb', $r_id );
	$border_control = get_field( 'border_on_archive', $r_id );
	$large_vert     = get_field( 'resource_archive_large_vertical_image', $r_id );
	$small_vert     = get_field( 'resource_archive_smaller_vertical_image', $r_id );
	$small_wide     = get_field( 'resource_archive_smaller_wide_image', $r_id );
	$display        = true;
	$image_1        = null;

	// Top Logic
	if ( $top ) {
		if ( $count === 1 ) {
			$image = wp_get_attachment_image( $large_vert, 'obj-resource-large-vertical' );
		} elseif ( ( 2 === $count ) || ( 3 === $count ) ) {
			$image = wp_get_attachment_image( $small_vert, 'obj-resource-small-vertical' );
		}

		if ( $count > 3 ) {
			$display = false;
		}
	}

	if ( ! $top ) {
			$image   = wp_get_attachment_image( $small_wide, 'obj-resource-wide-horizontal', false, array( 'class' => 'small-wide-resource-img' ) );
			$image_1 = wp_get_attachment_image( $small_vert, 'obj-resource-small-vertical', false, array( 'class' => 'small-vert-resource-img' ) );
	}

	if ( $border_control ) {
		$border_class = null;
	} else {
		$border_class = 'has-border';
	}

	if ( $display ) {
		?>
		<div class="resource-archive-block__outer">
			<a href="<?php echo $perm; ?>">
				<div class="resource-archive-block">
					<?php if ( ! empty( $image ) ) : ?>
						<div class="resource-archive-block__image-wrap <?php echo $border_class; ?>">
							<?php echo $image; ?>
							<?php if ( ! empty( $image_1 ) ) : ?>
								<?php echo $image_1; ?>
							<?php endif; ?>
						</div>
					<?php endif; ?>
					<div class="resource-archive-block__details">
						<h3><?php echo $title; ?></h3>
						<?php if ( ! empty( $hover_blurb ) ) : ?>
							<div class="resource-archive-block__hover-blurb"><?php echo $hover_blurb; ?></div>
						<?php endif; ?>
						<div class="fake-button">Download</div>
					</div>
				</div>
			</a>
		</div>
		<?php
	}
}
