@include('layouts.head')
<body>
<div class="dash wrapper">

  @include('layouts.header')


        <div class="custom-border"></div>
        <div class="container">
          @forelse( $statelist as $slist)
		  
		  <form  action="{{ route('refundpolicyeditupdate',$slist->id) }}" method="post" enctype="multipart/form-data">
            @csrf 
			
			@if(Session::has('success'))
			 <div class="alert alert-success text-center mt-3 mb-3">
				<span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
				 {{ Session::get('success') }}
			 </div> 
		    @endif
			
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
			<input type="hidden" class="custom-field w-100 form-control" name="id" value="{{ $slist->id }}" >
            <div class="voucher">
                <div class="row">
                <div class="col-lg-12 mb-4">
                  <button type="submit" class="green-small mr-2">SEND</button>
				  
				  <a href="{{ route('dashboard') }}"><button type="button" class="gray-small mr-2" > BACK</button></a>
          <a href="{{route('refundpolicylist')}}"><button type="button" class="sgreen ">REFUND POLICY LIST</button></a>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-12">
                  <div class="form-group">
                    <label for="name" class="custom-label mr-2">Refund Policy Description:</label>
                    <input type="text" class="custom-field form-control d-inline" name="name" 
					value="{{ $slist->name }}">
                  </div>
				  @if ($errors->has('name'))
					<span class="text-danger">&nbsp;&nbsp;  {{ $errors->first('name') }}</span>
				@endif
                </div>
              </div>
              
			  <div class="row">
                <div class="col-lg-12">
                  <div class="form-group">
                    <label for="refund" class="custom-label mr-2">Refund Policy Hours:</label>
                    <input type="text" class="custom-field form-control d-inline" name="refund" 
					value="{{ $slist->refund }}">
                  </div>
				  @if ($errors->has('refund'))
					<span class="text-danger">&nbsp;&nbsp;  {{ $errors->first('refund	') }}</span>
				@endif
                </div>
              </div>
               
            </div>
          </form>
		  @empty 
		@endforelse 
        </div>
      </div>

@include('layouts.footer')