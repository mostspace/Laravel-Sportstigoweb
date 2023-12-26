@include('layouts.head')
<?php $pageheading = 'ALL PRODUCTS';?>
<body>
   <div class="dash wrapper">
      @include('layouts.header')
      <div class="custom-border"></div>
      <section class="content-main ">
      <div class="container">
      <div class="row d-flex flex-wrap align-items-center justify-content-md-start justify-content-center mb-4">
                  <!--<button type="submit" class="theme-btn mr-3">ADD NEW STAFF</button>!-->
                  <a href="{{ url('/add-products') }}"><button type="button" class="gray-small mr-2" > BACK</button></a>
                  <a href="{{url('/product/Listing')}}"><button type="button" class="theme-btn">All Product Record </button></a>
               </div>
      <div class="row">
            <div class="col-md-12 col-sm-12">
               <div class="x_panel">
                  <div class="x_content">
                     <div class="row">
                        <div class="col-sm-12">
                           <div class="card-box table-responsive">
                              <table id="datatable" class="table table-striped table-bordered" style="width:100%">
                                 <thead>
                                    <tr>
                                       <th width="5%">#</th>
                                       <th width="20%">product Image</th>
                                       <th width="10%">Product Name</th>
                                       <th width="10%">Product price</th>
                                       <th width="30%">Product description</th>
                                       <th width="10%">Product stock</th>
                                       <th width="5%">Instock/Not</th>
                                       <th width="30%">Action</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    @foreach( $products as $detail)
                                    <tr>
                                       <td>{{$detail->id}}</td>
                                       <td><img src="{{asset('/NewProductImages/'.$detail->p_image)}}" width="50%px" alt=""/></td>
                                       <td>{{$detail->p_name}}</td>
                                       <td>{{$detail->p_price}}</td>
                                       <td>{{$detail->p_desc}}</td>
                                       <td>{{$detail->p_stock}}</td>
                                       <td>{{$detail->out_of_stock}}</td>
                                       <td>
                                          <a class="btn btn-info white_color" href="{{url('/product/edit/'.$detail->id)}}">Edit</a>
                                          <a href="{{url('/product/delete/'.$detail->id)}}" class="btn btn-danger white_color"
                                             onclick="return confirm('Are you sure to Delete this record')">Delete</a>
                                       </td>
                                    </tr>
                                    @endforeach
                                 </tbody>
                              </table>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
      </section>
      </div>
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
