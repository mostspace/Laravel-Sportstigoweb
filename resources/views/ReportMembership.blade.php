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
            <img src="<?php echo asset('assets\img\vip.svg'); ?>"> 
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
              <h3>Membership Report</h3>
            </div>
          </div>
          <div class="col-md-8 text-right">
            Search Report From 
            <input type="date" name="from" id="from" value="" class="custom-field ml-2"> To 
            <input type="date" name="to" id="to" value="{{ old('todate') }}"  class="custom-field ml-2" onchange="filterreport()">
            
          </div>
        </div>
        
        
       
        <table class="s-report table table-striped" style="width:100%;">
          <thead>
            <tr>
              <th scope="col">DATE</th>
              <th>Vendor Name</th>
              <th>User Name</th>
              <th>Package Name</th>
              <th>Package Duration</th>
              <th>Active Duration(From)</th>
              <th>Active Duration(To)</th>
              <th>Person</th>
              <th>Package Price</th>
              <th>Payment Status</th>
              
            </tr>
          </thead>
          <tbody>

           @if(count($membershipsdetails) > 0)
           @foreach($membershipsdetails as $mshipsdetails)
           
           <tr>
              <th scope="row">{{\Carbon\Carbon::parse($mshipsdetails->created_at)->format('d.m.Y')}}</th>
              <td>{{$mshipsdetails->businessname}}</td>
              <td>{{$mshipsdetails->name}}</td>
              <td>{{$mshipsdetails->package_name}}</td>
              <td>{{$mshipsdetails->package_duration}} Months</td>
              <td>{{\Carbon\Carbon::parse($mshipsdetails->fromdate)->format('d.m.Y')}}</td>
              <td>{{\Carbon\Carbon::parse($mshipsdetails->todate)->format('d.m.Y')}}</td>
              <td>{{$mshipsdetails->person}}</td>
              <!--<td>RM {{number_format($mshipsdetails->package_price,2)}}</td>!-->
              <td>RM {{number_format($mshipsdetails->totalpackage_price,2)}}</td>
              

              <?php $paystatus_id = $mshipsdetails->paystatus_id;
                              
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
          @endforeach
          @else
            <tr>
              <td colspan="9" align="center"><b>No Records Found</b></td>            
           </tr>
           @endif
          
         

         
       </tbody>
        </table>

        <div class="w-100">
        
        {!! $membershipsdetails->links() !!}
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
  var url = "{{route('vendormembershipfilter',['',''])}}" +"/"+fromdate+"/"+todate ;
	window.location.href=url;           
  
}

</script>

@include('layouts.footer')  