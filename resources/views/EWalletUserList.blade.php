@include('layouts.head')
<body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
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
        <!--<div class="dropdown mr-2">-->
        <!--  <button class="btn btn-secondary dropdown-toggle px-4" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">-->
        <!--    Filter-->
        <!--  </button>-->
        <!--  <div class="dropdown-menu" aria-labelledby="dropdownMenu2">-->
        <!--    <button class="dropdown-item" type="button">Action</button>-->
        <!--    <button class="dropdown-item" type="button">Another action</button>-->
        <!--    <button class="dropdown-item" type="button">Something else here</button>-->
        <!--  </div>-->
        <!--</div>-->
        <!--<div>
            <span class="filter-text">Filter:</span> 
            <select class="form-control filter-select d-inline w-auto mr-2" aria-label="Default select example">
              <option selected>All</option>
              <option value="1">Filter 1</option>
              <option value="2">Filter 2</option>
              <option value="3">Filter 3</option>
            </select>
			
        </div>!-->
		
		
        <div>
		<input type="text"  id = "txtserach" name="txtserach" placeholder="Search..."  
		value="<?php if(isset($txtserach)){ echo $txtserach; } ?>"  onkeydown="return (event.keyCode!=13);"/>
		<input type="button" name="search" value="Search" onclick="funsorting();">
            <span class="filter-text">Sort:</span>
            <select class="form-control filter-select d-inline w-auto mr-2" aria-label="Default select example"  
			id = "sorting" name="sorting">
       <!-- <option value="ASC">A-Z</option>!-->
		
		
		<option value="ASC" <?php if (isset($sorting) && $sorting=="ASC") echo "selected";?> >ASC	</option>
		<option value="DESC" <?php if (isset($sorting) && $sorting=="DESC") echo "selected";?> >DESC</option>    
            </select>
			
			
			<!--<input type="submit" name="serach" value="Search">!-->
        </div>
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
        <div><a href="{{ route('dashboard') }}"><button type="button" class="gray-small mr-2" > BACK</button></a></div>
      </div>
      <?php 
        // echo '<pre>';
        // print_r($userdetails);
        // echo '</pre>';
        // exit();
      ?>
     </form>
	 

    <table class="rs-table refferal-users w-100 text-center">
      <tr class="shadow-none h-auto">
	    <th>Action</th>
        <th>Join Date</th>
        <th>Email ID</th>
		<th>Mobile</th>
        <th>Name</th>
		<th>Wallet Amount</th>
      </tr>
    
	@forelse( $userdetails as $userdetailsvalue ) 

         
		<tr>
       <td>
          <div class="action-btns">
		   

            <a href="{{ route('editewallet', $userdetailsvalue['id']  ) }}" class="edit-btn">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M17 2.99981C17.2626 2.73717 17.5744 2.52883 17.9176 2.38669C18.2608 2.24455 18.6286 2.17139 19 2.17139C19.3714 2.17139 19.7392 2.24455 20.0824 2.38669C20.4256 2.52883 20.7374 2.73717 21 2.99981C21.2626 3.26246 21.471 3.57426 21.6131 3.91742C21.7553 4.26058 21.8284 4.62838 21.8284 4.99981C21.8284 5.37125 21.7553 5.73905 21.6131 6.08221C21.471 6.42537 21.2626 6.73717 21 6.99981L7.5 20.4998L2 21.9998L3.5 16.4998L17 2.99981Z" stroke="#98A9BC" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </a>

              <button class="btn btn-danger m-1" style="display:none" id="deletebtn_{{$userdetailsvalue['user_id']}}">Delete User</button>
           

          </div>
        </td>
        <td>{{date('d-m-Y', strtotime($userdetailsvalue['created_at']));}}</td>
        <td>{{$userdetailsvalue['email']}}</td>
		<td>{{$userdetailsvalue['mobile']}}</td>
		<td>{{$userdetailsvalue['name']}}<!--<span class="user-box"><img src="<?php echo asset('assets/img/user.jpg'); ?>" class="user-img ml-2"></span>!--></td>
		<td>{{$userdetailsvalue['wallet_amount']}}</td>
      </tr>


	@empty 

    @endforelse 

	 

 
	
      
    </table> 
    <div class="w-100">
    {!! $userdetails->links() !!}
	
    </div>
	
  </div>
  
  
  </div>
</div>

<script>
  function deleteuserfun(btn){
    var user_btn_id = $(btn).attr("data-userid");
    $("#deletebtn_"+user_btn_id).click();
  }
  
  jQuery("#sorting").change(function(){
  var txtval = document.getElementById("txtserach").value; 
  
	var sortval = document.getElementById("sorting").value;
	
	if (txtval == null ||
                txtval == undefined ||
                txtval.length == 0) {
                txtval = 'Search';
				var url = "{{route('sortingewalletlist',['',''])}}" +"/"+txtval+"/"+sortval ;
				window.location.href=url;
                
            } else {
                var url = "{{route('sortingewalletlist',['',''])}}" +"/"+txtval+"/"+sortval ;
				
				window.location.href=url;
                //return true;
            }
  });
  
  
 function funsorting()
 {

  var txtval = document.getElementById("txtserach").value; 
	var sortval = document.getElementById("sorting").value;
	if (txtval == null ||
                txtval == undefined ||
                txtval.length == 0) {
                txtval = '';
				var url = "{{route('ewalletlist')}}";
				
				window.location.href=url;
                
            } else {
                var url = "{{route('sortingewalletlist',['',''])}}" +"/"+txtval+"/"+sortval ;
				
				window.location.href=url;
				
            }
  }
  
  
</script>

@include('layouts.footer')