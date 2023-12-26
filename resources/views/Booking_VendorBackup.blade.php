@include('layouts.head')
<body>

<div class="dash wrapper">
	
   @include('layouts.header')

  <div class="custom-border">
  </div>

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
                                    <a href="#step2" data-toggle="tab" aria-controls="step2" role="tab" aria-expanded="false"><span class="round-tab"></span> <i>Select Court</i></a>
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
        
                        
						
					<form action="{{ route('payatcounter')}}" method="post"  enctype="multipart/form-data">
					@csrf 
						
						<input type="hidden" name="loginid" id = "loginid" value="<?php if(!empty(Session::get('getsessionuserid'))) { echo Session::get('getsessionuserid'); } ?>">
                            <div class="tab-content" id="main_form">
                              <div class="tab-pane active" role="tabpanel" id="step1">
                                <div class="row">
                                  <div class="col-md-8">
                                    <div id="datepicker" class="calendar"></div><div></div>
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
								<div id="courttimedetails">
								
                                  
                                    
									 
									                        
                                  </div>                                
                                </div>     
                                <div class="col-lg-4">
                                      <ul class="list-inline pull-right">
                                        <li><button type="button" class="green-btn next-step step-time" disabled>NEXT</button></li>
                                        <li><button type="button" class="green-btn prev-step mt-3">BACK</button></li>
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
                                        <input type="text" class="form-control" name="mobile" id="mobile">
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
                                      <li><button type="button" class="green-btn prev-step mt-3">BACK</button></li>
                                    </ul>
                                  </div> 
                                </div>
                              </div>
                              <div class="tab-pane" role="tabpanel" id="step5">
                                <div class="row">
                                  
								  <div class="col-lg-8">
                                    <div class="bs">
                                      <h6>Booking Summary :</h6>
                                      
                                      <div id="bookingsummary">
									 
									  </div>
                                    </div>
                                  </div>
								  
								 
                                  <div class="col-lg-4">
                                    <ul class="list-inline pull-right">
                                      <li><button type="button" onclick="postpayatcounter('1');" class="green-btn step-payment">PAY ON MOBILE</button></li>
                                      <li><button type="submit" class="green-btn mt-3">PAY AT COUNTER</button></li>
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
<script src="<?php echo asset('assets\js\jquery.js'); ?>"></script>
<script type="text/javascript">

    $(document).ready(function(){
        $(".step-date").click(function(){
			$("div.steptext").text("SELECT COURT");
			
			$('#datepicker').datepicker('option', 'dateFormat', 'yy-mm-dd');
			var id = $('#datepicker').val();
			//alert(id);
			
		$("#court_details").html('');
		var url = '{{ route("getcourtdetails", ":id") }}';
				url = url.replace(':id', id);
				
				$.ajax({
					type : "GET",
					url : url,
					dataType: 'json',
					
					
					success:function(data){
						
						//alert(data);
						$("#court_details").append(data)
					
					}
				});
				
					
			
			
			
        });
        $(".step-court").click(function(){
			
            $("div.steptext").text("SELECT TIME");
        });
        $(".step-time").click(function(){
            $("div.steptext").text("BOOKING INFO");
		});
        $(".step-info").click(function(){
            $("div.steptext").text("PAYMENT");
        });
    });
	
	  
	  
	var court_id_arr = [];
	
	
	function removeItem(court_id_arr, item){
		return court_id_arr.filter(f => f !== item)
	}
	
  $(".court-back").click(function(){
    $(".step-court").attr("disabled","");
  });

	function handleClick(chkevent){
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
		//console.log("courid");
		//console.log(courid);
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
		console.log("court_id_arr");
		console.log(court_id_arr);	
    
      
      
      
     
	}
	
	
	function removeItemcourttime(courttime_id_arr, item){
		return courttime_id_arr.filter(f => f !== item)
	}
	var courttime_id_arr = [];
	
	function handleCourttimeClick(chkevent){
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
		if(checkvalueischecked == true){
			console.log("in true");
			console.log(courttimeid);
			courttime_id_arr.push(courttimeid);
			
			
		}else{
			console.log("in false");
			courttime_id_arr = removeItemcourttime(courttime_id_arr, courttimeid);
		}
		
		$("#bookingsummary").html('');
		
		var url = '{{route("getcourttimesummay")}}';
		var courseids = courttime_id_arr.toString();
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
				
				 $("#bookingsummary").append(data)
				
				
				
			}
		});
		
		
		console.log("courttime_id_arr");
		console.log(courttime_id_arr);
		
	}
	


</script>


<script>

function postpayatcounter(paymethod)
{
  
	
  var url = "{{route('payatcounter',[''])}}" +"/"+paymethod;
	window.location.href=url;           
  
}

</script>




 @include('layouts.footer')