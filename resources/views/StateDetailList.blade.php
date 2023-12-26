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
        <div align="right"><a href="{{ route('dashboard') }}"><button type="button" class="gray-small mr-2" > BACK</button></a></div>
      </div>
      <?php 
        // echo '<pre>';
        // print_r($userdetails);
        // echo '</pre>';
        // exit();
      ?>
     </form>
	 

    <table class="refferal-users w-100 text-center">
      <tr class="shadow-none h-auto">
        <th>Actions</th>
       
        <th>State Name</th>
		<th>Created Date</th>
      </tr>
    
	@forelse( $statelist as $userdetailsvalue )

         
		<tr>
        <td>
          <div class="action-btns">
		   

            <a href="{{ route('stateedit', $userdetailsvalue->id ) }}" class="edit-btn">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M17 2.99981C17.2626 2.73717 17.5744 2.52883 17.9176 2.38669C18.2608 2.24455 18.6286 2.17139 19 2.17139C19.3714 2.17139 19.7392 2.24455 20.0824 2.38669C20.4256 2.52883 20.7374 2.73717 21 2.99981C21.2626 3.26246 21.471 3.57426 21.6131 3.91742C21.7553 4.26058 21.8284 4.62838 21.8284 4.99981C21.8284 5.37125 21.7553 5.73905 21.6131 6.08221C21.471 6.42537 21.2626 6.73717 21 6.99981L7.5 20.4998L2 21.9998L3.5 16.4998L17 2.99981Z" stroke="#98A9BC" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </a>

           <!--<a href="{{ route('deletestate', $userdetailsvalue->id ) }}" class="delete-btn">!-->
           <a href="javascript:void(0)" id="del{{$userdetailsvalue->id}}" onclick="deleteuserfun({{$userdetailsvalue->id}})" data-userid="" class="delete-btn">
			
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M3 6H5H21" stroke="#98A9BC" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              <path d="M8 6V4C8 3.46957 8.21071 2.96086 8.58579 2.58579C8.96086 2.21071 9.46957 2 10 2H14C14.5304 2 15.0391 2.21071 15.4142 2.58579C15.7893 2.96086 16 3.46957 16 4V6M19 6V20C19 20.5304 18.7893 21.0391 18.4142 21.4142C18.0391 21.7893 17.5304 22 17 22H7C6.46957 22 5.96086 21.7893 5.58579 21.4142C5.21071 21.0391 5 20.5304 5 20V6H19Z" stroke="#98A9BC" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </a>
            
            
              
              
              <button class="btn btn-danger m-1" style="display:none" id="">Delete User</button>
           

          </div>
        </td>
       
        <td>{{$userdetailsvalue->name}}</td>
		<td>{{date('d-m-Y', strtotime($userdetailsvalue->created_at));}}</td>
      </tr>


	@empty 

    @endforelse 

	 

 
	
      
    </table> 
    <div class="w-100">
    {!! $statelist->links() !!}
	
    </div>
	
  </div>
  
  
  </div>
</div>

<script>
  function deleteuserfun1(btn){
    var user_btn_id = $(btn).attr("data-userid");
    $("#deletebtn_"+user_btn_id).click();
  }
  


  function deleteuserfun(btn){
	
	var user_btn_id = btn;
    $("#deletebtn_"+user_btn_id).click();
	
	var txt;
	  if (confirm("Are you sure want to remove!")) 
	  {
		var url = "{{ route('deletestate', '') }}"+"/"+btn ;
		
		window.location.href=url
	  } 
	  else 
	  {
		
	  }
	
	
  } 
  jQuery("#sorting").change(function(){
  var txtval = document.getElementById("txtserach").value; 
  
	var sortval = document.getElementById("sorting").value;
	
	if (txtval == null ||
                txtval == undefined ||
                txtval.length == 0) {
                txtval = 'Search';
				var url = "{{route('sortingstatelist',['',''])}}" +"/"+txtval+"/"+sortval ;
				window.location.href=url;
                
            } else {
                var url = "{{route('sortingstatelist',['',''])}}" +"/"+txtval+"/"+sortval ;
				
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
				var url = "{{route('Statedetaillist')}}";
				
				window.location.href=url;
                
            } else {
                var url = "{{route('sortingstatelist',['',''])}}" +"/"+txtval+"/"+sortval ;
				
				window.location.href=url;
				
            }
  }
  
  
</script>

@include('layouts.footer')