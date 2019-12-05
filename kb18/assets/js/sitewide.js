var scrollSectionTopAdjustment = 100;

// SiteHeader add a scrolling class and calculate for absolute position.
var scrollCheck = function(jqueryElements) {
  if (jQuery(window).scrollTop() >= 40) {
    jqueryElements.not('.scrolled').addClass('scrolled').end().filter('.unscrolled').removeClass('unscrolled');
  } else {
    jqueryElements.not('.unscrolled').addClass('unscrolled').end().filter('.scrolled').removeClass('scrolled');
  }
};

var jumpNavCheck = function() {
  if (window.innerWidth > 600) {
    var jumpNav = jQuery('.site-inner > section.jump-nav');
    var jumpNavCloned = jQuery('header.site-header > section.jump-nav');

    if (jumpNav.length && !jumpNavCloned.length) {
      var windowTop = jQuery(window).scrollTop();
      var jumpNavOffset = jumpNav.offset().top;
      if (windowTop - jumpNavOffset >= 0) {
        jQuery('.site-header > .wrap').hide();
        jQuery('.site-inner > .jump-nav')
          .clone(true)
          .appendTo('.site-header');
      }
    }

    if (jumpNav.length && jumpNavCloned.length) {
      var windowTop = jQuery(window).scrollTop();
      var jumpNavOffset = jumpNav.offset().top;
      if (windowTop - jumpNavOffset < 0) {
        jQuery('.site-header > .wrap').show();
        jumpNavCloned.remove();
      }
    }
  }
};

var arrayifyHTMLCollection = function(collection) {
  return [].slice.call(collection);
};

var scrollingTabs = function(scrollingTabsElements) {
  var header = scrollingTabsElements['header'];
  var admin = scrollingTabsElements['admin'];
  var headerHeight = header.length ? header.height() : 0;
  var adminHeight = admin.length ? admin.height() : 0;
  var fixedDistanceFromTop = headerHeight + adminHeight + scrollSectionTopAdjustment;

  scrollingTabsElements['tabsWraps'].map(function(object) {

    var wrap = object['wrap'];
    var leftInner = object['leftInner'];
    var leftOuter = object['leftOuter'];
    var leftTitles = object['leftTitles'];
    var rightTabs = object['rightTabs'];
    var rightBlurbs = object['rightBlurbs'];
    var tabsAndTitles = object['tabsAndTitles'];

    var wrapRect = wrap.getBoundingClientRect();
    var leftInnerRect = leftInner.getBoundingClientRect();
    var beforeSection = wrapRect.top >= fixedDistanceFromTop;
    var afterSection = wrapRect.bottom < leftInnerRect.height + fixedDistanceFromTop;

    if (beforeSection || afterSection) {
      leftInner.style.cssText = 'max-width:' + leftOuter.clientWidth + 'px;';

      if (beforeSection && !wrap.classList.contains('before')) {
        wrap.classList.add('before');
      } else if (afterSection && !wrap.classList.contains('after')) {
        wrap.classList.add('after');
      }
    } else {
      // in section
      var activeIndex = leftTitles.findIndex(function(el) {
        return el.classList.contains('active');
      });
      var indexToActivate = rightBlurbs.findIndex(function(blurb, index) {
        // below checks if the bottom of the title has passed the top of the tab blurb
        return (
          leftTitles[index].getBoundingClientRect().bottom >
          blurb.getBoundingClientRect().top
        );
      });

      if (activeIndex !== indexToActivate) {
        tabsAndTitles.filter(function(el) {
            return el.classList.contains('active');
          }) // filter down to only elements with active class
          .map(function(el) {
            el.classList.remove('active');
        }); //remove active class

        window.requestAnimationFrame(function(){
          rightTabs[indexToActivate].classList.add('active');
          leftTitles[indexToActivate].classList.add('active');
        });
      }

      if (leftInner.style.position !== 'fixed') {
        window.requestAnimationFrame(function(){
          wrap.classList.remove('before', 'after');
          leftInner.style.top = fixedDistanceFromTop + 'px';
          leftInner.style.maxWidth = '' + leftOuter.clientWidth + 'px';
          leftInner.style.position = 'fixed';
        });
      }
    }
  });
};

