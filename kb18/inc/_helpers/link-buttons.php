<?php

function objectiv_link_button( $btn_details = null, $class = null ) {

	if ( ! empty( $btn_details ) ) {
		$title       = $btn_details['title'];
		$url         = $btn_details['url'];
		$target      = $btn_details['target'];
		$video_modal = $btn_details['video_modal'];

		if ( empty( $class ) ) {
			$class = 'primary-button';
		}

		if ( empty( $title ) ) {
			$title = 'Learn More';
		}

		if ( ! empty( $url ) && ! empty( $title ) ) {
			return '<span class="' . $class . '"><a ' . ( $video_modal ? 'class="video-modaal"' : '' ) . 'target="' . $target . '" href="' . $url . '">' . $title . '</a></span>';
		} else {
			return '';
		}
	} else {
		return '';
	}
}

function objectiv_link_link( $link_details = null, $class = null ) {

	if ( ! empty( $link_details ) ) {
		$title  = $link_details['title'];
		$url    = $link_details['url'];
		$target = $link_details['target'];

		if ( empty( $title ) ) {
			$title = 'Learn More';
		}

		if ( ! empty( $url ) && ! empty( $title ) ) {
			return '<a class="' . $class . '" target="' . $target . '" href="' . $url . '">' . $title . '</a>';
		} else {
			return '';
		}
	} else {
		return '';
	}

}

function objectiv_link_with_img( $link_details = null, $img = null, $class = null ) {

	if ( ! empty( $link_details ) ) {
		$title  = $link_details['title'];
		$url    = $link_details['url'];
		$target = $link_details['target'];

		if ( empty( $title ) ) {
			$title = 'Learn More';
		}

		if ( ! empty( $url ) && ! empty( $title ) ) {
                    if(! empty( $img )){
                        $class .= " menu-cta-image";
                        return '<a class="' . $class . '" target="' . $target . '" href="' . $url . '"><img src="'.$img['url'].'" ><p>' . $title . '</p></a>';
                    } else{
			return '<a class="' . $class . '" target="' . $target . '" href="' . $url . '">' . $title . '</a>';
                    }
		} else {
			return '';
		}
	} else {
		return '';
	}

}
