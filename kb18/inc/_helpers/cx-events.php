<?php
/**
 * CX Events Helper
 *
 * Helpers functions to handle events related data
 *
 * @package KerryBodine
 */

// Controls how many events to show per page
define('KBCO_EVENTS_PER_PAGE', 24);

// When true, the form will be saved to DB after dynamic population
define('KBCO_SAVE_FORM_ON_PRE_RENDER', true);

// Our target form id, this could change base on the server
define('KBCO_CX_GFORM_ID', 19);

/**
 * Remove past events from the current list.
 *
 * @access private
 * @param array $events - The event list.
 * @return array - The event list with future events only
 */
function _evt_helper_remove_past_events( $events = null ) {
    $timestamp = current_time( 'timestamp' );
	$today     = strtotime( date('Y-m-d', $timestamp) );

	foreach ( $events as $starttime => $post_id ) {
        foreach ($post_id as $index => $event_id ) {
            $end_date        = get_post_meta($event_id, 'sc_event_end_date_time', true);
            $event_timestamp = empty($end_date) ? $starttime : $end_date;
            $event_date      = strtotime( date('Y-m-d', $event_timestamp) );

            if ( $event_date < $today ) {
                unset( $events[ $starttime ][ $index ] );
            }
        }
        if ( 0 === count($events[ $starttime ]) ) {
            unset( $events[ $starttime ] );
        }
	}
	return $events;
}

/**
 * Regenerate the events array using increment index values.
 *
 * @access private
 * @param array $events - The array of events.
 * @return array - The updated events array.
 */
function _evt_helper_flat_events_array( $events = array(), $load_details = true ) {
	if ( ! empty( $events ) ) {
		$single_level_events = array();

		foreach ( $events as $event_array ) {
			foreach ( $event_array as $event_id ) {
                if ( $load_details ) {
                    $event = evt_helper_get_event_info($event_id);
                    array_push( $single_level_events, $event );
                } else {
                    array_push( $single_level_events, $event_id );
                }
			}
		}

		return $single_level_events;
	}
}

/**
 * Get the event start and end date interval.
 * Possible formats are:
 * - May 8-9, 2019
 * - May 23 - Jun 13, 2019
 * If the $is_sponsored_area flag is true, the month will be the full name instead of 3 letters.
 *
 * @access private
 * @param int     $event_id - The event post id.
 * @param boolean $is_sponsored_area - Flag to see if we are in the sponsored area.
 * @param int     $evt_start - Timestamp of a specific start date.
 * @param int     $evt_end - Timestamp of a specific end date.
 * @return string - The formatted event date interval.
 */
function _evt_helper_get_event_dates( $event_id, $is_sponsored_area = false, $evt_start = '', $evt_end = '' ) {
	$start_date = empty($evt_start) ? get_post_meta( $event_id, 'sc_event_date_time', true ) : $evt_start;
    $end_date   = empty($evt_end) ? get_post_meta( $event_id, 'sc_event_end_date_time', true ) : $evt_end;

	if ( empty( $start_date ) || empty( $end_date ) ) {
		return '';
	}

	$format_start_date = date_i18n( sc_get_date_format(), $start_date );
    $format_end_date   = date_i18n( sc_get_date_format(), $end_date );
    $month_format      = $is_sponsored_area ? 'F' : 'M.';

	if ( $format_end_date !== $format_start_date ) {
		$start_year  = date_i18n( 'Y', $end_date );
		$start_month = date_i18n( $month_format, $start_date );
		$start_day   = date_i18n( 'j', $start_date );
		$end_year    = date_i18n( 'Y', $end_date );
		$end_month   = date_i18n( $month_format, $end_date );
		$end_day     = date_i18n( 'j', $end_date );

		// assumes no events from one month to same month of next year
		if ( $start_month !== $end_month ) {
			if ( $start_year !== $end_year ) {
				return $start_month . ' ' . $start_day . ', ' . $start_year . ' - ' . $end_month . ' ' . $end_day . ', ' . $end_year;
			} else {
				return $start_month . ' ' . $start_day . ' - ' . $end_month . ' ' . $end_day . ', ' . $end_year;
			}
		} else {
			return $start_month . ' ' . $start_day . '-' . $end_day . ', ' . $end_year;
		}
	} else {
		return $format_start_date;
	}
}

/**
 * Get the CSS classes for this event row
 *
 * @access private
 * @param object $event - The current event item.
 * @return string - The css classes.
 */
function _evt_helper_get_css_classes( $event ) {
    $css_classes = array(
        'cx-event',
        'event-list-item',
        date_i18n( 'M-Y', get_post_meta( $event->ID, 'sc_event_date_time', true ) ),
        get_field( 'event_type', $event->ID )['value'],
    );
    if ($event->is_featured ) {
        array_push($css_classes, 'cx-event--is-featured');
        array_push($css_classes, 'cx-event-modal');
    }
    if ($event->has_visual_boost ) {
        array_push($css_classes, 'cx-event--has-visual-bost');
        array_push($css_classes, 'cx-event-modal');
    }
    return implode(' ', $css_classes);
}

/**
 * Load the associated sponsored data for that featured event.
 *
 * @access private
 * @param object $event - Our current event item.
 */
