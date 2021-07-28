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
   * Button Icon
   */

  var set_button_link_icon = function() {
    var arrow_left = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17 14"><path d="M6.364 13.231L-.04 6.933c-.074-.058-.074-.174 0-.247L6.364.387c.074-.072.177-.072.25 0l.825.812-5.05 4.966h13.794c.398 0 .722.319.722.71 0 .376-.324.695-.722.695H2.507l4.932 4.85-.825.811c-.073.073-.176.073-.25 0"/></svg>';
    var arrow_right = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17 14"><path d="M10.636 13.231l6.404-6.298c.074-.058.074-.174 0-.247L10.636.387c-.074-.072-.177-.072-.25 0l-.825.812 5.05 4.966H.817c-.398 0-.722.319-.722.71 0 .376.324.695.722.695h13.676l-4.932 4.85.825.811c.073.073.176.073.25 0"/></svg>';

    $( '.button-link' ).each( function() {
      var button = $( this ).not( 'input' );

      /**
       * Append svg if no existing svg.
       */
      if ( ! button.find( 'svg' ).length ) {
        if ( button.hasClass( 'button--prev' ) ) {
          button.append( arrow_left );
        } else {
          button.append( arrow_right );
        }
      }
    } );

    $( 'input[type="button"], input[type="submit"]' ).each( function() {
      var value = $( this ).attr( 'value' );

      if ( ! $( this ).parent().hasClass( 'button-input' ) ) {
        $( this ).attr( 'value', '' ).wrap( '<div class="button button-input"></div>' );

        $( this ).parent( '.button-input' ).prepend( value );
      }

      // $( this ).parent( '.button-input' ).append( arrow_right ).prepend( $( '<span>' + value + '</span>' ) );
    } );
  };

  jQuery( document ).on( 'gform_post_render', function( e, form_id ) {
    set_button_link_icon();
  } );

  $( document ).ready( function() {
    set_button_link_icon();
  } );

  /**
   * List Icon
   */

  $( document ).ready( function() {
    $( '.list-arrow li' ).each( function() {
      var svg = $( '<svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 13"><path d="M9.921-.051l-.706.708 4.867 4.884H0v1.003h14.082l-4.867 4.882.706.71 6.074-6.094z"/></svg>' );

      if ( $( this ).children( 'a' ).length ) {
        var href = $( this ).attr( 'href' );
        var svg = $( '<a class="list-icon" href="' + href + '"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 13"><path d="M9.921-.051l-.706.708 4.867 4.884H0v1.003h14.082l-4.867 4.882.706.71 6.074-6.094z"/></svg></a>' );

        $( this ).css( 'paddingLeft', 0 );
        $( this ).children( 'a' ).css( 'paddingLeft', '2.25rem' );
      }

      $( this ).append( svg );
    } );
  } );

  /**
   * WordPress comment form.
   */

  $( '.comment-form' ).each( function() {
    var comment_field_wrap = $( '<span class="comment-field-wrap"></span>' );
    var comment_form_author = $( this ).find( '.comment-form-author' );
    var comment_form_email = $( this ).find( '.comment-form-email' );
    var comment_notes = $( this ).find( '.comment-notes' );

    if ( ! $( this) .find('.comment-field-wrap').length > 0 ) {
      if ( comment_notes.length > 0 ) {
        comment_field_wrap.insertAfter( comment_notes );
      } else {
        $( this ).prepend( comment_field_wrap );
      }
    }

    comment_field_wrap.append( comment_form_author ).append( comment_form_email );
  } );

  $( '.blog-posts-comments-label a' ).on( 'click', function( e ) {
    e.preventDefault();

    if ( $( e.target ).is( '.comments-label-close' ) ) {
      $( '.blog-post-comments' ).slideUp( 250 );

      $( '.blog-posts-comments-label' ).addClass( 'is-active' );
      $( '.blog-posts-comments-label .comments-label__text' ).removeClass( 'screen-reader-text' );
      $( '.blog-posts-comments-label .comments-label-close' ).addClass( 'screen-reader-text' );

      return false;
    }

    $( '.blog-post-comments' ).slideDown( 250 );

    $( '.blog-posts-comments-label' ).addClass( 'is-active' );
    $( '.blog-posts-comments-label .comments-label__text' ).addClass( 'screen-reader-text' );
    $( '.blog-posts-comments-label .comments-label-close' ).removeClass( 'screen-reader-text' );
  } );

  $( document ).ready( function() {
    if ( window.location.hash == '#comments' ) {
      $( '.blog-post-comments' ).addClass( 'has-hash' );

      $( '.blog-posts-comments-label' ).addClass( 'is-active' );
      $( '.blog-posts-comments-label .comments-label__text' ).addClass( 'screen-reader-text' );
      $( '.blog-posts-comments-label .comments-label-close' ).removeClass( 'screen-reader-text' );
    }
  } );

  /**
   * Grab
   */

  $.fn.grab = function( size ) {
    var arr = [];

    for ( var i = 0; i < this.length; i += size ) {
      arr.push( this.slice( i, i + size ) );
    }

    return this.pushStack( arr, 'grab', size );
  }

  /**
   * Split Navigation
   */

  var split_nav = function() {
    var split_nav = $( '#primary-menu' );
    var insertAfter = $( '#primary .logo' );
    var ul_clone = $( '<ul class="menu" id="primary-menu-clone"></ul>' );
    var half_1_length = Math.ceil( parseFloat( split_nav.children().length / 2 ) );
    var half_1 = $( split_nav ).children().slice( 0, half_1_length );
    var half_2 = $( split_nav ).children().slice( half_1_length );

    ul_clone.insertAfter( insertAfter ).append( half_2 );

    split_nav.css( 'display', 'flex' );
    ul_clone.css( 'display', 'flex' );
  };

  var split_nav_equal_width = function() {
    var equalize = $( '#primary ul' );
    var maxWidth = 0;

    equalize.each( function() {
      $( this ).css( 'width', 'auto' );

      if ( $( this ).width() > maxWidth ) {
        maxWidth = $( this ).width() + .01;
      }
    } );

    equalize.width( maxWidth );
  };

  // split_nav();
  // split_nav_equal_width();

  // $( window ).on( 'resize', function() {
  //   setTimeout( split_nav_equal_width, 300 );
  // } );

  /**
   * Dynamic Grid
   */

  var dynamic_grid = function() {
    $( '.dynamic-grid' ).each( function() {
      var grid = $( this );
      var cell = grid.find( '.dynamic-grid-cell' );
      var content = grid.find( '.dynamic-grid-content' );
      var toggle = grid.find( '.client-image__link' );

      if ( window.matchMedia( '(min-width: 1280px)' ).matches ) {
        var row = 5;
      } else if ( window.matchMedia( '(min-width: 1024px)' ).matches ) {
        var row = 4;
      } else if ( window.matchMedia( '(min-width: 768px)' ).matches ) {
        var row = 3;
      } else if ( window.matchMedia( '(min-width: 576px)' ).matches ) {
        var row = 2;
      } else {
        var row = 1;
      }

      cell.unwrap( '.dynamic-grid-flex' );
      cell.unwrap( '.dynamic-grid-wrap' );
      cell.unwrap( '.dynamic-grid-row' );

      cell.grab( row ).wrap( '<div class="dynamic-grid-row"><div class="dynamic-grid-wrap"><div class="dynamic-grid-flex"></div></div></div>' );

      content.each( function() {
        var id = $( this ).data( 'content-id' );
        var parent = grid.find( '.dynamic-grid-cell[data-cell-id="' + id + '"]' ).closest( '.dynamic-grid-row' );

        $( this ).appendTo( parent );
      } );

      toggle.on( 'click', function( e ) {
        e.preventDefault();

        var panel = $( this ).attr( 'href' );

        if ( $( this ).hasClass( 'is-active' ) ) {
          toggle.removeClass( 'is-active' );
          $( '.dynamic-grid-content' ).removeClass( 'is-active' ).slideUp( 175 );
          grid.removeClass( 'activated' );
        } else {
          toggle.removeClass( 'is-active' );
          $( this ).addClass( 'is-active' );
          $( '.dynamic-grid-content' ).removeClass( 'is-active' ).slideUp( 175 );

          if ( grid.hasClass( 'activated' ) ) {
            setTimeout( function() {
              $( panel ).addClass( 'is-active' ).slideDown( 275 );
              grid.addClass( 'activated' );
            }, 175 );
          } else {
            $( panel ).addClass( 'is-active' ).slideDown( 275 );
            grid.addClass( 'activated' );
          }
        }
      } );
    } );
  }

  $( document ).ready( function() {
    dynamic_grid();
  } );

  $( window ).on( 'resize', function() {
    setTimeout( dynamic_grid, 400 );
  } );

  /**
   * Pagination for Filter
   */

  var run_pagination = function() {
    $( '[data-pagination]' ).each( function() {
      var pagination = $( this );
      var pagination_display = $( this ).css( 'display' );
      var target = pagination.attr( 'data-pagination' );
      var limit = pagination.attr( 'data-pagination-limit' );
      var page_total = Math.ceil( $( target ).length / limit );
      var current = pagination.attr( 'data-pagination-current' );
      var display = pagination.attr( 'data-pagination-display' );

      pagination.attr( 'data-pagination-total', page_total );

      $( target ).each( function( i ) {
        $( this ).attr( 'data-pagination-page', parseInt( i / limit + 1 ) );
      } );

      pagination.children( 'li' ).not( '.pagination-next, .pagination-prev' ).remove();

      for ( var i = 0; i < page_total; i++ ) {
        $( this ).append( '<li><a data-pagination-nav="' + ( i + 1 ) + '" href="#">' + ( i + 1 ) + '</a></li>' );
      }

      pagination.append( $( '.pagination-next' ) );

      if ( ! current ) {
        pagination.attr( 'data-pagination-current', 1 );

        var current = pagination.attr( 'data-pagination-current' );
      }

      $( target ).attr( 'data-pagination-hidden', true ).css( 'display', 'none' );

      $( '[data-pagination-page=' + current + ']' ).attr( 'data-pagination-hidden', false ).css( 'display', display );

      $( '[data-pagination-nav]' ).removeClass( 'is-active' );

      $( '[data-pagination-nav=' + current + ']' ).addClass( 'is-active' );

      if ( page_total < 2 ) {
        pagination.css( 'display', 'none' );
        pagination.parent().css( 'display', 'none' );
      } else {
        pagination.css( 'display', pagination_display );
        pagination.parent().css( 'display', pagination_display );
      }
    } );
  };

  $( document ).ready( function() {
    run_pagination();

    $( document ).on( 'click', '[data-pagination] a', function( e ) {
      e.preventDefault();

      var pagination = $( this ).closest( '[data-pagination]' );
      var limit = pagination.attr( 'data-pagination-limit' );
      var target = pagination.attr( 'data-pagination' );
      var $target = $( target ).not( '[data-filter-hidden="true"]' ).not( '[data-scan-hidden="true"]' );
      var nav = $( this ).attr( 'data-pagination-nav' );
      var current = pagination.attr( 'data-pagination-current' );
      var page_total = pagination.attr( 'data-pagination-total' );

      if ( pagination.attr( 'data-pagination-display' ) ) {
        var display = pagination.attr( 'data-pagination-display' );
      } else {
        var display = 'block';
      }

      pagination.attr( 'data-pagination-current', nav );

      if ( $( this ).is( '.pagination-next a' ) ) {
        if ( parseInt( current ) === parseInt( page_total ) ) {
          pagination.attr( 'data-pagination-current', 1 );
        } else {
          pagination.attr( 'data-pagination-current', ( parseInt( current ) + 1 ) );
        }
      } else if ( $( this ).is( '.pagination-prev a' ) ) {
        if ( parseInt( current ) === 1 ) {
          pagination.attr( 'data-pagination-current', page_total );
        } else {
          pagination.attr( 'data-pagination-current', ( parseInt( current ) - 1 ) );
        }
      } else {
        pagination.attr( 'data-pagination-current', nav );
      }

      var current_new = pagination.attr( 'data-pagination-current' );

      $( target ).attr( 'data-pagination-hidden', true ).css( 'display', 'none' );

      $( '[data-pagination-page=' + current_new + ']' ).each( function() {
        $( this ).attr( 'data-pagination-hidden', false ).css( 'display', display );
      } );

      $( '[data-pagination-nav]' ).removeClass( 'is-active' );

      $( '[data-pagination-nav=' + current_new + ']' ).addClass( 'is-active' );
    } );
  } );

  var reload_pagination = function( all ) {
    $( '[data-pagination]' ).each( function() {
      var pagination = $( this );
      var target = pagination.attr( 'data-pagination' );

      if ( all == true ) {
        var $target = $( target );
      } else {
        var $target = $( target ).not( '[style="display: none;"]' );
      }

      var limit = pagination.attr( 'data-pagination-limit' );
      var page_total = Math.ceil( $target.length / limit );
      var current = pagination.attr( 'data-pagination-current' );
      var display = pagination.attr( 'data-pagination-display' );

      pagination.add( pagination.parent( 'nav' ) ).attr( 'data-pagination-total', page_total );

      $( target ).attr( 'data-pagination-page', 0 );

      $target.each( function( i ) {
        var page = Math.ceil( ( i + 1 ) / limit );

        $( this ).attr( 'data-pagination-page', 0 );
        $( this ).attr( 'data-pagination-page', page );
      } );

      pagination.children( 'li' ).not( '.pagination-next, .pagination-prev' ).remove();

      for ( var i = 0; i < page_total; i++ ) {
        $( this ).append( '<li><a data-pagination-nav="' + ( i + 1 ) + '" href="#">' + ( i + 1 ) + '</a></li>' );
      }

      pagination.append( $( '.pagination-next' ) );

      // reset current page attribute to 1 after filtering
      pagination.attr( 'data-pagination-current', 1 );

      $target.attr( 'data-pagination-hidden', true ).css( 'display', 'none' );

      $( '[data-pagination-page="1"]' ).attr( 'data-pagination-hidden', false ).css( 'display', display );

      $( '[data-pagination-nav]' ).removeClass( 'is-active' );

      $( '[data-pagination-nav="1"]' ).addClass( 'is-active' );
    } );
  };

  /**
   * Filter
   */

  // Filter button click
  $( '[data-filter] a, [data-filter] button' ).on( 'click', function( e ) {
    e.preventDefault();

    var filter = $( this ).closest( '[data-filter]' );
    var category = filter.attr( 'data-filter' );

    if ( filter.attr( 'data-filter-display' ) ) {
      var display = filter.attr( 'data-filter-display' );
    } else {
      var display = 'block';
    }

    // Filter all
    if ( $( this ).is( '.filter-all, .filter-all a, .filter-all button' ) ) {
      filter.find( 'li' ).removeClass( 'is-active' );
      $( this ).parent().addClass( 'is-active' );

      if ( filter.attr( 'data-filter-display' ) ) {
        var display = filter.attr( 'data-filter-display' );
      } else {
        var display = 'block';
      }

      $( '[data-' + category + ']' ).attr( 'data-filter-hidden', false ).attr( 'data-scan-hidden', false ).css( 'display', display );

      reload_pagination( true );

      return;
    } else {
      $( '.filter-all, .filter-all a, .filter-all button' ).removeClass( 'is-active' );
    }

    // filter-multi
    if ( filter.is( '.filter-multi' ) ) {
      if ( $( this ).parent().hasClass( 'is-active' ) ) {
        $( this ).parent().removeClass( 'is-active' );
      } else {
        $( this ).parent().addClass( 'is-active' );
      }
    } else {
      filter.find( 'li' ).removeClass( 'is-active' );
      $( this ).parent().addClass( 'is-active' );
    }

    // filter-null
    if ( filter.is( '.filter-null' ) ) {
      if ( $( this ).parent().hasClass( 'is-active' ) ) {
        filter.find( 'li' ).removeClass( 'is-active' );
      } else {
        filter.find( 'li' ).removeClass( 'is-active' );

        $( this ).parent().addClass( 'is-active' );
      }
    }

    // filtering

    // Hide elements that are set to be filtered
    $( '[data-filter]' ).each( function() {
      var filter = $( this ).data( 'filter' );

      $( '[data-' + filter + ']' ).attr( 'data-filter-hidden', true ).hide();
    } );

    // Hide filter alert and filter instruction
    $( '.filter-alert, .filter-instruction' ).hide();

    // Build an array of selected options
    var option = [];

    // For each selected option build a selector and push to array
    $( '[data-filter] option:selected:not(:disabled)' ).each( function() {
      var filter = $( this ).closest( '[data-filter]' ).data( 'filter' );
      var choice = $( this ).attr( 'value' );
      var select = '[data-' + filter + '*="' + choice + '"]';

      option.push( select );
    } );

    $( '[data-filter] .is-active' ).each( function() {
      var filter = $( this ).closest( '[data-filter]' ).data( 'filter' );
      var choice = $( this ).find( 'a' ).attr( 'title' );

      if ( ! choice ) {
        choice = $( this ).find( 'a' ).text();
      }

      var select = '[data-' + filter + '*="' + choice + '"]';

      option.push( select );
    } );

    /**
     * Clicking [data-filter-clear] element triggers 'change'
     * on the select and the option array will be empty.
     */
    if ( ! Array.isArray( option ) || ! option.length ) {
      $( '[data-filter]' ).each( function() {
        var filter = $( this ).closest( '[data-filter]' ).data( 'filter' );
        var select = '[data-' + filter + ']';

        option.push( select );
      } );
    }

    // Remove separators from array to become one selector
    option = option.join( '' );

    var results = $( option );

    // if ( results.length > 6 ) {
    //   $( '.show-more' ).show();
    // } else {
    //   $( '.show-more' ).hide();
    // }

    // if ( ! results.length ) {
    //   $( '.no-results' ).show();
    //   $( '.show-more' ).hide();
    // } else {
    //   $( '.no-results' ).hide();
    // }

    // Show elements that match the filtered options
    // (added .not( '[data-scan-hidden="true"]' ) to compliment searhing)
    results.attr( 'data-filter-hidden', false );
    results.not( '[data-scan-hidden="true"]' ).css( 'display', display );

    // Show filter alert if no results
    if ( results.length < 1 ) {
      var showtext = $( '.filter-show' ).text();

      // Prevent duplicate alerts
      $( '.filter-alert p' ).remove();

      // $( '.filter-alert' ).prepend( '<p><span>There are no results matching those options.</span>Try refreshing your search using the ' + showtext + ' button.</p>' ).show();

      $( '.filter-alert' ).prepend( "<p><span>There are no results matching those options.</span>If you're not finding what you're looking for check out <a href='/ebcap/community-programs'>EBCAP's Community Programs</a> Page.</p>" ).show();
    }

    // reload pagination

    reload_pagination();
  } );

  // $( '[data-filter-clear]' ).on( 'click', function( e ) {
  //   e.preventDefault();

  //   var clear = $( this ).data( 'filter-clear' ).replace( /\s/g, '' ).split( ',' );

  //   for ( var i = 0; i < clear.length; i++ ) {
  //     c = $( '[data-filter="' + clear[ i ] + '"]' );

  //     c.find( 'select option:first' ).prop( 'selected', true ).trigger( 'chosen:updated' ).trigger( 'change' );
  //   }
  // } );

  // $( document ).ready( function() {
  //   $( '[data-pagination] a' ).on( 'click', function( e ) {
  //     e.preventDefault();

  //     e.stopImmediatePropagation();

  //     e.stopPropagation();

  //     return false;
  //   } );
  // } );

  // search filter

  jQuery.expr[':']._contains = function( a, i, m ) {
    return ( a.textContent || a.innerText || '' ).toLowerCase().indexOf( m[3].toLowerCase() ) >= 0;
  };

  var search_filter_input = $( '[data-scan]' );

  search_filter_input.each( function() {
    var filter = $( this ).attr( 'data-scan' );
    var target = $( this ).attr( 'data-scan-target' );
    var display = $( this ).attr( 'data-scan-display' );

    if ( ! display ) {
      var display = 'block';
    }

    // By default set all elements not already
    // scan hidden to data-scan-hidden="false"
    $( filter ).not( '[data-scan-hidden="true"]' ).attr( 'data-scan-hidden', false );

    $( this ).on( 'input', function() {
      var input = $( this ).val();

      if ( input ) {
        $( filter ).find( '' + target + ':not(:_contains(' + input + '))' ).closest( $( filter ) ).not( '[data-filter-hidden="true"]' ).attr( 'data-scan-hidden', true ).css( 'display', 'none' );
        $( filter ).find( '' + target + ':_contains(' + input + ')' ).closest( $( filter ) ).not( '[data-filter-hidden="true"]' ).attr( 'data-scan-hidden', false ).css( 'display', display );
      } else {
        $( filter ).not( '[data-filter-hidden="true"]' ).attr( 'data-scan-hidden', false ).css( 'display', display );
      }

      // reload pagination

      $( '[data-pagination]' ).each( function() {
        var pagination = $( this );
        var target = pagination.attr( 'data-pagination' );
        var $target = $( target ).not( '[style="display: none;"]' );
        var limit = pagination.attr( 'data-pagination-limit' );
        var page_total = Math.ceil( $target.not( '[data-scan-hidden="true"]' ).length / limit );
        var current = pagination.attr( 'data-pagination-current' );
        var display = pagination.attr( 'data-pagination-display' );

        pagination.add( pagination.parent( 'nav' ) ).attr( 'data-pagination-total', page_total );

        $( target ).attr( 'data-pagination-page', 0 );

        $target.each( function( i ) {
          var page = Math.ceil( ( i + 1 ) / limit );

          $( this ).attr( 'data-pagination-page', 0 );
          $( this ).attr( 'data-pagination-page', page );
        } );

        pagination.children( 'li' ).not( '.pagination-next, .pagination-prev' ).remove();

        for ( var i = 0; i < page_total; i++ ) {
          $( this ).append( '<li><a data-pagination-nav="' + ( i + 1 ) + '" href="#">' + ( i + 1 ) + '</a></li>' );
        }

        pagination.append( $( '.pagination-next' ) );

        // reset current page attribute to 1 after filtering
        pagination.attr( 'data-pagination-current', 1 );

        $target.attr( 'data-pagination-hidden', true ).css( 'display', 'none' );

        $( '[data-pagination-page="1"]' ).attr( 'data-pagination-hidden', false ).css( 'display', display );

        $( '[data-pagination-nav]' ).removeClass( 'is-active' );

        $( '[data-pagination-nav="1"]' ).addClass( 'is-active' );
      } );
    } );
  } );

  /**
   * Sortby
   */
  function sortMeBy( arg, sel, elem, order ) {
    var $selector = $( sel ),
      $element = $selector.children( elem );

    $element.sort( function( a, b ) {
      var an = parseInt( a.getAttribute( arg ) ),
        bn = parseInt( b.getAttribute( arg ) );

      if ( order == 'asc' ) {
        if ( an > bn )
          return 1;
        if ( an < bn )
          return -1;
      } else if ( order == 'desc' ) {
        if ( an < bn )
          return 1;
        if ( an > bn )
          return -1;
      }

      return 0;
    } );

    $element.detach().appendTo( $selector );
  }

  /**
   * jQuery Sorting
   *
   * (https://j11y.io/javascript/sorting-elements-with-jquery)
   */
   jQuery.fn.sortElements = ( function() {
    var sort = [].sort;

    return function( comparator, getSortable ) {
      getSortable = getSortable || function() {
        return this;
      };

      var placements = this.map( function() {
        var sortElement = getSortable.call( this ),
          parentNode = sortElement.parentNode,

          // Since the element itself will change position, we have
          // to have some way of storing its original position in
          // the DOM. The easiest way is to have a 'flag' node:
          nextSibling = parentNode.insertBefore( document.createTextNode( '' ), sortElement.nextSibling );

        return function() {
          if ( parentNode === this ) {
            throw new Error( "You can't sort elements if any one is a descendant of another." );
          }

          // Insert before flag:
          parentNode.insertBefore( this, nextSibling );

          // Remove flag:
          parentNode.removeChild( nextSibling );
        };
      } );

      return sort.call( this, comparator ).each( function( i ) {
        placements[ i ].call( getSortable.call( this ) );
      } );
    };
  } )();

  /**
   * Sort News Feed
   */

  var sort_feed_alpha = function() {
    $( '.feed .cell' ).sortElements( function( a, b ) {
      return $( a ).find( 'h6 a' ).text().toLowerCase() > $( b ).find( 'h6 a' ).text().toLowerCase() ? 1 : -1;
    } );

    $( '.feed .cell' ).each( function() {
      var display = $( this ).attr( 'data-display' );

      $( this ).not( '[data-filter-hidden="true"]' ).not( '[data-scan-hidden="true"]' ).css( 'display', display );
    } );
  };

  var sort_feed_alpha_desc = function() {
    $( '.feed .cell' ).sortElements( function( a, b ) {
      return $( a ).find( 'h6 a' ).text().toLowerCase() < $( b ).find( 'h6 a' ).text().toLowerCase() ? 1 : -1;
    } );

    $( '.feed .cell' ).each( function() {
      var display = $( this ).attr( 'data-display' );

      $( this ).css( 'display', display );
    } );
  };

  var sort_feed_recent = function() {
    sortMeBy( 'data-date-order', '.feed .grid', '.cell', 'asc' );
  };

  var sort_feed_recent_desc = function() {
    sortMeBy( 'data-date-order', '.feed .grid', '.cell', 'desc' );
  };

  var reset_links_sort_feed = function() {
    $( '[data-filter] a[href*="sort=alpha"]' ).attr( 'href', '?sort=alpha#news-feed' );
    $( '[data-filter] a[href*="sort=recent"]' ).attr( 'href', '?sort=recent#news-feed' );
  };

  $( '[data-filter] a[href*="sort="]' ).on( 'click', function( e ) {
    e.preventDefault();

    if ( $( this ).is( '[href*="sort=alpha-desc"]' ) ) {
      sort_feed_alpha_desc();

      $( this ).attr( 'href', '?sort=alpha' );
    } else if ( $( this ).is( '[href*="sort=alpha"]' ) ) {
      sort_feed_alpha();

      $( this ).attr( 'href', '?sort=alpha-desc' );
    } else if ( $( this ).is( '[href*="sort=recent-desc"]' ) ) {
      sort_feed_recent_desc();

      $( this ).attr( 'href', '?sort=recent' );
    } else if ( $( this ).is( '[href*="sort=recent"]' ) ) {
      sort_feed_recent();

      $( this ).attr( 'href', '?sort=recent-desc' );
    }
  } );

  /**
   * Call Chosen.
   *
   * JS below for form and Chosen to be reorganized. 
   */

  $(document).ready(function() {
    $('nav select').chosen({
      width: '100%'
    });
  });

  /**
   * Form
   */

  $(document).ready(function() {
    $('form select').chosen({
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

  $(document).on('click', function(e) {
    if (! $(e.target).closest('.sidebar-filter .dropdown > button, .sidebar-filter .chosen-container').length) {
      $('.sidebar-filter .dropdown, .sidebar-filter .chosen-container').css('marginTop', '0');
    }
  });

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
      }, 275 );
    }
  } );

  $( '#accessory .close' ).on( 'click', function( e ) {
    e.preventDefault();

    var classToggle = $( this ).add( $( 'body, #accessory, #accessory-toggle, #header, #page' ) );

    classToggle.addClass( 'is-closed is-closing' ).removeClass( 'is-open' );

    setTimeout( function() {
      classToggle.removeClass( 'is-closing' );
    }, 275 );
  } );

  $( '#accessory-toggle' ).on( 'click', function() {
    var classToggle = $( this ).add( $( this ).parent() ).add( $( 'body, #accessory, #accessory-toggle, #header, #page' ) );

    if ( $( '#accessory' ).hasClass( 'is-open' ) ) {
      classToggle.addClass( 'is-closed is-closing' ).removeClass( 'is-open' );

      setTimeout( function() {
        classToggle.removeClass( 'is-closing' );
      }, 275 );
    } else {
      classToggle.addClass( 'is-open is-opening' ).removeClass( 'is-closed' );

      setTimeout( function() {
        classToggle.removeClass( 'is-opening' );
      }, 275 );
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

  $( '#accessory-menu .menu-item-has-children > a' ).on( 'click', function( e ) {
    e.preventDefault();
    e.stopPropagation();

    if ( $( this ).parent( 'li' ).hasClass( 'is-open' ) ) {
      $( this ).next( 'ul' ).slideUp( 275 );
      $( this ).parent( 'li' ).removeClass( 'is-open' );
    } else {
      $( this ).next( 'ul' ).slideDown( 275 );
      $( this ).parent( 'li' ).addClass( 'is-open' );
    }
  } );

  $( '#accessory-menu .menu-item-has-children a span:first-child' ).on( 'click', function( e ) {
    e.preventDefault();
    e.stopPropagation();

    if ( ! $( this ).is( '.nolink, .no-link' ) && ! $( this ).closest( 'li' ).is( '.nolink, .no-link' ) && ! $( this ).parent().is( '.nolink, .no-link' ) ) {
      window.location.href = $( this ).parent().attr( 'href' );
    } else if ( $( this ).parent( '.menu-item-has-children' ) || $( this ).parent().parent( '.menu-item-has-children' ) ) {
      if ( $( this ).closest( '.menu-item-has-children' ).hasClass( 'is-open' ) ) {
        $( this ).closest( '.menu-item-has-children' ).find( 'ul' ).first().slideUp( 275 );
        $( this ).closest( '.menu-item-has-children' ).removeClass( 'is-open' );
      } else {
        $( this ).closest( '.menu-item-has-children' ).find( 'ul' ).first().slideDown( 275 );
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
    var element = $( 'h1, .line-heading h2, .list-3-col > li > h4, .list-4-col > li > h4, .page-header .entry-content p, .prevent-orphan, .footer-grid__cell h4, .footer-grid__cell button, .footer-grid__cell .button, .page-header .entry-content p' );

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
    $( 'p, h1, h2, h3, h4, h5, h6' ).each( function() {
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
        var speed = 275;
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

      if ($('body').hasClass('page-template-grantmaking-process')) {
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
        var speed = 275;
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
   * Tabbed Content
   */

  $( '.tabset' ).each( function() {
    var tab = $( this ).find( '[role="tab"]' );
    var all_panel = $( this ).find( '[role="tabpanel"]' );

    tab.each( function( e ) {
      var panel = '#' + $( this ).attr( 'aria-controls' );
      var panel_container = $( this ).closest( '.tabset' ).find( '.tabset__panel' );

      $( this ).on( 'click', function( e ) {
        e.preventDefault();

        all_panel.removeClass( 'is-active' );
        tab.removeClass( 'is-active' );

        $( this ).addClass( 'is-active' );
        $( panel ).addClass( 'is-active' );

        panel_container.attr( 'data-active-panel', panel );
      } );
    } );
  } );

  $( '.tabset-hover' ).each( function() {
    var tab = $( this ).find( '[role="tab"]' );
    var all_panel = $( this ).find( '[role="tabpanel"]' );

    tab.each( function() {
      var panel = '#' + $( this ).attr( 'aria-controls' );

      $( this ).on( {
        mouseenter: function() {
          all_panel.removeClass( 'is-active' );
          tab.removeClass( 'is-active' );
          $( this ).addClass( 'is-active' );
          $( panel ).addClass( 'is-active' );
        },
        // mouseleave: function() {
        //   $( panel ).removeClass( 'is-active' );
        // }
      } );
    } );

    $( this ).on( 'click', function( e ) {
      e.preventDefault();
    } );
  } );

  var minHeight_tabpanel = function() {
    $( '.tabset' ).each( function() {
      var minHeight = 0;
      var panel = $( this ).find( '[role="tabpanel"]' );
      var parent = $( this ).find( '.tabset__panel' );

      panel.each( function() {
        if ( $( this ).height() > minHeight ) {
          minHeight = $( this ).height();
        }
      } );

      parent.css( 'minHeight', minHeight );
    } );
  };

  $( document ).ready( function() {
    minHeight_tabpanel();
  } );

  $( window ).on( 'resize', function() {
    setTimeout( minHeight_tabpanel, 400 );
  } );

  /**
   * Accordion
   */

  // Hide inactive panels
  // $( '.accordion' ).each( function() {
  //   if ( ! $( this ).hasClass( 'is-open' ) ) {
  //     $( this ).children( '.accordion__panel' ).hide();
  //   }
  // } );

  // $( '.accordion__title' ).on( 'click', function( e ) {
  //   e.preventDefault();

  //   if ( $( this ).parent( '.accordion' ).hasClass( 'is-open' ) ) {
  //     $( this ).next( '.accordion__panel' ).slideUp( 275 );
  //     $( this ).parent( '.accordion' ).removeClass( 'is-open' );
  //   } else {
  //     $( this ).next( '.accordion__panel' ).slideDown( 275 );
  //     $( this ).parent( '.accordion' ).addClass( 'is-open' );
  //   }
  // } );

  /**
   * Vendor: Magnific Popup
   */

  // $( '.gallery__image' ).magnificPopup( {
  //   type: 'image',
  //   gallery: {
  //     enabled: true
  //   }
  // } );

  $('[href="#hire-talent-form"]').magnificPopup({
    type: 'inline',
    midClick: true,
    removalDelay: 275
  });

  $('[href="#submit-resume-form"]').magnificPopup({
    type: 'inline',
    midClick: true,
    removalDelay: 275
  });

  $('.close').on('click', function() {
    $.magnificPopup.close();
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
   * Template: Team
   */

  var team_intro_equal_width = function() {
    var equalize = $( '.team-intro .team-intro-equalize' );
    var maxHeight = 0;

    if ( window.matchMedia( '(min-width: 768px)' ).matches ) {
      equalize.each( function() {
        $( this ).css( 'height', 'auto' );

        if ( $( this ).height() > maxHeight ) {
          maxHeight = $( this ).height() + .01;
        }
      } );

      equalize.height( maxHeight );
    } else {
      equalize.css( 'height', 'auto' );
    }
  };

  team_intro_equal_width();

  $( window ).on( 'resize', function() {
    setTimeout( team_intro_equal_width, 300 );
  } );

  /**
   * Language Navigation
   */

  $( '#language-menu li' ).each( function() {
    var index = parseInt( $( this ).index() + 1 );
    var href = $( this ).children( 'a' ).first().attr( 'href' );

    $( this ).children( 'a' ).first().attr( 'href', href + '?language=' + index + '' );
  } );

  $( '#accessory-language-menu li' ).each( function() {
    var index = parseInt( $( this ).index() + 1 );
    var href = $( this ).children( 'a' ).first().attr( 'href' );

    $( this ).children( 'a' ).first().attr( 'href', href + '?language=' + index + '' );
  } );

  if ( qurl( 'language' ) ) {
    var language = qurl( 'language' );

    $( '#language-menu' ).children().removeClass( 'is-active' );
    $( '#language-menu li:nth-child(' + language + ')' ).addClass( 'is-active' );
  } else {
    $( '#language-menu' ).children().first().addClass( 'is-active' );
  }

  /**
   * Link List
   */

  $( document ).ready( function() {
    $( '.link-list' ).each( function() {
      var li = $( this ).find( 'li a' );
      var svg = '<svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 21 16"><path d="M13 0l-1.41 1.41L17.17 7H0v2h17.17l-5.58 5.59L13 16l8-8z"/></svg>';

      li.append( svg );
    } );
  } );

  /**
   * Newsletter
   */

  $( document ).ready( function() {
    setTimeout( function() {
      var form = $( '.newsletter' ).find( 'form' );
      var input = $( '.newsletter' ).find( 'input[type="email"]' );
      var svg = '<svg class="form__arrow" viewBox="0 0 8 13" xmlns="http://www.w3.org/2000/svg"><path d="M1.868 0L0 1.99 4.237 6.5 0 11.01 1.868 13 8 6.5z"/></svg>';

      form.append( svg );
      input.attr( 'placeholder', 'E-mail' );
    }, 300 );

    /**
     * Repeat same settimeout function as above with
     * longer time in case it did not load yet.
     */
    setTimeout( function() {
      var form = $( '.newsletter' ).find( 'form' );
      var input = $( '.newsletter' ).find( 'input[type="email"]' );
      var svg = '<svg class="form__arrow" viewBox="0 0 8 13" xmlns="http://www.w3.org/2000/svg"><path d="M1.868 0L0 1.99 4.237 6.5 0 11.01 1.868 13 8 6.5z"/></svg>';

      if ( ! form.find( '.form__arrow' ).length ) {
        form.append( svg );
      }

      input.attr( 'placeholder', 'E-mail' );
    }, 1200 );
  } );

  /**
   * Newsletter Button
   */

  var footer_newsletter_button = function() {
    var flex_container = $( '.newsletter .ginput_container_email' );
    var newsletter_button = flex_container.closest( 'form' ).find( '[type="submit"]' );

    if ( newsletter_button.parent( '.button' ).length ) {
      newsletter_button = newsletter_button.parent();
    }

    flex_container.append( newsletter_button );
  };

  jQuery( document ).on( 'gform_post_render', function( e, form_id ) {
    if ( jQuery( 'div.validation_error' ).length > 0 ) {
      footer_newsletter_button();

      $( '.newsletter .ginput_container_email .button' ).on( {
        mouseenter: function() {
          $( this ).add( $( this ).prev() ).addClass( 'is-hover' );
        },
        mouseleave: function() {
          $( this ).add( $( this ).prev() ).removeClass( 'is-hover' );
        }
      } );
    }
  } );

  $( document ).ready( function() {
    footer_newsletter_button();

    $( '.newsletter .ginput_container_email .button' ).on( {
      mouseenter: function() {
        $( this ).add( $( this ).prev() ).addClass( 'is-hover' );
      },
      mouseleave: function() {
        $( this ).add( $( this ).prev() ).removeClass( 'is-hover' );
      }
    } );
  } );

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

  $( '.file-upload input[type="file"]' ).on( 'change', function() {
    var t = $( this );
    var label = t.closest( 'label' );

    if ( ! label.length > 0 ) {
      label = t.closest( 'li' ).find( 'label' );
    }

    if ( label.find( '.label-text' ).length > 0 ) {
      label = label.find( '.label-text' );
    }

    if ( ! t.get( 0 ).files.length == 0 ) {
      label.text( t.get( 0 ).files[0].name );
    }
  } );

  // var file_inputs = document.querySelectorAll( '.file-upload input[type="file"]' );

  // Array.prototype.forEach.call( file_inputs, function( input ) {
  //   var label  = input.nextElementSibling,
  //     labelVal = label.innerHTML;

  //   input.addEventListener( 'change', function( e ) {
  //     var fileName = '';

  //     if ( this.files && this.files.length > 1 ) {
  //       fileName = ( this.getAttribute( 'data-multiple-caption' ) || '' ).replace( '{count}', this.files.length );
  //     } else {
  //       fileName = e.target.value.split( '\\' ).pop();
  //     }

  //     if ( fileName )
  //       label.querySelector( 'span' ).innerHTML = fileName;
  //     else
  //       label.innerHTML = labelVal;
  //   } );
  // } );

  /**
   * Template Careers
   */

  function replaceElementTag(targetSelector, newTagString) {
    $(targetSelector).each(function() {
      var newElem = $(newTagString, { html: $(this).html() });

      $.each(this.attributes, function() {
        newElem.attr(this.name, this.value);
      });

      $(this).replaceWith(newElem);
    });
  }

  $( document ).ready( function() {
    $('.careers-list-item-form').each( function() {
      var input = $( this ).find( 'input[type="file"]' );
      var input_id = input.attr( 'id' );

      input.attr( 'id', input_id + '-1' );

      $( this ).wrap( '<noscript></noscript>' ).addClass( 'is-inactive' );
    } );
  } );

  $('.accordion-list-anchor').on('click', function(e) {
    e.preventDefault();

    var li = $(this).closest('li'),
      li_all = $(this).closest('ul').find('li'),
      content = li.find('.accordion-list-content'),
      content_all = li_all.find('.accordion-list-content'),
      form = li.find('form');

    var careers_list_forms = $('#careers-list').find('form');
    var current_form = li.find('.careers-list-item-form');
    var current_form_id = current_form.find('input[type="file"]').attr('id');
    var file_input_id = $('.careers-list-item-form').find('input[type="file"]').attr('id');

    li_all.not(li).removeClass('is-active');

    content_all.not(content).slideUp(250);

    li_all.find('.careers-list-item-form-validation-message').addClass('screen-reader-text');

    var all_input = $('.careers-list-item-form').not('.is-inactive').find('input[type="file"]');
    var all_input_id = all_input.attr('id');

    all_input.attr('id', all_input_id + '-1');

    setTimeout(function() {
      $('.careers-list-item-form').not(current_form).not('.is-inactive').wrap('<noscript></noscript>').addClass('is-inactive');
    }, 250);

    if (li.hasClass('is-active') ) {
      li.removeClass('is-active');

      content.slideUp(250);

      setTimeout(function() {
        li.find('.careers-list-item-form').wrap('<noscript></noscript>').addClass('is-inactive');
      }, 250);

      li.find('.careers-list-item-form-validation-message').addClass('screen-reader-text');
    } else {
      current_form.unwrap('noscript').removeClass('is-inactive');
      current_form.find('input[type="file"]').attr('id', current_form_id.slice(0, -2));

      li.addClass('is-active');

      content.slideDown(250);

      var form = li.find('form');
      var form_file_input = form.find('input[type="file"]');
      var form_submit = form.find('[type="submit"]');

      form_submit.on('click', function(e) {
        e.preventDefault();

        if ($(this).closest('li').find('input[type="file"]').get(0).files.length === 0) {
          li.find('.careers-list-item-form-validation-message').removeClass('screen-reader-text');
        } else {
          $(this).closest('form').submit();
        }
      });
    }

    /**
     * Help test for each input id and parent tagName.
     */
    // $( '[name="input_2"]' ).each( function() {
    //   var form = $( this ).closest( '.careers-list-item-form' );

    //   alert( 'id is: ' + $( this ).attr( 'id' ) + ' and parent tag is: ' + form.parent().get( 0 ).tagName );
    // } );
  });

  $( '.accordion-list-title' ).on( {
    mouseenter: function() {
      $( this ).closest( 'li' ).addClass( 'is-hover' );
    },
    mouseleave: function() {
      $( this ).closest( 'li' ).removeClass( 'is-hover' );
    }
  } );

  /**
   * Prepend SVG to file input.
   *
   * Wrap label text in span.
   */
  $( document ).ready( function() {
    $( '.file-upload' ).each( function() {
      var fileLabelSvg = jQuery( '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 37"><path d="M2.069 35.709c-1.162-.844-1.842-1.91-2.023-3.17-.226-1.578.42-3.084 1.042-3.894l15.178-19.76.017-.02c.064-.077 1.584-1.874 3.583-2.034.993-.08 1.917.248 2.747.973 2.51 2.195 1.658 4.721.857 5.751L10.817 29.77c-.224.287-.634.335-.916.107-.282-.227-.33-.644-.106-.93l12.653-16.214c.152-.2 1.454-2.053-.686-3.923-.564-.493-1.151-.708-1.794-.657-1.388.111-2.589 1.452-2.685 1.562L2.116 29.461c-.374.486-.958 1.641-.78 2.886.128.893.633 1.663 1.5 2.29l.021.016c1.32 1.04 2.729 1.288 4.188.738 1.002-.378 1.701-1.02 1.827-1.14.775-.987 17.84-22.721 18.64-23.885 1.84-2.674 1.54-5.161-.893-7.392-1.284-1.178-2.589-1.728-3.878-1.639-1.821.128-3.115 1.468-3.587 2.038-1.158 1.414-15.927 20.309-16.076 20.5-.224.286-.634.334-.916.106-.282-.227-.329-.644-.105-.93.61-.78 14.927-19.098 16.097-20.527.581-.702 2.178-2.346 4.498-2.509 1.655-.117 3.284.55 4.84 1.977 2.916 2.674 3.303 5.918 1.089 9.135-.839 1.22-17.986 23.057-18.716 23.986-.014.018-.03.036-.046.052-.037.039-.932.947-2.32 1.47-.545.206-1.208.367-1.95.367-1.044 0-2.244-.32-3.48-1.291z"/></svg>' );
      var label = $( this ).find( 'label' );
      var gfield_required = label.find( '.gfield_required' );

      gfield_required.detach();

      var label_text = label.text();

      label.attr( 'data-label', label_text );

      label.wrapInner( '<span class="label-text"></span>' );

      gfield_required.insertAfter( label.find( '.label-text' ) );

      label.prepend( fileLabelSvg );
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
    var headersIdsListMobile = $('.content-single .aside-post-navigation-mobile');

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

    var blockFeed = $('.block-feed.block-feed--images');
    var blockFeedTitleHead = $('.block-feed-title-head');

    var links = $('.feed-options-bar a, #filter-categories-list a');

    var styleFix = $('<style id="posts-wrap-transition-fix">.feed-section__posts * { transition: none !important; }</style>');

    $('body').append(styleFix);

    setTimeout(function() {
      $('#posts-wrap-transition-fix').remove();
    }, 200);

    blockFeed.toggleClass('block-feed--list');
    blockFeedTitleHead.toggleClass('is-active');

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
});