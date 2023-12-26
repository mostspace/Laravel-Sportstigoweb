@include('layouts.head')
<body>
<div class="dash wrapper">

    @include('layouts.header')
  
    <div class="custom-border"></div>
    @forelse( $userdetails as $usrlist) 
    <form action="{{ route('salesagentupdate',$usrlist->id)}}" method="post"  enctype="multipart/form-data">
          @csrf 
    <div class="main-section pt-4 pb-4">
      <div class="container">
        <div class="row d-flex align-items-center justify-content-md-start justify-content-center mb-4">
          <!--<button type="submit" class="theme-btn mr-3">ADD NEW STAFF</button>!-->
          
		  
          <button type="submit" class="green-small mr-2">SAVE</button>
		  <a href="{{ route('dashboard') }}"><button type="button" class="gray-small mr-2" > BACK</button></a>
      <a href="{{route('salesagentlist')}}"><button type="button" class="theme-btn mr-2">SALES AGENT LIST</button></a>     
		  
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
                  <label for="userid" class="custom-label">Name</label>
                </div>
                <div class="col-lg-6">
				<input type="hidden" class="custom-field w-100 form-control" name="id" value="{{ $usrlist->id}}">
                  <input type="text" class="custom-field w-100 form-control" name="name" value="{{ $usrlist->name }}">
                </div>
				@if ($errors->has('name'))
				<span class="text-danger">{{ $errors->first('name') }}</span>
				@endif
              </div>
            </div>
			
			
			<div class="col-lg-12">
              <div class="form-group row">
                <div class="col-lg-4 text-right">
                  <label for="mobile" class="custom-label">Mobile No</label>
                </div>
                <div class="col-lg-6">
				<input type="hidden" class="custom-field w-100 form-control" name="id" value="{{ $usrlist->id}}">
                  <input type="text" class="custom-field w-100 form-control" name="mobile" value="{{ $usrlist->mobile }}">
                </div>
				@if ($errors->has('mobile'))
				<span class="text-danger">{{ $errors->first('mobile') }}</span>
				@endif
              </div>
            </div>
			
			<div class="col-lg-12">
              <div class="form-group row">
                <div class="col-lg-4 text-right">
                  <label for="userid" class="custom-label">Username/Email</label>
                </div>
                <div class="col-lg-6">
				
                  <input type="text" class="custom-field w-100 form-control" name="email" value="{{ $usrlist->email }}">
                </div>
				@if ($errors->has('email'))
				<span class="text-danger">{{ $errors->first('email') }}</span>
				@endif
              </div>
            </div>
			
            <div class="col-lg-12">
              <div class="form-group row">
                <div class="col-lg-4 text-right">
                  <label for="userid" class="custom-label">Password</label>
                </div>
                <div class="col-lg-6">
                  <input type="password" name = "password" class="custom-field w-100 form-control" value="{{ $usrlist->original_password }}">
				  
                </div>
                        @if ($errors->has('password'))
                        <span class="text-danger">{{ $errors->first('password') }}</span>
                        @endif
              </div>
            </div>




            <div class="col-lg-12">
              <div class="form-group row">
                <div class="col-lg-4 text-right">
                  <label for="bankname" class="custom-label">Bank Name</label>
                </div>
                <div class="col-lg-6">
                  <input type="text" name = "bankname" class="custom-field w-100 form-control" value="{{ $usrlist->bankname }}">
				  
                </div>
                      @if ($errors->has('bankname'))
                      <span class="text-danger">{{ $errors->first('bankname') }}</span>
                      @endif
              </div>
            </div>

            <div class="col-lg-12">
              <div class="form-group row">
                <div class="col-lg-4 text-right">
                  <label for="bankacno" class="custom-label">Account No</label>
                </div>
                <div class="col-lg-6">
                  <input type="text" name = "bankacno" class="custom-field w-100 form-control" value="{{ $usrlist->bankacno }}" >
				  
                </div>
                  @if ($errors->has('bankacno'))
                  <span class="text-danger">{{ $errors->first('bankacno') }}</span>
                  @endif
              </div>
            </div>
			
			<div class="col-lg-12">
              <div class="form-group row">
                <div class="col-lg-4 text-right">
                  <label for="bankaccountname" class="custom-label">Account Holder Name</label>
                </div>
                <div class="col-lg-6">
                  <input type="text" name = "bankaccountname" class="custom-field w-100 form-control" value="{{ $usrlist->bankaccountname }}" >
				  
                </div>
                @if ($errors->has('bankaccountname'))
                <span class="text-danger">{{ $errors->first('bankaccountname') }}</span>
                @endif
              </div>
            </div>










            
          </div>
       
		
		 </form>
		@empty 
		@endforelse 
      </div>
    </div>
  
  </div>
  
  
@include('layouts.footer')  