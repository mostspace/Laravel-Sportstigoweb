@include('layouts.head')
<body>
<div class="dash wrapper">

  @include('layouts.header')


        <div class="custom-border"></div>
        <div class="container">
          <form  action="{{ route('state.store') }}" method="post" enctype="multipart/form-data">
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
                <div class="col-lg-12 d-flex flex-wrap justify-content-md-start justify-content-center mt-2 mb-5">
                  <button type="submit" class="green-small mr-2 mb-2">SEND</button>
				  
				  <a href="{{ route('dashboard') }}"><button type="button" class="gray-small mr-2 mb-2" > BACK</button></a>
          <a href="{{route('Statedetaillist')}}"><button type="button" class="green-small ">STATE LIST</button></a>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-12">
                  <div class="form-group">
                    <label for="statename" class="custom-label mr-2">State Name:</label>
                    <input type="text" class="custom-field form-control d-inline" name="statename">
                  </div>
				  @if ($errors->has('statename'))
					<span class="text-danger">&nbsp;&nbsp;  {{ $errors->first('statename') }}</span>
				@endif
                </div>
              </div>
             
              <?php /*
              <div class="row">
                <div class="col-lg-12">
                  <div class="form-group">
                    <label for="banner1" class="custom-label mr-2">Category Image :</label>
                    <div class="file-upload iuw2">                
                      <div class="image-upload-wrap">
                        <input class="file-upload-input" id="iuw2" type='file' onchange="readURL(this);" accept="image/*" />
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
              </div>  */ ?>
               
            </div>
          </form>
        </div>
      </div>

@include('layouts.footer')