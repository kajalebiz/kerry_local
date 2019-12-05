<?php

function obj_do_jump_nav( $nav_items = null ) {
	if ( ! empty( $nav_items ) && is_array( $nav_items ) ) {
		foreach ( $nav_items as $ni ) {
			$title     = $ni['title'];
			$link      = $ni['id_to_link_to'];
			$button    = $ni['button'];
			$btn_class = null;

			if ( $button ) {
				$btn_class = 'is-button';
			}

			echo "<a href='#{$link}' class='jump-nav__link {$btn_class}'>";
			echo $title;
			echo '</a>';
		}
		echo "<div class='top-page-arrow'>";
		echo get_svg( 'top-page' );
		echo '</div>';
	}
}
