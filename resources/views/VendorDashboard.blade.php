@include('layouts.head')

<body>
    <?php $pageheading = 'Vendor Dashboard'; ?>
    <div class="dash wrapper">

        @include('layouts.header')

        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif


        <div class="dash wrapper">

            <div class="custom-border">
            </div>


            <div class="main-section pt-4 pb-4">
                <div class="container-fluid">

                    <div class="row d-flex">

                        <div class="col-lg-9">

                            <div class="row d-flex align-items-center justify-content-center">
                                <div class="col-lg-3 col-md-3 col-12">
                                    <a href="{{ route('editvendorprofile', Session::get('getsessionuserid')) }}">
                                        <div class="black-box">
                                            <div><span class="main-text">PROFILE</span></div>
                                            <div><span class="sub-text">Manage Business</span></div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-lg-3 col-md-3 col-12">
                                    <a href="{{ route('vendorstaff') }}">
                                        <div class="black-box">
                                            <div><span class="main-text">Staff</span></div>
                                            <div><span class="sub-text">Manage Staff Access</span></div>

                                        </div>
                                    </a>
                                </div>
                                <div class="col-lg-3 col-md-3 col-12">
                                    <a href="{{ route('userslist') }}">
                                        <div class="black-box">
                                            <div><span class="main-text">Users </span></div>
                                            <div><span class="sub-text">Manage Customers</span></div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-lg-3 col-md-3 col-12">
                                    <a href="{{ route('voucher.index') }}">
                                        <div class="black-box">
                                            <div><span class="main-text">Voucher </span></div>
                                            <div><span class="sub-text">Create Promo Voucher</span></div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="custom-border mt-4 mb-4"></div>
                            <div class="row d-flex align-items-center justify-content-center">
                                
                                <!--<div class="col-md-3">
                                <a href="{{ route('sportslotcreate') }}">
                                        <div class="black-box">
                                        <div><span class="main-text">Slots Price </span></div>
                                        <div><span class="sub-text">Manage Slot price</span></div>
                                        </div></a>
                                </div>!-->
                                <div class="col-lg-3 col-md-3 col-12">
                                    <!--<a href="{{ route('vendorwithdrawallist') }}">!-->
                                    <a href="{{ route('vendoraddwithdrawal') }}">
                                        <div class="black-box">
                                            <div><span class="main-text">WITHDRAWAL </span></div>
                                            <div><span class="sub-text">Request Withdrawal</span></div>

                                        </div>
                                    </a>
                                </div>
                                <div class="col-lg-3 col-md-3 col-12">
                                    <a href="{{ route('membershipcreate') }}">
                                        <div class="black-box">
                                            <div><span class="main-text">Packages</span></div>
                                            <div><span class="sub-text">Manage Sport Packages</span></div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-lg-3 col-md-3 col-12">
                                    <a href="{{ route('noticboard') }}">
                                        <div class="black-box">
                                            <div><span class="main-text">Message</span></div>
                                            <div><span class="sub-text">Contact Support Team</span></div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-lg-3 col-md-3 col-12">
                                    <a href="{{ route('venuecreate') }}">
                                        <div class="black-box">
                                            <div><span class="main-text">Venue</span></div>
                                            <div><span class="sub-text">Manage Sport Venue</span></div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="custom-border mt-4 mb-4"></div>
                            <div class="row d-flex align-items-center justify-content-center">
                             
                                <div class="col-lg-3 col-md-3 col-12">
                                    <a href="{{ route('vendorreport') }}">
                                        <div class="black-box">
                                            <div><span class="main-text">Manage Sales </span></div>
                                            <div><span class="sub-text">Sales Management</span></div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-lg-3 col-md-3 col-12">
                                    <a href="{{ url('/booking-calender') }}">
                                        <div class="black-box">
                                            <div><span class="main-text">Booking Calendar </span></div>
                                            <div><span class="sub-text">Booking Records</span></div>
                                        </div>
                                    </a>
                                </div>
                                <!--New Code Addedd!-->
                                <div class="col-lg-3 col-md-3 col-12">
                                    <a href="{{ url('/add-products') }}">
                                        <div class="black-box">
                                            <div><span class="main-text">Add Products </span></div>
                                            <div><span class="sub-text">Manage Products</span></div>
                                        </div>
                                    </a>
                                </div>
                                <!--End New Code Addedd!-->

                                <div class="col-lg-3 col-md-3 col-12">
                                    <!--<a href="{{ route('bookingsales') }}">!-->
                                    <a href="{{ route('checkinsales') }}">
                                        <div class="black-box">
                                            <div><span class="main-text text-green">CHECK-IN & POS</span></div>
                                            <div><span class="sub-text">Check In Customer & POS </span></div>
                                        </div>
                                    </a>
                                </div>

                            </div>

                            <div class="custom-border mt-4 mb-4"></div>
                            <div class="row d-flex align-items-center justify-content-center">
                              
                                <div class="col-lg-3 col-md-3 col-12">
                                    <div class="black-box">
                                        <div><span class="main-text text-red"> <a class="main-text text-red"
                                                    href="#"
                                                    onclick="document.getElementById('logout-form').submit();">LoGOUT</a>
                                            </span></div>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                            style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                        <div><span class="sub-text">Log out from System</span></div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="col-lg-3">
                            <div class="light-green-box text-center">
                                @if (isset($bookingdtls))
                                    @if (count($bookingdtls) > 0)
                                        <input type="hidden" id="cart_count" name="cart_count"
                                            value="{{ count($bookingdtls) }}" size="2">
                                    @else
                                        <input type="hidden" id="cart_count" name="cart_count" value="0"
                                            size="2">
                                    @endif
                                @endif

                                <span class="light-green-title">Latest Booking Notification</span>
                                <div id="latestbooking" style="overflow:auto; height:230px;">

                                    <table class="vendor table table-striped" border="0">
                                        <thead>
                                            <tr>
                                                <th scope="col">Date</th>
                                                <th scope="col">Time</th>
                                                <th scope="col">User</th>
                                                <th scope="col">Mobile</th>
                                                <th scope="col">Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @if (isset($bookingdtls))
                                                @if (count($bookingdtls) > 0)
                                                    @foreach ($bookingdtls as $bdtls)
                                                        <tr>

                                                            <td>{{ \Carbon\Carbon::parse($bdtls->date)->format('d.m.Y') }}
                                                            </td>
                                                            <td>{{ \Carbon\Carbon::parse($bdtls->created_at)->format('h.i a') }}
                                                            </td>
                                                            <td>{{ $bdtls->username }}</td>
                                                            <td>{{ $bdtls->mobileno }}</td>
                                                            <td>RM {{ $bdtls->amount }}</td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            @endif



                                        </tbody>
                                    </table>


                                </div>
                            </div>
                            <div class="light-green-box text-center">
                                <span class="light-green-title">Latest Checkin Records</span>
                                <div id="latestcheckin" style="overflow:auto; height:230px;">
                                    <table class="vendor table table-striped" border="0">
                                        <thead>
                                            <tr>
                                                <th scope="col">Date</th>
                                                <th scope="col">Check-In Time</th>
                                                <th scope="col">Game Time</th>
                                                <th scope="col">Mobile</th>
                                                <th scope="col">Desc</th>
                                            </tr>
                                        </thead>
                                        <tbody>


                                            @if (isset($bookingcheckdetails))
                                                @if (count($bookingcheckdetails) > 0)
                                                    @foreach ($bookingcheckdetails as $bdtls)
                                                        <tr>
                                                            <td>{{ \Carbon\Carbon::parse($bdtls->date)->format('d.m.Y') }}
                                                            </td>
                                                            <td>{{ \Carbon\Carbon::parse($bdtls->created_at)->format('h.i a') }}
                                                            </td>
                                                            <td>{{ \Carbon\Carbon::parse($bdtls->stime)->format('h.i a') }}
                                                            </td>
                                                            <td>{{ $bdtls->mobileno }}</td>
                                                            <td>{{ $bdtls->courtname }}</td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            @endif

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>

            <!-- <div class="right-sidebar">
    <div class="light-green-box text-center">
    @if (isset($bookingdtls))
