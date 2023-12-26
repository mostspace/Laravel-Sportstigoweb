@include('layouts.head')
<body>
<?php $pageheading ='Voucher'; ?>
<div class="dash wrapper">

  @include('layouts.header')
  
    <div class="custom-border"></div>
  
    <div class="container">
  
       <form name ="form1" action="{{ route('saverequestvoucher') }}" method="post" enctype="multipart/form-data">
        @csrf 

		@if(Session::has('success'))
			<div class="alert alert-success text-center mt-3 mb-3">
				<span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
				 {{ Session::get('success') }}
			</div> 
		@endif
        
		<div class="row">
		    <div class="col-lg-12 d-flex justify-content-md-start justify-content-center mt-5">
              <button type="submit" class="green-small mr-2 mb-2">SAVE</button>
              <a href="{{ route('dashboard') }}"><button type="button" class="gray-small" > BACK</button></a>
            </div>
		</div>
		
		<div class="row mt-4">
          <div class="col-lg-4">
            <div class="form-group">
              <label for="voucher_type" class="custom-label mr-2">Type of Voucher :</label>
            </div>
          </div>
		  <?php 
			$role = Session::get('getsessionrole');
			if($role==3)
			{
			  ?>
		   <div class="col-lg-4">
            <div class="form-group">
              <input class="form-check-input custom-radio" type="radio" onchange="SelectVoucherType('loginvendor')" name="voucher_type" value="loginvendor" id="loginvendor" {{ (old('voucher_type') == 'loginvendor') ? 'checked' : 'checked'}}>
              <label for="voucher_type" class="custom-label mr-2">For Vendor</label>
            </div>
           </div>
		  <?php
		    }
	       ?>

     <?php 
			$role = Session::get('getsessionrole');
			if($role==6)
			{
			  ?>
		   <div class="col-lg-4">
            <div class="form-group">
              <input class="form-check-input custom-radio" type="radio" onchange="SelectVoucherType('loginvendor')" name="voucher_type" value="loginvendor" id="loginvendor" {{ (old('voucher_type') == 'loginvendor') ? 'checked' : 'checked'}}>
              <label for="voucher_type" class="custom-label mr-2">For Vendor</label>
            </div>
           </div>
		  <?php
		    }
	       ?>   
		   
		  <?php 
			$role = Session::get('getsessionrole');
			if($role==1)
			{
			  ?>
          <div class="col-lg-4">
            <div class="form-group">
              <input class="form-check-input custom-radio" type="radio" onchange="SelectVoucherType('allvendor')" name="voucher_type" value="allvendor" id="allvendor" {{ (old('voucher_type') == 'allvendor') ? 'checked' : ''}}>
              <label for="voucher_type" class="custom-label mr-2">For All Vendor</label>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="form-group">
              <input class="form-check-input custom-radio" type="radio" onchange="SelectVoucherType('selectedvendor')" name="voucher_type" value="selectedvendor" id="selectedvendor" {{ (old('voucher_type') == 'selectedvendor') ? 'checked' : ''}}>
              <label for="voucher_type" class="custom-label mr-2">For selected vendor</label>
            </div>
          </div>
		  
			  @if ($errors->has('voucher_type'))
				<span class="text-danger">&nbsp;&nbsp;  {{ $errors->first('voucher_type') }}</span>
		    @endif
			
			<?php
		    }
	       ?>
			  
        </div>

        <!-- All Vendor Section Start -->
        <div class="custom-border mb-2 444"></div>
        <div id="AllVoucherHeadSection" class="header-sub-title" style="margin-left:-100px;">
          <h3>Global Voucher (For All Vendor)</h3>
        </div>
		<div id="SelectedVoucherHeadSection" class="header-sub-title" style="margin-left:-100px;display:none">
            <h3>VOUCHER ( For selected vendor )</h3>
        </div>
        <div class="custom-border mt-2 444 AllVoucherSectioncls"></div>

        <div id="AllVoucherBodySection" class="voucher">
          
		 
		  <div class="row">
          <div class="col-lg-6">
            <div class="form-group">
              <label for="userid" class="custom-label mr-2">Voucher Date:</label>
              <input type="date" id="voucher_date" value="{{ old('voucher_date') }}" class="custom-field form-control d-inline ml-2" name="voucher_date">
			  @if ($errors->has('voucher_date'))
				<span class="text-danger">{{ $errors->first('voucher_date') }}</span>
		      @endif
            </div>
			
          </div>
		  
		  <div class="col-lg-6" id="SelectedVoucherVendorName" style="display:none">
            <div class="form-group">
              <label for="userid" class="custom-label mr-2">Vendor Name:</label>
               <select name="vendor_name[]"  class="form-control sportigo-select d-inline w-auto mr-2" aria-label="Default select example">
                
				        @forelse( $allvendorlist as $vendorlist )    
					      <option value="{{ $vendorlist->vendor_id }}"> {{ $vendorlist->businessname }} </option>
				        @empty 

				        @endforelse 
				</select>
				@if ($errors->has('vendor_name'))
				<span class="text-danger">{{ $errors->first('vendor_name') }}</span>
				@endif
				
              
            </div>
			
          </div>
		  
		  
        </div>
		
		
        <div class="row">
          <div class="col-lg-12">
            <div class="form-group">
              <label for="userid" class="custom-label mr-2">Generate Voucher Code:</label>
              <input type="text" class="custom-field form-control d-inline" id="voucher_code" value="{{$vouchercode}}" name="voucher_code" readOnly>
			  @if ($errors->has('voucher_code'))
				<span class="text-danger">{{ $errors->first('voucher_code') }}</span>
			  @endif
            </div>
          </div>
		  
        </div>
        <div class="row">
          <div class="col-lg-6">
            <div class="form-group">
              <label for="userid" class="custom-label mr-2">Used By:</label>
              <span class="sub">From</span> <input type="date" id="voucher_from_date" value="{{ old('voucher_from_date') }}" class="custom-field form-control d-inline ml-2" name="voucher_from_date">
              <span class="sub">To</span> <input type="date" value="{{ old('voucher_to_date') }}" id="voucher_to_date" class="custom-field form-control d-inline ml-2" name="voucher_to_date">
			  
			  @if ($errors->has('voucher_from_date'))
				<span class="text-danger">{{ $errors->first('voucher_from_date') }}</span>
			  @endif
			  
			  @if ($errors->has('voucher_to_date'))
				<span class="text-danger">{{ $errors->first('voucher_to_date') }}</span>
			  @endif
            </div>
          </div>
        </div>
        <div class="row d-flex align-items-center justify-content-center">
          <div class="col-lg-4">
            
            <div class="custom-radio col-md-6 mb-2">
              <input type="checkbox" value= "1" id="voucher_is_expired_date" name="voucher_is_expired_date" {{ (old('voucher_is_expired_date')=='1') ? ' checked' : '' }}>
              <label class="custom-label2 d-flex align-items-center" for="voucher_is_expired_date"> No Expired Date</label>
            </div>
			
			
          </div>
		  
		 <div class="col-lg-4">
            <div class="form-group">
              <label for="userid" class="custom-label mr-2">Amount:</label>
              <input type="text" class="custom-field form-control d-inline" value="{{ old('amount') }}" id="amount" name="amount" onkeyup="change_amount()">
			 
            </div>
            @if ($errors->has('amount'))
				<span class="text-danger">{{ $errors->first('amount') }}</span>
			  @endif
          </div>
          <div class="col-lg-4">
            <div class="form-group">
              <label for="userid" class="custom-label mr-2">Total Usage :</label>
              <input type="text" class="custom-field form-control d-inline" value="{{ old('voucher_total_usage') }}" id="voucher_total_usage" name="voucher_total_usage">
			 
            </div>
          </div>
          <div class="col-lg-4">
            <div class="form-group">
              <label for="userid" class="custom-label mr-2">% Discount :</label>
              <input type="text" class="custom-field form-control d-inline" id = "voucher_discount" value="{{ old('voucher_discount') }}" name="voucher_discount" onkeyup="change_voucher_discount()">
			  @if ($errors->has('voucher_discount'))
				<span class="text-danger">{{ $errors->first('voucher_discount') }}</span>
			  @endif
            </div>
			  
          </div>
        </div> 
		  
		  
        </div>
		

		
        <div class="custom-border mb-2 333 AllVoucherSectioncls"></div>
        <!-- All Vendor Section End -->
		

        <!-- Selected Vendor Section Start -->
        
        <div class="custom-border mt-2 222 SelectedVoucherSectioncls" style="display:none"></div>
		<div class="custom-border mb-2 111 SelectedVoucherSectioncls" style="display:none"></div>
        <!-- Selected Vendor Section End -->
  
        <div class="row mb-5">
        <div class="col-lg-12">
          <label for="userid" class="custom-label mr-2">Latest Voucher Records :</label>
          <table class="rs-table table-striped voucher-table w-100">
            <thead>
              <tr>
			          <th>Action</th>
                <th>Voucher Date</th>
                <th>Code</th>
                <th>Date</th>
                <th>Vendor</th>
                <th>Total Usage</th>
                <th>Total Amount</th>
                <th>Discount(%)</th>
                <th>Balanced</th>
				      </tr>
            </thead>
            <tbody>
           
			 @forelse( $allvoucherlist as $voucheretails )
			
			  @foreach( explode(",",str_replace( array( '"', '[',']' ), '', $voucheretails->vendor_code))  As $key )
			  
			   @foreach( $allvendorlist as $vendorlist )
			  
				@if( $key == $vendorlist->vendor_id )
				<tr>
			
			<td>
				<div class="action-btns">
		   
					<a href="javascript:void(0)" id="del{{$voucheretails->id}}" onclick="deleteuserfun({{$voucheretails->id}})" data-userid="{{$voucheretails->id}}}" class="delete-btn">
					<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
					  <path d="M3 6H5H21" stroke="#98A9BC" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
					  <path d="M8 6V4C8 3.46957 8.21071 2.96086 8.58579 2.58579C8.96086 2.21071 9.46957 2 10 2H14C14.5304 2 15.0391 2.21071 15.4142 2.58579C15.7893 2.96086 16 3.46957 16 4V6M19 6V20C19 20.5304 18.7893 21.0391 18.4142 21.4142C18.0391 21.7893 17.5304 22 17 22H7C6.46957 22 5.96086 21.7893 5.58579 21.4142C5.21071 21.0391 5 20.5304 5 20V6H19Z" stroke="#98A9BC" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
					  </svg>
					</a>
				
					</div>
					</td>
			
			
			
			
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
                
                </tr>

				@endif
				
				
			   @endforeach	
			   
			   @if( $key == '' )
				<tr>
			    
				<td>
				<div class="action-btns">
		   
					<a href="javascript:void(0)" id="del{{$voucheretails->id}}" onclick="deleteuserfun({{$voucheretails->id}})" data-userid="{{$voucheretails->id}}}" class="delete-btn">
					<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
					  <path d="M3 6H5H21" stroke="#98A9BC" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
					  <path d="M8 6V4C8 3.46957 8.21071 2.96086 8.58579 2.58579C8.96086 2.21071 9.46957 2 10 2H14C14.5304 2 15.0391 2.21071 15.4142 2.58579C15.7893 2.96086 16 3.46957 16 4V6M19 6V20C19 20.5304 18.7893 21.0391 18.4142 21.4142C18.0391 21.7893 17.5304 22 17 22H7C6.46957 22 5.96086 21.7893 5.58579 21.4142C5.21071 21.0391 5 20.5304 5 20V6H19Z" stroke="#98A9BC" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
					  </svg>
					</a>
				
					</div>
					</td>
				
				
                <td>{{ \Carbon\Carbon::parse($voucheretails->voucher_date)->format('d-m-Y')}} </td> 
				        <td>{{ $voucheretails->voucher_code }}</td>
                <td>{{ \Carbon\Carbon::parse($voucheretails->voucher_from_date)->format('d-m-Y')}} - {{ \Carbon\Carbon::parse($voucheretails->voucher_to_date)->format('d-m-Y')}}</td>
				        <td></td>
				        <td>{{ $voucheretails->voucher_total_usage }}</td>
                <td>{{ $voucheretails->amount }}</td>
                <td>{{ $voucheretails->voucher_discount }}</td>
			          <?php
                  $calculatediscountamount = $voucheretails->amount * $voucheretails->voucher_discount/100;
                  $balanceamount = $voucheretails->amount - $calculatediscountamount;
                ?>
                <td>{{ $balanceamount  }}</td>
				        
				 </tr>				 
			   @endif
			 	  
			   
			  
			  @endforeach
			  
			 
			 @empty
             <tr>
					<td class="text-center h3 p-3" colspan="9"> No Records Found </td>
			</tr>	
             @endforelse
			
          </tbody>
          </table>        
        </div>
        
      </div>

      </form>  
    </div>
  </div>

