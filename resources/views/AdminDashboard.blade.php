@include('layouts.head')
<body>
<?php $pageheading ='Admin Dashboard'; ?>
<div class="dash wrapper">

  @include('layouts.header')

  @if (session('success'))
  <div class="alert alert-success" role="alert">
      {{ session('success') }}
  </div>
 @endif
  
  <div class="custom-border">
  </div>
  <div class="main-section pt-4 pb-4">
    <div class="container">
      <div class="row align-items-center justify-content-center">
        <div class="col-md-3">

        <a href="{{route('AdminProfile')}}">
        <div class="black-box">
          <div><span class="main-text">PROFILE</span></div>
          <div><span class="sub-text">Manage Profile</span></div>
        </div>
        </a>    
        </div>
        

        <div class="col-md-3">
          <a href="{{route('users.create')}}">
          <div class="black-box">
          <div><span class="main-text">staff</span></div>
          <div><span class="sub-text">Manage System Access</span></div>
        </div>
        </a>
      </div>

        <div class="col-md-3">
          <a href="{{route('vendorlist')}}">
        <div class="black-box">
          <div><span class="main-text">Vendors list</span></div>
          <div><span class="sub-text">Manage Vendors/Partners</span></div>
        </div>
      </a>
      </div>


        <div class="col-md-3">
            <a href="{{route('userslist')}}">
        <div class="black-box">
          <div><span class="main-text">USERS </span></div>
          <div><span class="sub-text">Manage Sportstigo Users</span></div>
        </div>
            </a>
      </div>
      </div>
    </div>
      <div class="custom-border mt-4 mb-4"></div>
      <div class="container">
      <div class="row align-items-center justify-content-center">
        <div class="col-md-3">
          <!--<a href="{{route('voucher.index')}}">!-->
		 <a href="{{ route('voucher.index') }}">
        <div class="black-box">
          <div><span class="main-text">Voucher </span></div>
          <div><span class="sub-text">Manage Vouchers </span></div>
        </div></a>
      </a>
      </div>  

        <div class="col-md-3">
            <a href="{{route('category.index')}}">
        <div class="black-box">
          <div><span class="main-text">Categories </span></div>
          <div><span class="sub-text">Manage Categories</span></div>
        </div>
            </a>
      </div>                
        <div class="col-md-3">
          <a href="{{route('state.index')}}">
        <div class="black-box">
          <div><span class="main-text">states </span></div>
          <div><span class="sub-text">Manage States</span></div>
        </div>
      </a>
      </div>                
        <div class="col-md-3">
        <a href="{{route('instructorslist')}}">
        <div class="black-box">
          <div><span class="main-text">INSTRUCTORS</span></div>
          <div><span class="sub-text">Manage Instructors</span></div>
        </div>
      </a>
      </div>                
      </div>
    </div>
      <div class="custom-border mt-4 mb-4"></div>
      <div class="container">
      <div class="row align-items-center justify-content-center">
        <div class="col-md-3">
          <a href="{{route('hostlist')}}">
        <div class="black-box">
          <div><span class="main-text">Host </span></div>
          <div><span class="sub-text">Manage Host / Setting</span></div>
        </div>
      </a>
      </div>
        <div class="col-md-3">
          <a href="{{route('buddylist')}}"> 
        <div class="black-box">
          <div><span class="main-text">Buddy</span></div>
          <div><span class="sub-text">Manage Buddy System</span></div>
        </div>
          </a>
      </div>
        <div class="col-md-3">
          <a href="{{route('noticboard')}}">
        <div class="black-box">
          <div><span class="main-text">Message Box</span></div>
          <div><span class="sub-text">Support Messages</span></div>
        </div>
      </a>
      </div>
        <div class="col-md-3">
          <a href="{{route('withdrawallist')}}">
        <div class="black-box">
          <div><span class="main-text">withdrawal</span></div>
          <div><span class="sub-text">MANAGE USER WITHDRAWAL</span></div>
        </div>
      </a>
      </div>
      </div>
    </div>
      <div class="custom-border mt-4 mb-4"></div>
      <div class="container">
      <div class="row align-items-center justify-content-center">
        <div class="col-md-3">
        <div class="black-box">
        <a href="{{route('vendorreport')}}">
          <div><span class="main-text">Sales Report </span></div>
          <div><span class="sub-text">Manage sales</span></div>
        </div>
      </a>
      </div>
        <div class="col-md-3">
          <a href="{{route('ewalletlist')}}">
        <div class="black-box">
          <div><span class="main-text">Ewallet</span></div>
          <div><span class="sub-text">Ewallet Management</span></div>
        </div>
      </a>
      </div>
        <div class="col-md-3">
         <a href="{{route('refferallist')}}">
        <div class="black-box">
          <div><span class="main-text">Refferal  </span></div>
          <div><span class="sub-text">Manage Refferal Program</span></div>
        </div></a>
      </div>
        <div class="col-md-3">
          <a href="{{route('AdminBanner')}}">
        <div class="black-box">
          <div><span class="main-text">Banner  </span></div>
          <div><span class="sub-text">Manage App Banner</span></div>
        </div>
          </a>
      </div>
	  
      </div>
	  
    </div>
	<div class="custom-border mt-4 mb-4"></div>
    <div class="container">
      <div class="row align-items-center justify-content-end">
	  <div class="col-md-3">
         <a href="{{route('refundpolicy')}}">
        <div class="black-box">
          <div><span class="main-text">Refund Policy  </span></div>
          <div><span class="sub-text">Manage Refund Policy</span></div>
        </div>
          </a>
      </div>
	   <div class="col-md-3">
          
		   <a href="{{route('salesagentcreate')}}">
		  
        <div class="black-box">
          <div><span class="main-text">Sales Agent  </span></div>
          <div><span class="sub-text">Manage Sales Agent</span></div>
        </div>
          </a>
      </div>
        <div class="col-md-3">
          <a href="#" onclick="document.getElementById('logout-form').submit();">
        <div class="black-box">
          <div><span class="main-text text-red"><a class="main-text text-red" href="#" onclick="document.getElementById('logout-form').submit();">LoGOUT</a></span></div>
          <div><span class="sub-text"></span></div>
        </div>
      </a>
	   <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
			{{ csrf_field() }}
			</form>
      </div>
      </div>
    </div>
  </div>
</div>
@include('layouts.footer')