function _evt_helper_load_featured_info( &$event ) {

    // Initialize with empty values
    $event->sponsor_image_url   = '';
    $event->sponsor_area        = '';
    $event->sponsor_link        = '';
    $event->sponsor_description = '';
    $event->sponsor_dates       = '';

    if (get_field('cx_paid_event_image', $event->ID) ) {
        $sponsor_image_array      = wp_get_attachment_image_src( get_field('cx_paid_event_image', $event->ID), 'full' );
        $event->sponsor_image_url = $sponsor_image_array[0];
    }

    if (get_field('cx_paid_event_cta_url', $event->ID) ) {
        $event->sponsor_link = get_field('cx_paid_event_cta_url', $event->ID);
    }

    if (get_field('cx_paid_event_description', $event->ID) ) {
        $event->sponsor_description = get_field('cx_paid_event_description', $event->ID);
    }

    if (get_field('cx_event_sponsor_area', $event->ID) ) {
        $selected_sponsor_area = get_field('cx_event_sponsor_area', $event->ID);
        $event->sponsor_area   = $selected_sponsor_area['value'];
    }

    $event->sponsor_dates = _evt_helper_get_event_dates($event->ID, true);
}

/**
 * Get the data related to the event speaker
 *
 * @access private
 * @param int    $event_id - The current event.
 * @param string $speaker - The speaker index (speaker_1 or speaker_2).
 * @return object - The object with the speaker information
 */
function _evt_helper_get_speaker_info( $event_id, $speaker ) {

    // initialize our object
    $info        = new StdClass();
    $info->image = '';
    $info->name  = '';
    $info->bio   = '';

    if (get_field("cx_event_featured_{$speaker}_image", $event_id) ) {
        $image_array = wp_get_attachment_image_src( get_field("cx_event_featured_{$speaker}_image", $event_id), 'full' );
        $info->image = $image_array[0];
    }

    if (get_field("cx_event_featured_{$speaker}_fullname", $event_id) ) {
        $info->name = get_field("cx_event_featured_{$speaker}_fullname", $event_id);
    }

    if (get_field("cx_event_featured_{$speaker}_bio", $event_id) ) {
        $info->bio = get_field("cx_event_featured_{$speaker}_bio", $event_id);
    }

    return $info;
}

/**
 * Check if today's date is within the bi-weekly range
 *
 * @access private
 * @param array  $periods - An array of weeks.
 * @param string $start_key - The index of the array that holds the starting week key.
 * @param string $end_key - The index of the array that holds the ending week key.
 * @return bool
 */
function _evt_helper_is_today_in_range( $periods, $start_key, $end_key ) {
    $today    = strtotime(date('Y-m-d'));
    $is_valid = false;
    foreach ($periods as $period ) {
        $start = strtotime($period[ $start_key ]);
        $end   = strtotime($period[ $end_key ]);
        if ($today >= $start && $today <= $end ) {
            $is_valid = true;
            break;
        }
    }
    return $is_valid;
}

/**
 * Validate if the event has an active visual bost setup and if it's still active.
 *
 * @access private
 * @param int $event_id - The event id.
 * @return bool
 */
function _evt_helper_validate_visual_boost( $event_id ) {
    $is_valid = false;
    if (get_field('cx_event_visual_boost_enabled', $event_id) ) {
        if (have_rows('cx_event_visual_boost_periods', $event_id) ) {
            $periods  = get_field('cx_event_visual_boost_periods', $event_id);
            $is_valid = _evt_helper_is_today_in_range($periods, 'cx_event_visual_boost_period_start', 'cx_event_visual_boost_period_end');
        }
    }
    return $is_valid;
}

/**
 * Validate if the current event should display in one of the sponsored events areas.
 *
 * @access private
 * @param int $event_id - The event id.
 * @return bool
 */
function _evt_helper_validate_featured_sponsor( $event_id ) {
    $is_valid = false;
    if (get_field('cx_event_featured_event', $event_id) ) {
        if (have_rows('cx_event_sponsor_selected_periods', $event_id) ) {
            $periods  = get_field('cx_event_sponsor_selected_periods', $event_id);
            $is_valid = _evt_helper_is_today_in_range($periods, 'cx_event_sponsor_start_date', 'cx_event_sponsor_end_date');
        }
    }
    return $is_valid;
}

/**
 * Checks if the sponsor event has any cta setup.
 *
 * @access private
 * @param int $event_id - The event id.
 * @return object - An object containing the URL and Label of the CTA.
 */
function _evt_helper_get_default_sponsor_cta( $event_id ) {
    $cta        = new StdClass();
    $cta->label = '';
    $cta->url   = '';

    // default register cta fields
    $reg_text = get_field( 'cx_paid_event_cta_label', $event_id );
    $reg_link = get_field( 'cx_paid_event_cta_url', $event_id );

    if ( ! empty( $reg_text ) && ! empty($reg_link) ) {
        $cta->label = $reg_text;
        $cta->url   = $reg_link;
    }
    return $cta;
}

/**
 * Generate our array of dates to be used in the dropdown filter.
 *
 * @access public
 * @param array $events - The current event list.
 * @return array - Array of dates.
 */
function evt_helper_get_year_months( $events ) {

	$months_and_years = array();

	foreach ( $events as $event ) {
		$date  = get_post_meta( $event->ID, 'sc_event_date_time', true );
		$value = date_i18n( 'M-Y', $date );
		$label = date_i18n( 'F Y', $date );

		if ( ! array_key_exists( $value, $months_and_years ) ) {
			$months_and_years[ $value ] = $label;
		}
	}

	return $months_and_years;
}

/**
 * Generate our array of event types.
 *
 * @access public
 * @param array $events - The current event list.
 * @return array - Array of event types.
 */
