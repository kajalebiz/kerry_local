<?php
/**
 * CX Event Submission Form Section
 *
 * Helpers functions to display the event submission form
 *
 * @package KerryBodine
 */

/**
 * Generate the event submission form section
 */
function obj_cx_event_submission_form_section( $intro_text, $html_form, $submission_form_deets = null, $section_classes = null, $bg_shapes = null ) {

	$sec_meta = decide_section_meta( 'event-submission-form-section', $section_classes, $submission_form_deets, $bg_shapes );

	if ( ! empty( $submission_form_deets ) ) {
		do_section_top( $sec_meta );
		obj_cx_event_submission_form_inner( $intro_text, $html_form, $submission_form_deets );
		do_section_bottom( $sec_meta );
	}
}

/**
 * Generate the inner content of the event submission form wrapper
 */
function obj_cx_event_submission_form_inner( $intro_text, $html_form, $submission_form_deets = null ) {
    ?>
    <p class="intro"><span class="grande-text"><?php echo $intro_text; ?></span></p>
    <div class="cx-event-submission-form-wrap">
        <ul id="gform-steps-navigation" data-steps-loaded="no"></ul>
        <div id="gform-current-page-name"></div>
        <?php echo $html_form; ?>
        <div class="gform-required-fields-msg">* Required Fields</div>
    </div>
    <?php
}