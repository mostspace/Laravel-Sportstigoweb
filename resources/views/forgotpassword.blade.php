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
          <h3>Change Password</h3>
        </div>

                           @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @elseif (session('error'))
                                <div class="alert alert-danger" role="alert">
                                    {{ session('error') }}
                                </div>
                            @endif

       
          <form action="{{ route('change_password') }}" method="POST">
            @csrf 
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
          <div class="row">
            <div class="col-lg-12">
              <div class="form-group">
                <label class="custom-label" for="email">User ID</label>
                <input type="text" class="custom-field form-control w-100" value="{{ old('email') }}" placeholder="Enter User ID" name="email">
                {{-- <input type="file" name="mydata"> --}}
                @if ($errors->has('email'))
                    <span class="text-danger">{{ $errors->first('email') }}</span>
                @endif
              </div>
            </div>
            <div class="col-lg-12">
              <div class="form-group">
                <label class="custom-label" for="old_password">Old Password</label>
                <input type="password" class="custom-field form-control w-100" value="{{ old('old_password') }}" placeholder="Enter Old Password" name="old_password">
                @if ($errors->has('old_password'))
                    <span class="text-danger">{{ $errors->first('old_password') }}</span>
                  @endif
              </div>
            </div>

            <div class="col-lg-12">
              <div class="form-group">
                <label class="custom-label" for="nw_password">New Password</label>
                <input type="password" class="custom-field form-control w-100" value="{{ old('nw_password') }}" placeholder="Enter New Password" name="nw_password">
                @if ($errors->has('nw_password'))
                    <span class="text-danger">{{ $errors->first('nw_password') }}</span>
                  @endif
              </div>
            </div>
            
            <div class="col-lg-12">
              <div class="form-group">
                <label class="custom-label" for="cm_password">Confirm New Password</label>
                <input type="password" class="custom-field form-control w-100" value="{{ old('cm_password') }}" placeholder="Enter Confirm New Password" name="cm_password">
                @if ($errors->has('cm_password'))
                    <span class="text-danger">{{ $errors->first('cm_password') }}</span>
                  @endif
              </div>
            </div>

           
            <div class="col-lg-12">
              <button type="submit" class="green-small mr-2 mt-5">SAVE</button>
              <a href="{{ route('dashboard') }}"><button type="button" class="gray-small mt-5" > BACK</button></a>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

</div>

@include('layouts.footer')