jQuery(document).ready(function() {

  // Initialize Mobile Menu
  MobileMenu.init();

  // Initialize accessible menus
  jQuery(document).gamajoAccessibleMenu();

  var header = jQuery('.site-header');
  var admin = jQuery('#wpadminbar');

  // in effort to optimize the scroll functions I'm preparing these 
  // elements ahead of time so they don't need to get called each time.
  var getTabsWrapsImportantElements = function( wrap ) {
    var leftInner = wrap.getElementsByClassName('tabs-left__inner')[0];
    var leftOuter = leftInner.parentElement;
    var rightTabs = arrayifyHTMLCollection( wrap.getElementsByClassName('tabs-right__tab') ).reverse(); //arrays are reversed to find the last item that satisfies the condition
    var leftTitles = arrayifyHTMLCollection( leftInner.children ).reverse(); //arrays are reversed to find the last item that satisfies the condition
    var rightBlurbs = rightTabs.map(function(tab){
      return tab.querySelector('.tabs-right__blurb')
    })
    return {
      wrap: wrap,
      leftInner: leftInner,
      leftOuter: leftOuter,
      rightTabs: rightTabs,
      leftTitles: leftTitles,
      rightBlurbs: rightBlurbs,
      tabsAndTitles: rightTabs.concat(leftTitles)
    }
  }

  var scrollingTabsElements = {
    header: header,
    admin: admin,
    tabsWraps: arrayifyHTMLCollection(document.getElementsByClassName('tabs-wrap')).map(getTabsWrapsImportantElements)
  }

  var scrollCheckSelectors = [
    '.site-header',
    '.site-title a',
    '.obj-mega-menu__hover-outer',
    '.top-page-arrow'
  ].join(', ');
  var scrollCheckElements = jQuery(scrollCheckSelectors);

  // Perform the header scroll check
  scrollCheck(scrollCheckElements);
  jumpNavCheck();

  jQuery(window).scroll(function() {
    scrollCheck(scrollCheckElements);
    jumpNavCheck();
    if (window.innerWidth > 899) {
      scrollingTabs(scrollingTabsElements);
    }
  });

  // Check to see if menu goes outside of container,
  // if it does we'll move it back into view
  // Genesis Menu
  jQuery('.genesis-nav-menu .menu-item').on('mouseenter mouseleave', function(e) {
    if (jQuery(this).find('.sub-menu').length) {
      var elm = jQuery(this).children('.sub-menu');
      var off = elm.offset();
      var l = off.left;
      var w = elm.width();
      var docW = jQuery('body').width();

      var isEntirelyVisible = l + w <= docW;

      if (!isEntirelyVisible) {
        jQuery(this)
          .children('.sub-menu')
          .addClass('edge');
      } else {
        jQuery(this)
          .children('.sub-menu')
          .removeClass('edge');
      }
    }
  });

  // Check to see if menu goes outside of container,
  // if it does we'll move it back into view
  // OBJ Menu
  jQuery('.obj-menu__top-item').on('mouseenter mouseleave', function(e) {
    if (jQuery(this).find('.obj-menu__top-item__sub-menu').length) {
      var elm = jQuery(this).children('.obj-menu__top-item__sub-menu');
      var off = elm.offset();
      var l = off.left;
      var w = elm.width();
      var docW = jQuery('body').width();

      var isEntirelyVisible = l + w <= docW;

      if (!isEntirelyVisible) {
        jQuery(this)
          .children('.obj-menu__top-item__sub-menu')
          .addClass('edge');
      } else {
        jQuery(this)
          .children('.obj-menu__top-item__sub-menu')
          .removeClass('edge');
      }
    }
  });

  // Simply Smooth scrolling - just link to an id.
  jQuery('a[href^="#"]').on('click', function(event) {
    var headerHeight = header.length ? header.height() : 0;
    var adminHeight = admin.length ? admin.height() : 0;
    var target = jQuery(this.getAttribute('href'));
    if (target.length) {
      event.preventDefault();
      jQuery('html, body')
        .stop()
        .animate(
          {
            scrollTop: target.offset().top - headerHeight - adminHeight
          },
          1000
        );
    }
  });

  jQuery('.angled-slider-wrap').each(function() {
    var slickAngledIndividual = jQuery(this);
    var angledParent = jQuery(this).parents('.angled-slider-outer-wrap');
    var dotsDiv = angledParent.find('.angled-slider__dots-inner');

    slickAngledIndividual.slick({
      arrows: false,
      autoplay: true,
      autoplaySpeed: 7000,
      fade: true,
      dots: this.dataset.useDots === 'true',
      appendDots: dotsDiv,
      cssEase: 'linear'
    });

    var sliderBlocks = jQuery(this).find('.angled-slide__block');
    var sliderBlockHeight = 0;

    sliderBlocks.each(function() {
      var block = jQuery(this);
      var bHeight = block.height();

      if (bHeight > sliderBlockHeight) {
        sliderBlockHeight = bHeight;
      }
    });

    if (sliderBlockHeight > 0) {
      sliderBlocks.css('min-height', sliderBlockHeight);
      sliderBlocks.css('max-height', sliderBlockHeight);
    }
  });

  jQuery('.tabs-left__title h3').on('click', function(event) {
    const title = event.target;
    const titleContainer = title.parentElement;
    const tabsLeftInner = titleContainer.parentElement;
    const titleContainers = arrayifyHTMLCollection(tabsLeftInner.children);
    const titleContainerIndex = titleContainers.indexOf(titleContainer); //selected title's index amongst its siblings
    const tabsLeft = tabsLeftInner.parentElement;
    const tabsWrap = tabsLeft.parentElement;
    const rightTabs = tabsWrap.getElementsByClassName('tabs-right__tab');
    const correspondingTab = rightTabs.item(titleContainerIndex);

    const header = jQuery('.site-header');
    const admin = jQuery('#wpadminbar');
    const headerHeight = header.length ? header.height() : 0;
    const adminHeight = admin.length ? admin.height() : 0;
    const topSpace = headerHeight + adminHeight + scrollSectionTopAdjustment;

    const siteContainer = document.querySelector('.site-container');
    const siteContainerStyle = window.getComputedStyle(siteContainer);        // Body element is position: relative so site-container
    const siteContainerMarginTop = parseInt(siteContainerStyle['marginTop']); // margin is counted in addition to the body position.
    const bodyRectTop = document.body.getBoundingClientRect().top;
    const currentPosition = -1 * bodyRectTop + siteContainerMarginTop;
    const titleTop = title.getBoundingClientRect().top;
    const titleInnerTop = tabsLeftInner.getBoundingClientRect().top;
    const blurb = correspondingTab.querySelector('.tabs-right__blurb');
    const blurbTop = blurb.getBoundingClientRect().top;
    
    const coordAddends = [
      currentPosition,
      blurbTop,
      titleInnerTop,
      -1 * titleTop,
      -1 * topSpace
    ]

    const sum = function(acc, val) {
      return acc + val;
    }

    const coords = coordAddends.reduce(sum, 0);

    jQuery('html, body').stop().animate({ scrollTop: coords }, 400);
  });

// Update WooCommerce cart menu items when cart is updated via AJAX (wc_fragments)
  // @todo: Include amount in desktop menu item tooltip?
  // @todo: Include quantity in mobile menu item?
  jQuery( document.body ).on( 'updated_cart_totals', function() {

    var qty = jQuery('.product-quantity input').attr('value');
    // console.log( qty );
    jQuery('.icon-cart__counter').html( qty );

    var amt = jQuery('.cart-subtotal .woocommerce-Price-amount.amount');
    // console.log( amt );
    jQuery('.icon-cart__amount').html( amt );

  });


  // Initialize Lazyload
  var lazyLoadInstance = new LazyLoad({
    elements_selector: ".lazy"
  });

  function initalize_resources_filter() {

    // var limit = 3;
    // var has_run = false;
    // @todo: use 0 and ajax to show first set of resources

    var $container = jQuery('.resources-grid'),
        $checkboxes = jQuery('.resource-filter input'),
        $alert = jQuery('.resources-grid__alert'),
        $alertButton = jQuery('.resources-grid__alert-button'),
        $loadMore = jQuery('.resources-grid__load-more');


    if ( $container.length ) {

      $container.isotope({
        itemSelector: '.resources-grid__item-wrapper',
        layoutMode: 'fitRows',
        fitRows: {
          gutter: 0
        }
      });
      
      $checkboxes.change(function(){
        var filters = [];
        // get checked checkboxes values
        $checkboxes.filter(':checked').each(function(){
          filters.push( this.value );
        });
        filters = filters.join(', ');

        // Limit results
        // filters.slice(0, limit);
        // console.log(filters);

        // console.log( filters );
        $container.isotope({ filter: filters });

        // Display message box if no filtered items
        if ( !$container.data('isotope').filteredItems.length ) {
          $alert.show();
        } else {
          $alert.hide();
        }

      });

      // Remove checked filters
      $alertButton.on('click', function(e) {
        $checkboxes.attr('checked', false).change();
      });

      // // AJAX load more resources
      // $loadMore.on('click', function(e) {

      //   e.preventDefault();

        // var nonce = jQuery(this).data('nonce');
        // var offset = jQuery(this).data('offset');
        // var ajax_url = window.data.ajaxurl;
        // var button = jQuery(this);

        // // Disable load more button
        // button.attr( 'disabled' , true );
        // button.html('Loading...');

        // // Set initial offset
        // if ( typeof init_offset == 'undefined' ) {
        //   init_offset = offset;
        // }

        // var data = {
        //   action: 'kb_load_more_ajax',
        //   init_offset: init_offset,
        //   offset: offset,
        //   nonce: nonce
        // }

        // jQuery.post(ajax_url, data, function(response) {

        //   var response = JSON.parse(response);
        //   // console.log(response);

        //   jQuery.each(response, function(key, value) {
        //     var val = jQuery(value);
        //     // var container = 

        //     $container.append(val).isotope( 'appended', val );
        //   });

        //   // Undo disabled button
        //   button.attr('disabled', false );
        //   button.html('Load more');

        //   // Set offset
        //   var current_offset = button.attr('offset');
        //   offset = init_offset + current_offset;
        //   button.attr('data-offset', new_offset );

        //   // If it has run
        //   has_run = true;

        //   return false;

        // });

      // });

      // Initialize resources
      // $loadMore.click();
  
    }
      
  }
  initalize_resources_filter();

  jQuery('.video-modaal').modaal({
    type: 'video',
    after_open: function(wraps) {
      wraps[0].addEventListener('click', function(event) {
        if (event.target.classList.contains('modaal-video-wrap')) {
          jQuery('.video-modaal').modaal('close');
        }
      });
    }
  });

  jQuery('.top-page-arrow').on('click', function(e) {
    jQuery('html, body')
      .stop()
      .animate(
        {
          scrollTop: 0
        },
        1000
      );
  });

  function sliderize() {
    jQuery(this).slick({
      arrows: false,
      autoplay: true,
      dots: this.children.length > 1,
      autoplaySpeed: 7000
    });
  }

  // Slider for testimonials
  jQuery('.testimonial-slider__outer').each(sliderize);

  // Slider for featured resources
  jQuery('.featured-resource__slider').each(function(){
    jQuery(this).slick({
      arrows: false,
      autoplay: true,
      dots: this.children.length > 1,
      autoplaySpeed: 7000,
      fade: true,
    }).hide().fadeIn();
  });

  // Event Details Slider
  jQuery('.event-preview-slider').slick({
    arrows: false,
    autoplay: true,
    dots: true,
    autoplaySpeed: 7000,
    fade: true,
    responsive: [
      {
        breakpoint: 900,
        settings: 'unslick'
      }
    ]
  }).on('init', function(){
    scrollingTabs(scrollingTabsElements);
  }).on('reInit', function(){
    scrollingTabs(scrollingTabsElements);
  });

  function reSlickIfNecessary() {
    if (window.innerWidth > 899) {
      jQuery('.event-preview-slider').not('.slick-initialized').slick({
        arrows: false,
        autoplay: true,
        dots: true,
        autoplaySpeed: 7000,
        fade: true,
        responsive: [
          {
            breakpoint: 900,
            settings: 'unslick'
          }
        ]
      });
    }
  }

  window.addEventListener('resize', reSlickIfNecessary);

  function accordionClickHandler(event){
    const header = jQuery('.site-header');
    const admin = jQuery('#wpadminbar');
    const headerHeight = header.length ? header.height() : 0;
    const adminHeight = admin.length ? admin.height() : 0;

    if ( event.currentTarget.classList.contains('closed') ) {
      closeAllAccordionTabs();
      event.currentTarget.classList.remove('closed');
      jQuery(event.currentTarget).nextAll().stop().slideDown();

      const scrollTo = function( eventCurrentTarget ){
        jQuery('html, body').stop().animate( { scrollTop: jQuery(eventCurrentTarget).offset().top - headerHeight - adminHeight }, 400 );
      }

      setTimeout(scrollTo, 400, event.currentTarget); 
    } else {
      event.currentTarget.classList.add('closed');
      jQuery(event.currentTarget).nextAll().stop().slideUp();
    }
  }

  function closeAccordionTab(tab){
    tab.classList.add('closed');
    jQuery(tab).nextAll().stop().slideUp();
  }

  function closeAllAccordionTabs(){ 
    const rightTitles = arrayifyHTMLCollection(document.getElementsByClassName('tabs-right__title'));
    rightTitles.map(closeAccordionTab);
  }

  function removeInlineDisplayProperty(element) {
    element.style.display = '';
  }

  function accordionize(groupsOfTabs, rightTitles) {
    arrayifyHTMLCollection(rightTitles).map(function(el){
      el.classList.add('closed');
      el.addEventListener('click', accordionClickHandler);

      //undo any previous jQuery slideDown
      jQuery(el).nextAll().toArray().map(removeInlineDisplayProperty);
    });

    arrayifyHTMLCollection(groupsOfTabs).map(function(el){
      el.classList.add('accordion');
    });
  }

  function deaccordionize(groupsOfTabs, rightTitles) {
    arrayifyHTMLCollection(rightTitles).map(function(el){
      el.classList.remove('closed');
    });

    arrayifyHTMLCollection(groupsOfTabs).map(function(el){
      el.classList.remove('accordion');
    });
  }

  function accordionizeTabsOnResize(){
    const groupsOfTabs = document.getElementsByClassName('tabs-right');
    const rightTitles  = document.getElementsByClassName('tabs-right__title');

    if (groupsOfTabs.item(0)) {
      const accordioned          = groupsOfTabs.item(0).classList.contains('accordion');
      const needToAccordionize   = window.innerWidth < 900 && ! accordioned;
      const needToDeaccordionize = window.innerWidth > 899 &&   accordioned;

      if (needToAccordionize){
        accordionize(groupsOfTabs, rightTitles);
      } else if (needToDeaccordionize) {
        deaccordionize(groupsOfTabs, rightTitles);
      }
    }
  }
  //initial call on page load;
  accordionizeTabsOnResize();

  window.addEventListener('resize', accordionizeTabsOnResize);
  
  jQuery('#blog-categories-dropdown').change(function selectBlogCategory(
    event
  ) {
    if (!event.target.value) {
      return;
    } else if (event.target.value === '0') {
      window.location.href = 'https://' + window.location.hostname + '/blog';
    } else {
      window.location.href =
        'https://' +
        window.location.hostname +
        '/category/' +
        event.target.value;
    }
  });

  var select = jQuery('.inner-footer-form-cta select');
  select
    .each(function() {
      jQuery(this).addClass(
        jQuery(this)
          .children(':selected')
          .attr('class')
      );
    })
    .on('change', function(ev) {
      jQuery(this)
        .attr('class', '')
        .addClass(
          jQuery(this)
            .children(':selected')
            .attr('class')
        );
    });
});
