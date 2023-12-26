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
      <div class="boxes row ">
        <div class="col-md-4 ml-0">
          <div class="black-box">
            <div><span class="main-text">Booking</span></div>
            <div><span class="sub-text">Book Your Sports</span></div>
          </div>
        </div>        
      </div>
    </div>
    <div class="custom-border mt-4"></div>
  <div class="container">
      <div class="row text-center">
        <div class="col-lg-12 mt-4 mb-2">          
            <h2 class="text-center"><strong>THANK YOU</strong></h2>
            <a href="{{route('bookingcheck')}}"> <button type="submit" class="booking-btn mt-3 mb-3">Booking No: {{$maxbookingno}}</button></a>
            <p class="text-black"><strong>Kindly Request Client to Login Sportstigo App and Make Payment.<br>Booking Status only will beConfirmed Once Payment is made/Successfull! </strong></p>
            <p class="text-black"><strong>Mohon Pelanggan Log Masuk Aplikasi Sportstigo dan Buat Pembayaran. Status Tempahan akan Disahkan Setelah Pembayaran dibuat/Berjaya! </strong></p>
            <p class="text-black"><strong>请要求客户登录 Sportstigo 应用程序并付款。只有付款/成功后才会确认预订状态 !</strong></p>
            <p class="text-black"><strong>Sportstigo செயலியில் உள்நுழைந்து பணம் செலுத்துமாறு வாடிக்கையாளரைக் கேளுங்கள்.பணம் செலுத்தப்பட்டதும்/வெற்றிகரமானதும் மட்டுமே முன்பதிவு நிலை உறுதிப்படுத்தப்படும்</strong></p>
            <a href="{{route('dashboard')}}"><button type="button" class="theme-btn">BACK TO ADMIN</button></a>
        </div>
      </div>
    </div>
    <div class="custom-border mt-4"></div>
  </div>


</div>


@include('layouts.footer')