function evt_helper_get_event_types( $events ) {

	$types = array();

	foreach ( $events as $event ) {
		$type  = get_field( 'event_type', $event->ID );
		$value = $type['value'];
		$label = $type['label'];

		if ( ! array_key_exists( $value, $types ) ) {
			$types[ $value ] = $label;
		}
	}

	return $types;
}

/**
 * Get the list of events from the database.
 *
 * @access public
 * @return array - Array of id's of future events.
 */
function evt_helper_get_sponsored_events() {
    $events        = sc_get_all_events();
    $future_events = _evt_helper_remove_past_events( $events );
    $event_ids     = _evt_helper_flat_events_array($future_events, false);
    $featured      = array(
        'first_box'     => null,
        'second_box'    => null,
        'third_box'     => null,
        'bottom_banner' => null,
    );
    foreach ($event_ids as $event_id ) {
        if ( _evt_helper_validate_featured_sponsor($event_id) ) {
            // load our event details
            $feat_event = evt_helper_get_event_info($event_id);

            // store in the specific area
            $featured[ $feat_event->sponsor_area ] = $feat_event;
        }
    }
    return $featured;
}

/**
 * Get the list of events from the database.
 *
 * @access public
 * @return array - Array of id's of future events.
 */
function evt_helper_get_all_events_query() {
    $timestamp = current_time( 'timestamp' );
	$today     = strtotime( date('Y-m-d', $timestamp) );
    $paged     = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
    $args      = array(
		'posts_per_page' => KBCO_EVENTS_PER_PAGE,
		'post_type'      => 'sc_event',
		'post_status'    => 'publish',
		'orderby'        => 'meta_value_num',
		'fields'         => 'ids',
        'order'          => 'asc',
        'meta_key'       => 'sc_event_date_time', // phpcs:ignore
        'paged'          => $paged,
    );

    $meta_query = array(
        'relation' => 'OR',
        array(
            'key'     => 'sc_event_date_time',
            'value'   => $today,
            'compare' => '>=',
        ),
        array(
            'key'     => 'sc_event_end_date_time',
            'value'   => $today,
            'compare' => '>=',
        ),
    );

    $args['meta_query'] = $meta_query; // phpcs:ignore

    $search_term = evt_helper_get_search_term();

    if ('' !== $search_term ) {
        $args['s'] = $search_term;
    }

    $the_query = new WP_Query( $args );
    return $the_query;
}

/**
 * Get the pagination for the current event listing query
 *
 * @access public
 * @param WP_Query $the_query - The executed WordPress query result.
 * @return string - HTML content for the pagination
 */
function evt_helper_get_pagination( $the_query ) {
    $big        = 999999999; // need an unlikely integer
    $args       = array(
        'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
        'format'    => '?paged=%#%',
        'current'   => max( 1, get_query_var('paged') ),
        'total'     => $the_query->max_num_pages,
        'prev_text' => __('<'),
		'next_text' => __('>'),
    );
    $pagination = paginate_links( $args );
    return str_replace("\n", '', $pagination);
}

/**
 * Load events data from an array of events ids
 *
 * @access public
 * @param array $event_ids - Array of events ids.
 * @return array - Array of events data.
 */
function evt_helper_load_all_events( $event_ids = array() ) {
    $events = array();
	if ( ! empty( $event_ids ) ) {
		foreach ( $event_ids as $event_id ) {
            $event = evt_helper_get_event_info($event_id);
            array_push( $events, $event );
		}
    }
    return $events;
}

/**
 * Get the event related information.
 *
 * @access public
 * @param int $event_id - The event post id.
 * @return object - The object with all the event related info.
 */
function evt_helper_get_event_info( $event_id = null ) {
    $event = null;
    if ( ! is_null($event_id) ) {
        // initialize our event object
        $event = new StdClass();

        // load all the event related data
        $event->ID        = $event_id;
        $event->title     = get_the_title( $event_id );
        $event->dates     = _evt_helper_get_event_dates( $event_id );
        $event->city      = get_field( 'city', $event_id );
        $event->hosted_by = get_field( 'hosted_by', $event_id );

        $event->is_featured      = _evt_helper_validate_featured_sponsor($event_id);
        $event->has_visual_boost = _evt_helper_validate_visual_boost($event_id);
        $event->css_classes      = _evt_helper_get_css_classes($event);
        if ($event->is_featured || $event->has_visual_boost ) {
            _evt_helper_load_featured_info($event);
        }
    }
    return $event;
}

/**
 * Some events may have speakers associated
 *
 * @access public
 * @param int $event_id - The event post id.
 * @return object An object with the speakers
 */
function evt_helper_get_speakers( $event_id ) {

    // Initialize our result object
    $speakers          = new StdClass();
    $speakers->title   = '';
    $speakers->persons = array();

    // Get our speakers fields to process
    $speaker1 = _evt_helper_get_speaker_info($event_id, 'speaker_1');
    $speaker2 = _evt_helper_get_speaker_info($event_id, 'speaker_2');

    if ( ! empty($speaker1->name) && ! empty($speaker1->bio) ) {
        array_push($speakers->persons, $speaker1);
    }

    if ( ! empty($speaker2->name) && ! empty($speaker2->bio) ) {
        array_push($speakers->persons, $speaker2);
    }

    if (count($speakers->persons) > 0 ) {
        $speakers->title = 'Featured Speakers';
    }

    return $speakers;

}

/**
 * Get the label and url for the register button
 *
 * @access public
 * @param int $event_id - The event post id.
 * @return object - The cta label and url
 */
