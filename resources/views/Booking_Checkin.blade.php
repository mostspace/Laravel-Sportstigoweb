@include('layouts.head')
<body>
<?php $pageheading ='CHECKIN'; ?>
<div class="dash wrapper">

  @include('layouts.header')

  @if (session('success'))
  <div class="alert alert-success" role="alert">
      {{ session('success') }}
  </div>
@endif

<div class="dash wrapper">

  <!--<div class="header pt-4 pb-4">
    <div class="header-1 container-fluid text-right">
      <div class="logo-box">
        <img src="img/logo.png">
      </div>
      <div>
        <span class="sub-logo">Administration Panel 1.0</span>
      </div>
      <div>
        <span class="logged">Logged As De Sports Center  </span>
      </div>
      <div class="header-main-title text-left">
        <h2>CHECKIN</h2>
      </div>
    </div>
  </div> !-->

  <div class="custom-border">
  </div>

  <div class="main-section pt-4 pb-4">
    <div class="container">
      <div class="row">
        <div class="col-md-4 p-0">
		<a href="{{route('bookingsales')}}">
          <div class="black-box">
            <div><span class="main-text">POS</span></div>
            <div><span class="sub-text">Book Your Sports</span></div>
          </div>
		  </a>
        </div>
        <div class="col-md-4 p-0">
		<a href="{{route('bookingcheck')}}">
          <div class="black-box">
            <div><span class="main-text">CHECK BOOKING</span></div>
            <div><span class="sub-text">check Booking Status</span></div>
          </div>
		</a>  
        </div>
        <div class="col-md-4 p-0">
        <a href="{{route('bookingqrcodecheck')}}">
          <div class="black-box">
            <div><span class="main-text">CHECKIN</span></div>
            <div><span class="sub-text">Checkin with QR code</span></div>
          </div>
        </a>
        </div>
		<div class="col-md-4 p-0">
		<a href="{{route('dashboard')}}">
        <div class="black-box w-auto">
          <div><span class="main-text">BACK HOME</span></div>
          <div><span class="sub-text2">BACK TO MAIN MENU</span></div>
        </div>
		</a>
      </div>
      </div>
    </div>
  </div>

  <div class="custom-border">
  </div>


</div>


@include('layouts.footer')