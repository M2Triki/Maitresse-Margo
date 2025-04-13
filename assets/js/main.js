/**
 * Main JavaScript file
 *
 * @package MaitresseMargo
 */

(function ($) {
  "use strict";

  // Document Ready
  $(document).ready(function () {
    // Menu mobile
    $(".menu-toggle").on("click", function () {
      $(".main-navigation").toggleClass("toggled");
    });

    // Sous-menus sur mobile
    if ($(window).width() < 768) {
      $(".menu-item-has-children > a").on("click", function (e) {
        e.preventDefault();
        $(this).parent().toggleClass("sub-menu-open");
        $(this).next(".sub-menu").slideToggle();
      });
    }

    // Smooth scroll pour les ancres
    $('a[href*="#"]:not([href="#"])').on("click", function () {
      if (
        location.pathname.replace(/^\//, "") ===
          this.pathname.replace(/^\//, "") &&
        location.hostname === this.hostname
      ) {
        var target = $(this.hash);
        target = target.length
          ? target
          : $("[name=" + this.hash.slice(1) + "]");
        if (target.length) {
          $("html, body").animate(
            {
              scrollTop: target.offset().top - 100,
            },
            1000
          );
          return false;
        }
      }
    });

    // Initialiser le slider de témoignages si slick est disponible
    if ($.fn.slick) {
      $(".testimonials-slider").slick({
        dots: true,
        arrows: false,
        infinite: true,
        speed: 500,
        slidesToShow: 1,
        adaptiveHeight: true,
        autoplay: true,
        autoplaySpeed: 5000,
      });
    }

    // Animation au scroll
    $(window).on("scroll", function () {
      if ($(this).scrollTop() > 100) {
        $(".site-header").addClass("sticky");
      } else {
        $(".site-header").removeClass("sticky");
      }
    });
  });
})(jQuery);
