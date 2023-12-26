@include('layouts.head')
<body>
<div class="dash wrapper">

    @include('layouts.header')
  
    <div class="custom-border"></div>
	@forelse( $userlist as $usrlist) 
	<form action="{{ route('staffupdate',$usrlist->id) }}" method="post"  enctype="multipart/form-data">
          @csrf 
		  
    <div class="main-section pt-4 pb-4">
      <div class="container">
        <div class="row d-flex align-items-center justify-content-md-start justify-content-center mb-4">
          <!--<button type="submit" class="theme-btn mr-3">ADD NEW STAFF</button>!-->
         
		  <button type="submit" class="green-small mr-2 mb-2">SAVE</button>
          <a href="{{ route('dashboard') }}"><button type="button" class="gray-small mr-2 mb-2" > BACK</button></a>
		  <a href="{{route('stafflist')}}"><button type="button" class="theme-btn mr-2">STAFF LIST</button></a>
		  
        </div>
		
        
		  @if(Session::has('success'))
			<div class="alert alert-success text-center mt-3 mb-3">
				<span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
				 {{ Session::get('success') }}
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
				  <input type="hidden" class="custom-field w-100 form-control" name="userid" value="{{ $usrlist->id }}" >
                  <input type="text" class="custom-field w-100 form-control" name="staffname" value="{{ $usrlist->name }}" >
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
                  <input type="text" class="custom-field w-100 form-control" name="username" value="{{ $usrlist->email }}">
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
                  <input type="password" class="custom-field w-100 form-control" value="{{ $usrlist->original_password }}" name="stafpassword">
				  
                </div>
				@if ($errors->has('stafpassword'))
				<span class="text-danger">{{ $errors->first('stafpassword') }}</span>
				@endif
              </div>
            </div>
          <!--  <div class="col-lg-4"></div>-->
          <!--   <div class="col-lg-6 text-right">-->
          <!--    <button type="submit" class="green-small mr-2 mt-5">SAVE</button>-->
          <!--<a href="{{ route('dashboard') }}"><button type="button" class="gray-small mt-5" > BACK</button></a>-->
          <!--  </div>-->
          </div>
		@empty 
		@endforelse 
        
        <div class="main-title mt-5 mb-4">
          <h3>Staff Access Level Menu Permission</h3>
        </div>
        
		<div class="row align-items-center mb-3">
		
		
		
		
		
		@forelse( $moduledtlsdd as $moduledtvalue) 
		
		
		
		<div class="col-md-4 form-check custom-check text-right">
					<input class="form-check-input" type="checkbox" onclick="is_checked(this,{{$moduledtvalue['id']}})" value="{{$moduledtvalue['moduleroute']}}" <?php 
				
		if (in_array(trim($moduledtvalue['modulename']), $customer_right_array))			
			{
				echo "checked";
				
			}
			
				
		  ?> name = "PERMISSION[]" id="{{$moduledtvalue['moduleroute']}}">
					<label  for="{{$moduledtvalue['moduleroute']}}">
					<input type="hidden" name="PERMISSIONDESC[]" value="{{$moduledtvalue['moduledesc']}}">
					<input type="hidden" name="PERMISSIONMODULENAME[]" value="{{$moduledtvalue['modulename']}}">
					<input type="hidden" name="PERMISSIONROUTE[]" value="{{$moduledtvalue['moduleroute']}}">
					<input type="hidden" id="is_checked_{{$moduledtvalue['id']}}" name="is_checked[]" value="<?php 
				
		if (in_array(trim($moduledtvalue['modulename']), $customer_right_array))			
			{
				echo "1";
				
			}else{
				echo "0";
				
			}
			
				
		  ?>">
					<?php 
						echo $moduledtvalue['modulename'];
					?>
					</label>
					
					</div>
		
		  
		
		   
		
		@empty 
		@endforelse 
		
		  
		</div>
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