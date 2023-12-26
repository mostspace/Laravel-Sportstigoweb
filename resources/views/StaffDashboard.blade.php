@include('layouts.head')
<body>
<?php $pageheading ='Staff Dashboard'; ?>
<div class="dash wrapper">

  @include('layouts.header')

  @if (session('success'))
  <div class="alert alert-success" role="alert">
      {{ session('success') }}
  </div>
  @endif
  
  <div class="custom-border"></div>
  <div class="main-section pt-4 pb-4">
    <div class="container">
      <div class="row align-items-center justify-content-center">
        
		@forelse( $staffmoduledetails as $staffmoduledtls) 
			
				<div class="col-md-3">
				<a href="{{$staffmoduledtls['route']}}">
				<div class="black-box">
				  <div><span class="main-text">{{$staffmoduledtls['modulename']}}</span></div>
				  <div><span class="sub-text">{{$staffmoduledtls['muduledesc']}}</span></div>
				</div>
				</a>    
				</div>
		@empty 
		@endforelse 

      </div>

    </div>
    


	<div class="container">
      <div class="row align-items-center justify-content-end">
        <div class="col-md-3">
          <a href="#" onclick="document.getElementById('logout-form').submit();">
        <div class="black-box">
          <div><span class="main-text text-red">LoGOUT</span></div>
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