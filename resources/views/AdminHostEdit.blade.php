@include('layouts.head')
<body>
<div class="dash wrapper">

    @include('layouts.header')
  
    <div class="custom-border"></div>
    @forelse( $userdetails as $usrlist) 
        <form action="{{ route('hostupdate',$usrlist->host_id)}}" method="post"  enctype="multipart/form-data">
          @csrf

    <div class="main-section pt-4 pb-4">
      <div class="container">
        <div class="row d-flex align-items-center justify-content-start mb-4">
          <!--<button type="submit" class="theme-btn mr-3">ADD NEW STAFF</button>!-->
          <button type="submit" class="green-small mr-2">SAVE</button>
          <a href="{{ route('dashboard') }}"><button type="button" class="gray-small mr-2" > BACK</button></a>
          
          <a href="{{route('hostlist')}}"><button type="button" class="theme-btn mr-2">HOST LIST</button></a>
		  
		  
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
                  <label for="userid" class="custom-label">Host Name</label>
                </div>
                <div class="col-lg-6">
				<input type="hidden" class="custom-field w-100 form-control" name="id" value="{{ $usrlist->host_id }}">
                  <input type="text" class="custom-field w-100 form-control" name="host_game_name" value="{{ $usrlist->host_game_name }}">
                </div>
				@if ($errors->has('host_game_name'))
				<span class="text-danger">{{ $errors->first('host_game_name') }}</span>
				@endif
              </div>
            </div>
			
			
			
            <div class="col-lg-12">
              <div class="form-group row">
                <div class="col-lg-4 text-right">
                  <label for="description" class="custom-label">Description</label>
                </div>
                <div class="col-lg-6">
				
                  <input type="text" class="custom-field w-100 form-control" name="description" value="{{ $usrlist->description }}">
                </div>
				@if ($errors->has('description'))
				<span class="text-danger">{{ $errors->first('description') }}</span>
				@endif
              </div>
            </div>
			<div class="col-lg-12">
              <div class="form-group row">
                <div class="col-lg-4 text-right">
                  <label for="gamestartdate" class="custom-label">Start Date</label>
                </div>
                <div class="col-lg-6">
				
                 <input type="date" id="gamestartdate" value = "{{$usrlist->gamestartdate}}" name="gamestartdate" class="custom-field form-control">
                </div>
				@if ($errors->has('gamestartdate'))
				<span class="text-danger">{{ $errors->first('gamestartdate') }}</span>
				@endif
              </div>
            </div>
			
			<div class="col-lg-12">
              <div class="form-group row">
                <div class="col-lg-4 text-right">
                  <label for="gameenddate" class="custom-label">End Date</label>
                </div>
                <div class="col-lg-6">
				
                 <input type="date" id="gameenddate" value = "{{$usrlist->gameenddate}}" name="gameenddate" class="custom-field form-control">
                </div>
                @if ($errors->has('gameenddate'))
                <span class="text-danger">{{ $errors->first('gameenddate') }}</span>
                @endif
              </div>
            </div>
			
     
			
            <div class="col-lg-12">
              <div class="form-group row">
                <div class="col-lg-4 text-right">
                  <label for="venuename" class="custom-label">Venue Name</label>
                </div>
                <div class="col-lg-6">
				
                <select name="venuename" class="form-control sportigo-select-2 d-inline w-auto mr-2" aria-label="Default select example">
                
                @forelse( $allvendorlist as $vendorlist )    
                  <option value="{{ $vendorlist->vendor_id }}" {{ $usrlist->venuename == $vendorlist->vendor_id  ? 'selected' : ''}}>{{ $vendorlist->businessname}}</option>

                @empty 

                @endforelse 
              </select>

                </div>
				
              </div>
            </div>


			<!--<div class="col-lg-12">
              <div class="form-group row">
                <div class="col-lg-4 text-right">
                  <label for="venuename" class="custom-label">Location</label>
                </div>
                <div class="col-lg-6">
				
                  <input type="text" class="custom-field w-100 form-control" name="venuename" value="{{ $usrlist->venuename }}">
                </div>
				@if ($errors->has('venuename'))
				<span class="text-danger">{{ $errors->first('venuename') }}</span>
				@endif
              </div>
            </div>!-->

			
			<div class="col-lg-12">
              <div class="form-group row">
                <div class="col-lg-4 text-right">
                  <label for="hostcreatedby" class="custom-label">Host Created By</label>
                </div>
                <div class="col-lg-6">
				
                  <input type="text" class="custom-field w-100 form-control" name="hostcreatedby" value="{{ $usrlist->hostcreatedby }}">
                </div>
				
              </div>
            </div>
			
			
			<div class="col-lg-12">
              <div class="form-group row">
                <div class="col-lg-4 text-right">
                  <label for="totalplayer" class="custom-label">Total Join People</label>
                </div>
                <div class="col-lg-6">
				
                  <input type="text" class="custom-field w-100 form-control" name="totalplayer" value="{{ $usrlist->totalplayer }}">
                </div>
				@if ($errors->has('totalplayer'))
				<span class="text-danger">{{ $errors->first('totalplayer') }}</span>
				@endif
              </div>
            </div>
			
			<div class="col-lg-12">
              <div class="form-group row">
                <div class="col-lg-4 text-right">
                  <label for="hostexpired" class="custom-label">Status</label>
                </div>
                <div class="col-lg-6">
				<select class="form-control sportigo-select d-inline w-auto mr-2" aria-label="Default select example" name="hostexpired">
                <option value="Y" {{($usrlist->hostexpired =='Y') ? 'selected' : '' }}>Expired</option>
				<option value="N" {{($usrlist->hostexpired =='N') ? 'selected' : '' }}>Upcomming</option>
                
              </select>
                  
                </div>
				@if ($errors->has('hostexpired'))
				<span class="text-danger">{{ $errors->first('hostexpired') }}</span>
				@endif
              </div>
            </div>
			
			<div class="col-lg-12">
              <div class="form-group row">
                <div class="col-lg-4 text-right">
                  <label for="bookingcheck" class="custom-label">Booking Check</label>
                </div>
                <div class="col-lg-6">
				<select class="form-control sportigo-select d-inline w-auto mr-2" aria-label="Default select example" name="bookingcheck">
                <option value="Y" {{($usrlist->bookingcheck =='Y') ? 'selected' : '' }}>Booked</option>
				<option value="N" {{($usrlist->bookingcheck =='N') ? 'selected' : '' }}>Not Booked</option>
                
              </select>
                  
                </div>
				@if ($errors->has('bookingcheck'))
				<span class="text-danger">{{ $errors->first('bookingcheck') }}</span>
				@endif
              </div>
            </div>
			
			
            <div class="col-lg-4"></div>
           
			<div class="col-lg-6 text-right">
              
            </div>
          </div>
       
		
		 </form>
		@empty 
		@endforelse 
      </div>
    </div>
  
  </div>
  
  
@include('layouts.footer')  