<?php
/**
 * CX Events List Section
 *
 * Helpers functions to display events related data in the grid
 *
 * @package KerryBodine
 */

/**
 * Generate the event list section
 */
function obj_cx_events_list_section( $events, $bottom_banner, $pagination, $event_list_deets = null, $section_classes = null, $bg_shapes = null ) {

	$sec_meta = decide_section_meta( 'event-list-section', $section_classes, $event_list_deets, $bg_shapes );

	if ( ! empty( $event_list_deets ) ) {
		do_section_top( $sec_meta );
		obj_cx_events_list_inner( $events, $bottom_banner, $pagination, $event_list_deets );
		do_section_bottom( $sec_meta );
	}
}

/**
 * Generate the inner content of the event list wrapper
 */
function obj_cx_events_list_inner( $events, $bottom_banner, $pagination, $event_list_deets = null ) {
    echo '<h3 class="section-title green">Upcoming events</h3>';
    obj_do_cx_events_list_filter( $events );
    obj_do_cx_events_list( $events );
    obj_do_cx_event_bottom_banner_output( $bottom_banner );
    obj_do_cx_events_list_pagination( $pagination );
}

/**
 * Display the filter form for the events
 */
function obj_do_cx_events_list_filter( $events ) {
	$months        = evt_helper_get_year_months( $events );
    $types         = evt_helper_get_event_types( $events );
    $search_term   = evt_helper_get_search_term();
    $reset_display = 'none';
    if ('' !== $search_term ) {
        $reset_display = 'block';
    }
	?>
	<div class="event-list-filter__wrap">
        <!-- <div class="event-search-form-wrap">
            <form method="get" action="/events/">
                <div class="event-search-form-inner">
                    <input type="search" value="<?php echo $search_term; ?>" name="evtq" placeholder="Search" class="input-search" />
                    <button class="btn-search">
                        <i class="fa fa-search" aria-hidden="true"></i>
                    </button>
                </div>
            </form>
        </div> -->
        <div class="select-wrap">
			<select name="event-list__month" id="event-list__month">
				<option value="all">When</option>
				<?php foreach ( $months as $abbr => $month ) : ?>
					<option value="<?php echo $abbr; ?>"><?php echo $month; ?></option>
				<?php endforeach; ?>
			</select>
		</div>
		<div class="select-wrap">
			<select name="event-list__type" id="event-list__type">
				<option value="all">Type</option>
				<?php foreach ( $types as $abbr => $type ) : ?>
					<option value="<?php echo $abbr; ?>"><?php echo $type; ?></option>
				<?php endforeach; ?>
			</select>
		</div>
		<div class="filter-reset" style="display:<?php echo $reset_display; ?>">Reset</div>
    </div>
    <span style="display: none;" class="no-events-shown-message grande-text">No results seem to match your search. Adjust the filters to see what other events may be relevant for you.</span>
	<?php
}

/**
 * Get the event list and output
 */
function obj_do_cx_events_list( $events ) {
	if (is_array($events) ) {
        echo '<div class="event-list-grid">';
        foreach ($events as $event ) {
            obj_do_cx_event_item_output($event);
        }
        echo '</div>';
    }
}

function obj_do_cx_event_item_output( $event ) {
    if ( $event->is_featured || $event->has_visual_bost ) {
        obj_do_cx_featured_item_output($event);
    }else {
        obj_do_cx_standard_item_output($event);
    }
}

function obj_do_cx_featured_item_output( $event ) {
    ?>
    <div class="<?php echo $event->css_classes; ?>" data-cx-event="cx-event-<?php echo $event->ID; ?>">
        <div class="cx-event__item cx-event__dates"><?php echo $event->dates; ?></div>
        <div class="cx-event__item cx-event__title"><?php echo $event->title; ?></div>
        <div class="cx-event__item cx-event__hosted-by"><?php echo $event->hosted_by; ?></div>
        <div class="cx-event__item cx-event__city"><?php echo $event->city; ?></div>
        <div class="cx-event__item cx-event__plus">
            <div class=circle>
                <div class="bar horizontal"></div>
                <div class="bar vertical"></div>
            </div>
        </div>
    </div>
    <?php
}

function obj_do_cx_standard_item_output( $event ) {
    ?>
    <div class="<?php echo $event->css_classes; ?>" data-cx-event="cx-event-<?php echo $event->ID; ?>">
        <div class="cx-event__item cx-event__dates"><?php echo $event->dates; ?></div>
        <div class="cx-event__item cx-event__title"><?php echo $event->title; ?></div>
        <div class="cx-event__item cx-event__hosted-by"><?php echo $event->hosted_by; ?></div>
        <div class="cx-event__item cx-event__city"><?php echo $event->city; ?></div>
        <div class="cx-event__item cx-event__plus"></div>
    </div>
    <?php
    if ($event->has_visual_boost ) {
        obj_do_cx_featured_item_overlay_output( $event );
    }
}

function obj_do_cx_event_bottom_banner_output( $bottom_banner ) {
    ?>
    <?php if ( ! empty( $bottom_banner) ) : ?>
    <div class="bottom-banner">
        <div class="bottom-banner__image" style="background-image:url('<?php echo $bottom_banner->sponsor_image_url; ?>');"></div>
        <div class="bottom-banner__info">
            <span class="info-item info-event__title"><?php echo $bottom_banner->title; ?></span>
            <span class="info-item info-event__description"><?php echo $bottom_banner->sponsor_description; ?></span>
            <?php if ( '' !== $bottom_banner->sponsor_link ) : ?>
            <span class="info-item info-event__link primary-button">
                <a href="<?php echo $bottom_banner->sponsor_link; ?>" class="cx-event-modal" data-cx-event="cx-event-<?php echo $bottom_banner->ID; ?>">READ NOW</a>
            </span>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>
    <?php
}

function obj_do_cx_events_list_pagination( $pagination ) {
    echo '<nav class="cx-events-list-pagination">' . $pagination . '</nav>';
}