function evt_helper_get_register_cta( $event_id ) {
    $cta = _evt_helper_get_default_sponsor_cta( $event_id );

    if ( '' !== $cta->label && '' !== $cta->url ) {
        return $cta;
    }

    // Regular register cta fields
    $reg_text = get_field( 'registration_text', $event_id );
    $reg_link = get_field( 'registration_link', $event_id );

    // Universe link fields
    $is_universe_link = get_field( 'register_section_is_this_a_universe_event_link', $event_id );
    $universe_link    = get_field( 'register_section_universe_event_link', $event_id );

    // setup our values
    if ( $is_universe_link && ! empty( $universe_link ) ) {
        $cta->label = 'Get Tickets';
        $cta->url   = $universe_link;
    }elseif (is_array( $reg_link ) ) {
        $cta->label = $reg_link['title'];
		$cta->url   = $reg_link['url'];
    }
    return $cta;
}

/**
 * Retrieve the form code to submit an event from the front-end.
 *
 * @access public
 * @return string - Empty string if form is not found.
 */
function evt_helper_get_submission_form() {
    $form_id = 19;
    if ( get_field( 'cx_event_submission_form' ) ) {
        $form    = get_field( 'cx_event_submission_form' );
        $form_id = $form['id'];
    }
    $form_html = gravity_form( $form_id, false, false, false, null, true, 1, false );
    return $form_html;
}

/**
 * Retrieve the intro text for the the form submission page
 *
 * @access public
 * @return string
 */
function evt_helper_get_intro_text() {
    $text = '';
    if ( get_field( 'cx_event_submission_intro_text' ) ) {
        $text = get_field( 'cx_event_submission_intro_text' );
    }
    return $text;
}

/**
 * Function to retrieve the search value
 *
 * @access public
 * @return string - The search term
 */
function evt_helper_get_search_term() {
    $term = '';
    if (isset($_GET['evtq']) ) {
        $term = sanitize_text_field( wp_unslash( $_GET['evtq'] ) );
    }
    return $term;
}

/**
 * Retrieve the id of the field list that contains all the dates
 * We validate against the custom css field attribute
 *
 * @access public
 * @param mixed $fields - The current form field that we are evaluating.
 * @return int - The field id
 */
function evt_helper_get_visual_bost_dates_field_id( $fields ) {
    $id = 0;
    if (is_array($fields) ) {
        foreach ($fields as $field ) {
            if (stripos($field->cssClass, 'input-cx-visual-bost-dates') !== false ) { // phpcs:ignore
                $id = $field->id;
                break;
            }
        }
    } elseif ( is_object($fields) ) {
        if (stripos($fields->cssClass, 'input-cx-visual-bost-dates') !== false ) { // phpcs:ignore
            $id = $fields->id;
        }
    }
    return $id;
}

/**
 * Get the last event date added by the user from the form submission in step 2
 *
 * @param array $fields - The entire form fields.
 * @return string - Empty string or YYYY-MM-DD formatted date.
 */
function evt_helper_get_event_last_date( $fields ) {
    $last_date = '';
    foreach ($fields as $field ) {
        if (stripos($field->cssClass, 'input-cx-event-dates') !== false ) { // phpcs:ignore
            $dates = rgpost( 'input_' . $field->id );
            if (is_array($dates) ) {
                $last_date = end($dates);
                if (false !== $last_date ) {
                    $last_date = evt_helper_convert_event_date_to_db_format($last_date);
                    break;
                }
            }
        }
    }
    return $last_date;
}

/**
 * Format the event date (mm/dd/yyyy) to a
 * database format for later usage YYYY-MM-DD
 *
 * @access public
 * @param string $event_date - The event date in m/d/yyyy.
 * @return string The formatted date as YYYY-MM-DD
 */
function evt_helper_convert_event_date_to_db_format( $event_date ) {

    // split the event date in parts
    list($month, $day, $year) = explode('/', $event_date);

    // make sure month is 2 digits
    $month = str_pad($month, 2, '0', STR_PAD_LEFT);

    // make sure day is 2 digits
    $day = str_pad($day, 2, '0', STR_PAD_LEFT);

    // format our date
    $formatted_date = "{$year}-{$month}-{$day}";
    return $formatted_date;
}

/**
 * Get the biweekly date ranges array
 *
 * @access public
 * @param string $last_date - The user selected event last date.
 * @return array - Array of biweekly ranges
 */
function evt_helper_get_weeks( $last_date = '' ) {
    $dt           = strtotime(date('2019-01-01'));
    $current_week = date('W');
    $weeks        = array();
    $save         = false;
    $max_tries    = 200;
    for ($i = 0; $i < $max_tries; $i++ ) {

        // get our initial start date of that week
        $range['date_start'] = date('Y-m-d', strtotime('first saturday', $dt));

        // store this value for future usage
        $dt_week_start = strtotime($range['date_start']);

        // calculate rest of the values
        $range['label_start'] = date('l, M. d, Y', $dt_week_start);
        $range['week_start']  = date('W', $dt_week_start);
        $range['date_end']    = date('Y-m-d', strtotime('second friday', $dt_week_start));

        // store this value for future usage
        $dt_week_end        = strtotime($range['date_end']);
        $range['label_end'] = date('l, M. d, Y', $dt_week_end);
        $range['week_end']  = date('W', $dt_week_end);

        $range['choice_text']    = "{$range['label_start']} - {$range['label_end']}";
        $range['choice_value']   = "{$range['date_start']}_{$range['date_end']}";
        $range['choice_enabled'] = evt_helper_is_range_available($range);

        // initialize our start time
        $dt = $dt_week_end;
        if ($range['week_start'] >= $current_week || $range['week_end'] >= $current_week ) {
            $save = true;
        }
        if ( $save ) {
            array_push($weeks, $range);
            if (evt_helper_is_last_range($last_date, $range) ) {
                break;
            }
        }
    }
    return $weeks;
}

