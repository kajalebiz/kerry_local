/**
 * Our event form helper class
 */
var CX_EVENT_SUBMISSION_FORM_HELPER = function () {
    this.$form = null;
    this.total_steps = 0;
    this.SETUP_EVENT_DATES_FILTER = true;
    this.ALREADY_LOADED = false;
};

/**
 * Check if our form is present in the page
 * 
 * @return Boolean
 */
CX_EVENT_SUBMISSION_FORM_HELPER.prototype.isFormPresent = function (form_id) {
    // check if we are in the event submission page
    if (jQuery('.cx-event-submission-form-wrap').length > 0) {

        // find our multi page form 
        var $form = jQuery('.cx-event-submission-form-wrap').find('form');
        if ($form.length > 0) {

            // validate the form id with our form_id parameter
            if ($form.attr('id') === 'gform_' + form_id) {
                this.$form = $form;
                return true;
            }
        }
    }
    return false;
}

/**
 * Update the green bar above the form with the current page step
 */
CX_EVENT_SUBMISSION_FORM_HELPER.prototype.updateStepIndicator = function (current_page) {
    // generate our step pagination indicator
    var $step_pagination = jQuery('#gform-steps-navigation');

    this.total_steps = this.$form.find('.gf_step').length;

    // initialize the first time
    if ($step_pagination.data('steps-loaded') === 'no') {

        for (var index = 0; index < this.total_steps; index++) {
            var $li = jQuery('<li class="gform-step-item page-number-' + (index + 1) + '" />');
            if (index == 0) {
                $li.addClass('bg-fill');
            }
            $step_pagination.append($li);
        }
        $step_pagination.data('steps-loaded', 'yes');
        $step_pagination.attr('data-steps-loaded', 'yes');
    }

    // if current_page is undefined, we are on the thank you page.
    // form submission has been completed here.
    if(typeof current_page === 'undefined'){
        jQuery($step_pagination.find('li')).addClass('bg-fill');
    }else {
        jQuery($step_pagination.find('li')).removeClass('bg-fill');
        jQuery($step_pagination.find('.page-number-' + current_page)).addClass('bg-fill');
    }
}

/**
 * Update our page / step title
 */
CX_EVENT_SUBMISSION_FORM_HELPER.prototype.updateStepLabel = function (current_page) {
    // if current_page is undefined, we are on the thank you page.
    // form submission has been completed here.
    if(typeof current_page === 'undefined'){
        jQuery('#gform-current-page-name').html('<h3>Submission Sent!</h3>');
    }
    else{
        var $step_label = this.$form.find('.gf_step_active > .gf_step_label');
        jQuery('#gform-current-page-name').html('<h3>' + $step_label.text() + '</h3>');
    }
}

/**
 * Validate if we reach out our last step
 */
CX_EVENT_SUBMISSION_FORM_HELPER.prototype.isLastPage = function (current_page) {
    return current_page == this.total_steps;
}

/**
 * Validate if we are in the event details form
 */
CX_EVENT_SUBMISSION_FORM_HELPER.prototype.isEventFormPage = function (current_page) {
    return current_page == 2;
}

CX_EVENT_SUBMISSION_FORM_HELPER.prototype.hidePreviewElements = function(){
    jQuery('.sep-date-item').hide();
    jQuery('#preview-cx-event-date-end').hide();
    jQuery('.preview-item.extra-item').hide();
    jQuery('.preview-item.event-banner-item').hide();
    jQuery('.preview-item.speaker1-item').hide();
    jQuery('.preview-item.speaker2-item').hide();
    jQuery('.preview-item.promotion-item').hide();
}

/**
 * Method to display the preview, we need to copy each field value
 * and display those in "preview" containers without any mouse events.
 */
