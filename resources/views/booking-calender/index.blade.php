<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Details</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link href="{{ asset('assets\booking-calender\style.css') }}" rel="stylesheet" />
</head>

<body>
    <main>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <form id="booking_calender_filter_form" action="{{ route('booking.calender') }}">
                        <div class="header my-3">
                            <div class="row">
                                <div class="col-12 col-md-7 status-filter-button">
                                    <a type="button" href="{{ route('dashboard') }}"
                                        class="btn btn-danger px-md-4 m-1 rounded-0 border border-dark text-uppercase"><i
                                            class="bi bi-back"></i> Back</a>

                                    <button type="button"
                                        class="btn bg-checked-in px-md-4 m-1 rounded-0 border border-dark text-uppercase">Checked
                                        In</button>
                                    <button type="button"
                                        class="btn bg-booked px-md-4 m-1 rounded-0 text-uppercase">Booked</button>
                                    <button type="button"
                                        class="btn px-md-4 m-1 rounded-0 border border-info text-uppercase">Available</button>
                                    <button type="button"
                                        class="btn btn-dark px-md-4 m-1 rounded-0 border border-dark text-uppercase">Booking
                                        Closed</button>
                                    <button type="button"
                                        class="btn bg-venue-closed px-md-4 m-1 rounded-0 text-uppercase">Venue
                                        Closed</button>
                                    <select class="form-select" name="year"
                                        style="padding: 7px 20px; margin: 10px 5px" onchange="yearChange()">
                                        @for ($i = $year - 10; $i < $year + 10; $i++)
                                            <option value="{{ $i }}" {{ $year == $i ? 'selected' : '' }}>
                                                {{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-12 col-md-5">
                                    <div class="text-right search-booking">
                                        <input id="search" name="search" type="text"
                                            placeholder="Search By Booking No" value="{{ $search }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tabs-months">
                            <div class="tab-list">
                                <div class="tabs d-flex align-items-center">
                                    @foreach ($months as $month)
                                        <div class="tab-item @if ($selectedMonth == $month['value']) active @endif"
                                            onclick="formFilter({{ $month['value'] }}, 'month_input_feild')">
                                            <p>{{ $month['lable'] }} {{ $year }}</p>
                                        </div>
                                    @endforeach
                                    <input id="month_input_feild" hidden name="month" value="{{ $selectedMonth }}" />
                                    {{-- <input hidden name="year" value="{{ $year }}" /> --}}
                                </div>
                            </div>
                        </div>
                        <div class="tabs-date my-2">

                            <div class="tabs d-flex align-items-center">
                                @for ($day = 1; $day <= $daysInMonth; $day++)
                                    <div class="tab-item @if ($selectedDate == $day) active @endif"
                                        onclick="formFilter({{ $day }}, 'day_input_feild')">
                                        <p>
                                            {{ $day }}
                                        </p>
                                    </div>
                                @endfor
                                <input id="day_input_feild" hidden name="day" value="{{ $selectedDate }}" />
                            </div>
                        </div>
                    </form>

                    <div class="table-of-content d-flex">
                        <div class="court-list">
                            <ul>
                                @foreach ($venues as $venue)
                                    <li><span class="court bg-dark text-white text-center">{{ $venue->name }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div id="slot_content_table" class="table-view flex-grow-1">
                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                        @foreach ($timeSlots as $slot)
                                            <td class="border border-dark text-center">
                                                <p>{{ $slot }}</p>
                                            </td>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($bookings as $booking)
                                        <tr>
                                            @foreach ($booking as $slot)
                                                @if ($slot['status'] == 1)
                                                    <td class="border text-right"
                                                        onclick="slotDetailsModal({{ json_encode($slot) }})">
                                                        <span class="status">Available</span>
                                                    </td>
                                                @elseif ($slot['status'] == 2)
                                                    <td class="border text-right {{ !empty($search) && $search == $slot['bookingNo'] ? 'bg-search' : 'bg-booked' }}"
                                                        onclick="slotDetailsModal({{ json_encode($slot) }})">
                                                        <span class="status">Booked</span>
                                                    </td>
                                                @elseif ($slot['status'] == 3)
                                                    <td class="border text-right {{ !empty($search) && $search == $slot['bookingNo'] ? 'bg-search' : 'bg-checked-in' }}"
                                                        onclick="slotDetailsModal({{ json_encode($slot) }})">
                                                        <span class="status">Checked In</span>
                                                    </td>
                                                @elseif ($slot['status'] == 5)
                                                    <td class="border text-right bg-venue-closed">
                                                        <span class="status">Venue Closed</span>
                                                    </td>
                                                @else
                                                    <td class="border text-right {{ !empty($search) && $search == $slot['bookingNo'] ? 'bg-search' : 'bg-booking-closed' }}"
                                                        onclick="slotDetailsModal({{ json_encode($slot) }})">
                                                        <span class="status">Booking Closed</span>
                                                    </td>
                                                @endif
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="table-scroll-buttons">
                                <button id="slot_scroll_btn_left" class="left border-0">
                                    <i class="bi bi-chevron-double-left"></i>
                                </button>
                                <button id="slot_scroll_btn_right" class="right border-0">
                                    <i class="bi bi-chevron-double-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal custom-modal" id="exampleModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body p-0">
                        <div class="booking-info d-flex">
                            <div class="info p-3">
                                <p>Sports Venue : <span id="sports_venue">{{ $vendorInfo->businessname }}</span></p>
                                <p>Checkin Time : <span id="check_in_time">10AM - 11PM</span></p>
                                <p>Date : <span id="check_in_date">3.5.2023</span></p>
                                <p>Status : <span id="check_in_status">Not Check-IN</span></p>
                                <p>Court : <span id="court_name">Court 1</span></p>
                                <p>Payment : <span id="payment_text">Online / Done</span></p>
                                <p>Booking N: <span id="booking_no_text">1241341112</span> </p>
                            </div>
                            <div class="actions text-right flex-grow-1">
                                <button class="bg-dark" data-dismiss="modal" aria-label="Close">
                                    <i class="bi bi-x"></i>
                                </button>
                                <div class="status">
                                    <p>Remaining Time : <span id="remaining_time">0</span></p>
                                </div>
                                <div class="lights mt-3">
                                    <div class="">
                                        <img src="{{ asset('assets\booking-calender\light-bulb1.png') }}"
                                            alt="light-bulb" class="img-fluid">
                                    </div>
                                    <div>
                                        <img src="{{ asset('assets\booking-calender\light-bulb2.png') }}"
                                            alt="light-bulb" class="img-fluid">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="check-option d-flex justify-content-between p-3">
                            <div class="checkbox d-flex align-items-center">
                                <p>Checkin</p>
                                <label class="switch mb-0">
                                    <input type="checkbox" checked>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                            <div class="checkbox d-flex align-items-center">
                                <p>lights</p>
                                <label class="switch mb-0">
                                    <input type="checkbox" checked>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
        integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"
        integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous">
    </script>
    <script type="text/javascript">
        function formFilter(event, el) {
            let element = document.getElementById(el);
            element.value = event;
            document.getElementById("booking_calender_filter_form").submit();
        }

        function reamingTime(dt2, dt1) {

            const now = new Date().getTime();
            const futureDate = new Date(dt2).getTime();

            const timeleft = futureDate - now;

            const days = Math.floor(timeleft / (1000 * 60 * 60 * 24));
            const hours = Math.floor((timeleft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((timeleft % (1000 * 60 * 60)) / (1000 * 60));

            // return days + ' days ' + hours + ' hours ' + minutes + ' mins ';
            return `${days > 0 ? days+'d ': ''}${hours > 0 ? hours+'h ' : ''}${minutes > 0 ? minutes+' mins' : ''}`

        }


        function slotDetailsModal(details) {
            $("#booking_no_text").text(details.bookingNo);
            $("#court_name").text(details.court);
            $("#check_in_date").text(details.date);
            $("#check_in_time").text(details.name);

            let status = details.checkInStatus ? 'Check-IN' : 'Not Check-IN';
            $("#check_in_status").text(status);

            let paymentText =
                `${details.payMethod == 1 ? 'Online' : 'Counter'} / ${details.payStatus == 'Y' ? 'Done' : 'Not Done'}`;
            if (details.status == 1) {
                paymentText = null;
            }
            $("#payment_text").text(paymentText);

            let now = new Date(),
                endTime = new Date(details.endTime),
                timeDiff = 0;

            if (details.status == 3) {
                timeDiff = reamingTime(endTime, now);
            }

            $("#remaining_time").text(timeDiff);

            $('#exampleModal').modal('show');
        }

        $(function() {
            $('#search').keypress(function(event) {
                let keycode = (event.keyCode ? event.keyCode : event.which);
                if (keycode == '13') {
                    document.getElementById("booking_calender_filter_form").submit();
                }
                event.stopPropagation();
            });

        })

        let button = document.getElementById('slot_scroll_btn_right');
        button.onclick = function() {
            let container = document.getElementById('slot_content_table');
            sideScroll(container, 'right', 25, 100, 10);
        };

        let back = document.getElementById('slot_scroll_btn_left');
        back.onclick = function() {
            let container = document.getElementById('slot_content_table');
            sideScroll(container, 'left', 25, 100, 10);
        };

        function sideScroll(element, direction, speed, distance, step) {
            scrollAmount = 0;
            let slideTimer = setInterval(function() {
                if (direction == 'left') {
                    element.scrollLeft -= step;
                } else {
                    element.scrollLeft += step;
                }
                scrollAmount += step;
                if (scrollAmount >= distance) {
                    window.clearInterval(slideTimer);
                }
            }, speed);
        }

        function yearChange() {
            document.getElementById("booking_calender_filter_form").submit();
        }

        function refresh() {
            window.setTimeout(function() {
                window.location.reload();
            }, 15000);
        }
        refresh();
    </script>
</body>

</html>
