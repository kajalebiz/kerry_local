jQuery(document).ready(function () {
    jQuery('#event-list__month, #event-list__type').on('change', function () {
        var month = jQuery('#event-list__month').val();
        var type = jQuery('#event-list__type').val();
        var type_class = type === 'all' ? '' : '.' + type;
        var month_class = month === 'all' ? '' : '.' + month;
        var classString = type_class + month_class;

        if (month === 'all' && type === 'all') {
            jQuery('.event-list-item').slideDown();
            jQuery('.filter-reset').fadeOut();
        } else {
            jQuery('.filter-reset').fadeIn();
            jQuery('.event-list-item:not(' + classString + ')').slideUp();
            jQuery('.event-list-item' + classString).slideDown();
        }
        //check if no events are shown and show a message if so
        if (jQuery('.event-list-item' + classString).length > 0) {
            jQuery('.event-list-section .inner-event-list-section .no-events-shown-message').hide()
        } else {
            jQuery('.event-list-section .inner-event-list-section .no-events-shown-message').show();
        }
    });
    // jQuery('.filter-reset').on('click', function () {
    //     location.href='/events/';
    // });
    jQuery('.filter-reset').on('click', function () {
        jQuery('#event-list__type, #event-list__month').val('all');
        jQuery('.event-list-section .inner-event-list-section .no-events-shown-message').hide();
        jQuery('.event-list-item').slideDown();
        jQuery(this).fadeOut();
    });
});