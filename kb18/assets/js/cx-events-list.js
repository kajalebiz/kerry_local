jQuery(document).ready(function(){
    jQuery('.cx-event-modal-trigger').modaal({
        custom_class: 'cx-event-details-modal'
    });
    
    jQuery('.cx-event-modal').on('click', function(e){
        e.preventDefault();
        e.stopPropagation();
        var selector = jQuery(this).attr('data-cx-event');
        var elem = jQuery('a[data-trigger-id="'+ selector +'"]');
        elem.trigger('click');
    });
});