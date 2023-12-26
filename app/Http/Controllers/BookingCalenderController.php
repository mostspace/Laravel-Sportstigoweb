<?php

namespace App\Http\Controllers;

use App\Models\vendordetails;
use App\Models\venues;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class BookingCalenderController extends Controller
{
    private $months = [
        [
            'value' => '01',
            'lable' => 'Jan',
        ],
        [
            'value' => '02',
            'lable' => 'Feb',
        ],
        [
            'value' => '03',
            'lable' => 'Mar',
        ],
        [
            'value' => '04',
            'lable' => 'Apr',
        ],
        [
            'value' => '05',
            'lable' => 'May',
        ],
        [
            'value' => '06',
            'lable' => 'Jun',
        ],
        [
            'value' => '07',
            'lable' => 'Jul',
        ],
        [
            'value' => '08',
            'lable' => 'Aug',
        ],
        [
            'value' => '09',
            'lable' => 'Sept',
        ],
        [
            'value' => '10',
            'lable' => 'Oct',
        ],
        [
            'value' => '11',
            'lable' => 'Nov',
        ],
        [
            'value' => '12',
            'lable' => 'Dec',
        ],
    ];

    public function index()
    {

        $getsessioinid = Session::get('getsessionuserid');
        $getsessionrole = Session::get('getsessionrole');
        $getsessionusertype = Session::get('getsessionusertype');
        $getSessionUserCreatedBy = Session::get('getsessioncreatedby');

        //For Staff Role Created By Vendor
        if($getsessionrole == 6 && $getsessionusertype == "Vendor") {
            $getsessioinid = $getSessionUserCreatedBy;
        }

        if (($getsessioinid && $getsessionrole == 3) || ($getsessioinid && $getsessionrole == 6 && $getsessionusertype == "Vendor")) {
            $venues = DB::table('venues')->where('vendor_id', $getsessioinid)->get();
            $vendorInfo = DB::table('vendors')->where('vendor_id', $getsessioinid)->first();
            $vendorDetails = (array) DB::table('vendordetails')->where('vendor_id', $getsessioinid)->first();

            $year = request('year', Carbon::now()->format('Y'));
            $selectedMonth = request('month', Carbon::now()->format('m'));
            $selectedDate = request('day', Carbon::now()->format('d'));
            $search = request('search', null);

            $months = $this->months;
            $filterDate = "$year-$selectedMonth-$selectedDate";

            $currentDate = Carbon::parse($filterDate);
            $currentday = $currentDate->format('l');
            $now = Carbon::now();

            $daysInMonth = $currentDate->daysInMonth;

            $currentdayStartTime = strtolower($currentday) . 'stime';
            $currentdayEndTime = strtolower($currentday) . 'etime';
            $timeSlots = [];

            $isClosingDay = false;
            $closingDay = DB::table('vendorclosingdays')
                ->where('vendor_id', $getsessioinid)
                ->whereDate('closingdays', $currentDate)
                ->first();
            if (!empty($closingDay)) {
                $isClosingDay = true;
            }

            if (!empty($vendorDetails)) {
                $timeSlots = $this->getTimeSlots($vendorDetails[$currentdayStartTime], $vendorDetails[$currentdayEndTime]);
            }
            $bookings = [];
            if (!empty($venues)) {
                foreach ($venues as $key => $venue) {
                    $allSlot = [];

                    if (!empty($timeSlots)) {

                        $bookSlots = DB::table('booking_with_vendorsdetails')
                            ->leftJoin('booking_with_vendors', 'booking_with_vendors.bookingno', 'booking_with_vendorsdetails.bookingno')
                            ->where('booking_with_vendorsdetails.vendor_id', $getsessioinid)
                            ->where('booking_with_vendorsdetails.days', $currentday)
                            ->where('booking_with_vendorsdetails.courtid', $venue->id)
                            ->whereDate('booking_with_vendorsdetails.date', $currentDate)
                            ->select('booking_with_vendorsdetails.*', 'booking_with_vendors.paystatus as payStatus', 'booking_with_vendors.paymethod as payMethod')
                            ->get();


                        foreach ($timeSlots as $slot) {

                            $slots = explode("-", $slot);
                            $stime = strtotime($slots[0]);
                            $etime = strtotime($slots[1]);
                            $first = array();

                            if (!empty($bookSlots)) {
                                foreach ($bookSlots as $value) {
                                    if (strtotime($value->stime) == $stime) {
                                        $first = (array) $value;
                                        break;
                                    }
                                }
                            }
                            $eDateTimeStr = $filterDate . $slots[1];
                            $eDateTime = Carbon::parse($eDateTimeStr);

                            $single = [
                                'name' => $slot,
                                'status' => 1,
                                'bookingNo' => null,
                                'checkInStatus' => 0,
                                'court' => $venue->name,
                                'date' => $filterDate,
                                'payStatus' => null,
                                'payMethod' => null,
                                'endTime' => $eDateTime,
                            ];
                            if (!empty($first)) {
                                $single['bookingNo'] = $first['bookingno'];
                                $single['checkInStatus'] = $first['checkinstatus'];
                                $single['payMethod'] = $first['payMethod'];
                                $single['payStatus'] = $first['payStatus'];

                                if ($first['checkinstatus'] == 0) {
                                    $single['status'] = 2;
                                } elseif ($first['checkinstatus'] == 1) {
                                    $single['status'] = 3;
                                }
                            }

                            if ($now->gt($eDateTime)) {
                                $single['status'] = 4;
                            }

                            if ($isClosingDay) {
                                $single['status'] = 5;
                            }

                            $allSlot[] = $single;
                        }
                    }
                    $bookings[$venue->name] = $allSlot;
                };
            }

            return view(
                'booking-calender.index',
                compact(
                    'venues',
                    'vendorInfo',
                    'timeSlots',
                    'bookings',
                    'daysInMonth',
                    'selectedDate',
                    'months',
                    'selectedMonth',
                    'year',
                    'search'
                )
            );
        }

        return redirect('/login');
    }

    public function getTimeSlots($start, $end)
    {
        $start = Carbon::parse($start);
        $end = Carbon::parse($end);
        $data = [];
        for ($d = $start; $d < $end; $d->addHour()) {
            $addOne = Carbon::parse($d->toDateTimeString());
            $data[] = $d->format('h.iA')  . " - " . $addOne->addHour()->format('h.iA');
        };
        return $data;
    }
}