CX_EVENT_SUBMISSION_FORM_HELPER.prototype.generatePreview = function () {

    // hide extra elements by default
    this.hidePreviewElements();

    // grab the field data
    var event_title = this.getTextFieldValue('cx-event-title');
    var event_location = this.getTextFieldValue('cx-event-location');
    var event_dates = this.getEventDatesValues();
    var event_host_name = this.getTextFieldValue('cx-host-name');
    var event_host_type = this.getSelectFieldValue('cx-host-type');
    var event_format = this.getSelectFieldValue('cx-event-format');
    var event_tags = this.getCheckboxesValues('cx-event-tags');
    var event_plan = this.getEventPlan();

    var $previewContainer = jQuery(jQuery('.preview-cx-event-details')[0]);
    var $eventTagList = jQuery('#preview-cx-event-tags');
    jQuery('#preview-cx-event-title').html(event_title);
    jQuery('#preview-cx-event-location').html(event_location);
    jQuery('#preview-cx-event-date-start').html(event_dates[0]);
    if(event_dates.length===2){
        jQuery('.sep-date-item').show();
        jQuery('#preview-cx-event-date-end').html(event_dates[1]);
        jQuery('#preview-cx-event-date-end').show();
    }
    jQuery('#preview-cx-event-host-name').html(event_host_name);
    jQuery('#preview-cx-event-host-type').html(event_host_type);
    jQuery('#preview-cx-event-format').html(event_format);

    $eventTagList.html('');
    for (var index = 0; index < event_tags.length; index++) {
        $eventTagList.append('<li>' + event_tags[index] + '</li>');
    }

    if(event_plan !== 'free' ){
        var event_description = this.getTextAreaFieldValue('cx-event-description');
        var event_url = this.getTextFieldValue('cx-event-url');
        jQuery('#preview-cx-event-description').html(event_description);
        jQuery('#preview-cx-event-url').html(event_url);
        jQuery('.preview-item.extra-item').show();
    }

    if(event_plan === 'featured'){


        // Grab our values
        var speaker1_name = this.getTextFieldValue('cx-event-speaker-fullname.data-speaker-1');
        var speaker1_bio = this.getTextAreaFieldValue('cx-event-speaker-bio.data-speaker-1');
        var speaker2_name = this.getTextFieldValue('cx-event-speaker-fullname.data-speaker-2');
        var speaker2_bio = this.getTextAreaFieldValue('cx-event-speaker-bio.data-speaker-2');
        var event_promotion = this.getTextAreaFieldValue('cx-event-promotion');

        // Append our values
        jQuery('#preview-cx-event-speaker1-name').html(speaker1_name);
        jQuery('#preview-cx-event-speaker1-bio').html(speaker1_bio);
        jQuery('#preview-cx-event-speaker2-name').html(speaker2_name);
        jQuery('#preview-cx-event-speaker2-bio').html(speaker2_bio);
        jQuery('#preview-cx-event-promotions').html(event_promotion);

        // Show the values
        jQuery('.preview-item.event-banner-item').show();

        jQuery('.speaker1-item.item--section-header').show();
        jQuery('.speaker1-item.item--fullname').show();
        jQuery('.speaker1-item.item--bio').show();

        if( jQuery('#preview-cx-event-speaker1-img').is('[data-img]') === false){
            jQuery('.speaker1-item.item--image').show();
        }

        if('' !== speaker2_name && '' !== speaker2_bio){
            jQuery('.speaker2-item.item--section-header').show();
            jQuery('.speaker2-item.item--fullname').show();
            jQuery('.speaker2-item.item--bio').show();
        }

        if( jQuery('#preview-cx-event-speaker2-img').is('[data-img]') === false){
            jQuery('.speaker2-item.item--image').show();
        }

        if('' != event_promotion){
            jQuery('.preview-item.promotion-item').show();
        }
    }
}

/**
 * Update the preview of a text field
 */
CX_EVENT_SUBMISSION_FORM_HELPER.prototype.getTextFieldValue = function (field_class) {
    var $input_field = jQuery(jQuery('.input-' + field_class).find('.ginput_container > input'));
    return $input_field.val();
}

CX_EVENT_SUBMISSION_FORM_HELPER.prototype.getTextAreaFieldValue = function (field_class) {
    var $input_field = jQuery(jQuery('.input-' + field_class).find('.ginput_container > textarea'));
    return $input_field.val();
}

CX_EVENT_SUBMISSION_FORM_HELPER.prototype.getSelectFieldValue = function (field_class) {
    var $input_field = jQuery(jQuery('.input-' + field_class).find('.ginput_container > select'));
    return $input_field.val();
}

CX_EVENT_SUBMISSION_FORM_HELPER.prototype.getEventDatesValues = function () {
    var fields = jQuery('.input-cx-event-dates').find('input[type="text"]');
    var dates = [];
    for (var index = 0; index < fields.length; index++) {
        dates.push(fields[index].value);
    }
    return dates;
}

CX_EVENT_SUBMISSION_FORM_HELPER.prototype.getCheckboxesValues = function (field_class) {
    var fields = jQuery('.input-' + field_class).find('input:checked');
    var values = [];
    for (var index = 0; index < fields.length; index++) {
        values.push(fields[index].value);
    }
    return values;
}

CX_EVENT_SUBMISSION_FORM_HELPER.prototype.getEventPlan = function(){
    return jQuery('.cx-input-event-plan').find('input:checked').val().toLowerCase();
}

