jQuery(function($) {

  /**
   * Fix dark mode flash.
   */
  $(document).ready(function() {
    $('#fix-dark-mode-flash').remove();
  });

  /*!
   * Get the URL parameters
   * (c) 2021 Chris Ferdinandi, MIT License, https://gomakethings.com
   * @param  {String} url The URL
   * @return {Object}     The URL parameters
   */
  function getParams(url = window.location) {
    let params = {};

    new URL(url).searchParams.forEach(function (val, key) {
      if (params[key] !== undefined) {
        if (!Array.isArray(params[key])) {
          params[key] = [params[key]];
        }

        params[key].push(val);
      } else {
        params[key] = val;
      }
    });

    return params;
  }

  /**
   * Query URL
   * Usage: qurl( $q )
   */
   function qurl( q ) {
    var x = window.location.search.substring( 1 );
    var s = x.split( '&' );

    for ( var i = 0; i < s.length; i++ ) {
      var pair = s[ i ].split( '=' );

      if ( pair[0] === q ) {
        return pair[1];
      }
    }
  };

  function hash() {
    return window.location.hash.substr( 1 ).replace( '#', '' );
  };

  /**
   * Call Chosen.
   *
   * JS below for form and Chosen to be reorganized. 
   */

  $(document).ready(function() {
    $('form select, nav select').chosen({
      width: '100%'
    });
  });

  // $(document).ready(function() {
  //   var chosen_search_svg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 18"><path d="M11.975 2.052c-2.736-2.736-7.187-2.736-9.923 0-2.736 2.736-2.736 7.187 0 9.923 2.44 2.441 6.248 2.704 8.983.79l4.877 4.877c.478.477 1.252.477 1.73 0 .477-.478.477-1.252 0-1.73l-4.877-4.877c1.914-2.735 1.651-6.542-.79-8.983zm-1.438 8.485c-1.95 1.95-5.124 1.95-7.074 0-1.95-1.95-1.95-5.124 0-7.074 1.95-1.95 5.124-1.95 7.074 0 1.95 1.95 1.95 5.124 0 7.074z"/></svg>';

  //   $('.chosen-search').append(chosen_search_svg);
  // });

  $(document).ready(function() {
    $('.chosen-search-input').each(function() {
      var select = $(this).closest('.chosen-container').prev('select');
      var chosenInputPlaceholder = select.attr('data-input-placeholder');

      $('.chosen-search-input').attr('placeholder', chosenInputPlaceholder);
    });
  });

  /**
   * Dropdown - move items down.
   */

  // Close all on click outside
  $(document).on('click', function(e) {
    if (! $(e.target).closest('.sidebar-filter .dropdown > button, .sidebar-filter .chosen-container').length) {
      $('.sidebar-filter .dropdown, .sidebar-filter .chosen-container').css('marginTop', '0');
    }
  });

  /**
   * When dropdown open then click off window (ex. your desktop),
   * dropdown closes, and no way to detect the click. Use
   * 'chosen:hiding_dropdown' to hide.
   */
  $('.sidebar-filter select').on('chosen:hiding_dropdown', function() {
    var findChosenWithDrop = $(this).closest('.sidebar-filter').find('.chosen-with-drop');

    if (! findChosenWithDrop.length) {
      $('.sidebar-filter .dropdown, .sidebar-filter .chosen-container').css('marginTop', '0');
    }
  });

  $('.sidebar-filter .dropdown > button').on('click', function(e) {
    var height = $(this).next('.dropdown-content').height();
    var nextItem = $(this).closest('.dropdown').next('.dropdown');
    var marginTop = height + 16 + 'px';

    $(this).closest('.dropdown').css('marginTop', '0');
    $(this).closest('.dropdown').siblings('.dropdown').css('marginTop', '0');

    if ($(this).closest('.dropdown').hasClass('is-active')) {
      nextItem.css('marginTop', '0');
    } else {
      nextItem.css('marginTop', marginTop);
    }
  });

  $(document).on('click', '.sidebar-filter .chosen-single', function() {
    var height = $(this).closest('.chosen-container').find('.chosen-drop').height();
    var nextItem = $(this).closest('.chosen-container').nextAll('.chosen-container:first, .dropdown:first');
    var marginTop = height + 16 + 'px';

    $(this).closest('.chosen-container').css('marginTop', '0');
    $(this).closest('.chosen-container').siblings('.chosen-container, .dropdown').css('marginTop', '0');

    if ($(this).hasClass('chosen-with-drop')) {
      nextItem.css('marginTop', '0');
    } else {
      nextItem.css('marginTop', marginTop);
    }

    var findChosenWithDrop = $(this).closest('.sidebar-filter').find('.chosen-with-drop');

    if (! findChosenWithDrop.length) {
      $('.sidebar-filter .dropdown, .sidebar-filter .chosen-container').css('marginTop', '0');
    }
  });

  /**
   * Image Ratio
   */

  var image_ratio = function() {
    "use strict";

    var images_parent = document.querySelector( '[data-proportional-image]' );
    var images = document.querySelectorAll( '[data-proportional-image] img' );

    if ( images_parent ) {
      var data_widthBase = images_parent.getAttribute( 'data-width-base' );
      var data_scaleFactor = images_parent.getAttribute( 'data-scale' );
    }

    function adjustImageWidth( image ) {
      if ( data_widthBase ) {
        var widthBase = data_widthBase;
      } else {
        var widthBase = 110;
      }

      if ( data_scaleFactor ) {
        var scaleFactor = data_scaleFactor;
      } else {
        var scaleFactor = .375;
      }

      var imageRatio = image.naturalWidth / image.naturalHeight;

      image.style.width = ( Math.pow( imageRatio, scaleFactor ) * widthBase ) + 'px';
    }

    images.forEach( adjustImageWidth );
  }

  $( document ).ready( function() {
    image_ratio();
  } );

  $( window ).on( 'load', function() {
    image_ratio();
  } );

  $( window ).on( 'resize', function() {
    setTimeout( image_ratio, 400);
  } );

  /**
   * Navigation
   */

  $( document ).on( 'click touchend', function( e ) {
    var classToggle = $( 'body, #accessory, #accessory-toggle, #header, #page' );

    if ( $( '#accessory' ).hasClass( 'is-open' ) && $( e.target ).closest( 'body' ).length && ! $( e.target ).closest( '#accessory, #accessory-toggle' ).length ) {
      classToggle.addClass( 'is-closed is-closing' ).removeClass( 'is-open' );

      setTimeout( function() {
        classToggle.removeClass( 'is-closing' );
      }, 250 );
    }
  } );

  $( '#accessory .close' ).on( 'click', function( e ) {
    e.preventDefault();

    var classToggle = $( this ).add( $( 'body, #accessory, #accessory-toggle, #header, #page' ) );

    classToggle.addClass( 'is-closed is-closing' ).removeClass( 'is-open' );

    setTimeout( function() {
      classToggle.removeClass( 'is-closing' );
    }, 250 );
  } );

  $( '#accessory-toggle' ).on( 'click', function() {
    var classToggle = $( this ).add( $( this ).parent() ).add( $( 'body, #accessory, #accessory-toggle, #header, #page' ) );

    if ( $( '#accessory' ).hasClass( 'is-open' ) ) {
      classToggle.addClass( 'is-closed is-closing' ).removeClass( 'is-open' );

      setTimeout( function() {
        classToggle.removeClass( 'is-closing' );
      }, 250 );
    } else {
      classToggle.addClass( 'is-open is-opening' ).removeClass( 'is-closed' );

      setTimeout( function() {
        classToggle.removeClass( 'is-opening' );
      }, 250 );
    }
  } );

  var closeMenuDesktop = function() {
    if ( window.matchMedia( '(min-width: 1024px)' ).matches ) {
      $( '#main' ).removeClass( 'is-open' );
    }
  }

  $( document ).ready( function() {
    closeMenuDesktop();
  } );

  $( window ).on( 'resize', function() {
    setTimeout( closeMenuDesktop, 400 );
  } );

  /**
   * Navigation Path Helper
   *
   * Insert a span after sub menu.
   * In the CSS it will be positioned behind the
   * menu to help with mouse path.
   */

  $( document ).ready( function() {
    var primary_menu_li = $( '#primary-menu li' );

    primary_menu_li.each( function() {
      var sub_menu = $( this ).children( 'ul' ).first();

      if ( sub_menu ) {
        sub_menu.wrap( '<span class="menu-path-helper"></span>' );
      }
    } );
  } );

  // Add menu elements to create scroll
  // $( document ).ready( function() {
  //   var e = $( '#menu-item-190' );

  //   for ( var i = 0; i < 10; i++ ) {
  //     e.clone().insertAfter( e );
  //   }
  // } );

  $('#accessory-menu .menu-item-has-children > a').on('click', function(e) {
    e.preventDefault();

    e.stopPropagation();

    // Prevent multiple open
    $(this).closest('ul').children('li.menu-item-has-children').children('ul').slideUp(250);
    $(this).closest('ul').children('li').not($(this).parent('li')).removeClass('is-open');

    if ($(this).parent('li').hasClass('is-open')) {
      $(this).next('ul').slideUp(250);
      $(this).parent('li').removeClass('is-open');
    } else {
      $(this).next('ul').slideDown(250);
      $(this).parent('li').addClass('is-open');
    }
  });

  $( '#accessory-menu .menu-item-has-children a span:first-child' ).on( 'click', function( e ) {
    e.preventDefault();
    e.stopPropagation();

    if ( ! $( this ).is( '.nolink, .no-link' ) && ! $( this ).closest( 'li' ).is( '.nolink, .no-link' ) && ! $( this ).parent().is( '.nolink, .no-link' ) ) {
      window.location.href = $( this ).parent().attr( 'href' );
    } else if ( $( this ).parent( '.menu-item-has-children' ) || $( this ).parent().parent( '.menu-item-has-children' ) ) {
      if ( $( this ).closest( '.menu-item-has-children' ).hasClass( 'is-open' ) ) {
        $( this ).closest( '.menu-item-has-children' ).find( 'ul' ).first().slideUp( 250 );
        $( this ).closest( '.menu-item-has-children' ).removeClass( 'is-open' );
      } else {
        $( this ).closest( '.menu-item-has-children' ).find( 'ul' ).first().slideDown( 250 );
        $( this ).closest( '.menu-item-has-children' ).addClass( 'is-open' );
      }
    }
  } );

  $( '.logo__mark, .logo__type' ).on( {
    mouseenter: function() {
      $( '#header .logo' ).addClass( 'is-hover' );
    },
    mouseleave: function() {
      $( '#header .logo' ).removeClass( 'is-hover' );
    }
  } );

  /**
   * Prevent Link.
   */
  $( document ).ready( function() {
    $( 'a.nolink, a.no-link, .nolink > a, .no-link > a' ).on( 'click', function( e ) {
      e.preventDefault();
    } );
  } );

  /**
   * Prevent Orphan
   */
  $( document ).ready( function() {
    var element = $( '.page-header:not(.page-header--search) h1, .line-heading h2, .list-3-col > li > h4, .list-4-col > li > h4, .page-header .entry-content p, .prevent-orphan, .footer-grid__cell h4, .footer-grid__cell button, .footer-grid__cell .button, .page-header .entry-content p' );

    element.each( function() {
      var a = $( this ).html().trim().replace( '&nbsp;', ' ' ).split( ' ' );

      if ( a.length > 1 ) {
        a[ a.length - 2 ] += '&nbsp;' + a[ a.length - 1 ];
        a.pop();
        $( this ).html( a.join( ' ' ) );
      }
    } );
  } );

  /**
   * Remove empty element
   */
  $( document ).ready( function() {
    $( '.entry-content p, .entry-content h1, .entry-content h2, .entry-content h3, .entry-content h4, .entry-content h5, .entry-content h6' ).each( function() {
      var html = $.trim( $( this ).html() );

      if ( html == '' || html == ' ' || html == '&nbsp;' ) {
        $( this ).remove();
      }
    } );
  } );

  /**
   * Replace Tag
   */

  $( window ).on( 'load', function() {
    $( '.hs-form fieldset' ).each( function() {
      var t = $( '<div>' );

      $.each( this.attributes, function( i, attr ) {
        $( t ).attr( attr.name, attr.value );
      } );

      $( this ).replaceWith( function() {
        return $( t ).append( $( this ).contents() );
      } );
    } );
  } );

  /**
   * Reveal
   */

  $( window ).on( 'load', function() {
    $( '.reveal' ).each( function() {
      var cusion = $( this ).find( '.reveal__toggle' ).outerHeight();
      var inside = $( this ).find( '.reveal__content' );
      var remove = $( this ).find( '.close' );
      var rename = $( this ).find( '.reveal__toggle a' ).text();
      var reveal = $( this );
      var toggle = $( this ).find( '.reveal__toggle' );

      inside.css( 'top', cusion );

      toggle.on( 'click', function( e ) {
        var height = reveal.find( '.reveal__content' ).outerHeight();

        e.preventDefault();

        if ( reveal.hasClass( 'is-open' ) ) {
          reveal.addClass( 'is-closed' ).removeClass( 'is-open' );
          toggle.css( 'marginBottom', 0 );

          setTimeout( function() {
            toggle.find( 'a' ).text( rename );
          }, 260 );
        } else {
          reveal.addClass( 'is-open' ).removeClass( 'is-closed' );
          toggle.css( 'marginBottom', height ).find( 'a' ).text( 'close' );
        }
      } );

      remove.on( 'click', function( e ) {
        e.preventDefault();

        reveal.addClass( 'is-closed' ).removeClass( 'is-open' );
        toggle.css( 'marginBottom', 0 );

        setTimeout( function() {
          toggle.find( 'a' ).text( rename );
        }, 260 );
      } );
    } );
  } );

  /**
   * Emergence
   */

  // emergence.init( {
  //   reset: false
  // } );

  /**
   * Scroll Action
   */

  var headerScrollClass = function() {
    var a = Math.ceil( $( 'html' ).scrollTop() ); // (Firefox)
    var b = Math.ceil( $( 'body' ).scrollTop() ); // (Everyone else)

    // Check which to use - body on firefox will print 0, html on chrome will print 0.
    if ( a > b ) {
      var n = a;
    } else {
      var n = b;
    }

    if ( window.matchMedia( '(min-width: 1024px)' ).matches ) {
      if ( n > 114 ) {
        $( '#header' ).not( '.pre-scrolled' ).addClass( 'is-scrolled' ).removeClass( 'not-scrolled' );
      } else {
        $( '#header' ).not( '.pre-scrolled' ).addClass( 'not-scrolled' ).removeClass( 'is-scrolled' );
      }
    } else {
      if ( n > 80 ) {
        $( '#header' ).not( '.pre-scrolled' ).addClass( 'is-scrolled' ).removeClass( 'not-scrolled' );
      } else {
        $( '#header' ).not( '.pre-scrolled' ).addClass( 'not-scrolled' ).removeClass( 'is-scrolled' );
      }
    }
  };

  $( document ).ready( function() {
    headerScrollClass();
  } );

  $( document ).on( 'scroll', function() {
    headerScrollClass();
  } );

  var marketCounter = function() {
    var a = Math.ceil( $( 'html' ).scrollTop() ); // (Firefox)
    var b = Math.ceil( $( 'body' ).scrollTop() ); // (Everyone else)

    // Check which to use - body on firefox will print 0, html on chrome will print 0.
    if ( a > b ) {
      var n = a;
    } else {
      var n = b;
    }

    if ( $( '.counter-bar' ).is( '[data-emergence="visible"]' ) && ! $( '.counter-bar' ).hasClass( 'counted-up' ) ) {
      $( '.counter .counter-number-digit' ).each( function() {
        $( this ).prop( 'Counter', 0 ).animate( {
          Counter: $( this ).attr( 'data-counter' )
        }, {
          duration: 3000,
          easing: 'swing',
          step: function( now ) {
            $( this ).text( Math.ceil( now ) );
          }
        } );
      } );

      $( '.counter-bar' ).addClass( 'counted-up' );
    }
  };

  var portfolioCounter = function() {
    var a = Math.ceil( $( 'html' ).scrollTop() ); // (Firefox)
    var b = Math.ceil( $( 'body' ).scrollTop() ); // (Everyone else)

    // Check which to use - body on firefox will print 0, html on chrome will print 0.
    if ( a > b ) {
      var n = a;
    } else {
      var n = b;
    }

    if ( $( '.portfolio-counter' ).is( '[data-emergence="visible"]' ) && ! $( '.portfolio-counter' ).hasClass( 'counted-up' ) ) {
      $( '.portfolio-counter__number' ).each( function() {
        $( this ).prop( 'Counter', 0 ).animate( {
          Counter: $( this ).attr( 'data-counter' )
        }, {
          duration: 3000,
          easing: 'swing',
          step: function( now ) {
            $( this ).text( Math.ceil( now ) );
          }
        } );
      } );

      $( '.portfolio-counter' ).addClass( 'counted-up' );
    }
  };

  $( document ).on( 'scroll', function() {
    setTimeout( marketCounter, 400 );
    setTimeout( portfolioCounter, 400 );
  } );

  /**
   * Search Utility
   */

  $( '.search-utility button' ).on( 'click', function( e ) {
    var search = $( this ).closest( 'form' ).find( '.search-field' );

    if ( ! search.hasClass( 'is-active' ) ) {
      e.preventDefault();

      search.addClass( 'is-active' ).focus();
    } else if ( search.hasClass( 'is-active' ) && search.val() == '' ) {
      e.preventDefault();

      search.removeClass( 'is-active' );
    }
  } );

  var header_utility = document.querySelector( '.header-primary' );

  if ( header_utility ) {
    var header_search_field = header_utility.querySelector( '.search-field' );
  }

  document.addEventListener( 'click', function( e ) {
    if ( header_utility ) {
      var inside__header_utility = header_utility.contains( e.target );
    }

    if ( ! inside__header_utility && $( header_search_field ).val() == '' ) {
      header_search_field.classList.remove( 'is-active' );
    }
  } );

  /**
   * Smooth Scroll
   */
  $(document).ready(function() {
    $(document).on('click', '[data-goto]', function(e) {
      e.preventDefault();

      var goto = $(this).attr('data-goto');
      var offs = $(goto).offset().top;
      var trim = $(this).attr('data-goto-trim');

      if ($(this).attr('speed')) {
        var speed = $(this).attr('speed');
      } else {
        var speed = 250;
      }

      if (! trim) {
        var trim = 0;
      }

      /**
       * Overide trim setting
       */
      if (window.matchMedia('(min-width: 1024px)').matches) {
        trim = 114;
      } else {
        trim = 86;
      }

      if ($('body').hasClass('page-template-process')) {
        if (window.matchMedia('(min-width: 1024px)').matches) {
          trim = 144;
        } else {
          trim = 116;
        }
      }

      $('body, html').animate({
        scrollTop: offs - trim
      }, { duration: speed });
    });

    $(document).on('change', '.goto-select', function(e) {
      e.preventDefault();

      var goto = $(this).find(':selected').attr('value');
      var offs = $('#' + goto).offset().top;
      var trim = $(this).attr('data-goto-trim');

      if ($(this).attr('speed')) {
        var speed = $(this).attr('speed');
      } else {
        var speed = 250;
      }

      if (! trim) {
        var trim = 0;
      }

      /**
       * Overide trim setting
       */
      if (window.matchMedia('(min-width: 1024px)').matches) {
        trim = 114;
      } else {
        trim = 86;
      }

      $('body, html').animate({
        scrollTop: offs - trim
      }, { duration: speed });
    });
  });

  /**
   * Vendor: Slick
   */

  var nextArrow = '<button class="slick-next" type="button"><svg viewBox="0 0 17 30" xmlns="http://www.w3.org/2000/svg"><path d="M1.889 30L17 15 1.889 0 0 1.875 13.222 15 0 28.125z"/></svg></button>';
  var prevArrow = '<button class="slick-prev" type="button"><svg viewBox="0 0 17 30" xmlns="http://www.w3.org/2000/svg"><path d="M15.111 30L0 15 15.111 0 17 1.875 3.778 15 17 28.125z"/></svg></button>';

  $('.hero-image-slider').slick({
    appendDots: $('.hero-dots'),
    arrows: false,
    dots: true,
    rows: 0,
    speed: 250,
    asNavFor: $('.hero-caption-slider, .hero-photo-credit-slider')
  });

  $('.hero-caption-slider').slick({
    arrows: false,
    draggable: false,
    fade: true,
    rows: 0,
    speed: 250,
    asNavFor: $('.hero-image-slider, .hero-photo-credit-slider')
  });

  $('.hero-photo-credit-slider').slick({
    arrows: false,
    draggable: false,
    fade: true,
    rows: 0,
    speed: 250,
    asNavFor: $('.hero-caption-slider, .hero-image-slider')
  });

  // Make arrow keys work
  if ($('.hero .slick-list').length) {
    $('.hero .slick-list').attr('tabindex', 0).focus();
  }

  $('.quote-slideshow__slider.is-reel').slick({
    appendDots: $('.quote-slideshow-dots'),
    arrows: true,
    dots: true,
    nextArrow: $('#quote-slideshow-next'),
    prevArrow: $('#quote-slideshow-prev'),
    rows: 0,
    speed: 250,
    asNavFor: $('.quote-slideshow__author.is-reel')
  });

  $('.quote-slideshow__author.is-reel').slick({
    arrows: false,
    draggable: false,
    fade: true,
    rows: 0,
    speed: 250,
    asNavFor: $('.quote-slideshow__slider.is-reel')
  });

  $( '.reel--bleed .slick-slide' ).on( 'click', function( e ) {
    var i = $( this ).data( 'slick-index' );

    if ( $('.slick-slider' ).slick( 'slickCurrentSlide' ) !== i ) {
      e.preventDefault();
      e.stopPropagation();

      $( '.slick-slider' ).slick( 'slickGoTo', i );
    }
  } );

  $( '.reel--appendArrows' ).each( function() {
    if ( $( this ).hasClass( 'arrows' ) ) {
      var appendArrows = $( this );
    } else if ( $( this ).siblings( '.arrows' ).length ) {
      var appendArrows = $( this ).siblings( '.arrows' );
    } else if ( $( this ).siblings().find( '.arrows' ).length ) {
      var appendArrows = $( this ).siblings().find( '.arrows' );
    } else if ( $( this ).closest( '.arrows' ).length ) {
      var appendArrows = $( this ).closest( '.arrows' );
    } else {
      var appendArrows = $( '.arrows' );
    }

    $( this ).slick( 'slickSetOption', {
      appendArrows: appendArrows,
      arrows: true
    }, true );
  } );

  $( '.reel--dots' ).each( function() {
    if ( $( this ).hasClass( 'dots' ) ) {
      var appendDots = $( this );
    } else if ( $( this ).siblings( '.dots' ).length ) {
      var appendDots = $( this ).siblings( '.dots' );
    } else if ( $( this ).siblings().find( '.dots' ).length ) {
      var appendDots = $( this ).siblings().find( '.dots' );
    } else if ( $( this ).closest( '.dots' ).length ) {
      var appendDots = $( this ).closest( '.dots' );
    } else {
      var appendDots = $( '.dots' );
    }

    $( this ).slick( 'slickSetOption', {
      appendDots: appendDots,
      dots: true
    }, true );
  } );

  var slickArrowAlign = function() {
    $( '.slick-arrow-align' ).each( function() {
      var a = $( this ).find( '.slick-arrow' );
      var b = a.outerHeight();
      var h = $( this ).find( '.slick-list' ).innerHeight();
      var m = ( h / 2 ) - ( b / 2 );

      a.css( {
        marginTop: m,
        top: 0,
        transform: 'none'
      } );
    } );
  }

  /**
   * Open external link in new tab
   */
  $( document ).ready( function() {
    $( 'a' ).filter( '[href^="http"], [href^="//"]' ).not( '[href*="' + window.location.host + '"]' ).attr( 'rel', 'noopener noreferrer' ).attr( 'target', '_blank' );
  } );

  /**
   * Open PDF in new tab
   */
  $( document ).ready( function() {
    $( 'a[href$=".pdf"]' ).attr( 'target', '_blank' );
  } );

  /**
   * Form Spam Protection
   */
  jQuery( document ).ready( function() {
    var form = 'footer form, header form, .gform_wrapper form';

    jQuery( form ).append( '<div style="top: -99999px; left: -99999px; position: absolute;"><input id="protect" name="protect" type="text"></div>' );

    jQuery( form ).on( 'submit', function( e ) {
      if ( jQuery( this ).find( '#protect' ).val() ) {
        e.preventDefault();
      }
    } );

    jQuery( form ).each( function() {
      var submit_button = jQuery( this ).find( '[type="submit"]' );

      jQuery( submit_button ).on( 'click', function( e ) {
        if ( jQuery( this ).closest( 'form' ).find( '#protect' ).val() ) {
          e.preventDefault();
        }
      } );
    } );
  } );

  /**
   * Dropdown
   */

  $(document).on('click', function(e) {
    if (! $(e.target).closest('.dropdown').length) {
      $('.dropdown').removeClass('is-active');
    }
  });

  $('.dropdown > button').on('click', function(e) {
    e.preventDefault();

    $('.dropdown').not($(this).closest('.dropdown')).removeClass('is-active');

    $(this).closest('.dropdown').toggleClass('is-active');
  });

  $('.dropdown-content > li:first-child').on({
    mouseenter: function() {
      $(this).closest('ul').addClass('is-top-item-hover');
    },
    mouseleave: function() {
      $(this).closest('ul').removeClass('is-top-item-hover');
    }
  });

  /**
   * Sidebar filters hide.
   */

  $('.sidebar-filter-hide-button').on('click', function(e) {
    e.preventDefault();

    var sidebar = $(this).closest('.sidebar-filter');

    $(this).closest('.feed-section').find('.sidebar-filter-show-button-container').toggleClass('is-active');

    sidebar.toggleClass('is-active');
  });

  $('.sidebar-filter-show-button').on('click', function(e) {
    e.preventDefault();

    $(this).closest('.feed-section').find('.sidebar-filter-show-button-container').removeClass('is-active');

    $('.sidebar-filter').addClass('is-active');
  });

  /**
   * Delete URL parameter.
   */

  function deleteParam(url, key, value) {
    let params = url.searchParams.getAll(key);

    var index = params.indexOf(value);
    
    if (index > -1) {
      params.splice(index, 1);
    }
    
    url.searchParams.delete(key);
    
    params.forEach(function(param) {
      url.searchParams.append(key, param);
    });
  }

  /**
   * Sidebar filters - with select values.
   */

  var url = new URL(window.location.href);

  $('.sidebar-filter select').on('change', function() {
    var category = $(this).find(':selected').attr('data-category'),
      filter = $(this).attr('data-filter'),
      filterAll = url.searchParams.getAll(filter),
      filterAnchor = $(this).closest('nav').attr('data-filter-anchor'),
      hash = url.href.split('#')[1];

    if (category && filter) {

      /**
       * Add parameter or delete if exists.
       */
      if ($(this).attr('data-select-multiple') == 'false') {
        url.searchParams.delete(filter);
        url.searchParams.append(filter, category);
      } else if (filterAll.indexOf(category) > -1) {
        deleteParam(url, filter, category);
      } else {
        url.searchParams.append(filter, category);
      }

      if ($('.block-feed.block-feed--list').length) {
        url.searchParams.append('view-list', 'true');
      } else {
        url.searchParams.delete('view-list');
      }

      /**
       * Use .split() to get everything before '#'
       * then append filter anchor.
       */
      if (filterAnchor) {
        url.href = url.href.split('#')[0] + '#' + filterAnchor;
      }

      window.location.replace(url.href);
    }
  });

  var closeIcon = $('<svg aria-hidden="true" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg"><path d="M7.857 6.506L1.571.221.157 1.635 6.443 7.92 0 14.363l1.414 1.415 6.443-6.443 6.442 6.442 1.415-1.414L9.27 7.92l6.285-6.285L14.142.221 7.857 6.506z"/></svg>');

  $(document).ready(function() {
    var urlParams = getParams();

    for (var param in urlParams) {
      if (Array.isArray(urlParams[param])) {
        for (var i = 0; i < urlParams[param].length; i++) {
          var urlCategoryRemoved = new URL(window.location.href),
            categoryText = $('[data-filter="' + param + '"] [data-category="' + urlParams[param][i] + '"]:first').text();

          if (! categoryText) {
            categoryText = urlParams[param][i];
          }

          deleteParam(urlCategoryRemoved, param, urlParams[param][i]);

          if ($('.block-feed.block-feed--list').length) {
            urlCategoryRemoved.searchParams.append('view-list', 'true');
          } else {
            urlCategoryRemoved.searchParams.delete('view-list');
          }

          if (param != 'items' && param != 'sort' && param != 'view-list') {
            $('#filter-categories-list').append($('<li data-category="' + param + '"><a href="' + urlCategoryRemoved.href + '">' + categoryText + '</a></li>'));
          }
        }
      } else {
        var urlCategoryRemoved = new URL(window.location.href),
          categoryText = $('[data-filter="' + param + '"] [data-category="' + urlParams[param] + '"]:first').text();

        if (! categoryText) {
          categoryText = urlParams[param];
        }

        deleteParam(urlCategoryRemoved, param, urlParams[param]);

        if ($('.block-feed.block-feed--list').length) {
          urlCategoryRemoved.searchParams.append('view-list', 'true');
        } else {
          urlCategoryRemoved.searchParams.delete('view-list');
        }

        if (param != 'items' && param != 'sort' && param != 'view-list') {
          $('#filter-categories-list').append($('<li data-category="' + param + '"><a href="' + urlCategoryRemoved.href + '">' + categoryText + '</a></li>'));
        }
      }
    };

    if ($('#filter-categories-list li').length > 0) {
      $('.page-header-categories').addClass('has-categories');
    }

    $('#filter-categories-list > li > a').append(closeIcon);

    if (Object.keys(urlParams).length > 0) {
      $('.page-header-categories').addClass('is-active');
    }
  });

  /**
   * Apply header id's.
   */
  $(document).ready(function() {
    var headersIds = $('.content-single .entry-content h2, .content-single .entry-content h3');
    var headersIdsList = $('.content-single .aside-post-navigation');
    var headersIdsListMobile = $('.aside-post-navigation-mobile');

    // [Optional] Icon that will clone and append
    var headersIdsIcon = $('.aside-post-navigation-icon');

    headersIds.each(function() {
      var headersIdsText = $(this).text().toLowerCase().replace(/\s+/g, '-').replace(/[^0-9a-z-]/gi, '');

      if (! $(this).attr('id')) {
        $(this).addClass('header-anchor').attr('id', headersIdsText);
      }
    });

    $('.header-anchor').each(function() {
      headersIdsList.append($('<li><a data-goto="#' + $(this).attr('id') + '" href="#' + $(this).attr('id') + '"><span>' + $(this).text() + '</span></a></li>'));
      headersIdsListMobile.append($('<option value="' + $(this).attr('id') + '">' + $(this).text() + '</option>'));
    });

    headersIdsListMobile.chosen({
      width: '100%'
    });

    headersIdsListMobile.next('.chosen-container').find('.chosen-search-input').attr('placeholder', headersIdsListMobile.attr('data-input-placeholder'));

    if (headersIdsIcon && headersIdsIcon.length) {
      headersIdsList.children('li').children('a').each(function() {
        var headersIdsIconClone = headersIdsIcon.clone();

        $(this).append(headersIdsIconClone);
      });
    }
  });

  /**
   * Bucket description icon.
   */
  $(document).ready(function() {
    var bucketDescriptionText = $('.bucket-description');

    bucketDescriptionText.each(function() {
      var appendParent = $(this);

      if ($(this).find('p').length) {
        appendParent = $(this).find('p').last();
      }

      var bucketDescriptionHref = $(this).closest('li').find('a').attr('href');
      var bucketDescriptionIcon = $('<svg aria-hidden="true" class="bucket-description-arrow" viewBox="0 0 36 17" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M26.55 1L34 8.5 26.55 16M0 8.5h34" stroke="#6e7ca0" stroke-width="2"/></svg>');

      if ($(this).closest('ul').attr('data-arrows-small') == 'true') {
        bucketDescriptionIcon = $('<svg viewBox="0 0 25 17" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15.352 1l7.395 7.5-7.395 7.5M1 8.397l21.748.103" stroke="#6e7ca0" stroke-width="2"/></svg>');
      }

      appendParent.append('&nbsp;').append($('<a class="bucket-description-link" href="' + bucketDescriptionHref + '"></a>'));

      $(this).find('.bucket-description-link').append(bucketDescriptionIcon);
    });
  });

  /**
   * Set icon in Chosen button.
   */

  $(document).ready(function() {
    var svg = $('<svg viewBox="0 0 23 13" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1.6 1.5l9.9 9.9 9.9-9.9" stroke="#6e7ca0" stroke-width="2"/></svg>');

    $('.chosen-single > div').remove();

    $('.chosen-single').append(svg);
  });

  $(document).on('click', '.button-view-list', function(e) {
    e.preventDefault();

    var blockFeed = $('.block-feed');
    var blockFeedTitleHead = $('.block-feed-title-head');

    var links = $('.feed-options-bar a, #filter-categories-list a');

    var styleFix = $('<style id="posts-wrap-transition-fix">.feed-section__posts * { transition: none !important; }</style>');

    $('body').append(styleFix);

    setTimeout(function() {
      $('#posts-wrap-transition-fix').remove();
    }, 200);

    blockFeed.toggleClass('block-feed--list');
    blockFeedTitleHead.toggleClass('is-active');

    if (blockFeed.hasClass('block-feed--list')) {
      $('.button-view-list').text('View all as grid');
    } else {
      $('.button-view-list').text('View all as list');
    }

    links.each(function() {
      var linkBaseUrl = window.location.href.toString().split(window.location.host)[0] + window.location.host;
      var linkUrl = false;

      try {
        linkUrl = new URL($(this).attr('href'));
      } catch(e) {}

      if (! linkUrl) {
        try {
          linkUrl = new URL(linkBaseUrl + $(this).attr('href'));
        } catch(e) {}
      }

      if (linkUrl) {
        if ($('.block-feed.block-feed--list').length) {
          linkUrl.searchParams.append('view-list', 'true');
        } else {
          linkUrl.searchParams.delete('view-list');
        }
      }

      $(this).attr('href', linkUrl.href);
    });
  });

  /**
   * Content navigation.
   */
  $('.content-navigation-icon').on('click', function(e) {
    e.preventDefault();

    var childList = $(this).closest('li').children('ul:first');

    childList.slideToggle(200);
  });

  $(document).ready(function() {
    var chosenSelects = $('nav select');

    if (chosenSelects.length) {
      chosenSelects.each(function() {
        var $select = $(this);
        var select_opt1 = $select.children('option:first');
        var placeholder = $select.attr('data-placeholder');

        if (! placeholder) {
          placeholder = 'Select...';
        }

        /**
         * Add class to select on mobile.
         */
        if (/iP(od|hone)/i.test(window.navigator.userAgent) || (/Android/i.test(window.navigator.userAgent) && /Mobile/i.test(window.navigator.userAgent))) {
          $select.addClass('chosen-mobile');
        }

        if (select_opt1.is(':empty')) {
          select_opt1.text(placeholder);
        }
      });
    }
  });
});