/**
 * Parse the range string format START_END in an human readeable text
 *
 * @access private
 * @param string $range - YYYY-MM-DD_YYYY-MM-DD.
 * @return string - Human readeable text
 */
function _evt_helper_get_range_label( $range ) {
    list($date_start, $date_end) = explode('_', $range);
    $start_label                 = date('l, M. d, Y', strtotime($date_start));
    $end_label                   = date('l, M. d, Y', strtotime($date_end));
    return "{$start_label} - {$end_label}";
}

/**
 * Validate if the range has not been selected for other featured events
 *
 * @access public
 * @param array $range - An array containing the start and end dates of the range.
 * @return bool
 */
function evt_helper_is_range_available( $range ) {
    return true;
}

/**
 * Check if the current range is still under the user events dates.
 *
 * @access public
 * @param string $last_date - The user selected last event date.
 * @param array  $range - The current biweekly range.
 * @return bool
 */
function evt_helper_is_last_range( $last_date, $range ) {
    $last_range = false;
    if ( '' !== $last_date ) {
        $last_date_ts  = strtotime($last_date);
        $week_start_ts = strtotime($range['date_start']);
        $week_end_ts   = strtotime($range['date_end']);

        if ($last_date_ts >= $week_start_ts && $last_date_ts <= $week_end_ts ) {
            $last_range = true;
        }
    }
    return $last_range;
}

/**
 * Populate checkboxes with the biweekly period ranges.
 *
 * @param int   $field_id - The checkboxes list field id.
 * @param array $weeks - Array of period ranges.
 * @return array - Array with the indexes and values that fill the field
 * @see https://docs.gravityforms.com/gform_pre_render/#2-populate-choices-checkboxes
 */
function evt_helper_generate_list_options( $field_id, $weeks ) {
    $choices = array();
    $inputs  = array();
    foreach ($weeks as $index => $week ) {
        $option = array(
            'text'  => $week['choice_text'],
            'value' => $week['choice_value'],
        );
        array_push($choices, $option);

        $item = array(
            'label' => $week['choice_text'],
            'id'    => $field_id . '.' . ( $index + 1 ),
        );
        array_push($inputs, $item);
    }
    return array(
        'choices' => $choices,
        'inputs'  => $inputs,
    );
}

/**
 * Disable the checkbox if that range is already booked.
 * This will be used for the sponsored event area.
 *
 * @param string $field_content - The entire html content with field and label.
 * @return string - The updated markup with the disabled attribute added.
 */
function evt_helper_disable_booked_dates( $field_content ) {
    $weeks       = evt_helper_get_weeks();
    $dom_content = new SimpleXMLElement("<?xml version='1.0' standalone='yes'?><field>{$field_content}</field>");
    if ( isset($dom_content->div->ul->li) ) {
        $counter = 0;
        foreach ($dom_content->div->ul->li as $item ) {
			if ( ! $weeks[ $counter ]['choice_enabled'] ) {
				$item->input->addAttribute('checked', 'checked');
				$item->input->addAttribute('disabled', 'disabled');
			}
			$item->input->addAttribute('data-index', $counter);
			$counter++;
        }
    }
    $label = $dom_content->label->asXML();
    $div   = $dom_content->div->asXML();
    return "{$label}{$div}";
}

/**
 * Get the total of selected periods
 * It checks for actual checked checkboxes,
 * if the value is empty skip that option
 *
 * @param array $fields - The entire form fields.
 * @param int   $target_field_id - Our checkboxes field id.
 * @return int Total of selected periods.
 * @see https://docs.gravityforms.com/gform_pre_render/#3-populate-field-with-values-from-earlier-page
 */
function evt_helper_count_selected_periods( $fields, $target_field_id ) {
    $selected_periods = 0;
    foreach ($fields as &$field ) {
        if ($target_field_id === $field['id'] ) {
            if ( is_array( $field->inputs ) ) {
                foreach ( $field->inputs as $input ) {
                    // get name of individual field, replace period with underscore when pulling from post
                    $input_name = 'input_' . str_replace( '.', '_', $input['id'] );
                    $value      = rgpost( $input_name );

                    if ('' !== $value ) {
                        $selected_periods++;
                    }
                }
            }
        }
    }
    if (0 === $selected_periods ) {
        $selected_periods = 1;
    }
    return $selected_periods;
}

function evt_helper_preview_boost_selected_periods( $fields, $target_field_id ) {
    $selected_periods = array();
    foreach ($fields as &$field ) {
        if ($target_field_id === $field['id'] ) {
            if ( is_array( $field->inputs ) ) {
                foreach ( $field->inputs as $input ) {
                    // get name of individual field, replace period with underscore when pulling from post
                    $input_name = 'input_' . str_replace( '.', '_', $input['id'] );
                    $value      = rgpost( $input_name );

                    if ('' !== $value ) {
                        array_push($selected_periods, $value);
                    }
                }
            }
        }
    }
    return $selected_periods;
}


