@include('layouts.head')

<body>
   <div class="dash wrapper">
   @include('layouts.header')
   <div class="custom-border">
   </div>
   <div class="main-section pt-4 pb-4">
   <div class="container">
   
      <form action="{{ route('savevendor') }}" method="post" enctype="multipart/form-data">
      @csrf 
       
		 
		 @if(Session::has('success'))
			<div class="alert alert-success text-center mt-3 mb-3">
				<span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
				 {{ Session::get('success') }}
			</div> 
		  @endif
     
         <div class="row">
             
            <div class="col-lg-12 mb-4 d-flex flex-wrap justify-content-md-start justify-content-center">
            <?php 
                   $role = Session::get('getsessionrole');
                   if($role==7)
                   {
                   ?>  
                      <button type="submit" class="green-small mr-2">SAVE</button>
                   <?php
                   }


                   if($role==8)
                   {
                   ?>  
                      <button type="submit" class="green-small mr-2">SAVE</button>
                   <?php
                   }
                   
                   if($role==1)
                   {
                   ?>  
                      <button type="submit" class="green-small mr-2">SAVE</button>
                   <?php
                   }

                   ?> 
                   
            <a href="{{ route('dashboard') }}"  class="d-inline"><button type="button" class="gray-small mr-2"> BACK</button></a>
				<a href="{{ route('vendorlist') }}"  class="d-inline"><button type="button" class="sgreen"> VENDOR LIST</button></a>
				
            </div> 
             
            <div class="col-lg-4">
               <div class="form-group">
                  <label for="businessname" class="custom-label">Business Name</label>
                  <input type="text" class="form-control" value="{{ old('businessname') }}" name="businessname">
				  @if ($errors->has('businessname'))
				   <span class="text-danger">{{ $errors->first('businessname') }}</span>
		         @endif
               </div>
            </div>
          
			
			<div class="col-lg-2">
            <div class="form-group">
              <label for="refund" class="custom-label">Refund Policy</label>
              <select class="form-control sportigo-select d-inline w-auto mr-2" aria-label="Defaul select example" name="refund">
               
			   @forelse( $allrefundpolicylist as $allrefundpolicylst )    
						<option value="{{ $allrefundpolicylst->refund }}"> 
						{{ $allrefundpolicylst->name }} </option>
						@empty 
						@endforelse 
			   
			   
              </select>
			  @if ($errors->has('refund'))
				   <span class="text-danger">{{ $errors->first('refund') }}</span>
		         @endif
            </div>
          </div>
		  
		  
            <div class="col-lg-6">
               <div class="form-group">
                  <label for="address" class="custom-label">Address</label>
                  <input type="text" class="form-control" value="{{ old('address') }}" id="address" name="address">
                  <input type="hidden" class="form-control" id="latitude" name="latitude" readonly />
                  <input type="hidden" class="form-control" id="longitude" name="longitude" readonly />
				   @if ($errors->has('address'))
				   <span class="text-danger">{{ $errors->first('address') }}</span>
		         @endif
               </div>
            </div>






			
            <div class="col-lg-6">
               <div class="form-group">
                  <label for="description" class="custom-label">Description</label>
                  <input type="text" class="form-control" value="{{ old('description') }}" name="description">
				  @if ($errors->has('description'))
				   <span class="text-danger">{{ $errors->first('description') }}</span>
		         @endif
               </div>
            </div>
			
           
			
			<div class="col-lg-6">
            <div class="form-group">
              <label for="whatsapp" class="custom-label">Phone Number</label>
              <div class="row g-0">
                <div class="col-lg-2">
                  <select name="phonecode" class="form-control sportigo-select d-inline w-auto mr-2" aria-label="Default select example">
                    <option selected>+ 60</option>
                  </select>
                </div>
                <div class="col-lg-10">
                   <input type="text" class="custom-field-2 form-control" name="whatsapp">
                </div>
				@if ($errors->has('whatsapp'))
				   <span class="text-danger">{{ $errors->first('whatsapp') }}</span>
		         @endif
              </div>
            </div>
          </div>
			
			
			
           
          <div class="col-lg-5">
               <div class="form-group">
                  <label for="moredetails" class="custom-label">More Details</label>
                  <!--<input type="text" class="form-control" value="{{ old('moredetails') }}" name="moredetails">!-->


                  <textarea id="moredetails"  rows="8" cols="50" name="moredetails" class="form-control custom-area" placeholder="Write something.."  >{{ old('moredetails') }}</textarea>


               </div>
            </div> 
			
			<div class="col-lg-3">
                  <div class="form-group">
                    <label for="state" class="custom-label">State</label>
                    
					<select name="state" class="form-control sportigo-select-2 d-inline w-auto mr-2" aria-label="Default select example">
						@forelse( $allstatelist as $allstatelst )    
						<option value="{{ $allstatelst->id }}"> {{ $allstatelst->name }} </option>
						@empty 
						@endforelse 
                    </select>
                  </div>
				  @if ($errors->has('state'))
				   <span class="text-danger">{{ $errors->first('state') }}</span>
		          @endif
			</div>	  
			<div class="col-lg-4">	  
				  <div class="form-group">
                    <label for="state" class="custom-label">Business Category</label>
                   <select name="business_category" class="form-control sportigo-select-2 d-inline w-auto mr-2" aria-label="Default select example">
                
					@forelse( $allcategorieslist as $categorieslist )    
						<option value="{{ $categorieslist->id }}"> {{ $categorieslist->name }} </option>
					@empty 

					@endforelse 
					</select>
					
					
                  </div>
				   @if ($errors->has('business_category'))
				   <span class="text-danger">{{ $errors->first('business_category') }}</span>
		          @endif
				  
            </div>

            <div class="col-lg-4">
               <div class="form-group">
                  <label for="bankname" class="custom-label">Bank Name</label>
                  <input type="text" class="form-control" value="{{ old('bankname') }}" name="bankname">
               </div>
            </div>
            <div class="col-lg-4">
               <div class="form-group">
                  <label for="bankacno" class="custom-label">Account No</label>
                  <input type="text" class="form-control" value="{{ old('bankacno') }}" name="bankacno">
               </div>
            </div>
            <div class="col-lg-4">
               <div class="form-group">
                  <label for="bankaccountname" class="custom-label">Account Holder Name</label>
                  <input type="text" class="form-control" value="{{ old('bankaccountname') }}" name="bankaccountname">
               </div>
            </div>
                
			
            <div class="col-lg-4">
               <div class="form-group">
                  <label for="promo" class="custom-label">Promo Message</label>
                  <input type="text" class="form-control" value="{{ old('promo') }}" name="promo">
               </div>
            </div>



           



            <div class="col-lg-4">
               <div class="form-group">
                  <label for="userid" class="custom-label d-flex">Gallery</label>
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
               @if ($errors->has('categoryimage'))
				   <span class="text-danger">{{ $errors->first('categoryimage') }}</span>
		          @endif
            </div>
            
			 <div class="col-lg-4">
               <div class="form-group">
                  <label for="userid" class="custom-label d-flex">Sub Gallery1</label>
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
               @if ($errors->has('categoryimage2'))
				   <span class="text-danger">{{ $errors->first('categoryimage2') }}</span>
		          @endif
            </div>
			 <div class="col-lg-4">
               <div class="form-group">
                  <label for="userid" class="custom-label d-flex">Sub Gallery2</label>
                  <div class="file-upload iuw3">                
                      <div class="image-upload-wrap" >
                        <input class="file-upload-input" id="iuw3" type='file' name="categoryimage3" onchange="readURL(this);" accept="image/*" />
                        <input type="hidden" name="hdn_category_image3" value="myimagepath">
                        <div class="drag-text">
                          <h3>+</h3>
                        </div>
                      </div>
                      <div class="file-upload-content">
                        <img class="file-upload-image" src="#" alt="your image" />
                        <div class="image-title-wrap">
                          <button type="button" id="iuw3" class="remove-image"><span class="image-title">Uploaded Image</span></button>
                        </div>
                      </div>
                    </div>   
               </div>
               @if ($errors->has('categoryimage3'))
				   <span class="text-danger">{{ $errors->first('categoryimage3') }}</span>
		          @endif
            </div>
			
			<div class="col-lg-4">
               <div class="form-group">
                  <label for="userid" class="custom-label d-flex">Sub Gallery3</label>
                  <div class="file-upload iuw4">                
                      <div class="image-upload-wrap" >
                        <input class="file-upload-input" id="iuw4" type='file' name="categoryimage4" onchange="readURL(this);" accept="image/*" />
                        <input type="hidden" name="hdn_category_image4" value="myimagepath">
                        <div class="drag-text">
                          <h3>+</h3>
                        </div>
                      </div>
                      <div class="file-upload-content">
                        <img class="file-upload-image" src="#" alt="your image" />
                        <div class="image-title-wrap">
                          <button type="button" id="iuw4" class="remove-image"><span class="image-title">Uploaded Image</span></button>
                        </div>
                      </div>
                    </div>   
               </div>
               @if ($errors->has('categoryimage4'))
				   <span class="text-danger">{{ $errors->first('categoryimage4') }}</span>
		          @endif
            </div>
			
			
            <div class="col-lg-6">
               <div class="form-group">
                  <label for="userid" class="custom-label">Facility</label>  
               </div>
                <div class="row">
                 
					@forelse( $allfacilitylist as $allfacility )    
						
					<div class="custom-radio col-md-6 mb-2">
                     <input type="checkbox" name="Facility[]" id="{{ $allfacility->id }}" value="{{ $allfacility->facility }}">
                     <label class="custom-label2 d-flex align-items-center" for="{{ $allfacility->id }}"> {{ $allfacility->facility }}</label>
                    </div>
					@empty 

					@endforelse 
				 
				 
				  
                  
				</div>  
			   
			
			 
			   
            </div>

            <div class="col-lg-4">
               <div class="form-group">
                  <label for="userid" class="custom-label">Business Hours</label>  
               </div>

               <div class="mb-2 d-flex">
                  <label class="custom-label2 min-w-76 mr-2">Sunday</label>
                  <input type="time" class="form-control" name="sundaystime">
                  <input type="time" class="form-control" name="sundayetime">
			   </div>
				
               <div class="mb-2 d-flex">
                <label class="custom-label2 min-w-76 mr-2">Monday</label>
                <input type="time" class="form-control" name="mondaystime">
                <input type="time" class="form-control" name="mondayetime">
              </div>
             
             <div class="mb-2 d-flex">
              <label class="custom-label2 min-w-76 mr-2">Tuesday</label>
              <input type="time" class="form-control" name="tuesdaystime">
              <input type="time" class="form-control" name="tuesdayetime">
            </div>
           
           <div class="mb-2 d-flex">
            <label class="custom-label2 min-w-76 mr-2">Wednesday</label>
            <input type="time" class="form-control" name="wednesdaystime">
            <input type="time" class="form-control" name="wednesdayetime">
          </div>
         
         <div class="mb-2 d-flex">
          <label class="custom-label2 min-w-76 mr-2">Thursday</label>
          <input type="time" class="form-control" name="thursdaystime">
          <input type="time" class="form-control" name="thursdayetime">
        </div>

        <div class="mb-2 d-flex">
          <label class="custom-label2 min-w-76 mr-2">Friday</label>
          <input type="time" class="form-control" name="fridaystime">
          <input type="time" class="form-control" name="fridayetime">
        </div>

        <div class="mb-2 d-flex">
          <label class="custom-label2 min-w-76 mr-2">Saturday</label>
          <input type="time" class="form-control" name="saturdaystime">
          <input type="time" class="form-control" name="saturdayetime">
        </div>

        <br><br><br>             
       

       
		  <?php 
		 $role = Session::get('getsessionrole');
		if($role==7)
		{
		?>
           <!--<div class="custom-radio col-md-8 mb-2">
                  <input type="checkbox" name="Vendor_Reffer_commisionval" id="Vendor_Reffer_commisionval"  value="Y">
                  <label class="custom-label2 d-flex align-items-center" for="Vendor_Reffer_commisionval"> 
                  Vendor Reffer Commision
                     </label>
            </div>!-->
            
            <div class="col-lg-8">	  
				  <div class="form-group">
                    <label for="state" class="custom-label">Vendor Reffer Commision</label>
                <select name="vendorrefferalid" class="form-control sportigo-select-2 d-inline w-auto mr-2" aria-label="Default select example" width="200px">
               <option value="0">---Select---</option> 
					@forelse( $allvendorrefferallist as $allvendorrefferallst )    
						<option value="{{ $allvendorrefferallst->id }}"> {{ $allvendorrefferallst->name }} </option>
					@empty 

					@endforelse 
					</select>
					
					
                  </div>
				  @if ($errors->has('vendorrefferalid'))
				   <span class="text-danger">{{ $errors->first('vendorrefferalid') }}</span>
		          @endif
				  
            </div>




            <?php
		}
	   ?>
	
      
              

            </div>

            <!--<div class="col-lg-2">
               <div class="form-group">
                  <label for="userid" class="custom-label">Closing Days</label>  
               </div>
               <div class="mb-2">
                  <input type="date" id="closing_days1" name="closing_days1" class="custom-field form-control">
               </div>
               <div class="mb-2">
                  <input type="date" id="closing_days2" name="closing_days2" class="custom-field form-control">
               </div>
               <div class="mb-2">
                  <input type="date" id="closing_days3" name="closing_days3"class="custom-field form-control">
               </div>
               <div class="mb-2">
                  <input type="date" id="closing_days4" name="closing_days4"class="custom-field form-control">
               </div>
               <div class="mb-2">
                  <input type="date" id="closing_days5" name="closing_days5"class="custom-field form-control">
               </div>
               <div class="mb-2">
                  <input type="date" id="closing_days6" name="closing_days6"class="custom-field form-control">
               </div>
               <div class="mb-2">
                  <input type="date" id="closing_days7" name="closing_days7"class="custom-field form-control">
               </div>
               <div class="mb-2">
                  <input type="date" id="closing_days8" name="closing_days8"class="custom-field form-control">
               </div>
            </div>!-->
            <div class="col-lg-2">
                  <div class="form-group">
                  <label for="userid" class="custom-label">Closing Days</label>  
               </div>
               <?php
                 for($i=0;$i<8;$i++)
                 {
               ?>
                  <div class="mb-2">
                     <input type="date" id="closing_days[]" name="closing_days[]" class="custom-field form-control">
                  </div>
                <?php
                 }
                ?>  

            </div>


      </form>
      </div>
   </div>

<!-- Add the this google map apis to webpage -->
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&key=AIzaSyBFm6rvChGSV45iKWoXZVF73RBEVmTwaNo&libraries=places"></script>

	 

 
<script>
google.maps.event.addDomListener(window, 'load', initialize);
function initialize() {
var input = document.getElementById('address');
var autocomplete = new google.maps.places.Autocomplete(input);
autocomplete.addListener('place_changed', function () {
var place = autocomplete.getPlace();
// place variable will have all the information you are looking for.
 
  document.getElementById("latitude").value = place.geometry['location'].lat();
  document.getElementById("longitude").value = place.geometry['location'].lng();
});
}
</script>




   @include('layouts.footer')
