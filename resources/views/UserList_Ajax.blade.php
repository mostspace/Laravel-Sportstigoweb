@include('layouts.head')
<body>
<div class="dash wrapper">
    
  @include('layouts.header')

  <div class="custom-border">
  </div>
  <div class="main-section pt-4 pb-4">
    <div class="container">
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
        <div>
            <span class="filter-text">Filter:</span> 
            <select class="form-control filter-select d-inline w-auto mr-2" aria-label="Default select example">
              <option selected>All</option>
              <option value="1">Filter 1</option>
              <option value="2">Filter 2</option>
              <option value="3">Filter 3</option>
            </select>
        </div>
        <div>
            <span class="filter-text">Sort:</span>
            <select class="form-control filter-select d-inline w-auto mr-2" aria-label="Default select example">
              <option selected>A-Z</option>
              <option value="1">Filter 1</option>
              <option value="2">Filter 2</option>
              <option value="3">Filter 3</option>
            </select>
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
      </div>
      <?php 
        // echo '<pre>';
        // print_r($userdetails);
        // echo '</pre>';
        // exit();
      ?>
     
    <table class="refferal-users w-100 text-center">
      <tr class="shadow-none h-auto">
        <th>Actions</th>
        <th>Join Date</th>
        <th>Location</th>
        <th>Mobile No</th>
        <th>Email ID</th>
        <th>Name</th>
      </tr>
      @foreach($userdetails as $userdetailsvalue)
      <tr>
        <td>
          <div class="action-btns">
            <a href="{{route('users.show', $userdetailsvalue->id)}}" class="view-btn">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M3 12C3 12 6.27273 5.5 12 5.5C17.7273 5.5 21 12 21 12C21 12 17.7273 18.5 12 18.5C6.27273 18.5 3 12 3 12Z" stroke="#98A9BC" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              <path class="eye" d="M12 14.5C13.1046 14.5 14 13.3807 14 12C14 10.6193 13.1046 9.5 12 9.5C10.8954 9.5 10 10.6193 10 12C10 13.3807 10.8954 14.5 12 14.5Z" stroke="#98A9BC" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </a>

            <a href="{{route('users.edit', $userdetailsvalue->id)}}" class="edit-btn">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M17 2.99981C17.2626 2.73717 17.5744 2.52883 17.9176 2.38669C18.2608 2.24455 18.6286 2.17139 19 2.17139C19.3714 2.17139 19.7392 2.24455 20.0824 2.38669C20.4256 2.52883 20.7374 2.73717 21 2.99981C21.2626 3.26246 21.471 3.57426 21.6131 3.91742C21.7553 4.26058 21.8284 4.62838 21.8284 4.99981C21.8284 5.37125 21.7553 5.73905 21.6131 6.08221C21.471 6.42537 21.2626 6.73717 21 6.99981L7.5 20.4998L2 21.9998L3.5 16.4998L17 2.99981Z" stroke="#98A9BC" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </a>

            <a href="javascript:void(0)" onclick="deleteuserfun(this)" data-userid="{{$userdetailsvalue['user_id']}}" class="delete-btn">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M3 6H5H21" stroke="#98A9BC" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              <path d="M8 6V4C8 3.46957 8.21071 2.96086 8.58579 2.58579C8.96086 2.21071 9.46957 2 10 2H14C14.5304 2 15.0391 2.21071 15.4142 2.58579C15.7893 2.96086 16 3.46957 16 4V6M19 6V20C19 20.5304 18.7893 21.0391 18.4142 21.4142C18.0391 21.7893 17.5304 22 17 22H7C6.46957 22 5.96086 21.7893 5.58579 21.4142C5.21071 21.0391 5 20.5304 5 20V6H19Z" stroke="#98A9BC" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </a>
            
            <form action="{{ route('users.destroy', $userdetailsvalue['user_id']) }}" method="POST">
              <input type="hidden" name="_method" value="DELETE">
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <button class="btn btn-danger m-1" style="display:none" id="deletebtn_{{$userdetailsvalue['user_id']}}">Delete User</button>
            </form>

          </div>
        </td>
        <td>{{date('d-m-Y', strtotime($userdetailsvalue['created_at']));}}</td>
        <td>Vadodara</td>
        <td>01612345678</td>
        <td>{{$userdetailsvalue['email']}}</td>
        <td>{{$userdetailsvalue['name']}}<span class="user-box"><img src="<?php echo asset('assets/img/user.jpg'); ?>" class="user-img ml-2"></span></td>
      </tr>
      @endforeach
      <?php /*
      <tr>
        <td>
          <div class="action-btns">
            <a href="#" class="view-btn">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M3 12C3 12 6.27273 5.5 12 5.5C17.7273 5.5 21 12 21 12C21 12 17.7273 18.5 12 18.5C6.27273 18.5 3 12 3 12Z" stroke="#98A9BC" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              <path class="eye" d="M12 14.5C13.1046 14.5 14 13.3807 14 12C14 10.6193 13.1046 9.5 12 9.5C10.8954 9.5 10 10.6193 10 12C10 13.3807 10.8954 14.5 12 14.5Z" stroke="#98A9BC" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </a>
            <a href="#" class="edit-btn">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M17 2.99981C17.2626 2.73717 17.5744 2.52883 17.9176 2.38669C18.2608 2.24455 18.6286 2.17139 19 2.17139C19.3714 2.17139 19.7392 2.24455 20.0824 2.38669C20.4256 2.52883 20.7374 2.73717 21 2.99981C21.2626 3.26246 21.471 3.57426 21.6131 3.91742C21.7553 4.26058 21.8284 4.62838 21.8284 4.99981C21.8284 5.37125 21.7553 5.73905 21.6131 6.08221C21.471 6.42537 21.2626 6.73717 21 6.99981L7.5 20.4998L2 21.9998L3.5 16.4998L17 2.99981Z" stroke="#98A9BC" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </a>
            <a href="#" class="delete-btn">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M3 6H5H21" stroke="#98A9BC" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              <path d="M8 6V4C8 3.46957 8.21071 2.96086 8.58579 2.58579C8.96086 2.21071 9.46957 2 10 2H14C14.5304 2 15.0391 2.21071 15.4142 2.58579C15.7893 2.96086 16 3.46957 16 4V6M19 6V20C19 20.5304 18.7893 21.0391 18.4142 21.4142C18.0391 21.7893 17.5304 22 17 22H7C6.46957 22 5.96086 21.7893 5.58579 21.4142C5.21071 21.0391 5 20.5304 5 20V6H19Z" stroke="#98A9BC" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </a>
          </div>
        </td>
        <td>19/09/2022</td>
        <td>Johor Bahru</td>
        <td>01612345678</td>
        <td>satchi@sportstigo.com</td>
        <td>Sacthi<span class="user-box"><img src="img/user.jpg" class="user-img ml-2"></span></td>
      </tr>
      <tr>
        <td>
          <div class="action-btns">
            <a href="#" class="view-btn">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M3 12C3 12 6.27273 5.5 12 5.5C17.7273 5.5 21 12 21 12C21 12 17.7273 18.5 12 18.5C6.27273 18.5 3 12 3 12Z" stroke="#98A9BC" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              <path class="eye" d="M12 14.5C13.1046 14.5 14 13.3807 14 12C14 10.6193 13.1046 9.5 12 9.5C10.8954 9.5 10 10.6193 10 12C10 13.3807 10.8954 14.5 12 14.5Z" stroke="#98A9BC" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </a>
            <a href="#" class="edit-btn">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M17 2.99981C17.2626 2.73717 17.5744 2.52883 17.9176 2.38669C18.2608 2.24455 18.6286 2.17139 19 2.17139C19.3714 2.17139 19.7392 2.24455 20.0824 2.38669C20.4256 2.52883 20.7374 2.73717 21 2.99981C21.2626 3.26246 21.471 3.57426 21.6131 3.91742C21.7553 4.26058 21.8284 4.62838 21.8284 4.99981C21.8284 5.37125 21.7553 5.73905 21.6131 6.08221C21.471 6.42537 21.2626 6.73717 21 6.99981L7.5 20.4998L2 21.9998L3.5 16.4998L17 2.99981Z" stroke="#98A9BC" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </a>
            <a href="#" class="delete-btn">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M3 6H5H21" stroke="#98A9BC" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              <path d="M8 6V4C8 3.46957 8.21071 2.96086 8.58579 2.58579C8.96086 2.21071 9.46957 2 10 2H14C14.5304 2 15.0391 2.21071 15.4142 2.58579C15.7893 2.96086 16 3.46957 16 4V6M19 6V20C19 20.5304 18.7893 21.0391 18.4142 21.4142C18.0391 21.7893 17.5304 22 17 22H7C6.46957 22 5.96086 21.7893 5.58579 21.4142C5.21071 21.0391 5 20.5304 5 20V6H19Z" stroke="#98A9BC" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </a>
          </div>
        </td>
        <td>19/09/2022</td>
        <td><span class="total-earned">RM 50.00</span></td>
        <td>01612345678</td>
        <td>satchi@sportstigo.com</td>
        <td>Malar Villi<span class="user-box"><img src="img/user.jpg" class="user-img ml-2"></span></td>
      </tr>
      */ ?>
    </table> 
    <ul class="pagination">
      <li class="page-item"><a class="page-link" href="#">
        <svg class="mr-2" width="8" height="13" viewBox="0 0 8 13" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd" clip-rule="evenodd" d="M7.17738 1.18123C7.51212 1.51596 7.51212 2.05868 7.17738 2.39341L2.64061 6.93018L7.17738 11.4669C7.51212 11.8017 7.51212 12.3444 7.17738 12.6791C6.84265 13.0139 6.29993 13.0139 5.9652 12.6791L0.82234 7.53627C0.487605 7.20153 0.487605 6.65882 0.82234 6.32408L5.9652 1.18123C6.29993 0.846492 6.84265 0.846492 7.17738 1.18123Z" fill="#98A9BC"/>
        </svg>
        Prev</a></li>
      <li class="page-item"><a class="page-link" href="#">1</a></li>
      <li class="page-item"><a class="page-link" href="#">2</a></li>
      <li class="page-item"><a class="page-link" href="#">3</a></li>
      <li class="page-item"><a class="page-link" href="#">Next
      <svg class="ml-2" width="8" height="13" viewBox="0 0 8 13" fill="none" xmlns="http://www.w3.org/2000/svg">
      <path fill-rule="evenodd" clip-rule="evenodd" d="M0.82234 1.19783C1.15708 0.863094 1.69979 0.863094 2.03452 1.19783L7.17738 6.34069C7.51212 6.67542 7.51212 7.21813 7.17738 7.55287L2.03452 12.6957C1.69979 13.0305 1.15708 13.0305 0.82234 12.6957C0.487605 12.361 0.487605 11.8183 0.82234 11.4835L5.35911 6.94678L0.82234 2.41001C0.487605 2.07528 0.487605 1.53256 0.82234 1.19783Z" fill="#98A9BC"/>
      </svg>
      </a></li>
    </ul>
  </div>
  </div>
</div>

<script>
  function deleteuserfun(btn){
    var user_btn_id = $(btn).attr("data-userid");
    $("#deletebtn_"+user_btn_id).click();
  }
</script>

@include('layouts.footer')