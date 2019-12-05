<?php

function get_svg( $icon_name = null ) {

	if ( ! empty( $icon_name ) ) {
		$file_path = get_stylesheet_directory() . '/assets/icons/' . $icon_name . '.svg';

		ob_start();
		include $file_path;
		$svg = ob_get_clean();

		return $svg;
	}

	return null;
}
