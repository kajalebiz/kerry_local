<?php

function obj_do_what_online_section( $what_online = null, $section_classes = null, $bg_shapes = null ) {

	$sec_meta = decide_section_meta( 'what-online', $section_classes, $what_online, $bg_shapes );

	if ( ! empty( $what_online ) ) {
		do_section_top( $sec_meta );
		obj_do_what_online_do( $what_online );
		do_section_bottom( $sec_meta );
	}
}

function obj_do_what_online_do( $what_online = null ) {
	

//	if ( array_key_exists( 'video_url', $what_online ) && array_key_exists( 'video_thumb', $what_online ) ) {
		$vid_block = array(
			'video_url'   => $what_online['video_url']['sk_why_kerry_video_url'],
			'video_thumb' => $what_online['video_thumb']['sk_why_kerry_video_thumbnail']['url'],
		);
                $thumb = $vid_block['video_thumb'];
		$vid   = $vid_block['video_url'];
		echo "<div class='pop-video-outer training_video'>";
                echo "<a href='{$vid}' class='video-modaal'>";
                echo "<div class='video__play_wrp'><div class='pop-video__play'></div></div>";
                echo "<div class='top-angled-image'><img src='{$thumb}' class='video-modaal_thumb'></div>";
                echo '</a>';
                echo '</div>';
//	}

}
