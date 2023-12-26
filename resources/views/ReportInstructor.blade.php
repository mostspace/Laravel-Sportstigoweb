@include('layouts.head')
<body>
<div class="dash wrapper">

    @include('layouts.header')
  
    <div class="main-section pt-2 pb-4">
    <div class="container-fluid">

      <div class="row d-flex align-items-center justify-content-between mx-4">
        <div class="d-flex"> 
          <div class="black-box">
            <div><span class="main-text">SALES REPORT</span></div>
            <div><span class="sub-text">PARTNER SALES REPORT</span></div>
          </div>
          <a href = "{{ route('dashboard') }}">
          <div class="black-box">
            <div><span class="main-text">BACK TO MAIN</span></div>
            <div><span class="sub-text2"></span></div>
          </div></a>
        </div>
        <div class="d-flex"> 
        <a href = "{{ route('vendoronlinesalesreport') }}">  
        <div class="white-box text-center">
          <img src="<?php echo asset('assets\img\payment.svg'); ?>"> 
            <div><p class="w-text">Online Sales Report</p></div>
          </div>
        </a> 
        
        <a href = "{{ route('vendorvoucherreport') }}">  
          <div class="white-box text-center"> 
          <img src="<?php echo asset('assets\img\voucher.svg'); ?>"> 
            <div><p class="w-text">Voucher Report</p></div>
          </div></a>
          <a href = "{{ route('vendorcountersalesreport') }}">  
          <div class="white-box text-center"> 
          <img src="<?php echo asset('assets\img\cashier.svg'); ?>"> 
            <div><p class="w-text">Counter Sales Report</p></div>
          </div>
          </a>
          <a href="{{route('vendorwithdrawreport')}}">
          <div class="white-box text-center"> 
          <img src="<?php echo asset('assets\img\cash-machine.svg'); ?>"> 
            <div><p class="w-text">Withdrawal Report</p></div>
          </div></a>
          <a href = "{{ route('vendormembership') }}">  
          <div class="white-box text-center">
            <img src="<?php echo asset('assets\img\payment.svg'); ?>"> 
              <div><p class="w-text">Membership Report</p></div>
            </div>
          </a>
        </div>
      </div>

      <div class="custom-border mt-4 mb-4"></div>

      

 

      

      <form action="" method="post"  enctype="multipart/form-data">


      <div class="container">
        <div class="row">
          <div class="col-md-12">



        <div class="row mt-5 mb-3">
          <div class="col-md-4">
            <div class="main-title">
              <h3>Instructors Details Report</h3>
            </div>
          </div>
          <div class="col-md-8 text-right">
            Search Report From 
            <input type="date" name="from" id="from" value="{{ old('fromdate')}}" class="custom-field ml-2"> To 
            <input type="date" name="to" id="to" value="{{ old('fromdate') }}"  class="custom-field ml-2" onchange="filterreport()">
            
          </div>
        </div>
        
        <table class="s-report table table-responsive table-striped" style="width:100%;">
          <thead>
            <tr>
              <th scope="col">DATE</th>
              <th scope="col">BOOKING NO</th>
              <th scope="col">INSTRUCTOR NAME</th>
              <th scope="col">VENDOR NAME</th>
              <th scope="col">CATEGORY</th>
              <th scope="col">USER NAME</th>
              <th scope="col">INSTRUCTOR HIRE DATE</th>
              <th scope="col">TIME</th>
              <th scope="col">AMOUNT</th>
              <th scope="col">COMMISSION</th>
              <th scope="col">NET PROFIT</th>
              <th scope="col">BOOKING STATUS</th>
              <th scope="col">PAYMENT STATUS</th>
             
            </tr>
          </thead>
          <tbody>
          
          @if(count($instructordetails) > 0)
          @foreach($instructordetails as $instructordtls)

          <tr>
              <th scope="row">{{\Carbon\Carbon::parse($instructordtls->created_at)->format('d.m.Y')}}</th>
              <td>{{$instructordtls->instructor_booking_no}}</td>
              
              <td>{{$instructordtls->user_name}}</td>
              <td>{{$instructordtls->sportcenter}}</td>
              <td>{{$instructordtls->name}}</td>
              <td>{{$instructordtls->username}}</td>
              <td>{{\Carbon\Carbon::parse($instructordtls->date)->format('d.m.Y')}}</td>
              <td>{{$instructordtls->time}}</td>
              <td>{{$instructordtls->amount}}</td>
              <td>{{$instructordtls->admin_commision}}</td>
              <td>{{$instructordtls->netprofit}}</td>
              
                            
                            <?php $bookingstatus = $instructordtls->bookingstatus;
                              
                              if($bookingstatus==0)
                              {
                                $checkbookingstatus = 'New Booking'; 
                                echo '<td><b><font color="red">'.$checkbookingstatus.'</font></b></td>';
                              }
                              if($bookingstatus==1)
                              {
                                $checkbookingstatus = 'Accept this Offer'; 
                                echo '<td><b><font color="red">'.$checkbookingstatus.'</font></b></td>';
                              }
                              if($bookingstatus==2)
                              {
                                $checkbookingstatus = 'Payment Done'; 
                                echo '<td><b><font color="red">'.$checkbookingstatus.'</font></b></td>';
                              }
                              if($bookingstatus==3)
                              {
                                $checkbookingstatus = 'Job Not Done'; 
                                echo '<td><b><font color="red">'.$checkbookingstatus.'</font></b></td>';
                              }
                              if($bookingstatus==4)
                              {
                                $checkbookingstatus = 'Job Done'; 
                                echo '<td><b><font color="green">'.$checkbookingstatus.'</font></b></td>';
                              }
                              
                              ?>

              
                            <?php $paystatus_id = $instructordtls->paystatus_id;
                              
                              if($paystatus_id==0)
                              {
                                $checkpaystatus_id = 'Pending'; 
                                echo '<td><b><font color="red">'.$checkpaystatus_id.'</font></b></td>';
                              }
                              else
                              {
                                $checkpaystatus_id = 'Success'; 
                                echo '<td><b><font color="green">'.$checkpaystatus_id.'</font></b></td>';
                              }
                              ?>

             

            


                              

                              
                         
          

            </tr>
            <tr>
              <td colspan="9"></td>            
            </tr>


          @endforeach
          @else
          <tr>
              <td colspan="13" align="center"><b>No Records Found</b></td>            
         </tr>


          @endif
        
        </tbody>
        </table>

        <div class="w-100">
        {!! $instructordetails->links() !!}
      
        </div>
	
        

      </div>
      </div>
      </div>

  </div>
</div>
            </form>

<script>

function filterreport()
{
  var fromdate = document.getElementById("from").value; 
	var todate = document.getElementById("to").value;
  var url = "{{route('instructorreportfilter',['',''])}}" +"/"+fromdate+"/"+todate ;
	window.location.href=url;           
  
}

</script>

@include('layouts.footer')  