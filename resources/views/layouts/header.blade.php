



      <div class="header pt-3 pb-3">
    <div class="header-1 container-fluid text-right">
      <div class="logo-box mb-2">
        <a href="{{ route('dashboard') }}"><img src="<?php echo asset('assets\img\sportstigo.png'); ?>" height="25px"></a>
      </div>

      
      <div>
        <span class="logged">Logged As {{session()->get('getsessionloginname');}}  </span></a>
       
       
      </div>
      {{-- <div class="d-flex align-items-center"> --}}
        <div class="header-main-title text-left">
          <h2>{{ (isset($pageheading)) ? $pageheading : 'Page Heading'}}</h2>

        </div>
        <div class="header-sub-title text-left">
          <h3>{{ (isset($pagesubheading)) ? $pagesubheading : ''}}</h3>
        </div>

        {{-- <div class="header-main-title text-left">
          <h2>VOUCHER</h2>
        </div>
        <div class="header-sub-title text-left">
          <h3>GLOBAL VOUCHER ( For All Vendors )</h3>
        </div> --}}

        {{-- <button type="submit" class="gray-small ml-3">EDIT</button> --}}
      {{-- </div> --}}
    </div>
  </div> 






