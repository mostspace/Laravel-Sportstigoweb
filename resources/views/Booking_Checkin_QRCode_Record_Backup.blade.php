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
            <a href="{{ route('bookingqrcodecheck')}}"><div><span class="main-text">SCAN NOW</span></div></a>
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
                <div class="col-md-10">
                    <video id="preview" width="100%"></video>
                </div>
                <div class="col-md-3" height="200px;">
                    <label>SCAN QR CODE</label>
                    <input type="text" name="text" id="text" readonyy="" placeholder="scan qrcode" class="form-control">
                </div>
            </div>
          <label for="bookingno" class="custom-label">Scan Booking No</label>
          <div class="row">
            <div class="col-lg-6">
              <div class="form-group">                
                <input type="text" class="custom-field w-100 form-control" id= "bookingno" value="<?php if(isset($_POST['bookingno'])){ echo $_POST['bookingno']; } ?>" name="bookingno">
				     </div>
            </div>
            <div class="col-lg-6">
              <div class="form-group">                
                <button type="submit" class="light-gray-btn">CHECKIN</button>
              </div>
            </div>
          </div>


         




          <div class="row mt-5">
            <div class="col-lg-10">
			  
          @if(isset($bookingdetails)) 
			    @if(count($bookingdetails) > 0)
			    @foreach($bookingdetails as $bookdtls)
			    <div class="row">
                <div class="col-md-12">
                  
                  <span class="booking-title">Venue Name : <?php if(!empty(Session::get('getsessionloginname'))) { echo Session::get('getsessionloginname'); } ?></span>
                   <span class="booking-title"><br>Payment Method : 
                   <?php 
                    if($bookdtls->paymethod==1) 
                    { 
                      echo 'Online Payment'; 
                    } 
                    else
                    {
                      echo 'Counter Payment'; 
                    }
                    ?>
                  </span>
                </div>
        </div><br>
        <div class="row">              
        <div class="col-xl-3 col-lg-3 col-md-3">
                                        <div class="form-group">
                                            <div class="mt-2 mb-2">
											
							                                  <img src="{{asset('qrcodeimages/'.$bookdtls->qrcodeimage)}}" width="200px" alt="Blog-image" />
                                            </div>
                                        </div>
            </div>
          </div>  
          </div>                        
        @endforeach
			           
        @endif
        @endif

        </div>
		
      </div>

    </div>
  </div>

  </form>


</div>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/webrtc-adapter/3.3.3/adapter.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.1.10/vue.min.js"></script>
<script type="text/javascript" src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
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
           });
</script>

@include('layouts.footer')