jQuery(document).ready(function (){
    jQuery('.be_prepared_listing').on('change','.prepared_co',function (){
        var cookie_name = jQuery(this).attr('data-session'); 
        var visited = jQuery.cookie(cookie_name);
        if ( jQuery(this).is(':checked')) {
            if (visited == 'yes') {
                //return false;
            } else {
                jQuery.cookie(cookie_name, 'yes', {
                    expires: 1000
                });
            }
        }
        else{
            if (visited == 'no') {
                //return false;
            } else {
                jQuery.cookie(cookie_name, 'no', {
                    expires: 1000
                });
            }
        }
    });
    jQuery( ".be_prepared_listing .prepared_co" ).each(function( index ) {
       var cookie_name = jQuery(this).attr('data-session'); 
        var visited = jQuery.cookie(cookie_name);
        if (visited == 'yes') {
            jQuery('.'+cookie_name).trigger('click');
        }
    });


    equalheight('.resources_block .grid-block');
    equalheight('.front_blogs .two-grid__post-block__title');
    jQuery(document).on('gform_confirmation_loaded', function(event, formId){
        if(formId == 2) {
             jQuery(".resource-banner__form-wrap-outer h3.resource-banner__form-title").hide();
        }
    });

});
// jQuery(document).load(function (){
//        console.log('in');
// });

jQuery(window).load(function() {
  equalheight('.resources_block .grid-block');
  equalheight('.front_blogs .two-grid__post-block__title');
});

jQuery(window).resize(function(){
  equalheight('.resources_block .grid-block');
  equalheight('.front_blogs .two-grid__post-block__title');
});

equalheight = function(container){

var currentTallest = 0,
     currentRowStart = 0,
     rowDivs = new Array(),
     $el,
     topPosition = 0;
 jQuery(container).each(function() {

   $el = jQuery(this);
   jQuery($el).height('auto')
   topPostion = $el.position().top;

   if (currentRowStart != topPostion) {
     for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
       rowDivs[currentDiv].height(currentTallest);
     }
     rowDivs.length = 0; // empty the array
     currentRowStart = topPostion;
     currentTallest = $el.height();
     rowDivs.push($el);
   } else {
     rowDivs.push($el);
     currentTallest = (currentTallest < $el.height()) ? ($el.height()) : (currentTallest);
  }
   for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
     rowDivs[currentDiv].height(currentTallest);
   }
 });
}