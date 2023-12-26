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

      <div class="container">
        <div class="row">
          <div class="col-md-4">
            <div class="purple-outer d-flex align-items-center">
              <div>
                <div class="purple-inner">
                <img src="<?php echo asset('assets\img\mobilesales.svg'); ?>">
                </div>
              </div>
              <div class="ml-2">
                <div><span class="color-main-text">Today Online Booking Sales</span></div>
                <div class="position-relative"><span class="color-sub-text">RM {{number_format($todaysalesviamobile,2)}} </span></div>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="blue-outer d-flex align-items-center">
              <div>
                <div class="blue-inner">
                <img src="<?php echo asset('assets\img\counterx.svg'); ?>">
                </div>
              </div>
              <div class="ml-2">
                <div><span class="color-main-text">Today Sales Via Counter</span></div>

               

                <div class="position-relative"><span class="color-sub-text">RM {{number_format($todaysalesviacounter,2)}} </span></div>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="green-outer d-flex align-items-center">
              <div>
                <div class="green-inner">
                <img src="<?php echo asset('assets\img\totalsales.svg'); ?>">
                </div>
              </div>
              <div class="ml-2">
                <div><span class="color-main-text">Total Sales for today</span></div>
                <div class="position-relative"><span class="color-sub-text">RM {{number_format($todaytotalsales,2)}}</span></div>
              </div>
            </div>
          </div>
        </div>
      </div>


      <div class="container">
        <div class="row mt-3">
          <div class="col-md-4">
          <div class="colorless-outer d-flex align-items-center">
            <div>
              <div class="colorless-inner-1">
              <img src="<?php echo asset('assets\img\sportstigoadmin.svg'); ?>">
              </div>
            </div>
            <div class="ml-2">
              <div><span class="color-main-text">Sporstigo Commision</span></div>
              <div class="position-relative"><span class="color-sub-text">RM {{number_format($SporstigoCommision,2)}}</span></div>
            </div>
          </div>
        </div>
        <?php 
        $role = Session::get('getsessionrole');
        if($role==7)
          {
          ?>
              <div class="col-md-4">
                <div class="colorless-outer d-flex align-items-center">
                  <div>
                    <div class="colorless-inner-1">
                    <img src="<?php echo asset('assets\img\sportstigoadmin.svg'); ?>">
                    </div>
                  </div>
                  <div class="ml-2">
                    <div><span class="color-main-text">SalesAgent Commision</span></div>
                    <div class="position-relative"><span class="color-sub-text">RM {{number_format($SalesagentCommision,2)}}</span></div>
                  </div>
                </div>
              </div>
            <?php
          }
            ?>

    <?php 
        $role = Session::get('getsessionrole');
        if($role==8)
          {
          ?>
              <div class="col-md-4">
                <div class="colorless-outer d-flex align-items-center">
                  <div>
                    <div class="colorless-inner-1">
                    <img src="<?php echo asset('assets\img\sportstigoadmin.svg'); ?>">
                    </div>
                  </div>
                  <div class="ml-2">
                    <div><span class="color-main-text">Vendor Refferal Commision</span></div>
                    <div class="position-relative"><span class="color-sub-text">RM {{number_format($SalesagentCommision,2)}}</span></div>
                  </div>
                </div>
              </div>
            <?php
          }
            ?>

          <div class="col-md-4">
          <div class="colorless-outer d-flex align-items-center">
            <div>
              <div class="colorless-inner-2">
              <img src="<?php echo asset('assets\img\accountnew.svg'); ?>">
              </div>
            </div>
            <div class="ml-2">
              <div><span class="color-main-text">Total Amount in Account</span></div>
              <div class="position-relative"><span class="color-sub-text">RM {{  number_format($totalAmountinAccount,2)}}</span></div>
            </div>
          </div>
        </div>
        <?php 
        $role = Session::get('getsessionrole');
        if(($role!=7) && ($role!=8))
          
          {
          ?>

          <div class="col-md-4">
          <div class="colorless-outer d-flex align-items-center">
            <div>
              <div class="colorless-inner-3">
              <img src="<?php echo asset('assets\img\netprofit.svg'); ?>">
              </div>
            </div>
            <div class="ml-2">
              <div><span class="color-main-text">Today Net Profit</span></div>
              <div class="position-relative"><span class="color-sub-text">RM {{number_format($netprofit,2)}}</span></div>
            </div>
          </div>
        <?php
          }
            ?>
          
        </div>
        </div>
      </div>
      

      <form action="" method="post"  enctype="multipart/form-data">


      <div class="container">
        <div class="row">
          <div class="col-md-12">



        <div class="row mt-5 mb-3">
          <div class="col-md-4">
            <div class="main-title">
              <h3>Sales Voucher Report</h3>
            </div>
          </div>
          <div class="col-md-8 text-right">
            Search Report From 
            <input type="date" name="from" id="from" value="{{ old('fromdate')}}" class="custom-field ml-2"> To 
            <input type="date" name="to" id="to" value="{{ old('fromdate') }}"  class="custom-field ml-2" onchange="filterreport()">
            
          </div>
        </div>
        
        <table class="s-report table table-striped" style="width:100%;">
          <thead>
            <tr>
                <th>Voucher Date</th>
                <th>Voucher Code</th>
                <th>From Date To Date</th>
                <th>Vendor Name</th>
                <th>Total Usage</th>
                <th>Total Amount</th>
                <th>Discount(%)</th>
                <th>Balanced</th>
				       
            </tr>
          </thead>
          <tbody>
          


          @foreach( $allvoucherlist as $voucheretails )
			
          @foreach( explode(",",str_replace( array( '"', '[',']' ), '', $voucheretails->vendor_code))  As $key )
          
          @foreach( $allvendorlist as $vendorlist )
          
                @if( $key == $vendorlist->vendor_id )

              <tr>
                <td>{{ \Carbon\Carbon::parse($voucheretails->voucher_date)->format('d-m-Y')}} </td>
                <td>{{ $voucheretails->voucher_code }}</td>
                <td>{{ \Carbon\Carbon::parse($voucheretails->voucher_from_date)->format('d-m-Y')}} - {{ \Carbon\Carbon::parse($voucheretails->voucher_to_date)->format('d-m-Y')}}</td>
				        <td>{{ $vendorlist->businessname }}</td>
				        <td>{{ $voucheretails->voucher_total_usage }}</td>
                <td>{{ $voucheretails->amount }}</td>
                <td>{{ $voucheretails->voucher_discount }}</td>
			          <?php
                  $calculatediscountamount = $voucheretails->amount * $voucheretails->voucher_discount/100;
                  $balanceamount = $voucheretails->amount - $calculatediscountamount;
                ?>
                <td>{{ $balanceamount  }}</td>
				        <!--<td>{{ $voucheretails->amount }}</td>!-->
              </tr>
              <tr>
              <td colspan="9"></td>            
              </tr>

                @endif
				
				
			    @endforeach	


          @if( $key == '' )

          <tr>
            <td>{{ \Carbon\Carbon::parse($voucheretails->voucher_date)->format('d-m-Y')}} </td> 
				    <td>{{ $voucheretails->voucher_code }}</td>
            <td>{{ \Carbon\Carbon::parse($voucheretails->voucher_from_date)->format('d-m-Y')}} - {{ \Carbon\Carbon::parse($voucheretails->voucher_to_date)->format('d-m-Y')}}</td>
				    <td></td>
				    <td>{{ $voucheretails->voucher_total_usage }}</td>
            <td>{{ $voucheretails->voucher_discount }}</td>
            <td>{{ $voucheretails->amount }}</td>
			      <?php
                  $calculatediscountamount = $voucheretails->amount * $voucheretails->voucher_discount/100;
                  $balanceamount = $voucheretails->amount - $calculatediscountamount;
                ?>
                <td>{{ $balanceamount  }}</td>
				    <!--<td>{{ $voucheretails->amount }}</td>!-->
            </tr>
            <tr>
            <td colspan="9"></td>            
            </tr>


          @endif


          @endforeach

          @endforeach



          
        
        </tbody>
        </table>

        <div class="w-100">
        {!! $allvoucherlist->links() !!}
      
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
  var url = "{{route('vendorvoucherreportfilter',['',''])}}" +"/"+fromdate+"/"+todate ;
	window.location.href=url;           
  
}

</script>

@include('layouts.footer')  