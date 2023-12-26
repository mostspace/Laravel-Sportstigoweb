@include('layouts.head')
<body>
<div class="dash wrapper">
    
    @include('layouts.header')

    <div class="custom-border"></div>
    <div class="container">
       <form  action="{{ route('bannerstore') }}" method="post" enctype="multipart/form-data">
            @csrf 
			
			@if(Session::has('success'))
			 <div class="alert alert-success text-center mt-3 mb-3">
				<span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
				 {{ Session::get('success') }}
			 </div> 
		    @endif
		
      <div class="voucher">

         <div class="row">
              <div class="col-lg-12 d-flex flex-wrap justify-content-md-start justify-content-center mb-4">
                <button type="submit" class="green-small mr-2 mb-2">SAVE</button>
				 
				 <a href="{{ route('dashboard') }}"><button type="button" class="gray-small mr-2 mb-2" > BACK</button></a>
                 <a href="{{route('bannerlist')}}"><button type="button" class="green-small ">BANNER LIST</button></a>
              </div>
            </div>
            
         <!--<div>
              <label for="banner1" class="custom-label mr-2">Slider Banner :</label>  
         </div>!-->
		
        



        <div class="row">
            <div class="col">
                <div class="form-group d-flex">
                    
                   <div class="d-flex align-items-center justify-content-center">
                        <div>
                            <label for="banner1" class="custom-label mr-2">Banner Type  :</label> 
                            <select name="bannertype" class="form-control sportigo-select w-auto mr-2" aria-label="Default select example">
						    
                            <option value="1"> Main Banner</option>
                            <option value="2"> Secondary Banner</option>
						
						    </select> 
                        </div>
                  </div>     
                  </div> 
                  </div> 
                  </div>              

        <div class="row">
            <div class="col-md-14">
                <div class="form-group d-flex">
                    
                   <div class="d-flex align-items-center justify-content-center">
                        <div>
                            <label for="banner1" class="custom-label mr-4">&nbsp;&nbsp;&nbsp;Banner  :</label>  
                        </div>
                        <div>
                            <div class="file-upload iuw1">                
                                <div class="image-upload-wrap" >
                                  <input class="file-upload-input" id="iuw1" name="bannerimage" type='file' onchange="readURL(this);" accept="image/*" />
                                  <div class="drag-text">
                                    <h3>+</h3>
                                  </div>
								  <input type="hidden" name="hdn_bannerimage" value="myimagepath">
								  
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
                    
                    <div class="d-flex align-items-center justify-content-center">
                        <!--<div class="custom-radio ml-2">
                            <input type="checkbox" name="url1" id="url1">
                            <label class="custom-label2 d-flex align-items-center" for="url1"></label>                                
                        </div>!-->
                        <label for="url1" class="custom-label mx-2">URL :</label>
                        <input type="text" class="custom-field form-control w-170 d-inline" name="url1" id="url1" onkeyup="change_URL()">
                    </div>
                   
                    <div class="d-flex align-items-center justify-content-center">
                        <!--<div class="custom-radio ml-2">
                            <input type="checkbox" name="vendorpage1" id="vendorpage1">
                            <label class="custom-label2 d-flex align-items-center" for="vendorpage1"></label>                                
                        </div>!-->
                        <label for="vendorpage1" class="custom-label mx-2">Vendor Page :</label>
                        <!--<select class="form-control sportigo-select w-auto mr-2" aria-label="Default select example">
                          <option selected>ABC Badminton Center</option>
                          <option value="1">ABC Badminton Center</option>
                          <option value="2">ABC Badminton Center</option>
                          <option value="3">ABC Badminton Center</option>
                        </select>!-->
						
						
						<select name="vendor_code" id = 'vendor_code' class="form-control sportigo-select w-auto mr-2" aria-label="Default select example" onchange="change_vendor()">
						<option value="0">-----Select-----</option>
						@forelse( $allvendorlist as $vendorlist )    
                            
							<option value="{{ $vendorlist->vendor_id }}"> {{ $vendorlist->businessname }} </option>
						@empty 

						@endforelse 
						</select>
						@if ($errors->has('vendor_code'))
						<span class="text-danger">{{ $errors->first('vendor_code') }}</span>
						@endif
						
						
						
                    </div>
                    
                </div>
            </div>
        </div>
		@if ($errors->has('bannerimage'))
			<span class="text-danger">{{ $errors->first('bannerimage') }}</span>
		@endif
		
        
       <!-- <div>
              <label for="banner2" class="custom-label mr-2">Secondary Banner :</label>  
         </div>
		
		<div class="row">
            <div class="col-md-12">
                <div class="form-group d-flex">
                    
                    <div class="d-flex align-items-center justify-content-center">
                        <div>
                            <label for="banner2" class="custom-label mr-2">Banner  :</label>  
                        </div>
                        <div>
                            <div class="file-upload iuw2">                
                                <div class="image-upload-wrap" >
                                  <input class="file-upload-input" id="iuw2" name="secondbannerimage" type='file' onchange="readURL(this);" accept="image/*" />
                                  <div class="drag-text">
                                    <h3>+</h3>
                                  </div>
								  <input type="hidden" name="hdn_secondbannerimage" value="myimagepath1">
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
                   
                    <div class="d-flex align-items-center justify-content-center">
                       
                        <label for="url2" class="custom-label mx-2">URL :</label>
                        <input type="text" class="custom-field form-control w-170 d-inline" name="url2" id="url2">
                    </div>
					
                    <div class="d-flex align-items-center justify-content-center">
                       
                        <label for="vendorpage1" class="custom-label mx-2">Vendor Page :</label>
                       
						
						<select name="secondvendor_code" class="form-control sportigo-select w-auto mr-2" aria-label="Default select example">
						
						@forelse( $allvendorlist as $vendorlist )    
							<option value="{{ $vendorlist->vendor_id }}"> {{ $vendorlist->businessname }} </option>
						@empty 

						@endforelse 
						</select>
						@if ($errors->has('vendor_code'))
						<span class="text-danger">{{ $errors->first('vendor_code') }}</span>
						@endif
						
                    </div>
                    
                </div>
            </div>
        </div>  !-->
        
        
        @if ($errors->has('secondbannerimage'))
									<span class="text-danger">{{ $errors->first('secondbannerimage') }}</span>
		@endif

           

      </div>


    </form>
    </div>
  </div>
  <script>
    function change_URL() 
    {
      
        var temp = "0";
        var mySelect = document.getElementById('vendor_code');

        for(var i, j = 0; i = mySelect.options[j]; j++) 
        {
           
            if(i.value == temp) {
                mySelect.selectedIndex = j;
                break;
            }
        }
    }
    function change_vendor() 
    {
       
        document.getElementById("url1").value = '';  
    }
    </script>
  @include('layouts.footer')