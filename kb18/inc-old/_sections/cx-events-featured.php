<?php
/**
 * CX Events Sponsored Section
 *
 * Helpers functions to display sponsored events.
 *
 * @package KerryBodine
 */

/**
 * Generate the event list section
 */
function obj_cx_events_featured_section( $events, $event_feat_deets = null, $section_classes = null, $bg_shapes = null ) {

	$sec_meta = decide_section_meta( 'event-featured-section', $section_classes, $event_feat_deets, $bg_shapes );

	if ( ! empty( $event_feat_deets ) ) {
		do_section_top( $sec_meta );
		obj_cx_events_feat_inner($events);
		do_section_bottom( $sec_meta );
	}
}

function obj_cx_events_feat_inner( $events ) {
    echo '<div class="sponsored-event-container">';
    obj_do_cx_featured_event_item_output($events['first_box'], 'sponsored-first-box');
    obj_do_cx_featured_event_item_output($events['second_box'], 'sponsored-second-box');
    obj_do_cx_featured_event_item_output($events['third_box'], 'sponsored-third-box featured');
    echo '</div>';
}

function obj_do_cx_featured_event_item_output( $event, $extra_css_class = '' ) {
?>
    <article class="sponsored-event cx-event-modal <?php echo $extra_css_class; ?>" data-cx-event="cx-event-<?php echo $event->ID; ?>">
        <div class="sponsored-event__image" style="background-image: url('<?php echo $event->sponsor_image_url; ?>')">
            <span class="featured-label">SPONSORED CONTENT</span>
        </div>
        <div class="sponsored-event__details">
            <h4 class="event-title"><?php echo $event->title; ?></h4>
            <div class="event-info">
                <span class="event-info__host"><?php echo $event->hosted_by; ?></span>
                <span class="event-info__date"><?php echo $event->sponsor_dates; ?></span>
                <span class="event-info__location"><?php echo $event->city; ?></span>
                <?php if ( '' !== $event->sponsor_link ) : ?>
                <span class="event-info__link yellow-button">
                    <a href="<?php echo $event->sponsor_link; ?>">View Details</a>
                </span>
                <?php endif; ?>
            </div>
        </div>
    </article>
<?php
    obj_do_cx_featured_item_overlay_output( $event );
}

function obj_do_cx_featured_item_overlay_output( $event ) {
    $speakers_section = evt_helper_get_speakers( $event->ID );
    $register_cta     = evt_helper_get_register_cta( $event->ID );
    ?>
    <a href="#cx-event-details-<?php echo $event->ID; ?>" class="cx-event-modal-trigger" data-trigger-id="cx-event-<?php echo $event->ID; ?>">&nbsp;</a>
    <div id="cx-event-details-<?php echo $event->ID; ?>" style="display:none;" class="cx-event-details-modal">
        <?php if ( ! empty( $event->sponsor_image_url ) ) : ?>
            <div class="cx-event-details-modal__image" style="background-image:url('<?php echo $event->sponsor_image_url; ?>');"></div>
        <?php endif; ?>
        <div class="cx-event-details-modal__info">
            <h3 class="modal-info__title"><?php echo $event->title; ?></h3>
            <div class="modal-info__details">
                <div class="info-left-column modal-details">
                    <div class="modal-details__date"><?php echo $event->sponsor_dates; ?></div>
                    <div class="modal-details__city"><?php echo $event->city; ?></div>
                    <?php if ( '' !== $register_cta->label && '' !== $register_cta->url ) : ?>
                        <span class="primary-button">
                            <a href="<?php echo $register_cta->url; ?>" class="" target="_blank"><?php echo $register_cta->label; ?></a>
                        </span>
                    <?php endif; ?>
                    <div class="modal-details__hosted-by"><?php echo $event->hosted_by; ?></div>
                </div>
                <div class="info-right-column modal-details">
                    <?php if ( get_field( 'cx_paid_event_description', $event->ID ) ) : ?>
                        <div class="modal-details__description">
                            <?php echo get_field( 'cx_paid_event_description', $event->ID ); ?>
                        </div>
                    <?php endif; ?>
                   
                    <?php if ( '' !== $speakers_section->title ) : ?>
                        <h4><?php echo $speakers_section->title; ?></h4>
                    <?php endif; ?>
                    <?php if ( count($speakers_section->persons) > 0 ) : ?>
                    <div class="cx-event-speakers-list">
                        <?php foreach ( $speakers_section->persons as $speaker ) : ?>
                        <div class="cx-event-speaker">
                            <?php if ( '' !== $speaker->image ) : ?>
                            <div class="cx-event-speaker__image">
                                <img src="<?php echo $speaker->image; ?>" />
                            </div>
                            <?php endif; ?>
                            <div class="cx-event-speaker__bio">
                                <div class="speaker-bio__name"><?php echo $speaker->name; ?></div>
                                <span class="speaker-bio__position"></span>
                                <p class="speaker-bio__resume"><?php echo $speaker->bio; ?></p>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php if ( get_field('cx_event_promotions_or_discounts', $event->ID) ) : ?>
        <div class="cx-event-details-modal__offer">
            <div class="modal-offer-info">
                <span class="modal-offer-info__title"><?php echo get_field('special_offer_title', $event->ID) ? get_field('special_offer_title', $event->ID) : 'Promotion'; ?></span>
                <span class="modal-offer-info__text"><?php echo get_field('cx_event_promotions_or_discounts', $event->ID); ?></span>
            </div>
            <?php if ( '' !== $register_cta->label && '' !== $register_cta->url ) : ?>
            <div class="modal-offer-cta">
                <span class="button">
                    <a href="<?php echo $register_cta->url; ?>" class=""><?php echo $register_cta->label; ?></a>
                </span>
            </div>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </div>
    <?php
}