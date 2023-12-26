@include('layouts.head')
<body>
<div class="dash wrapper">

  @include('layouts.header')
  
    <div class="custom-border"></div>
  
    <div class="main-section pb-2">
      <div class="container">
        @forelse( $commisionmgmt as $commmgmt)
	
       <form  action="{{ route('commisionupdate',$commmgmt->userid) }}" method="post" enctype="multipart/form-data">
            @csrf 
			
			@if(Session::has('success'))
			 <div class="alert alert-success text-center mt-3 mb-3">
				<span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
				 {{ Session::get('success') }}
			 </div> 
		    @endif
			
          <div class="row">
            
    		<div class="col-lg-6 d-flex flex-wrap justify-content-md-start justify-content-center mb-3 mt-4">
                <button type="submit" class="green-small mr-2 mt-2 mb-2">SAVE</button>
                <a href="{{ route('dashboard') }}"><button type="button" class="gray-small" > BACK</button></a>
            </div>
            <div class="col-lg-6"></div>
            <div class="col-lg-12">
              <div class="form-group row">
                <div class="col-lg-4 text-right">
                  <label for="userid" class="custom-label">Name</label>
                </div>
                <div class="col-lg-6">
                  <input type="text" class="custom-field w-100 form-control" value="{{$commmgmt->name}}" name="name" disabled>
                </div>
              </div>
            </div>
            <div class="col-lg-12">
              <div class="form-group row">
                <div class="col-lg-4 text-right">
                  <label for="userid" class="custom-label">Login ID</label>
                </div>
                <div class="col-lg-6">
                  <input type="text" class="custom-field w-100 form-control" value="{{$commmgmt->id}}" name="loginid" disabled>
                </div>
              </div>
            </div>
            <div class="col-lg-12">
              <div class="form-group row">
                <div class="col-lg-4 text-right">
                  <label for="userid" class="custom-label">Username</label>
                </div>
                <div class="col-lg-6">
                  <input type="text" class="custom-field w-100 form-control" value="{{$commmgmt->email}}" name="username" disabled>
                </div>
              </div>
            </div>
            <div class="col-lg-12">
              <div class="form-group row">
                <div class="col-lg-4 text-right">
                  <label for="userid" class="custom-label">Password</label>
                </div>
                <div class="col-lg-6">
                  <input type="password" class="custom-field w-100 form-control" value="{{$commmgmt->original_password}}" name="password" disabled>
                </div>
              </div>
            </div>
			
			 <div class="col-lg-12">
              <div class="form-group row">
                <div class="col-lg-3"></div>
                <div class="col-lg-5 text-left">
                  <label for="userid" class="custom-label">Admin Set Commission :</label>
                </div>
               
              </div>
            </div>
			
            <div class="col-lg-12">
              <div class="form-group row">
                <div class="col-lg-3"></div>
                <div class="col-lg-5 text-left">
                  <label for="userid" class="custom-label">Admin Booking Commission :</label>
                </div>
                <div class="col-lg-1">
                  <div class="d-flex"><input type="text" class="custom-field w-100 form-control" value="{{$commmgmt->admin_commisionval}}" name="admin_commisionval">%</div>
                </div>
              </div>
            </div>
            <div class="col-lg-12">
              <div class="form-group row">
                <div class="col-lg-3"></div>
                <div class="col-lg-5 text-left">
                  <label for="userid" class="custom-label">Refferal User Commission :</label>
                </div>
                <div class="col-lg-1">
                  <div class="d-flex"><input type="text" value="{{$commmgmt->Refferal_commisionval}}" class="custom-field w-100 form-control" name="Refferal_commisionval">%</div>
                </div>
              </div>
            </div>
			 <div class="col-lg-12">
              <div class="form-group row">
                <div class="col-lg-3"></div>
                <div class="col-lg-5 text-left">
                  <label for="userid" class="custom-label">Vendor Sales Agent Commission :</label>
                </div>
                <div class="col-lg-1">
                  <div class="d-flex"><input type="text" value="{{$commmgmt->sales_agent_commisionval}}"  class="custom-field w-100 form-control" name="sales_agent_commisionval">%</div>
                </div>
              </div>
            </div>
            <div class="col-lg-12">
              <div class="form-group row">
                <div class="col-lg-3"></div>
                <div class="col-lg-5 text-left">
                  <label for="userid" class="custom-label">Vendor Reffer Commission :</label>
                </div>
                <div class="col-lg-1">
                  <div class="d-flex"><input type="text" value="{{$commmgmt->Vendor_Reffer_commisionval}}"  class="custom-field w-100 form-control" name="Vendor_Reffer_commisionval">%</div>
                </div>
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