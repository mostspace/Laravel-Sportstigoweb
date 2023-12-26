
(function($) {
    "use strict";
    var fullHeight = function() {
        $('.js-fullheight').css('height', $(window).height());
        $(window).resize(function() {
            $('.js-fullheight').css('height', $(window).height());
        });
    };
    fullHeight();
    $('#sidebarCollapse').on('click', function() {
        $('#sidebar').toggleClass('active');
        $('#content').toggleClass('m-0 full-width');
    });
    $('.closebtn').on('click', function() {
        $('#sidebar').removeClass('active');
    });
})(jQuery);


$("#datepicker").datepicker( {
  firstDay: 1,
  onSelect: function() {
    var dateText = $.datepicker.formatDate("MM dd, yy", $(this).datepicker("getDate"));
         $('p.bgText').text(dateText);
    }
});





