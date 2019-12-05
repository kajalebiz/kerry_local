jQuery(document).ready(function () {
    jQuery('.cx-event-modal-trigger').modaal({
        custom_class: 'cx-event-details-modal',
        after_open: function () {
            if (jQuery(window).width() < 900) {
                jQuery('#' + this.scope.id).css('padding-top', '20vh');
            }else{
                jQuery('#' + this.scope.id).css('padding-top', '15vh');
            }
        },
    });

    jQuery('.cx-event-modal').on('click', function (e) {
        e.preventDefault();
        var selector = jQuery(this).attr('data-cx-event');
        var elem = jQuery('a[data-trigger-id="' + selector + '"]');
        elem.trigger('click');
    });
});