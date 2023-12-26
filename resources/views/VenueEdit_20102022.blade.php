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
		@forelse( $venuedetails as $usrlist) 
        <form action="{{ route('venueupdate',$usrlist->id)}}" method="post"  enctype="multipart/form-data">
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
                   <select name="vendor_id"  class="form-control sportigo-select-2 d-inline w-auto mr-2" aria-label="Default select example">
                
					@foreach($allvendorlist as $vendorlist)
						<option value="{{ $usrlist->vendor_id }}" {{$usrlist->vendor_id == $vendorlist->vendor_id  ? 'selected' : ''}}>{{ $vendorlist->businessname}}</option>
					@endforeach

						
					</select>
					
					
                  </div>
				  @if ($errors->has('vendor_id'))
				   <span class="text-danger">{{ $errors->first('vendor_id') }}</span>
		          @endif
				  
            </div>
			
            <div class="col-lg-4">
               <div class="form-group">
                  <label for="businessname" class="custom-label">Court Name</label>
                  <input type="text" class="form-control" value="{{ $usrlist->name}}" name="name">
				  @if ($errors->has('name'))
				   <span class="text-danger">{{ $errors->first('name') }}</span>
		         @endif
               </div>
            </div>
            
			
		  
		  
            <div class="col-lg-4">
               <div class="form-group">
                  <label for="address" class="custom-label">Court Description</label>
                  <input type="text" class="form-control" value="{{ $usrlist->courtdesc}}" name="courtdesc">
				  @if ($errors->has('courtdesc'))
				   <span class="text-danger">{{ $errors->first('courtdesc') }}</span>
		         @endif
               </div>
            </div>
			
           <div class="col-lg-4">
               <div class="form-group">
                  <label for="moredetails" class="custom-label">Special Commercial Price</label>
                  <input type="text" class="form-control" value="{{ $usrlist->courtprice}}" name="courtprice">
				  @if ($errors->has('courtprice'))
				   <span class="text-danger">{{ $errors->first('courtprice') }}</span>
		         @endif
               </div>
            </div>
			
            <div class="col-lg-4">
               <div class="form-group">
                  <label for="moredetails" class="custom-label">Normal Price</label>
                  <input type="text" class="form-control" value="{{ $usrlist->normalprice}}" name="normalprice">
				  @if ($errors->has('normalprice'))
				   <span class="text-danger">{{ $errors->first('normalprice') }}</span>
		         @endif
               </div>
            </div>
			
			
			
			<!--<div class="col-lg-4">
               <div class="form-group">
                  <label for="businessname" class="custom-label">Date</label>
                  <input type="date" id="courtdate" name="courtdate" value="{{ $usrlist->courtdate}}" class="custom-field form-control">
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
			   
			   
			   @if( $usrlist->image )
                                    <div class="col-xl-3 col-lg-3 col-md-3">
                                        <div class="form-group">
                                            <div class="mt-2 mb-2">
											
							<img src="{{asset('CourtsImages/'.$usrlist->image)}}" width="100px" alt="Blog-image" />
                                            </div>
                                        </div>
                                    </div>
					 @endif  
					 
					 
            </div>
			
			
			<!--<div class="col-lg-4">
               <div class="form-group">
                  <label for="userid" class="custom-label">Time</label>  
               </div>
			@forelse( $allvenuescourttimes as $usrlist)	
			 <div class="mb-1 d-flex">
                  <input type="time" class="form-control" value="{{ $usrlist->stime}}" name="stime[]" style="width:200px">
				  
             </div>
			@empty 
			@endforelse	
			</div>	
			
			<div class="col-lg-4">
               <div class="form-group">
                  <label for="userid" class="custom-label">Price</label>  
               </div>
			@forelse( $allvenuescourttimes as $usrlist)	
			 <div class="mb-1 d-flex">
                  
				  <input type="hidden" class="form-control" value="{{ $usrlist->id}}" name="courttimeid[]" style="width:200px">
				  <input type="textbox" class="form-control" value="{{ $usrlist->price}}" name="price[]" style="width:200px">
				  
             </div>
			@empty 
			@endforelse	
			</div>!-->

				

			<div class="col-lg-8">
               <div class="form-group">
                  <label for="userid" class="custom-label">Start Time</label>  
				  <label for="userid" class="custom-label">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;End Time</label>  
				  <label for="userid" class="custom-label">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Price</label> 
				  <label for="userid" class="custom-label">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Days</label>				  
               </div>
			 
               
			   
				<?php 
				$myaaray = array();
				?>				
				@forelse( $allvenuescourttimes as $courtlist)
				<?php
				$myaaray[$courtlist->timedesc]['stime'] = $courtlist->stime;
				$myaaray[$courtlist->timedesc]['etime'] = $courtlist->etime;
				$myaaray[$courtlist->timedesc]['price'] = $courtlist->price;
				$myaaray[$courtlist->timedesc]['days'][] = $courtlist->days;				
				$myaaray[$courtlist->timedesc]['ids'][] = $courtlist->id;
				?>
				
				
				@empty 
			    @endforelse
					
				<?php 

