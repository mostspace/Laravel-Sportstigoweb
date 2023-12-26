@include('layouts.head')
<body>

<div class="dash wrapper">

   @include('layouts.header')

  <div class="custom-border">
  </div>
  <div id="checkindetailssuccess">
  <div class="main-section pt-4 pb-4">
    <div class="container">
      <div class="boxes row">
        <div class="col-md-4 p-0">
          <div class="black-box">
            <div><span class="main-text">Booking</span></div>
            <div><span class="sub-text">Book Your Sports</span></div>
          </div>
        </div>



        <div class="col-md-4 p-0">
          <div class="black-box">
            <div class="steptext"><span class="main-text">SELECT DATE</span></div>
            <div><span class="sub-text">Select Sports Slot/Court Booking Date</span></div>
          </div>
        </div>
        <div class="col-md-4 p-0">
          <div class="black-box">
          <a href="{{ route('dashboard') }}"> <div class="steptext"><span class="main-text">BACK</span></div></a>
          <div><span class="sub-text2">Back to Home</span></div>
          </div>
        </div>
      </div>



      <section class="signup-step-container">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-md-12">
                    <div class="wizard">
                        <div class="form-stepper wizard-inner">
                            <!-- <div class="connecting-line"></div> -->
                            <ul class="nav nav-tabs align-items-center" role="tablist">
                                <li role="presentation" class="active">
                                    <a href="#step1" data-toggle="tab" aria-controls="step1" role="tab" aria-expanded="true"><span class="round-tab"></span> <i>Select Date</i></a>
                                </li>
                                <li role="presentation" class="disabled">
                                    <a href="#step2" data-toggle="tab" aria-controls="step2" role="tab" aria-expanded="false"><span class="round-tab"></span> <i>Select Court/Slot</i></a>
                                </li>
                                <li role="presentation" class="disabled">
                                    <a href="#step3" data-toggle="tab" aria-controls="step3" role="tab"><span class="round-tab"></span> <i>Select Time</i></a>
                                </li>
                                <li role="presentation" class="disabled">
                                    <a href="#step4" data-toggle="tab" aria-controls="step4" role="tab"><span class="round-tab"></span> <i>Booking Info</i></a>
                                </li>
                                <li role="presentation" class="disabled">
                                    <a href="#step5" data-toggle="tab" aria-controls="step5" role="tab"><span class="round-tab"></span> <i>Payment</i></a>
                                </li>
                            </ul>

                        </div>




					<form name="form1" method="post"  enctype="multipart/form-data">
					@csrf

						<input type="hidden" name="loginid" id = "loginid" value="<?php if(!empty(Session::get('getsessionuserid'))) { echo Session::get('getsessionuserid'); } ?>">


            <div class="tab-content" id="main_form">
                              <div class="tab-pane active" role="tabpanel" id="step1">
                                <div class="row">

                                  <div class="col-md-8">
                                      <div class="d-flex align-items-center mb-4">
                                        <div class="d-flex align-items-center mr-5">
                                          <span>Open for Booking :</span>
                                          <span class="bookoption opendays ml-2"></span>
                                        </div>
                                        <div class="d-flex align-items-center">
                                          <span>Closed for Booking :</span>
                                          <span class="bookoption closedays ml-2"></span>
                                        </div>
                                      </div>
                                      <div id="datepicker" class="calendar"></div>
                                   <div>

                                </div>



                                  </div>

                                  <div class="col-md-4 mt-5">
                                    <ul class="list-inline text-left">
                                        <li><button type="button" class="green-btn next-step step-date">NEXT</button></li>
                                    </ul>
                                  </div>
                                </div>
                              </div>

							        <div class="tab-pane" role="tabpanel" id="step2">
                                <div class="row">
                                  <div class="col-lg-8" id="court_details">




                                  </div>
                                  <div class="col-lg-4">
                                    <ul class="list-inline pull-right">
                                      <li><button type="button"  class="green-btn next-step step-court" disabled>NEXT</button></li>
                                      <li><button type="button" class="green-btn prev-step court-back mt-3">BACK</button></li>
                                    </ul>
                                  </div>
                                </div>
                              </div>

							   <div class="tab-pane" role="tabpanel" id="step3">
                               <div class="row">
                                <div class="col-lg-8">
								<div id="courttimedetails"></div>
                                </div>
                                <div class="col-lg-4">
                                      <ul class="list-inline pull-right">
                                        <li><button type="button" class="green-btn next-step step-time" disabled>NEXT</button></li>
                                        <li><button type="button" class="green-btn prev-step time-back mt-3">BACK</button></li>

                                        <div id="bookingtotalamount">

                                       </div></h5>
                                      </ul>
                                </div>
                                </div>
                              </div>
                              <div class="tab-pane" role="tabpanel" id="step4">
                                 <div class="row">
                                  <div class="col-lg-8 text-center">
                                    <div>
                                      <div class="form-group">
                                        <label for="userid">Enter Mobile No</label>
                                        <input type="text" id = "mobile" class="form-control" name="mobile" id="mobile" value="+60">
                                        <input type="hidden" id = "getusername" class="form-control" name="getusername" id="getusername">
                                        <input type="hidden" id = "getuserid" class="form-control" name="getuserid" id="getuserid">
                                        <input type="hidden" id = "getemail" class="form-control" name="getemail" id="getemail">




                                      </div>
                                    </div>
                                    <div>
                                      <p class="text-black"><b>TO RECEIVE BOOKING DETAILS<br>
                                      RECORDS, KINDLY ENTER MOBILE NO<br>
                                      WHICH REGISTERED WITH<br>
                                      SPORTSTIGO. MOBILE APP</b></p>
                                    </div>
                                  </div>
                                  <div class="col-lg-4">
                                    <ul class="list-inline pull-right">
                                      <li><button type="button" class="green-btn next-step step-info">NEXT</button></li>
                                      <li><button type="button" class="green-btn prev-step mobile-back mt-3">BACK</button></li>
                                    </ul>
                                  </div>
                                </div>
                              </div>
                              <div class="tab-pane" role="tabpanel" id="step5">
                                <div class="row">

								            <div class="col-lg-8">
                                    <div class="bs">
                                    <div id="getcountmobileuser" >
                                    </div>
                                      <h6>Booking Summary :</h6>

                                      <div id="bookingsummary">

									                    </div>
                                    </div>
                                  </div>


                                  <div class="col-lg-4">
                                    <ul class="list-inline pull-right">
                                      <li><button type="button"  id="btnpaymobile"  onclick="postpayatcounter('1');" class="green-btn step-payment">PAY ON MOBILE</button></li>
                                      <li><button type="button"  id="btnpaycounter" onclick="postpayatcounter('2');" class="green-btn mt-3">PAY AT COUNTER</button></li>
                                      <li><button type="button" class="green-btn prev-step view-back mt-3">BACK</button></li>
                                    </ul>
                                  </div>
                                </div>
                              </div>
                              <div class="clearfix"></div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

  </div>
  </div>
 </div>
 <div id="bookingdetailssuccess">

  </div>


