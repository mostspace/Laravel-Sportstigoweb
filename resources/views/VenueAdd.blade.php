@include('layouts.head')
<body>
<div class="dash wrapper">

    @include('layouts.header')
  
    <div class="custom-border"></div>
    <form action="{{ route('venuesadd')}}" method="post"  enctype="multipart/form-data">
          @csrf 
    <div class="main-section pt-4 pb-4">
      <div class="container">
        <div class="row d-flex flex-wrap align-items-center justify-content-md-start justify-content-center mb-4">
          <!--<button type="submit" class="theme-btn mr-3">ADD NEW STAFF</button>!-->
          
		  <button type="submit" class="green-small mr-2 mb-2">SAVE</button>
	      <a href="{{ route('dashboard') }}"><button type="button" class="gray-small mr-2" > BACK</button></a>
          <a href="{{route('venuelist')}}"><button type="button" class="theme-btn">Court / Slot Details</button></a>
		  
        </div>
        
		  
		  @if(Session::has('success'))
			<div class="alert alert-success text-center mt-3 mb-3">
				<span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
				 {{ Session::get('success') }}
			</div> 
		 @endif
		 
		
          
          <div class="row">
           
		   <div class="col-lg-4">	  
				  <div class="form-group">
                    <label for="state" class="custom-label">Sports Setting For</label>
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
                  <label for="businessname" class="custom-label">Court / Slot Name</label>
                  <input type="text" class="form-control" value="{{ old('name') }}" name="name" maxlength="50">
				  @if ($errors->has('name'))
				   <span class="text-danger">{{ $errors->first('name') }}</span>
		         @endif
               </div>
            </div>
            
			
		  
		  
            <div class="col-lg-4">
               <div class="form-group">
                  <label for="address" class="custom-label">Court / Slot Description</label>
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
			
			
			<br><br><br><br><br><br><br><br>
			<!--<div class="col-lg-8 timefield">
               <div class="form-group">
                  <label for="userid" class="custom-label">Start Time</label>  
				  <label for="userid" class="custom-label">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;End Time</label>  
				  <label for="userid" class="custom-label">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Price</label> 
				  <label for="userid" class="custom-label">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Days</label>				  
                
               </div>
			 
               
               
               <div align="right">
               @if ($errors->has('days_name'))
				            <span class="text-danger">{{ $errors->first('days_name') }}</span>
		                    @endif   
             </div>
				 
			   <div class="mb-1 d-flex">
                  <input type="time" class="form-control" name="stime[1][]" style="width:200px">
				  <input type="time" class="form-control" name="etime[1][]" style="width:200px">
				  &nbsp;&nbsp;&nbsp;
				  <input type="text" class="form-control" name="price[1][]" style="width:200px">
				   &nbsp;&nbsp;&nbsp;<div class="form-group mb-2">
                   
						   <select id="selectday1" name="days_name[1][]"  class="d-none" multiple data-live-search="true" >
							    <option name="days[1]" value="Monday">Monday</option>
								<option name="days[1]" value="Tuesday">Tuesday </option>
								<option name="days[1]" value="Wednesday">Wednesday</option>
								<option name="days[1]" value="Thursday">Thursday</option>
								<option name="days[1]" value="Friday">Friday</option>
								<option name="days[1]" value="Saturday">Saturday</option>
								<option name="days[1]" value="Sunday">Sunday</option>
						   </select>
						   <div class="multiselect dropdown selectday1">
                            <button type="button" class="form-control text-left dropdown-toggle" data-toggle="dropdown" style="width:150px">
                             Select
                            </button>
                            <div class="dropdown-menu p-0">
                                <ul>
                                    <li>
                                        <a tabindex="0" class="multiItem"><input type="checkbox" name="sport" value="multiselect-all"><label class="checkbox"> Select All</label></a>
                                    </li>
                                    <li>
                                        <a tabindex="0" class="multiItem"><input type="checkbox" name="sport" value="Monday"><label class="checkbox"> Monday</label></a>
                                    </li>
                                    <li>
                                        <a tabindex="0" class="multiItem"><input type="checkbox" name="sport" value="Tuesday"><label class="checkbox"> Tuesday</label></a>
                                    </li>
                                    <li>
                                        <a tabindex="0" class="multiItem"><input type="checkbox" name="sport" value="Wednesday"><label class="checkbox"> Wednesday</label></a>
                                    </li>
                                    <li>
                                        <a tabindex="0" class="multiItem"><input type="checkbox" name="sport" value="Thursday"><label class="checkbox"> Thursday</label></a>
                                    </li>
                                    <li>
                                        <a tabindex="0" class="multiItem"><input type="checkbox" name="sport" value="Friday"><label class="checkbox">Friday</label></a>
                                    </li>
                                    <li>
                                        <a tabindex="0" class="multiItem"><input type="checkbox" name="sport" value="Saturday"><label class="checkbox"> Saturday</label></a>
                                    </li>
                                    <li>
                                        <a tabindex="0" class="multiItem"><input type="checkbox" name="sport" value="Sunday"><label class="checkbox"> Sunday</label></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
				   </div>
				</div>
			   
               
			   
			   
			   <div class="mb-1 d-flex">
                  <input type="time" class="form-control" name="stime[2][]" style="width:200px">
				  <input type="time" class="form-control" name="etime[2][]" style="width:200px">
				  &nbsp;&nbsp;&nbsp;<input type="text" class="form-control" name="price[2][]" style="width:200px">
				   &nbsp;&nbsp;&nbsp;<div class="form-group mb-2">
                   
						   <select id="selectday2" name="days_name[2][]"  class="d-none" multiple data-live-search="true" >
							    <option name="days[2]" value="Monday">Monday</option>
								<option name="days[2]" value="Tuesday">Tuesday </option>
								<option name="days[2]" value="Wednesday">Wednesday</option>
								<option name="days[2]" value="Thursday">Thursday</option>
								<option name="days[2]" value="Friday">Friday</option>
								<option name="days[2]" value="Saturday">Saturday</option>
								<option name="days[2]" value="Sunday">Sunday</option>
								
							
						    </select>
						    <div class="multiselect dropdown selectday2">
                            <button type="button" class="form-control text-left dropdown-toggle" data-toggle="dropdown" style="width:150px">
                             Select
                            </button>
                            <div class="dropdown-menu p-0">
                                <ul>
                                    <li>
                                        <a tabindex="0" class="multiItem"><input type="checkbox" name="sport" value="multiselect-all"><label class="checkbox"> Select All</label></a>
                                    </li>
                                    <li>
                                        <a tabindex="0" class="multiItem"><input type="checkbox" name="sport" value="Monday"><label class="checkbox"> Monday</label></a>
                                    </li>
                                    <li>
                                        <a tabindex="0" class="multiItem"><input type="checkbox" name="sport" value="Tuesday"><label class="checkbox"> Tuesday</label></a>
                                    </li>
                                    <li>
                                        <a tabindex="0" class="multiItem"><input type="checkbox" name="sport" value="Wednesday"><label class="checkbox"> Wednesday</label></a>
                                    </li>
                                    <li>
                                        <a tabindex="0" class="multiItem"><input type="checkbox" name="sport" value="Thursday"><label class="checkbox"> Thursday</label></a>
                                    </li>
                                    <li>
                                        <a tabindex="0" class="multiItem"><input type="checkbox" name="sport" value="Friday"><label class="checkbox">Friday</label></a>
                                    </li>
                                    <li>
                                        <a tabindex="0" class="multiItem"><input type="checkbox" name="sport" value="Saturday"><label class="checkbox"> Saturday</label></a>
                                    </li>
                                    <li>
                                        <a tabindex="0" class="multiItem"><input type="checkbox" name="sport" value="Sunday"><label class="checkbox"> Sunday</label></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
				   </div>
			   </div>
			   
			   
			   <div class="mb-1 d-flex">
                  <input type="time" class="form-control" name="stime[3][]" style="width:200px">
				  <input type="time" class="form-control" name="etime[3][]" style="width:200px">
				  &nbsp;&nbsp;&nbsp;<input type="text" class="form-control" name="price[3][]" style="width:200px">
				   &nbsp;&nbsp;&nbsp;<div class="form-group mb-2">
                   
						    <select id="selectday3" name="days_name[3][]"  class="d-none" multiple data-live-search="true" >
							   <option name="days[3]" value="Monday">Monday</option>
								<option name="days[3]" value="Tuesday">Tuesday </option>
								<option name="days[3]" value="Wednesday">Wednesday</option>
								<option name="days[3]" value="Thursday">Thursday</option>
								<option name="days[3]" value="Friday">Friday</option>
								<option name="days[3]" value="Saturday">Saturday</option>
								<option name="days[3]" value="Sunday">Sunday</option>
							</select>


                           
			   

							<div class="multiselect dropdown selectday3">
                            <button type="button" class="form-control text-left dropdown-toggle" data-toggle="dropdown" style="width:150px">
                             Select
                            </button>
                            <div class="dropdown-menu p-0">
                                <ul>
                                    <li>
                                        <a tabindex="0" class="multiItem"><input type="checkbox" name="sport" value="multiselect-all"><label class="checkbox"> Select All</label></a>
                                    </li>
                                    <li>
                                        <a tabindex="0" class="multiItem"><input type="checkbox" name="sport" value="Monday"><label class="checkbox"> Monday</label></a>
                                    </li>
                                    <li>
                                        <a tabindex="0" class="multiItem"><input type="checkbox" name="sport" value="Tuesday"><label class="checkbox"> Tuesday</label></a>
                                    </li>
                                    <li>
                                        <a tabindex="0" class="multiItem"><input type="checkbox" name="sport" value="Wednesday"><label class="checkbox"> Wednesday</label></a>
                                    </li>
                                    <li>
                                        <a tabindex="0" class="multiItem"><input type="checkbox" name="sport" value="Thursday"><label class="checkbox"> Thursday</label></a>
                                    </li>
                                    <li>
                                        <a tabindex="0" class="multiItem"><input type="checkbox" name="sport" value="Friday"><label class="checkbox">Friday</label></a>
                                    </li>
                                    <li>
                                        <a tabindex="0" class="multiItem"><input type="checkbox" name="sport" value="Saturday"><label class="checkbox"> Saturday</label></a>
                                    </li>
                                    <li>
                                        <a tabindex="0" class="multiItem"><input type="checkbox" name="sport" value="Sunday"><label class="checkbox"> Sunday</label></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
				   </div>
			   </div>
			   
			   
			   <div class="mb-1 d-flex">
                  <input type="time" class="form-control" name="stime[4][]" style="width:200px">
				  <input type="time" class="form-control" name="etime[4][]" style="width:200px">
				  &nbsp;&nbsp;&nbsp;<input type="text" class="form-control" name="price[4][]" style="width:200px">
				   &nbsp;&nbsp;&nbsp;<div class="form-group mb-2">
                   
						  <select id="selectday4" name="days_name[4][]"  class="d-none" multiple data-live-search="true" >
							    <option name="days[4]" value="Monday">Monday</option>
								<option name="days[4]" value="Tuesday">Tuesday </option>
								<option name="days[4]" value="Wednesday">Wednesday</option>
								<option name="days[4]" value="Thursday">Thursday</option>
								<option name="days[4]" value="Friday">Friday</option>
								<option name="days[4]" value="Saturday">Saturday</option>
								<option name="days[4]" value="Sunday">Sunday</option>
								
							
						    </select>
						    <div class="multiselect dropdown selectday4">
                            <button type="button" class="form-control text-left dropdown-toggle" data-toggle="dropdown" style="width:150px">
                             Select
                            </button>
                            <div class="dropdown-menu p-0">
                                <ul>
                                    <li>
                                        <a tabindex="0" class="multiItem"><input type="checkbox" name="sport" value="multiselect-all"><label class="checkbox"> Select All</label></a>
                                    </li>
                                    <li>
                                        <a tabindex="0" class="multiItem"><input type="checkbox" name="sport" value="Monday"><label class="checkbox"> Monday</label></a>
                                    </li>
                                    <li>
                                        <a tabindex="0" class="multiItem"><input type="checkbox" name="sport" value="Tuesday"><label class="checkbox"> Tuesday</label></a>
                                    </li>
                                    <li>
                                        <a tabindex="0" class="multiItem"><input type="checkbox" name="sport" value="Wednesday"><label class="checkbox"> Wednesday</label></a>
                                    </li>
                                    <li>
                                        <a tabindex="0" class="multiItem"><input type="checkbox" name="sport" value="Thursday"><label class="checkbox"> Thursday</label></a>
                                    </li>
                                    <li>
                                        <a tabindex="0" class="multiItem"><input type="checkbox" name="sport" value="Friday"><label class="checkbox">Friday</label></a>
                                    </li>
                                    <li>
                                        <a tabindex="0" class="multiItem"><input type="checkbox" name="sport" value="Saturday"><label class="checkbox"> Saturday</label></a>
                                    </li>
                                    <li>
                                        <a tabindex="0" class="multiItem"><input type="checkbox" name="sport" value="Sunday"><label class="checkbox"> Sunday</label></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
				   </div>
			   </div>
			   
			   
			   <div class="mb-1 d-flex">
                  <input type="time" class="form-control" name="stime[5][]" style="width:200px">
				  <input type="time" class="form-control" name="etime[5][]" style="width:200px">
				  &nbsp;&nbsp;&nbsp;<input type="text" class="form-control" name="price[5][]" style="width:200px">
				   &nbsp;&nbsp;&nbsp;<div class="form-group mb-2">
                   
						   <select id="selectday5" name="days_name[5][]"  class="d-none" multiple data-live-search="true" >
							    <option name="days[5]" value="Monday">Monday</option>
								<option name="days[5]" value="Tuesday">Tuesday </option>
								<option name="days[5]" value="Wednesday">Wednesday</option>
								<option name="days[5]" value="Thursday">Thursday</option>
								<option name="days[5]" value="Friday">Friday</option>
								<option name="days[5]" value="Saturday">Saturday</option>
								<option name="days[5]" value="Sunday">Sunday</option>
								
							
						    </select>
						    <div class="multiselect dropdown selectday5">
                            <button type="button" class="form-control text-left dropdown-toggle" data-toggle="dropdown" style="width:150px">
                             Select
                            </button>
                            <div class="dropdown-menu p-0">
                                <ul>
                                    <li>
                                        <a tabindex="0" class="multiItem"><input type="checkbox" name="sport" value="multiselect-all"><label class="checkbox"> Select All</label></a>
                                    </li>
                                    <li>
                                        <a tabindex="0" class="multiItem"><input type="checkbox" name="sport" value="Monday"><label class="checkbox"> Monday</label></a>
                                    </li>
                                    <li>
                                        <a tabindex="0" class="multiItem"><input type="checkbox" name="sport" value="Tuesday"><label class="checkbox"> Tuesday</label></a>
                                    </li>
                                    <li>
                                        <a tabindex="0" class="multiItem"><input type="checkbox" name="sport" value="Wednesday"><label class="checkbox"> Wednesday</label></a>
                                    </li>
                                    <li>
                                        <a tabindex="0" class="multiItem"><input type="checkbox" name="sport" value="Thursday"><label class="checkbox"> Thursday</label></a>
                                    </li>
                                    <li>
                                        <a tabindex="0" class="multiItem"><input type="checkbox" name="sport" value="Friday"><label class="checkbox">Friday</label></a>
                                    </li>
                                    <li>
                                        <a tabindex="0" class="multiItem"><input type="checkbox" name="sport" value="Saturday"><label class="checkbox"> Saturday</label></a>
                                    </li>
                                    <li>
                                        <a tabindex="0" class="multiItem"><input type="checkbox" name="sport" value="Sunday"><label class="checkbox"> Sunday</label></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
				   </div>
			   </div>
			   
			   
			   <div class="mb-1 d-flex">
                  <input type="time" class="form-control" name="stime[6][]" style="width:200px">
				  <input type="time" class="form-control" name="etime[6][]" style="width:200px">
				  &nbsp;&nbsp;&nbsp;<input type="text" class="form-control" name="price[6][]" style="width:200px">
				   &nbsp;&nbsp;&nbsp;<div class="form-group mb-2">
                   
						 <select id="selectday6" name="days_name[6][]"  class="d-none" multiple data-live-search="true" >
							    <option name="days[6]" value="Monday">Monday</option>
								<option name="days[6]" value="Tuesday">Tuesday </option>
								<option name="days[6]" value="Wednesday">Wednesday</option>
								<option name="days[6]" value="Thursday">Thursday</option>
								<option name="days[6]" value="Friday">Friday</option>
								<option name="days[6]" value="Saturday">Saturday</option>
								<option name="days[6]" value="Sunday">Sunday</option>
								
							
						    </select>
						    <div class="multiselect dropdown selectday6">
                            <button type="button" class="form-control text-left dropdown-toggle" data-toggle="dropdown" style="width:150px">
                             Select
                            </button>
                            <div class="dropdown-menu p-0">
                                <ul>
                                    <li>
                                        <a tabindex="0" class="multiItem"><input type="checkbox" name="sport" value="multiselect-all"><label class="checkbox"> Select All</label></a>
                                    </li>
                                    <li>
                                        <a tabindex="0" class="multiItem"><input type="checkbox" name="sport" value="Monday"><label class="checkbox"> Monday</label></a>
                                    </li>
                                    <li>
                                        <a tabindex="0" class="multiItem"><input type="checkbox" name="sport" value="Tuesday"><label class="checkbox"> Tuesday</label></a>
                                    </li>
                                    <li>
                                        <a tabindex="0" class="multiItem"><input type="checkbox" name="sport" value="Wednesday"><label class="checkbox"> Wednesday</label></a>
                                    </li>
                                    <li>
                                        <a tabindex="0" class="multiItem"><input type="checkbox" name="sport" value="Thursday"><label class="checkbox"> Thursday</label></a>
                                    </li>
                                    <li>
                                        <a tabindex="0" class="multiItem"><input type="checkbox" name="sport" value="Friday"><label class="checkbox">Friday</label></a>
                                    </li>
                                    <li>
                                        <a tabindex="0" class="multiItem"><input type="checkbox" name="sport" value="Saturday"><label class="checkbox"> Saturday</label></a>
                                    </li>
                                    <li>
                                        <a tabindex="0" class="multiItem"><input type="checkbox" name="sport" value="Sunday"><label class="checkbox"> Sunday</label></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
				   </div>
			   </div>
			   
			   
			   <div class="mb-1 d-flex">
                  <input type="time" class="form-control" name="stime[7][]" style="width:200px">
				  <input type="time" class="form-control" name="etime[7][]" style="width:200px">
				  &nbsp;&nbsp;&nbsp;<input type="text" class="form-control" name="price[7][]" style="width:200px">
				   &nbsp;&nbsp;&nbsp;<div class="form-group mb-2">
                   
						   <select id="selectday7" name="days_name[7][]"  class="d-none" multiple data-live-search="true" >
							    <option name="days[7]" value="Monday">Monday</option>
								<option name="days[7]" value="Tuesday">Tuesday </option>
								<option name="days[7]" value="Wednesday">Wednesday</option>
								<option name="days[7]" value="Thursday">Thursday</option>
								<option name="days[7]" value="Friday">Friday</option>
								<option name="days[7]" value="Saturday">Saturday</option>
								<option name="days[7]" value="Sunday">Sunday</option>
								
							
						    </select>
						    <div class="multiselect dropdown selectday7">
                            <button type="button" class="form-control text-left dropdown-toggle" data-toggle="dropdown" style="width:150px">
                             Select
                            </button>
                            <div class="dropdown-menu p-0">
                                <ul>
                                    <li>
                                        <a tabindex="0" class="multiItem"><input type="checkbox" name="sport" value="multiselect-all"><label class="checkbox"> Select All</label></a>
                                    </li>
                                    <li>
                                        <a tabindex="0" class="multiItem"><input type="checkbox" name="sport" value="Monday"><label class="checkbox"> Monday</label></a>
                                    </li>
                                    <li>
                                        <a tabindex="0" class="multiItem"><input type="checkbox" name="sport" value="Tuesday"><label class="checkbox"> Tuesday</label></a>
                                    </li>
                                    <li>
                                        <a tabindex="0" class="multiItem"><input type="checkbox" name="sport" value="Wednesday"><label class="checkbox"> Wednesday</label></a>
                                    </li>
                                    <li>
                                        <a tabindex="0" class="multiItem"><input type="checkbox" name="sport" value="Thursday"><label class="checkbox"> Thursday</label></a>
                                    </li>
                                    <li>
                                        <a tabindex="0" class="multiItem"><input type="checkbox" name="sport" value="Friday"><label class="checkbox">Friday</label></a>
                                    </li>
                                    <li>
                                        <a tabindex="0" class="multiItem"><input type="checkbox" name="sport" value="Saturday"><label class="checkbox"> Saturday</label></a>
                                    </li>
                                    <li>
                                        <a tabindex="0" class="multiItem"><input type="checkbox" name="sport" value="Sunday"><label class="checkbox"> Sunday</label></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
				   </div>
			   </div>
			   
			   
			   <div class="mb-1 d-flex">
                  <input type="time" class="form-control" name="stime[8][]" style="width:200px">
				  <input type="time" class="form-control" name="etime[8][]" style="width:200px">
				  &nbsp;&nbsp;&nbsp;<input type="text" class="form-control" name="price[8][]" style="width:200px">
				   &nbsp;&nbsp;&nbsp;<div class="form-group mb-2">
                   
						   <select id="selectday8" name="days_name[8][]"  class="d-none" multiple data-live-search="true" >
							    <option name="days[8]" value="Monday">Monday</option>
								<option name="days[8]" value="Tuesday">Tuesday </option>
								<option name="days[8]" value="Wednesday">Wednesday</option>
								<option name="days[8]" value="Thursday">Thursday</option>
								<option name="days[8]" value="Friday">Friday</option>
								<option name="days[8]" value="Saturday">Saturday</option>
								<option name="days[8]" value="Sunday">Sunday</option>
								
							
						    </select>
						    <div class="multiselect dropdown selectday8">
                            <button type="button" class="form-control text-left dropdown-toggle" data-toggle="dropdown" style="width:150px">
                             Select
                            </button>
                            <div class="dropdown-menu p-0">
                                <ul>
                                    <li>
                                        <a tabindex="0" class="multiItem"><input type="checkbox" name="sport" value="multiselect-all"><label class="checkbox"> Select All</label></a>
                                    </li>
                                    <li>
                                        <a tabindex="0" class="multiItem"><input type="checkbox" name="sport" value="Monday"><label class="checkbox"> Monday</label></a>
                                    </li>
                                    <li>
                                        <a tabindex="0" class="multiItem"><input type="checkbox" name="sport" value="Tuesday"><label class="checkbox"> Tuesday</label></a>
                                    </li>
                                    <li>
                                        <a tabindex="0" class="multiItem"><input type="checkbox" name="sport" value="Wednesday"><label class="checkbox"> Wednesday</label></a>
                                    </li>
                                    <li>
                                        <a tabindex="0" class="multiItem"><input type="checkbox" name="sport" value="Thursday"><label class="checkbox"> Thursday</label></a>
                                    </li>
                                    <li>
                                        <a tabindex="0" class="multiItem"><input type="checkbox" name="sport" value="Friday"><label class="checkbox">Friday</label></a>
                                    </li>
                                    <li>
                                        <a tabindex="0" class="multiItem"><input type="checkbox" name="sport" value="Saturday"><label class="checkbox"> Saturday</label></a>
                                    </li>
                                    <li>
                                        <a tabindex="0" class="multiItem"><input type="checkbox" name="sport" value="Sunday"><label class="checkbox"> Sunday</label></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
				   </div>
			   </div>
			   
				  
            </div>			!-->	
									 
				
								  
			
			
			
     <!--       <div class="col-lg-6 text-right">-->
     <!--         <button type="submit" class="green-small mr-2 mt-5">SAVE</button>-->
			  <!--<a href="{{ route('dashboard') }}"><button type="button" class="gray-small mt-5" > BACK</button></a>-->
			  
     <!--       </div>-->
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