// echo '<pre>myaaray :: ';
// print_r($myaaray);
// echo '</pre>';
	

				for($i=1;$i<=count($myaaray);$i++){

					// foreach($myaaray[$i])

					$existing_id = $myaaray[$i]['ids'];
					$existing_days = $myaaray[$i]['days'];

					foreach($existing_id as $existing_id_key=>$existing_id_value){				
						// echo '<input type="hidden" name="existing_ids['.$existing_id_value.']['.$i.'][]" value="'.$existing_days[$existing_id_key].'">';						
						echo '<input type="hidden" name="existing_ids['.$i.']['.$existing_id_value.'][]" value="'.$existing_days[$existing_id_key].'">';						
					}
				?>
				 
			    
				<div class="mb-1 d-flex">
                  <input type="time" class="form-control" name="stime[<?php echo $i; ?>][]" value="<?php echo $myaaray[$i]['stime'] ?>" style="width:200px">
				  <input type="time" class="form-control" name="etime[<?php echo $i; ?>][]" value="<?php echo $myaaray[$i]['etime'] ?>"style="width:200px">
				  &nbsp;&nbsp;&nbsp;
				  <input type="text" class="form-control" name="price[<?php echo $i; ?>][]" value="<?php echo $myaaray[$i]['price'] ?>"style="width:200px">
				   &nbsp;&nbsp;&nbsp;<div class="form-group mb-2">		   
				   
							
						<select id="selectday<?php echo $i; ?>" name="days_name[<?php echo $i; ?>][]" class="" multiple data-live-search="true" >						   
							
							<option name="days<?php echo $i; ?>"  <?php if (in_array("Monday", $existing_days)){ echo 'selected'; } ?> value="Monday">Monday</option>
							<option name="days<?php echo $i; ?>"  <?php if (in_array("Tuesday", $existing_days)){ echo 'selected'; } ?> value="Tuesday">Tuesday </option>
							<option name="days<?php echo $i; ?>"  <?php if (in_array("Wednesday", $existing_days)){ echo 'selected'; } ?> value="Wednesday">Wednesday</option>
							<option name="days<?php echo $i; ?>"  <?php if (in_array("Thursday", $existing_days)){ echo 'selected'; } ?> value="Thursday">Thursday</option>
							<option name="days<?php echo $i; ?>"  <?php if (in_array("Friday", $existing_days)){ echo 'selected'; } ?> value="Friday">Friday</option>
							<option name="days<?php echo $i; ?>"  <?php if (in_array("Saturday", $existing_days)){ echo 'selected'; } ?> value="Saturday">Saturday</option>
							<option name="days<?php echo $i; ?>"  <?php if (in_array("Sunday", $existing_days)){ echo 'selected'; } ?> value="Sunday">Sunday</option>							

						</select>
							
				   </div>
				</div>
				<?php } ?>

			    <script>
				var a= $('#selectday1').val();
				//alert(a);	
				$('option[name=days2]').each(function() 
				{    
					if($(this).is(':selected'))
					  optval =($(this).val());
					 $("input[value="+ optval+"]").prop("checked",true);
				});
				
				</script>
				  
            </div>		



		   
			
            <div class="col-lg-6 text-right">
              <button type="submit" class="green-small mr-2 mt-5">SAVE</button>
			  <a href="{{ route('dashboard') }}"><button type="button" class="gray-small mt-5" > BACK</button></a>
          </div>
       
		
		 </form>
		@empty 
		@endforelse 
      </div>
    </div>
  
  </div>
  
  
@include('layouts.footer')  
