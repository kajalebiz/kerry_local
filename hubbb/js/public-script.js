/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

jQuery( document ).ready( function($) {
    window.scrollTo(0,0);
    jQuery(".section-content").find("ol").each(function () {
        var start = jQuery(this).attr("start");
        if(typeof start === "undefined") {
            jQuery(this).addClass("withoutstart");
        } else{
            jQuery(this).addClass("withstart");
        }        
    });
   
    // menu jQuery
    jQuery('.main-menu li.menu-item-has-children > a').after('<a class="child-triggerm"><span></span></a>');  
    jQuery('.main-menu li').click(function() {
      jQuery(this).siblings('li').find('a.child-triggerm').removeClass('child-open');
      jQuery(this).siblings('li').find('ul').slideUp(250);
      jQuery(this).find('a.child-triggerm').next('ul').slideToggle(250);
      jQuery(this).find('a.child-triggerm').toggleClass('child-open');
      return false;
    });

    // jQuery('.main-menu li:first-child .child-triggerm').addClass('child-open');
    // jQuery('.main-menu li:first-child ul.sub-menu').slideDown();
    
    var head_height = jQuery('.main-header').outerHeight();
    var tab_titles_height = jQuery('.tab-titles').outerHeight();
    var sum_header = head_height + tab_titles_height;

    // on click scroll to id
    jQuery('.sidebar-list a[href*="#"]').on('click', function(e) {
      jQuery('body').addClass('jump_to_section');
      var url     = jQuery(this).attr('href');
      var hasid  = url.substring(url.indexOf('#'));
      if (jQuery('.main-header').hasClass('scrolled')) {
        var head_height = jQuery('.main-header').outerHeight();
      }else{
        var head_height = jQuery('.main-header').outerHeight() - 20 ;
      }
      
      var tab_titles_height = jQuery('.tab-titles').outerHeight();
      var sum_header = head_height + tab_titles_height;

      if( jQuery(hasid).length > 0 ){
        e.preventDefault();
        jQuery('html, body').animate({
            scrollTop: jQuery(hasid).offset().top - head_height - tab_titles_height,
        },500,function(){
            setTimeout(function(){
                jQuery('body').removeClass('jump_to_section');
            },150);   
        });
      }
    });

    var window_height = jQuery( window ).height();
    var set_side_height = window_height - sum_header;

    jQuery('.right-sidebar').css({"top": sum_header , "height" : set_side_height - 50 });
    jQuery('.section-content').find("table").wrap( "<div class='table-responsive'></div>" );
  
    // Cache selectors
    var topMenu = jQuery(".main-menu"),
        //topMenuHeight = topMenu.outerHeight()+15,
    // All list items
    menuItems = topMenu.find("a"),
    // Anchors corresponding to menu items
    scrollItems = menuItems.map(function(){
      var item = jQuery(jQuery(this).attr("href"));
      if (item.length) { return item; }
    });

    var position = $(window).scrollTop(); 

    jQuery(window).scroll(function() {
        
      var head_height = jQuery('.main-header').outerHeight();
      var tab_titles_height = jQuery('.tab-titles').outerHeight();
      var sum_header = head_height + tab_titles_height;

      // Bind to scroll
      // Get container scroll position
      var fromTop = jQuery(this).scrollTop() + sum_header + 35;
      // Get id of current scroll item
      var cur = scrollItems.map(function(){
        if (jQuery(this).offset().top < fromTop)
          return this;
      });
      // Get the id of the current element
      cur = cur[cur.length-1];
      var id = cur && cur.length ? cur[0].id : "";
      // Set/remove active class
      
      var scroll = $(window).scrollTop();

        if(jQuery('body').hasClass('jump_to_section'))
        {
           // menuItems.parent().removeClass("active").end().filter("[href='#"+id+"']").parent().addClass("active");
           // jQuery(".main-menu > li").not('.active').find(".sub-menu").slideUp();
           // jQuery(".main-menu > li.active").find(".sub-menu").slideDown();
           // jQuery('.main-menu > li.active .child-triggerm').addClass('child-open');

        }else{
            if(!menuItems.filter("[href='#"+id+"']").parent().parent('ul').hasClass('sub-menu')){
                menuItems.parent().removeClass("active").end().filter("[href='#"+id+"']").parent().addClass("active");                
            }else{
                menuItems.filter("[href='#"+id+"']").parents('ul.sub-menu').find('li').removeClass("active");
                menuItems.filter("[href='#"+id+"']").parent().addClass('active');
            }

            // jQuery(".main-menu > li").not('.active').find(".sub-menu").slideUp();
            // jQuery(".main-menu > li").not('.active').find(".child-triggerm").removeClass('child-open');
            // jQuery(".main-menu > li.active").find(".sub-menu").slideDown();
            // jQuery('.main-menu > li.active .child-triggerm').addClass('child-open');

            // jQuery('.main-menu > li').each(function(){
            //   var $this = jQuery(this);
            //   if(jQuery(this).find('li').hasClass('active')){
            //     $this.find('.sub-menu').slideDown(); 
            //   }else{
            //     $this.find('.sub-menu').slideUp();
            //   }              
            // });

            if(scroll > position) {
              console.log('scrollDown');
              //$('div').text('Scrolling Down Scripts');
              jQuery(".main-menu > li").not('.active').find(".sub-menu").slideUp();
              jQuery(".main-menu > li").not('.active').find(".child-triggerm").removeClass('child-open');
              jQuery(".main-menu > li.active").find(".sub-menu").slideDown();
              jQuery('.main-menu > li.active .child-triggerm').addClass('child-open');
            } else {
              console.log('scrollUp');
              jQuery('.main-menu > li').each(function(){
                var $this = jQuery(this);
                if(jQuery(this).find('li').hasClass('active')){
                  $this.find('.sub-menu').slideDown();
                  // jQuery(".main-menu > li").find(".child-triggerm").removeClass('child-open');
                  $this.find('.child-triggerm').addClass('child-open');
                  // console.log($this);
                }else{
                  console.log("in");
                  $this.find('.sub-menu').slideUp();
                  jQuery(".main-menu > li.active").find(".child-triggerm").removeClass('child-open');
                }              
              });
            }
            position = scroll;
        }

    });
});

