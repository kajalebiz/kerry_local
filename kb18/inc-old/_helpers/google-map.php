<?php

function obj_get_google_maps_static_url( $address = null ) {

	if ( ! empty( $address ) ) {
		$api_key     = 'AIzaSyDhPMSZGWX_nFP4p8B60_lTHXDXMrFWY00';
		$city_string = urlencode( $address );

		return "https://maps.googleapis.com/maps/api/staticmap?center={$city_string}&zoom=13&scale=2&size=600x320&maptype=roadmap&key={$api_key}&format=jpg&visual_refresh=true&markers=size:mid%7Ccolor:0xff0000%7Clabel:%7C{$city_string}";
	} else {
		return null;
	}
}

function obj_get_google_maps_link( $address = null ) {
	if ( ! empty( $address ) ) {
		$city_string = urlencode( $address );

		return "https://www.google.com/maps/place/{$city_string}";
	} else {
		return null;
	}
}
