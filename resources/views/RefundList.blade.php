@include('layouts.head')
<body>
<div class="dash wrapper">

  @include('layouts.header')


        <div class="custom-border"></div>
        <div class="container">
          <form  action="{{ route('refundsstore') }}" method="post" enctype="multipart/form-data">
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
               <div class="col-lg-12 d-flex flex-wrap justify-content-md-start justify-content-center mb-4">
                  <button type="submit" class="green-small mr-2 mb-2">SEND</button>
				  
				  <a href="{{ route('dashboard') }}" class="d-inline"><button type="button" class="gray-small mr-2 mb-2"> BACK</button></a>
          <a href="{{route('refundpolicylist')}}" class="d-inline"><button type="button" class="sgreen">REFUND POLICY LIST</button></a>
                </div>
            </div>
              
              <div class="row">
                <div class="col-lg-12">
                  <div class="form-group">
                    <label for="name" class="custom-label mr-2">Refund Policy Description:</label>
                    <input type="text" class="custom-field form-control d-inline" name="name">
                  </div>
				  @if ($errors->has('name'))
					<span class="text-danger">&nbsp;&nbsp;  {{ $errors->first('name') }}</span>
				@endif
                </div>
				
				
              </div>
			  
			  <div class="row">
                <div class="col-lg-12">
                  <div class="form-group">
                    <label for="refund" class="custom-label mr-2">Refund Policy Hours:</label>
                    <input type="text" class="custom-field form-control d-inline" name="refund">
                  </div>
				  @if ($errors->has('refund'))
					<span class="text-danger">&nbsp;&nbsp;  {{ $errors->first('refund') }}</span>
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