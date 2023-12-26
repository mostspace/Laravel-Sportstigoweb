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


<?php
  $check = 'SEARCH';

  if(isset($_POST['bookingno']))
  {
       if($_POST['bookingno']=='')
       {
         $check = 'SEARCH';
       }
       else
       {
         $check = 'SEARCH';
       }
       
  }

?>

  <form action="{{ route('checkwithbookingno')}}" method="post"  enctype="multipart/form-data">
 @csrf 
  <div class="main-section pt-4 pb-4">
    <div class="container">

      <div class="row"> 
        <div class="col-md-4">             
          <div class="black-box">
            <div><span class="main-text">CHECK BOOKING</span></div>
            <div><span class="sub-text">check Booking Status</span></div>
          </div>
		  <a href="{{route('dashboard')}}">
          <div class="black-box">
            <div><span class="main-text">BACK TO MAIN</span></div>
            <div><span class="sub-text2">Back to MAin Menu</span></div>
          </div></a>
        </div>
	
        <div class="col-md-8">
          <label for="bookingno" class="custom-label">Enter Booking No</label>
          <div class="row">
            <div class="col-lg-6">
              <div class="form-group">                
                <input type="text" class="custom-field w-100 form-control" id= "bookingno" 
				value="<?php if(isset($_POST['bookingno'])){ echo $_POST['bookingno']; } ?>" name="bookingno">
				</div>
            </div>
            <div class="col-lg-6">
              <div class="form-group">                
                
              <button type="submit" class="light-gray-btn"><?php echo $check;?></button>
             
             
              </div>
            </div>
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

                

            </div>
			        @endif
              @endif

              @if(!isset($bookingdetails))
                   <div class="booking-title">No Checkin Records founds</div>
                    
              @endif


          </div>
        </div>
		
      </div>

    </div>
  </div>

  </form>


</div>

<script>
  function postcheckin(id)
{

   
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