@include('layouts.head')
<?php $pageheading = 'ADD PRODUCTS';?>
<body>
   <div class="dash wrapper">
      @include('layouts.header')
      <div class="custom-border"></div>
      <form action="{{ url('/add_new_products')}}" method="post"  enctype="multipart/form-data">
         @csrf
         <div class="main-section pt-4 pb-4">
            <div class="container">
               <div class="row d-flex flex-wrap align-items-center justify-content-md-start justify-content-center mb-4">
                  <!--<button type="submit" class="theme-btn mr-3">ADD NEW STAFF</button>!-->
                  <button type="submit" class="green-small mr-2 mb-2">SAVE</button>
                  <a href="{{ route('dashboard') }}"><button type="button" class="gray-small mr-2" > BACK</button></a>
                  <a href="{{url('/product/Listing')}}"><button type="button" class="theme-btn">product Listing</button></a>
               </div>
               @if(Session::has('success'))
               <div class="alert alert-success text-center mt-3 mb-3">
                  <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                  {{ Session::get('success') }}
               </div>
               @endif
               <div class="row">
                  <div class="col-lg-4">
                     <div class="form-group">
                        <label for="state" class="custom-label">Product Name</label>
						<input type="text" class="form-control" value="" name="p_name" maxlength="50">
						@error('p_name')
					<span class="field_error" style="color:red;">{{$message}}</span>
					@enderror
					</div>

                  </div>
                  <div class="col-lg-4">
                     <div class="form-group">
                        <label for="businessname" class="custom-label">Product Price</label>
                        <input type="text" class="form-control" value="" name="p_price" maxlength="50">
						@error('p_price')
					<span class="field_error" style="color:red;">{{$message}}</span>
					@enderror
                     </div>
                  </div>
                  <div class="col-lg-4">
                     <div class="form-group">
                        <label for="address" class="custom-label">Product Description</label>
                        <input type="text" class="form-control" value="" name="p_desc">
						@error('p_desc')
					<span class="field_error" style="color:red;">{{$message}}</span>
					@enderror
                     </div>
                  </div>
                  <div class="col-lg-4">
                     <div class="form-group">
                        <label for="description" class="custom-label">Product Image</label>
                        <input type="file" class="form-control" value="" name="p_image">
						@error('p_image')
					<span class="field_error" style="color:red;">{{$message}}</span>
					@enderror
                     </div>
                  </div>
                  <div class="col-lg-4">
                     <div class="form-group">
                        <label for="moredetails" class="custom-label">Product Stock</label>
                        <input type="text" class="form-control" value="" name="p_stock">
						@error('p_stock')
					<span class="field_error" style="color:red;">{{$message}}</span>
					@enderror
					</div>
                  </div>
				  <div class="col-lg-4">
                     <div class="form-group" style="margin-top:35px;">
					 <label class="custom-label" for="product stock">In stock</label>
						<input class="form-check-input" type="checkbox" name="out_of_stock" value="1" id="" style="margin-left:20px;">
                     </div>
                  </div>
                  <br><br><br><br><br><br><br><br>
               </div>
      </form>
      </div>
      </div>
   </div>
   <style>
      .multiselect .multiItem{
      position: relative;
      display: flex;
      align-items: center;
      padding: 8px 10px;
      color: #495057;
      }
      .multiselect .multiItem:hover{
      background: #ced4da;
      }
      .multiselect .multiItem label{
      width:100%;
      margin:0;
      line-height: 18px;
      display:flex;
      position:relative;
      }
      .multiselect input[type=checkbox] {
      position: absolute;
      height: 100%;
      width: 100%;
      display:block;
      margin: 0;
      opacity:0;
      left:0;
      z-index:1;
      }
      .multiselect input[type=checkbox]:before,.multiselect input[type=checkbox]:after{
      display:none;
      }
      .multiItem label.checkbox:before {
      content:" ";
      height: 16px;
      width: 16px;
      border: 1px solid #999;
      left: 0px;
      top: 9px;
      background-color: #fff;
      border-radius: 2px;
      display:block!important;
      margin-right:12px;
      }
      .multiItem label.checkbox:after {
      content:" ";
      position:absolute;
      height: 5px;
      width: 9px;
      left: 3px;
      top: 4px;
      }
      .multiselect input[type=checkbox]:checked + label:before {
      background-color: #18ba60;
      border-color: #18ba60;
      }
      .multiselect input[type=checkbox]:checked + label:after {
      content: "";
      border-left: 1px solid #fff;
      border-bottom: 1px solid #fff;
      transform: rotate(-45deg);
      }
   </style>
   @include('layouts.footer')