<style>
    .multiselect .multiItem{
        position: relative;
        display: flex;
        align-items: center;  
        padding: 8px 10px;
        color: #495057;
    }
    .multiselect .multiItem:hover{
        background: #ced4da;
    }
    .multiselect .multiItem label{
        width:100%;
        margin:0;
        line-height: 18px;
        display:flex;
        position:relative;
    }
    .multiselect input[type=checkbox] {
        position: absolute;
        height: 100%;
        width: 100%;
        display:block;
        margin: 0;
        opacity:0;
        left:0;
        z-index:1;
    }
    .multiselect input[type=checkbox]:before,.multiselect input[type=checkbox]:after{
        display:none;
    }
    .multiItem label.checkbox:before { 
        content:" ";
        height: 16px;
        width: 16px;
        border: 1px solid #999;
        left: 0px;
        top: 9px;
        background-color: #fff;
        border-radius: 2px;
        display:block!important;
        margin-right:12px;
    }
    .multiItem label.checkbox:after {
        content:" ";
        position:absolute;
        height: 5px;
        width: 9px;
        left: 3px;
        top: 4px;
    }
    .multiselect input[type=checkbox]:checked + label:before {
        background-color: #18ba60;
        border-color: #18ba60;
    }
    .multiselect input[type=checkbox]:checked + label:after {
        content: "";
        border-left: 1px solid #fff;
        border-bottom: 1px solid #fff;
        transform: rotate(-45deg);
    }
