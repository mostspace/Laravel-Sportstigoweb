@include('layouts.head')
<body>
<div class="dash wrapper">

    @include('layouts.header')
  
    <div class="custom-border"></div>
  
    <div class="main-section pt-4 pb-4">
      <div class="container">
        <div class="row d-flex align-items-center justify-content-start mb-4">
          <!--<button type="submit" class="theme-btn mr-3">ADD NEW STAFF</button>!-->
          <a href="{{route('hostlist')}}"><button type="button" class="theme-btn">HOST LIST</button></a>
		  
		  
        </div>
        <form action="{{ route('hostadd')}}" method="post"  enctype="multipart/form-data">
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
                  <label for="userid" class="custom-label">Host Name</label>
                </div>
                <div class="col-lg-6">
                  <input type="text" class="custom-field w-100 form-control" name="host_game_name">
                </div>
				@if ($errors->has('host_game_name'))
				<span class="text-danger">{{ $errors->first('host_game_name') }}</span>
				@endif
              </div>
            </div>
			
            <div class="col-lg-12">
              <div class="form-group row">
                <div class="col-lg-4 text-right">
                  <label for="userid" class="custom-label">Title</label>
                </div>
                <div class="col-lg-6">
                  <input type="text" class="custom-field w-100 form-control" name="title">
                </div>
				@if ($errors->has('title'))
				<span class="text-danger">{{ $errors->first('title') }}</span>
				@endif
              </div>
            </div>
			<div class="col-lg-12">
              <div class="form-group row">
                <div class="col-lg-4 text-right">
                  <label for="userid" class="custom-label">Decsription</label>
                </div>
                <div class="col-lg-6">
                  <input type="text" class="custom-field w-100 form-control" name="description">
                </div>
				@if ($errors->has('description'))
				<span class="text-danger">{{ $errors->first('description') }}</span>
				@endif
              </div>
            </div>
           
			<div class="col-lg-12">
              <div class="form-group row">
                <div class="col-lg-4 text-right">
                  <label for="userid" class="custom-label">Venue</label>
                </div>
                <div class="col-lg-6">
                  <input type="text" class="custom-field w-100 form-control" name="venue">
                </div>
				@if ($errors->has('venue'))
				<span class="text-danger">{{ $errors->first('venue') }}</span>
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