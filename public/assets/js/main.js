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


// $("#datepicker").datepicker( {
//   firstDay: 1,
//   onSelect: function() {
//     var dateText = $.datepicker.formatDate("MM dd, yy", $(this).datepicker("getDate"));
//          $('.bgText').text(dateText);
		
//     }
// });

$('.courtbox input').change(function() {
if($(this).is(':checked')){
	var selid= "."+$(this).attr('id');
	
	var cname= $(""+selid+ " .bs-title .cname").text();
	$('.selcname').text(cname);
	$('.cnameval').val(cname);
	var cprice= $(""+selid+ " .bs-title .cprice").text();
	$('.selcprice').text(cprice);
	$('.cpriceval').val(cprice);
}

});

$('.timebox input').change(function() {
if($(this).is(':checked')){
	
	
	var selid= "."+$(this).attr('id');
	var ctime= $(""+selid+"").text();
	var cidate= $(".cid").text();
	var codate= $(".cod").text();
	$('.seltime').text(ctime);
	$('.ccival').val(cidate+ctime);
	$('.ccdval').val(codate+ctime);
}

});


// function removeUpload() {
  
//   $(".file-upload-input").replaceWith($(".file-upload-input").clone());
//   $(".file-upload-content").hide();
//   $(".image-upload-wrap").show();
// }




 // ------------step-wizard-------------
$(document).ready(function () {
    $('.nav-tabs > li a[title]').tooltip();
    
    //Wizard
    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {

        var target = $(e.target);
    
        if (target.parent().hasClass('disabled')) {
            return false;
        }
    });

    $(".next-step").click(function (e) {

        var active = $('.wizard .nav-tabs li.active');
        active.next().removeClass('disabled');
        nextTab(active);

        $('.wizard').find('.nav-tabs li.active').prev().addClass('completed');

    });
    $(".prev-step").click(function (e) {

        var active = $('.wizard .nav-tabs li.active');
        prevTab(active);

        $('.wizard').find('.nav-tabs li.active').removeClass('completed');

    });
});

function nextTab(elem) {
    $(elem).next().find('a[data-toggle="tab"]').click();
}
function prevTab(elem) {
    $(elem).prev().find('a[data-toggle="tab"]').click();
}

$('.nav-tabs').on('click', 'li', function() {
    $('.nav-tabs li.active').removeClass('active');
    $(this).addClass('active');
});

