<?php

function obj_do_event_preview_slider( $slider = null ) {
	if ( is_array( $slider ) && ! empty( $slider ) ) {
		echo "<div class='event-preview-slider__outer'>";
		echo "<div class='event-preview-slider'>";
		foreach ( $slider as $slide ) {
			obj_do_event_preview_slide( $slide );
		}
		echo '</div>';
		echo '</div>';
	}
}

function obj_do_event_preview_slide( $slide = null ) {
	if ( is_array( $slide ) && ! empty( $slide ) ) {
		$layout      = $slide['image_layout'];
		$image_1     = $slide['image_1'];
		$image_2     = $slide['image_2'];
		$image_3     = $slide['image_3'];
		$testimonial = $slide['testimonial'];

		if ( $layout === 'three-small' && is_array( $image_1 ) && is_array( $image_2 ) && is_array( $image_3 ) ) {
			$image_1 = $image_1['id'];
			$image_1 = wp_get_attachment_image( $image_1, 'obj-event-prev-fifty-wide', false, array( 'class' => 'first-image' ) );
			$image_2 = $image_2['id'];
			$image_2 = wp_get_attachment_image( $image_2, 'obj-event-prev-fifty-wide', false, array( 'class' => 'second-image' ) );
			$image_3 = $image_3['id'];
			$image_3 = wp_get_attachment_image( $image_3, 'obj-event-prev-fifty-wide', false, array( 'class' => 'third-image' ) );
		} elseif ( $layout === 'one-tall-one-small' && is_array( $image_1 ) && is_array( $image_2 ) ) {
			$image_1 = $image_1['id'];
			$image_1 = wp_get_attachment_image( $image_1, 'obj-event-prev-fifty-wide-tall', false, array( 'class' => 'first-image' ) );
			$image_2 = $image_2['id'];
			$image_2 = wp_get_attachment_image( $image_2, 'obj-event-prev-fifty-wide', false, array( 'class' => 'second-image' ) );
			$image_3 = null;
		} elseif ( $layout === 'one-large-two-small' && is_array( $image_1 ) && is_array( $image_2 ) && is_array( $image_3 ) ) {
			$image_1 = $image_1['id'];
			$image_1 = wp_get_attachment_image( $image_1, 'obj-event-prev-two-thirds-wide', false, array( 'class' => 'first-image' ) );
			$image_2 = $image_2['id'];
			$image_2 = wp_get_attachment_image( $image_2, 'obj-event-prev-third-wide', false, array( 'class' => 'second-image' ) );
			$image_3 = $image_3['id'];
			$image_3 = wp_get_attachment_image( $image_3, 'obj-event-prev-third-wide', false, array( 'class' => 'third-image' ) );
		} else {
			$image_1 = null;
			$image_2 = null;
			$image_3 = null;
		}

		if ( ! empty( $layout ) && ! empty( $image_1 ) && ! empty( $image_2 ) ) {
			echo "<div class='event-preview-slide__outer'>";
			echo "<div class='event-preview-slide {$layout}'>";
			echo $image_1;
			echo $image_2;
			echo $image_3;
			obj_do_testimonial( $testimonial );
			echo '</div>';
			echo '</div>';
		}
	}
}
