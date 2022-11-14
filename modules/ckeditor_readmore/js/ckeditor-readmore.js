/**
 * @file
 * CKEditor Read more functionality.
 */

(function ($) {
  'use strict';
  Drupal.behaviors.ckeditorReadmore = {
    attach: function (context, settings) {
      var $ckeditorReadmore = $('.ckeditor-readmore');

      var type = $ckeditorReadmore.data('readmore-type');
      var more_text = Drupal.t($ckeditorReadmore.data('readmore-more-text'));
      var less_text = Drupal.t($ckeditorReadmore.data('readmore-less-text'));

      if ($ckeditorReadmore.length > 0) {
        var $ckeditorReadmoreParent = $ckeditorReadmore
          .once()
          .wrap('<div class="ckeditor-readmore-wrapper"></div>')
          .parent();

        if (type === 'button') {
          $ckeditorReadmoreParent.append('<button class="ckeditor-readmore-toggler">'+more_text+'</button>');
        } else {
          $ckeditorReadmoreParent.append('<a class="ckeditor-readmore-toggler" href="#">'+more_text+'</a>');
        }
        $('.ckeditor-readmore-toggler').once().on('click', function (event) {
          event.preventDefault();
          $(this).blur();

          var $element = $(this).prev();

          //get element display before toggling
          if ($element.css('display') === 'none') {
            $(this).html(less_text);
          } else {
            $(this).html(more_text);
          }

          $element.slideToggle();
        });
      }
    }
  };
})(jQuery);
