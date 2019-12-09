<?php

function obj_do_upcoming_events_grid( $event_id = null ) {
	if ( ! empty( $event_id ) ) {
		$passed = obj_event_has_passed( $event_id );

		if ( $passed ) {
			$title  = 'Join an upcoming bootcamp!';
			$events = obj_get_kb_events();

		} else {
			$title  = 'Can&rsquo;t make it?';
			$events = obj_get_kb_events_related( $event_id );
		}
		if ( ! empty( $events ) ) {
			echo "<h2 class='section-title page-color'>{$title}</h2>";
			obj_do_events_grid( $events, 'three-wide no-top-marg pad-bottom', true, true, 3 );
		}
	}
}
