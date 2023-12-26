@include('layouts.head')
<body>
<div class="dash wrapper">

    @include('layouts.header')
  
    <div class="custom-border"></div>
    <form action="{{ route('membershipadd')}}" method="post"  enctype="multipart/form-data">
          @csrf 
    <div class="main-section pt-4 pb-4">
      <div class="container">
        <div class="row d-flex align-items-center justify-content-md-start justify-content-center mb-4">
          <!--<button type="submit" class="theme-btn mr-3">ADD NEW STAFF</button>!-->
         
		  <button type="submit" class="green-small mr-2 mb-2">SAVE</button>
			  <a href="{{ route('dashboard') }}"><button type="button" class="gray-small mr-2 mb-2" > BACK</button></a>
              <a href="{{route('membershiplist')}}"><button type="button" class="theme-btn ">MEMBERSHIP LIST</button></a>
		  
        </div>
       
		  
		  @if(Session::has('success'))
			<div class="alert alert-success text-center mt-3 mb-3">
				<span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
				 {{ Session::get('success') }}
			</div> 
		 @endif
		 
		
		
          
          <div class="row" style="align-items: center;">
            <div class="col-md-12 dynamic-field" id="dynamic-field-1">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="row align-items-center">
                            <div class="col-md-6 p-0 text-right">
                                <label for="packagename" class="custom-label mr-2">Package Name:</label>
                            </div>
                            <div class="col-md-6 p-0">
                                <input type="text" class="custom-field form-control d-inline" name="package_name" value="{{ old('package_name') }}">
                            </div>
							@if ($errors->has('package_name'))
							<span class="text-danger">{{ $errors->first('package_name') }}</span>
							@endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row align-items-center">
                            <div class="col-md-6 p-0 text-right">
                                <label for="packagename" class="custom-label mr-2">Status:</label>
                            </div>
                            <div class="col-md-6 p-0">
                                <select name="status" class="form-control sportigo-select d-inline w-auto mr-2" aria-label="Default select example">
                                  <option selected value="1">Open for Booking</option>
                                  <option value="0">Close</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                
				<div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="row align-items-center">
                            <div class="col-md-6 p-0 text-right">
                                <label for="packagename" class="custom-label mr-2">Package Descriptions1:</label>
                            </div>
                            <div class="col-md-6 p-0">
                                <input type="text" class="custom-field form-control d-inline w-100" name="package_desc1" value="{{ old('package_desc1') }}">
                            </div>
                        </div>
                    </div>
					<div class="col-md-6 mb-3">
                        <div class="row align-items-center">
                            <div class="col-md-6 p-0 text-right">
                                <label for="packagename" class="custom-label mr-2">Package Descriptions2:</label>
                            </div>
                            <div class="col-md-6 p-0">
                                <input type="text" class="custom-field form-control d-inline w-100" name="package_desc2" value="{{ old('package_desc2') }}">
                            </div>
                        </div>
                    </div>
                </div>
               
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="row align-items-center">
                            <div class="col-md-6 p-0 text-right">
                                <label for="packagename" class="custom-label mr-2">Package Descriptions3:</label>
                            </div>
                            <div class="col-md-6 p-0">
                                <input type="text" class="custom-field form-control d-inline w-100" name="package_desc3" value="{{ old('package_desc3') }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="row align-items-center">
                            <div class="col-md-6 p-0 text-right">
                                <label for="packagename" class="custom-label mr-2">Package Descriptions4:</label>
                            </div>
                            <div class="col-md-6 p-0">
                                <input type="text" class="custom-field form-control d-inline w-100" name="package_desc4" value="{{ old('package_desc4') }}">
                            </div>
                        </div>
                    </div>
                </div>
                
				<div class="row">
                    
					<div class="col-md-6 mb-3">
                        <div class="row align-items-center">
                            <div class="col-md-6 p-0 text-right">
                                <label for="packagename" class="custom-label mr-2">Package Descriptions5:</label>
                            </div>
                            <div class="col-md-6 p-0">
                                <input type="text" class="custom-field form-control d-inline w-100" name="package_desc5" value="{{ old('package_desc5') }}">
                            </div>
                        </div>
                    </div>
					<div class="col-md-6 text-right">
                                <div class="form-group">
                                <label for="duration2" class="custom-label mr-2">Duration :</label>
                                  <select name="package_duration" class="form-control sportigo-select d-inline w-auto mr-2" aria-label="Default select example">
                                    <option selected value="1">1 Month</option>
                                    <option value="2">2 Month</option>
                                    <option value="6">6 Month</option>
                                    <option value="12">12 Month</option>
                                </select>
                                </div>
                            </div>
                    
                </div>
				



                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="row align-items-center">
                            <div class="col-md-6 p-0 text-right">
                                <label for="packagename" class="custom-label mr-2">Package Original Price:</label>
                            </div>
                            <div class="col-md-6 p-0">
                                <input type="text" class="custom-field form-control d-inline w-100" name="package_price" value="{{ old('package_price') }}">
                            </div>
							@if ($errors->has('package_price'))
							<span class="text-danger">{{ $errors->first('package_price') }}</span>
							@endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row align-items-center">
                                <div class="col-md-6 p-0 text-right">
                                  <label for="packagediscountprice2" class="custom-label mr-2">Package Discount Price:</label>
                                  </div>
                                  <div class="col-md-6 p-0">
                                   <input type="text" class="custom-field form-control d-inline w-100" name="package_discount_price" value="{{ old('package_discount_price') }}">
                                </div>
								@if ($errors->has('package_discount_price'))
								<span class="text-danger">{{ $errors->first('package_discount_price') }}</span>
								@endif
                        </div>    
                    </div>
                </div>
               
                <div class="row">
                <div class="col-lg-6">
                   <div class="row align-items-center">
                    <div class="col-md-6 p-0 text-right">
                      <label for="userid" class="custom-label">Gallery:</label>
                      </div>
                      <div class="col-md-6 p-0">
                      <div class="file-upload iuw1">                
                          <div class="image-upload-wrap" >
                            <input class="file-upload-input" id="iuw1" type='file' name="categoryimage" onchange="readURL(this);" accept="image/*" />
                            <input type="hidden" name="hdn_category_image" value="myimagepath">
                            <div class="drag-text">
                              <h3>+</h3>
                            </div>
                          </div>
                          <div class="file-upload-content">
                            <img class="file-upload-image" src="#" alt="your image" />
                            <div class="image-title-wrap">
                              <button type="button" id="iuw1" class="remove-image"><span class="image-title">Uploaded Image</span></button>
                            </div>
                          </div>
                        </div> 
    				  @if ($errors->has('categoryimage'))
    				   <span class="text-danger">{{ $errors->first('categoryimage') }}</span>
    		         @endif					
                   </div>
                </div>
                </div>
                
           </div>
           
          
        
     <!--       <div class="col-md-12 mt-4 mb-5">-->
     <!--         <button type="submit" class="green-small mr-2 mt-5">SAVE</button>-->
			  <!--<a href="{{ route('dashboard') }}"><button type="button" class="gray-small mt-5" > BACK</button></a>-->
     <!--       </div>-->
            
       </div>
       
		
		 </form>
      </div>
    </div>
  
  </div>
  
  
@include('layouts.footer')  