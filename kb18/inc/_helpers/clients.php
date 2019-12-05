<?php

function obj_do_clients_grid( $clients = null ) {
	if ( ! empty( $clients ) && is_array( $clients ) ) {
		echo "<div class='clients-grid'>";
		foreach ( $clients as $c ) {
			obj_do_client_image( $c );
		}
		echo '</div>';
	}
}

function obj_do_client_image( $client = null ) {
	if ( ! empty( $client ) ) {
		$id    = $client;
		$name  = get_the_title( $id );
		$thumb = get_the_post_thumbnail( $id, 'large', array( 'class' => 'client__image' ) );
		$link  = get_field( 'link', $id );

		if ( ! empty( $thumb ) && ! empty( $name ) ) {
			echo "<div class='client-block'>";
			if ( ! empty( $link ) ) {
				echo "<a href='{$link}' class='client-block__link'>";
			}
			echo "<div class='client-block__inner'>";
			echo $thumb;
			echo '</div>';
			if ( ! empty( $link ) ) {
				echo '</a>';
			}
			echo '</div>';
		}
	}
}