@if (count($bookingdtls) > 0)
<input type="hidden" id="cart_count" name="cart_count" value="{{ count($bookingdtls) }}" size="2">
@else
<input type="hidden" id="cart_count" name="cart_count" value="0" size="2">
@endif
@endif

      <span class="light-green-title">Latest Booking Notification</span>





      <div id="latestbooking" style="overflow:auto; height:250px;">

     <table class="vendor table table-striped" border="0" >
        <thead>
          <tr>
            <th scope="col">DATE</th>
            <th scope="col">TIME</th>
            <th scope="col">USER</th>
            <th scope="col">MOBILENO</th>
            <th scope="col">TOTAL</th>
          </tr>
        </thead>
        <tbody>

        @if (isset($bookingdtls))
        @if (count($bookingdtls) > 0)
@foreach ($bookingdtls as $bdtls)
<tr>

   <td>{{ \Carbon\Carbon::parse($bdtls->date)->format('d.m.Y') }}</td>
    <td>{{ \Carbon\Carbon::parse($bdtls->created_at)->format('h.i a') }}</td>
        <td>{{ $bdtls->username }}</td>
        <td>{{ $bdtls->mobileno }}</td>
    <td>RM {{ $bdtls->amount }}</td>
    </tr>
@endforeach
@endif
        @endif



        </tbody>
      </table>


    </div>
    </div>
    <div class="light-green-box text-center">
      <span class="light-green-title">Latest Checkin Records</span>
 <div id="latestcheckin" style="overflow:auto; height:250px;">
      <table class="vendor table table-striped" border="0">
        <thead>
          <tr>
            <th scope="col">DATE</th>
            <th scope="col">CHECKIN TIME</th>
            <th scope="col">SLOT TIME</th>
            <th scope="col">MOBILENO</th>
            <th scope="col">DESC</th>
          </tr>
        </thead>
        <tbody>


        @if (isset($bookingcheckdetails))
   @if (count($bookingcheckdetails) > 0)
