@include('layouts.head')
<body>
<div class="dash wrapper">

  @include('layouts.header')
  
    <div class="custom-border"></div>
    
	  <div class="container mt-5 mb-5">
    <form name ="form1" action="{{ route('saverequestnotice') }}" method="post" enctype="multipart/form-data">
        @csrf 

		@if(Session::has('success'))
			<div class="alert alert-success text-center mt-3 mb-3">
				<span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
				 {{ Session::get('success') }}
			</div> 
		@endif
		<marquee behavior="scroll" direction="left">To reach our support team, you can send a direct message using the form below. Our Support team will be happy to assist you with any questions or issues you may have..</marquee>
		<div class="row">
            <div class="col-lg-12 d-flex flex-wrap justify-content-md-start justify-content-center mb-4">
              <button type="submit" class="green-small mr-2 mb-2 inline-flex">SEND</button>
			  
			  
			  
			  <a href="{{ route('dashboard') }}"><button type="button" class="gray-small inline-flex mr-2 mb-2" > BACK</button></a>
        <a href="{{route('noticlist')}}"><button type="button" class="green-small">Inbox</button></a>
            </div>
      </div>
      
      <div class="row">
        <div class="col-md-5">
            <div class="row align-items-center">
                <div class="col-md-4 p-0 text-right">
                    <label for="packagename" class="custom-label mr-2">Title:</label>
                </div>
                <div class="col-md-8 p-0">
                    <input type="text" class="custom-field form-control" value="{{ old('title') }}" name="title">
					@if ($errors->has('title'))
					<span class="text-danger">&nbsp;&nbsp;  {{ $errors->first('title') }}</span>
					@endif
                </div>
				
            </div>
        </div>
        <div class="col-md-7">
          <div class="row d-flex align-items-center justify-content-center mb-2">
            <!--<div class="col-md-4">
              <div class="custom-radio">
                <input type="checkbox" name="toallvendors" id="toallvendors">
                <label class="custom-label2 d-flex align-items-center" for="toallvendors"> To All Vendors :</label>                                
              </div> 
            </div>
            <div class="col-md-4">
                <div class="custom-radio">
                  <input type="checkbox" name="toselectedvendors" id="toselectedvendors">  
                  <label class="custom-label2 d-flex align-items-center" for="toselectedvendors"> To Selected Vendor :</label>                                
                </div>
            </div>!-->
      <?php 
			$role = Session::get('getsessionrole');
			if($role==7)
			{
			  ?>
			  <div class="col-lg-4">
              <div class="form-group">
              <input class="form-check-input custom-radio" type="radio" onchange="SelectVoucherType('admin')" name="voucher_type" value="admin" id="admin" {{ (old('voucher_type') == 'admin') ? 'checked' : 'checked'}}>
              <label for="voucher_type" class="custom-label mr-2">To Admin:</label>
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
              <input class="form-check-input custom-radio" type="radio" onchange="SelectVoucherType('admin')" name="voucher_type" value="admin" id="admin" {{ (old('voucher_type') == 'admin') ? 'checked' : 'checked'}}>
              <label for="voucher_type" class="custom-label mr-2">To Admin:</label>
            </div>
            </div>
			  <?php
		    }
	       ?>
			<?php 
			$role = Session::get('getsessionrole');
			if($role==3)
			{
			  ?>
			  <div class="col-lg-4">
              <div class="form-group">
              <input class="form-check-input custom-radio" type="radio" onchange="SelectVoucherType('admin')" name="voucher_type" value="admin" id="admin" {{ (old('voucher_type') == 'admin') ? 'checked' : 'checked'}}>
              <label for="voucher_type" class="custom-label mr-2">To : Sportstigo admin</label>
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
              <label for="voucher_type" class="custom-label mr-2">To All Vendors:</label>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="form-group">
              <input class="form-check-input custom-radio" type="radio" onchange="SelectVoucherType('selectedvendor')" name="voucher_type" value="selectedvendor" id="selectedvendor" {{ (old('voucher_type') == 'selectedvendor') ? 'checked' : ''}}>
              <label for="voucher_type" class="custom-label mr-2">To Selected Vendor:</label>
            </div>
          </div>
		   @if ($errors->has('voucher_type'))
				<span class="text-danger">&nbsp;&nbsp;  {{ $errors->first('voucher_type') }}</span>
		    @endif
			
			<?php
		    }
	       ?>
			
			
            <div class="col-lg-4" id="SelectedVoucherVendorName" style="display:none">
            
               <select name="vendor_name[]" multiple data-live-search="true" 
			   
			   class="form-control sportigo-select w-auto mr-2" aria-label="Default select example">
                
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
      </div>
     
      <div class="row mt-2">
        <div class="col-md-5">
            <div class="row align-items-center">
                <div class="col-md-4 p-0 text-right">
                    <label for="packagename" class="custom-label mr-2">Message:</label>
                </div>
                <div class="col-md-8 p-0">
                    <textarea id="subject"  rows="8" cols="50" name="subject" class="form-control custom-area" placeholder="Write something.."  >{{ old('subject') }}</textarea>
					@if ($errors->has('subject'))
				<span class="text-danger">&nbsp;&nbsp;  {{ $errors->first('subject') }}</span>
				@endif
                </div>
				
            </div>
         
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
	  
     
	  $("#SelectedVoucherVendorName").css('display','none')
	        
    }else if(Typevalue == 'selectedvendor'){
	  
      $("#SelectedVoucherVendorName").css('display','block') 

    }
  }
  
  
  
</script>

@include('layouts.footer')