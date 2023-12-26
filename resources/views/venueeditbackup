
@include('layouts.head')
<body>
<div class="dash wrapper">

    @include('layouts.header')
  
    <div class="custom-border"></div>

    


    

    @forelse( $venuedetails as $usrlist) 
        <form action="{{ route('venueupdate',$usrlist->id)}}" method="post"  enctype="multipart/form-data">
          @csrf

        <input type="hidden" id = "courtid" name="courtid" value={{$usrlist->id}}>


    <div class="main-section pt-4 pb-4">
      <div class="container">
        <div class="row d-flex flex-wrap align-items-center justify-content-md-start justify-content-center mb-4">
          <!--<button type="submit" class="theme-btn mr-3">ADD NEW STAFF</button>!-->
          
		  <button type="submit" class="green-small mr-2">SAVE</button>
		  <a href="{{ route('dashboard') }}"><button type="button" class="gray-small mr-2" > BACK</button></a>
          <a href="{{route('venuelist')}}"><button type="button" class="theme-btn ">SPORT SLOT</button></a>
		  
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
                  <input type="text" class="form-control" value="{{ $usrlist->name}}" name="name" maxlength="50">
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
                        <input type="hidden" name="hdn_category_image" value="hdn_category_image">
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
											
							<img src="{{asset($usrlist->image)}}" width="100px" alt="Blog-image" />
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

                <?php 
				 $mydaysarray = array();
				 ?>				
				 @forelse( $alldays as $key => $adays)
				 <?php
				   $mydaysarray[$key]['dayname'] = $adays->dayname;				
				 ?>
				
				
				@empty 
			    @endforelse
            
                @if(isset($id2))
                   
                @endif
               

            <div class="row">
           
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <div>	  
                        <div class="form-group">
                            <label for="state" class="custom-label">Select Days</label>
                             <select name="dayname"  id=  "dayname" class="form-control sportigo-select-2 d-inline w-auto mr-2" aria-label="Default select example">
                             
                             @foreach($alldays as $adays)
                             @if(isset($id2))
                             <option value="{{ $adays->dayname }}" {{ $id2 == $adays->dayname  ? 'selected' : ''}}>{{ $adays->dayname}}</option>
                             @else
                             <option value="{{ $adays->dayname }}">{{ $adays->dayname}}</option>
                             @endif
						     @endforeach
                                
                            </select>
                            
                            
                        </div>
                       
                        
                    </div>
                    

                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <div>	  
                        <div class="form-group">
                            <label for="state" class="custom-label"></label>
                            <br>
                            <input type="button" name="search" value="Search" class="green-small mr-2" onclick="venuesorting();">
                            
                            
                        </div>
                       
                        
                    </div>

                </div>
                
          </div>




			<div class="col-lg-8 timefield">
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
			   
				<?php 
				$myaaray = array();
				?>				
				@forelse( $allvenuescourttimes as $key => $courtlist)
				<?php
				$myaaray[$key]['stime'] = $courtlist->stime;
				$myaaray[$key]['etime'] = $courtlist->etime;
				$myaaray[$key]['price'] = $courtlist->price;
				$myaaray[$key]['days'][] = $courtlist->days;				
				$myaaray[$key]['ids'][] = $courtlist->id;
				?>
				
				
				@empty 
			    @endforelse
					
				<?php 