<head>
    <script src="<?php echo asset('assets\js\jquery.js'); ?>"></script>
</head>	
<script>

$(document).ready(function(){
	$("#selectedvendor").change(function(){
	  if($("#selectedvendor").is(":checked")) {
		  $("#SelectedVoucherVendorName").css('display','block') ;
		}
	});
	if($("#selectedvendor").is(":checked")) {
	  $("#SelectedVoucherVendorName").css('display','block') ;
	}
});

  
  function SelectVoucherType(Typevalue){
    console.log("Typevalue")
    console.log(Typevalue)
    if(Typevalue == 'allvendor'){
	  
      $("#AllVoucherHeadSection").css('display','block')
      $("#AllVoucherBodySection").css('display','block')
      $(".AllVoucherSectioncls").css('display','block')      
      $("#SelectedVoucherHeadSection").css('display','none')
      $("#SelectedVoucherBodySection").css('display','none')      
      $(".SelectedVoucherSectioncls").css('display','none')
	  $("#SelectedVoucherVendorName").css('display','none')
	        
    }else if(Typevalue == 'selectedvendor'){
	  
      $("#AllVoucherHeadSection").css('display','none')
      $("#AllVoucherBodySection").css('display','block')
      $(".AllVoucherSectioncls").css('display','block')      
      $("#SelectedVoucherHeadSection").css('display','block')
      $("#SelectedVoucherBodySection").css('display','none')      
      $(".SelectedVoucherSectioncls").css('display','none')
	  $("#SelectedVoucherVendorName").css('display','block') 

    }
  }
  
  
  
</script>



<script>
  function deleteuserfun(btn){
    var user_btn_id = $(btn).attr("data-userid");
    $("#deletebtn_"+user_btn_id).click();
  }
  
function deleteuserfun(btn){
	
	var user_btn_id = btn;
    $("#deletebtn_"+user_btn_id).click();
	
	var txt;
	  if (confirm("Are you sure want to remove!")) 
	  {
		var url = "{{ route('voucherdelete', '') }}"+"/"+btn ;
		
		window.location.href=url
	  } 
	  else 
	  {
		
	  }
	
	
  } 
  


  function change_voucher_discount() 
  {
    //document.getElementById("amount").disabled = true;
    document.getElementById("amount").value = 0;
  }

  function change_amount() 
  {
    //document.getElementById("voucher_discount").disabled = true;
    document.getElementById("voucher_discount").value = 0;  
  }

</script>




@include('layouts.footer')