CX_EVENT_SUBMISSION_FORM_HELPER.prototype.handleEventDatePickerSelection = function($elem, index){
    if ( index === 0 ){

        // for our first date picker, restrict pass dates from today
        var input = $elem.prev();
        jQuery(input).datepicker('option', 'beforeShow', function(dpInput, dpInstance){
            return { minDate: 0 };
        });
    }else{

        // for the rest datepicker, restrict dates based on the previous selected date
        var input = $elem.prev();
        jQuery(input).datepicker('option', 'beforeShow', function(dpInput, dpInstance){
            var prevContainer = jQuery(dpInput).parent().parent().prev();
            var prevInput = jQuery(prevContainer).find('input.datepicker_with_icon');
            var prevSelectedDate = jQuery(prevInput).datepicker('getDate');
            var prevDate = new Date(prevSelectedDate);
            var dateMin = new Date(prevDate.getFullYear(), prevDate.getMonth(), prevDate.getDate() + 1);
            return { minDate: dateMin };
        });
    }
    $elem.attr('data-binded','yes');
}
CX_EVENT_SUBMISSION_FORM_HELPER.prototype.validateAddRowTarget = function(target){
    if(jQuery(target).hasClass('add_list_item')){
        return true;
    }

    if(target.nodeName==='IMG'){
        var parent = jQuery(target).parent();
        if(jQuery(parent).hasClass('add_list_item')){
            return true;
        }
    }

    return false;
}
CX_EVENT_SUBMISSION_FORM_HELPER.prototype.bindEventDatePickerEvents = function () {
    // self helper reference
    var self = this;

    // check if we are in our event dates list field
    var defaultPicker = jQuery('.input-cx-event-dates .ui-datepicker-trigger');
    if(defaultPicker.length>0){
        // bind our first element
        this.handleEventDatePickerSelection(jQuery(defaultPicker[0]), 0);

        // since our datepicker has a greater z-index, we need to listen for document click
        jQuery(document).on('click', function(evt){
            
            // validate if we added a new date picker in the list
            if ( self.validateAddRowTarget(evt.target) ){
                
                evt.stopImmediatePropagation();

                // iterate over the pickers and bind our click handler event
                var pickers =  jQuery('.ui-datepicker-trigger');
                for(var index=0; index < pickers.length; index++){
                    if(!pickers[index].hasAttribute('data-binded')){
                        self.handleEventDatePickerSelection(jQuery(pickers[index]), index);
                    }
                }
            }
        });
    }
}

CX_EVENT_SUBMISSION_FORM_HELPER.prototype.bindFileUploadEvents = function(){
    var fields = jQuery('.input-cx-file-field input[type="file"]');
    if(fields.length>0){
        for(var index=0; index<fields.length; index++){
            var $fileField = jQuery(fields[index]);
            $fileField.on('change', function(evt){
                var fileName = evt.target.files[0].name;
                var previewSpan = jQuery(this).parent().next().find('.preview-file-name');
                if(previewSpan.length>0){
                    jQuery(previewSpan).html(fileName);
                }

            });
        }
    }
}

// Show or hide the intro text
CX_EVENT_SUBMISSION_FORM_HELPER.prototype.handleIntroText = function(current_page){
    if(this.ALREADY_LOADED){
        if(current_page==1){
            jQuery('.inner-event-submission-form-section > .intro').show();
        }else{
            jQuery('.inner-event-submission-form-section > .intro').hide();
        }
        setTimeout(function(){
            jQuery.scrollTo('#cx-event-submission-form', 800);
        }, 200);
    }else{
        this.ALREADY_LOADED = true;
    }
}

CX_EVENT_SUBMISSION_FORM_HELPER.prototype.handleSelectColorChange = function(){
    jQuery('.gfield_select').on('change', function(){
        if(this.selectedIndex==0){
            jQuery(this).removeClass('option-selected');
        }else{
            jQuery(this).addClass('option-selected');
        }
    });
}

var cxSubmissionHelper = new CX_EVENT_SUBMISSION_FORM_HELPER();

jQuery(document).on('gform_post_render', function (event, form_id, current_page) {

    // check if we are in the event submission page
    // and our multi-step form is present
    if (cxSubmissionHelper.isFormPresent(form_id)) {

        // Intro text should only be visible in the first step
        cxSubmissionHelper.handleIntroText(current_page);

        // update our green bar with the current page / step
        cxSubmissionHelper.updateStepIndicator(current_page);

        // update our step label
        cxSubmissionHelper.updateStepLabel(current_page);

        cxSubmissionHelper.bindEventDatePickerEvents();

        cxSubmissionHelper.handleSelectColorChange();

        cxSubmissionHelper.bindFileUploadEvents();

        // display the preview if we are on the last page
        if (cxSubmissionHelper.isLastPage(current_page)) {
            cxSubmissionHelper.generatePreview();
        }

        if(typeof current_page === 'undefined' ){
            jQuery('.gform-required-fields-msg').hide();
        }else{
            jQuery('.gform-required-fields-msg').show();
        }
    }
});