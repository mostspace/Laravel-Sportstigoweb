@include('layouts.head')
<body>
<div class="dash wrapper">

    @include('layouts.header')
  
    <div class="custom-border"></div>
  
    <div class="main-section pt-4 pb-4">
      <div class="container">
        <div class="row d-flex align-items-center justify-content-start mb-4">
          <!--<button type="submit" class="theme-btn mr-3">ADD NEW STAFF</button>!-->
          <a href="{{route('spotsslotlist')}}"><button type="button" class="theme-btn">SPORT SLOT LIST</button></a>
		  
		  
        </div>
		@forelse( $sportsslotpricesdetails as $sprtlist) 
        <form action="{{ route('sportslotupdate',$sprtlist->slot_id )}}" method="post"  enctype="multipart/form-data">
          @csrf 
		  
		  @if(Session::has('success'))
			<div class="alert alert-success text-center mt-3 mb-3">
				<span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
				 {{ Session::get('success') }}
			</div> 
		  @endif	
		 
		 <div class="row" style="align-items: center;">
            <div class="col-md-12 dynamic-field mt-5" id="dynamic-field-1">
                <div class="row mb-3">
                    <div class="col-md-5">
                        <div class="row align-items-center">
                            <div class="col-md-6 p-0 text-right">
                                <label for="packagename" class="custom-label mr-2">Sport Slot Name:</label>
                            </div>
                            <div class="col-md-6 p-0">
                                <input type="text" class="custom-field form-control d-inline" value="{{ $sprtlist->slotname }}" name="slotname">
								@if ($errors->has('slotname'))
								<span class="text-danger">{{ $errors->first('slotname') }}</span>
								@endif
                            </div>
							
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="row align-items-center">
                            <div class="col-md-6 p-0 text-right">
                                <label for="packagename" class="custom-label mr-2">Status:</label>
                            </div>
                            <div class="col-md-6 p-0">
                                <select class="form-control sportigo-select d-inline w-auto mr-2" aria-label="Default select example" name="status" value="{{ old('status') }}">
            <option value="1" {{($sprtlist->status =='1') ? 'selected' : '' }}>Open for Booking</option>  
			<option value="0" {{($sprtlist->status =='0') ? 'selected' : '' }}>Close</option> 
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-5">
                        <div class="row align-items-center">
                            <div class="col-md-6 p-0 text-right">
                                <label for="packagename" class="custom-label mr-2">Sport Slot Short Descriptions:</label>
                            </div>
                            <div class="col-md-6 p-0">
                                <textarea id="slotdesc" name="slotdesc" class="form-control d-inline slot-area" placeholder="Max 60 character" >{{$sprtlist->slotdesc}}</textarea>
							    @if ($errors->has('slotdesc'))
								<span class="text-danger">{{ $errors->first('slotdesc') }}</span>
								@endif	
                            </div>
							
                        </div>
						
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5">
                        <div class="row align-items-center">
                            <div class="col-md-6 p-0 text-right">
                                <label for="packagename" class="custom-label mr-2">Sport Slot Original Price:</label>
                            </div>
                            <div class="col-md-6 p-0">
                                <input type="text" class="custom-field form-control d-inline" value="{{ $sprtlist->original_price }}" name="original_price">
								@if ($errors->has('original_price'))
								<span class="text-danger">{{ $errors->first('original_price') }}</span>
								@endif
                            </div>
							
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="row">
                            <div class="col-md-7">
                                <div class="form-group">
                                  <label for="packagediscountprice2" class="custom-label mr-2">Sport Slot Discount Price:</label>
                                  <input type="text" class="custom-field w-170 form-control d-inline" value="{{ $sprtlist->discount_price  }}" name="discount_price">
								  
                                </div>
                            </div>
                            <div class="col-md-5 p-0">
                                <div class="form-group">
                                    
								<div class="mb-2 d-flex">
								  <input type="time" class="form-control" value="{{ $sprtlist->stime  }}"  name="stime">
									
								  <input type="time" class="form-control" value="{{ $sprtlist->etime  }}"  name="etime">
									
							   </div>	
									@if ($errors->has('stime'))
									<span class="text-danger">{{ $errors->first('stime') }}</span>
									@endif <br>
									@if ($errors->has('etime'))
									<span class="text-danger">{{ $errors->first('etime') }}</span>
									@endif
									<!--<select class="form-control sportigo-select d-inline w-auto mr-2" aria-label="Default select example">
                                        <option selected>7:00 AM</option>
                                        <option value="1">8:00 AM</option>
                                        <option value="2">9:00 AM</option>
                                        <option value="3">10:00 AM</option>
                                    </select>
                                    <select class="form-control sportigo-select d-inline w-auto" aria-label="Default select example">
                                        <option selected>8:00 AM</option>
                                        <option value="1">9:00 AM</option>
                                        <option value="2">10:00 AM</option>
                                        <option value="3">11:00 AM</option>
                                    </select>!-->
                                </div>
								
                            </div>
                        </div>
                    </div>
                </div>
                
                
           </div>
           
            <!--<div class="col-md-12 mt-4 append-buttons">
              <div class="clearfix">            
                <button type="button" id="add-button" class="addrow float-left "><i class="fa fa-plus fa-fw"></i>Add More</button>
                <button type="button" id="remove-button" class="removerow float-left ml-3" disabled="disabled"><i class="fa fa-minus fa-fw"></i>Remove</button>
              </div>
            </div>!-->
        
            <div class="col-md-12 mt-4 mb-5">
              <button type="submit" class="theme-btn">SAVE</button>
            </div>
            
       </div>
          
         
       
		
		 </form>
		 @empty 
		@endforelse 
      </div>
    </div>
  
  </div>
  
  
@include('layouts.footer')  