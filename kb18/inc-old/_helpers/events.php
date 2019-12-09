<?php

// Dislay a grid of event blocks
function obj_do_events_grid( $event_times = null, $class = null, $card = false, $link = false, $num = 99 ) {
	if ( ! empty( $event_times ) && is_array( $event_times ) ) {
		$count = 1;
		echo "<div class='events-grid__wrap {$class}'>";
		foreach ( $event_times as $events ) {
			foreach ( $events as $e ) {
				if ( $count <= $num ) {
					if ( $card ) {
						obj_do_event_card( $e );
					} else {
						obj_do_event_block( $e );
					}
					$count += 1;
				}
			}
		}
		echo '</div>';

		if ( $link ) {
			$archive_link = get_post_type_archive_link( 'sc_event' );

			if ( ! empty( $archive_link ) ) {
				echo "<a href='{$archive_link}' class='events-grid__view_all'>View all CX Events</a>";
			}
		}
	}
}

// Display an event block
function obj_do_event_block( $event = null ) {
	if ( ! empty( $event ) ) {
		$pid       = $event;
		$date      = obj_get_event_dates( $pid );
		$city      = obj_get_event_city( $pid );
		$perm      = get_the_permalink( $pid );
		$thumb_id  = get_post_thumbnail_id( $pid );
		$image     = wp_get_attachment_image( $thumb_id, 'obj-blog-block', false, array( 'class' => 'event-block__thumb' ) );
		$btn_class = decide_page_button_class();
		$display   = ! empty( $date ) && ! empty( $city ) && ! empty( $perm ) && ! empty( $image );

		if ( $display ) {
			echo "<div class='event-block__outer'>";
			echo "<a href='{$perm}' class='event-block__link'>";
			echo "<div class='event-block__inner'>";
			echo $image;
			echo "<div class='event-block__title'><span class='event-block__city'>{$city}</span> - <span class='event-block__date'>{$date}</span></div>";
			echo "<div class='event-block__button-wrap'>";
			echo "<div class='fake-button {$btn_class} small-button'>Learn More</div>";
			echo '</div>';
			echo '</div>';
			echo '</a>';
			echo '</div>';
		}
	}
}

// Display an event card
function obj_do_event_card( $event = null ) {
	if ( ! empty( $event ) ) {
		$pid      = $event;
		$date     = obj_get_event_dates( $pid );
		$city     = obj_get_event_city( $pid );
		$perm     = get_the_permalink( $pid );
		$title    = get_field( 'event_banner_override_title', $pid );
		$thumb_id = get_post_thumbnail_id( $pid );
		$image    = wp_get_attachment_image( $thumb_id, 'obj-blog-block', false, array( 'class' => 'event-block__thumb' ) );
		$display  = ! empty( $date ) && ! empty( $city ) && ! empty( $perm ) && ! empty( $image );

		if ( $display ) {
			echo "<div class='event-block__outer card'>";
			echo "<a href='{$perm}' class='event-block__link'>";
			echo "<div class='event-block__inner'>";
			echo $image;
			echo "<div class='event-block__details'>";
			echo "<div class='event-block__event-title'>{$title}</div>";
			echo "<div class='event-block__title'><span class='event-block__city'>{$city}</span> - <span class='event-block__date'>{$date}</span></div>";
			echo '</div>';
			echo '</div>';
			echo '</a>';
			echo '</div>';
		}
	}
}

// Get Event Start Date
function obj_get_event_start_date( $id = null, $format = 'F d' ) {
	if ( ! empty( $id ) ) {
		$date = get_post_meta( $id, 'sc_event_date_time', true );
		$date = date_i18n( $format, $date );
		return $date;
	}
	return null;
}

