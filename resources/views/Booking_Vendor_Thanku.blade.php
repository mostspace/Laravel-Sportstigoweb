@include('layouts.head')
<body>
<div class="dash wrapper">

    @include('layouts.header')
  
    <div class="custom-border"></div>
  
    <div class="main-section pt-4 pb-4">
      <div class="container">
        <div class="row d-flex align-items-center justify-content-start mb-4">
         
          <a href="{{route('venuelist')}}"><button type="button" class="theme-btn">COURT LIST</button></a>
		  
		  
        </div>
        <form action="{{ route('venuesadd')}}" method="post"  enctype="multipart/form-data">
          @csrf 
		  
		  @if(Session::has('success'))
			<div class="alert alert-success text-center mt-3 mb-3">
				<span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
				 {{ Session::get('success') }}
			</div> 
		 @endif
		 
		
          
          
		
		 </form>
      </div>
    </div>
  
  </div>
  
  
@include('layouts.footer')  