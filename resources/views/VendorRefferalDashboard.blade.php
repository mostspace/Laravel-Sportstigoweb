@include('layouts.head')
<body>
<?php $pageheading ='Sales Agent Dashboard'; ?>
<div class="dash wrapper">

  @include('layouts.header')

  @if (session('success'))
  <div class="alert alert-success" role="alert">
      {{ session('success') }}
  </div>
@endif

<div class="dash wrapper">

  
  <div class="custom-border">
  </div>

  <div class="main-section pt-4 pb-4">
    <div class="container">
      <div class="row align-items-center justify-content-center">
          <div class="col-md-3">
		  <a href="{{route('vendorrefferalprofile')}}">
          <div class="black-box">
            <div><span class="main-text">PROFILE</span></div>
            <div><span class="sub-text">Manage Profile</span></div>
          </div></a>
        </div>
        
        <div class="col-md-3">
          
          <a href="{{route('vendorreport')}}">
          <div class="black-box">
            <div><span class="main-text">SALES REPORT</span></div>
            <div><span class="sub-text">Vendor Booking</span></div>
          </div></a>
        </div>   
        
        


        <div class="col-md-3">
		 <a href="{{route('vendoraddwithdrawal')}}">
        <div class="black-box">
          <div><span class="main-text">WITHDRAWAL</span></div>
          <div><span class="sub-text">Withdraw Sales Commision</span></div>
        </div>
      </div>
      </div>
      <div class="row align-items-center justify-content-center">
         
       </div>
	  
	  <div class="row align-items-center justify-content-center">
          <div class="col-md-3">
		&nbsp;
        </div>
        
          <div class="col-md-3">
         &nbsp;
        </div>
        
       
        <div class="col-md-3">
		<a href="{{route('vendor.index')}}">
        <div class="black-box">
          <div><span class="main-text">VENDOR</span></div>
          <div><span class="sub-text">Register New Vendor</span></div>
        </div></a>
      </div>
	  
	  <div class="col-md-3">
         <div class="black-box">
          <div><span class="main-text text-red"> <a class="main-text text-red" href="#" onclick="document.getElementById('logout-form').submit();">LoGOUT</a>  </span></div>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
			{{ csrf_field() }}
			</form>
		  <div><span class="sub-text">Logout from System</span></div>
        </div>
        </div>
		
		
      </div>
	  
	  
	  
	  
	  
    </div>
  </div>

  <div class="custom-border">
  </div>


</div>
@include('layouts.footer')

