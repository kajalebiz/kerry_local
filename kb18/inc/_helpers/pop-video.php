<?php

function obj_do_pop_video( $vid_deets = null ) {
	if ( ! empty( $vid_deets ) ) {
		$thumb = $vid_deets['video_thumb']['sizes']['obj-angled-slide'];
		$vid   = $vid_deets['video_url'];

		if ( ! empty( $thumb ) && ! empty( $vid ) ) {
			echo "<div class='pop-video-outer'>";
			echo "<a href='{$vid}' class='video-modaal'>";
			echo "<div class='pop-video__play'></div>";
			echo "<img src='{$thumb}' class='video-modaal_thumb'>";
			echo '</a>';
			echo '</div>';
		}
	}
}
