@include('layouts.head')
<body>
   <div class="dash wrapper">
   @include('layouts.header')
   <div class="custom-border">
   </div>
   <div class="main-section pt-4 pb-4">
   <div class="container">
   
      <!--<div class="row d-flex align-items-center justify-content-end mb-4">
         <button type="submit" class="green-round-btn mr-3">APPROVE</button>
         <button type="submit" class="red-round-btn">SUSPEND</button>
      </div>!-->
	   @forelse( $vendorlist as $vlist)
	   @forelse( $vendorDetails as $vdetaillist)
	   <form action="{{ route('updatevendorprofile',$vlist->vendor_id) }}" method="post" enctype="multipart/form-data">
         @csrf 
        <div class="row">
            <div class="col-lg-4 d-flex justify-content-md-start justify-content-center">
                <button type="submit" class="green-small mr-2 mb-2">SAVE</button>
        		<a href="{{ route('dashboard') }}"><button type="button" class="gray-small" > BACK</button></a>
			</div>
		</div>
				  
		<p class="edit-title">Edit Profile</p>
	 
	  
	   
         <!--<input type="hidden" name="_token" value="{{ csrf_token() }}" />!-->
		 
		 
		 @if(Session::has('success'))
			<div class="alert alert-success text-center mt-3 mb-3">
				<span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
				 {{ Session::get('success') }}
			</div> 
		@endif
       
      @if(Session::has('danger'))
			<div class="alert alert-danger text-center mt-3 mb-3">
				<span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
				 {{ Session::get('danger') }}
			</div> 
		@endif
		
		
		<div class="row">
            <div class="col-lg-4">
               <div class="form-group">
                  <label for="businessname" class="custom-label">Business Name</label>
                  <input type="text" class="form-control" value="{{ $vlist->businessname}}" name="businessname">
				  @if ($errors->has('businessname'))
				   <span class="text-danger">{{ $errors->first('businessname') }}</span>
		         @endif
               </div>
            </div>
            <!--<div class="col-lg-2">
               <div class="form-group">
                  <label for="refund" class="custom-label">Refund Policy</label>
                  <input type="text" class="form-control" value="{{ old('refund') }}" name="refund">
				  @if ($errors->has('refund'))
				   <span class="text-danger">{{ $errors->first('refund') }}</span>
		         @endif
               </div>
            </div>!-->
			
			<div class="col-lg-2">
            <div class="form-group">
              <label for="refund" class="custom-label">Refund Policy</label>
              <select class="form-control sportigo-select d-inline w-auto mr-2" aria-label="Default select example" name="refund">
              @forelse( $allrefundpolicylist as $allrefundpolicylst )    
						<option value="{{ $allrefundpolicylst->refund }}" {{$vlist->refund == $allrefundpolicylst->refund  ? 'selected' : ''}}>{{ $allrefundpolicylst->name}}</option>
			    @endforeach
                
              </select>
			  @if ($errors->has('refund'))
				   <span class="text-danger">{{ $errors->first('refund') }}</span>
		         @endif
            </div>
          </div>
		  
		  
            <div class="col-lg-6">
               <div class="form-group">
                  <label for="address" class="custom-label">Address</label>
                  <input type="text" class="form-control" value="{{ $vlist->address}}" id = "address" name="address">
                  <input type="hidden" class="form-control" value="{{ $vlist->latitude}}" id="latitude" name="latitude" readonly />
                  <input type="hidden" class="form-control" value="{{ $vlist->longitude}}" id="longitude" name="longitude" readonly />


				  @if ($errors->has('address'))
				   <span class="text-danger">{{ $errors->first('address') }}</span>
		         @endif
               </div>
            </div>
			
            <div class="col-lg-6">
               <div class="form-group">
                  <label for="description" class="custom-label">Description</label>
                  <input type="text" class="form-control" value="{{ $vlist->description}}" name="description">
				  @if ($errors->has('description'))
				   <span class="text-danger">{{ $errors->first('description') }}</span>
		         @endif
               </div>
            </div>
			
            <!--<div class="col-lg-6">
               <div class="form-group">
                  <label for="whatsapp" class="custom-label">Whatsapp</label>
                  <input type="text" class="form-control" value="{{ old('whatsapp') }}" name="whatsapp">
				  @if ($errors->has('whatsapp'))
				   <span class="text-danger">{{ $errors->first('whatsapp') }}</span>
		         @endif
               </div>
            </div>!-->
			
			<div class="col-lg-6">
            <div class="form-group">
              <label for="whatsapp" class="custom-label">Phone Number</label>
              <div class="row g-0">
                <div class="col-lg-2">
                  <select name="phonecode" class="form-control sportigo-select d-inline w-auto mr-2" aria-label="Default select example">
                   
					<option value="+ 60" {{($vlist->phonecode =='+ 60') ? 'selected' : '' }}>+ 60</option>
                  </select>
                </div>
                <div class="col-lg-10">
                   <input type="text" class="custom-field-2 form-control" value="{{ $vlist->whatsapp}}" name="whatsapp">
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
                  <!--<input type="text" class="form-control" value="{{ $vlist->moredetails}}" name="moredetails">!-->

                  <textarea id="moredetails" rows="8" cols="50" name="moredetails" class="form-control custom-area" placeholder="Write something.."  >{{ $vlist->moredetails }}</textarea>
               </div>
            </div>
            <!--<div class="col-lg-3">
               <div class="form-group">
                  <label for="state" class="custom-label">State</label>
                  <input type="text" class="form-control" value="{{ old('state') }}" name="state">
				  @if ($errors->has('state'))
				   <span class="text-danger">{{ $errors->first('state') }}</span>
		         @endif
               </div>
            </div>
            <div class="col-lg-3">
               <div class="form-group">
                  <label for="userid" class="custom-label">Business Category</label>
                  <input type="text" class="form-control" value="{{ old('business_category') }}" name="business_category">
				  @if ($errors->has('business_category'))
				   <span class="text-danger">{{ $errors->first('business_category') }}</span>
		         @endif
               </div>
            </div>!-->
			
			<div class="col-lg-3">
                  <div class="form-group">
                    <label for="state" class="custom-label">State</label>
                    
					<select name="state" class="form-control sportigo-select-2 d-inline w-auto mr-2" aria-label="Default select example">
						

					@foreach($allstatelist as $allstatelst)
						<option value="{{ $allstatelst->id }}" {{$vlist->state == $allstatelst->id  ? 'selected' : ''}}>{{ $allstatelst->name}}</option>
					@endforeach


									
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
                
					
						
					@foreach($allcategorieslist as $categorieslist)
						<option value="{{ $categorieslist->id }}" {{$vlist->business_category == $categorieslist->id  ? 'selected' : ''}}>{{ $categorieslist->name}}</option>
					@endforeach
					
					
					</select>
					
					
                  </div>
				  @if ($errors->has('business_category'))
				   <span class="text-danger">{{ $errors->first('business_category') }}</span>
		          @endif
				  
            </div>
				
           <!--  <div class="col-lg-4">	  
				  <div class="form-group">
                  <label for="bankname" class="custom-label">Bank Name</label>
                  <input type="text" class="form-control" value="{{ $vlist->bankname}}" name="bankname">
              </div>
				</div>

            <div class="col-lg-4">
               <div class="form-group">
                  <label for="bankacno" class="custom-label">Account No</label>
                  <input type="text" class="form-control" value="{{ $vlist->bankacno}}" name="bankacno">
               </div>
            </div>
				
            <div class="col-lg-4">
               <div class="form-group">
                  <label for="bankaccountname" class="custom-label">Account Holder Name</label>
                  <input type="text" class="form-control" value="{{ $vlist->bankaccountname}}" name="bankaccountname">
               </div>
            </div> 
      !-->     
			
            <div class="col-lg-4">
               <div class="form-group">
                  <label for="promo" class="custom-label">Promo Message</label>
                  <input type="text" class="form-control" value="{{ $vlist->promo}}" name="promo">
               </div>
            </div>


  
            <div class="col-lg-4">
               <div class="form-group">
                  <label for="userid" class="custom-label d-flex ">Gallery</label>
                  <div class="file-upload iuw1">
                    <div class="image-upload-wrap" >
                        <input class="file-upload-input" id="iuw1" type='file' name="categoryimage" onchange="readURL(this);" accept="image/*" disabled="true" />
                        <input type="hidden" name="hdn_category_image" value="myimagepath">
                        <div class="drag-text">
                          <h3>+</h3>
                        </div>
                      </div>
					 
					 @if( $vlist->image )
                                    <div class="col-xl-3 col-lg-3 col-md-3">
                                        <div class="form-group">
                                            <div class="mt-2 mb-2">
											
							<img src="{{asset($vlist->image)}}" width="100px" alt="Blog-image" />
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
               @if ($errors->has('categoryimage'))
				   <span class="text-danger">{{ $errors->first('categoryimage') }}</span>
		          @endif
            </div>
			
            <div class="col-lg-4">
                  <div class="form-group">
                     <label for="userid" class="custom-label d-flex">Sub Gallery1</label>
                     <div class="file-upload iuw2">
                     <div class="image-upload-wrap" >
                           <input class="file-upload-input" id="iuw2" type='file' name="categoryimage2" onchange="readURL(this);" accept="image/*" disabled="true" />
                           <input type="hidden" name="hdn_category_image2" value="myimagepath">
                           <div class="drag-text">
                           <h3>+</h3>
                           </div>
                        </div>
                  
                  @if( $vlist->image1 )
                                       <div class="col-xl-3 col-lg-3 col-md-3">
                                          <div class="form-group">
                                             <div class="mt-2 mb-2">
                                    
                        <img src="{{asset($vlist->image1)}}" width="100px" alt="Blog-image" />
                                             </div>
                                          </div>
                                       </div>
                  @endif  
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
                           <input class="file-upload-input" id="iuw3" type='file' name="categoryimage3" onchange="readURL(this);" accept="image/*" disabled="true"/>
                           <input type="hidden" name="hdn_category_image3" value="myimagepath">
                           <div class="drag-text">
                           <h3>+</h3>
                           </div>
                        </div>
                  
                                        @if( $vlist->image2 )
                                       <div class="col-xl-3 col-lg-3 col-md-3">
                                          <div class="form-group">
                                             <div class="mt-2 mb-2"><img src="{{asset($vlist->image2)}}" width="100px" alt="Blog-image" />
                                             </div>
                                          </div>
                                       </div>
                                       @endif  
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
                        <input class="file-upload-input" id="iuw4" type='file' name="categoryimage4" onchange="readURL(this);" accept="image/*" disabled="true"/>
                        <input type="hidden" name="hdn_category_image4" value="myimagepath">
                        <div class="drag-text">
                          <h3>+</h3>
                        </div>
                      </div>
					 
					 @if( $vlist->image3 )
                                    <div class="col-xl-3 col-lg-3 col-md-3">
                                        <div class="form-group">
                                            <div class="mt-2 mb-2">
											
							<img src="{{asset($vlist->image3)}}" width="100px" alt="Blog-image" />
                                            </div>
                                        </div>
                                    </div>
					 @endif  
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
            
            
            <div class="col-lg-4">
            
                  <input class="form-check-input" type="checkbox"  onclick="myFunction(this)" value = "Yes" name = "checkbox1" id="checkbox1">      <label for="userid" class="custom-label">Upload Gallery(Yes)</label>
                 
            </div>
	







					 
            <div class="col-lg-6">
               <div class="form-group">
                  <label for="userid" class="custom-label">Facility</label>  
               </div>
               
			   <div class="row">
			   
			        @forelse( $allfacilitylist as $allfacility )    
					
					<div class="custom-radio col-md-6 mb-2">
                     <input type="checkbox" name="Facility[]" id="{{ $allfacility->id }}" value="{{$allfacility->facility}}"
					 
					 <?php 
				
						if (in_array(trim($allfacility->facility), $facility_right_array))			
							{
								echo "checked";
							}
							
								
						  ?>
					 
					 
					 
					 >
					 
					<label class="custom-label2 d-flex align-items-center" for="{{ $allfacility->id }}"> 
					 {{$allfacility->facility}}
					 </label>
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
                  <input type="time" class="form-control" value = "{{ $vdetaillist->sundaystime}}" name="sundaystime">
                  <input type="time" class="form-control" value = "{{ $vdetaillist->sundayetime}}" name="sundayetime">
			   </div>
				
               <div class="mb-2 d-flex">
                <label class="custom-label2 min-w-76 mr-2">Monday</label>
                <input type="time" class="form-control" value = "{{ $vdetaillist->mondaystime}}" name="mondaystime">
                <input type="time" class="form-control" value = "{{ $vdetaillist->mondayetime}}" name="mondayetime">
              </div>
             
             <div class="mb-2 d-flex">
              <label class="custom-label2 min-w-76 mr-2">Tuesday</label>
              <input type="time" class="form-control" value = "{{ $vdetaillist->tuesdaystime}}" name="tuesdaystime">
              <input type="time" class="form-control" value = "{{ $vdetaillist->tuesdayetime}}" name="tuesdayetime">
            </div>
           
           <div class="mb-2 d-flex">
            <label class="custom-label2 min-w-76 mr-2">Wednesday</label>
            <input type="time" class="form-control" value = "{{ $vdetaillist->wednesdaystime}}" name="wednesdaystime">
            <input type="time" class="form-control" value = "{{ $vdetaillist->wednesdayetime}}" name="wednesdayetime">
          </div>
         
         <div class="mb-2 d-flex">
          <label class="custom-label2 min-w-76 mr-2">Thursday</label>
          <input type="time" class="form-control" value = "{{ $vdetaillist->thursdaystime}}" name="thursdaystime">
          <input type="time" class="form-control" value = "{{ $vdetaillist->thursdayetime}}" name="thursdayetime">
        </div>

        <div class="mb-2 d-flex">
          <label class="custom-label2 min-w-76 mr-2">Friday</label>
          <input type="time" class="form-control" value = "{{ $vdetaillist->fridaystime}}" name="fridaystime">
          <input type="time" class="form-control" value = "{{ $vdetaillist->fridayetime}}" name="fridayetime">
        </div>

        <div class="mb-2 d-flex">
          <label class="custom-label2 min-w-76 mr-2">Saturday</label>
          <input type="time" class="form-control" value = "{{ $vdetaillist->saturdaystime}}" name="saturdaystime">
          <input type="time" class="form-control" value = "{{ $vdetaillist->saturdayetime}}" name="saturdayetime">
        </div>

       
           

            </div>

            <!--<div class="col-lg-2">
               <div class="form-group">
                  <label for="userid" class="custom-label">Closing Days</label>  
               </div>
               <div class="mb-2">
                  <input type="date" id="closing_days1" value = "{{$vdetaillist->closing_days1}}" name="closing_days1" class="custom-field form-control">
               </div>
               <div class="mb-2">
                  <input type="date" id="closing_days2" value = "{{$vdetaillist->closing_days2}}" name="closing_days2" class="custom-field form-control">
               </div>
               <div class="mb-2">
                  <input type="date" id="closing_days3" value = "{{$vdetaillist->closing_days3}}" name="closing_days3"class="custom-field form-control">
               </div>
               <div class="mb-2">
                  <input type="date" id="closing_days4" value = "{{$vdetaillist->closing_days4}}" name="closing_days4"class="custom-field form-control">
               </div>
               <div class="mb-2">
                  <input type="date" id="closing_days5" value = "{{$vdetaillist->closing_days5}}" name="closing_days5"class="custom-field form-control">
               </div>
               <div class="mb-2">
                  <input type="date" id="closing_days6" value = "{{$vdetaillist->closing_days6}}" name="closing_days6"class="custom-field form-control">
               </div>
               <div class="mb-2">
                  <input type="date" id="closing_days7" value = "{{$vdetaillist->closing_days7}}" name="closing_days7"class="custom-field form-control">
               </div>
               <div class="mb-2">
                  <input type="date" id="closing_days8" value = "{{$vdetaillist->closing_days8}}" name="closing_days8"class="custom-field form-control">
               </div>
            </div>!-->

            <div class="col-lg-2">
               <div class="form-group">
                  <label for="userid" class="custom-label">Closing Days</label>  
               </div>
                @forelse( $vendorclosingdayslist as $vclosingdayslist)
               <div class="mb-2">
                  <input type="date" id="closing_days1" value = "{{$vclosingdayslist->closingdays}}" name="closing_days[]" class="custom-field form-control">
               </div>
               @empty 
		         @endforelse 
            </div>   

      
      </div>
		
	
       </form> 
	    @empty 
		@endforelse 
			@empty 
		@endforelse 
      
   </div>

<script>

function myFunction(c) 
{
   var checkval = c.checked;
   if(checkval==true)
   {

      document.getElementById("iuw1").disabled=false;
      document.getElementById("iuw2").disabled=false;
      document.getElementById("iuw3").disabled=false;
      document.getElementById("iuw4").disabled=false;
   }
   else
   {
      document.getElementById("iuw1").disabled=true;
      document.getElementById("iuw2").disabled=true;
      document.getElementById("iuw3").disabled=true;
      document.getElementById("iuw4").disabled=true;
   }
}

</script> 


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
