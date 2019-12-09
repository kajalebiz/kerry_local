<?php

function obj_events_list_section( $event_list_deets = null, $section_classes = null, $bg_shapes = null ) {

	$sec_meta = decide_section_meta( 'event-list-section', $section_classes, $event_list_deets, $bg_shapes );

	if ( ! empty( $event_list_deets ) ) {
		do_section_top( $sec_meta );
		obj_events_list_inner( $event_list_deets );
		do_section_bottom( $sec_meta );
	}
}

function obj_events_list_inner( $event_list_deets = null ) {
	obj_do_events_list_filter();
	obj_do_events_list();
	echo '<span style="display: none;" class="no-events-shown-message grande-text">No results seem to match your search. Adjust the filters to see what other events may be relevant for you.</span>';
}