function _evt_helper_attach_uploaded_image( $image_url ) {
    $dir_data   = wp_upload_dir();
    $local_file = str_replace($dir_data['baseurl'], $dir_data['basedir'], $image_url);
    $filename   = basename( $local_file );

    // Check the type of file. We'll use this as the 'post_mime_type'.
    $filetype = wp_check_filetype( $filename, null );

    // Prepare an array of post data for the attachment.
    $attachment = array(
        'guid'           => $dir_data['url'] . '/' . $filename,
        'post_mime_type' => $filetype['type'],
        'post_title'     => preg_replace( '/\.[^.]+$/', '', $filename ),
        'post_content'   => '',
        'post_status'    => 'inherit',
    );

    // Insert the attachment.
    $attach_id = wp_insert_attachment( $attachment, $local_file );

    // WordPress API for image uploads.
    include_once ABSPATH . 'wp-admin/includes/image.php';

    // Generate the metadata for the attachment, and update the database record.
    $attach_data = wp_generate_attachment_metadata( $attach_id, $local_file );
    wp_update_attachment_metadata( $attach_id, $attach_data );

    return $attach_id;
}

/**
 * Enable the credit card field in gravity form
 *
 * @param bool $is_enabled - Current status of the field.
 * @return bool
 * @see https://docs.gravityforms.com/gform_enable_credit_card_field/
 */
function evt_helper_enable_creditcard( $is_enabled ) {
    return true;
}
add_filter( 'gform_enable_credit_card_field', 'evt_helper_enable_creditcard', 11 );

/**
 * Execute some fields setup before displaying the form in the front-end.
 *
 * @param Object $form - The current gravity form to be filtered.
 * @return Object The updated form.
 * @see https://docs.gravityforms.com/gform_pre_render/
 */
function evt_helper_handle_pre_render_filter( $form ) {
    if (KBCO_SAVE_FORM_ON_PRE_RENDER ) {
        $the_form = RGFormsModel::get_form_meta($form['id']);
    } else {
        $the_form = &$form;
    }

    // get our current page / step
    $current_page = GFFormDisplay::get_current_page( $form['id'] );

    // field id may change base on the server
    $target_field_id = evt_helper_get_visual_bost_dates_field_id( $the_form['fields'] );

    // Step 3: We are on the visual boost page
    if (3 === $current_page ) {

        // get our last event date from previous page
        $last_date = evt_helper_get_event_last_date($the_form['fields']);

        // generate our biweekly period up to the last event date
        $weeks = evt_helper_get_weeks($last_date);

        // generate our field options
        $options = evt_helper_generate_list_options($target_field_id, $weeks);

        // fill the field with the generated options
        foreach ($the_form['fields'] as &$field ) {
            if ($target_field_id === $field['id'] ) {
				$field['choices'] = $options['choices'];
				$field['inputs']  = $options['inputs'];
            }
        }
    }

    // Step 4: We are on the review entry page (last step)
    elseif (4 === $current_page ) {

        // load our html preview template code
        $preview_template = file_get_contents(get_stylesheet_directory() . '/internal-templates/preview-event-submission.html');

        // get the total of selected periods
        $selected_periods     = evt_helper_count_selected_periods($the_form['fields'], $target_field_id);
        $preview_periods      = evt_helper_preview_boost_selected_periods($the_form['fields'], $target_field_id);
        $formatted_event_date = '';

        // update our template with the range values
        if (count($preview_periods) > 0 ) {
            $list_items = '';
            foreach ($preview_periods as $range ) {
                $list_items .= '<li>' . _evt_helper_get_range_label($range) . '</li>';
            }
            $preview_template = str_replace('<li>__SPONSOR_DATE__</li>', $list_items, $preview_template);
        }

        // iterate over the rest of the fields to generate proper preview of the event data
        foreach ($the_form['fields'] as &$field ) {

            // event plan to show proper dates labels
            if (stripos($field->cssClass, 'cx-input-event-plan') !== false ) { // phpcs:ignore
                $field_data = rgpost('input_' . $field->id );
                $date_type_label = '';
                if ( 'Boosted' === $field_data ) {
                    $date_type_label = 'Boosted Dates';
                }
                elseif ( 'Featured' === $field_data ) {
                    $date_type_label = 'Featured Dates';
                }
                $preview_template = str_replace('__DATES_TYPE_RANGE_LABEL__', $date_type_label, $preview_template);
            }

            // banner image
            if (stripos($field->cssClass, 'input-cx-event-image') !== false ) { // phpcs:ignore
                $input_name    = 'input_' . $field->id;
                $temp_filename = RGFormsModel::get_temp_filename( $form['id'], $input_name );
                $uploaded_name = $temp_filename['uploaded_filename'];
                $temp_location = RGFormsModel::get_upload_url( $form['id'] ) . '/tmp/' . $temp_filename['temp_filename'];
                $css_bg_image  = 'style="background-image:url(' . $temp_location . ');"';

                // set uploaded image as a background image in our container
                $preview_template = str_replace('data-img="__BANNER_IMG__"', $css_bg_image, $preview_template);
            }

            // speaker image
            if (stripos($field->cssClass, 'input-cx-event-speaker-image') !== false ) { // phpcs:ignore

                // get which speaker
                $speaker    = ( stripos($field->cssClass, 'data-speaker-1') !== false ) ? 'SPEAKER1' : 'SPEAKER2'; // phpcs:ignore

                // get our input name
                $input_name = 'input_' . $field->id;

                // get our temp uploaded file
                $temp_filename = RGFormsModel::get_temp_filename( $form['id'], $input_name );
                if ( ! empty($temp_filename) ) {
                    $uploaded_name = $temp_filename['uploaded_filename'];
                    $temp_location = RGFormsModel::get_upload_url( $form['id'] ) . '/tmp/' . $temp_filename['temp_filename'];
                    $css_bg_image  = 'style="background-image:url(' . $temp_location . ');"';
                    $find_data_txt = 'data-img="__' . $speaker . '_IMG__"';

                    // set uploaded image as a background image in our container
                    $preview_template = str_replace($find_data_txt, $css_bg_image, $preview_template);
                }
            }
        }

        // update the rest of the elements in the preview page
        foreach ($the_form['fields'] as &$field ) {
            if (stripos($field->cssClass, 'cx-content-preview') !== false ) { // phpcs:ignore
                $field->content = $preview_template;
            }

            if (false !== stripos($field->cssClass, 'input-cx-range-qty') ) { // phpcs:ignore
				$_POST[ 'input_' . $field->id ] = $selected_periods;
            }
        }
    }
    // Save form to database, if constant is set to true
    if (KBCO_SAVE_FORM_ON_PRE_RENDER ) {
        RGFormsModel::update_form_meta($form['id'], $the_form);
    }
    return $the_form;
}
add_filter('gform_pre_render_' . KBCO_CX_GFORM_ID, 'evt_helper_handle_pre_render_filter');

