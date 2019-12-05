<?php

function obj_do_event_detail_section_when( $details = null ) {
     if ( ! empty( is_singular( 'sc_event' ) ) ) {
	$days = $details['event_when_details_days'];
     }  elseif (! empty( is_singular( 'countdown' ) )) {
         $days = $details['countdown_when_details_days'];
     }

	if ( is_array( $days ) && ! empty( $days ) ) {
		echo "<div class='side-by-side__wrap event-details'>";
		echo "<div class='side-by-side__left'>";
		echo "<h3 class='side-by-side__title'>When</h3>";
		echo '</div>';
		echo "<div class='side-by-side__right'>";
		echo "<div class='event-when__wrap'>";
		foreach ( $days as $d ) {
			echo "<div class='event-when__day'>";
			echo "<div class='event-when__date'>";
			echo $d['day'];
			echo '</div>';
			echo "<div class='event-when__detail'>";
			echo $d['day_detail'];
			echo '</div>';
			echo '</div>';
		}
		echo '</div>';
		echo '</div>';
		echo '</div>';
	}

}

function obj_do_event_detail_section_where( $details = null ) {

        if ( ! empty( is_singular( 'sc_event' ) ) ) {
	$venue_detail_type = $details['event_where_venue_detail_type'];
	$venue_text        = $details['event_where_venue_text'];
	$venue_link        = $details['event_where_venue_link'];
	$aline_1           = $details['event_where_address_line_1'];
	$aline_2           = $details['event_where_address_line_2'];
	$image             = $details['event_where_location_image'];
	$loc_details       = $details['event_where_location_details'];
	$disclaimer        = $details['event_where_location_disclaimer'];
        }  elseif (! empty( is_singular( 'countdown' ) )) {
            $venue_detail_type = $details['countdown_where_venue_detail_type'];
            $venue_text        = $details['countdown_where_venue_text'];
            $venue_link        = $details['countdown_where_venue_link'];
            $aline_1           = $details['countdown_where_address_line_1'];
            $aline_2           = $details['countdown_where_address_line_2'];
            $image             = $details['countdown_where_location_image'];
            $loc_details       = $details['countdown_where_location_details'];
            $disclaimer        = $details['countdown_where_location_disclaimer'];
        }

	

	$display = ! empty( $venue ) || ! empty( $aline_1 ) || ! empty( $aline_2 ) || ! empty( $image ) || ! empty( $details ) || ! empty( $disclaimer );

	if ( $display ) {
		echo "<div class='side-by-side__wrap event-details'>";
		echo "<div class='side-by-side__left'>";
		echo "<h3 class='side-by-side__title'>Where</h3>";
		echo '</div>';
		echo "<div class='side-by-side__right'>";
		echo "<div class='event-where__wrap'>";
		if ( 'link' === $venue_detail_type && ! empty( $venue_link ) ) {
			$venue_link_constructed = '<a class="venue" href="' . $venue_link['url'] . '" target="_blank">' . $venue_link['title'] . '</a>';
			echo "<div class='event-where__venue event-detail-sec'>{$venue_link_constructed}</div>";
		} elseif ( 'text' === $venue_detail_type && ! empty( $venue_text ) ) {
			echo "<div class='event-where__venue event-detail-sec'>{$venue_text}</div>";
		}
		if ( ! empty( $aline_1 ) || ! empty( $aline_2 ) ) {
			echo "<div class='event-where__address event-detail-sec'>";
			if ( ! empty( $aline_1 ) ) {
				echo "<div class='event-where__aline_1'>{$aline_1}</div>";
			}
			if ( ! empty( $aline_2 ) ) {
				echo "<div class='event-where__aline_2'>{$aline_2}</div>";
			}
			echo '</div>';
		}
		if ( ! empty( $image ) ) {
			$image = wp_get_attachment_image( $image['ID'], 'large' );
			echo $image;
		}
		if ( ! empty( $loc_details ) ) {
			echo "<div class='event-where__loc_details lmb0 event-detail-sec'>{$loc_details}</div>";
		}
		if ( ! empty( $aline_1 ) && ! empty( $aline_2 ) ) {
			$address       = $aline_1 . ', ' . $aline_2;
			$map_image_url = obj_get_google_maps_static_url( $address );
			$link          = obj_get_google_maps_link( $address );

			if ( ! empty( $map_image_url ) ) {
				echo "<a target='_blank' href='{$link}' class='event-where__map-link'>";
				echo "<img src='$map_image_url' class='event-where__map'>";
				echo '</a>';
			}
		}
		if ( ! empty( $disclaimer ) ) {
			echo "<div class='event-where__disclaimer event-detail-sec lmb0'>{$disclaimer}</div>";
		}
		echo '</div>';
		echo '</div>';
		echo '</div>';
	}
}

function obj_do_event_detail_section_price( $details = null ) {
	$priceline = $details['price_line_text'];
	$included  = $details['what_it_includes'];
	$cancel    = $details['cancelation_policy'];

	$display = ! empty( $priceline ) || ! empty( $included ) || ! empty( $cancel );

	if ( $display ) {
		echo "<div class='side-by-side__wrap event-details'>";
		echo "<div class='side-by-side__left'>";
		echo "<h3 class='side-by-side__title'>How Much</h3>";
		echo '</div>';
		echo "<div class='side-by-side__right'>";
		echo "<div class='event-how-much__wrap'>";
		if ( ! empty( $priceline ) ) {
			echo "<div class='event-how-much__priceline lmb0 event-detail-sec'>{$priceline}</div>";
		}
		if ( ! empty( $included ) ) {
			echo "<div class='event-detail-sec'>";
			echo "<h5 class='event-how-much__included-title'>What It Includes:</h5>";
			echo "<div class='event-how-much__included lmb0 green-li'>{$included}</div>";
			echo '</div>';
		}
		if ( ! empty( $cancel ) ) {
			echo "<div class='event-detail-sec'>";
			echo "<h5 class='event-how-much__included-title cancellation lmb0'>Cancellation Policy:</h5>";
			echo "<div class='event-how-much__cancel'>{$cancel}</div>";
			echo '</div>';
		}
		echo '</div>';
		echo '</div>';
		echo '</div>';
	}
}
