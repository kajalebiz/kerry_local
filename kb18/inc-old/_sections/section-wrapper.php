<?php

function do_section_top( $section_meta = null ) {

	$sec_id             = $section_meta['section_id'];
	$sec_class          = $section_meta['section_class'];
	$additional_classes = $section_meta['section_add_classes'];
	$sec_color_class    = $section_meta['section_color_class'];
	$marg_class         = decide_section_margin_class( $section_meta );
	$pad_class          = decide_section_padding_class( $section_meta );
	$wrap               = $section_meta['section_wrap'];

	echo "<section id='" . $sec_id . "' class='" . $sec_class . ' ' . $marg_class . ' ' . $pad_class . ' ' . $additional_classes . ' ' . $sec_color_class . "'>";
	if ( array_key_exists( 'bg_shapes', $section_meta ) && is_array( $section_meta['bg_shapes'] ) ) {
		obj_output_bg_shapes_array( $section_meta['bg_shapes'] );
	}
	if ( $wrap ) {
		echo "<div class='wrap'>";
	}
	echo "<div class='inner-" . $sec_class . "'>";
}

function do_section_bottom( $section_meta = null ) {
	$wrap = $section_meta['section_wrap'];

	echo '</div>';
	if ( $wrap ) {
		echo '</div>';
	}
	echo '</section>';
}

function decide_section_margin_class( $section_meta = null ) {
	$margin_class = 'section-margin';
	if ( is_array( $section_meta ) && key_exists( 'section_margins', $section_meta ) ) {
		$sec_margins = $section_meta['section_margins'];
		if ( $sec_margins === 'none' ) {
			$margin_class = null;
		} elseif ( $sec_margins === 'bottom' ) {
			$margin_class = 'section-margin-bottom';
		}
	}
	return $margin_class;
}

function decide_section_padding_class( $section_meta = null ) {
	$padding_class = null;
	if ( is_array( $section_meta ) && key_exists( 'section_paddings', $section_meta ) ) {
		$sec_paddings = $section_meta['section_paddings'];
		if ( $sec_paddings === 'both' ) {
			$padding_class = 'section-padding';
		} elseif ( $sec_paddings === 'none' ) {
			$padding_class = null;
		} elseif ( $sec_paddings === 'top' ) {
			$padding_class = 'section-padding-top';
		} elseif ( $sec_paddings === 'bottom' ) {
			$padding_class = 'section-padding-bottom';
		}
	}
	return $padding_class;
}

function obj_output_bg_shapes_array( $shapes_array = null ) {
	if ( is_array( $shapes_array ) ) {
		foreach ( $shapes_array as $shape => $number ) {
			obj_echo_bg_section_shapes( $shape, $number );
		}
	}
}

function obj_echo_bg_section_shapes( $shape = null, $number = 0 ) {
	if ( ! empty( $shape ) && ! empty( $number ) ) {

		if ( $shape === 'oval' ) {
			$shape = 'oval';
		} elseif ( $shape === 'rect' ) {
			$shape = 'rectangle';
		} elseif ( $shape === 'twit' ) {
			$shape = 'twitter';
		} elseif ( $shape === 'amp' ) {
			$shape = 'ampersand';
		} else {
			$shape = null;
		}

		$count = 1;
		if ( ! empty( $shape ) ) {
			while ( $count <= $number ) {
				echo "<div class='bg-shape-wrap {$shape}-{$count} {$shape}'>";
				echo get_svg( $shape );
				echo '</div>';
				$count += 1;
			}
		}
	}
}