</style>
<script>
$('.timefield select').each(function() 
{    
    var filedid = $(this).attr('id');
    var myString= $('#'+filedid).val();
    $("input[name='sport']").each(function() {
       $("."+filedid+" input[type='checkbox'").map(function () { 
            myString.includes($(this).val()) ? $(this).prop('checked', true) : $(this).prop('checked', false) 
        });
        $("."+filedid+" input[type='checkbox'").change(function(){
            var checkboxess = $('#'+filedid+' option:selected').length;
            $("."+filedid+" .dropdown-toggle").html("Selected ("+checkboxess+")");
                            
            var inputval = $(this).val();
            if ((inputval=="multiselect-all") && ($('.'+filedid + ' input[value="multiselect-all"').prop('checked')==false)){
                 $('.'+filedid + ' input').prop("checked", false);
                $('#'+filedid + ' option').removeAttr("selected");
            }
            
            
            if (($(this).prop('checked')==false) && ($('.'+filedid + ' input[value="multiselect-all"').prop('checked')==false)){ 
                $('#'+filedid + ' option[value="'+ inputval + '"]').removeAttr("selected");
            }
            else{
                $('#'+filedid + ' option[value="'+ inputval + '"]').attr("selected","");
                    $('#'+filedid + ' option[value="multiselect-all"]').removeAttr("selected");
                    $('.'+filedid + ' input[value="multiselect-all"]').prop("checked", false);
                if(inputval=="multiselect-all"){
                 $('.'+filedid + ' input').prop("checked", true);
                 $('#'+filedid + ' option').attr("selected","");
                }
               
            }
            
            
        });
    });
    
});
</script>
  
@include('layouts.footer')  

 
 
 