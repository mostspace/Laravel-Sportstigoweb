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
        <th>Join Date</th>
		    <th>Host Name</th>
		    <th>Status</th>
		    <th>Mobile No</th>
        <th>Email</th>
        <th>User Name</th>
      </tr>
    
	@forelse( $buddydetails as $userdetailsvalue ) 

         
		<tr>
        
    <td>{{date('d-m-Y', strtotime($userdetailsvalue->created_at));}}</td>
		<td>{{$userdetailsvalue->host_game_name}}
		<td><span class="total-earned">
		<?php
		
		if($userdetailsvalue->status=='1')
			echo 'Active';
		else
			echo 'InActive';
		
		?>
		
		</span></td>
		<td>{{$userdetailsvalue->mobile}}
		<td>{{$userdetailsvalue->email}}
		<td>{{$userdetailsvalue->name}}
      </tr>


	@empty 
  @endforelse 

	 

 
	
      
    </table> 
    <div class="w-100">
    {!! $buddydetails->links() !!}
	
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
				var url = "{{route('sortingbuddylist',['',''])}}" +"/"+txtval+"/"+sortval ;
				window.location.href=url;
                
            } else {
                var url = "{{route('sortingbuddylist',['',''])}}" +"/"+txtval+"/"+sortval ;
				
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
				var url = "{{route('buddylist')}}";
				
				window.location.href=url;
                
            } else {
                var url = "{{route('sortingbuddylist',['',''])}}" +"/"+txtval+"/"+sortval ;
				
				window.location.href=url;
				
            }
  }
  
  
</script>

@include('layouts.footer')