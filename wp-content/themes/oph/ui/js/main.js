jQuery(function ($) {
  // Used for cookie setting - only remember the top level to avoid creating additional cookies for pagination pages
  var rootPageName = window.location.pathname.split("/")[1] || "";

  /**
   * Fix dark mode flash.
   */
  $(document).ready(function () {
    $("#fix-dark-mode-flash").remove();
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
  function qurl(q) {
    var x = window.location.search.substring(1);
    var s = x.split("&");

    for (var i = 0; i < s.length; i++) {
      var pair = s[i].split("=");

      if (pair[0] === q) {
        return pair[1];
      }
    }
  }

  function hash() {
    return window.location.hash.substr(1).replace("#", "");
  }

  function select2CopyClasses(data, container) {
    if (data.element) {
      $(container).addClass($(data.element).attr("class"));
    }

    return data.text;
  }

  /**
   * Fix for the Select2 Bullshit
   */

  // Find all select options
  function getOptions(select) {
    var options = $(select).children("option").not(".filler-option");
    getParents(options);
  }
  // Get parent data for all options
  function getParents(options) {
    $(options).each(function () {
      var parent = $(this).data("parent");
      getLevel(this, parent, 1);
    });

    sortOptions(options, 2);
  }
  // Get sub-levels
  function getLevel(element, parent, iteration) {
    if (parent == 0) {
      addLevel(element, iteration);
    } else {
      var parentSelect, parentElem, parentData;
      parentSelect = $(element).parent();
      parentElem = $(parentSelect).children(
        "option[data-termID=" + parent + "]"
      );
      iteration++;
      parentData = $(parentElem).data("parent");
      getLevel(element, parentData, iteration);
    }
  }
  // Add level as CSS class
  function addLevel(element, level) {
    var classLevel = "level-" + level;
    $(element).addClass(classLevel);
  }

  function sortOptions(options, iteration) {
    var currentLevel, currentOptions;
    currentLevel = "level-" + iteration;
    currentOptions = [];

    $(options).each(function () {
      if ($(this).hasClass(currentLevel)) {
        currentOptions.push(this);
      }
    });

    if ($(currentOptions).length) {
      $(currentOptions).each(function () {
        var parent, parentSelect, parentElem;
        parent = $(this).data("parent");
        parentSelect = $(this).parent();
        parentElem = $(parentSelect).children(
          "option[data-termID=" + parent + "]"
        );
        $(this).insertAfter(parentElem);
      });
      iteration++;
      sortOptions(options, iteration);
    }
  }

  $(document).ready(function () {
    var contentSelect, focusSelect;
    contentSelect = $('select[data-filter="content-type"]');
    focusSelect = $('select[data-filter="focus-area"]');
    getOptions(contentSelect);
    getOptions(focusSelect);
  });

  /**
   * Call Select2
   */
  $(document).ready(function () {
    $("nav select").select2({
      searchInputPlaceholder: "Type here to search ...",
      // Hides the search on career's page | For other pages requires at least 5 results for the search to show
      minimumResultsForSearch: $("body.page-template-careers").length
        ? Infinity
        : 5,
      templateResult: select2CopyClasses,
      templateSelection: select2CopyClasses,
    });

    var sidebarSelect = $(".sidebar-filter select").select2({
      dropdownCssClass: "sidebar-filter-dropdown",
      searchInputPlaceholder: "Type here to search ...",
      minimumResultsForSearch: 5,
      templateResult: select2CopyClasses,
      templateSelection: select2CopyClasses,
      // closeOnSelect: false,
      // allowClear: true,
      // multiple: true,
    });

    $(sidebarSelect).on("select2:select", function (e) {
      var element, classes;
      element = e.params.data.element;
      classes = e.params.data.element.className;
      console.log(classes);

      $(element).addClass("active");
    });

    /**
     * Wrap dropdown on open. Inner div helps with rounded corners
     * that have overflow hidden and pseudo element outside.
     */
    $("nav select").on("select2:open", function (e) {
      $(".select2-dropdown-inner").contents().unwrap();

      $(".select2-dropdown").wrapInner(
        '<div class="select2-dropdown-inner"></div'
      );

      if ($(".select2-dropdown").children(".select2-dropdown-inner").length) {
        $(".select2-dropdown").addClass("has-inner");
      }

      // Set search field to focus
      setTimeout(function () {
        $("input.select2-search__field")[0].focus();
      }, 10);
    });
  });

  /**
   * Dropdown - move items down.
   */

  // Close all on click outside
  $(document).on("mousedown", function (e) {
    if (!$(e.target).closest(".sidebar-filter .select2").length) {
      $(".sidebar-filter .select2").css("marginTop", "0");

      $(".sidebar-filter").removeClass("has-select-open");
    }
  });

  $("nav select").on("select2:close", function (e) {
    $(this).next(".select2").nextAll(".select2:first").css("marginTop", "0");
  });

  $(".sidebar-filter select").on("select2:open", function (e) {
    var height = $(".select2-dropdown").height();
    var nextItem = $(this).next(".select2").nextAll(".select2:first");
    var marginTop = 173 + 16 + "px"; // Using hard-code value of 173 instead of the 'height' variable

    // Set pointer-events to none to prevent undesired selection
    $(".select2-dropdown ul").css("pointerEvents", "none");

    // Set pointer-events back to normal
    setTimeout(function () {
      $(".select2-dropdown ul").css("pointerEvents", "auto");
    }, 300);

    $(this).css("marginTop", "0");
    $(this).siblings(".select2").css("marginTop", "0");

    if ($(this).next(".select2").hasClass("select2-container--below")) {
      nextItem.css("marginTop", marginTop);
    } else {
      nextItem.css("marginTop", "0");
    }
  });

  /**
   * Image Ratio
   */

  var image_ratio = function () {
    "use strict";

    var images_parent = document.querySelector("[data-proportional-image]");
    var images = document.querySelectorAll("[data-proportional-image] img");

    if (images_parent) {
      var data_widthBase = images_parent.getAttribute("data-width-base");
      var data_scaleFactor = images_parent.getAttribute("data-scale");
    }

    function adjustImageWidth(image) {
      if (data_widthBase) {
        var widthBase = data_widthBase;
      } else {
        var widthBase = 110;
      }

      if (data_scaleFactor) {
        var scaleFactor = data_scaleFactor;
      } else {
        var scaleFactor = 0.375;
      }

      var imageRatio = image.naturalWidth / image.naturalHeight;

      image.style.width = Math.pow(imageRatio, scaleFactor) * widthBase + "px";
    }

    images.forEach(adjustImageWidth);
  };

  $(document).ready(function () {
    image_ratio();
  });

  $(window).on("load", function () {
    image_ratio();
  });

  $(window).on("resize", function () {
    setTimeout(image_ratio, 400);
  });

  /**
   * Navigation
   */

  $(document).on("click touchend", function (e) {
    var classToggle = $("body, #accessory, #accessory-toggle, #header, #page");

    if (
      $("#accessory").hasClass("is-open") &&
      $(e.target).closest("body").length &&
      !$(e.target).closest("#accessory, #accessory-toggle").length
    ) {
      classToggle.addClass("is-closed is-closing").removeClass("is-open");

      setTimeout(function () {
        classToggle.removeClass("is-closing");
      }, 250);
    }
  });

  $("#accessory .close").on("click", function (e) {
    e.preventDefault();

    var classToggle = $(this).add(
      $("body, #accessory, #accessory-toggle, #header, #page")
    );

    classToggle.addClass("is-closed is-closing").removeClass("is-open");

    setTimeout(function () {
      classToggle.removeClass("is-closing");
    }, 250);
  });

  $("#accessory-toggle").on("click", function () {
    var classToggle = $(this)
      .add($(this).parent())
      .add($("body, #accessory, #accessory-toggle, #header, #page"));

    if ($("#accessory").hasClass("is-open")) {
      classToggle.addClass("is-closed is-closing").removeClass("is-open");

      setTimeout(function () {
        classToggle.removeClass("is-closing");
      }, 250);
    } else {
      classToggle.addClass("is-open is-opening").removeClass("is-closed");

      setTimeout(function () {
        classToggle.removeClass("is-opening");
      }, 250);
    }
  });

  var closeMenuDesktop = function () {
    if (window.matchMedia("(min-width: 1024px)").matches) {
      $("#main").removeClass("is-open");
    }
  };

  $(document).ready(function () {
    closeMenuDesktop();
  });

  $(window).on("resize", function () {
    setTimeout(closeMenuDesktop, 400);
  });

  /**
   * Navigation Path Helper
   *
   * Insert a span after sub menu.
   * In the CSS it will be positioned behind the
   * menu to help with mouse path.
   */

  $(document).ready(function () {
    var primary_menu_li = $("#primary-menu li");

    primary_menu_li.each(function () {
      var sub_menu = $(this).children("ul").first();

      if (sub_menu) {
        sub_menu.wrap('<span class="menu-path-helper"></span>');
      }
    });
  });

  // Add menu elements to create scroll
  // $( document ).ready( function() {
  //   var e = $( '#menu-item-190' );

  //   for ( var i = 0; i < 10; i++ ) {
  //     e.clone().insertAfter( e );
  //   }
  // } );

  $("#accessory-menu .menu-item-has-children > a").on("click", function (e) {
    e.preventDefault();

    e.stopPropagation();

    // Prevent multiple open
    $(this)
      .closest("ul")
      .children("li.menu-item-has-children")
      .children("ul")
      .slideUp(250);
    $(this)
      .closest("ul")
      .children("li")
      .not($(this).parent("li"))
      .removeClass("is-open");

    if ($(this).parent("li").hasClass("is-open")) {
      $(this).next("ul").slideUp(250);
      $(this).parent("li").removeClass("is-open");
    } else {
      $(this).next("ul").slideDown(250);
      $(this).parent("li").addClass("is-open");
    }
  });

  $("#accessory-menu .menu-item-has-children a span:first-child").on(
    "click",
    function (e) {
      e.preventDefault();
      e.stopPropagation();

      if (
        !$(this).is(".nolink, .no-link") &&
        !$(this).closest("li").is(".nolink, .no-link") &&
        !$(this).parent().is(".nolink, .no-link")
      ) {
        window.location.href = $(this).parent().attr("href");
      } else if (
        $(this).parent(".menu-item-has-children") ||
        $(this).parent().parent(".menu-item-has-children")
      ) {
        if ($(this).closest(".menu-item-has-children").hasClass("is-open")) {
          $(this)
            .closest(".menu-item-has-children")
            .find("ul")
            .first()
            .slideUp(250);
          $(this).closest(".menu-item-has-children").removeClass("is-open");
        } else {
          $(this)
            .closest(".menu-item-has-children")
            .find("ul")
            .first()
            .slideDown(250);
          $(this).closest(".menu-item-has-children").addClass("is-open");
        }
      }
    }
  );

  $(".logo__mark, .logo__type").on({
    mouseenter: function () {
      $("#header .logo").addClass("is-hover");
    },
    mouseleave: function () {
      $("#header .logo").removeClass("is-hover");
    },
  });

  /**
   * Prevent Link.
   */
  $(document).ready(function () {
    $("a.nolink, a.no-link, .nolink > a, .no-link > a").on(
      "click",
      function (e) {
        e.preventDefault();
      }
    );
  });

  /**
   * Prevent Orphan
   */
  $(document).ready(function () {
    var element = $(
      ".page-header:not(.page-header--search) h1, .line-heading h2, .list-3-col > li > h4, .list-4-col > li > h4, .page-header .entry-content p, .prevent-orphan, .footer-grid__cell h4, .footer-grid__cell button, .footer-grid__cell .button, .page-header .entry-content p"
    );

    element.each(function () {
      var a = $(this).html().trim().replace("&nbsp;", " ").split(" ");

      if (a.length > 1) {
        a[a.length - 2] += "&nbsp;" + a[a.length - 1];
        a.pop();
        $(this).html(a.join(" "));
      }
    });
  });

  /**
   * Remove empty element
   */

  //This is causing formatting issues on posts. Removing temporarily

  /*
  $(document).ready(function () {
    $(
      ".entry-content p, .entry-content h1, .entry-content h2, .entry-content h3, .entry-content h4, .entry-content h5, .entry-content h6"
    ).each(function () {
      var html = $.trim($(this).html());

      if (html == "" || html == " " || html == "&nbsp;") {
        $(this).remove();
      }
    });
  }); */

  /**
   * Replace Tag
   */

  $(window).on("load", function () {
    $(".hs-form fieldset").each(function () {
      var t = $("<div>");

      $.each(this.attributes, function (i, attr) {
        $(t).attr(attr.name, attr.value);
      });

      $(this).replaceWith(function () {
        return $(t).append($(this).contents());
      });
    });
  });

  /**
   * Reveal
   */

  $(window).on("load", function () {
    $(".reveal").each(function () {
      var cusion = $(this).find(".reveal__toggle").outerHeight();
      var inside = $(this).find(".reveal__content");
      var remove = $(this).find(".close");
      var rename = $(this).find(".reveal__toggle a").text();
      var reveal = $(this);
      var toggle = $(this).find(".reveal__toggle");

      inside.css("top", cusion);

      toggle.on("click", function (e) {
        var height = reveal.find(".reveal__content").outerHeight();

        e.preventDefault();

        if (reveal.hasClass("is-open")) {
          reveal.addClass("is-closed").removeClass("is-open");
          toggle.css("marginBottom", 0);

          setTimeout(function () {
            toggle.find("a").text(rename);
          }, 260);
        } else {
          reveal.addClass("is-open").removeClass("is-closed");
          toggle.css("marginBottom", height).find("a").text("close");
        }
      });

      remove.on("click", function (e) {
        e.preventDefault();

        reveal.addClass("is-closed").removeClass("is-open");
        toggle.css("marginBottom", 0);

        setTimeout(function () {
          toggle.find("a").text(rename);
        }, 260);
      });
    });
  });

  /**
   * Emergence
   */

  // emergence.init( {
  //   reset: false
  // } );

  /**
   * Scroll Action
   */

  var headerScrollClass = function () {
    var a = Math.ceil($("html").scrollTop()); // (Firefox)
    var b = Math.ceil($("body").scrollTop()); // (Everyone else)

    // Check which to use - body on firefox will print 0, html on chrome will print 0.
    if (a > b) {
      var n = a;
    } else {
      var n = b;
    }

    if (window.matchMedia("(min-width: 1024px)").matches) {
      if (n > 114) {
        $("#header")
          .not(".pre-scrolled")
          .addClass("is-scrolled")
          .removeClass("not-scrolled");
      } else {
        $("#header")
          .not(".pre-scrolled")
          .addClass("not-scrolled")
          .removeClass("is-scrolled");
      }
    } else {
      if (n > 80) {
        $("#header")
          .not(".pre-scrolled")
          .addClass("is-scrolled")
          .removeClass("not-scrolled");
      } else {
        $("#header")
          .not(".pre-scrolled")
          .addClass("not-scrolled")
          .removeClass("is-scrolled");
      }
    }
  };

  $(document).ready(function () {
    headerScrollClass();
  });

  $(document).on("scroll", function () {
    headerScrollClass();
  });

  var marketCounter = function () {
    var a = Math.ceil($("html").scrollTop()); // (Firefox)
    var b = Math.ceil($("body").scrollTop()); // (Everyone else)

    // Check which to use - body on firefox will print 0, html on chrome will print 0.
    if (a > b) {
      var n = a;
    } else {
      var n = b;
    }

    if (
      $(".counter-bar").is('[data-emergence="visible"]') &&
      !$(".counter-bar").hasClass("counted-up")
    ) {
      $(".counter .counter-number-digit").each(function () {
        $(this)
          .prop("Counter", 0)
          .animate(
            {
              Counter: $(this).attr("data-counter"),
            },
            {
              duration: 3000,
              easing: "swing",
              step: function (now) {
                $(this).text(Math.ceil(now));
              },
            }
          );
      });

      $(".counter-bar").addClass("counted-up");
    }
  };

  var portfolioCounter = function () {
    var a = Math.ceil($("html").scrollTop()); // (Firefox)
    var b = Math.ceil($("body").scrollTop()); // (Everyone else)

    // Check which to use - body on firefox will print 0, html on chrome will print 0.
    if (a > b) {
      var n = a;
    } else {
      var n = b;
    }

    if (
      $(".portfolio-counter").is('[data-emergence="visible"]') &&
      !$(".portfolio-counter").hasClass("counted-up")
    ) {
      $(".portfolio-counter__number").each(function () {
        $(this)
          .prop("Counter", 0)
          .animate(
            {
              Counter: $(this).attr("data-counter"),
            },
            {
              duration: 3000,
              easing: "swing",
              step: function (now) {
                $(this).text(Math.ceil(now));
              },
            }
          );
      });

      $(".portfolio-counter").addClass("counted-up");
    }
  };

  $(document).on("scroll", function () {
    setTimeout(marketCounter, 400);
    setTimeout(portfolioCounter, 400);
  });

  /**
   * Search Utility
   */

  $(".search-utility button").on("click", function (e) {
    var search = $(this).closest("form").find(".search-field");
    if (!search.hasClass("is-active")) {
      e.preventDefault();

      search.addClass("is-active").focus();
    } else if (search.hasClass("is-active") && search.val() == "") {
      e.preventDefault();

      search.removeClass("is-active");
    }
  });

  var header_utility = document.querySelector(".header-primary");

  if (header_utility) {
    var header_search_field = header_utility.querySelector(".search-field");
  }

  document.addEventListener("click", function (e) {
    if (header_utility) {
      var inside__header_utility = header_utility.contains(e.target);
    }

    if (!inside__header_utility && $(header_search_field).val() == "") {
      header_search_field.classList.remove("is-active");
    }
  });

  /**
   * Smooth Scroll
   */
  $(document).ready(function () {
    $(document).on("click", "[data-goto]", function (e) {
      e.preventDefault();

      var goto = $(this).attr("data-goto");
      var offs = $(goto).offset().top;
      var trim = $(this).attr("data-goto-trim");

      if ($(this).attr("speed")) {
        var speed = $(this).attr("speed");
      } else {
        var speed = 250;
      }

      if (!trim) {
        var trim = 0;
      }

      /**
       * Overide trim setting
       */
      if (window.matchMedia("(min-width: 1024px)").matches) {
        trim = 114;
      } else {
        trim = 86;
      }

      if ($("body").hasClass("page-template-process")) {
        if (window.matchMedia("(min-width: 1024px)").matches) {
          trim = 144;
        } else {
          trim = 116;
        }
      }

      $("body, html").animate(
        {
          scrollTop: offs - trim,
        },
        { duration: speed }
      );
    });

    $(document).on("change", ".goto-select", function (e) {
      e.preventDefault();

      var goto = $(this).find(":selected").attr("value");
      var offs = $("#" + goto).offset().top;
      var trim = $(this).attr("data-goto-trim");

      if ($(this).attr("speed")) {
        var speed = $(this).attr("speed");
      } else {
        var speed = 250;
      }

      if (!trim) {
        var trim = 0;
      }

      /**
       * Overide trim setting
       */
      if (window.matchMedia("(min-width: 1024px)").matches) {
        trim = 114;
      } else {
        trim = 86;
      }

      $("body, html").animate(
        {
          scrollTop: offs - trim,
        },
        { duration: speed }
      );
    });
  });

  /**
   * Vendor: Slick
   */

  var nextArrow =
    '<button class="slick-next" type="button"><svg viewBox="0 0 17 30" xmlns="http://www.w3.org/2000/svg"><path d="M1.889 30L17 15 1.889 0 0 1.875 13.222 15 0 28.125z"/></svg></button>';
  var prevArrow =
    '<button class="slick-prev" type="button"><svg viewBox="0 0 17 30" xmlns="http://www.w3.org/2000/svg"><path d="M15.111 30L0 15 15.111 0 17 1.875 3.778 15 17 28.125z"/></svg></button>';

  $(".hero-image-slider").slick({
    appendDots: $(".hero-dots"),
    arrows: false,
    dots: true,
    rows: 0,
    speed: 500,
    autoplay: true,
    autoplaySpeed: 4000,
    fade: true,
    useTransform: true,
    cssEase: "ease-in-out",
    asNavFor: $(".hero-caption-slider, .hero-photo-credit-slider"),
  });

  $(".hero-caption-slider").slick({
    arrows: false,
    draggable: false,
    fade: true,
    rows: 0,
    speed: 500,
    asNavFor: $(".hero-image-slider, .hero-photo-credit-slider"),
  });

  $(".hero-photo-credit-slider").slick({
    arrows: false,
    draggable: false,
    fade: true,
    rows: 0,
    speed: 250,
    asNavFor: $(".hero-caption-slider, .hero-image-slider"),
  });

  // Make arrow keys work
  if ($(".hero .slick-list").length) {
    $(".hero .slick-list").attr("tabindex", 0).focus();
  }

  $(".quote-slideshow__slider.is-reel").slick({
    appendDots: $(".quote-slideshow-dots"),
    arrows: true,
    dots: true,
    nextArrow: $("#quote-slideshow-next"),
    prevArrow: $("#quote-slideshow-prev"),
    rows: 0,
    speed: 250,
    asNavFor: $(".quote-slideshow__author.is-reel"),
  });

  $(".quote-slideshow__author.is-reel").slick({
    arrows: false,
    draggable: false,
    fade: true,
    rows: 0,
    speed: 250,
    asNavFor: $(".quote-slideshow__slider.is-reel"),
  });

  $(".reel--bleed .slick-slide").on("click", function (e) {
    var i = $(this).data("slick-index");

    if ($(".slick-slider").slick("slickCurrentSlide") !== i) {
      e.preventDefault();
      e.stopPropagation();

      $(".slick-slider").slick("slickGoTo", i);
    }
  });

  $(".reel--appendArrows").each(function () {
    if ($(this).hasClass("arrows")) {
      var appendArrows = $(this);
    } else if ($(this).siblings(".arrows").length) {
      var appendArrows = $(this).siblings(".arrows");
    } else if ($(this).siblings().find(".arrows").length) {
      var appendArrows = $(this).siblings().find(".arrows");
    } else if ($(this).closest(".arrows").length) {
      var appendArrows = $(this).closest(".arrows");
    } else {
      var appendArrows = $(".arrows");
    }

    $(this).slick(
      "slickSetOption",
      {
        appendArrows: appendArrows,
        arrows: true,
      },
      true
    );
  });

  $(".reel--dots").each(function () {
    if ($(this).hasClass("dots")) {
      var appendDots = $(this);
    } else if ($(this).siblings(".dots").length) {
      var appendDots = $(this).siblings(".dots");
    } else if ($(this).siblings().find(".dots").length) {
      var appendDots = $(this).siblings().find(".dots");
    } else if ($(this).closest(".dots").length) {
      var appendDots = $(this).closest(".dots");
    } else {
      var appendDots = $(".dots");
    }

    $(this).slick(
      "slickSetOption",
      {
        appendDots: appendDots,
        dots: true,
      },
      true
    );
  });

  var slickArrowAlign = function () {
    $(".slick-arrow-align").each(function () {
      var a = $(this).find(".slick-arrow");
      var b = a.outerHeight();
      var h = $(this).find(".slick-list").innerHeight();
      var m = h / 2 - b / 2;

      a.css({
        marginTop: m,
        top: 0,
        transform: "none",
      });
    });
  };

  /**
   * Open external link in new tab
   */
  $(document).ready(function () {
    $("a")
      .filter('[href^="http"], [href^="//"]')
      .not('[href*="' + window.location.host + '"]')
      .attr("rel", "noopener noreferrer")
      .attr("target", "_blank");
  });

  /**
   * Open PDF in new tab
   */
  $(document).ready(function () {
    $('a[href$=".pdf"]').attr("target", "_blank");
  });

  /**
   * Form Spam Protection
   */
  jQuery(document).ready(function () {
    var form = "footer form, header form, .gform_wrapper form";

    jQuery(form).append(
      '<div style="top: -99999px; left: -99999px; position: absolute;"><input id="protect" name="protect" type="text"></div>'
    );

    jQuery(form).on("submit", function (e) {
      if (jQuery(this).find("#protect").val()) {
        e.preventDefault();
      }
    });

    jQuery(form).each(function () {
      var submit_button = jQuery(this).find('[type="submit"]');

      jQuery(submit_button).on("click", function (e) {
        if (jQuery(this).closest("form").find("#protect").val()) {
          e.preventDefault();
        }
      });
    });
  });

  /**
   * Dropdown
   */

  $(document).on("click", function (e) {
    if (!$(e.target).closest(".dropdown").length) {
      $(".dropdown").removeClass("is-active");
    }
  });

  $(".dropdown > button").on("click", function (e) {
    e.preventDefault();

    $(".dropdown").not($(this).closest(".dropdown")).removeClass("is-active");

    $(this).closest(".dropdown").toggleClass("is-active");
  });

  $(".dropdown-content > li:first-child").on({
    mouseenter: function () {
      $(this).closest("ul").addClass("is-top-item-hover");
    },
    mouseleave: function () {
      $(this).closest("ul").removeClass("is-top-item-hover");
    },
  });

  /**
   * Sidebar filters hide.
   *
   * Cookie js @link https://github.com/js-cookie/js-cookie
   * Note, no expiry is set | default behaviour is to treat this as a session cookie (expires once the customer closes the browser)
   */
  $(".sidebar-filter-hide-button").on("click", function (e) {
    e.preventDefault();
    var sidebar = $(this).closest(".sidebar-filter");

    $(this)
      .closest(".feed-section")
      .find(".sidebar-filter-show-button-container")
      .toggleClass("is-active");

    sidebar.toggleClass("is-active");

    var visibility = sidebar.hasClass("is-active") ? 1 : 0;
    Cookies.set(`sidebar-filter-visible-${rootPageName}`, visibility);
  });

  $(".sidebar-filter-show-button").on("click", function (e) {
    e.preventDefault();

    $(this)
      .closest(".feed-section")
      .find(".sidebar-filter-show-button-container")
      .removeClass("is-active");

    $(".sidebar-filter").addClass("is-active");
  });

  $(document).ready(function () {
    if (!$(".sidebar-filter").length) return;
    var getSearchUtilityVisiblity = Cookies.get(
      `sidebar-filter-visible-${rootPageName}`
    );

    // If visible is set to 1 or user hasn't selected a preference, then we'll show the sidebar
    if (
      typeof getSearchUtilityVisiblity === "undefined" ||
      getSearchUtilityVisiblity == "1"
    ) {
      $(".sidebar-filter").addClass("is-active");
    }
  });

  /**
   * Delete URL parameter.
   */

  // function deleteParam(url, key, value) {
  //   let params = url.searchParams.getAll(key);

  //   var index = params.indexOf(value);

  //   if (index > -1) {
  //     params.splice(index, 1);
  //   }

  //   url.searchParams.delete(key);

  //   params.forEach(function (param) {
  //     url.searchParams.append(key, param);
  //   });
  // }

  /**
   * Sidebar filters - with select values.
   */

  // var url = new URL(window.location.href);
  // window.sidebarFilterUrl = ""; // Used to store the current URL for the sidebar filters.

  // $(".sidebar-filter select").on("change", function () {
  //   var category = $(this).find(":selected").attr("data-category"),
  //     filter = $(this).attr("data-filter"),
  //     filterAll = url.searchParams.getAll(filter),
  //     filterAnchor = $(this).closest("nav").attr("data-filter-anchor"),
  //     hash = url.href.split("#")[1];

  //   if (category && filter) {
  //     /**
  //      * Add parameter or delete if exists.
  //      */
  //     if ($(this).attr("data-select-multiple") == "false") {
  //       url.searchParams.delete(filter);
  //       url.searchParams.append(filter, category);
  //     } else if (filterAll.indexOf(category) > -1) {
  //       deleteParam(url, filter, category);
  //     } else {
  //       url.searchParams.append(filter, category);
  //     }

  //     if ($(".block-feed.block-feed--list").length) {
  //       url.searchParams.set("view-list", "true");
  //     } else {
  //       url.searchParams.set("view-list", "false");
  //     }

  //     /**
  //      * Use .split() to get everything before '#'
  //      * then append filter anchor.
  //      */
  //     if (filterAnchor) {
  //       url.href = url.href.split("#")[0] + "#" + filterAnchor;
  //     }

  //     window.sidebarFilterUrl = url.href;
  //   }
  // });

  // $(".sidebar-filter a.sidebar-filter__submit").on("click", function (e) {
  //   e.preventDefault();
  //   window.location.replace(window.sidebarFilterUrl);
  // });

  // var closeIcon = $(
  //   '<svg aria-hidden="true" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg"><path d="M7.857 6.506L1.571.221.157 1.635 6.443 7.92 0 14.363l1.414 1.415 6.443-6.443 6.442 6.442 1.415-1.414L9.27 7.92l6.285-6.285L14.142.221 7.857 6.506z"/></svg>'
  // );

  // $(document).ready(function () {
  //   var urlParams = getParams();

  //   for (var param in urlParams) {
  //     if (Array.isArray(urlParams[param])) {
  //       for (var i = 0; i < urlParams[param].length; i++) {
  //         var urlCategoryRemoved = new URL(window.location.href),
  //           categoryText = $(
  //             '[data-filter="' +
  //               param +
  //               '"] [data-category="' +
  //               urlParams[param][i] +
  //               '"]:first'
  //           ).text();

  //         if (!categoryText) {
  //           categoryText = urlParams[param][i];
  //         }

  //         deleteParam(urlCategoryRemoved, param, urlParams[param][i]);

  //         if ($(".block-feed.block-feed--list").length) {
  //           urlCategoryRemoved.searchParams.append("view-list", "true");
  //         } else {
  //           urlCategoryRemoved.searchParams.delete("view-list");
  //         }

  //         // if (param != "items" && param != "sort" && param != "view-list") {
  //         //   $("#filter-categories-list").append(
  //         //     $(
  //         //       '<li data-category="' +
  //         //         param +
  //         //         '"><a href="' +
  //         //         urlCategoryRemoved.href +
  //         //         '">' +
  //         //         categoryText +
  //         //         "</a></li>"
  //         //     )
  //         //   );
  //         // }
  //       }
  //     } else {
  //       // var urlCategoryRemoved = new URL(window.location.href),
  //       //   categoryText = $(
  //       //     '[data-filter="' +
  //       //       param +
  //       //       '"] [data-category="' +
  //       //       urlParams[param] +
  //       //       '"]:first'
  //       //   ).text();

  //       // if (!categoryText) {
  //       //   categoryText = urlParams[param];
  //       // }

  //       // deleteParam(urlCategoryRemoved, param, urlParams[param]);

  //       // if ($(".block-feed.block-feed--list").length) {
  //       //   urlCategoryRemoved.searchParams.append("view-list", "true");
  //       // } else {
  //       //   urlCategoryRemoved.searchParams.delete("view-list");
  //       // }

  //       // if (param != "items" && param != "sort" && param != "view-list") { 
  //       //   var displayText = categoryText.replace(/-/g, " "); 
  //       //   $("#filter-categories-list").append(
  //       //     $(
  //       //       '<li data-category="' +
  //       //         param +
  //       //         '"><a href="' +
  //       //         urlCategoryRemoved.href +
  //       //         '">' +
  //       //         displayText +
  //       //         "</a></li>"
  //       //     )
  //       //   );
  //       // }
  //     }
  //   }

  //   // if ($("#filter-categories-list li").length > 0) {
  //   //   $(".page-header-categories").addClass("has-categories");
  //   // }

  //   // $("#filter-categories-list > li > a").append(closeIcon);

  //   // if (Object.keys(urlParams).length > 0) {
  //   //   $(".page-header-categories").addClass("is-active");
  //   // }
  // });

  // Create Table of Contents
  $(document).ready(function () {
    var alpha, postNav, mobilePostNav, tocHeader, sources;

    alpha = $(".content-single .entry-content").find("h2");
    postNav = $(".content-single .aside-post-navigation ul");
    mobilePostNav = $(".aside-post-navigation-mobile select");
    tocHeader = $(".content-single__aside > h3");

    // log to the console for me
    function logme(data) {
      console.log(data);
    }

    // generate the anchor links
    function anchorsMade(item, type) {
      var anchorsText = $(item)
        .text()
        .toLowerCase()
        .replace(/\s+/g, "-")
        .replace(/[^0-9a-z-]/gi, "");
      // logme("Anchor text: " + anchorsText); 
      anchorsAway(item, anchorsText, type);
    }

    // apply anchor links
    function anchorsAway(item, anchor, type) {
      // if (!$(item).attr("id")) {
      //   $(item).addClass(type).attr("id", anchor);
      // } else {
      //   $(item).addClass(type);
      // } 
      $(item).addClass(type).attr("id", anchor);
      sortTopLevel(item);
    }

    // sort for top-level nav items
    function sortTopLevel(item) {
      if ($(item).is("h2")) {
        genTop(item);
      } else {
        sortSubLevel(item);
      }
    }

    // get sub-level
    function sortSubLevel(item) {
      var content, treeGroup, subTree, sliceTree, subLevel, surSlice, surLevel;
      content = $(item).text().replace(/\./gi, "-");
      treeGroup = content.split(" ");
      subTree = treeGroup[0];
      sliceTree = subTree.split("-");
      // logme(sliceTree);
      // subLevel = subTree.slice(-1);
      // logme('subLevel: ' + subLevel);
      subLevel = sliceTree.slice(-1);
      // logme("new subLevel: " + subLevel);
      // surLevel = subTree.slice(0, -2);
      // logme('surLevel: ' + surLevel);
      surSlice = sliceTree.slice(0, -1);
      surLevel = surSlice.join("-");
      // logme("new surLevel: " + surLevel);

      // logme(subTree.length);

      if (subLevel == "1") {
        if (sliceTree.length > 2) {
          genList(item, surLevel, true);
        } else {
          genList(item, surLevel);
        }
      } else {
        getList(item, subTree);
      }
    }

    // create new sublist
    function genList(item, subTree, dig = false) {
      // logme("Running genList()");
      var lastItem,
        parentItem,
        subTreeSplit,
        subTreeSlice,
        parentID,
        parentTree,
        newID,
        newList;
      newID = "tree-" + subTree;
      // logme("newID: " + newID);
      newList = '<ul id="' + newID + '" class="subtree"></ul>';
      // logme(newList);

      if (dig) {
        parentID = getParent(subTree);
        // logme("parentID: " + parentID);
        parentTree = "#tree-" + parentID;
        // logme("parentTree: " + parentTree);
        // lastItem = $(postNav).children('li').last().children('ul').last().children('li').last();
        lastItem = $(parentTree);
        // logme("lastItem on dig.");
        // logme(lastItem);
      } else {
        lastItem = $(postNav).children("li").last();
        // logme("lastItem no dig.");
        // logme(lastItem);
        if (!lastItem.hasClass("tree")) {
          lastItem.addClass("tree");
        }
      }

      $(lastItem).append(newList);
      genItem(item, newID);
    }

    // get current sublist
    function getList(item, subTree) {
      // logme("Running getList()");
      var childItem, genTree, listID;
      genTree = getParent(subTree);
      // logme("genTree: " + genTree);
      listID = "tree-" + genTree;
      // logme("subTree: " + subTree);
      // logme("listID: " + listID);
      genItem(item, listID);
    }

    // generate list item
    function genItem(item, itemID) {
      // logme("Running genItem()");
      var itemList = "ul#" + itemID;
      // logme(itemList);
      $(itemList).append(
        $(
          '<li><a data-goto="#' +
          $(item).attr("id") +
          '" href="#' +
          $(item).attr("id") +
          '"><span>' +
          $(item).text() +
          "</span></a></li>"
        )
      );
    }

    // create top-level list items
    function genTop(item) {
      postNav.append(
        $(
          '<li><div class="treetop"><a data-goto="#' +
          $(item).attr("id") +
          '" href="#' +
          $(item).attr("id") +
          '"><span>' +
          $(item).text() +
          '</span></a><span class="foliage"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 12.28 7.16"><g><g><polygon class="cls-1" points="1.05 7.16 0 6.1 6.14 0 12.28 6.1 11.22 7.16 6.14 2.11 1.05 7.16"/></g></g></svg></span></div></li>'
        )
      );
      mobilePostNav.append(
        $(
          '<option value="' +
          $(item).attr("id") +
          '">' +
          $(item).text() +
          "</option>"
        )
      );
    }

    // get parent item ID 
    function getParent(child) {
      // logme("Running getParent()");
      var split, slice, parent;
      split = child.split("-");

      if (split.length > 1) {
        slice = split.slice(0, -1);
        parent = slice.join("-");
      } else {
        parent = split;
      }
      return parent;
    }

    // get each alpha, all betas, and begin navgen
    $(alpha).each(function () {
      anchorsMade(this, "header-anchor");
      // logme(this);

      var beta = $(this).nextUntil(alpha, "h4");

      $(beta).each(function () {
        var val = $(this).text();

        if (val.match(/^\d/)) {
          anchorsMade(this, "sub-anchor");
          logme(this);
        }
      });
    });

    // Hide Navigation title if there are not sub-headings
    if ($(".header-anchor").length) {
      tocHeader.show();
    }

  });

  // Show ToC Subtrees
  // CSS class 'bloomed' toggles element height
  $(document).ready(function () {
    var pollinator = $("span.foliage");

    $(pollinator).click(function () {
      var trunk = $(this).closest(".tree");

      if ($(trunk).hasClass("bloomed")) {
        $(trunk).removeClass("bloomed");
      } else {
        $(trunk).addClass("bloomed");
      }
    });
  });

  // Create 'Sources' Toggle
  // Finds 'Sources' section in the_content()
  // JK they don't want it now...
  // $(document).ready(function(){
  //   var headings, sourceWrap, wrapContent, expandWrap;
  //   headings = $('.content-single .entry-content h2');
  //   wrapContent = '<div class="source-wrap"></div>';
  //   expandWrap = '<span class="source-expand">Expand <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 12.28 7.16"><g><g><polygon class="cls-1" points="1.05 7.16 0 6.1 6.14 0 12.28 6.1 11.22 7.16 6.14 2.11 1.05 7.16"/></g></g></svg></span>';

  //   $(headings).each(function(){
  //     var content = $(this).text();

  //     if ( content.endsWith('Sources') ) {
  //       console.log('Found the Sources: ');
  //       var sourceEnds, sourceList;
  //       sourceEnds = $('h2, div');

  //       $(this).append(expandWrap);
  //       $(this).after(wrapContent);

  //       sourceWrap = $('.source-wrap');

  //       sourceList = $(sourceWrap).nextUntil(sourceEnds, 'p');
  //       $(sourceList).each(function(){
  //         $(this).appendTo(sourceWrap);
  //       });
  //     }
  //   });
  // });

  // Reveal Sources on click
  $(document).ready(function () {
    var pulley, curtain;
    pulley = $('.entry-content h2[id$="sources"] span.source-expand');
    curtain = $(pulley).parent("h2");

    $(pulley).click(function () {
      if ($(curtain).hasClass("revealed")) {
        $(curtain).removeClass("revealed");
      } else {
        $(curtain).addClass("revealed");
      }
    });
  });

  /**
   * Bucket description icon.
   */
  $(document).ready(function () {
    var bucketDescriptionText = $(".bucket-description");

    bucketDescriptionText.each(function () {
      var appendParent = $(this);

      if ($(this).find("p").length) {
        appendParent = $(this).find("p").last();
      }

      var bucketDescriptionHref = $(this).closest("li").find("a").attr("href");
      var bucketDescriptionIcon = $(
        '<svg aria-hidden="true" class="bucket-description-arrow" viewBox="0 0 36 17" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M26.55 1L34 8.5 26.55 16M0 8.5h34" stroke="#6e7ca0" stroke-width="2"/></svg>'
      );

      if ($(this).closest("ul").attr("data-arrows-small") == "true") {
        bucketDescriptionIcon = $(
          '<svg viewBox="0 0 25 17" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15.352 1l7.395 7.5-7.395 7.5M1 8.397l21.748.103" stroke="#6e7ca0" stroke-width="2"/></svg>'
        );
      }

      appendParent.append(
        $(
          '<span class="keep-together">&nbsp;<a class="bucket-description-link" href="' +
          bucketDescriptionHref +
          '"></a></span>'
        )
      );

      $(this).find(".bucket-description-link").append(bucketDescriptionIcon);
    });
  });

  /**
   * Set icon in Select2 button.
   */
  $(document).ready(function () {
    var selectArrow = $(
      '<svg viewBox="0 0 23 13" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1.6 1.5l9.9 9.9 9.9-9.9" stroke="#6e7ca0" stroke-width="2"/></svg>'
    );

    $("select2-container").remove("select2-selection__arrow");

    $(".select2-selection").append(selectArrow);
  });

  /**
   * Set List View Height to 'auto'
   */
  function resetGridViewHeight() {
    console.log("Resetting the grid...");
    var elem;
    elem = $(".block-feed-post.same-height");

    $(elem).each(function () {
      $(this).css("height", "auto");
    });
  }

  /**
   * Set Grid View Height to Largest
   */
  function setGridViewSameHeight() {
    console.log("Resizing the grid...");
    var elem, match;
    elem = $(".block-feed-post.same-height");

    match = 0;
    $(elem).each(function () {
      var postHeight;
      postHeight = $(this).outerHeight();

      console.log("match: " + match);
      console.log("postHeight: " + postHeight);

      if (postHeight > match) {
        match = postHeight;
      }
    });

    console.log("Final match: " + match);

    $(elem).each(function () {
      $(this).css("height", match);
    });

    console.log("Posts matched.");
  }

  /**
   * Deal with Grid View on Page Load
   */
  $(document).ready(function () {
    var postFeed = $(".block-feed");
    if (!postFeed.hasClass("block-feed--list")) {
      // Trigger if the initial view is grid
      setGridViewSameHeight();
    } else {
      console.log("Viewing as list");
    }
  });

  /**
   * View as List/Grid Action
   */
  $(document).on("click", ".button-view-list", function (e) {
    e.preventDefault();

    var blockFeed = $(".block-feed");
    var blockFeedTitleHead = $(".block-feed-title-head");

    var links = $(
      ".feed-options-bar a, #filter-categories-list a, .feed-footer nav.pagination a"
    );

    var styleFix = $(
      '<style id="posts-wrap-transition-fix">.feed-section__posts * { transition: none !important; }</style>'
    );

    $("body").append(styleFix);

    setTimeout(function () {
      $("#posts-wrap-transition-fix").remove();
    }, 200);

    blockFeed.toggleClass("block-feed--list");
    blockFeedTitleHead.toggleClass("is-active");

    if (blockFeed.hasClass("block-feed--list")) {
      $(".button-view-list").text("View as Grid");
    } else {
      $(".button-view-list").text("View as List");
    }

    links.each(function () {
      var linkBaseUrl =
        window.location.href.toString().split(window.location.host)[0] +
        window.location.host;
      var linkUrl = false;

      try {
        linkUrl = new URL($(this).attr("href"));
      } catch (e) { }

      if (!linkUrl) {
        try {
          linkUrl = new URL(linkBaseUrl + $(this).attr("href"));
        } catch (e) { }
      }

      if (linkUrl) {
        if ($(".block-feed.block-feed--list").length) {
          linkUrl.searchParams.set("view-list", "true");
        } else {
          linkUrl.searchParams.set("view-list", "false");
        }
      }

      $(this).attr("href", linkUrl.href);
    });

    if (blockFeed.hasClass("block-feed--list")) {
      resetGridViewHeight();
    } else {
      setGridViewSameHeight();
    }
  });

  /**
   * Content navigation.
   */
  $(".content-navigation-icon").on("click", function (e) {
    e.preventDefault();

    var childList = $(this).closest("li").children("ul:first");

    childList.slideToggle(200);
  });

  /**
   * Careers signup form.
   */
  function careersSignupFormSetup() {
    var form = $(".careers-signup-form form:first");
    var button = form.find('input[type="submit"]:first');
    var gform_fields = form.find(".gform_fields");
    var mailingListField = form.find(".gfield.mailing-list");

    gform_fields.append(button);

    if (window.matchMedia("(min-width: 1024px)").matches) {
      mailingListField.insertAfter(gform_fields);
    } else {
      mailingListField.insertBefore(button);
    }

    $(".careers-signup-form:first").addClass("form-fields-setup");

    form.addClass("form-fields-setup");
  }

  $(document).ready(function () {
    careersSignupFormSetup();
  });

  $(window).on("resize", function () {
    setTimeout(careersSignupFormSetup, 300);
  });

  // Adds smooth scroll to anchor tags
  $('a[href*="#"]:not([href="#"]):not([href$="#categories"]):not(.footnote_hard_link)').on(
    "click",
    function () {
      if (
        location.pathname.replace(/^\//, "") ==
        this.pathname.replace(/^\//, "") &&
        location.hostname == this.hostname
      ) {
        var stickyHeaderHeight = $(".header-content").outerHeight();

        var target = $(this.hash);
        target = target.length
          ? target
          : $("[name=" + this.hash.slice(1) + "]");

        if (target.length) {
          $("html,body").animate(
            {
              scrollTop: target.offset().top - stickyHeaderHeight,
            },
            1000
          );
          return false;
        }
      }
    }
  );

  /**
   * Adding a custom search form on primary menu's search icon.
   * We are creating a separate one here to reserve the default searchform.php for content-none.php template
   */
  $(".sitewide-search-button").on("click", function () {
    let template = `<div id='header-sitewide-search-form' style='display: none;'>
  		<div class='close-btn'>
  			<a href='javascript:void(0);'>
  				<svg width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
  					<path fill-rule="evenodd" clip-rule="evenodd" d="M8.14231 9.40385L0.5422 1.72711L1.90039 0.355225L9.50051 8.03197L17.1001 0.35573L18.4583 1.72762L10.8587 9.40385L18.6485 17.2722L17.2903 18.644L9.50051 10.7757L1.71024 18.6445L0.352051 17.2727L8.14231 9.40385Z" fill="#6E7CA0"/>
  				</svg>
  			</a>
  		</div>
  		<form class="header-search-form wrap" action="/" method="get">
  			<input class="search-field" id="search-input" type="search" name="s" placeholder="Search here" value="${siteData.searchQuery}">
  			<button type="submit">
  				<svg aria-hidden="true" viewBox="0 0 21 20" xmlns="http://www.w3.org/2000/svg"><path d="M16.478 13.675c2.273-3.305 1.94-7.862-.998-10.801-3.314-3.314-8.687-3.314-12 0-3.314 3.314-3.314 8.686 0 12 3.207 3.208 8.345 3.31 11.676.308l4.429 4.429 1.414-1.414-4.521-4.522zm-2.413-9.387c2.533 2.533 2.533 6.64 0 9.172-2.532 2.533-6.639 2.533-9.171 0-2.533-2.533-2.533-6.64 0-9.172 2.532-2.533 6.639-2.533 9.171 0z"/></svg>
  			</button>
  		</form>
  	</div>`;
    if (!$("#header-sitewide-search-form").length) {
      $("body").append(template);
    }

    if ($("#header-sitewide-search-form").is(":hidden")) {
      $("#header-sitewide-search-form").fadeIn(300);
      $("#search-input:first").focus();
    } else {
      $("#header-sitewide-search-form").fadeOut(300);
    }
  });

  $(document).on(
    "click",
    "#header-sitewide-search-form .close-btn a",
    function () {
      $("#header-sitewide-search-form").fadeOut(300);
    }
  );

  // Page template footnotes toggle
  $("body.page-template #toggle-footnotes").on("click", function () {
    let $root = $(this);
    if ($(".footnotes").is(":visible")) {
      // collapse
      $(".footnotes").slideUp(400, function () {
        $root.text($root.data("show"));
      });
    } else {
      // show
      $(".footnotes").slideDown(400, function () {
        $root.text($root.data("hide"));
      });
    }
  });

  // Single Research Page
  $(
    "body.single-research #toggle-footnotes, body.single-grants #toggle-footnotes, body.single-careers #toggle-footnotes"
  ).on("click", function () {
    let $root = $(this);
    if ($(".footnotes").is(":visible")) {
      // collapse
      $root.find("span.expand").show().css("display", "inline-flex");
      $root.find("span.collapse").hide();
      $(".footnotes").slideUp(100, "linear");
    } else {
      // show
      expandFootnotes($root, 100);
    }
  });

  function expandFootnotes($root, delay = 0) {
    $root.find("span.collapse").show().css("display", "inline-flex");
    $root.find("span.expand").hide();
    if (delay) {
      $(".footnotes").slideDown(100, "linear");
    } else {
      $(".footnotes").show();
    }
  }

  // Scroll to Footnote
  //   console.log('Watching for footnotes...');

  var scrollNote;
  scrollNote = $(".see-footnote");

  $(scrollNote).click(function (e) {
    e.preventDefault();

    var source, sourceTag, footNote, fnOffset;
    source = $(this);
    sourceTag = $(this).attr("id");
    footNote = $('a.footnote-label[href$="' + sourceTag + '"]');

    console.log("source: ", source);
    console.log("sourceTag: ", sourceTag);
    console.log("footNote: ", footNote);

    // If the footnotes is collapsed and the target footnote look up exists -> open quickly
    if (!$(".footnotes").is(":visible") && footNote) {
      expandFootnotes($("#toggle-footnotes"));
    }

    if (!footNote) {
      console.log("footnote id " + sourceTag + " not found");
      return false;
    }

    fnOffset = footNote.offset();
    $("html, body").animate({ scrollTop: fnOffset.top - 140 }, 750);
  });

  // Imported Footnotes Scroll 
  var scrollNoteAlt = $(".entry-content a[href^='#']");

  scrollNoteAlt.click(function (e) {
    e.preventDefault();
    var href = $(this).attr('href'),
      footnote = $('li' + href),
      idOffset;

    console.log(href);
    console.log(footnote);

    // If the footnotes is collapsed and the target footnote look up exists -> open quickly
    if (!$(".footnotes").is(":visible")) {
      expandFootnotes($("#toggle-footnotes"));
    }

    setTimeout(function () {
      idOffset = footnote.offset().top - 140;

      $("html, body").animate({ scrollTop: idOffset }, 750);
    }, 10);
  });

  var scrollLabel;
  scrollLabel = $(".footnote-label");

  $(scrollLabel).click(function (e) {
    e.preventDefault();

    var source, sourceLink, hashLink, hashID, footLabel, fnOffset;
    source = $(this);
    sourceLink = $(this).attr("href").split("#");
    hashLink = sourceLink[1];
    footLabel = $('a#' + hashLink);

    fnOffset = footLabel.offset();
    $("html, body").animate({ scrollTop: fnOffset.top - 140 }, 750);
  });


  // Scroll on Footer Button View
  console.log("Waiting to scroll...");

  var footView;
  footView = $(".feed-footer__options").children(
    'button[class^="button-view-"], button[class*=" button-view-"]'
  );

  $(footView).click(function (e) {
    var feed, feedOffset;
    feed = $(".feed-options-bar");
    setTimeout(function () {
      feedOffset = feed.offset();
      $("html, body").animate({ scrollTop: feedOffset.top - 140 }, 500);
    }, 200);
  });

  // Add class to assist the styling of dynamically imported tables
  $(
    "body.single-research, body.single-grants, body.page-template-table-of-contents, body.page-template"
  )
    .find("table:not(.table)")
    .each(function () {
      let $table = $(this);
      $table.addClass("table-imported");
      if ($table.parent(".scroll-box").length < 1) {
        console.log("Table boxed up.");
        $table.wrap("<div class='scroll-box'></div>");
      }

      /**
       * Create a thead based on the following conditions:
       * 1. there is no thead presently
       * 2. The first row only has texts
       */
      if ($table.find("thead").length == 0) {
        let matchConditions = true;
        $table.find("tbody > tr:first td").each(function () {
          if ($(this).text() != $(this).html()) {
            matchConditions = false;
            return false;
          }
        });

        if (matchConditions === false) return true; // skip to the next iteration

        $el = $table.find("tbody > tr:first").detach();
        let thead = $el
          .html()
          .replaceAll("<td>", "<th>")
          .replaceAll("</td>", "</th>");
        $table.find("tbody").before("<thead>" + thead + "</thead>");
      }
    });

  /**
   * Live Sort-by Column Header
   * - research.php
   * - research-category.php
   *
   */
  $(document).ready(function () {
    console.log("Filters are ready.");

    var filterBtn, layout, listings;
    // title buttons, archive block, archive results
    filterBtn = $("h6.feed-sorter");
    layout = $(".feed-section__posts .block-feed-post--container");
    listings = $(".block-feed .block-feed-post");

    // begin filter on-click
    $(filterBtn).click(function () {
      var filter = $(this);
      activateTitle(filter);
    });

    function activateTitle(filter) {
      var data, dataUpp, dataStr;
      data = $(filter).data("sort");
      dataUpp = data.substr(0, 1).toUpperCase() + data.substr(1);
      dataStr = "sort" + dataUpp;
      console.log(dataStr);

      if (filter.hasClass("sorting")) {
        if (filter.hasClass("rev")) {
          $(filterBtn).removeClass("rev");
          sort(dataStr);
        } else {
          $(filter).addClass("rev");
          sortRev(dataStr);
        }
      } else {
        $(filterBtn).removeClass("sorting");
        $(filter).addClass("sorting");
        sort(dataStr);
      }
    }

    function sort(dataStr) {
      $(listings)
        .sort(function (a, b) {
          var A = $(a).data(dataStr).toString();
          var B = $(b).data(dataStr).toString();
          return A < B ? -1 : A > B ? 1 : 0;
        })
        .appendTo(layout);
    }

    function sortRev(dataStr) {
      $(listings)
        .sort(function (a, b) {
          var A = $(a).data(dataStr).toString();
          var B = $(b).data(dataStr).toString();
          return A < B ? 1 : A > B ? -1 : 0;
        })
        .appendTo(layout);
    }
  });

  // Hides the flex-helper pseudo element when un-needed
  $(document).ready(function () {
    var feed, results;
    feed = $(".feed-section__posts .block-feed-post--container");
    results = $(feed).children(".block-feed-post");

    // if the page has a feed, run the script
    if (feed.length > 0) {
      var count, tally;
      count = 0;
      // count up the number of results
      $(results).each(function () {
        count = ++count;
      });
      console.log("Count: " + count);
      // test divisible by three (for 3x3 grid fix)
      tally = count % 3;
      console.log("Tally: " + tally);
      // if divisible, hide the helper
      if (!tally) {
        console.log("Grid cubed.");
        $(feed).addClass("cubed");
      }
    }
  });

  /**
   * I'm pretty sure everything in this repo is made up, and the points 
   * don't matter. 
   * 
   * Newly-build Sidebar Nav 
   */
  $(document).ready(function () {
    console.log('Ada online.');

    // toggle hiding on each dropdown 
    $('.selection-prompt').click(function () {
      var wrappers, wrap, state;
      wrappers = $('.selection-dropdown');
      wrap = $(this).parent('.selection-dropdown');
      state = $(wrap).hasClass('active');

      if (state) {
        $(wrap).removeClass('active');
      } else {
        $(wrappers).removeClass('active');
        $(wrap).addClass('active');
      }
    });
    // sub-section searches 
    $('.selection-search').on('keyup keypress', function (e) {
      var keyCode = e.keyCode || e.which;
      // disallow form submission on 'enter' key when focusing a 
      // dropdown's search field 
      if (keyCode === 13) {
        e.preventDefault();
        return false;
      } else {
        // filter results 
        var value, labels;
        value = $(this).val().toLowerCase();
        labels = $(this).siblings('.options-wrapper').children('label.selection-label');

        $(labels).filter(function () {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
      }
    });
    // rearrage for hierarchy 
    function find_parents(selectionID) {
      var set, options;
      set = $(selectionID).children('.selection-options').children('.options-wrapper');
      options = $(set).children('.selection-label');

      // this will only work while `orderby` => `parents` 
      $(options).each(function () {
        var parentID;
        parentID = $(this).attr('data-parent');

        if (parentID != '0') {
          var parentAttr, parentItem;
          parentAttr = '.selection-label[data-termid=' + parentID + ']';
          parentItem = $(this).siblings(parentAttr);
          $(this).insertAfter(parentItem);
        }
      });
    }
    find_parents('#filter-focus-area');
    find_parents('#filter-content-type');
  });

  // Strip &nbsp; from page headers 
  $(document).ready(function () {
    var oldhtml = $('.page-header__main h1').html();
    var newhtml = oldhtml.replace(/&nbsp;/g, ' ');

    $('.page-header__main h1').html(newhtml);
  });

  // Footnotes Plugin custom js
  var footnotes = $('.footnotes_reference_container > div:last-child'),
    footnotesToggle = $('.footnote_container_prepare p');

  $('.footnote_reference_container_collapse_button').html('<svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M18.1123 9.71249L12.4996 15.2875L6.8877 9.71249" stroke="#445277" stroke-width="1.49661"></path></svg>')

  footnotesToggle.find('span').on('click', function () {

    if (footnotesToggle.hasClass('open')) {
      footnotesToggle.removeClass('open')
      footnotesToggle.find('span:nth-child(1)').text('Expand Footnotes');
    } else {
      footnotesToggle.addClass('open')
      footnotesToggle.find('span:nth-child(1)').text('Collapse Footnotes');
    }
  });

  $('.footnote_hard_link').on('click', function () {
    $('.footnote_container_prepare p').addClass('open');
    footnotesToggle.find('span:nth-child(1)').text('Collapse Footnotes');
  });

  // ToC Links
  $(document).on('click', '.tree a', function (e) {
    var href = $(this).attr('href');
    history.replaceState(undefined, undefined, href)
  });
  $(window).on('load', function () {
    var hash = window.location.hash;
    if (hash) {
      $('.tree [href="' + hash + '"]').trigger('click');
    }
  });

});

// reverse append isn't working, and I'm not sure I know how to fix it , alos probbaly need to add back in the ability to swap the css for the arrow indcator, sicne it will ned to rortate

// window.onclick = e => {
//   console.log(e.target);  // to get the element
// }