</div>
<script src="<?php echo asset('assets\js\jquery.js'); ?>"></script>


<script type="text/javascript">






    $(document).ready(function()
    {



              var disableDates_array;
              var url = '{{ route("getcloseingdays") }}';

              $.ajax({
                type : "GET",
                url : url,
                dataType: 'json',

                success:function(data)
                {


                        disableDates_array = data;
                        const disableDates = disableDates_array.split(",");

                       // disableDate = ["2022-11-18","2022-11-19","2022-11-20","2022-11-22","2022-11-23"] // yyyy/MM/dd
                       console.log("disableDates" );
                       console.log(disableDates );

                        function ShowDisableDates(date)
                                      {

                                              ymd = date.getFullYear() + "-" + ("0" + (date.getMonth() + 1)).slice(-2) + "-" + ("0" + date.getDate()).slice(-2);
                                              day = new Date(ymd).getDay();
                                              if ($.inArray(ymd, disableDates) < 0) {
                                              return [true, "enabled", "Open Days"];
                                              } else {
                                              return [false, "disabled", "Closing Days"];
                                              }
                                        }
                                        $(function() {
                                            $("#datepicker").datepicker({beforeShowDay:ShowDisableDates,minDate: 0});
                                        });

                }
              });




      $(".step-date").click(function()
              {

                      $("div.steptext").text("SELECT COURT");
                      $('#datepicker').datepicker('option', 'dateFormat', 'yy-mm-dd');
                      var id = $('#datepicker').val();

                      var res = disableDates_array.includes(id);
                      //console.log("res="+res);
                      if(res==false)
                      {
                                    $("#court_details").html('');
                                    var url = '{{ route("getcourtdetails", ":id") }}';
                                    url = url.replace(':id', id);

                                    $.ajax({
                                    type : "GET",
                                    url : url,
                                    dataType: 'json',
                                    success:function(data){
                                    $("#court_details").append(data)
                                    }
                                    });

                      }
                      if(res==true)
                      {

                        var url = "{{route('bookingsales')}}";
				                window.location.href=url;

                      }


            });


            $(".step-court").click(function(){

                $("div.steptext").text("SELECT TIME");
            });
                $(".step-time").click(function(){
                $("div.steptext").text("BOOKING INFO");
            });
            $(".step-info").click(function(){
            $("div.steptext").text("PAYMENT");

            var mobileno = $('#mobile').val();
            if (mobileno == null || mobileno == undefined || mobileno.length == 0)
              {
                mobileno = '+60';
              }

             var url = '{{ route("checkregisteruser", ":mobileno") }}';
              url = url.replace(':mobileno', mobileno);




              $("#getcountmobileuser").html('');
              $.ajax({
                type : "GET",
                url : url,
                dataType: 'json',

               success:function(data){

                if(data[0]>=1){

                  $(".step-payment").removeAttr("disabled");
                    $("#getcountmobileuser").append("User registered with Pay on Mobile")
                    document.getElementById("getcountmobileuser").style.color = "green";
                    document.getElementById("getcountmobileuser").style.fontSize = "x-large";
                    document.getElementById("getusername").value = data[1];
                    document.getElementById("getuserid").value = data[3];
                    document.getElementById("getemail").value = data[4];


                  }
                  else{

                    $(".step-payment").attr("disabled","");
                  $("#getcountmobileuser").append("User not registered with Pay on Mobile")
                  document.getElementById("getcountmobileuser").style.color = "#FF0000";
                  document.getElementById("getcountmobileuser").style.fontSize = "x-large";


                  }

                }
              });



        });
    });





  var court_id_arr = [];
	function removeItem(court_id_arr, item){
		return court_id_arr.filter(f => f !== item)
	}
  $(".step-court,.step-time").attr("disabled","");
  $(".court-back").click(function()
  {

    $(".step-court,.step-time").attr("disabled","");
  });
  $(".time-back").click(function()
  {

    $(".step-time").attr("disabled","");
    //console.log("time-back");
    //console.log(court_id_arr);
    court_id_arr = [];
    //console.log(court_id_arr.toString())



  });
  $(".mobile-back").click(function()
  {

  });

  $(".view-back").click(function()
  {

  });
	function handleClick(chkevent)
  {

    $("#court_details input[type=checkbox]").each(function(){
              var itemslength= $("#court_details input[type=checkbox]:checked").length;
                if(itemslength<1){
                  $(".step-court").attr("disabled","");

                  }
                  else{
                    $(".step-court").removeAttr("disabled");
                  }
            });
            var courid = $(chkevent).attr("data-id")
            console.log("courid");
            console.log(courid);
            var checkvalueischecked = $(chkevent).is(":checked");
            if(checkvalueischecked == true){
              //console.log("in true");
              court_id_arr.push(courid);
            }else{
              //console.log("in false");
              court_id_arr = removeItem(court_id_arr, courid);
            }
		      $("#courttimedetails").html('');


          var url = '{{route("getcourttime")}}';


          var courseids = court_id_arr.toString();
          var vendor_id = document.getElementById("loginid").value;


          $.ajax({
            type : "POST",
            url : url,
            headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            data :{
                vendor_id : vendor_id,courseids:courseids
            },
            dataType: 'json',
            error: function(jqXHR, textStatus, errorThrown) {
              console.log(textStatus, errorThrown);
            },
            success:function(data){


              $("#courttimedetails").append(data)



            }
          });


  }



	function removeItemcourttime(courttime_id_arr, item){
		return courttime_id_arr.filter(f => f !== item)
	}


	var courttime_id_arr = [];

	function handleCourttimeClick(chkevent)
  {


    $("#courttimedetails .timeItem").each(function(){
            var timeid= $(this).attr('id');
            var itemslengths= $("#"+timeid+" input[type=checkbox]:checked").length;

              if((itemslengths<=1) && (itemslengths==0)){
                $(".step-time").attr("disabled","");
              }
              else{
                $(".step-time").removeAttr("disabled");
              }

          });


          var courttimeid = $(chkevent).attr("data-id")
          var checkvalueischecked = $(chkevent).is(":checked");
          if(checkvalueischecked == true)
          {
            console.log("in true");
            //console.log(courttimeid);
            courttime_id_arr.push(courttimeid);


          }
          else
          {
            console.log("in false");
            courttime_id_arr = removeItemcourttime(courttime_id_arr, courttimeid);
          }

          $("#bookingsummary").html('');
          $("#bookingtotalamount").html('');


          var url = '{{route("getcourttimesummay")}}';
          var courseids = courttime_id_arr.toString();
          var vendor_id = document.getElementById("loginid").value;

          console.log(courseids);


          $.ajax({
            type : "POST",
            url : url,
            headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            data :{
                vendor_id : vendor_id,courseids:courseids
            },
            dataType: 'json',
            error: function(jqXHR, textStatus, errorThrown) {
              console.log(textStatus, errorThrown);
            },
            success:function(data){

              $("#bookingsummary").append(data[0])
              $("#bookingtotalamount").append(data[1])



            }
          });


          //console.log("courttime_id_arr");
          //console.log(courttime_id_arr);

	}
</script>

<script>

function postpayatcounter(id)
{

  if(id==2)
  {
    $("#btnpaycounter").prop("disabled", true);
  }

    var url = '{{route("payatcounter")}}';
		var gmobileno = document.getElementById("mobile").value;
    var gusername = document.getElementById("getusername").value;
    var guserid = document.getElementById("getuserid").value;
    var gemail = document.getElementById("getemail").value;
		$.ajax({
			type : "POST",
			url : url,
			headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}' },
			data :{
					paymentmethodid : id,
          getmobileno : gmobileno,
          getusername : gusername,
          getuserid : guserid,
          getemail : gemail,
			},
			dataType: 'json',

			success:function(data)
      {


        if(id==1)
        {
          //window.location.href=data;
          $("#bookingdetailssuccess").append(data)
          $("#checkindetailssuccess").hide();
        }
        else
        {
          $("#bookingdetailssuccess").append(data)
          $("#checkindetailssuccess").hide();

        }

      }
		});

}

$( "body" ).mouseover(function() {
if($(".ui-datepicker-current-day").hasClass("ui-state-disabled")){
  $(".step-date").attr("disabled","");
  }
  else{
    $(".step-date").removeAttr("disabled");
  }
});



</script>


 @include('layouts.footer')