/**
 * Change the field output by adding custom attributes or options
 *
 * @param string $field_content - The html markup of the field.
 * @param Object $field - the current gravity form field ojbect.
 * @return string The updated html markup of the field.
 * @see https://docs.gravityforms.com/gform_field_content/
 */
function evt_helper_update_field_content( $field_content, $field ) {

    // if in admin mode just return the field content
    if ( is_admin() ) {
        return $field_content;
    }

    // phpcs:disable
    // @TODO: Revise this piece of code in the future to see if is still needed
    //
    // disable the options that are already booked
    // $target_field_id = evt_helper_get_visual_bost_dates_field_id($field);
    // if ( $target_field_id === $field->id ) {
    //     $content = evt_helper_disable_booked_dates($field_content);
    //     return $content;
    // }
    // phpcs:enable

    // make our quantity field as read only
    if (false !== stripos($field->cssClass, 'input-cx-range-qty') ) { // phpcs:ignore
        return str_replace( 'type=', "readonly='readonly' type=", $field_content );
    }

    return $field_content;
}
add_filter( 'gform_field_content_' . KBCO_CX_GFORM_ID, 'evt_helper_update_field_content', 10, 2 );

/**
 * Updated the custom fields of the new CX Event Post created
 * from the form submission
 *
 * @param Object $post_id - The id of the new cx event created.
 * @param Object $entry - Current gravity entry object.
 * @param Object $form  - Current gravity form object.
 * @see https://docs.gravityforms.com/gform_after_create_post/
 */
