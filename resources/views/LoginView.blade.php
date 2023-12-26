@include('layouts.head')
<body>
<head>
  <title>Login View</title>
</head>
<div class="dash wrapper">

  <div class="d-flex">
    <div class="left-login w-100 d-none d-md-block vh-100">
    </div>

    

    <div class="right-login w-100">
      <div class="container login-box">
        <div class="logo-box">
          <img src="<?php echo asset('assets\img\logo.png'); ?>">
        </div>
        <div class="main-title mt-5 mb-4">
          <h3>Login to your account</h3>
        </div>

        @if(Session::has('success'))
		<div class="alert alert-danger alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
			{{Session::get('success')}}
		</div>
		@endif
		
		
		
		
		
		 @php 
		 if(isset($_COOKIE['email']) && isset($_COOKIE['password']))
                   {
                      $email = $_COOKIE['email'];
                      $password  = $_COOKIE['password'];
                      $remember = "checked='checked'";
                   }
                   else{
                      $email ='';
                      $password = '';
                      $remember = "";
                    }
       @endphp
		
		
       
		

        {{-- <form action="{{ route('checkauth')}}" method="post"  enctype="multipart/form-data"> --}}
          <form action="{{ route('checkauth') }}" method="POST">
            @csrf 
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
          <div class="row">
            <div class="col-lg-12">
              <div class="form-group">
                <label class="custom-label" for="email">User ID</label>
                <input type="text" class="custom-field form-control w-100" value="{{$email}}" placeholder="Enter User ID" name="email">
                {{-- <input type="file" name="mydata"> --}}
                @if ($errors->has('email'))
                    <span class="text-danger">{{ $errors->first('email') }}</span>
                @endif
              </div>
            </div>
            <div class="col-lg-12">
              <div class="form-group">
                <label class="custom-label" for="password">Password</label>
                <input type="password" class="custom-field form-control w-100" value="{{$password}}" placeholder="Enter Password" name="password">
				@if ($errors->has('password'))
						<span class="text-danger">{{ $errors->first('password') }}</span>
					@endif
              </div>
            </div>
            <div class="col-lg-6">
              <div class="form-group">
                <div class="custom-radio">
                  <input type="checkbox" name="remember" id="remember" value="1" {{$remember}}>
                  <label class="custom-label d-flex align-items-center" for="remember"> Remember me</label>
					
				
				</div>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="form-group text-right">
              <a href="{{ route('forgotpassword')}}" class="login-link font-weight-bold">Change password?</a>
              </div>
            </div>
            <div class="col-lg-12">
              <button type="submit" class="theme-btn w-100">Login now</button>
            </div>
                      


          </div>
        </form>
      </div>
    </div>
  </div>
  
</div>


@include('layouts.footer')