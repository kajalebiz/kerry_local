<?php

function obj_do_grid_blocks( $blocks = null, $classes = null ) {
	if ( ! empty( $blocks ) && is_array( $blocks ) ) {
		echo "<div class='grid-blocks__wrap {$classes}'>";
		foreach ( $blocks as $gb ) {
			echo "<div class='grid-block'>";
			if ( ! empty( $gb['title'] ) ) {
				echo "<h5 class='grid-block__title'>";
				echo $gb['title'];
				echo '</h5>';
			}
			if ( ! empty( $gb['blurb'] ) ) {
				echo "<div class='grid-block__blurb'>";
				echo $gb['blurb'];
				echo '</div>';
			}
			echo '</div>';
		}
		echo '</div>';
	}
}

function obj_do_image_grid_blocks( $i_blocks = null, $classes = null ) {
	if ( ! empty( $i_blocks ) && is_array( $i_blocks ) ) {
		echo "<div class='grid-image-blocks__wrap {$classes}'>";
		foreach ( $i_blocks as $gb ) {
			echo "<div class='image-grid-block'>";
			if ( ! empty( $gb['image'] ) ) {
				$image = wp_get_attachment_image( $gb['image']['ID'], 'obj-image-blurb-block' );
				if ( ! empty( $image ) ) {
					echo "<div class='grid-block__image'>";
					echo $image;
					echo '</div>';
				}
			}
			if ( ! empty( $gb['title'] ) ) {
				echo "<h5 class='grid-block__title'>";
				echo $gb['title'];
				echo '</h5>';
			}
			if ( ! empty( $gb['blurb'] ) ) {
				echo "<div class='grid-block__blurb'>";
				echo $gb['blurb'];
				echo '</div>';
			}
			echo '</div>';
		}
		echo '</div>';
	}
}

function obj_do_text_blocks( $blocks = null, $classes = null ) {
	if ( is_array( $blocks ) && ! empty( $blocks ) ) {
		echo "<div class='grid-text-blocks__wrap {$classes}'>";
		foreach ( $blocks as $block ) {
			echo "<div class='grid-text-block lmb0'>";
			echo $block['block'];
			echo '</div>';
		}
		echo '</div>';
	}
}

function obj_do_two_wide_text_blocks( $two_blocks = null, $classes = null ) {
	if ( is_array( $two_blocks ) && ! empty( $two_blocks ) ) {
		echo "<div class='grid-text-two-blocks__wrap {$classes}'>";
		foreach ( $two_blocks as $block ) {
			echo "<div class='grid-text-two-block lmb0 larger-text'>";
			echo $block;
			echo '</div>';
		}
		echo '</div>';
	}
}