jQuery(window).scroll(function() {
  var scroll =jQuery(window).scrollTop();
  if ( scroll > 50) {
    jQuery('.main-header').addClass('scrolled');
  }else{
    jQuery('.main-header').removeClass('scrolled');
  }
});

jQuery(window).resize(function() {
  var head_height = jQuery('.main-header').outerHeight();
  var tab_titles_height = jQuery('.tab-titles').outerHeight();
  var sum_header = head_height + tab_titles_height;

  jQuery('.right-sidebar').css('top', sum_header );

  var window_height = jQuery( window ).height();    
  var set_side_height = window_height - sum_header;

  jQuery('.right-sidebar').css({"top": sum_header , "height" : set_side_height - 50 });

});

jQuery(window).load(function() {

  window.scrollTo(0,0);
  var head_height = jQuery('.main-header').outerHeight();
  var tab_titles_height = jQuery('.tab-titles').outerHeight();

  var sum_header = head_height + tab_titles_height;  
  if(window.location.hash) {
      var hash = window.location.hash.substring(1);

      if( jQuery('#'+hash).length > 0 ){    
        jQuery('html, body').animate({
            scrollTop: jQuery('#'+hash).offset().top - sum_header 
        },700);
      }
  }
  setTimeout(
  function() { 
    var window_height = jQuery( window ).height();   
    var sum_header = head_height + tab_titles_height;
    var set_side_height = window_height - sum_header;
    jQuery('.right-sidebar').css({"top": sum_header , "height" : set_side_height - 50 });
  }, 1000);
});