@foreach ($bookingcheckdetails as $bdtls)
<tr>
        <td>{{ \Carbon\Carbon::parse($bdtls->date)->format('d.m.Y') }}</td>
    <td>{{ \Carbon\Carbon::parse($bdtls->created_at)->format('h.i a') }}</td>
    <td>{{ \Carbon\Carbon::parse($bdtls->stime)->format('h.i a') }}</td>
        <td>{{ $bdtls->mobileno }}</td>
    <td>{{ $bdtls->courtname }}</td>
    </tr>
@endforeach
@endif
        @endif

        </tbody>
      </table></div>
    </div>
  </div> -->

        </div>


        <script>
            function OrderCountFunction() {
                const url = window.location.href;
                const lastSegment = url.substring(url.lastIndexOf("/") + 1);

                var surl = "";
                //var surl =   'https://mrinvito.com/laravel/sportstigo/';
                var surl = 'https://sportstigo.com/sportstigo/';
                //var surl =  "http://127.0.0.1:8000/";
                var existing_count = document.getElementById('cart_count').value;
                $("#latestbooking").html('');
                $("#latestcheckin").html('');


                $.ajax({
                    url: surl + 'get_order_counts/{id}',
                    type: "GET",
                    data: {
                        id: 1
                    },
                    contentType: 'application/json',
                    dataType: 'json',
                    error: function(request, error) {

                    },
                    success: function(data) {

                        var get_count_from_program = data[0];
                        $("#latestbooking").append(data[1]);
                        $("#latestcheckin").append(data[2]);

                        console.log("get_count_from_program==: ");
                        console.log(get_count_from_program);

                        if (parseInt(existing_count) < parseInt(get_count_from_program)) {
                            //var file = 'https://mrinvito.com/laravel/sportstigo/assets/FoodOrderZomatoOrder.mp3';
                            var file = 'https://sportstigo.com/sportstigo/assets/FoodOrderZomatoOrder.mp3';
                            //var file = 'http://127.0.0.1:8000/assets/FoodOrderZomatoOrder.mp3';
                            let audioTrack = new Audio(file);
                            audioTrack.preload = 'auto';
                            audioTrack.onloadeddata = function() {
                                console.log("audio: " + file + " has successfully loaded.");
                            };
                            audioTrack.play();
                            clearInterval(interval);
                            setInterval(function() {
                                location.reload();
                            }, 6000);

                        } else {

                        }
                    }
                });
            }
            var interval = setInterval(function() {
                OrderCountFunction();
            }, 5000); // 60*1000 60 second
        </script>


        @include('layouts.footer')