function evt_helper_set_post_content( $post_id, $entry, $form ) {

    // use this flag to map paid events extra fields
    $is_paid_event = false;

    // help us to know which ACF keys to update
    $event_plan = 'Free'; // Free | Boosted | Featured

    // get the created cx event submission post
    $post = get_post( $post_id );

    if ('cx_event' === $post->post_type ) {
        foreach ( $form['fields'] as $field ) {
            $inputs = $field->get_entry_inputs();

            // Event location - string
            if (stripos($field->cssClass, 'input-cx-event-location') !== false ) { // phpcs:ignore
                $field_key = 'field_5cf7cdb6f41d5';
                $value     = rgar( $entry, (string) $field->id );
                update_field( $field_key, $value, $post_id );
            }

            // Event dates - array
            else if (stripos($field->cssClass, 'input-cx-event-dates') !== false ) { // phpcs:ignore
                $repeater_key  = 'field_5cf7ddff12301';
                $sub_field_key = 'field_5cf7de1e12302';
                $input_value   = rgar( $entry, (string) $field->id );
                $field_value   = array();
                $event_dates   = unserialize($input_value); // phpcs:ignore
                if ( is_array($event_dates) ) {
                    foreach ($event_dates as $day ) {
                        $row_value = array(
                            $sub_field_key => evt_helper_convert_event_date_to_db_format($day),
                        );
                        array_push($field_value, $row_value);
                    }
                    update_field( $repeater_key, $field_value, $post_id );
                }
            }

            // Host name - string
            else if (stripos($field->cssClass, 'input-cx-host-name') !== false ) { // phpcs:ignore
                $field_key = 'field_5cf7de9812303';
                $value     = rgar( $entry, (string) $field->id );
                update_field( $field_key, $value, $post_id );
            }

            // Host type - string
            else if (stripos($field->cssClass, 'input-cx-host-type') !== false ) { // phpcs:ignore
                // save a basic text value
                $field_key = 'field_5cf7df72b08b9';
                $value     = rgar( $entry, (string) $field->id );
                update_field( $field_key, $value, $post_id );
            }

            // Event format - string
            else if (stripos($field->cssClass, 'input-cx-event-format') !== false ) { // phpcs:ignore
                $field_key = 'field_5cf7dea612304';
                $value     = rgar( $entry, (string) $field->id );
                update_field( $field_key, $value, $post_id );
            }

            // Relevant tags - array but saved as string in acf
            else if (stripos($field->cssClass, 'input-cx-event-tags') !== false ) { // phpcs:ignore
                $field_key = 'field_5cf7dec912305';
                $tags      = array();
                if (is_array($inputs) ) {
                    foreach ( $inputs as $input ) {
                        $value = rgar( $entry, (string) $input['id'] );
                        if ('' !== $value ) {
                            array_push($tags, $value);
                        }
                    }
                }
                if (count($tags) > 0 ) {
                    $value = implode(', ', $tags);
                    update_field( $field_key, $value, $post_id );
                }
            }

            // Boosted or Featured Event - boolean
            else if (stripos($field->cssClass, 'boost-your-event') !== false ) { // phpcs:ignore
                $boost_key    = 'field_5cc1c363dc638';
                $featured_key = 'field_5cc266d414ddf';
                $value        = rgar( $entry, (string) $field->id );

                if ('Boosted' === $value ) {
                    update_field( $boost_key, 1, $post_id );
                    $is_paid_event = true;
                    $event_plan    = 'Boosted';
                }
                elseif ('Featured' === $value ) {
                    update_field( $featured_key, 1, $post_id );
                    $is_paid_event = true;
                    $event_plan    = 'Featured';
                }
            }

            // Paid periods - array
            else if (stripos($field->cssClass, 'input-cx-visual-bost-dates') !== false ) { // phpcs:ignore
                $field_value = array();

                // Default keys to the boosted fields
                $repeater_key   = 'field_5cc1c3aadc639';
                $start_date_key = 'field_5cc1c3d1dc63a';
                $end_date_key   = 'field_5cc1c3fcdc63b';

                if ('Featured' === $event_plan ) {
                    $repeater_key   = 'field_5cca8acfa3a2c';
                    $start_date_key = 'field_5cca8b1da3a2d';
                    $end_date_key   = 'field_5cca8b30a3a2e';
                }

                if ( is_array( $inputs ) ) {
                    foreach ( $inputs as $input ) {
                        $value = rgar( $entry, (string) $input['id'] );
                        if ('' !== $value ) {
                            list($start_date, $end_date) = explode('_', $value);
                            $row_value                   = array(
                                $start_date_key => $start_date,
                                $end_date_key   => $end_date,
                            );
                            array_push($field_value, $row_value);
                        }
                    }
                    if (count($field_value) > 0 ) {
                        update_field( $repeater_key, $field_value, $post_id );
                    }
                }
            }

            // Event URL
            else if (stripos($field->cssClass, 'input-cx-event-url') !== false && $is_paid_event ) { // phpcs:ignore
                $field_key = 'field_5c985b531aa13';
                $value     = rgar( $entry, (string) $field->id );
                update_field( $field_key, $value, $post_id );
            }
            // Event Description
            else if (stripos($field->cssClass, 'input-cx-event-description') !== false && $is_paid_event ) { // phpcs:ignore
                $field_key = 'field_5cdaf7daf674f';
                $value     = rgar( $entry, (string) $field->id );
                update_field( $field_key, $value, $post_id );
            }

            if ('Featured' === $event_plan ) {

                // Event Image
                if (stripos($field->cssClass, 'input-cx-event-image') !== false ) { // phpcs:ignore
                    $image_url = rgar( $entry, (string) $field->id );

                    // Insert the attachment.
                    $attach_id = _evt_helper_attach_uploaded_image($image_url);

                    $field_key = 'field_5d012d34f2ee1';
                    update_field( $field_key, $attach_id, $post_id );
                }

                // Featured speaker 1 full name
                else if (stripos($field->cssClass, 'input-cx-event-speaker-fullname data-speaker-1') !== false) { // phpcs:ignore
                    $field_key = 'field_5d0bc194bf3f1';
                    $value     = rgar( $entry, (string) $field->id );
                    update_field( $field_key, $value, $post_id );
                }

                // Featured speaker 1 bio
                else if (stripos($field->cssClass, 'input-cx-event-speaker-bio data-speaker-1') !== false) { // phpcs:ignore
                    $field_key = 'field_5d0bc1fbbf3f2';
                    $value     = rgar( $entry, (string) $field->id );
                    update_field( $field_key, $value, $post_id );
                }

                // Featured speaker 1 image
                else if (stripos($field->cssClass, 'input-cx-event-speaker-image data-speaker-1') !== false) { // phpcs:ignore
                    $image_url = rgar( $entry, (string) $field->id );

                    // Insert the attachment.
                    $attach_id = _evt_helper_attach_uploaded_image($image_url);

                    $field_key = 'field_5d0bc218bf3f3';
                    update_field( $field_key, $attach_id, $post_id );
                }

                // Featured speaker 2 full name
                else if (stripos($field->cssClass, 'input-cx-event-speaker-fullname data-speaker-2') !== false) { // phpcs:ignore
                    $field_key = 'field_5d0bc238bf3f4';
                    $value     = rgar( $entry, (string) $field->id );
                    update_field( $field_key, $value, $post_id );
                }

                // Featured speaker 2 bio
                else if (stripos($field->cssClass, 'input-cx-event-speaker-bio data-speaker-2') !== false) { // phpcs:ignore
                    $field_key = 'field_5d0bc247bf3f5';
                    $value     = rgar( $entry, (string) $field->id );
                    update_field( $field_key, $value, $post_id );
                }

                // Featured speaker 2 image
                else if (stripos($field->cssClass, 'input-cx-event-speaker-image data-speaker-2') !== false) { // phpcs:ignore
                    $image_url = rgar( $entry, (string) $field->id );

                    // Insert the attachment.
                    $attach_id = _evt_helper_attach_uploaded_image($image_url);

                    $field_key = 'field_5d0bc25ebf3f6';
                    update_field( $field_key, $attach_id, $post_id );
                }

                // Promotions or discounts
                else if (stripos($field->cssClass, 'input-cx-event-promotion') !== false) { // phpcs:ignore
                    $field_key = 'field_5d0bc276bf3f7';
                    $value     = rgar( $entry, (string) $field->id );
                    update_field( $field_key, $value, $post_id );
                }
            }
        }
    }
}
add_action( 'gform_after_create_post_' . KBCO_CX_GFORM_ID, 'evt_helper_set_post_content', 10, 3 );