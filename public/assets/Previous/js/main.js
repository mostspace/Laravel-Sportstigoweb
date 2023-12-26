//Upload file
function readURL(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function (e) {
        var img_id = "." + $(input).attr('id');
      $(img_id + " .image-upload-wrap").hide();

      $(img_id + " img").attr("src", e.target.result);
      $(img_id + " .file-upload-content").show();

      $(img_id + " .image-title").html("X");
    };

    reader.readAsDataURL(input.files[0]);
  } 
}

$(".remove-image").click(function() {
    var del_id = "." + $(this).attr('id');
    $(del_id + " .file-upload-content").hide();
    $(del_id + " .image-upload-wrap").show();
});






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




// function removeUpload() {
  
//   $(".file-upload-input").replaceWith($(".file-upload-input").clone());
//   $(".file-upload-content").hide();
//   $(".image-upload-wrap").show();
// }





