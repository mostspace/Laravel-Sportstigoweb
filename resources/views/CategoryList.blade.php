@include('layouts.head')
<body>
<div class="dash wrapper">

  @include('layouts.header')


        <div class="custom-border"></div>
        <div class="container">
          <form  action="{{ route('category.store') }}" method="post" enctype="multipart/form-data">
            @csrf 
			
			@if(Session::has('success'))
			 <div class="alert alert-success text-center mt-3 mb-3">
				<span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
				 {{ Session::get('success') }}
			 </div> 
		    @endif
			
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
            <div class="voucher">
                
            <div class="row">
                <div class="col-lg-12 d-flex flex-wrap justify-content-md-start justify-content-center mt-2 mb-4">
                  <button type="submit" class="d-inline green-small mr-2 mb-2">SEND</button>
				  
				  
				   <a href="{{ route('dashboard') }}" class="d-inline" ><button type="button" class="d-inline gray-small mr-2 mb-2" > BACK</button></a>
           <a href="{{route('categorylist')}}" class="d-inline" ><button type="button" class="d-inline sgreen">CATEGORY LIST</button></a>
                </div>
            </div>
              
              <div class="row">
                <div class="col-lg-12">
                  <div class="form-group">
                    <label for="categoryname" class="custom-label mr-2">Categories Name:</label>
                    <input type="text" class="custom-field form-control d-inline" name="categoryname">
                  </div>
				  @if ($errors->has('categoryname'))
					<span class="text-danger">&nbsp;&nbsp;  {{ $errors->first('categoryname') }}</span>
				@endif
                </div>
              </div>
              <div class="row">
                <div class="col-lg-12">
                  <div class="form-group">
                    <label for="banner1" class="custom-label mr-2">Category Image :</label>
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
                  </div>            
                </div>
              </div>
			  
			  
			  <div class="row">
                <div class="col-lg-12">
                  <div class="form-group">
                    <label for="banner2" class="custom-label mr-2">Category Featured Image :</label>
                    <div class="file-upload iuw2">                
                      <div class="image-upload-wrap" >
                        <input class="file-upload-input" id="iuw2" type='file' name="categoryimage2" onchange="readURL(this);" accept="image/*" />
                        <input type="hidden" name="hdn_category_image2" value="myimagepath">
                        <div class="drag-text">
                          <h3>+</h3>
                        </div>
                      </div>
                      <div class="file-upload-content">
                        <img class="file-upload-image" src="#" alt="your image" />
                        <div class="image-title-wrap">
                          <button type="button" id="iuw2" class="remove-image"><span class="image-title">Uploaded Image</span></button>
                        </div>
                      </div>
                    </div>                            
                  </div>            
                </div>
              </div>
			  
              
            </div>
          </form>
        </div>
      </div>

@include('layouts.footer')