// echo '<pre>myaaray :: ';
// print_r($myaaray);
// echo '</pre>';
	

				// for($i=1;$i<=count($myaaray);$i++)ssss{

                for($i=0;$i<count($myaaray);$i++){


					// foreach($myaaray[$i])

					$existing_id = $myaaray[$i]['ids'];
					$existing_days = $myaaray[$i]['days'];

					foreach($existing_id as $existing_id_key=>$existing_id_value){				
						// echo '<input type="hidden" name="existing_ids['.$existing_id_value.']['.$i.'][]" value="'.$existing_days[$existing_id_key].'">';						
						echo '<input type="hidden" name="existing_ids['.$i.']['.$existing_id_value.'][]" value="'.$existing_days[$existing_id_key].'">';						

                        // echo '<input type="hidden" name="existing_ids['.$i.']['.$existing_id_value.'][]" value="'.$existing_id_value.'">';						
                        echo '<input type="hidden" name="is_update['.$existing_id_value.']" id="existing_ids_'.$existing_id_value.'" value="0">';						
                        echo '<input type="hidden" name="is_update_amount['.$existing_id_value.']" id="existing_amount_'.$existing_id_value.'" value="0">';						
                        echo '<input type="hidden" name="existing_ids_data[]" value="'.$existing_id_value.'">';						



					}
				?>
				 
			    
				<div class="mb-1 d-flex">
                  <input type="time" disabled class="form-control" name="stime[<?php echo $i; ?>][]" value="<?php echo $myaaray[$i]['stime'] ?>" style="width:200px">
				  <input type="time" disabled class="form-control" name="etime[<?php echo $i; ?>][]" value="<?php echo $myaaray[$i]['etime'] ?>"style="width:200px">
				  &nbsp;&nbsp;&nbsp;
				  <input type="text" class="form-control" onkeyup="update_amount(this,'<?php echo $myaaray[$i]['price'] ?>','<?php echo $existing_id_value; ?>')" name="price[<?php echo $i; ?>][]" value="<?php echo $myaaray[$i]['price'] ?>"style="width:200px">
				   &nbsp;&nbsp;&nbsp;<div class="form-group mb-2">		   
				   
							
						<!--<select id="selectday<?php echo $i; ?>" class="d-none" name="days_name[<?php echo $i; ?>][]" disabled multiple data-live-search="true" >						   
							<option name="days<?php echo $i; ?>"  <?php if (in_array("Monday", $existing_days)){ echo 'selected'; } ?> value="Monday">Monday</option>
							<option name="days<?php echo $i; ?>"  <?php if (in_array("Tuesday", $existing_days)){ echo 'selected'; } ?> value="Tuesday">Tuesday </option>
							<option name="days<?php echo $i; ?>"  <?php if (in_array("Wednesday", $existing_days)){ echo 'selected'; } ?> value="Wednesday">Wednesday</option>
							<option name="days<?php echo $i; ?>"  <?php if (in_array("Thursday", $existing_days)){ echo 'selected'; } ?> value="Thursday">Thursday</option>
							<option name="days<?php echo $i; ?>"  <?php if (in_array("Friday", $existing_days)){ echo 'selected'; } ?> value="Friday">Friday</option>
							<option name="days<?php echo $i; ?>"  <?php if (in_array("Saturday", $existing_days)){ echo 'selected'; } ?> value="Saturday">Saturday</option>
							<option name="days<?php echo $i; ?>"  <?php if (in_array("Sunday", $existing_days)){ echo 'selected'; } ?> value="Sunday">Sunday</option>							
                        </select>!-->
                        
						  <div class="multiselect dropdown selectday<?php echo $i; ?>">
                            <button type="button" class="form-control text-left dropdown-toggle" style="width:150px">
                                
                            <?php if (in_array("Monday", $existing_days)){ echo '<a tabindex="0" class="multiItem"><label> Monday</label></a>'; } ?>
                            <?php if (in_array("Tuesday", $existing_days)){ echo '<a tabindex="0" class="multiItem"><label> Tuesday</label></a>'; } ?>
                            <?php if (in_array("Wednesday", $existing_days)){ echo '<a tabindex="0" class="multiItem"><label> Wednesday</label></a>'; } ?>
                            <?php if (in_array("Thursday", $existing_days)){ echo '<a tabindex="0" class="multiItem"><label> Thursday</label></a>'; } ?>
                            <?php if (in_array("Friday", $existing_days)){ echo '<a tabindex="0" class="multiItem"><label> Friday</label></a>'; } ?>
                            <?php if (in_array("Saturday", $existing_days)){ echo '<a tabindex="0" class="multiItem"><label> Saturday</label></a>'; } ?>
                            <?php if (in_array("Sunday", $existing_days)){ echo '<a tabindex="0" class="multiItem"><label> Sunday</label></a>'; } ?>




                            </button>
                            
                           
                            

                            
                           

                            <!--<div class="dropdown-menu p-0">
                                <ul>
                                    <li>
                                        <a tabindex="0" class="multiItem"><input type="checkbox" name="sport1" value="multiselect-all"><label class="checkbox" > Select All</label></a>
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
                              </div>!-->



                        </div>
				   </div>
				</div>
				<?php } ?>
                
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
                        
                        var checkboxes = $('#'+filedid+' option:selected').length;
                        $("."+filedid+" .dropdown-toggle").html("Selected ("+checkboxes+")");
        
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
				  
            </div>		



		   
			
     <!--       <div class="col-lg-6 text-right">-->
     <!--         <button type="submit" class="green-small mr-2 mt-5">SAVE</button>-->
			  <!--<a href="{{ route('dashboard') }}"><button type="button" class="gray-small mt-5" > BACK</button></a>-->
     <!--     </div>-->
       
		
		 </form>
		@empty 
		@endforelse 
      </div>
    </div>
  
  </div>
  

<script>
function update_amount(enterval,originalprice,rowid){
    var amountvalue = $(enterval).val();
    if(amountvalue != originalprice){
        $("#existing_ids_"+rowid).val(1);
        $("#existing_amount_"+rowid).val(amountvalue)
    }else{
        $("#existing_ids_"+rowid).val(0);
        $("#existing_amount_"+rowid).val(originalprice)
    }  
}

function venuesorting()
 {

  
    var txtcourtid = document.getElementById("courtid").value; 
	var txtdays = document.getElementById("dayname").value;
   
    var url = "{{route('venuesearch',['',''])}}" +"/"+txtcourtid+"/"+txtdays ;
    window.location.href=url;
  }
  
  
</script>


</script>



  
@include('layouts.footer')  
