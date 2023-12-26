@include('layouts.head')
<body>
<div class="dash wrapper">

    @include('layouts.header')
  
    <div class="custom-border"></div>
  
    <div class="main-section pt-4 pb-4">
      <div class="container">
        <div class="row d-flex align-items-center justify-content-start mb-4">
          <!--<button type="submit" class="theme-btn mr-3">ADD NEW STAFF</button>!-->
          <a href="{{route('venuelist')}}"><button type="button" class="theme-btn">SPORT LOT</button></a>
		  
		  
        </div>
        <form action="{{ route('venuesadd')}}" method="post"  enctype="multipart/form-data">
          @csrf 
		  
		  @if(Session::has('success'))
			<div class="alert alert-success text-center mt-3 mb-3">
				<span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
				 {{ Session::get('success') }}
			</div> 
		 @endif
		 
		
          
          <div class="row">
           
		   <div class="col-lg-4">	  
				  <div class="form-group">
                    <label for="state" class="custom-label">Business Name</label>
                   <select name="vendor_id" class="form-control sportigo-select-2 d-inline w-auto mr-2" aria-label="Default select example">
                
					@forelse( $allvendorlist as $vendorlist )    
						<option value="{{ $vendorlist->vendor_id }}"> {{ $vendorlist->businessname }} </option>
					@empty 

					@endforelse 
					</select>
					
					
                  </div>
				  @if ($errors->has('vendor_id'))
				   <span class="text-danger">{{ $errors->first('vendor_id') }}</span>
		          @endif
				  
            </div>
			
			
            <div class="col-lg-4">
               <div class="form-group">
                  <label for="businessname" class="custom-label">Court Name</label>
                  <input type="text" class="form-control" value="{{ old('name') }}" name="name">
				  @if ($errors->has('name'))
				   <span class="text-danger">{{ $errors->first('name') }}</span>
		         @endif
               </div>
            </div>
            
			
		  
		  
            <div class="col-lg-4">
               <div class="form-group">
                  <label for="address" class="custom-label">Court Description</label>
                  <input type="text" class="form-control" value="{{ old('courtdesc') }}" name="courtdesc">
				  @if ($errors->has('courtdesc'))
				   <span class="text-danger">{{ $errors->first('courtdesc') }}</span>
		         @endif
               </div>
            </div>
			
            <div class="col-lg-4">
               <div class="form-group">
                  <label for="description" class="custom-label">Special Commercial Price</label>
                  <input type="text" class="form-control" value="{{ old('courtprice') }}" name="courtprice">
				  @if ($errors->has('courtprice'))
				   <span class="text-danger">{{ $errors->first('courtprice') }}</span>
		         @endif
               </div>
            </div>
			
            
			
			<div class="col-lg-4">
               <div class="form-group">
                  <label for="moredetails" class="custom-label">Normal Price</label>
                  <input type="text" class="form-control" value="{{ old('normalprice') }}" name="normalprice">
				  @if ($errors->has('normalprice'))
				   <span class="text-danger">{{ $errors->first('normalprice') }}</span>
		         @endif
               </div>
            </div>
			
		   <!--<div class="col-lg-4">
               <div class="form-group">
                  <label for="businessname" class="custom-label">Date</label>
                  <input type="date" id="courtdate" name="courtdate"class="custom-field form-control">
				  @if ($errors->has('courtdate'))
				   <span class="text-danger">{{ $errors->first('courtdate') }}</span>
		         @endif
               </div>
            </div>!-->
			
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
				  @if ($errors->has('categoryimage'))
				   <span class="text-danger">{{ $errors->first('categoryimage') }}</span>
		         @endif					
               </div>
            </div>
			<div class="row">
			<div class="col-lg-4">
               <div class="form-group">
                <label for="state" class="custom-label">&nbsp;&nbsp;&nbsp;Days</label>
			   </div>
			 </div>  
			</div>  
			 <!--<div class="row">
              
		       <div class="custom-radio  mb-2">
			      <div class="custom-radio">
					<input type="checkbox" name="days[]" id="Monday" value="Monday">
                     <label class="custom-label2 d-flex align-items-center" for="Monday">Monday</label>
				  </div>	 
			   
			   </div>
			   
			   <div class="custom-radio  mb-2">
			      <div class="custom-radio">
					<input type="checkbox" name="days[]" id="Tuesday" value="Tuesday">
                     <label class="custom-label2 d-flex align-items-center" for="Tuesday">Tuesday </label>
				  </div>	 
			   </div>
			   
			   <div class="custom-radio  mb-2">
			      <div class="custom-radio">
					<input type="checkbox" name="days[]" id="Wednesday" value="Wednesday">
                     <label class="custom-label2 d-flex align-items-center" for="Wednesday">Wednesday </label>
				  </div>	 
			   </div>
			   
			   <div class="custom-radio  mb-2">
			      <div class="custom-radio">
					<input type="checkbox" name="days[]" id="Thursday" value="Thursday">
                     <label class="custom-label2 d-flex align-items-center" for="Thursday">Thursday </label>
				  </div>	 
			   </div>
			   
			   <div class="custom-radio mb-2">
			      <div class="custom-radio">
					 <input type="checkbox" name="days[]" id="Friday" value="Friday">
                     <label class="custom-label2 d-flex align-items-center" for="Friday">Friday </label>
				  </div>	 
			   </div>
			   
			   <div class="custom-radio  mb-2">
			      <div class="custom-radio">
					 <input type="checkbox" name="days[]" id="Saturday" value="Saturday">
                     <label class="custom-label2 d-flex align-items-center" for="Saturday">Saturday </label>
				  </div>	 
			   </div>
			   
			   <div class="custom-radio  mb-2">
			      <div class="custom-radio">
					<input type="checkbox" name="days[]" id="Sunday" value="Sunday">
                     <label class="custom-label2 d-flex align-items-center" for="Sunday">Sunday </label>
				  </div>	 
			   </div>
			  
			  <div class="custom-radio  mb-2">
			      <div class="custom-radio">
					<input type="checkbox" name="days[]" id="All" value="All" onclick='selects()' >
                     <label class="custom-label2 d-flex align-items-center" for="All">All Days </label>
				  </div>	 
			   </div>
			   
			 </div> !--> 
			
			<!--<div class="row">
			
			<div class="custom-radio">
			
					 <input type="checkbox" name="days[]" id="Monday" value="Monday">
                     <label class="custom-label2 d-flex align-items-center" for="Monday">Monday</label>
					 
					 <input type="checkbox" name="days[]" id="Tuesday" value="Tuesday">
                     <label class="custom-label2 d-flex align-items-center" for="Tuesday">Tuesday </label>
					 
					 <input type="checkbox" name="days[]" id="Wednesday" value="Wednesday">
                     <label class="custom-label2 d-flex align-items-center" for="Wednesday">Wednesday </label>
					 
					 <input type="checkbox" name="days[]" id="Thursday" value="Thursday">
                     <label class="custom-label2 d-flex align-items-center" for="Thursday">Thursday </label>
					 
					 <input type="checkbox" name="days[]" id="Friday" value="Friday">
                     <label class="custom-label2 d-flex align-items-center" for="Friday">Friday </label>
					 
					 <input type="checkbox" name="days[]" id="Saturday" value="Saturday">
                     <label class="custom-label2 d-flex align-items-center" for="Saturday">Saturday </label>
					 
					 <input type="checkbox" name="days[]" id="Sunday" value="Sunday">
                     <label class="custom-label2 d-flex align-items-center" for="Sunday">Sunday </label>
					 
					 <input type="checkbox" name="days[]" id="All" value="All">
                     <label class="custom-label2 d-flex align-items-center" for="All">All Days </label>
					 
			</div></div>!-->
			
			
			
			<div class="col-lg-8">
               <div class="form-group">
                  <label for="userid" class="custom-label">Start Time</label>  
				  <label for="userid" class="custom-label">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;End Time</label>  
				  <label for="userid" class="custom-label">
				  &nbsp;&nbsp;&nbsp;
				  &nbsp;&nbsp;&nbsp;
				  
				  Price</label> &nbsp;&nbsp;&nbsp;&nbsp;

				<label for="state" class="custom-label">Days</label>				  
               </div>
			 
               
			   <div class="mb-1 d-flex">
			   
                  <input type="time" class="form-control" name="stime[]" style="width:200px">
				  <input type="time" class="form-control" name="etime[]" style="width:200px">
				  &nbsp;&nbsp;&nbsp;<input type="text" class="form-control" name="price[]" style="width:150px">
				  <div class="form-group mb-2">
                    
						   <select name="vendor_name[]" multiple data-live-search="true" class="form-control sportigo-select d-inline w-auto mr-2" aria-label="Default select example">
							<option name="days[]" value="Monday">Monday</option>
								<option name="days[]" value="Tuesday">Tuesday </option>
								<option name="days[]" value="Wednesday">Wednesday</option>
								<option name="days[]" value="Thursday">Thursday</option>
								<option name="days[]" value="Friday">Friday</option>
								<option name="days[]" value="Saturday">Saturday</option>
								<option name="days[]" value="Sunday">Sunday</option>
							
						    </select>
				   </div>
			   </div>
			    @if ($errors->has('price'))
				   <span class="text-danger">{{ $errors->first('price') }}</span>
		         @endif	
			   <div class="mb-1 d-flex">
                  <input type="time" class="form-control" name="stime[]" style="width:200px">
				  <input type="time" class="form-control" name="etime[]" style="width:200px">
				  &nbsp;&nbsp;&nbsp;
				  <input type="text" class="form-control" name="price[]" style="width:150px">
				   <div class="form-group">
                    
						  
				   </div>
				</div>
			   
			  
			   
			   
			   
			   <div class="mb-1 d-flex">
                  <input type="time" class="form-control" name="stime[]" style="width:200px">
				  <input type="time" class="form-control" name="etime[]" style="width:200px">
				  &nbsp;&nbsp;&nbsp;<input type="text" class="form-control" name="price[]" style="width:150px">
			   </div>
			   <div class="mb-1 d-flex">
                  <input type="time" class="form-control" name="stime[]" style="width:200px">
				  <input type="time" class="form-control" name="etime[]" style="width:200px">
				  &nbsp;&nbsp;&nbsp;<input type="text" class="form-control" name="price[]" style="width:150px">
			   </div>
			   <div class="mb-1 d-flex">
                  <input type="time" class="form-control" name="stime[]" style="width:200px">
				  <input type="time" class="form-control" name="etime[]" style="width:200px">
				  &nbsp;&nbsp;&nbsp;<input type="text" class="form-control" name="price[]" style="width:150px">
			   </div>
			   <div class="mb-1 d-flex">
                  <input type="time" class="form-control" name="stime[]" style="width:200px">
				  <input type="time" class="form-control" name="etime[]" style="width:200px">
				  &nbsp;&nbsp;&nbsp;<input type="text" class="form-control" name="price[]" style="width:150px">
			   </div>
			   <div class="mb-1 d-flex">
                  <input type="time" class="form-control" name="stime[]" style="width:200px">
				  <input type="time" class="form-control" name="etime[]" style="width:200px">
				  &nbsp;&nbsp;&nbsp;<input type="text" class="form-control" name="price[]" style="width:150px">
			   </div>
			   <div class="mb-1 d-flex">
                  <input type="time" class="form-control" name="stime[]" style="width:200px">
				  <input type="time" class="form-control" name="etime[]" style="width:200px">
				  &nbsp;&nbsp;&nbsp;<input type="text" class="form-control" name="price[]" style="width:150px">
			   </div>
			   <div class="mb-1 d-flex">
                  <input type="time" class="form-control" name="stime[]" style="width:200px">
				  <input type="time" class="form-control" name="etime[]" style="width:200px">
				  &nbsp;&nbsp;&nbsp;<input type="text" class="form-control" name="price[]" style="width:150px">
			   </div>
				  
            </div>				
									 
				
								  
			
			
			
            <div class="col-lg-6 text-right">
              <button type="submit" class="green-small mr-2 mt-5">SAVE</button>
			  <a href="{{ route('dashboard') }}"><button type="button" class="gray-small mt-5" > BACK</button></a>
			  
            </div>
          </div>
       
		
		 </form>
      </div>
    </div>
  
  </div>
 
<script type="text/javascript">  
   function selects(){  
   var ele=document.getElementsByName('days');  
                for(var i=0; i<ele.length; i++){  
                    if(ele[i].type=='checkbox')  
                        ele[i].checked=true;  
                }  
   }
</script>
 
  
@include('layouts.footer')  

 
 
 