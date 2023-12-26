@include('layouts.head')
<body>
<div class="dash wrapper">

  @include('layouts.header')


        <div class="custom-border"></div>
        <div class="container">
          @forelse( $categorylist as $catelist)
		  
		  <form  action="{{ route('categoryupdate',$catelist->id) }}" method="post" enctype="multipart/form-data">
            @csrf 
			
			@if(Session::has('success'))
			 <div class="alert alert-success text-center mt-3 mb-3">
				<span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
				 {{ Session::get('success') }}
			 </div> 
		    @endif
			
			<div class="row">
                <div class="col-lg-12 mt-5">
                  <button type="submit" class="d-inline sgreen mr-2 mb-2">SEND</button>
				  
				  
				   <a href="{{ route('dashboard') }}"><button type="button" class="d-inline gray-small mr-2 mb-2"> BACK</button></a>
           <a href="{{route('categorylist')}}"><button type="button" class="d-inline sgreen ">CATEGORY LIST</button></a>
                </div>
              </div>
              
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
			<input type="hidden" class="custom-field w-100 form-control" name="userid" value="{{ $catelist->id }}" >
            <div class="voucher">
              <div class="row">
                <div class="col-lg-12">
                  <div class="form-group">
                    <label for="categoryname" class="custom-label mr-2">Categories Name:</label>
                    <input type="text" class="custom-field form-control d-inline" name="categoryname" 
					value="{{ $catelist->name }}">
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
					  
					  
					  @if( $catelist->image )
                                    <div class="col-xl-3 col-lg-3 col-md-3">
                                        <div class="form-group">
                                            <div class="mt-2 mb-2">
											
						<img src="{{asset($catelist->image)}}" width="100px" alt="Blog-image" />
                                            </div>
                                        </div>
                                    </div>
					 @endif  
					  
					  
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
					  
					  
					  @if( $catelist->image2 )
                                    <div class="col-xl-3 col-lg-3 col-md-3">
                                        <div class="form-group">
                                            <div class="mt-2 mb-2">
											
						<img src="{{asset($catelist->image2)}}" width="100px" alt="Blog-image" />
                                            </div>
                                        </div>
                                    </div>
					 @endif  
					  
					  
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
              
              
            </div>
          </form>
		  @empty 
		@endforelse 
        </div>
      </div>

@include('layouts.footer')