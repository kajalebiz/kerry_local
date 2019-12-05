<?php

function obj_do_logos_row( $logos = null ) {
	if ( ! empty( $logos ) ) {
		echo "<div class='logos-row'>";
		foreach ( $logos as $l ) {
			obj_do_logo( $l );
		}
		echo '</div>';
	}
}

function obj_do_logo( $logo = null ) {
	if ( ! empty( $logo ) ) {
		$img     = $logo['logo'];
		$link    = $logo['link'];
		$img_url = null;

		if ( ! empty( $img ) ) {
			$img_url = $img['sizes']['medium_large'];
		}

		if ( ! empty( $img_url ) ) {
			echo "<div class='logo-outer'>";
			if ( ! empty( $link ) ) {
				echo '<a target="' . $link['target'] . '" href="' . $link['url'] . '">';
			}
			echo "<div class='logo-inner'>";
			echo '<img src="' . $img_url . '" >';
			echo '</div>';
			if ( ! empty( $link ) ) {
				echo '</a>';
			}
			echo '</div>';
		}
	}
}
