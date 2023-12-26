@include('layouts.head')
<body>
   <div class="dash wrapper">
   @include('layouts.header')
   <div class="custom-border">
   </div>
   <div class="main-section pt-4 pb-4">
   <div class="container">
    
	   @forelse( $withdrawaldetails as $wlist)
	  
	   <form action="{{ route('vendoraddrequestwithdrawal',$wlist->id) }}" method="post" enctype="multipart/form-data">
         @csrf 
         <!--<input type="hidden" name="_token" value="{{ csrf_token() }}" />!-->
		<input type="hidden" class="custom-field w-100 form-control" name="id" value="{{ $wlist->id}}"> 
		
		 
		 @if(Session::has('success'))
			<div class="alert alert-success text-center mt-3 mb-3">
				<span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
				 {{ Session::get('success') }}
			</div> 
		@endif
        
		<div class="row">&nbsp;</div>
		
		<div class="row">
                <div class="col-lg-12 d-flex flex-wrap justify-content-md-start justify-content-center mb-4">
                  <button type="submit" class="d-inline sgreen mr-2 mb-2">SEND REQUEST</button>
				  
				  <a href="{{route('vendorwithdrawallist')}}" ><button type="button" class="d-inline sgreen mr-2 mb-2"> Withdrawal List / Status</button></a>
				   <a href="{{ route('dashboard') }}" ><button type="button" class="d-inline gray-small mr-2 mb-2"> BACK</button></a>
			   	   
                </div>
              </div>
	
		<div class="row">		
			
			<div class="col-lg-4">
               <div class="form-group">
                  <label for="name" class="custom-label">Withdrawal Name</label>
                  <input type="text" class="form-control" value="{{ $wlist->name}}" name="name" readonly>
				  @if ($errors->has('name'))
				   <span class="text-danger">{{ $errors->first('name') }}</span>
		         @endif
               </div>
            </div>
		</div>
		<div class="row">		
			
			<div class="col-lg-4">
               <div class="form-group">
                  <label for="bankname" class="custom-label">Bank Name</label>
                  <input type="text" class="form-control" value="{{ $wlist->bankname}}" name="bankname" readonly>
				  
               </div>
            </div>
		</div>
		<div class="row">		
			
			<div class="col-lg-4">
               <div class="form-group">
                  <label for="bankacno" class="custom-label">Account No</label>
                  <input type="text" class="form-control" value="{{ $wlist->bankacno}}" name="bankacno" readonly>
				  
               </div>
            </div>
		</div>
		<div class="row">		
			
			<div class="col-lg-4">
               <div class="form-group">
                  <label for="bankaccountname" class="custom-label">Account Holder Name</label>
                  <input type="text" class="form-control" value="{{ $wlist->bankaccountname}}" name="bankaccountname" readonly >
				 
               </div>
            </div>
		</div>
		<div class="row">	
		
			<div class="col-lg-4">
               <div class="form-group">
                  <label for="wallet_amount" class="custom-label">Wallet Amount</label>

              
                  <input type="text" class="form-control" value="{{ sprintf('%.2f', $wlist->wallet_amount) }}" name="wallet_amount" readonly>
				  @if ($errors->has('wallet_amount'))
				   <span class="text-danger">{{ $errors->first('wallet_amount') }}</span>
		         @endif
               </div>
            </div>
           
		
      </div>
		<div class="row">	
		
			<div class="col-lg-4">
               <div class="form-group">
                  <label for="withdrawal_amount" class="custom-label">Withdrawal Amount</label>
                  <input type="text" class="form-control" value="" name="withdrawal_amount">
				  @if ($errors->has('withdrawal_amount'))
				   <span class="text-danger">{{ $errors->first('withdrawal_amount') }}</span>
		         @endif
               </div>
            </div>
           
		
      </div>
	<div class="col-lg-4"></div>
            
			
			
	
       </form> 
	    @empty 
		@endforelse 
			
      <table border="0" cellpadding="0" cellspacing="0" style="width:1000px;">
	<tbody>
		<tr>
			<td><img alt="" src="https://sportstigo.com/sportstigo/public/assets/img/alarm.png" style="width: 30px; height: 30px;" /></td>
			<td><span style="color:#000000;">All withdrawal requests subject to a 2% withdrawal fee. You can check your withdrawal status within 3-5&nbsp;business days of your request.</span></td>
		</tr>
	</tbody>
</table>

<p>&nbsp;</p>
</body>  
   </div>
   
   @include('layouts.footer')
