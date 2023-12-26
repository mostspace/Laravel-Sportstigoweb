@include('layouts.head')
<body>
<div class="dash wrapper">

    @include('layouts.header')
  
    <div class="custom-border"></div>
  
    <div class="main-section pt-4 pb-4">
      <div class="container">
        <div class="row d-flex align-items-center justify-content-start mb-4">
          <!--<button type="submit" class="theme-btn mr-3">ADD NEW STAFF</button>!-->
          <a href="{{route('instructorslist')}}"><button type="button" class="theme-btn">INSTRUCTOR LIST</button></a>
		  
		  
        </div>
        <form action="{{ route('instructorsadd')}}" method="post"  enctype="multipart/form-data">
          @csrf 
		  
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
                  <label for="userid" class="custom-label">Username/Email</label>
                </div>
                <div class="col-lg-6">
                  <input type="text" class="custom-field w-100 form-control" name="user_name">
                </div>
				@if ($errors->has('user_name'))
				<span class="text-danger">{{ $errors->first('user_name') }}</span>
				@endif
              </div>
            </div>
			<div class="col-lg-12">
              <div class="form-group row">
                <div class="col-lg-4 text-right">
                  <label for="userid" class="custom-label">Mobile Number</label>
                </div>
                <div class="col-lg-6">
                  <input type="text" class="custom-field w-100 form-control" name="mobile">
                </div>
				@if ($errors->has('mobile'))
				<span class="text-danger">{{ $errors->first('mobile') }}</span>
				@endif
              </div>
            </div>
            <div class="col-lg-12">
              <div class="form-group row">
                <div class="col-lg-4 text-right">
                  <label for="userid" class="custom-label">Password</label>
                </div>
                <div class="col-lg-6">
                  <input type="password" class="custom-field w-100 form-control" value="{{ old('password') }}" name="password">
				  
                </div>
				@if ($errors->has('password'))
				<span class="text-danger">{{ $errors->first('password') }}</span>
				@endif
              </div>
            </div>
            <div class="col-lg-4"></div>
            <div class="col-lg-6 text-right">
              <button type="submit" class="theme-btn">SAVE</button>
            </div>
          </div>
       
		
		 </form>
      </div>
    </div>
  
  </div>
  
  
@include('layouts.footer')  