@include('layouts.head')
<body>
<?php $pageheading ='CHECKIN WITH BOOKING NO'; ?>
<div class="dash wrapper">

  @include('layouts.header')

  @if (session('success'))
  <div class="alert alert-success" role="alert">
      {{ session('success') }}
  </div>
@endif

<div class="dash wrapper">

  

  <div class="custom-border">
  </div>


<form action="{{ route('checkwithbookingnoqrcode')}}" method="post"  enctype="multipart/form-data">
 @csrf 
  <div class="main-section pt-4 pb-4">
    <div class="container">

      <div class="row"> 
      <div class="col-md-4">             
          <div class="black-box">
            <div><span class="main-text">SCAN NOW</span></div>
            <div><span class="sub-text">Scan Booking QR Code</span></div>
          </div>
		      <a href="{{route('dashboard')}}">
          <div class="black-box">
            <div><span class="main-text">BACK TO MAIN</span></div>
            <div><span class="sub-text2">Back to MAin Menu</span></div>
          </div></a>
        </div>
       
		 
	
        <div class="col-md-8">

        <div class="row mt-5">
                
                  <div class="col-md-12">
                    @if(!isset($bookingdetails))
                    <video id="preview" width="100%"></video>
                    @endif 
                    @if(isset($bookingdetails))
			              @if(count($bookingdetails) == 0)
                    <video id="preview" width="100%"></video>
                    @endif 
                    @endif 

                  </div>
                <div class="col-md-3" height="200px;">
                <div id="bookingaccept" style="display: none;"><button type="submit" class="light-green-btn mt-4" name="booking">BOOKING DETAILS</div>  
                    @if(isset($bookingdetails))
			              @if(count($bookingdetails) > 0)
                         <div id="bookingaccept" style="display: block;"><button type="submit" class="light-green-btn mt-4" name="booking">BOOKING DETAILS</div>      
                    @endif
			              @endif

                 </div>
                <div class="col-md-3" height="200px;">
                    
                    <input type="hidden" name="text" id="text" readonyy="" placeholder="scan booking no" class="form-control">
                    
                 </div>
                 <!--<div class="col-md-5">
                 <button type="submit" class="light-gray-btn mt-4">GO</button>
                 </div>!-->
                
                
                
        </div>

        
        
          <div class="row mt-5">
            <div class="col-lg-10">
          
			  @if(isset($bookingdetails))
			  @if(count($bookingdetails) > 0)
			  <div class="row">
                <div class="col-md-12">
                  <span class="booking-title d-block">Booking Summary :</span>
                  <span class="booking-title">Venue Name : <?php if(!empty(Session::get('getsessionloginname'))) { echo Session::get('getsessionloginname'); } ?></span>
                   <span class="booking-title"><br>Payment Method : 
                    <?php 
                    if($paymethoddtls->paymethod==1) 
                    { 
                      echo 'Online Payment'; 
                    } 
                    else
                    {
                      echo 'Counter Payment'; 
                    }
                    ?>
                  </span>
                    <span class="booking-title"><br>Booking No: {{$paymethoddtls->bookingno }} </span>
                </div>
                </div>
			  @endif
			  @endif
			  
			  @if(isset($bookingdetails))
			  @if(count($bookingdetails) > 0)
			  @foreach($bookingdetails as $bookdtls)
		  
				
                <div class="col-md-6"></div>
                <div class="custom-border mt-2 mb-2"></div>
                <span class="booking-title d-block">{{$bookdtls->courtname}} :</span>
              <!--<div class="row">
                <div class="col-md-8 text-right">
                  <span class="booking-title text-right">Checkin Date /Time : 12.30PM / 12.12.2022</span>
                </div>
                <div class="col-md-4 text-left">
                  <span class="booking-title text-green ml-4"></span>
                </div>
              </div>!-->

              <div class="row align-items-center">
                <div class="col-md-7 text-right">
                        <span class="booking-title text-right">
                                                  Checkin Date /Time : {{ \Carbon\Carbon::parse($bookdtls->stime)->format('h.ia')}} / {{\Carbon\Carbon::parse($bookdtls->date)->format('d.m.Y')}}
                        </span>
                </div>
                <div class="col-md-2 text-left">
                  <span class="booking-title text-green ml-4">RM {{$bookdtls->price}}</span>
                </div>

                <div class="col-md-3 text-left">
                
                <button type="button"  id="btnpostcheckin{{$bookdtls->id}}"  onclick="postcheckin({{$bookdtls->id}});" 
                 
                 <?php

                            if($bookdtls->checkinstatus==0)
                            {

                              ?>
                                      class="light-greencheckin-btn"
                              <?php
                            }
                 ?>
                
                <?php

                      if($bookdtls->checkinstatus==1)
                      {

                        ?>
                                class="light-redcheckin-btn"
                        <?php
                      }
                      ?>
                 
                 
                 
                 >
                  <?php
                  if($bookdtls->checkinstatus==0)
                  {
                    echo "Checkin";
                  }
                  else
                  {
                    echo "Checkin-Done";
                  }
                  ?>
                </button>
                
               </div>
              </div>

              <!--<div class="row">
                <div class="col-md-8 text-right">
                  <span class="booking-title text-right">BOOKING FEES</span>
                </div>
                <div class="col-md-4 text-left">
                  <span class="booking-title text-green ml-4">RM {{$bookdtls->bookingfees}}</span>
                </div>
              </div>!-->
			  @endforeach
			  @endif
        @endif

        @if(isset($bookingdetails))
			  @if(count($bookingdetails) == 0)
            <div class="booking-title">No Checkin Records founds</div>
        @endif
        @endif


              
			  @if(isset($bookingdetails))
			  @if(count($bookingdetails) > 0)
				  
              <div class="custom-border mt-2 mb-2"></div>
               <div class="row">
                <div class="col-md-8 text-right">
                    <span class="booking-title text-right">BOOKING FEES :</span>
                  </div>
                  <div class="col-md-4 text-left">
                  <span class="booking-title text-green ml-4">RM {{$bookdtls->admin_commision}}</span>
                </div>

                  <div class="col-md-8 text-right">
                    <span class="booking-title text-right">Total Amount :</span>
                  </div>
                  <div class="col-md-4 text-left">
                    <span class="booking-title text-green ml-4"> RM {{$bookingdetails[0]->amount}}</span>
                  </div>
                </div>
                <div class="custom-border mt-2 mb-2"></div>
                <div class="row">
                  <div class="col-md-8 text-right">
                    <span class="booking-title text-right">Payment Date : </span>
                  </div>
                  <div class="col-md-4 text-left">
                    <span class="booking-title text-green ml-4">{{ \Carbon\Carbon::parse($bookingdetails[0]->created_at)->format('d.m.Y')}}</span>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-8 text-right">
                    <span class="booking-title text-right">Payment Time :</span>
                  </div>
                  <div class="col-md-4 text-left">
                    <span class="booking-title text-green ml-4"> {{ \Carbon\Carbon::parse($bookingdetails[0]->created_at)->format('h.i a')}}</span>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-8 text-right">
                    <span class="booking-title text-right">Payment Status :</span>
                  </div>
                  <div class="col-md-4 text-left">
                    <span class="booking-title text-green ml-4"> 
                    <?php 
                    if($bookingdetails[0]->paystatus=='N') 
                    { 
                      echo 'Paid at mobile'; 
                    } 
                    else if($bookingdetails[0]->paystatus=='M') 
                    { 
                      echo 'Paid at mobile'; 
                    } 
                    else
                    {
                      echo 'Paid at counter'; 
                    }
                    ?>



                    </span>
                  </div>
                </div>

                <div class="row">              
                              <div class="col-xl-3 col-lg-3 col-md-3">
                                        <div class="form-group">
                                            <div class="mt-2 mb-2">
											
							                                  <img src="{{asset($bookdtls->qrcodeimage)}}" width="200px" alt="Blog-image" />
                                            </div>
                                        </div>
            </div>
          </div>  

            </div>
			        @endif
              @endif

              @if(!isset($bookingdetails))
                   <!--<div>No Checkin Records founds</div>!-->
                    
              @endif


          </div>
        </div>
		
      </div>

    </div>
  </div>

  </form>