// Get event dates
function obj_get_event_dates( $event_id ) {
	$start_date = get_post_meta( $event_id, 'sc_event_date_time', true );
	$end_date   = get_post_meta( $event_id, 'sc_event_end_date_time', true );

	if ( empty( $start_date ) || empty( $end_date ) ) {
		return '';
	}

	$format_start_date = date_i18n( sc_get_date_format(), $start_date );
	$format_end_date   = date_i18n( sc_get_date_format(), $end_date );

	if ( $format_end_date !== $format_start_date ) {
		$start_year  = date_i18n( 'Y', $end_date );
		$start_month = date_i18n( 'F', $start_date );
		$start_day   = date_i18n( 'j', $start_date );
		$end_year    = date_i18n( 'Y', $end_date );
		$end_month   = date_i18n( 'F', $end_date );
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
function obj_get_count_event_dates( $event_id ) {
	$start_date = strtotime(get_post_meta( $event_id, 'countdown_event_start_date', true ));
	$end_date   = strtotime(get_post_meta( $event_id, 'countdown_event_end_date', true ));
	if ( empty( $start_date ) || empty( $end_date ) ) {
		return '';
	}
	$format_start_date = date_i18n( sc_get_date_format(), $start_date );
	$format_end_date   = date_i18n( sc_get_date_format(), $end_date );
	if ( $format_end_date !== $format_start_date ) {
		$start_year  = date_i18n( 'Y', $end_date );
		$start_month = date_i18n( 'F', $start_date );
		$start_day   = date_i18n( 'j', $start_date );
		$end_year    = date_i18n( 'Y', $end_date );
		$end_month   = date_i18n( 'F', $end_date );
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

function obj_event_has_passed( $id = null ) {
	$time  = current_time( 'timestamp' );
	$start = get_post_meta( $id, 'sc_event_date_time', true );

	if ( $time > $start ) {
		return true;
	} else {
		return false;
	}
}

// Get Event City
function obj_get_event_city( $id = null ) {
	if ( ! empty( $id ) ) {
		$city = get_field( 'city', $id );
		return $city;
	}
	return null;
}

// Remove past events (returns all future events)
function obj_remove_past_events( $events = null ) {
	$time = current_time( 'timestamp' );

	foreach ( $events as $starttime => $post_id ) {
		if ( $starttime < $time ) {
			unset( $events[ $starttime ] );
		}
	}
	return $events;
}

// Remove future events (returns all past events)
function obj_remove_future_events( $events = null ) {
	$time = current_time( 'timestamp' );

	foreach ( $events as $starttime => $post_id ) {
		if ( $starttime > $time ) {
			unset( $events[ $starttime ] );
		}
	}
	krsort( $events );
	return $events;

}

// Get a number of all future events
function obj_get_events_number() {
	$events        = sc_get_all_events();
	$future_events = obj_remove_past_events( $events );
	$event_count   = obj_count_events( $future_events );

	return $event_count;
}

// Get a number of all future events that are also kb events
function obj_get_kb_events_number() {
	$future_kb_events = obj_get_kb_events();
	$event_count      = obj_count_events( $future_kb_events );

	return $event_count;
}

// Takes in an array of events (organized the way that SC organizes them via keys that correlate to start time)
function obj_count_events( $events = null ) {
	if ( ! empty( $events ) ) {
		$event_count = 0;

		if ( is_array( $events ) ) {
			foreach ( $events as $event_time ) {
				if ( is_array( $event_time ) ) {
					$additional_events = count( $event_time );
					$event_count      += $additional_events;
				}
			}
		}

		return $event_count;
	}
}

// Returns all events that are in the future that also are kb events
function obj_get_kb_events() {
	$events        = sc_get_all_events();
	$future_events = obj_remove_past_events( $events );

	if ( ! empty( $future_events ) ) {

		// Remove events that are not KB events
		foreach ( $future_events as $starttime => $event_array ) {
			foreach ( $event_array as $event_key => $event_id ) {
				$is_kb_event = get_field( 'kb_co_workshop', $event_id );
				if ( ! $is_kb_event ) {
					unset( $future_events[ $starttime ][ $event_key ] );
				}
			}
		}

		// Remove event times that no longer have events
		foreach ( $future_events as $starttime => $event_array ) {
			if ( empty( $event_array ) ) {
				unset( $future_events[ $starttime ] );
			}
		}
	}

	return $future_events;
}

function obj_get_kb_events_related( $event_id = null, $num = 3 ) {
	$events = null;

	if ( ! empty( $event_id ) ) {
		$terms          = get_the_terms( $event_id, 'sc_event_category' );
		$event_cat_term = get_term( ( $terms[0] ) );
		$event_cat_slug = $event_cat_term->slug;
		$events         = obj_get_kb_events();
		$plenty_in_cat  = obj_see_if_sufficient_in_cat( $events, $num, $event_cat_slug, $event_id );

		if ( ! empty( $events ) ) {
			foreach ( $events as $starttime => $event_array ) {
				foreach ( $event_array as $event_key => $inner_event_id ) {
					if ( $plenty_in_cat ) {
						$same_cat = obj_events_in_same_cat( $event_cat_slug, $inner_event_id );
						$dq       = $same_cat || $event_id === $inner_event_id;
						if ( $dq ) {
							unset( $events[ $starttime ][ $event_key ] );
						}
					} else {
						$dq = $event_id === $inner_event_id;
						if ( $dq ) {
							unset( $events[ $starttime ][ $event_key ] );
						}
					}
				}
			}
			$events = obj_return_x_events( $num, $events );
		}
	}
	return $events;
}

function obj_return_x_events( $num = null, $events ) {
	$events    = obj_flat_events_array( $events );
	$count     = 0;
	$full_list = array();

	foreach ( $events as $event_id ) {

		if ( $count < $num ) {
			$start = get_post_meta( $event_id, 'sc_event_date_time', true );
			$type  = get_post_meta( $event_id, 'sc_event_recurring', true );

			if ( ! empty( $type ) && 'none' != $type ) {

				$recurring = get_post_meta( $event_id, 'sc_all_recurring', true );

				foreach ( $recurring as $time ) {
					$full_list[ $time ][] = $event_id;
				}
			} else {
				$full_list[ $start ][] = $event_id;
			}
			$count += 1;
		}
	}
	ksort( $full_list );

	return $full_list;
}

function obj_events_in_same_cat( $event_cat_slug = null, $inner_event_id = null ) {
	$inner_terms          = get_the_terms( $inner_event_id, 'sc_event_category' );
	$inner_event_cat_term = get_term( ( $inner_terms[0] ) );
	$inner_event_cat_slug = $inner_event_cat_term->slug;

	return $event_cat_slug === $inner_event_cat_slug;
}

function obj_see_if_sufficient_in_cat( $events = null, $num = null, $event_cat_slug = null, $event_id = null ) {
	if ( ! empty( $events ) && ! empty( $num ) && ! empty( $event_cat_slug ) && ! empty( $event_id ) ) {
		$events     = obj_flat_events_array( $events );
		$cat_events = array();
		if ( is_array( $events ) ) {
			foreach ( $events as $inner_event_id ) {
				$inner_terms          = get_the_terms( $inner_event_id, 'sc_event_category' );
				$inner_event_cat_term = get_term( ( $inner_terms[0] ) );
				$inner_event_cat_meta = get_term_meta( $inner_event_cat_term );
				$inner_event_cat_slug = $inner_event_cat_term->slug;
				$dq                   = ( $event_cat_slug !== $inner_event_cat_slug ) || ( $event_id === $inner_event_id );
				if ( ! $dq ) {
					array_push( $cat_events, $inner_event_id );
				}
			}
		}

		if ( ! empty( $cat_events ) ) {
			$count = count( $cat_events );
			return $count >= $num;
		}
	} else {
		return false;
	}
}

function obj_flat_events_array( $events = null ) {
	if ( ! empty( $events ) ) {
		$single_level_events = array();

		foreach ( $events as $event_array ) {
			foreach ( $event_array as $event_id ) {
				array_push( $single_level_events, $event_id );
			}
		}

		return $single_level_events;
	}
}

function obj_do_events_list_filter() {
	$months = obj_get_year_months();
	$types  = obj_get_event_types();

	?>
	<div class="event-list-filter__wrap">
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
		<div class="filter-reset">Reset</div>
	</div>
	<?php
}

// Output events in list
function obj_do_events_list() {
	$events        = sc_get_all_events();
	$future_events = obj_remove_past_events( $events );
	$future_events = obj_flat_events_array( $future_events );
	$pos_count     = 1;

	$display_list_cta  = get_field( 'display_list_block_cta' );
	$list_cta_title    = get_field( 'list_block_cta_title' );
	$list_cta_blurb    = get_field( 'list_block_cta_blurb' );
	$list_cta_button   = get_field( 'list_block_cta_button' );
	$list_cta_bg_image = get_field( 'list_block_cta_background_image' );
	$list_cta_position = get_field( 'list_block_cta_position' );
	$list_cta_position = (int) $list_cta_position;
	if ( ! empty( $list_cta_bg_image ) && key_exists( 'url', $list_cta_bg_image ) ) {
		$list_cta_bg_image = $list_cta_bg_image['url'];
	}

	if ( ! empty( $future_events ) && is_array( $future_events ) ) {
		echo "<div class='event-list-grid'>";
		foreach ( $future_events as $event_id ) {
			obj_do_list_event( $event_id );
			$pos_count += 1;

			if ( ! empty( $display_list_cta ) && $display_list_cta ) {
				if ( $pos_count === $list_cta_position ) {
					if ( ! empty( $list_cta_title ) ) {
						echo "<div class='list-event-cta' style='background-image: url($list_cta_bg_image)'>";
						echo "<h3 class='list-event-cta__title'>$list_cta_title</h3>";
						if ( ! empty( $list_cta_blurb ) ) {
							echo "<div class='list-event-cta__blurb'>$list_cta_blurb</div>";
						}
						echo objectiv_link_button( $list_cta_button );
						echo '</div>';
					}
				}
			}
		}
		echo '</div>';
	}
}

function obj_do_list_event( $event_id = null ) {
	if ( ! empty( $event_id ) ) {
		$title          = get_the_title( $event_id );
		$date           = obj_get_event_dates( $event_id );
		$city           = get_field( 'city', $event_id );
		$tier           = get_field( 'event_tier', $event_id );
		$img_id         = get_post_thumbnail_id( $event_id );
		$image          = wp_get_attachment_image_url( $img_id, 'obj-blog-block' );
		$hosted_by      = get_field( 'hosted_by', $event_id );
		$hosted_by_link = get_field( 'hosted_by_link', $event_id );
		$is_kb_event    = get_field( 'kb_co_workshop', $event_id );
		$event_blurb    = get_field( 'teaser_blurb', $event_id );
		$why_title      = get_field( 'why_title', $event_id );
		$why_block      = get_field( 'why_block', $event_id );
		$speakers_title = get_field( 'speakers_title', $event_id );
		$speakers       = get_field( 'speakers', $event_id );
		$spec_title     = get_field( 'special_offer_title', $event_id );
		$spec_detail    = get_field( 'special_offer_text', $event_id );
		$type_class     = get_field( 'event_type', $event_id )['value'];
		$date_class     = date_i18n( 'M-Y', get_post_meta( $event_id, 'sc_event_date_time', true ) );

		// Set Detail level
		if ( $is_kb_event ) {
			$deet_level     = 2;
			$hosted_by_link = array(
				'title' => 'More Details',
				'url'   => get_permalink( $event_id ),
			);

		} elseif ( 'base' === $tier ) {
			$deet_level = 0;
		} elseif ( 'tier1' === $tier ) {
			$deet_level = 1;
		} elseif ( 'tier2' === $tier ) {
			$deet_level = 2;
		}

		// Details for Image
		$display_image = false;
		$img_class     = 'no-img';
		if ( ! empty( $image ) && ( $deet_level >= 1 ) ) {
			$img_class     = 'has-img';
			$display_image = true;
		}

		if ( ! empty( $title ) && ! empty( $date ) && ! empty( $city ) ) {
		?>
			<div class="list-event <?php echo $tier; ?> <?php echo $img_class; ?> <?php echo $type_class; ?> <?php echo $date_class; ?>">
				<div class="list-event__top">
					<div class="list-event__left">
						<h3 class="list-event__title"><?php echo $title; ?></h3>
						<div class="list-event__date"><?php echo $date; ?></div>
						<div class="list-event__city"><?php echo $city; ?></div>
					</div>
					<?php if ( $display_image ) : ?>
						<div class="list-event__image" style="background-image: url(<?php echo $image; ?>)">
						</div>
					<?php endif; ?>
				</div>
				<?php if ( ! empty( $hosted_by ) || ( ! empty( $event_blurb ) && ( $deet_level >= 1 ) ) || ( $deet_level >= 2 && ( ! empty( $why_block ) || is_array( $speakers ) ) ) ) : ?>
					<div class="list-event__hover-details">
						<div class="list-event__hover-details__top">
							<div class="list-event__hover-details__top-left">
								<?php if ( ! empty( $hosted_by ) ) : ?>
									<div class="list-event__hosted-by-title">Hosted By</div>
									<div class="list-event__hosted-by-host"><?php echo $hosted_by; ?></div>
									<?php if ( ! empty( $hosted_by_link ) && ( $deet_level >= 1 ) ) : ?>
										<?php echo objectiv_link_link( $hosted_by_link, 'list-event__hosted-by-link' ); ?>
									<?php endif; ?>
								<?php endif; ?>
							</div>
							<?php if ( ! empty( $event_blurb ) && ( $deet_level >= 1 ) ) : ?>
								<div class="list-event__hover-details__top-right">
										<div class="list-event__blurb lmb0 larger-text"><?php echo $event_blurb; ?></div>
								</div>
							<?php endif; ?>
						</div>
						<?php if ( $deet_level >= 2 && ( ! empty( $why_block ) || is_array( $speakers ) ) ) : ?>
							<div class="list-event__hover-details__bottom">
								<?php if ( ! empty( ! empty( $why_block ) ) ) : ?>
									<div class="list-event__why-attend">
										<?php if ( ! empty( $why_title ) ) : ?>
											<h4 class="list-event__why-attend-title"><?php echo $why_title; ?></h4>
										<?php endif; ?>
										<div class="list-event__why-attend-content lmb0"><?php echo $why_block; ?></div>
									</div>
								<?php endif; ?>
								<?php if ( ! empty( is_array( $speakers ) ) ) : ?>
									<div class="list-event__speakers">
										<?php if ( ! empty( $speakers_title ) ) : ?>
											<h4 class="list-event__speakers-title"><?php echo $speakers_title; ?></h4>
										<?php endif; ?>
										<div class="list-event__speakers_grid">
											<?php foreach ( $speakers as $s ) : ?>
												<?php obj_do_event_list_speaker( $s ); ?>
											<?php endforeach; ?>
										</div>
									</div>
								<?php endif; ?>
							</div>
						<?php endif; ?>
					</div>
				<?php endif; ?>
				<?php if ( ! empty( $spec_title ) || ! empty( $spec_detail ) && $deet_level >= 2 ) : ?>
					<div class="list-event__hover-special">
						<?php if ( ! empty( $spec_title ) ) : ?>
							<div class="list-event__hover-special_title"><?php echo $spec_title; ?></div>
						<?php endif; ?>
						<?php if ( ! empty( $spec_detail ) ) : ?>
							<div class="list-event__hover-special_detail"><?php echo $spec_detail; ?></div>
						<?php endif; ?>
					</div>
				<?php endif; ?>
			</div>
		<?php
		}
	}
}

function obj_do_event_list_speaker( $speaker = null ) {
	if ( ! empty( $speaker ) ) {
		$type     = $speaker['person_type'];
		$s_id     = $speaker['staff_member'];
		$headshot = null;
		$name     = null;
		$position = null;

		if ( 'one-ff' === $type ) {
			$headshot = $speaker['headshot'];
			$name     = $speaker['name'];
			$position = $speaker['position'];
			if ( is_array( $headshot ) ) {
				$head_image = $headshot['sizes']['obj-large-square'];
			}
		} elseif ( 'kb' === $type && ! empty( $s_id ) ) {
			$headshot = get_post_thumbnail_id( $s_id );
			$name     = get_the_title( $s_id );
			$position = get_field( 'position', $s_id );
			if ( ! empty( $headshot ) ) {
				$head_image = wp_get_attachment_image_src( $headshot, 'obj-large-square' )[0];
			}
		}

		if ( ! empty( $head_image ) && ! empty( $name ) ) {
			echo "<div class='list-event__speaker'>";
			echo "<div class='list-event__speaker-image-wrap'>";
			echo "<img src='$head_image' alt='$name headshot'>";
			echo '</div>';
			echo "<div class='list-event__speaker-name'>$name</div>";
			if ( ! empty( $position ) ) {
				echo "<div class='list-event__speaker-position'>$position</div>";
			}
			echo '</div>';
		}
	}
}

// Single Event Banner Block
function obj_do_event_banner_block() {
	$eid = get_the_ID();

	if ( ! empty( $eid ) ) {
		$title      = get_field( 'event_banner_override_title', $eid );
		$city       = get_field( 'city', $eid );
		$date       = obj_get_event_dates( $eid );
		$reg_text   = get_field( 'registration_text', $eid );
		$reg_link   = get_field( 'registration_link', $eid );
		$kb_event   = get_field( 'kb_co_workshop', $eid );
		$btn_class  = decide_page_button_class();
		$passed     = obj_event_has_passed( $eid );
		$foot_class = null;

		$is_universe_link = get_field( 'register_section_is_this_a_universe_event_link', $eid );
		$universe_link    = get_field( 'register_section_universe_event_link', $eid );

		if ( $passed ) {
			$reg_text   = 'This event has passed';
			$reg_link   = null;
			$foot_class = 'basemt';
		}

		if ( empty( $title ) ) {
			$title = get_the_title( $eid );
		}

		if ( $kb_event ) {
		?>
			<div class="event-banner-box">
				<?php if ( ! empty( $title ) ) : ?>
					<h2 class="event-banner-box__title"><?php echo $title; ?></h2>
				<?php endif; ?>
				<?php if ( ! empty( $city ) ) : ?>
					<h5 class="event-banner-box__city"><?php echo $city; ?></h5>
				<?php endif; ?>
				<?php if ( ! empty( $date ) ) : ?>
					<div class="event-banner-box__date"><?php echo $date; ?></div>
				<?php endif; ?>
				<?php if ( ! empty( $reg_text ) || is_array( $reg_link ) ) : ?>
					<footer class="event-banner-box__footer <?php echo $foot_class; ?>">
						<?php if ( ! empty( $reg_text ) ) : ?>
							<div class="event-banner-box__footer-text <?php echo $passed ? 'event-passed' : ''; ?>"><?php echo $reg_text; ?></div>
						<?php endif; ?>
						<?php if ( is_array( $reg_link ) && ! $is_universe_link ) : ?>
							<div class="event-banner-box__footer-button-wrap">
								<?php echo objectiv_link_button( $reg_link, $btn_class ); ?>
							</div>
						<?php endif; ?>
						<?php if ( $is_universe_link && ! empty( $universe_link ) ) : ?>
							<span class="<?php echo $btn_class; ?>">
								<a class="unii-listing-button" href="<?php echo $universe_link; ?>">Get Tickets</a>
							</span>
						<?php endif; ?>
					</footer>
				<?php endif; ?>
			</div>
		<?php
		}
	}
}

// Single Countdown Event Banner Block
function obj_do_countdown_event_banner_block() {
	$eid = get_the_ID();

	if ( ! empty( $eid ) ) {
		$title      = get_field( 'event_banner_override_title', $eid );
		$sub_title  = get_field( 'kerrybodine_all_pp_sub_heading', $eid );
		$city       = get_field( 'city', $eid );
		$date       = obj_get_count_event_dates( $eid );
		$reg_text   = get_field( 'registration_text', $eid );
		$reg_link   = get_field( 'registration_link', $eid );
		$kb_event   = get_field( 'kb_co_workshop', $eid );
		$btn_class  = decide_page_button_class();
		$passed     = obj_event_has_passed( $eid );
		$foot_class = null;

		$is_universe_link = get_field( 'register_section_is_this_a_universe_event_link', $eid );
		$universe_link    = get_field( 'register_section_universe_event_link', $eid );

		if ( $passed ) {
			$reg_text   = 'This event has passed';
			$reg_link   = null;
			$foot_class = 'basemt';
		}

		if ( empty( $title ) ) {
			$title = get_the_title( $eid );
		}

		if ( $kb_event ) {
		?>
			<div class="event-banner-box">
                                <?php if ( ! empty( $sub_title ) ) { ?>
                                    <h3><?php echo $sub_title; ?></h3>
                                <?php } if ( ! empty( $title ) ) : ?>
					<h2 class="event-banner-box__title"><?php echo $title; ?></h2>
				<?php endif; ?>
                                <?php
                                    $timer_date = get_field( 'countdown_event_start_date', $eid ); 
                                    $timer_date = new DateTime($timer_date);
                                    $timer_date = $timer_date->format( 'Y/m/d H:i:s' );
                                    ?>
					<div class="event-banner-box__date counter-event-date" data-start-date="<?php echo $timer_date; ?>"></div>
                                        <script type="text/javascript">
                                        jQuery(".counter-event-date")
                                        .countdown("<?php echo $timer_date; ?>", function(event) {
                                            var week_day = event.strftime('%w');
                                            var days_day = event.strftime('%d');
                                            var hourse_day = event.strftime('%H');
                                            var week_len = week_day.length;
                                            var days_len = days_day.length;
                                            var hourse_len = hourse_day.length;
                                            var week_html = '';
                                            var days_html = '';
                                            var hourse_html = '';
                                            for (i = 0; i < week_len ; i++) { 
                                                week_html = week_html + "<span>" + week_day.slice(i, i+1 ) +"</span>";
                                            }
                                            for (i = 0; i < days_len ; i++) { 
                                                days_html = days_html + "<span>" + days_day.slice(i, i+1 ) +"</span>";
                                            }
                                            for (i = 0; i < hourse_len ; i++) { 
                                                hourse_html = hourse_html + "<span>" + hourse_day.slice(i, i+1 ) +"</span>";
                                            }
                                          jQuery(this).html( 
                                            event.strftime('<div class="single-date"><div class="single-time">'+week_html+'</div><p>WEEKS</p></div> <div class="single-date"><div class="single-time">'+days_html+'</div> <p>Days</p></div> <div class="single-date"><div class="single-time">'+hourse_html+'</div> <p>Hours</p></div>')
                                          );
                                        });
                                      </script>
                                <?php if ( ! empty( $date ) ) : ?>
					<div class="event-banner-box__date"><?php echo $date; ?></div>
				<?php endif; ?>
				<?php if ( ! empty( $city ) ) : ?>
					<h5 class="event-banner-box__city"><?php echo $city; ?></h5>
				<?php endif; ?>
				<?php /* if ( ! empty( $reg_text ) || is_array( $reg_link ) ) : ?>
					<footer class="event-banner-box__footer <?php echo $foot_class; ?>">
						<?php if ( ! empty( $reg_text ) ) : ?>
							<div class="event-banner-box__footer-text <?php echo $passed ? 'event-passed' : ''; ?>"><?php echo $reg_text; ?></div>
						<?php endif; ?>
						<?php if ( is_array( $reg_link ) && ! $is_universe_link ) : ?>
							<div class="event-banner-box__footer-button-wrap">
								<?php echo objectiv_link_button( $reg_link, $btn_class ); ?>
							</div>
						<?php endif; ?>
						<?php if ( $is_universe_link && ! empty( $universe_link ) ) : ?>
							<span class="<?php echo $btn_class; ?>">
								<a class="unii-listing-button" href="<?php echo $universe_link; ?>">Get Tickets</a>
							</span>
						<?php endif; ?>
					</footer>
				<?php  endif; */?>
			</div>
		<?php
		}
	}
}

function obj_get_year_months() {
	$events = sc_get_all_events();
	$events = obj_remove_past_events( $events );
	$events = obj_flat_events_array( $events );

	$months_and_years = array();

	foreach ( $events as $e_id ) {
		$date  = get_post_meta( $e_id, 'sc_event_date_time', true );
		$value = date_i18n( 'M-Y', $date );
		$label = date_i18n( 'F Y', $date );

		if ( ! array_key_exists( $value, $months_and_years ) ) {
			$months_and_years[ $value ] = $label;
		}
	}

	return $months_and_years;
}

function obj_get_event_types() {
	$events = sc_get_all_events();
	$events = obj_remove_past_events( $events );
	$events = obj_flat_events_array( $events );

	$types = array();

	foreach ( $events as $e_id ) {
		$type  = get_field( 'event_type', $e_id );
		$value = $type['value'];
		$label = $type['label'];

		if ( ! array_key_exists( $value, $types ) ) {
			$types[ $value ] = $label;
		}
	}

	return $types;
}
