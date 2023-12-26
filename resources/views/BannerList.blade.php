@include('layouts.head')
<body>
<div class="dash wrapper">
    
  @include('layouts.header')

  <div class="custom-border">
  </div>
  <div class="main-section pt-4 pb-4">
    <div class="container">
	
	
	<?php
    if (isset($_POST["sorting"]) )
	{
	$postsorting = $_POST["sorting"];
	}
	
	?>
	
	 <form action="" method="post" enctype="multipart/form-data">
	 @csrf
		
	
      <div class="d-flex justify-content-end ">
        
		
        
        <!--<div class="dropdown">-->
        <!--  <button class="btn btn-secondary dropdown-toggle px-4" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">-->
        <!--    Sort-->
        <!--  </button>-->
        <!--  <div class="dropdown-menu" aria-labelledby="dropdownMenu2">-->
        <!--    <button class="dropdown-item" type="button">Action</button>-->
        <!--    <button class="dropdown-item" type="button">Another action</button>-->
        <!--    <button class="dropdown-item" type="button">Something else here</button>-->
        <!--  </div>-->
        <!--</div>-->
      </div>
      <?php 
        // echo '<pre>';
        // print_r($userdetails);
        // echo '</pre>';
        // exit();
      ?>
     </form>
	 
     <div align="right"><a href="{{ route('dashboard') }}"><button type="button" class="gray-small mr-2" > BACK</button></a></div>
    <table class="rs-table refferal-users w-100 text-center">
      <tr class="shadow-none h-auto">
        <th>Actions</th>
        <th>Banner Type</th>
        <th>Banner Image</th>
        <!--<th>Secondary Banner</th>!-->
		<th>Created Date</th>
      </tr>
    
	@forelse( $bannerslist as $userdetailsvalue )


         
		<tr>
        <td>
          <div class="action-btns">
		   

            <a href="{{ route('banneredit', $userdetailsvalue->id ) }}" class="edit-btn">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M17 2.99981C17.2626 2.73717 17.5744 2.52883 17.9176 2.38669C18.2608 2.24455 18.6286 2.17139 19 2.17139C19.3714 2.17139 19.7392 2.24455 20.0824 2.38669C20.4256 2.52883 20.7374 2.73717 21 2.99981C21.2626 3.26246 21.471 3.57426 21.6131 3.91742C21.7553 4.26058 21.8284 4.62838 21.8284 4.99981C21.8284 5.37125 21.7553 5.73905 21.6131 6.08221C21.471 6.42537 21.2626 6.73717 21 6.99981L7.5 20.4998L2 21.9998L3.5 16.4998L17 2.99981Z" stroke="#98A9BC" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </a>

           <a href="javascript:void(0)" id="del{{$userdetailsvalue->id}}" onclick="deleteuserfun({{$userdetailsvalue->id}})" data-userid="{{$userdetailsvalue['user_id']}}" class="delete-btn">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M3 6H5H21" stroke="#98A9BC" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              <path d="M8 6V4C8 3.46957 8.21071 2.96086 8.58579 2.58579C8.96086 2.21071 9.46957 2 10 2H14C14.5304 2 15.0391 2.21071 15.4142 2.58579C15.7893 2.96086 16 3.46957 16 4V6M19 6V20C19 20.5304 18.7893 21.0391 18.4142 21.4142C18.0391 21.7893 17.5304 22 17 22H7C6.46957 22 5.96086 21.7893 5.58579 21.4142C5.21071 21.0391 5 20.5304 5 20V6H19Z" stroke="#98A9BC" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </a>
            
            
              
              
              <button class="btn btn-danger m-1" style="display:none" id="deletebtn_{{$userdetailsvalue['user_id']}}">Delete User</button>
           

          </div>
        </td>


        <td class="text-center"> 
              <?php $bannertype = $userdetailsvalue->bannertype;
              
              if($bannertype==1)
              {
                 $bannertype = 'Main Slider Banner'; 
              }
              else
              {
                $bannertype = 'Secondary Slider Banner'; 
              }
              ?>

              {{$bannertype}}
      </td>


        <td class="text-center"> 
		@if( $userdetailsvalue->bannerimage )
		<img src="{{asset($userdetailsvalue->bannerimage)}}" width="50px" alt="Blog-image" />
		@else
		<img src="{{asset('backend/img/thumb.png')}}" alt="Blog-image" />	
		@endif													
		</td>
		<!--<td class="text-center"> 
		@if( $userdetailsvalue->secondbannerimage )
		<img src="{{asset($userdetailsvalue->secondbannerimage)}}" width="50px" alt="Blog-image" />
		@else
		<img src="{{asset('backend/img/thumb.png')}}" alt="Blog-image" />	
		@endif													
		</td>!-->
        
		<td>{{date('d-m-Y', strtotime($userdetailsvalue['created_at']));}}</td>
      </tr>


	@empty 

    @endforelse 

	 

 
	
      
    </table> 
    <div class="w-100">
    {!! $bannerslist->links() !!}
	
    </div>
	
  </div>
  
  
  </div>
</div>

<script>
  function deleteuserfun(btn){
    var user_btn_id = $(btn).attr("data-userid");
    $("#deletebtn_"+user_btn_id).click();
  }
  
function deleteuserfun(btn){
	
	var user_btn_id = btn;
    $("#deletebtn_"+user_btn_id).click();
	
	var txt;
	  if (confirm("Are you sure want to remove!")) 
	  {
		var url = "{{ route('bannerdelete', '') }}"+"/"+btn ;
		
		window.location.href=url
	  } 
	  else 
	  {
		
	  }
	
	
  } 
  
</script>

@include('layouts.footer')