</div>

<!--<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/webrtc-adapter/3.3.3/adapter.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.1.10/vue.min.js"></script>
<script type="text/javascript" src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">!-->


<script src="<?php echo asset('assets\jsqrcode\adapter.min.js'); ?>"></script>  
<script src="<?php echo asset('assets\jsqrcode\vue.min.js'); ?>"></script>
<script src="<?php echo asset('assets\jsqrcode\instascan.min.js'); ?>"></script>
<link rel="stylesheet" href="<?php echo asset('assets\cssqrcode\bootstrap.min.css'); ?>">

<script>
           let scanner = new Instascan.Scanner({ video: document.getElementById('preview')});
           
           Instascan.Camera.getCameras().then(function(cameras){
               if(cameras.length > 0 ){
                   scanner.start(cameras[0]);
               } else{
                   alert('No cameras found');
               }

           }).catch(function(e) {
               console.error(e);
           });

           scanner.addListener('scan',function(c){
            
            
               document.getElementById('text').value=c;
               //var txtval = c.replace(/"/g, ''); 
                var txtval = c;
                if(txtval.length == 10)
                   {
                      document.getElementById("bookingaccept").style.display = "block";
                   }


                    /*if (txtval == null || txtval == undefined || txtval.length == 0) 
                      {
                        
                      }
                    else
                    {
                      
                      if(txtval.length == 5)
                      {
                          document.getElementById("bookingaccept").style.display = "block";
                      }

                    }*/
               
               
           });






function postcheckin(id)
{

    //console.log("postcheckin");
    //console.log(id);
    var url = '{{route("postcheckin")}}';
		$.ajax({
			type : "POST",
			url : url,
			headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}' },
			data :{
					bookingid : id,
         
			},
			dataType: 'json',
			
			success:function(data)
      {
        
          var btn = document.getElementById("btnpostcheckin"+id);
          btn.value = 'Checkin-Done'; 
          btn.innerHTML = 'Checkin-Done';
          document.getElementById("btnpostcheckin"+id).classList.add('light-redcheckin-btn');
          document.getElementById("btnpostcheckin"+id).classList.remove('light-greencheckin-btn');
			
         
      }
		});

}




</script>

@include('layouts.footer')