@include('layouts.head')
<body>
<div class="dash wrapper">

    @include('layouts.header')
  
    <div class="custom-border"></div>
    <form action="{{ route('staffadd')}}" method="post"  enctype="multipart/form-data">
          @csrf 
    <div class="main-section pt-4 pb-4">
      <div class="container">
        <div class="row d-flex align-items-center justify-content-md-start justify-content-center mb-4">
          <!--<button type="submit" class="theme-btn mr-3">ADD NEW STAFF</button>!-->
          
		     <button type="submit" class="green-small mr-2 mb-2">SAVE</button>
          <a href="{{ route('dashboard') }}"><button type="button" class="gray-small mr-2 mb-2" > BACK</button></a>
          <a href="{{route('stafflist')}}"><button type="button" class="theme-btn ">STAFF LIST</button></a>
        </div>
       
		  
		  @if(Session::has('success'))
			<div class="alert alert-success text-center mt-3 mb-3">
				<span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
				 {{ Session::get('success') }}
			</div> 
		 @endif
		 
		@if(Session::has('success1'))
			<div class="alert alert-danger text-center mt-3 mb-3">
				<span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
				 {{ Session::get('success1') }}
			</div> 
		 @endif
          <!--<input type="hidden" name="_token" value="{{ csrf_token() }}" />!-->
          <div class="row">
            <div class="col-lg-12">
              <div class="form-group row">
                <div class="col-lg-4 text-right">
                  <label for="userid" class="custom-label">Staff Name</label>
                </div>
                <div class="col-lg-6">
                  <input type="text" class="custom-field w-100 form-control" name="staffname">
                </div>
				@if ($errors->has('staffname'))
				<span class="text-danger">{{ $errors->first('staffname') }}</span>
				@endif
              </div>
            </div>
            <div class="col-lg-12">
              <div class="form-group row">
                <div class="col-lg-4 text-right">
                  <label for="userid" class="custom-label">Username/Email</label>
                </div>
                <div class="col-lg-6">
                  <input type="text" class="custom-field w-100 form-control" name="username">
                </div>
				@if ($errors->has('username'))
				<span class="text-danger">{{ $errors->first('username') }}</span>
				@endif
              </div>
            </div>
            <div class="col-lg-12">
              <div class="form-group row">
                <div class="col-lg-4 text-right">
                  <label for="userid" class="custom-label">Password</label>
                </div>
                <div class="col-lg-6">
                  <input type="password" class="custom-field w-100 form-control" value="{{ old('stafpassword') }}" name="stafpassword">
				  
                </div>
				@if ($errors->has('stafpassword'))
				<span class="text-danger">{{ $errors->first('stafpassword') }}</span>
				@endif
              </div>
            </div>
          <!--  <div class="col-lg-4"></div>-->
          <!--  <div class="col-lg-6 text-right">-->
          <!--    <button type="submit" class="green-small mr-2 mt-5">SAVE</button>-->
          <!--<a href="{{ route('dashboard') }}"><button type="button" class="gray-small mt-5" > BACK</button></a>-->
          <!--  </div>-->
          </div>
        
        <div class="main-title mt-5 mb-4">
          <h3>Staff Access Level Menu Permission</h3>
        </div>
        
		<div class="row align-items-center mb-3">
		
		@forelse( $moduledtlsdd as $moduledtvalue)    
					<div class="col-md-4 form-check custom-check text-right">
					<input class="form-check-input" type="checkbox" onclick="is_checked(this,{{$moduledtvalue['id']}})" value="{{$moduledtvalue['moduleroute']}}" name = "PERMISSION[]" id="{{$moduledtvalue['moduleroute']}}" {{ (old('status')=='1') ? ' checked' : '' }}>
					<label for="{{$moduledtvalue['moduleroute']}}">
					<input type="hidden" name="PERMISSIONDESC[]" value="{{$moduledtvalue['moduledesc']}}">
					<input type="hidden" name="PERMISSIONMODULENAME[]" value="{{$moduledtvalue['modulename']}}">
					<input type="hidden" name="PERMISSIONROUTE[]" value="{{$moduledtvalue['moduleroute']}}">
					<input type="hidden" id="is_checked_{{$moduledtvalue['id']}}" name="is_checked[]" value="0">
					<?php 
						echo $moduledtvalue['modulename'];
					?>
					</label>
					
					</div>
		  @empty 

		  @endforelse 
		  
		</div>

	   
		
		 <!--<div class="col-md-3 form-check custom-check text-right">
            
			<input class="form-check-input" type="checkbox" value= "SALES REPORT" id="salesreport" name="PERMISSION[]" {{ (old('salesreport')=='1') ? ' checked' : '' }}>
			
			<label class="custom-label2" for="salesreport">
              SALES REPORT
            </label>
          </div> 
		  
          <div class="col-md-3 form-check custom-check text-right">
            <input class="form-check-input" type="checkbox" value="STAFF" id="staff" name="PERMISSION[]" {{ (old('staff')=='1') ? ' checked' : '' }}>
            <label class="custom-label2" for="staff">
              STAFF
            </label>
          </div>!-->
         
        
  
        <!--<div class="d-flex align-items-center mb-3">
          <div class="col-md-3 form-check custom-check text-right">
            <input class="form-check-input" type="checkbox" value="1" id="userlist" name="userlist" {{ (old('userlist')=='1') ? ' checked' : '' }}>
            <label class="custom-label2" for="userlist">
              USER LIST
            </label>
          </div>
          <div class="col-md-3 form-check custom-check text-right">
            <input class="form-check-input" type="checkbox" value="1" id="freelancer" name="freelancer" {{ (old('freelancer')=='1') ? ' checked' : '' }}>
            <label class="custom-label2" for="freelancer">
              FREELANCERS
            </label>
          </div>
          <div class="col-md-3 form-check custom-check text-right">
            <input class="form-check-input" type="checkbox" value="1" id="buddy" name="buddy" {{ (old('buddy')=='1') ? ' checked' : '' }}>
            <label class="custom-label2" for="buddy">
              BUDDY
            </label>
          </div>
        </div>!-->
  
        <!--<div class="d-flex align-items-center mb-3">
          <div class="col-md-3 form-check custom-check text-right">
            <input class="form-check-input" type="checkbox" value="1" id="voucher" name="voucher" {{ (old('voucher')=='1') ? ' checked' : '' }}>
            <label class="custom-label2" for="voucher">
              VOUCHER
            </label>
          </div>
          <div class="col-md-3 form-check custom-check text-right">
            <input class="form-check-input" type="checkbox" value="1" id="host" name="host" {{ (old('host')=='1') ? ' checked' : '' }}>
            <label class="custom-label2" for="host">
              HOST
            </label>
          </div>
           <div class="col-md-3 form-check custom-check text-right">
            <input class="form-check-input" type="checkbox" value="1" id="noticeboard" name="noticeboard" {{ (old('noticeboard')=='1') ? ' checked' : '' }}>
            <label class="custom-label2" for="noticeboard">
              NOTICE BOARD
            </label>
          </div>
        </div>!-->
  
        <!--<div class="d-flex align-items-center">
          <div class="col-md-3 form-check custom-check text-right">
            <input class="form-check-input" type="checkbox" value="1" id="categories" name="categories" {{ (old('categories')=='1') ? ' checked' : '' }}>
            <label class="custom-label2" for="categories">
              CATEGORIES
            </label>
          </div>
          <div class="col-md-3 form-check custom-check text-right">
            <input class="form-check-input" type="checkbox" value="1" id="withdrawal" name="withdrawal" {{ (old('withdrawal')=='1') ? ' checked' : '' }}>
            <label class="custom-label2" for="withdrawal">
              WITHDRAWAL
            </label>
          </div>
          <div class="col-md-3 form-check custom-check text-right">
            <input class="form-check-input" type="checkbox" value="1" id="vendorlist" name="vendorlist" {{ (old('vendorlist')=='1') ? ' checked' : '' }}>
            <label class="custom-label2" for="vendorlist">
              VENDOR LIST
            </label>
          </div>  
        </div>!-->
		
		 </form>
      </div>
    </div>
  
  </div>
  
  <script>
	function is_checked(service,idval){
		var ischecked = $(service).is(':checked');
		console.log("ischecked");
		console.log(ischecked);
		if(ischecked == true){
			$("#is_checked_"+idval).val(1);
		}else{
			$("#is_checked_"+idval).val(0);
		}
			
	}
		
  </script>
@include('layouts.footer')  