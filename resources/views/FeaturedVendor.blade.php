@include('layouts.head')
<body>
<div class="dash wrapper">
    
  @include('layouts.header')

  <div class="custom-border"></div>
  <div class="main-section pt-4 pb-4">
    <div class="container">
	  <div  style="float:right;"><a href="{{ url()->previous() }}"><button type="button" class="gray-small mr-2" > BACK</button></a></div>
      <table id="dataTable" class="table rs-table refferal-users text-center">
        <thead>
          <tr class="shadow-none h-auto">
            <th>Position</th>
            <th>Vendor Name</th>
            <th>Vendor Email</th>
          </tr>
        </thead>
        <tbody id="tablecontents">
	    @forelse( $featured_vendor as $vendor ) 
      <tr class="row1" data-id="{{ $vendor->position }}">
        <td>{{$vendor->position}}</td>
        <td>{{$vendor->businessname}}</td>
        <td>{{$vendor->email}}</td>
      </tr>
	    @empty
      @endforelse
        </tbody>
      </table> 
    </div>
  </div>
</div>

<!--<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.12/datatables.min.js"></script>-->

<script>
  $(function () {

    $("#tablecontents").sortable({
     items: "tr",
     cursor: 'move',
     opacity: 0.6,
     update: function() {
         sendOrderToServer();
     }
   });

   function sendOrderToServer() {

     var order = [];
     $('tr.row1').each(function(index,element) {
       order.push({
         id: $(this).attr('data-id'),
         position: index+1
       });
     });

     $.ajax({
       type: "POST", 
       dataType: "json", 
       url: "{{ url('/vendorlist/featuredVendorList') }}",
       headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}' },
       data: {
        order: order,
       },
       success: function(response) {
        var content = '';
        $.each(response, function(k, v) {
          content += '<tr class="row1" data-id="' + v['position'] + '">';
          content += '<td>' + v['position'] + '</td>';
          content += '<td>' + v['businessname'] + '</td>';
          content += '<td>' + v['email'] + '</td>';
          content += '</tr>';
        });
        $('#tablecontents').html(content);
       }
     });

   }
 });

 /* function deleteuserfun(btn){
    var user_btn_id = $(btn).attr("data-userid");
    $("#deletebtn_"+user_btn_id).click();
  }*/


  function deleteuserfun(btn){
    
	
	var user_btn_id = btn;
    $("#deletebtn_"+user_btn_id).click();
	
	var txt;
	  if (confirm("Are you sure want to remove!")) 
	  {
		var url = "{{ route('deletevendor', '') }}"+"/"+btn ;
		
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
				var url = "{{route('sortingvendorlist',['',''])}}" +"/"+txtval+"/"+sortval ;
				window.location.href=url;
                
            } else {
                var url = "{{route('sortingvendorlist',['',''])}}" +"/"+txtval+"/"+sortval ;
				
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
				var url = "{{route('vendorlist')}}";
				
				window.location.href=url;
                
            } else {
                var url = "{{route('sortingvendorlist',['',''])}}" +"/"+txtval+"/"+sortval ;
				
				window.location.href=url;
				
            }
  }
  
  
</script>

@include('layouts.footer')