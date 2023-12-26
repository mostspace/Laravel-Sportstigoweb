@include('layouts.head')
<body>

<div class="dash wrapper">
	
   @include('layouts.header')

  <div class="custom-border">
  </div>

  <div class="main-section pt-4 pb-4">
    <div class="container">
      <div class="boxes row">
        <div class="col-md-4 p-0">
          <div class="black-box">
            <div><span class="main-text">Booking</span></div>
            <div><span class="sub-text">Book Your Sports</span></div>
          </div>
        </div>
        <div class="col-md-4 p-0">
          <div class="black-box">
            <div class="steptext"><span class="main-text">SELECT DATE</span></div>
          </div>
        </div>
      </div>

      <section class="signup-step-container">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-md-12">
                    <div class="wizard">
                        <div class="form-stepper wizard-inner">
                            <!-- <div class="connecting-line"></div> -->
                            <ul class="nav nav-tabs align-items-center" role="tablist">
                                <li role="presentation" class="active">
                                    <a href="#step1" data-toggle="tab" aria-controls="step1" role="tab" aria-expanded="true"><span class="round-tab"></span> <i>Select Date</i></a>
                                </li>
                                <li role="presentation" class="disabled">
                                    <a href="#step2" data-toggle="tab" aria-controls="step2" role="tab" aria-expanded="false"><span class="round-tab"></span> <i>Select Court</i></a>
                                </li>
                                <li role="presentation" class="disabled">
                                    <a href="#step3" data-toggle="tab" aria-controls="step3" role="tab"><span class="round-tab"></span> <i>Select Time</i></a>
                                </li>
                                <li role="presentation" class="disabled">
                                    <a href="#step4" data-toggle="tab" aria-controls="step4" role="tab"><span class="round-tab"></span> <i>Booking Info</i></a>
                                </li>
                                <li role="presentation" class="disabled">
                                    <a href="#step5" data-toggle="tab" aria-controls="step5" role="tab"><span class="round-tab"></span> <i>Payment</i></a>
                                </li>
                            </ul>
                        </div>
        
                        <form role="form" action="#">
                            <div class="tab-content" id="main_form">
                              <div class="tab-pane active" role="tabpanel" id="step1">
                                <div class="row">
                                  <div class="col-md-8">
                                    <div id="datepicker" class="calendar"></div><div></div>
                                  </div>
                                  <div class="col-md-4 mt-5">
                                    <ul class="list-inline text-left">
                                        <li><button type="button" class="green-btn next-step step-date">NEXT</button></li>
                                    </ul>
                                  </div>
                                </div>
                              </div>
							  
							
							 
							 
							 
							 
							  
                              <div class="tab-pane" role="tabpanel" id="step2">
                                <div class="row">
                                  <div class="col-lg-8">
                                    
									@foreach($courtdetails as $courtdtls)
									<div class="bs-box d-flex align-items-center justify-content-around mb-4">
                                      <div class="d-flex align-items-center selectcourt{{$courtdtls->id}}">
										@if( $courtdtls->image )
									   <div class="bs-imgbox">
											<img src="{{asset('CourtsImages/'.$courtdtls->image)}}" width="50px" height="50px"  alt="Blog-image" />
                                        </div>
										@endif  
                                        <div class="bs-title ml-2">
                                          <h4 class="cname">{{$courtdtls->name}}</h4>
                                          <span class="ph">{{$courtdtls->courtdesc}}</span>
										  <span class="cprice">{{$courtdtls->price}}</span>
                                        </div>
                                      </div>
									    
										@if( ($courtdtls->bookstatus == 0) )	
										<div class="custom-timebox courtbox">
										  <input type="radio" name="courtname" id="selectcourt{{$courtdtls->id}}">
										  <label class="custom-label d-flex align-items-center" for="selectcourt{{$courtdtls->id}}">Select</label>
										</div>											
                                       <!--<button type="submit" class="gray-btn">Select</button>!-->
									   @else
									   <!--<button type="submit" class="red-btn">Full</button>!-->
								         <div class="custom-timebox courtbox">
										  <input type="radio" name="courtname" id="selectfull{{$courtdtls->id}}" class="booked">
										  <label class="custom-label d-flex align-items-center" for="selectfull{{$courtdtls->id}}">Select</label>
										</div>
										@endif  
                                    </div>
                                    @endforeach
									<!--<div class="bs-box d-flex align-items-center justify-content-around mb-4">
                                      <div class="d-flex align-items-center">
                                        <div class="bs-imgbox">
                                          <img src="img/box1.png">
                                        </div>
                                        <div class="bs-title ml-2">
                                          <h4>Court 1</h4>
                                          <span class="ph">RM 100 / Per Hour</span>
                                        </div>
                                      </div> 
                                      <button type="checkbox" class="gray-btn">Select</button>
                                    </div>
                                    <div class="bs-box d-flex align-items-center justify-content-around">
                                      <div class="d-flex align-items-center">
                                        <div class="bs-imgbox">
                                          <img src="img/box1.png">
                                        </div>
                                        <div class="bs-title ml-2">
                                          <h4>Court 1</h4>
                                          <span class="ph">RM 100 / Per Hour</span>
                                        </div>
                                      </div> 
                                      <button type="submit" class="red-btn">Full</button>
                                    </div>!-->
									
                                  </div>
                                  <div class="col-lg-4">
                                    <ul class="list-inline pull-right">
                                      <li><button type="button" class="green-btn next-step step-court">NEXT</button></li>
                                      <li><button type="button" class="green-btn prev-step mt-3">BACK</button></li>
                                    </ul>
                                  </div>
                                </div>
                              </div>
							  
							  
							 
							  
							  
							  
							  
							  
							  
							  
							  
							  
                              <div class="tab-pane" role="tabpanel" id="step3">
                               <div class="row">
                                <div class="col-lg-8">
                                  <div class="d-flex flex-wrap align-items-center justify-content-center">
                                    
									@foreach($vendortimedetails as $vendortimedtls)
									
									
									<?php if($vendortimedtls->sundaystime==NULL)
									{
									?>
										<div class="custom-timebox timebox">
										  <input type="radio" name="timebox" id="timebox9" class="booked">
										  <label class="custom-label d-flex align-items-center" for="timebox9">11:30pm</label>
										</div> 
									<?php									 
									}
								   else
								   {
									  ?>
									  <div class="custom-timebox timebox">
                                      <input type="radio" name="timebox" id="sundaystime">
                                      <label class="custom-label d-flex align-items-center sundaystime" for="sundaystime">
									  <?php echo date("g:ia", strtotime($vendortimedtls->sundaystime)); ?>
									  </label>
                                      </div>
									  <?php
									   
								   }  
							        ?>
									
									
									<?php if($vendortimedtls->mondaystime==NULL)
									{
									?>
										<div class="custom-timebox timebox">
										  <input type="radio" name="timebox" id="timebox9" class="booked">
										  <label class="custom-label d-flex align-items-center" for="timebox9">11:30pm</label>
										</div> 
									<?php									 
									}
								   else
								   {
									  ?>
									  <div class="custom-timebox timebox">
                                      <input type="radio" name="timebox" id="mondaystime">
                                      <label class="custom-label d-flex align-items-center mondaystime" for="mondaystime">
									  <?php echo date("g:ia", strtotime($vendortimedtls->mondaystime)); ?>
									  </label>
                                      </div>
									  <?php
									   
								   }  
							        ?>
									
									<?php if($vendortimedtls->tuesdaystime==NULL)
									{
									?>
										<div class="custom-timebox timebox">
										  <input type="radio" name="timebox" id="timebox9" class="booked">
										  <label class="custom-label d-flex align-items-center" for="timebox9">11:30pm</label>
										</div> 
									<?php									 
									}
								   else
								   {
									  ?>
									  <div class="custom-timebox timebox">
                                      <input type="radio" name="timebox" id="tuesdaystime">
                                      <label class="custom-label d-flex align-items-center tuesdaystime" for="tuesdaystime">
									  <?php echo date("g:ia", strtotime($vendortimedtls->tuesdaystime)); ?>
									  </label>
                                      </div>
									  <?php
									   
								   }  
							        ?>
									
									<?php if($vendortimedtls->wednesdaystime==NULL)
									{
									?>
										<div class="custom-timebox timebox">
										  <input type="radio" name="timebox" id="timebox9" class="booked">
										  <label class="custom-label d-flex align-items-center" for="timebox9">11:30pm</label>
										</div> 
									<?php									 
									}
								   else
								   {
									  ?>
									  <div class="custom-timebox timebox">
                                      <input type="radio" name="timebox" id="wednesdaystime">
                                      <label class="custom-label d-flex align-items-center wednesdaystime" for="wednesdaystime">
									  <?php echo date("g:ia", strtotime($vendortimedtls->wednesdaystime)); ?>
									  </label>
                                      </div>
									  <?php
									   
								   }  
							        ?>
									
									<?php if($vendortimedtls->thursdaystime==NULL)
									{
									?>
										<div class="custom-timebox timebox">
										  <input type="radio" name="timebox" id="timebox9" class="booked">
										  <label class="custom-label d-flex align-items-center" for="timebox9">11:30pm</label>
										</div> 
									<?php									 
									}
								   else
								   {
									  ?>
									  <div class="custom-timebox timebox">
                                      <input type="radio" name="timebox" id="thursdaystime">
                                      <label class="custom-label d-flex align-items-center thursdaystime" for="thursdaystime">
									  <?php echo date("g:ia", strtotime($vendortimedtls->thursdaystime)); ?>
									  </label>
                                      </div>
									  <?php
									   
								   }  
							        ?>
									
									
									<?php if($vendortimedtls->fridaystime==NULL)
									{
									?>
										<div class="custom-timebox timebox">
										  <input type="radio" name="timebox" id="timebox9" class="booked">
										  <label class="custom-label d-flex align-items-center" for="timebox9">11:30pm</label>
										</div> 
									<?php									 
									}
								   else
								   {
									  ?>
									  <div class="custom-timebox timebox">
                                      <input type="radio" name="timebox" id="fridaystime">
                                      <label class="custom-label d-flex align-items-center fridaystime" for="fridaystime">
									  <?php echo date("g:ia", strtotime($vendortimedtls->fridaystime)); ?>
									  </label>
                                      </div>
									  <?php
									   
								   }  
							        ?>
									
									<?php if($vendortimedtls->saturdaystime==NULL)
									{
									?>
										<div class="custom-timebox timebox">
										  <input type="radio" name="timebox" id="timebox9" class="booked">
										  <label class="custom-label d-flex align-items-center" for="timebox9">11:30pm</label>
										</div> 
									<?php									 
									}
								   else
								   {
									  ?>
									  <div class="custom-timebox timebox">
                                      <input type="radio" name="timebox" id="saturdaystime">
                                      <label class="custom-label d-flex align-items-center saturdaystime" for="saturdaystime">
									  <?php echo date("g:ia", strtotime($vendortimedtls->saturdaystime)); ?>
									  </label>
                                      </div>
									  <?php
									   
								   }  
							        ?>
									
									
                                    @endforeach
									<div class="custom-timebox timebox">
										  <input type="radio" name="timebox" id="timebox9" class="booked">
										  <label class="custom-label d-flex align-items-center" for="timebox9">11:30pm</label>
										</div>
										<div class="custom-timebox">
										  <input type="radio" name="timebox" id="timebox9" class="booked">
										  <label class="custom-label d-flex align-items-center" for="timebox9">11:45pm</label>
										</div>
                                    <!--<div class="custom-timebox">
                                      <input type="checkbox" name="timebox" id="timebox3" checked>
                                      <label class="custom-label d-flex align-items-center" for="timebox3">12:30</label>
                                    </div>     
                                    <div class="custom-timebox">
                                      <input type="checkbox" name="timebox" id="timebox4">
                                      <label class="custom-label d-flex align-items-center" for="timebox4">01:30</label>
                                    </div>
                                    <div class="custom-timebox">
                                      <input type="checkbox" name="timebox" id="timebox5" checked>
                                      <label class="custom-label d-flex align-items-center" for="timebox5">02:30</label>
                                    </div>
                                    <div class="custom-timebox">
                                      <input type="checkbox" name="timebox" id="timebox6">
                                      <label class="custom-label d-flex align-items-center" for="timebox6">03:30</label>
                                    </div>      
                                    <div class="custom-timebox">
                                      <input type="checkbox" name="timebox" id="timebox7" checked>
                                      <label class="custom-label d-flex align-items-center" for="timebox7">04:30</label>
                                    </div>
                                    <div class="custom-timebox">
                                      <input type="checkbox" name="timebox" id="timebox8">
                                      <label class="custom-label d-flex align-items-center" for="timebox8">05:30</label>
                                    </div>
                                    <div class="custom-timebox">
                                      <input type="checkbox" name="timebox" id="timebox9" class="booked">
                                      <label class="custom-label d-flex align-items-center" for="timebox9">06:30</label>
                                    </div> !-->                        
                                  </div>                                
                                </div>     
                                <div class="col-lg-4">
                                      <ul class="list-inline pull-right">
                                        <li><button type="button" class="green-btn next-step step-time">NEXT</button></li>
                                        <li><button type="button" class="green-btn prev-step mt-3">BACK</button></li>
                                      </ul>
                                </div>  
                                </div>
                              </div>
                              <div class="tab-pane" role="tabpanel" id="step4">
                                 <div class="row">
                                  <div class="col-lg-8 text-center">
                                    <div>
                                      <div class="form-group">
                                        <label for="userid">Enter Mobile No</label>
                                        <input type="text" class="form-control" name="mobile" id="mobile">
                                      </div>
                                    </div>
                                    <div>
                                      <p class="text-black"><b>TO RECEIVE BOOKING DETAILS<br>
                                      RECORDS, KINDLY ENTER MOBILE NO<br>
                                      WHICH REGISTERED WITH<br>
                                      SPORTSTIGO. MOBILE APP</b></p>
                                    </div>
                                  </div>
                                  <div class="col-lg-4">
                                    <ul class="list-inline pull-right">
                                      <li><button type="button" class="green-btn next-step step-info">NEXT</button></li>
                                      <li><button type="button" class="green-btn prev-step mt-3">BACK</button></li>
                                    </ul>
                                  </div> 
                                </div>
                              </div>
                              <div class="tab-pane" role="tabpanel" id="step5">
                                <div class="row">
                                  <div class="col-lg-8">
                                    <div class="bs">
                                      <h6>Booking Summary :</h6>
                                      <p>Venue Name : Skudai D Sport Center</p>
                                      <div class="custom-border mb-3 mt-3"></div>
                                      <h6 class="selcname">Court No 1:</h6>
                                      <p>Checkin Date /Time : <span class="seltime">12.30PM </span>/ <span class="bgText cid"></span></p>
                                      <p>Checkout Date / Time : <span class="seltime">12.30PM </span>/ <span class="bgText cod"></span></p>
                                      <p class="text-green selcprice">RM 115.00</p>
									  <input type="hidden" name="court" class="cnameval" />
									  <input type="hidden" name="checkin_date" class="ccival"/>
									  <input type="hidden" name="checkout_date" class="ccdval"//>
									  <input type="hidden" name="Price" class="cpriceval"//>
                                    </div>
                                  </div>
                                  <div class="col-lg-4">
                                    <ul class="list-inline pull-right">
                                      <li><button type="submit" class="green-btn step-payment">PAY ON MOBILE</button></li>
                                      <li><button type="submit" class="green-btn mt-3">PAY AT COUNTER</button></li>
                                    </ul>
                                  </div> 
                                </div>
                              </div>
                              <div class="clearfix"></div>
                            </div>
                            
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

 </div>
 </div>

</div>



 @include('layouts.footer')