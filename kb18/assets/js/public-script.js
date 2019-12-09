jQuery(document).ready(function ($){
    
    jQuery(document).on('click','.popup-learn-link',function(){
        setTimeout(function(){ 
            console.log('in');
            jQuery('#popmake-9414').popmake('close');
        }, 100);
    });
    
    jQuery(document).on('click','.woocommerce-remove-coupon',function(){
        coupon_code = jQuery(this).attr('data-coupon');
        setTimeout(function(){ 
            html = jQuery('.woocommerce-notices-wrapper .woocommerce-message').html();
            jQuery('.woocommerce-notices-wrapper .woocommerce-message').html('Promo code &ldquo;'+ coupon_code +'&rdquo; has been removed.');
        }, 1500);
    });
    
    jQuery(document).find('.woocommerce-Input[name=password_1]').after('<p id="woocommerce-Input-pass"></p>');
    jQuery(document).on('keyup', '.woocommerce-Input[name=password_1]', function(){
        var pass_val = jQuery(this).val();
        var check_flag = checkPasswordStrength(pass_val);
        if( check_flag == true ){
            jQuery(document).find('.woocommerce-Button[name=save_account_details]').removeAttr('disabled').removeClass( 'disabled' );
        }else{
            jQuery(document).find('.woocommerce-Button[name=save_account_details]').attr( 'disabled', 'disabled' ).addClass( 'disabled' );
        }
    });
    jQuery(document).find('.woocommerce-Input#reg_password').after('<p id="woocommerce-Input-pass"></p>');
    jQuery(document).on('keyup', '.woocommerce-Input#reg_password', function(){
        var pass_val = jQuery(this).val();
        var check_flag = checkPasswordStrength(pass_val);
        if( check_flag == true ){
            jQuery(document).find('.woocommerce-Button[name=register]').removeAttr('disabled').removeClass( 'disabled' );
        }else{
            jQuery(document).find('.woocommerce-Button[name=register]').attr( 'disabled', 'disabled' ).addClass( 'disabled' );
        }
    });
    jQuery(document).find('#account_password').after('<p id="woocommerce-Input-pass"></p>');
    jQuery(document).on('keyup', '#account_password', function(){
        var pass_val = jQuery(this).val();
        var check_flag = checkPasswordStrength(pass_val);
        if( check_flag == true ){
            jQuery("[for=account_password]").css("color","#58595B");
            jQuery(this).css("border-color", "#6dc22e");
            jQuery(document).find('#place_order').removeAttr('disabled').removeClass( 'disabled' );
        }else{
            jQuery("[for=account_password]").css("color","#D92731");
            jQuery(this).css("border-color", "#D92731");
            jQuery(document).find('#place_order').attr( 'disabled', 'disabled' ).addClass( 'disabled' );
        }
    });
       
//    if( jQuery('#ent-mem').length > 0 ){
//        jQuery( "#ent-mem .acf-form-submit input" ).attr('disabled','disabled');
//        jQuery('#ent-mem').find('input[type=checkbox]').click(function(){
//            if($(this).prop("checked") == true){
//                jQuery( "#ent-mem .acf-form-submit input" ).removeAttr('disabled');
//            }
//            else if($(this).prop("checked") == false){
//                jQuery( "#ent-mem .acf-form-submit input" ).attr('disabled','disabled');
//            }
//        });
//    }    
    if( jQuery('.site_above_header').length  == 0 ){
        jQuery(document).find('body').addClass('no_blue_bar');
    }
    jQuery('.acf-field-5dea4adaad484').hide();
    jQuery('.acf-field-5dea4a9aad482').hide();
    if(jQuery(".site_above_header").length > 0 ){
        jQuery(".site-header").prepend(jQuery(".site_above_header"));
//        jQuery(".site_above_header").insertBefore(".site-header .wrap:first-child");
    }    
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

if(jQuery('.subscription_quantity').length  > 0){
    jQuery('input[name ="quantity"]').on('change',function () {
        $init_val = parseFloat(jQuery(document).find('.green_title').attr('data-value'));
        $quantity = parseFloat(this.value);
        $final_val = parseFloat($init_val * $quantity).toFixed(2);
        jQuery(document).find('.green_title').html('$'+$final_val);
        if(this.value == 1){
            jQuery('.subscription_quantity .subscription_quantity_text').html('CX Pro Subscription');
        }else{
            jQuery('.subscription_quantity .subscription_quantity_text').html('CX Pro Subscriptions');
        }
    });
}

jQuery(window).load(function() {
  equalheight('.resources_block .grid-block');
  equalheight('.front_blogs .two-grid__post-block__title');
  equalheight('.end_sale .offer_bx .content_bx .bx_group');
});

jQuery(window).resize(function(){
  equalheight('.resources_block .grid-block');
  equalheight('.front_blogs .two-grid__post-block__title');
  equalheight('.end_sale .offer_bx .content_bx .bx_group');
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

function checkPasswordStrength(pass_val) {
    var flag = false; 
    var number = /([0-9])/;
    var alphabets = /([a-zA-Z])/;
    var special_characters = /([~,!,@,#,$,%,^,&,*,-,_,+,=,?,>,<])/;
    if (pass_val.length < 8) {
        jQuery('#woocommerce-Input-pass').removeClass();
        jQuery('#woocommerce-Input-pass').addClass('weak-password');
        jQuery('#woocommerce-Input-pass').html("Minimum 8 characters.");
        flag = false;
    } else {
        jQuery('#woocommerce-Input-pass').removeClass();
        jQuery('#woocommerce-Input-pass').addClass('strong-password');
        jQuery('#woocommerce-Input-pass').html("");
        flag = true;
//        if (pass_val.match(number) && pass_val.match(alphabets) && pass_val.match(special_characters)) {
//            jQuery('#woocommerce-Input-pass').removeClass();
//            jQuery('#woocommerce-Input-pass').addClass('strong-password');
//            jQuery('#woocommerce-Input-pass').html("Strong");
//            flag = true;
//        } else {
//            jQuery('#woocommerce-Input-pass').removeClass();
//            jQuery('#woocommerce-Input-pass').addClass('medium-password');
//            jQuery('#woocommerce-Input-pass').html("Medium (should include alphabets, numbers and special characters.)");
//        }
    }
    return flag;
//    console.log(flag);
    
    }
