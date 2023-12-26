@include('layouts.head')
<body>
<div class="dash wrapper">

    @include('layouts.header')
  
    <div class="custom-border"></div>
  
    <div class="main-section pt-4 pb-4">
      <div class="container">
	  
	  @forelse( $userdetails as $usrlist)
    <form action="{{ route('instructorsupdate',$usrlist->instructor_id)}}" method="post"  enctype="multipart/form-data">
          @csrf 
		  
	   <div class="row d-flex align-items-center justify-content-between">
	       <div>
             <button type="submit" class="green-small mr-2">SAVE</button>
              <a href="{{ route('dashboard') }}"><button type="button" class="gray-small mr-2" > BACK</button></a>
              <a href="{{route('instructorslist')}}"><button type="button" class="sgreen">INSTRUCTOR LIST</button></a>
		  </div>
		  <div>
            <a href="{{ route('instructorapproved', $usrlist->instructor_id )}}"><button type="button" class="green-round-btn mr-2">APPROVE</button></a>
            <a href="{{ route('instructorrejected', $usrlist->instructor_id )}}"><button type="button" class="red-round-btn">PENDING</button></a>
          </div>
       </div>
	  
        <div class="row d-flex align-items-center justify-content-start mb-4">
		 
		
		
		
          <!--<button type="submit" class="theme-btn mr-3">ADD NEW STAFF</button>!-->
          
          
         
        
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
                  <label for="userid" class="custom-label">Instructor Name</label>
                </div>
                <div class="col-lg-6">
				<input type="hidden" class="custom-field w-100 form-control" name="userid" value="{{ $usrlist->instructor_id}}">
                  <input type="text" class="custom-field w-100 form-control" name="user_name" value="{{ $usrlist->user_name }}">
                </div>
				@if ($errors->has('user_name'))
				<span class="text-danger">{{ $errors->first('user_name') }}</span>
				@endif
              </div>
            </div>
			
			<div class="col-lg-12">
              <div class="form-group row">
                <div class="col-lg-4 text-right">
                  <label for="userid" class="custom-label">IC Number</label>
                </div>
                <div class="col-lg-6">
                  <input type="text" class="custom-field w-100 form-control" name="icno" value="{{ $usrlist->icno }}">
                </div>
				@if ($errors->has('icno'))
				<span class="text-danger">{{ $errors->first('icno') }}</span>
				@endif
              </div>
            </div>
			
          
            <div class="col-lg-12">
              <div class="form-group row">
                <div class="col-lg-4 text-right">
                  <label for="userid" class="custom-label">Sports Center</label>
                </div>
                <div class="col-lg-6">
                  
                  <select name="sportcenter" class="form-control sportigo-select-2 d-inline w-auto mr-2" aria-label="Default select example">
                  @foreach($vendorlist as $vlist)
                  <option value="{{ $vlist->businessname }}" {{ $usrlist->sportcenter == $vlist->businessname  ? 'selected' : ''}}>{{ $vlist->businessname}}</option>
                  @endforeach
                </select>



                </div>
              @if ($errors->has('sportcenter'))
              <span class="text-danger">{{ $errors->first('sportcenter') }}</span>
              @endif
              </div>
            </div>

          
            <div class="col-lg-12">
              <div class="form-group row">
                <div class="col-lg-4 text-right">
                  <label for="userid" class="custom-label">Sport Category</label>
                </div>
                <div class="col-lg-6">
                  
                  <select name="sportcategory" class="form-control sportigo-select-2 d-inline w-auto mr-2" aria-label="Default select example">
                  @foreach($allcategorieslist as $categorieslist)
                  <option value="{{ $categorieslist->id }}" {{ $usrlist->sportcategory == $categorieslist->id  ? 'selected' : ''}}>{{ $categorieslist->name}}</option>
                  @endforeach
                </select>


                </div>

                



              @if ($errors->has('sportcategory'))
              <span class="text-danger">{{ $errors->first('sportcategory') }}</span>
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