@include('layouts.head')
<body>
   <div class="dash wrapper">
   @include('layouts.header')
   <div class="custom-border">
   </div>
   <div class="main-section pt-4 pb-4">
   <div class="container">
      <!--<div class="row d-flex align-items-center justify-content-end mb-4">
         <button type="submit" class="green-round-btn mr-3">APPROVE</button>
         <button type="submit" class="red-round-btn">SUSPEND</button>
      </div>!-->
	   @forelse( $withdrawaldetails as $wlist)
	   
       <!--<div class="row d-flex align-items-center justify-content-end">

        <a href="{{ route('vendorapprovewithdrwanrequest', $wlist->withdrawal_id  )}}"><button type="button" class="green-round-btn mr-3">APPROVE</button></a>
        <a href="{{ route('vendorrejectewithdrwanrequest', $wlist->withdrawal_id  )}}"><button type="button" class="red-round-btn">REJECT</button></a>
       </div>!-->
		
	 
	  
	   <form action="{{ route('vendorupdatewithdrawal',$wlist->withdrawal_id) }}" method="post" enctype="multipart/form-data">
         @csrf 
         <!--<input type="hidden" name="_token" value="{{ csrf_token() }}" />!-->
		<input type="hidden" class="custom-field w-100 form-control" name="id" value="{{ $wlist->withdrawal_id}}"> 
		<input type="hidden" class="custom-field w-100 form-control" name="withdrawaluserid" value="{{ $wlist->withdrawaluserid}}"> 
      <input type="hidden" class="custom-field w-100 form-control" name="bookingno" value="{{ $wlist->bookingno}}"> 
      <input type="hidden" class="custom-field w-100 form-control" name="onlinesales" value="{{ $wlist->onlinesales}}"> 
      <input type="hidden" class="custom-field w-100 form-control" name="countersales" value="{{ $wlist->countersales}}"> 
      <input type="hidden" class="custom-field w-100 form-control" name="vouchersales" value="{{ $wlist->vouchersales}}"> 
      <input type="hidden" class="custom-field w-100 form-control" name="admin_commision" value="{{ $wlist->admin_commision}}"> 
		 
		 @if(Session::has('success'))
			<div class="alert alert-success text-center mt-3 mb-3">
				<span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
				 {{ Session::get('success') }}
			</div> 
		@endif
       
		
    	<div class="row mb-4">
            <div class="col-lg-12">
    
            @if($wlist->withdrawal_status==2)
              <button type="submit" class="d-inline sgreen mr-2" disabled>UPDATE REQUEST</button>
            @elseif($wlist->withdrawal_status==3)
              <button type="submit" class="d-inline sgreen mr-2" disabled>UPDATE REQUEST</button>
            @else
             <button type="submit" class="d-inline sgreen mr-2">UPDATE REQUEST</button>  
            @endif  
    		  <a href="{{route('vendorwithdrawallist')}}"><button type="button" class="d-inline sgreen mr-2">WITHDRAWAL LIST</button></a>
    		  <a href="{{ route('dashboard') }}"><button type="button" class="d-inline gray-small" > BACK</button></a>
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
                  <input type="text" class="form-control" value="{{ $wlist->bankaccountname}}" name="bankaccountname" readonly>
				 
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
                  <input type="text" class="form-control" value="{{ $wlist->withdrawal_amount}}" name="withdrawal_amount">
				  @if ($errors->has('withdrawal_amount'))
				   <span class="text-danger">{{ $errors->first('withdrawal_amount') }}</span>
		         @endif
               </div>
            </div>
           
		
      </div>
	<!--<div class="col-lg-4"></div>-->
            
			
	<!--		<div class="row">-->
 <!--               <div class="col-lg-12 mt-4 mb-2">-->

 <!--               @if($wlist->withdrawal_status==2)-->
 <!--                 <button type="submit" class="theme-btn" disabled>UPDATE REQUEST</button>-->
 <!--               @elseif($wlist->withdrawal_status==3)-->
 <!--                 <button type="submit" class="theme-btn" disabled>UPDATE REQUEST</button>-->
 <!--               @else-->
 <!--                <button type="submit" class="theme-btn">UPDATE REQUEST</button>  -->
 <!--               @endif  -->
	<!--			  <a href="{{route('vendorwithdrawallist')}}"><button type="button" class="theme-btn">WITHDRAWAL LIST</button></a>-->
	<!--			  <a href="{{ route('dashboard') }}"><button type="button" class="gray-small mt-5" > BACK</button></a>-->
 <!--               </div>-->
 <!--             </div>-->
	
       </form> 
	    @empty 
		@endforelse 
			
      
   </div>
   @include('layouts.footer')
