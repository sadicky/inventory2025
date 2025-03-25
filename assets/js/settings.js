(function($) {
  'use strict';
  $('body').css('zoom','80%');
  $(".ms-settings-toggle").on('click', function(e){
    $('body').toggleClass('ms-settings-open');
  });

  $("#dark-mode").on('click', function(){
    $('body').toggleClass('ms-dark-theme');
  });
  $("#remove-quickbar").on('click', function(){
    $('body').toggleClass('ms-has-quickbar');
  });
  $("#hide-aside-left").on('click', function(){
    $('body').toggleClass('ms-aside-left-open');
  });

  $('.select2').select2();
})(jQuery);
